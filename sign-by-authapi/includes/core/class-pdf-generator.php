<?php
/**
 * PDF Generator
 *
 * Generates professional PDFs from form data with custom branding.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_PDF_Generator class
 *
 * @since 1.0.0
 */
class Sign_PDF_Generator {

	/**
	 * Generate customer data PDF.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id      Post ID of the signing request.
	 * @param int $business_id Business ID for branding.
	 * @return string|WP_Error Path to generated PDF or error.
	 */
	public function generate_customer_data_pdf( $cpt_id, $business_id ) {
		// Step 1: Load data.
		$cpt_data = $this->load_cpt_data( $cpt_id );
		if ( is_wp_error( $cpt_data ) ) {
			return $cpt_data;
		}

		$branding = $this->load_branding( $business_id );
		if ( is_wp_error( $branding ) ) {
			return $branding;
		}

		// Step 2: Check for custom letterhead.
		if ( ! empty( $branding['letterhead_path'] ) && file_exists( $branding['letterhead_path'] ) ) {
			return $this->generate_with_custom_letterhead( $cpt_data, $branding, $cpt_id );
		} else {
			return $this->generate_with_default_letterhead( $cpt_data, $branding, $cpt_id );
		}
	}

	/**
	 * Load CPT data.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return array|WP_Error CPT data or error.
	 */
	private function load_cpt_data( $cpt_id ) {
		$post = get_post( $cpt_id );

		if ( ! $post || 'sign_request' !== $post->post_type ) {
			return new WP_Error( 'invalid_post', 'Invalid signing request ID' );
		}

		$meta = get_post_meta( $cpt_id );

		// Extract standard fields.
		$data = array(
			'cpt_id'     => $cpt_id,
			'first_name' => get_post_meta( $cpt_id, 'esign_first_name', true ),
			'last_name'  => get_post_meta( $cpt_id, 'esign_last_name', true ),
			'email'      => get_post_meta( $cpt_id, 'esign_email', true ),
			'phone'      => get_post_meta( $cpt_id, 'esign_phone', true ),
			'address'    => $this->format_address( $cpt_id ),
		);

		// Extract custom fields (anything not starting with esign_ or _).
		$custom_fields = array();
		foreach ( $meta as $key => $value ) {
			if ( strpos( $key, 'esign_' ) !== 0 && strpos( $key, '_' ) !== 0 ) {
				$custom_fields[ $key ] = is_array( $value ) && count( $value ) === 1 ? $value[0] : $value;
			}
		}

		$data['custom_fields'] = $custom_fields;

		return $data;
	}

	/**
	 * Format address from CPT meta.
	 *
	 * @since 1.0.0
	 *
	 * @param int $cpt_id Post ID.
	 * @return string Formatted address.
	 */
	private function format_address( $cpt_id ) {
		$address_parts = array();

		$line1 = get_post_meta( $cpt_id, 'esign_address_line1', true );
		$line2 = get_post_meta( $cpt_id, 'esign_address_line2', true );
		$city  = get_post_meta( $cpt_id, 'esign_city', true );
		$state = get_post_meta( $cpt_id, 'esign_state', true );
		$zip   = get_post_meta( $cpt_id, 'esign_zip', true );

		if ( $line1 ) {
			$address_parts[] = $line1;
		}
		if ( $line2 ) {
			$address_parts[] = $line2;
		}
		if ( $city || $state || $zip ) {
			$city_state_zip = trim( implode( ' ', array_filter( array( $city, $state, $zip ) ) ) );
			if ( $city_state_zip ) {
				$address_parts[] = $city_state_zip;
			}
		}

		return implode( "\n", $address_parts );
	}

	/**
	 * Load branding settings.
	 *
	 * @since 1.0.0
	 *
	 * @param int $business_id Business ID.
	 * @return array|WP_Error Branding data or error.
	 */
	private function load_branding( $business_id ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_businesses';

		$branding = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE id = %d",
				$business_id
			),
			ARRAY_A
		);

		if ( ! $branding ) {
			return new WP_Error( 'invalid_business', 'Business not found' );
		}

		return $branding;
	}

	/**
	 * Generate PDF with custom letterhead.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data      CPT data.
	 * @param array $branding  Branding settings.
	 * @param int   $cpt_id    CPT ID.
	 * @return string|WP_Error Path to generated PDF or error.
	 */
	private function generate_with_custom_letterhead( $data, $branding, $cpt_id ) {
		// Check if FPDI is available.
		if ( ! class_exists( '\setasign\Fpdi\Fpdi' ) ) {
			return new WP_Error( 'missing_library', 'FPDI library not found. Please run composer install.' );
		}

		try {
			$pdf = new \setasign\Fpdi\Fpdi();

			// Import letterhead PDF as first page.
			$letterhead_path = $branding['letterhead_path'];
			$page_count      = $pdf->setSourceFile( $letterhead_path );

			// Use first page of letterhead as template.
			$pdf->AddPage();
			$template = $pdf->importPage( 1 );
			$pdf->useTemplate( $template );

			// Now overlay customer data on top.
			$pdf->SetFont( 'Arial', '', 12 );
			$pdf->SetXY( 20, 80 ); // Position below letterhead.

			// Add customer info.
			$pdf->SetFont( 'Arial', 'B', 14 );
			$pdf->Write( 0, 'CUSTOMER INFORMATION' );
			$pdf->Ln( 10 );

			$pdf->SetFont( 'Arial', '', 12 );
			$pdf->Write( 0, 'Name: ' . $data['first_name'] . ' ' . $data['last_name'] );
			$pdf->Ln( 7 );
			$pdf->Write( 0, 'Email: ' . $data['email'] );
			$pdf->Ln( 7 );
			if ( ! empty( $data['phone'] ) ) {
				$pdf->Write( 0, 'Phone: ' . $data['phone'] );
				$pdf->Ln( 7 );
			}
			if ( ! empty( $data['address'] ) ) {
				$pdf->Write( 0, 'Address: ' . str_replace( "\n", ', ', $data['address'] ) );
				$pdf->Ln( 7 );
			}

			// Add custom fields.
			if ( ! empty( $data['custom_fields'] ) ) {
				$pdf->Ln( 10 );
				$pdf->SetFont( 'Arial', 'B', 14 );
				$pdf->Write( 0, 'INTAKE QUESTIONNAIRE' );
				$pdf->Ln( 10 );

				$pdf->SetFont( 'Arial', '', 12 );
				foreach ( $data['custom_fields'] as $key => $value ) {
					$label = $this->format_field_label( $key );

					// Check if we need a new page.
					if ( $pdf->GetY() > 250 ) {
						$pdf->AddPage();
						$pdf->SetXY( 20, 20 );
					}

					$pdf->Write( 0, $label . ': ' . $value );
					$pdf->Ln( 7 );
				}
			}

			// Save to temp directory.
			$filepath = $this->get_temp_filepath( 'customer-data-' . $cpt_id );
			$pdf->Output( 'F', $filepath );

			return $filepath;

		} catch ( Exception $e ) {
			return new WP_Error( 'pdf_generation_failed', $e->getMessage() );
		}
	}

	/**
	 * Generate PDF with default letterhead (from logo/colors).
	 *
	 * @since 1.0.0
	 *
	 * @param array $data      CPT data.
	 * @param array $branding  Branding settings.
	 * @param int   $cpt_id    CPT ID.
	 * @return string|WP_Error Path to generated PDF or error.
	 */
	private function generate_with_default_letterhead( $data, $branding, $cpt_id ) {
		// Check if mPDF is available.
		if ( ! class_exists( '\Mpdf\Mpdf' ) ) {
			return new WP_Error( 'missing_library', 'mPDF library not found. Please run composer install.' );
		}

		try {
			$mpdf = new \Mpdf\Mpdf(
				array(
					'format'        => 'Letter',
					'margin_top'    => 40,
					'margin_bottom' => 20,
					'margin_left'   => 20,
					'margin_right'  => 20,
				)
			);

			// Build HTML template.
			$html = $this->build_html_template( $data, $branding );

			// Write HTML to PDF.
			$mpdf->WriteHTML( $html );

			// Save to temp directory.
			$filepath = $this->get_temp_filepath( 'customer-data-' . $cpt_id );
			$mpdf->Output( $filepath, 'F' );

			return $filepath;

		} catch ( Exception $e ) {
			return new WP_Error( 'pdf_generation_failed', $e->getMessage() );
		}
	}

	/**
	 * Build HTML template for PDF.
	 *
	 * @since 1.0.0
	 *
	 * @param array $data     CPT data.
	 * @param array $branding Branding settings.
	 * @return string HTML content.
	 */
	private function build_html_template( $data, $branding ) {
		$primary_color = ! empty( $branding['primary_color'] ) ? $branding['primary_color'] : '#007bff';
		$company_name  = ! empty( $branding['company_name'] ) ? $branding['company_name'] : get_bloginfo( 'name' );
		$logo_url      = ! empty( $branding['logo_url'] ) ? $branding['logo_url'] : '';

		ob_start();
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<style>
				body {
					font-family: Arial, sans-serif;
					color: #333;
				}
				.header {
					text-align: center;
					padding: 20px 0;
					border-bottom: 3px solid <?php echo esc_attr( $primary_color ); ?>;
					margin-bottom: 30px;
				}
				.logo {
					max-width: 200px;
					margin-bottom: 10px;
				}
				.company-name {
					font-size: 24px;
					font-weight: bold;
					color: <?php echo esc_attr( $primary_color ); ?>;
				}
				.section {
					margin: 30px 0;
				}
				.section-title {
					font-size: 18px;
					font-weight: bold;
					color: <?php echo esc_attr( $primary_color ); ?>;
					margin-bottom: 15px;
					text-transform: uppercase;
				}
				.field {
					margin: 10px 0;
					padding: 8px 0;
				}
				.field-label {
					font-weight: bold;
					display: inline-block;
					width: 150px;
				}
				.field-value {
					display: inline-block;
				}
			</style>
		</head>
		<body>
			<!-- Header with logo -->
			<div class="header">
				<?php if ( $logo_url ) : ?>
					<img src="<?php echo esc_url( $logo_url ); ?>" class="logo" alt="Company Logo">
				<?php endif; ?>
				<div class="company-name"><?php echo esc_html( $company_name ); ?></div>
			</div>

			<!-- Customer Information -->
			<div class="section">
				<div class="section-title">Customer Information</div>
				<div class="field">
					<span class="field-label">Name:</span>
					<span class="field-value">
						<?php echo esc_html( $data['first_name'] . ' ' . $data['last_name'] ); ?>
					</span>
				</div>
				<div class="field">
					<span class="field-label">Email:</span>
					<span class="field-value"><?php echo esc_html( $data['email'] ); ?></span>
				</div>
				<?php if ( ! empty( $data['phone'] ) ) : ?>
				<div class="field">
					<span class="field-label">Phone:</span>
					<span class="field-value"><?php echo esc_html( $data['phone'] ); ?></span>
				</div>
				<?php endif; ?>
				<?php if ( ! empty( $data['address'] ) ) : ?>
				<div class="field">
					<span class="field-label">Address:</span>
					<span class="field-value"><?php echo nl2br( esc_html( $data['address'] ) ); ?></span>
				</div>
				<?php endif; ?>
			</div>

			<!-- Custom Fields -->
			<?php if ( ! empty( $data['custom_fields'] ) ) : ?>
			<div class="section">
				<div class="section-title">Intake Questionnaire</div>
				<?php foreach ( $data['custom_fields'] as $key => $value ) : ?>
				<div class="field">
					<span class="field-label">
						<?php echo esc_html( $this->format_field_label( $key ) ); ?>:
					</span>
					<span class="field-value"><?php echo esc_html( $value ); ?></span>
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
		</body>
		</html>
		<?php
		return ob_get_clean();
	}

	/**
	 * Format field label (convert snake_case to Title Case).
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Field key.
	 * @return string Formatted label.
	 */
	private function format_field_label( $key ) {
		$label = str_replace( '_', ' ', $key );
		$label = ucwords( $label );
		return $label;
	}

	/**
	 * Get temporary file path.
	 *
	 * @since 1.0.0
	 *
	 * @param string $filename Filename prefix.
	 * @return string Full file path.
	 */
	private function get_temp_filepath( $filename ) {
		$upload_dir = wp_upload_dir();
		$temp_dir   = $upload_dir['basedir'] . '/sign-temp/';

		if ( ! file_exists( $temp_dir ) ) {
			wp_mkdir_p( $temp_dir );
		}

		$filename = sanitize_file_name( $filename . '-' . time() . '.pdf' );
		return $temp_dir . $filename;
	}
}
