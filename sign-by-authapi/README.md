# Sign by authAPI.net

**WordPress E-Signature & Contract Management Plugin**

Automate contract signing workflows by converting form submissions into legally-signed PDFs. Seamlessly integrate with JetFormBuilder and LibreSign for a complete end-to-end signing solution.

## Features

- **Automated Workflow**: Form submission → PDF generation → E-signature → Completion (all automatic)
- **Custom Branding**: Use your logo, colors, and custom PDF letterheads
- **Multi-Document Support**: Combine customer data with multiple contract templates
- **Legal Compliance**: Generate legally-valid e-signatures and verification certificates via LibreSign
- **Email Notifications**: Automatic emails for invitations, reminders, and completions
- **Customer Dashboard**: Token-based secure access for customers to sign documents
- **Activity Logging**: Complete audit trail of all signing activities
- **Multi-Tenant Ready**: Support multiple businesses with isolated settings

## Requirements

- WordPress 6.0 or higher
- PHP 7.4 or higher
- MySQL 5.7+ or MariaDB 10.2+
- LibreSign instance (self-hosted or cloud)
- Composer (for dependencies)

## Installation

### Method 1: Manual Installation

1. Download the plugin ZIP file
2. Upload to `/wp-content/plugins/sign-by-authapi/`
3. Navigate to the plugin directory:
   ```bash
   cd /wp-content/plugins/sign-by-authapi/
   ```
4. Install PHP dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
5. Activate the plugin through the 'Plugins' menu in WordPress

### Method 2: Development Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/sign-by-authapi.git
   cd sign-by-authapi
   ```
2. Install dependencies:
   ```bash
   composer install
   ```
3. Link to WordPress plugins directory or copy to `/wp-content/plugins/`
4. Activate the plugin in WordPress

## Configuration

### 1. LibreSign Setup

1. Set up a LibreSign instance (see [LibreSign documentation](https://github.com/LibreSign/libresign))
2. Obtain your API URL and API Key
3. In WordPress, go to **Sign → Settings**
4. Enter your LibreSign API URL and API Key
5. Click "Test Connection" to verify

### 2. Branding Configuration

1. Go to **Sign → Branding**
2. Configure:
   - Company name and contact information
   - Upload your logo
   - Set brand colors
   - (Optional) Upload custom PDF letterhead
   - Set authorized representative details
3. Save changes

### 3. Upload Contract Documents

1. Go to **Sign → Documents**
2. Upload your contract PDFs:
   - Service agreements
   - Terms & conditions
   - Privacy policies
   - Any other required documents
3. Set the sequence/order for document assembly
4. Save

### 4. Configure Signature Fields

The visual field editor (for placing signature boxes on PDFs) requires additional setup:
- This feature uses PDF.js and Fabric.js for the visual interface
- **Note**: The visual editor is planned for Phase 7 of development
- For now, signature fields can be manually configured in the database

### 5. Form Integration

#### With JetFormBuilder:

The plugin automatically hooks into JetFormBuilder form submissions. Ensure your form includes these fields:

**Required Fields** (mapped automatically):
- `first_name` → Customer first name
- `last_name` → Customer last name
- `email` → Customer email address

**Optional Fields**:
- `phone` → Phone number
- `address_line1`, `address_line2`, `city`, `state`, `zip` → Address components

**Custom Fields**:
- Any additional fields will be included in the generated PDF

### 6. Activate the System

1. Go to **Sign → Settings**
2. Check "Activate Plugin"
3. Configure email settings
4. Set redirect URLs for post-signing
5. Save changes

## Usage

### Customer Workflow

1. **Form Submission**: Customer fills out your intake form
2. **Email Notification**: Customer receives email with secure dashboard link
3. **Review & Sign**: Customer clicks link, reviews contract, and clicks "Sign"
4. **LibreSign Interface**: Customer is redirected to LibreSign to complete signature
5. **Completion**: Customer receives signed contract and certificate via email

### Admin Workflow

1. **Dashboard Monitoring**: View signing stats and pending requests in **Sign → Dashboard**
2. **Activity Log**: Review all signing activities in **Sign → Activity Log**
3. **View Requests**: Access individual signing requests in **Signing Requests** menu
4. **Notifications**: Receive email when contracts are signed

## Technical Architecture

### Core Components

- **Sign_Plugin**: Main plugin class, manages hooks and initialization
- **Sign_PDF_Generator**: Generates customer data PDFs with branding
- **Sign_PDF_Combiner**: Merges multiple PDFs into single document
- **Sign_LibreSign_Client**: Handles API communication with LibreSign
- **Sign_Signing_Controller**: Orchestrates the entire signing workflow
- **Sign_Webhook_Handler**: Processes callbacks from LibreSign
- **Sign_Email_Manager**: Manages all email notifications

### Database Schema

**Custom Post Type**: `sign_request`
- Stores all customer data and signing metadata

**Custom Tables**:
- `wp_sign_businesses` - Business/tenant configuration
- `wp_sign_documents` - Uploaded contract PDFs
- `wp_sign_fields` - Signature field coordinates
- `wp_sign_activity_log` - Audit trail

### Workflow Diagram

```
Form Submission
     ↓
Create CPT (signing_status='incomplete')
     ↓
Send Initial Email
     ↓
Customer Clicks Dashboard Link
     ↓
Generate PDF (customer data + contracts)
     ↓
Send to LibreSign
     ↓
Customer Signs in LibreSign
     ↓
Webhook Received
     ↓
Update CPT (signing_status='complete')
     ↓
Send Completion Emails
     ↓
Done
```

## Development

### Dependencies

**PHP Libraries** (via Composer):
- `mpdf/mpdf` - HTML to PDF conversion
- `setasign/fpdi` - PDF manipulation and merging

**JavaScript Libraries** (planned):
- `pdfjs-dist` - PDF rendering in browser
- `fabric` - Canvas manipulation for field editor

### Development Setup

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   npm install  # When JavaScript dependencies are added
   ```
3. Set up a local WordPress environment
4. Set up a local LibreSign instance for testing
5. Enable WordPress debugging:
   ```php
   define('WP_DEBUG', true);
   define('WP_DEBUG_LOG', true);
   ```

### File Structure

```
sign-by-authapi/
├── assets/
│   ├── css/          # Stylesheets
│   ├── js/           # JavaScript files
│   └── images/       # Plugin images
├── includes/
│   ├── admin/        # Admin interface classes
│   ├── core/         # Core functionality
│   ├── public/       # Public-facing classes
│   ├── class-activator.php
│   ├── class-deactivator.php
│   └── class-post-type.php
├── languages/        # Translation files
├── templates/
│   ├── admin/        # Admin page templates
│   ├── email/        # Email templates
│   └── public/       # Public page templates
├── vendor/           # Composer dependencies
├── composer.json     # PHP dependencies
├── sign-by-authapi.php  # Main plugin file
└── README.md
```

## Hooks & Filters

### Actions

- `sign_request_created` - Fired after creating a signing request
- `sign_pdf_sent` - Fired after sending PDF to LibreSign
- `sign_document_completed` - Fired when document is signed
- `sign_document_opened` - Fired when customer opens document
- `sign_document_declined` - Fired when customer declines

### Filters

- `sign_pdf_data` - Filter customer data before PDF generation
- `sign_email_content` - Filter email content before sending
- `sign_dashboard_url` - Filter the signing dashboard URL

## Troubleshooting

### PDF Generation Issues

- Ensure Composer dependencies are installed: `composer install`
- Check file permissions on `/wp-content/uploads/sign-temp/`
- Verify PHP memory limit (recommended: 256M)

### LibreSign Connection Issues

- Verify API URL is correct and accessible
- Check API key is valid
- Ensure webhook URL is publicly accessible
- Review LibreSign logs for errors

### Email Issues

- Check WordPress email configuration
- Verify "From" email address in Settings
- Use an SMTP plugin for reliable delivery
- Check spam folders

### Webhook Issues

- Ensure site is publicly accessible (not localhost)
- Check REST API is enabled: `/wp-json/sign/v1/webhook`
- Review Activity Log for webhook events
- Verify LibreSign callback configuration

## FAQ

**Q: Can I use this with other form builders besides JetFormBuilder?**
A: Yes, but you'll need to add custom integration hooks for your form builder. The plugin can be extended to work with any form submission system.

**Q: Do I need a LibreSign account?**
A: Yes, LibreSign handles the actual e-signature process. You can self-host LibreSign or use a cloud instance.

**Q: Can I customize the email templates?**
A: Currently, email templates are in the code. Template customization via admin UI is planned for a future release.

**Q: Is this GDPR compliant?**
A: The plugin stores minimal customer data. You're responsible for your privacy policy and consent mechanisms.

**Q: Can I white-label this plugin?**
A: Yes, the plugin is GPL-licensed. You can modify branding and distribute under GPL terms.

## Roadmap

### Phase 1-6: Foundation (Completed)
- ✅ Plugin scaffold
- ✅ Database schema
- ✅ Core classes
- ✅ PDF generation
- ✅ LibreSign integration
- ✅ Email system

### Phase 7: Visual Field Editor (In Progress)
- ⏳ PDF.js integration
- ⏳ Fabric.js drag-drop interface
- ⏳ Field configuration modal

### Phase 8: Polish & Testing
- Security hardening
- Comprehensive error handling
- Unit tests
- Integration tests

### Future Enhancements
- Gravity Forms integration
- WPForms integration
- DocuSign alternative integration
- Advanced field types (checkboxes, radio buttons)
- Multi-signer support
- Document templates with merge fields
- Mobile app

## Support

- **Documentation**: [https://authapi.net/sign/docs](https://authapi.net/sign/docs)
- **Issues**: [GitHub Issues](https://github.com/yourusername/sign-by-authapi/issues)
- **Email**: support@authapi.net

## Contributing

Contributions are welcome! Please:

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This plugin is licensed under the **GPL v2 or later**.

```
Sign by authAPI.net
Copyright (C) 2025 authAPI.net, Oxford Pierpont

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.
```

## Credits

**Developed by**: authAPI.net, Oxford Pierpont
**Built with**:
- WordPress
- LibreSign
- mPDF
- FPDI

---

**Made with ❤️ for the WordPress community**
