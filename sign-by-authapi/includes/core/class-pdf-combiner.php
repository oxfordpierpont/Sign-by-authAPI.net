<?php
/**
 * PDF Combiner
 *
 * Merges customer data PDF with contract documents into a single PDF.
 *
 * @package SignByAuthAPI
 * @since 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sign_PDF_Combiner class
 *
 * @since 1.0.0
 */
class Sign_PDF_Combiner {

	/**
	 * Combine customer data PDF with contract PDFs.
	 *
	 * @since 1.0.0
	 *
	 * @param string $customer_pdf_path  Path to customer data PDF.
	 * @param array  $contract_pdf_paths Array of contract PDF paths.
	 * @param int    $cpt_id             CPT ID for filename.
	 * @return string|WP_Error Path to combined PDF or error.
	 */
	public function combine_pdfs( $customer_pdf_path, $contract_pdf_paths, $cpt_id ) {
		// Check if FPDI is available.
		if ( ! class_exists( '\setasign\Fpdi\Fpdi' ) ) {
			return new WP_Error( 'missing_library', 'FPDI library not found. Please run composer install.' );
		}

		try {
			$pdf = new \setasign\Fpdi\Fpdi();

			// Step 1: Add customer data PDF.
			if ( file_exists( $customer_pdf_path ) ) {
				$this->add_pdf_to_combined( $pdf, $customer_pdf_path );
			} else {
				return new WP_Error( 'file_not_found', 'Customer data PDF not found: ' . $customer_pdf_path );
			}

			// Step 2: Add each contract PDF.
			foreach ( $contract_pdf_paths as $contract_path ) {
				if ( file_exists( $contract_path ) ) {
					$this->add_pdf_to_combined( $pdf, $contract_path );
				} else {
					return new WP_Error( 'file_not_found', 'Contract PDF not found: ' . $contract_path );
				}
			}

			// Step 3: Save combined PDF.
			$upload_dir = wp_upload_dir();
			$temp_dir   = $upload_dir['basedir'] . '/sign-temp/';

			if ( ! file_exists( $temp_dir ) ) {
				wp_mkdir_p( $temp_dir );
			}

			$filename = 'combined-' . $cpt_id . '-' . time() . '.pdf';
			$filepath = $temp_dir . $filename;

			$pdf->Output( 'F', $filepath );

			return $filepath;

		} catch ( Exception $e ) {
			return new WP_Error( 'pdf_combine_failed', $e->getMessage() );
		}
	}

	/**
	 * Add all pages from a PDF to the combined PDF.
	 *
	 * @since 1.0.0
	 *
	 * @param \setasign\Fpdi\Fpdi $pdf            FPDI instance.
	 * @param string              $source_pdf_path Path to source PDF.
	 */
	private function add_pdf_to_combined( $pdf, $source_pdf_path ) {
		$page_count = $pdf->setSourceFile( $source_pdf_path );

		for ( $page_no = 1; $page_no <= $page_count; $page_no++ ) {
			// Get page size.
			$template_id   = $pdf->importPage( $page_no );
			$template_size = $pdf->getTemplateSize( $template_id );

			// Add page with same orientation and size.
			$orientation = ( $template_size['width'] > $template_size['height'] ) ? 'L' : 'P';
			$pdf->AddPage( $orientation, array( $template_size['width'], $template_size['height'] ) );

			// Use template.
			$pdf->useTemplate( $template_id );
		}
	}

	/**
	 * Get contract PDFs for a business.
	 *
	 * @since 1.0.0
	 *
	 * @param int $business_id Business ID.
	 * @return array Array of file paths.
	 */
	public function get_contract_pdfs( $business_id ) {
		global $wpdb;

		$table = $wpdb->prefix . 'sign_documents';

		$documents = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE business_id = %d ORDER BY sequence ASC",
				$business_id
			),
			ARRAY_A
		);

		$file_paths = array();
		foreach ( $documents as $doc ) {
			if ( ! empty( $doc['file_path'] ) && file_exists( $doc['file_path'] ) ) {
				$file_paths[] = $doc['file_path'];
			}
		}

		return $file_paths;
	}
}
