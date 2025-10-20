=== Sign by authAPI.net === 
Contributors: authAPI.net, Oxford Pierpont
Tags: e-signature, contract, pdf, document signing, esign, digital signature, legal documents, contract management Requires at least: 6.0 Tested up to: 6.4 Stable tag: 1.0.0
Requires PHP: 7.4 License: GPLv2 or later 
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Transform form submissions into legally-signed contracts automatically. Complete onboarding workflows in minutes, not hours.

== Description ==

Sign by authAPI.net eliminates the frustration of manual contract creation and signing. When customers fill out your intake form, this plugin automatically generates professional PDFs with your branding, combines them with your contract templates, and enables immediate electronic signing - all within WordPress.
The Problem We Solve
Traditional contract workflows are broken:

Customer fills out form
You manually create contract
You manually copy form data into contract
You upload to DocuSign/HelloSign
Customer signs on separate platform
You download and file manually

Result: 30-60 minutes per customer, prone to errors, poor user experience.
Our Solution
Sign by authAPI.net automates everything:

Customer fills out form ✓
Contract auto-generates with all data ✓
Customer signs immediately ✓
Legal certificate created automatically ✓
Everyone receives documents instantly ✓

Result: 2 minutes, zero manual work, seamless experience.
Key Features
🎨 Professional Document Generation

Custom letterheads (upload your own PDF or generate from logo)
Brand-consistent design (colors, fonts, styling)
Automatic multi-page handling
Combine multiple contract documents

✍️ Visual Signature Field Editor

Drag-and-drop signature fields onto your PDFs
Add signature boxes, initial fields, date fields, and text fields
Position fields exactly where needed
Configure required vs optional fields

🔐 Legally-Compliant E-Signatures

ESIGN Act and UETA compliant
Audit trails with timestamps
IP address verification
Verification certificates
Cryptographic proof

📧 Automated Notifications

Initial signing invitation
Smart reminders (configurable intervals)
Completion confirmations with attachments
Admin notifications

👥 Multi-Tenant Ready

Perfect for agencies managing multiple clients
Each business has isolated settings
Custom branding per business
SaaS-ready architecture

🔌 Form Builder Integration

JetFormBuilder (included)
More integrations coming soon

📊 Customer Dashboard

View pending signatures
Access completed documents
Download signed PDFs and certificates
Mobile-friendly interface
Perfect For
Marketing Agencies - Client onboarding contracts
Consultants & Freelancers - Service agreements
Law Firms - Client intake and engagement letters
Real Estate Agents - Rental applications and offers
Financial Advisors - Client onboarding documents
HR Departments - Employee contracts and forms
Any Business - That needs signed contracts from web forms
How It Works
Setup (One-Time):

Configure your branding (logo, colors, company info)
Upload your contract templates (PDFs)
Use visual editor to place signature fields
Connect to LibreSign (open-source e-signature platform)
Activate system

Every Customer After That:

Customer fills out your WordPress form
System auto-generates PDF with their data
Combines with your contract templates
Customer signs electronically
Everyone receives signed documents + certificates
Done in 2 minutes!
Requirements
WordPress 6.0 or higher
PHP 7.4 or higher
LibreSign instance (self-hosted or cloud)
JetFormBuilder (free or pro)
SSL certificate recommended
LibreSign Setup
This plugin requires LibreSign for e-signature functionality. LibreSign is an open-source, ESIGN Act compliant e-signature platform.

Options:

Self-Host - Free, install on your own server (DigitalOcean, AWS, etc.)
Cloud Hosting - Use LibreSign's cloud service (paid)

Why LibreSign?

Open-source and free
Legally compliant
Complete control over your data
No per-signature fees
Professional audit trails

Documentation for setting up LibreSign: https://libresign.github.io/
Privacy & Data
Your Data Stays Yours:

All customer data stored in your WordPress database
Signed documents saved to your server
No third-party data sharing (except LibreSign for signing)
GDPR compliant (with proper configuration)
Pro Features (Coming Soon)
Additional form builder integrations (Gravity Forms, WPForms, Formidable)
Multi-signer support (multiple people sign one document)
Advanced workflows (approval chains, conditional documents)
Analytics dashboard (completion rates, time-to-sign)
White-label option (remove branding)
Priority support

== Installation ==
Automatic Installation
Log in to your WordPress admin panel
Navigate to Plugins → Add New
Search for "Sign by authAPI.net"
Click "Install Now"
Click "Activate"
Manual Installation
Download the plugin ZIP file
Log in to your WordPress admin panel
Navigate to Plugins → Add New → Upload Plugin
Choose the ZIP file and click "Install Now"
Click "Activate Plugin"
First-Time Setup
Step 1: Configure LibreSign Connection

Go to WordPress Admin → Sign → Settings
Enter your LibreSign URL (e.g., https://libresign.yourserver.com)
Enter your LibreSign API Key
Click "Test Connection" to verify
Save settings

Step 2: Configure Branding

Go to Sign → Branding
Upload your company logo (PNG/JPG, max 2MB)
Set your brand colors (primary, secondary, accent)
Optionally upload custom PDF letterhead (max 5MB)
Enter company information:
Company Name
Authorized Representative
Representative Title
Email, Phone, Address
Save branding

Step 3: Upload Contract Documents

Go to Sign → Documents
Click "Add New Document"
Upload your contract PDF (max 10MB)
Enter document name
Set sequence number (for ordering multiple documents)
Click "Upload & Configure Fields"

Step 4: Configure Signature Fields

After uploading, the Visual Field Editor opens
Click "Add Signature" button
Click on the PDF where you want the signature
Drag to resize the signature box
Configure field properties (label, required)
Add additional fields as needed (initials, dates, text)
Click "Save Fields"

Step 5: Connect to JetFormBuilder

Create or edit a JetFormBuilder form
In the form sidebar, find "Sign Configuration"
Check "Enable signing for this form"
Select your business (if multi-tenant)
Update form

Step 6: Activate System

Go to Sign → Settings → General
Review the requirements checklist
Click "Activate System"
System is now live!
Testing
Submit a test form to verify everything works:

Fill out your JetFormBuilder form
Check your email for signing invitation
Click the dashboard link
Click "Sign Now"
Complete signing in LibreSign
Verify completion email received
Download signed PDF and certificate

== Frequently Asked Questions ==

= Do I need a LibreSign account? =

Yes, you need a LibreSign instance. LibreSign is open-source and free to self-host on your own server (DigitalOcean, AWS, etc.). Alternatively, you can use LibreSign's cloud hosting service.

= Which form builders are supported? =

Currently, JetFormBuilder is supported. We're actively developing integrations for:

Gravity Forms
WPForms
Formidable Forms
Contact Form 7

= Are the signatures legally binding? =

Yes! LibreSign provides ESIGN Act (US) and UETA compliant e-signatures. Each signed document includes:

Cryptographic proof of document integrity
Timestamp of signing
IP address verification
Audit trail
Verification certificate

These are legally equivalent to handwritten signatures in most jurisdictions.

= Can I use my own PDF letterhead? =

Yes! You can upload a custom PDF letterhead template. The plugin will overlay customer data on your letterhead. Alternatively, the plugin can generate a professional letterhead from your logo and brand colors.

= What happens if a customer doesn't sign immediately? =

The plugin automatically sends reminder emails at configurable intervals (default: 24 hours, then every 3 days). Customers can access their signing dashboard anytime using the unique link in their email.

= Can I customize the email templates? =

Yes, all email templates are fully customizable through the plugin settings. You can edit subject lines, body content, and styling.

= Does this work on mobile devices? =

Yes! The signing interface is fully mobile-responsive. Customers can sign on any device.

= How is customer data stored? =

All customer data is stored in your WordPress database using Custom Post Types. Signed documents are saved to your WordPress uploads directory. You have complete control over your data.

= Can I use this for multiple businesses/clients? =

Yes! The plugin supports multi-tenant architecture. Each business can have its own:

Branding (logo, colors, letterhead)
Contract documents
Email templates
Settings

Perfect for agencies managing multiple clients.

= What if a customer updates their information before signing? =

Since PDFs are generated on-demand (when customer clicks "Sign Now"), any updates to the form data will be reflected in the PDF. The PDF is not generated until the moment of signing.

= Can I require multiple signatures on one document? =

This feature is coming in version 1.1. Currently, one customer signs per document.

= How much does LibreSign cost? =

LibreSign is open-source and free to self-host. If you prefer cloud hosting, LibreSign offers paid plans. There are no per-signature fees when self-hosting.

= Is my data secure? =

Yes. The plugin follows WordPress security best practices:

All inputs are validated and sanitized
SQL queries use prepared statements
Nonces protect against CSRF attacks
API keys are encrypted before storage
File uploads are validated
Webhook signatures are verified

= Can I white-label this plugin? =

White-label functionality will be available in the Pro version (coming soon).

= Where can I get support? =

Documentation: https://authapi.net/docs/sign
Support Forum: WordPress.org Support Forum
Priority Support: Available with Pro version

= Can I contribute to development? =

Yes! This is an open-source project. Visit our GitHub repository to contribute code, report bugs, or suggest features.

== Screenshots ==

Admin Dashboard - Overview of signing activity and quick stats
Branding Configuration - Upload logo, set colors, configure company info
Document Management - Upload and organize contract templates
Visual Signature Field Editor - Drag-and-drop signature fields onto PDFs
Field Configuration - Configure field types, labels, and requirements
LibreSign Settings - Connect to your LibreSign instance
Customer Dashboard - Customer view of pending and completed signatures
Generated PDF Example - Professional PDF with custom letterhead and form data
Email Notification - Signing invitation email template
Completed Signature - Signed document with verification certificate

== Changelog ==

= 1.0.0 (2025-10-20) = Initial Release

Complete WordPress plugin architecture
JetFormBuilder integration
Custom Post Type for signing requests
PDF generation engine (mPDF, FPDI)
Custom letterhead support (upload or auto-generate)
Multi-page document handling
Document combiner (merge customer data + contracts)
LibreSign API integration
Visual signature field editor (PDF.js + Fabric.js)
Drag-and-drop field placement
Support for signature, initial, date, and text fields
Customer signing dashboard
Token-based authentication
Automated email notifications (4 templates)
Reminder system with cron jobs
Webhook handler for signing completion
Multi-tenant support (multiple businesses)
Complete admin interface
Security hardening (input validation, nonces, encryption)
Documentation and help text
Translation ready

= 0.9.0 (2025-10-10) = Beta Release

Initial beta for testing with limited users

== Upgrade Notice ==

= 1.0.0 = Initial public release of Sign by authAPI.net. Transform your form submissions into legally-signed contracts automatically.

== Technical Details ==

System Requirements:

WordPress 6.0+
PHP 7.4+ (PHP 8.0+ recommended)
MySQL 5.7+ or MariaDB 10.2+
128MB PHP memory limit (256MB recommended)
SSL certificate (HTTPS)
LibreSign instance (self-hosted or cloud)

PHP Extensions Required:

openssl (for encryption)
curl (for API requests)
gd or imagick (for image processing)
mbstring (for text encoding)

PHP Libraries Used:

mPDF (GPLv2+) - PDF generation from HTML
FPDI (MIT) - PDF manipulation
PHPMailer (LGPL) - Email with attachments

JavaScript Libraries Used:

PDF.js (Apache 2.0) - PDF rendering in browser
Fabric.js (MIT) - Canvas manipulation for field editor
Signature Pad (MIT) - Signature capture (future feature)

Database Tables:

wp_sign_businesses - Business/tenant configurations
wp_sign_documents - Uploaded contract templates
wp_sign_fields - Signature field coordinates
wp_sign_activity_log - Audit trail (optional)
Custom Post Type: sign_request - Signing request data

API Integrations:

LibreSign REST API v1
WordPress REST API (for webhooks)
JetFormBuilder action hooks

Security Features:

Input validation and sanitization
Prepared SQL statements
CSRF protection (nonces)
XSS prevention
File upload validation
API key encryption
Webhook signature verification
Token-based authentication
Role-based access control

== Privacy Policy ==

Data Collection: This plugin stores customer data submitted through forms in your WordPress database. This includes:

Contact information (name, email, phone, address)
Custom form fields you configure
Signing metadata (IP address, timestamp)
Generated PDF documents
Signed documents

Data Sharing:

Customer data is sent to your LibreSign instance for signature capture
Email notifications are sent via your WordPress/SMTP configuration
No data is sent to authAPI.net servers

Data Retention:

Customer data is retained indefinitely in your WordPress database
Administrators can manually delete signing requests
Signed documents are stored in your WordPress uploads directory

User Rights: Under GDPR and similar privacy laws, users have the right to:

Access their data
Request data deletion
Export their data

Administrators should implement appropriate processes to handle these requests.

== Support ==

Documentation: https://authapi.net/docs/sign

Support Forum: WordPress.org Support

GitHub Repository: [Coming soon]

Commercial Support: Available with Pro version

== Roadmap ==

Version 1.1 (Q1 2026)

Gravity Forms integration
WPForms integration
Formidable Forms integration
Multi-signer support
Sequential signing workflows

Version 1.2 (Q2 2026)

Advanced analytics dashboard
Conditional document logic
Approval workflows
Custom fonts support
API for developers

Version 2.0 (Q3 2026)

White-label option
Priority support
Advanced integrations (Salesforce, HubSpot)
Mobile app

== Credits ==

Developed by: authAPI.net Team

Open Source Libraries:

mPDF by Matěj Humpál
FPDI by Setasign
PDF.js by Mozilla
Fabric.js by Fabric.js contributors
LibreSign by LibreSign contributors

Special Thanks:

WordPress community
JetFormBuilder team
LibreSign project
Beta testers

== License ==

This plugin is licensed under GPLv2 or later.

You are free to:

Use this plugin for any purpose
Modify the plugin code
Distribute modified versions
Use commercially

Under the terms that:

Modified versions must be GPLv2+
You must include license and copyright notice
Source code must be available

Full license: https://www.gnu.org/licenses/gpl-2.0.html

