# **Project Requirements Document (PRD)**

## **Sign by authAPI.net**

### **WordPress E-Signature & Contract Management Plugin**

**Author:** authAPI.net, Oxford Pierpont

**Version:** 1.0  
 **Date:** October 19, 2025  
 **Project Type:** WordPress Plugin Development  
 **Target Delivery:** Single installable WordPress plugin (.zip)

---

## **Table of Contents**

1. [Executive Summary](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#1-executive-summary)  
2. [Problem Statement](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#2-problem-statement)  
3. [Solution Overview](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#3-solution-overview)  
4. [Market Differentiation](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#4-market-differentiation)  
5. [User Personas & Use Cases](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#5-user-personas--use-cases)  
6. [Technical Architecture](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#6-technical-architecture)  
7. [Feature Specifications](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#7-feature-specifications)  
8. [Database Schema](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#8-database-schema)  
9. [Development Phases](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#9-development-phases)  
10. [Technical Stack & Dependencies](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#10-technical-stack--dependencies)  
11. [API Integrations](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#11-api-integrations)  
12. [Security Requirements](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#12-security-requirements)  
13. [Testing Requirements](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#13-testing-requirements)  
14. [Deployment & Installation](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#14-deployment--installation)  
15. [Future Enhancements](https://claude.ai/chat/87fbe2ae-76ba-45bb-b064-197899ec0c33#15-future-enhancements)

---

## **1\. Executive Summary**

### **1.1 Project Overview**

**Sign by authAPI.net** is a WordPress plugin that automates the entire contract signing workflow for businesses that collect customer information through online forms. Unlike standalone e-signature platforms (DocuSign, HelloSign, PandaDoc), this plugin is **deeply integrated** into WordPress and works seamlessly with existing form data to create a unified onboarding experience.

### **1.2 What Problem Does This Solve?**

Today, businesses using WordPress for customer onboarding face a **fragmented workflow**:

1. Customer fills out a form on WordPress (contact info, project details, preferences)  
2. Business manually creates a contract in Word/Google Docs  
3. Business manually copies form data into the contract  
4. Business uploads contract to DocuSign  
5. Business manually sends DocuSign link to customer  
6. Customer signs in a completely separate platform  
7. Business downloads signed document and manually files it

**This creates:**

* 30-60 minutes of manual work per customer  
* Data entry errors  
* Poor customer experience (multiple platforms)  
* Delays in onboarding (waiting for manual steps)  
* Lost revenue (customers abandon incomplete workflows)

### **1.3 How Sign by authAPI.net Solves This**

**Sign by authAPI.net automates the entire process:**

1. Customer fills out intake form on WordPress ✅  
2. **Plugin automatically generates a PDF** with all form data ✅  
3. **Plugin automatically attaches contract templates** ✅  
4. **Customer signs immediately** in a seamless workflow ✅  
5. **Legally-valid certificate generated automatically** ✅  
6. **Everyone receives signed documents instantly** ✅

**Result:** What took 30-60 minutes now takes 2 minutes, with zero manual work.

### **1.4 Business Impact**

**For Business Owners:**

* Reduce onboarding time by 95%  
* Eliminate data entry errors  
* Improve customer conversion (seamless experience)  
* Scale without hiring additional staff  
* Maintain legal compliance automatically

**For Customers:**

* Single platform experience  
* No account creation required  
* Mobile-friendly signing  
* Instant document delivery

### **1.5 Revenue Model**

This plugin will be:

* **Free core version** (basic features, single business)  
* **Premium version** (multi-tenant, advanced branding, priority support)  
* **Enterprise version** (white-label, custom integrations)

---

## **2\. Problem Statement**

### **2.1 Current Market Solutions & Their Limitations**

#### **Standalone E-Signature Platforms (DocuSign, HelloSign, etc.)**

**What they do well:**

* Legally compliant e-signatures  
* Audit trails and certificates  
* Multi-signer workflows

**What they don't do:**

* Don't integrate with WordPress form data  
* Require manual document creation  
* Require manual data entry  
* Operate as separate platforms (poor UX)  
* Expensive ($25-100/month per user)

#### **WordPress Form Plugins (Gravity Forms, JotForm, etc.)**

**What they do well:**

* Collect form data  
* Store data in WordPress  
* Email notifications

**What they don't do:**

* Cannot generate legally-compliant signatures  
* No audit trails or certificates  
* Simple "type your name" signatures (not enforceable)  
* No contract management

#### **WordPress E-Signature Plugins (WP E-Signature, etc.)**

**What they do well:**

* Basic signature capture within WordPress  
* Simple contracts

**What they don't do:**

* Don't integrate with form builders  
* Don't auto-populate contracts with form data  
* Limited legal compliance features  
* Poor document generation (no letterheads, branding)  
* Can't combine multiple documents

### **2.2 The Gap in the Market**

**There is no solution that:**

1. Lives entirely within WordPress  
2. Automatically converts form submissions into signed contracts  
3. Generates legally-compliant certificates  
4. Supports custom branding and letterheads  
5. Works with existing WordPress form builders  
6. Operates as a seamless, single-platform experience

**Sign by authAPI.net fills this exact gap.**

---

## **3\. Solution Overview**

### **3.1 What is Sign by authAPI.net?**

Sign by authAPI.net is a **WordPress plugin** that transforms form submissions into legally-signed contracts automatically. It consists of:

1. **Admin Dashboard** \- Where business owners configure branding, upload contracts, and manage settings  
2. **PDF Generation Engine** \- Converts form data into professional PDFs with letterheads  
3. **Document Combiner** \- Merges generated PDFs with uploaded contract templates  
4. **E-Signature Integration** \- Connects to LibreSign (open-source e-signature platform)  
5. **Customer Dashboard** \- Where customers view and sign pending documents  
6. **Notification System** \- Automated emails for reminders and confirmations  
7. **Certificate Generator** \- Creates legally-compliant verification certificates

### **3.2 How It Works (Step-by-Step)**

#### **Phase 1: Business Setup (One-Time)**

1. Business owner installs plugin on WordPress site  
2. Owner configures branding:  
   * Uploads company logo  
   * Sets brand colors  
   * Optionally uploads custom PDF letterhead  
   * Sets company information (name, authorized rep, email, address)  
3. Owner uploads contract documents (PDFs):  
   * Service agreements  
   * Terms & conditions  
   * Privacy policies  
   * Any other required documents  
4. Owner uses **visual editor** to place signature fields on each document:  
   * Clicks on PDF preview to add signature boxes  
   * Adds initial boxes, date fields, text fields  
   * Configures which fields are required  
5. Owner activates the system

#### **Phase 2: Customer Onboarding (Automated)**

1. Customer visits WordPress site and fills out intake form (JetFormBuilder)  
2. Form collects:  
   * Customer name, email, phone, address  
   * Project details, budget, timeline  
   * Any business-specific questions  
3. Customer clicks "Submit"  
4. **Plugin automatically triggers:**  
   * Creates/updates Custom Post Type (CPT) with all form data  
   * Sets metadata: `signing_status = 'incomplete'`  
   * Sends email to customer: "Please complete your contract signing"  
5. Customer receives email with link to signing dashboard

#### **Phase 3: Contract Signing (Seamless)**

1. Customer clicks link and lands on **WordPress signing dashboard**  
2. Dashboard shows: "You have 1 document pending signature"  
3. Customer clicks "Review & Sign"  
4. **Plugin generates complete PDF package:**  
   * **Page 1:** Customer data summary (with company letterhead)  
     * "Customer Information"  
     * Name: John Smith  
     * Email: john@example.com  
     * Project: Website Redesign  
     * Budget: $10,000-15,000  
     * \[All form fields displayed professionally\]  
   * **Pages 2-5:** Service Agreement (uploaded contract)  
   * **Pages 6-8:** Privacy Policy (uploaded contract)  
5. PDF sent to **LibreSign** with signature field coordinates  
6. Customer redirected to LibreSign signing interface  
7. Customer signs, initials, and dates where required  
8. LibreSign processes signature and creates certificate

#### **Phase 4: Completion (Instant)**

1. LibreSign sends webhook to WordPress  
2. **Plugin automatically:**  
   * Updates CPT metadata: `signing_status = 'complete'`  
   * Stores signed PDF URL  
   * Stores certificate URL  
   * Records signing timestamp, IP address  
3. **Automated emails sent:**  
   * Customer receives: Signed contract \+ Certificate  
   * Business owner receives: Notification of completion \+ Documents  
4. Customer redirected to next onboarding step (customizable)  
5. Dashboard updated: No pending signatures

#### **Phase 5: Reminders (Optional)**

If customer doesn't sign immediately:

1. Daily cron job checks for `signing_status = 'incomplete'`  
2. If document older than 24 hours, send reminder email  
3. Reminder includes dashboard link  
4. Reminders continue every 3 days until signed

### **3.3 Technical Flow Diagram**

```
┌─────────────────────────────────────────────────────────────────┐
│                    SIGN BY AUTHAPI.NET FLOW                     │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────┐
│ Customer visits  │
│ WordPress site   │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Fills JetForm    │
│ Builder form     │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────────────────────────────────────────┐
│ JetFormBuilder Action Hook: 'jet-form-builder/after-send'   │
│                                                               │
│ Plugin Function: create_signing_request()                    │
│  ├─ Extract form data                                        │
│  ├─ Create/Update CPT with data                             │
│  ├─ Set meta: signing_status = 'incomplete'                 │
│  ├─ Generate unique token                                    │
│  └─ Send email notification                                  │
└────────┬─────────────────────────────────────────────────────┘
         │
         ▼
┌──────────────────┐
│ Customer receives│
│ email with link  │
└────────┬─────────┘
         │
         ▼
┌──────────────────┐
│ Customer clicks  │
│ dashboard link   │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────────────────────────────────────────┐
│ Custom WordPress Page: /signing-dashboard/                   │
│                                                               │
│ Query: SELECT * FROM posts WHERE meta_key='signing_status'  │
│        AND meta_value='incomplete' AND post_author=user_id   │
│                                                               │
│ Display: List of pending documents with "Sign Now" buttons  │
└────────┬─────────────────────────────────────────────────────┘
         │
         ▼
┌──────────────────┐
│ Customer clicks  │
│ "Sign Now"       │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────────────────────────────────────────┐
│ Plugin Function: generate_signing_pdf()                      │
│                                                               │
│ Step 1: Load CPT data by ID                                  │
│  ├─ Customer info (name, email, phone, etc.)                │
│  ├─ Form responses (project details, budget, etc.)          │
│  └─ Business branding settings                              │
│                                                               │
│ Step 2: Generate Customer Data PDF                          │
│  ├─ Load letterhead (custom PDF or generated from logo)     │
│  ├─ Create HTML template                                     │
│  ├─ Populate with CPT data                                   │
│  ├─ Convert HTML to PDF using mPDF                          │
│  └─ Handle multi-page overflow automatically                │
│                                                               │
│ Step 3: Load Contract Documents                             │
│  ├─ Query: Get uploaded PDFs for this business             │
│  ├─ Order by sequence number                                │
│  └─ Load signature field coordinates                        │
│                                                               │
│ Step 4: Combine PDFs                                         │
│  ├─ Use FPDI library                                         │
│  ├─ Page 1: Generated customer data PDF                     │
│  ├─ Pages 2+: Imported contract documents                   │
│  └─ Save as single PDF to /wp-content/uploads/sign-temp/   │
│                                                               │
│ Step 5: Send to LibreSign                                    │
│  ├─ Upload combined PDF via API                             │
│  ├─ Attach signature field coordinates                      │
│  ├─ Set signer email: customer email from CPT              │
│  ├─ Set callback webhook URL                                │
│  └─ Receive signing URL                                      │
└────────┬─────────────────────────────────────────────────────┘
         │
         ▼
┌──────────────────┐
│ Redirect customer│
│ to LibreSign URL │
└────────┬─────────┘
         │
         ▼
┌──────────────────────────────────────────────────────────────┐
│ LibreSign Signing Interface (External)                       │
│  ├─ Display PDF with signature fields highlighted           │
│  ├─ Customer signs (draw/type/upload)                       │
│  ├─ Customer initials where required                        │
│  ├─ Customer enters dates                                    │
│  ├─ Capture IP address, timestamp, browser info            │
│  ├─ Generate cryptographic hash                             │
│  └─ Create certificate of completion                        │
└────────┬─────────────────────────────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────────────────────────────┐
│ LibreSign Webhook: POST to /wp-json/sign/v1/webhook        │
│                                                               │
│ Payload:                                                     │
│  {                                                           │
│    "event": "document_signed",                              │
│    "document_id": "abc123",                                 │
│    "signed_pdf_url": "https://...",                         │
│    "certificate_url": "https://...",                        │
│    "metadata": {                                             │
│      "cpt_id": 456,                                         │
│      "ip_address": "192.168.1.1",                           │
│      "signed_at": "2025-10-19T10:30:00Z"                   │
│    }                                                         │
│  }                                                           │
│                                                               │
│ Plugin Function: handle_webhook()                            │
│  ├─ Verify webhook signature (security)                     │
│  ├─ Extract CPT ID from metadata                            │
│  ├─ Download signed PDF from LibreSign                      │
│  ├─ Download certificate from LibreSign                     │
│  ├─ Save files to /wp-content/uploads/signed-docs/         │
│  ├─ Update CPT metadata:                                     │
│  │   ├─ signing_status = 'complete'                         │
│  │   ├─ signed_pdf_url = local file path                   │
│  │   ├─ certificate_url = local file path                  │
│  │   ├─ signed_date = timestamp                             │
│  │   └─ signer_ip = IP address                             │
│  └─ Trigger action: do_action('sign_document_completed')   │
└────────┬─────────────────────────────────────────────────────┘
         │
         ▼
┌──────────────────────────────────────────────────────────────┐
│ Email Notifications                                          │
│                                                               │
│ Email to Customer:                                           │
│  Subject: "Your contract has been signed successfully"      │
│  Body: Professional HTML template                           │
│  Attachments:                                                │
│   ├─ Signed contract PDF                                    │
│   └─ Verification certificate PDF                           │
│                                                               │
│ Email to Business Owner:                                     │
│  Subject: "New signed contract from [Customer Name]"        │
│  Body: Customer details + link to view in dashboard         │
│  Attachments: Same as customer                              │
└────────┬─────────────────────────────────────────────────────┘
         │
         ▼
┌──────────────────┐
│ Redirect customer│
│ to next step     │
│ (configurable)   │
└──────────────────┘
```

---

## **4\. Market Differentiation**

### **4.1 Competitive Analysis**

| Feature | Sign by authAPI.net | DocuSign | HelloSign | WP E-Signature | Gravity Forms \+ Zapier |
| ----- | ----- | ----- | ----- | ----- | ----- |
| **WordPress Native** | ✅ Yes | ❌ No | ❌ No | ✅ Yes | ⚠️ Partial |
| **Auto Form-to-PDF** | ✅ Yes | ❌ Manual | ❌ Manual | ❌ Manual | ⚠️ Via Zapier |
| **Custom Letterheads** | ✅ Yes | ⚠️ Templates | ⚠️ Templates | ❌ No | ❌ No |
| **Multi-Doc Combining** | ✅ Yes | ⚠️ Limited | ⚠️ Limited | ❌ No | ❌ No |
| **Visual Field Editor** | ✅ Yes | ✅ Yes | ✅ Yes | ❌ No | ❌ No |
| **Legal Certificates** | ✅ Yes | ✅ Yes | ✅ Yes | ⚠️ Basic | ❌ No |
| **Customer Dashboard** | ✅ Yes | ✅ Yes | ✅ Yes | ❌ No | ❌ No |
| **No Monthly Fees** | ✅ Yes | ❌ $25+ | ❌ $15+ | ✅ Yes | ❌ $20+ |
| **Self-Hosted Option** | ✅ Yes | ❌ No | ❌ No | ✅ Yes | ❌ No |
| **Multi-Tenant Support** | ✅ Yes | ⚠️ Enterprise | ⚠️ Enterprise | ❌ No | ❌ No |

### **4.2 Unique Value Propositions**

#### **1\. True WordPress Integration**

* Lives entirely within WordPress ecosystem  
* No external accounts required  
* Works with existing WordPress users  
* Integrates with any WordPress form builder

#### **2\. Zero-Touch Automation**

* Form submission → Signed contract in 2 minutes  
* No manual PDF creation  
* No manual data entry  
* No manual sending

#### **3\. Professional Document Generation**

* Custom letterheads  
* Brand-consistent design  
* Multi-page overflow handling  
* Combines multiple contracts

#### **4\. Cost Efficiency**

* No per-signature fees  
* No monthly subscriptions (self-hosted)  
* Scales to unlimited signatures  
* One-time setup cost

#### **5\. Complete Control**

* Self-hosted on own servers  
* Complete data ownership  
* Customizable workflows  
* White-label ready

#### **6\. Built for Multi-Tenancy**

* One installation serves multiple businesses  
* Each business has isolated settings  
* SaaS-ready architecture  
* Agency-friendly

### **4.3 Target Market**

#### **Primary Market:**

* **Marketing Agencies** (managing multiple clients)  
* **Freelancers & Consultants** (onboarding clients)  
* **Law Firms** (client intake forms)  
* **Real Estate Agents** (rental applications, offers)  
* **Financial Advisors** (client onboarding)  
* **SaaS Companies** (contract workflows)

#### **Secondary Market:**

* **WordPress Agencies** (offering as service to clients)  
* **Plugin Developers** (white-label resellers)  
* **Enterprise Companies** (internal contract management)

#### **Market Size:**

* 810 million WordPress sites worldwide  
* 43% of all websites use WordPress  
* Estimated 100,000+ businesses need contract automation  
* Total Addressable Market: $500M+

---

## **5\. User Personas & Use Cases**

### **5.1 Persona 1: Sarah \- Marketing Agency Owner**

**Demographics:**

* Age: 35  
* Role: Agency Owner  
* Company Size: 10 employees  
* Annual Revenue: $1.2M  
* Tech Skills: Moderate (uses WordPress, knows plugins)

**Pain Points:**

* Spends 2 hours/week manually creating contracts for new clients  
* Clients abandon onboarding due to friction  
* Data entry errors lead to contract mistakes  
* Paying $300/month for DocuSign (3 users)

**Use Case:** Sarah's agency gets 20 new clients/month. Each client fills out an intake form with project details, budget, timeline. Sarah currently:

1. Manually copies data from form into contract template  
2. Uploads to DocuSign  
3. Manually sends to client  
4. Waits 2-3 days for signature  
5. Downloads and files manually

**With Sign by authAPI.net:**

1. Client submits form  
2. Contract auto-generates with all data  
3. Client signs immediately  
4. Sarah receives notification  
5. All done in 2 minutes

**ROI:**

* Time saved: 8 hours/month \= $800/month (at $100/hr)  
* Cost saved: $300/month (DocuSign fees)  
* Revenue increase: 15% more conversions (faster onboarding)  
* **Total value: $1,100+/month**

### **5.2 Persona 2: Marcus \- Freelance Web Developer**

**Demographics:**

* Age: 28  
* Role: Freelancer  
* Annual Revenue: $80K  
* Tech Skills: Advanced (developer)

**Pain Points:**

* Looks unprofessional using "sign your name" text boxes  
* Needs legally-binding contracts  
* Can't afford DocuSign ($25/month for 5 signatures)  
* Clients ghost him during contract signing phase

**Use Case:** Marcus uses JetFormBuilder for his project intake form. Clients fill it out, but then Marcus has to:

1. Manually create contract in Google Docs  
2. Email it as a PDF  
3. Client prints, signs, scans, emails back  
4. Takes 3-5 days, many clients never return it

**With Sign by authAPI.net:**

1. Client submits intake form  
2. Professional contract auto-generates  
3. Client signs electronically  
4. Marcus looks professional  
5. Close rate improves

**ROI:**

* Converts 2 more clients/month \= $10K/month extra  
* Saves $25/month on e-sign tools  
* **Total value: $10K+/month**

### **5.3 Persona 3: Jennifer \- HR Manager at Law Firm**

**Demographics:**

* Age: 42  
* Role: HR Manager  
* Company Size: 50 attorneys  
* Tech Skills: Basic (uses WordPress for careers page)

**Pain Points:**

* New client intake requires 15-page questionnaire  
* Manually creating engagement letters is error-prone  
* Conflict checks require signed intake forms  
* Using DocuSign costs $5,000/year for 10 users

**Use Case:** Law firm gets 100 new client inquiries/month. Each requires:

1. Intake form (client details, case info, conflicts)  
2. Engagement letter (populated with client info)  
3. Fee agreement  
4. Retainer agreement  
5. Conflict waiver

Currently takes 30 minutes per client to prepare all documents.

**With Sign by authAPI.net:**

1. Prospective client fills intake form  
2. All 5 documents auto-generate with client data  
3. Client signs all at once  
4. HR receives notification  
5. Done in 5 minutes

**ROI:**

* Time saved: 50 hours/month \= $2,500/month (at $50/hr)  
* Cost saved: $420/month (DocuSign)  
* Reduced errors: Priceless  
* **Total value: $3,000+/month**

---

## **6\. Technical Architecture**

### **6.1 System Architecture Overview**

```
┌───────────────────────────────────────────────────────────────┐
│                    SIGN BY AUTHAPI.NET                        │
│                   WordPress Plugin v1.0                       │
└───────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                      FRONTEND LAYER                         │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │   Admin UI   │  │  Customer    │  │  Email       │     │
│  │   Settings   │  │  Dashboard   │  │  Templates   │     │
│  │   Pages      │  │  (Public)    │  │              │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│  - Branding Setup  - Pending Docs   - Reminder Emails      │
│  - Doc Upload      - Sign Interface - Completion Emails    │
│  - Field Editor    - History View   - Admin Notifications  │
│  - Settings        - Download PDFs                          │
└─────────────────────────────────────────────────────────────┘
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                   BUSINESS LOGIC LAYER                      │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │  Document    │  │  Signing     │  │  Notification│     │
│  │  Generator   │  │  Controller  │  │  Manager     │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│  - PDF Creation    - Workflow Logic - Email Queue          │
│  - Data Mapping    - Status Tracking - Reminder Cron       │
│  - Template Merge  - Token Auth     - Webhook Handler      │
│                                                              │
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │  Business    │  │  Security    │  │  Settings    │     │
│  │  Manager     │  │  Module      │  │  Manager     │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│  - Multi-tenant   - Token Validation - Config Storage      │
│  - Permissions    - Webhook Verify   - Default Values      │
│  - Isolation      - Data Encryption  - Validation Rules    │
└─────────────────────────────────────────────────────────────┘
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                      DATA LAYER                             │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │  WordPress   │  │  Custom      │  │  File        │     │
│  │  Database    │  │  Tables      │  │  Storage     │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│  - wp_posts (CPT) - sign_businesses - /uploads/sign/       │
│  - wp_postmeta    - sign_documents  - /temp/ (PDFs)        │
│  - wp_users       - sign_fields     - /signed/ (Final)     │
│  - wp_options     - sign_requests   - /letterheads/        │
└─────────────────────────────────────────────────────────────┘
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                   INTEGRATION LAYER                         │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐     │
│  │  LibreSign   │  │  JetForm     │  │  WordPress   │     │
│  │  API Client  │  │  Builder     │  │  Hooks       │     │
│  └──────────────┘  └──────────────┘  └──────────────┘     │
│  - Upload PDF     - Form Hooks      - Action Hooks         │
│  - Create Request - CPT Query       - Filter Hooks         │
│  - Webhook Listen - Meta Handling   - REST API             │
│  - File Download                                            │
└─────────────────────────────────────────────────────────────┘
                           ▼
┌─────────────────────────────────────────────────────────────┐
│                   EXTERNAL SERVICES                         │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────────────┐          ┌─────────────────┐          │
│  │   LibreSign     │          │   SMTP Server   │          │
│  │   (Self-Hosted) │          │   (Email)       │          │
│  └─────────────────┘          └─────────────────┘          │
│  - E-signature platform        - Transactional emails      │
│  - Certificate generation      - Notification delivery     │
│  - Audit trail                                              │
└─────────────────────────────────────────────────────────────┘
```

### **6.2 Plugin File Structure**

```
sign-by-authapi/
│
├── sign-by-authapi.php                 # Main plugin file
│   └── Plugin header, activation/deactivation hooks
│
├── README.md                           # Documentation
├── LICENSE.txt                         # GPL v2 or later
├── package.json                        # For JS dependencies
├── composer.json                       # For PHP dependencies
│
├── includes/                           # Core PHP classes
│   ├── class-sign-plugin.php          # Main plugin class
│   ├── class-activator.php            # Activation logic
│   ├── class-deactivator.php          # Deactivation logic
│   │
│   ├── admin/                         # Admin-specific functionality
│   │   ├── class-admin.php           # Admin menu, pages
│   │   ├── class-settings.php        # Settings API handler
│   │   ├── class-branding.php        # Branding configuration
│   │   ├── class-document-manager.php # Upload/manage contracts
│   │   └── class-field-editor.php    # Signature field editor
│   │
│   ├── public/                        # Public-facing functionality
│   │   ├── class-dashboard.php       # Customer dashboard
│   │   ├── class-signing-interface.php # Signing page
│   │   └── class-public-assets.php   # CSS/JS for public pages
│   │
│   ├── core/                          # Core business logic
│   │   ├── class-pdf-generator.php   # Generate PDFs from data
│   │   ├── class-pdf-combiner.php    # Merge multiple PDFs
│   │   ├── class-signing-controller.php # Workflow orchestration
│   │   ├── class-libresign-client.php # LibreSign API wrapper
│   │   ├── class-webhook-handler.php  # Handle LibreSign webhooks
│   │   ├── class-cpt-handler.php     # Custom Post Type operations
│   │   └── class-token-manager.php   # Generate/validate tokens
│   │
│   ├── notifications/                 # Email & notification system
│   │   ├── class-email-manager.php   # Email queue/sending
│   │   ├── class-reminder-cron.php   # Scheduled reminders
│   │   └── templates/                # Email HTML templates
│   │       ├── reminder.html
│   │       ├── completion.html
│   │       └── admin-notification.html
│   │
│   ├── database/                      # Database operations
│   │   ├── class-database.php        # Custom table creation
│   │   ├── class-business-model.php  # Business CRUD operations
│   │   ├── class-document-model.php  # Document CRUD operations
│   │   └── class-request-model.php   # Signing request CRUD
│   │
│   ├── integrations/                  # Third-party integrations
│   │   ├── class-jetformbuilder.php  # JetFormBuilder hooks
│   │   ├── class-gravity-forms.php   # Gravity Forms (future)
│   │   └── class-wpforms.php         # WPForms (future)
│   │
│   ├── security/                      # Security features
│   │   ├── class-validator.php       # Input validation
│   │   ├── class-sanitizer.php       # Data sanitization
│   │   ├── class-encryptor.php       # Encryption utilities
│   │   └── class-permissions.php     # User permissions
│   │
│   └── utils/                         # Utility functions
│       ├── class-logger.php          # Error/debug logging
│       ├── class-file-handler.php    # File operations
│       └── helpers.php               # Helper functions
│
├── assets/                            # Static assets
│   ├── css/
│   │   ├── admin/
│   │   │   ├── admin-styles.css     # Admin dashboard styles
│   │   │   └── field-editor.css     # Visual field editor styles
│   │   └── public/
│   │       ├── dashboard.css         # Customer dashboard styles
│   │       └── signing.css           # Signing interface styles
│   │
│   ├── js/
│   │   ├── admin/
│   │   │   ├── admin-scripts.js     # Admin functionality
│   │   │   ├── field-editor.js      # Drag-drop signature fields
│   │   │   └── pdf-viewer.js        # PDF preview in admin
│   │   └── public/
│   │       ├── dashboard.js          # Customer dashboard interactions
│   │       └── signing.js            # Signing page scripts
│   │
│   ├── images/
│   │   ├── logo.png                  # Plugin logo
│   │   ├── icons/                    # UI icons
│   │   └── placeholders/             # Placeholder images
│   │
│   └── vendor/                        # Third-party libraries
│       ├── pdfjs/                    # PDF.js for rendering
│       ├── fabricjs/                 # Fabric.js for field editor
│       └── signature-pad/            # Signature capture library
│
├── templates/                         # PHP templates
│   ├── admin/
│   │   ├── settings-page.php        # Settings page HTML
│   │   ├── branding-page.php        # Branding config page
│   │   ├── documents-page.php       # Document management page
│   │   └── field-editor-modal.php   # Field editor interface
│   │
│   ├── public/
│   │   ├── dashboard.php            # Customer dashboard template
│   │   ├── signing-page.php         # Signing interface template
│   │   └── thank-you.php            # Post-signing page
│   │
│   └── pdf/
│       ├── customer-data-default.php # Default customer data template
│       └── letterhead-default.php   # Default letterhead template
│
├── languages/                         # Translation files
│   ├── sign-by-authapi.pot          # Translation template
│   └── [language files]
│
└── tests/                            # Unit & integration tests
    ├── bootstrap.php                 # Test bootstrap
    ├── test-pdf-generator.php
    ├── test-libresign-client.php
    └── test-signing-workflow.php
```

### **6.3 Core Classes Explained**

#### **6.3.1 Main Plugin Class (`class-sign-plugin.php`)**

This is the entry point that initializes everything.

```php
<?php
/**
 * Main plugin class
 */
class Sign_Plugin {
    
    /**
     * Plugin version
     */
    const VERSION = '1.0.0';
    
    /**
     * Single instance
     */
    private static $instance = null;
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor - initialize plugin
     */
    private function __construct() {
        $this->load_dependencies();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $this->define_integration_hooks();
    }
    
    /**
     * Load all required classes
     */
    private function load_dependencies() {
        // Admin classes
        require_once plugin_dir_path(__FILE__) . 'admin/class-admin.php';
        require_once plugin_dir_path(__FILE__) . 'admin/class-settings.php';
        
        // Core classes
        require_once plugin_dir_path(__FILE__) . 'core/class-pdf-generator.php';
        require_once plugin_dir_path(__FILE__) . 'core/class-signing-controller.php';
        require_once plugin_dir_path(__FILE__) . 'core/class-libresign-client.php';
        
        // Public classes
        require_once plugin_dir_path(__FILE__) . 'public/class-dashboard.php';
        
        // ... load all other classes
    }
    
    /**
     * Register WordPress hooks for admin
     */
    private function define_admin_hooks() {
        $admin = new Sign_Admin();
        
        // Add menu pages
        add_action('admin_menu', array($admin, 'add_menu_pages'));
        
        // Enqueue admin scripts
        add_action('admin_enqueue_scripts', array($admin, 'enqueue_scripts'));
        
        // Register settings
        add_action('admin_init', array($admin, 'register_settings'));
    }
    
    /**
     * Register WordPress hooks for public
     */
    private function define_public_hooks() {
        $dashboard = new Sign_Dashboard();
        
        // Register dashboard page
        add_action('init', array($dashboard, 'register_dashboard_page'));
        
        // Enqueue public scripts
        add_action('wp_enqueue_scripts', array($dashboard, 'enqueue_scripts'));
    }
    
    /**
     * Register integration hooks
     */
    private function define_integration_hooks() {
        // JetFormBuilder integration
        add_action(
            'jet-form-builder/form-handler/after-send', 
            array($this, 'handle_form_submission'), 
            10, 
            2
        );
        
        // LibreSign webhook
        add_action('rest_api_init', array($this, 'register_webhook_endpoint'));
    }
    
    /**
     * Handle form submission from JetFormBuilder
     */
    public function handle_form_submission($form_data, $form) {
        $controller = new Sign_Signing_Controller();
        $controller->create_signing_request($form_data, $form);
    }
    
    /**
     * Register REST API endpoint for webhooks
     */
    public function register_webhook_endpoint() {
        register_rest_route('sign/v1', '/webhook', array(
            'methods' => 'POST',
            'callback' => array($this, 'handle_webhook'),
            'permission_callback' => '__return_true', // Verified inside callback
        ));
    }
    
    /**
     * Handle webhook from LibreSign
     */
    public function handle_webhook($request) {
        $handler = new Sign_Webhook_Handler();
        return $handler->process($request);
    }
}
```

**What this does:**

* Creates a single instance of the plugin (singleton pattern)  
* Loads all necessary class files  
* Registers WordPress hooks (actions and filters)  
* Connects form submissions to signing workflow  
* Creates API endpoint for LibreSign webhooks

---

#### **6.3.2 PDF Generator (`class-pdf-generator.php`)**

This generates PDFs from CPT data.

```php
<?php
/**
 * PDF Generator
 * Converts form data into professional PDFs
 */
class Sign_PDF_Generator {
    
    /**
     * Generate customer data PDF
     * 
     * @param int $cpt_id Post ID of the signing request
     * @param int $business_id Business ID for branding
     * @return string Path to generated PDF
     */
    public function generate_customer_data_pdf($cpt_id, $business_id) {
        // Step 1: Load data
        $cpt_data = $this->load_cpt_data($cpt_id);
        $branding = $this->load_branding($business_id);
        
        // Step 2: Check for custom letterhead
        if ($branding['has_custom_letterhead']) {
            return $this->generate_with_custom_letterhead(
                $cpt_data, 
                $branding
            );
        } else {
            return $this->generate_with_default_letterhead(
                $cpt_data, 
                $branding
            );
        }
    }
    
    /**
     * Load CPT data
     */
    private function load_cpt_data($cpt_id) {
        $post = get_post($cpt_id);
        $meta = get_post_meta($cpt_id);
        
        // Extract standard fields
        $data = array(
            'first_name' => get_post_meta($cpt_id, 'esign_first_name', true),
            'last_name' => get_post_meta($cpt_id, 'esign_last_name', true),
            'email' => get_post_meta($cpt_id, 'esign_email', true),
            'phone' => get_post_meta($cpt_id, 'esign_phone', true),
            'address' => get_post_meta($cpt_id, 'esign_address', true),
        );
        
        // Extract custom fields (anything not starting with esign_)
        $custom_fields = array();
        foreach ($meta as $key => $value) {
            if (strpos($key, 'esign_') !== 0 && strpos($key, '_') !== 0) {
                $custom_fields[$key] = is_array($value) ? $value[0] : $value;
            }
        }
        
        $data['custom_fields'] = $custom_fields;
        
        return $data;
    }
    
    /**
     * Load branding settings
     */
    private function load_branding($business_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'sign_businesses';
        
        $branding = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE id = %d",
                $business_id
            ),
            ARRAY_A
        );
        
        return $branding;
    }
    
    /**
     * Generate PDF with custom letterhead
     */
    private function generate_with_custom_letterhead($data, $branding) {
        require_once plugin_dir_path(__FILE__) . '../vendor/fpdi/autoload.php';
        
        $pdf = new \setasign\Fpdi\Fpdi();
        
        // Import letterhead PDF as first page
        $letterhead_path = $branding['letterhead_path'];
        $pageCount = $pdf->setSourceFile($letterhead_path);
        
        // Use first page of letterhead as template
        $pdf->AddPage();
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template);
        
        // Now overlay customer data on top
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(20, 80); // Position below letterhead
        
        // Add customer info
        $pdf->Write(0, 'CUSTOMER INFORMATION');
        $pdf->Ln(10);
        $pdf->Write(0, 'Name: ' . $data['first_name'] . ' ' . $data['last_name']);
        $pdf->Ln(7);
        $pdf->Write(0, 'Email: ' . $data['email']);
        $pdf->Ln(7);
        $pdf->Write(0, 'Phone: ' . $data['phone']);
        
        // Add custom fields
        if (!empty($data['custom_fields'])) {
            $pdf->Ln(15);
            $pdf->Write(0, 'INTAKE QUESTIONNAIRE');
            $pdf->Ln(10);
            
            foreach ($data['custom_fields'] as $key => $value) {
                $label = $this->format_field_label($key);
                $pdf->Write(0, $label . ': ' . $value);
                $pdf->Ln(7);
                
                // Check if we need a new page
                if ($pdf->GetY() > 250) {
                    $pdf->AddPage();
                    $pdf->SetXY(20, 20);
                }
            }
        }
        
        // Save to temp directory
        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/sign-temp/';
        if (!file_exists($temp_dir)) {
            wp_mkdir_p($temp_dir);
        }
        
        $filename = 'customer-data-' . $cpt_id . '-' . time() . '.pdf';
        $filepath = $temp_dir . $filename;
        
        $pdf->Output('F', $filepath);
        
        return $filepath;
    }
    
    /**
     * Generate PDF with default letterhead (from logo/colors)
     */
    private function generate_with_default_letterhead($data, $branding) {
        require_once plugin_dir_path(__FILE__) . '../vendor/mpdf/autoload.php';
        
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'Letter',
            'margin_top' => 40,
            'margin_bottom' => 20,
            'margin_left' => 20,
            'margin_right' => 20,
        ]);
        
        // Build HTML template
        $html = $this->build_html_template($data, $branding);
        
        // Write HTML to PDF
        $mpdf->WriteHTML($html);
        
        // Save to temp directory
        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/sign-temp/';
        if (!file_exists($temp_dir)) {
            wp_mkdir_p($temp_dir);
        }
        
        $filename = 'customer-data-' . $data['cpt_id'] . '-' . time() . '.pdf';
        $filepath = $temp_dir . $filename;
        
        $mpdf->Output($filepath, 'F');
        
        return $filepath;
    }
    
    /**
     * Build HTML template for PDF
     */
    private function build_html_template($data, $branding) {
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
                    border-bottom: 3px solid <?php echo $branding['primary_color']; ?>;
                }
                .logo {
                    max-width: 200px;
                    margin-bottom: 10px;
                }
                .company-name {
                    font-size: 24px;
                    font-weight: bold;
                    color: <?php echo $branding['primary_color']; ?>;
                }
                .section {
                    margin: 30px 0;
                }
                .section-title {
                    font-size: 18px;
                    font-weight: bold;
                    color: <?php echo $branding['primary_color']; ?>;
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
                <?php if ($branding['logo_url']): ?>
                    <img src="<?php echo $branding['logo_url']; ?>" class="logo" alt="Company Logo">
                <?php endif; ?>
                <div class="company-name"><?php echo esc_html($branding['company_name']); ?></div>
            </div>
            
            <!-- Customer Information -->
            <div class="section">
                <div class="section-title">Customer Information</div>
                <div class="field">
                    <span class="field-label">Name:</span>
                    <span class="field-value">
                        <?php echo esc_html($data['first_name'] . ' ' . $data['last_name']); ?>
                    </span>
                </div>
                <div class="field">
                    <span class="field-label">Email:</span>
                    <span class="field-value"><?php echo esc_html($data['email']); ?></span>
                </div>
                <div class="field">
                    <span class="field-label">Phone:</span>
                    <span class="field-value"><?php echo esc_html($data['phone']); ?></span>
                </div>
                <?php if (!empty($data['address'])): ?>
                <div class="field">
                    <span class="field-label">Address:</span>
                    <span class="field-value"><?php echo esc_html($data['address']); ?></span>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Custom Fields -->
            <?php if (!empty($data['custom_fields'])): ?>
            <div class="section">
                <div class="section-title">Intake Questionnaire</div>
                <?php foreach ($data['custom_fields'] as $key => $value): ?>
                <div class="field">
                    <span class="field-label">
                        <?php echo esc_html($this->format_field_label($key)); ?>:
                    </span>
                    <span class="field-value"><?php echo esc_html($value); ?></span>
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
     * Format field label (convert snake_case to Title Case)
     */
    private function format_field_label($key) {
        $label = str_replace('_', ' ', $key);
        $label = ucwords($label);
        return $label;
    }
}
```

**What this does:**

* Loads customer data from CPT  
* Loads business branding settings  
* Generates professional PDF with letterhead  
* Handles multi-page overflow automatically  
* Saves PDF to temporary directory  
* Returns file path for next step

---

#### **6.3.3 PDF Combiner (`class-pdf-combiner.php`)**

This merges multiple PDFs into one.

```php
<?php
/**
 * PDF Combiner
 * Merges customer data PDF with contract documents
 */
class Sign_PDF_Combiner {
    
    /**
     * Combine customer data PDF with contract PDFs
     * 
     * @param string $customer_pdf_path Path to customer data PDF
     * @param array $contract_pdf_paths Array of contract PDF paths
     * @param int $cpt_id For filename
     * @return string Path to combined PDF
     */
    public function combine_pdfs($customer_pdf_path, $contract_pdf_paths, $cpt_id) {
        require_once plugin_dir_path(__FILE__) . '../vendor/fpdi/autoload.php';
        
        $pdf = new \setasign\Fpdi\Fpdi();
        
        // Step 1: Add customer data PDF
        $this->add_pdf_to_combined($pdf, $customer_pdf_path);
        
        // Step 2: Add each contract PDF
        foreach ($contract_pdf_paths as $contract_path) {
            $this->add_pdf_to_combined($pdf, $contract_path);
        }
        
        // Step 3: Save combined PDF
        $upload_dir = wp_upload_dir();
        $temp_dir = $upload_dir['basedir'] . '/sign-temp/';
        
        $filename = 'combined-' . $cpt_id . '-' . time() . '.pdf';
        $filepath = $temp_dir . $filename;
        
        $pdf->Output('F', $filepath);
        
        return $filepath;
    }
    
    /**
     * Add all pages from a PDF to the combined PDF
     */
    private function add_pdf_to_combined($pdf, $source_pdf_path) {
        $pageCount = $pdf->setSourceFile($source_pdf_path);
        
        for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            $pdf->AddPage();
            $template = $pdf->importPage($pageNo);
            $pdf->useTemplate($template);
        }
    }
}
```

**What this does:**

* Takes customer data PDF  
* Takes array of contract PDFs  
* Merges them all into one document  
* Preserves all pages and formatting  
* Returns path to combined PDF

---

#### **6.3.4 LibreSign Client (`class-libresign-client.php`)**

This communicates with LibreSign API.

```php
<?php
/**
 * LibreSign API Client
 * Handles all communication with LibreSign
 */
class Sign_LibreSign_Client {
    
    private $api_url;
    private $api_key;
    
    /**
     * Constructor
     */
    public function __construct() {
        $this->api_url = get_option('sign_libresign_url');
        $this->api_key = get_option('sign_libresign_api_key');
    }
    
    /**
     * Upload PDF and create signing request
     * 
     * @param string $pdf_path Path to PDF file
     * @param string $signer_email Customer email
     * @param array $signature_fields Array of signature field coordinates
     * @param array $metadata Custom metadata (CPT ID, etc.)
     * @return array Response from LibreSign
     */
    public function create_signing_request(
        $pdf_path, 
        $signer_email, 
        $signature_fields, 
        $metadata
    ) {
        // Step 1: Upload the PDF file
        $file_uuid = $this->upload_file($pdf_path);
        
        // Step 2: Create signing request
        $response = $this->api_request('POST', '/api/v1/sign/file', array(
            'file' => array(
                'uuid' => $file_uuid,
            ),
            'users' => array(
                array(
                    'email' => $signer_email,
                    'description' => 'Customer',
                ),
            ),
            'sign_fields' => $this->format_signature_fields($signature_fields),
            'metadata' => $metadata,
            'callback' => array(
                'url' => rest_url('sign/v1/webhook'),
                'method' => 'POST',
            ),
        ));
        
        return $response;
    }
    
    /**
     * Upload PDF file to LibreSign
     */
    private function upload_file($pdf_path) {
        $response = $this->api_request('POST', '/api/v1/file', array(
            'file' => new CURLFile($pdf_path, 'application/pdf', basename($pdf_path)),
        ), true); // true = multipart/form-data
        
        return $response['uuid'];
    }
    
    /**
     * Format signature fields for LibreSign API
     */
    private function format_signature_fields($fields) {
        $formatted = array();
        
        foreach ($fields as $field) {
            $formatted[] = array(
                'type' => $field['type'], // signature, initial, date, text
                'page' => $field['page'],
                'llx' => $field['x'], // lower-left x
                'lly' => $field['y'], // lower-left y
                'urx' => $field['x'] + $field['width'], // upper-right x
                'ury' => $field['y'] + $field['height'], // upper-right y
                'required' => $field['required'],
            );
        }
        
        return $formatted;
    }
    
    /**
     * Download signed PDF from LibreSign
     */
    public function download_signed_pdf($document_uuid) {
        $response = $this->api_request('GET', "/api/v1/file/{$document_uuid}/signed");
        
        // Save to uploads directory
        $upload_dir = wp_upload_dir();
        $signed_dir = $upload_dir['basedir'] . '/sign-signed/';
        if (!file_exists($signed_dir)) {
            wp_mkdir_p($signed_dir);
        }
        
        $filename = 'signed-' . $document_uuid . '.pdf';
        $filepath = $signed_dir . $filename;
        
        file_put_contents($filepath, $response);
        
        return $filepath;
    }
    
    /**
     * Download certificate from LibreSign
     */
    public function download_certificate($document_uuid) {
        $response = $this->api_request('GET', "/api/v1/file/{$document_uuid}/certificate");
        
        $upload_dir = wp_upload_dir();
        $signed_dir = $upload_dir['basedir'] . '/sign-signed/';
        
        $filename = 'certificate-' . $document_uuid . '.pdf';
        $filepath = $signed_dir . $filename;
        
        file_put_contents($filepath, $response);
        
        return $filepath;
    }
    
    /**
     * Make API request to LibreSign
     */
    private function api_request($method, $endpoint, $data = array(), $multipart = false) {
        $url = $this->api_url . $endpoint;
        
        $args = array(
            'method' => $method,
            'headers' => array(
                'Authorization' => 'Bearer ' . $this->api_key,
            ),
            'timeout' => 60,
        );
        
        if ($method === 'POST' || $method === 'PUT') {
            if ($multipart) {
                // For file uploads
                $args['body'] = $data;
            } else {
                $args['headers']['Content-Type'] = 'application/json';
                $args['body'] = json_encode($data);
            }
        }
        
        $response = wp_remote_request($url, $args);
        
        if (is_wp_error($response)) {
            throw new Exception('LibreSign API Error: ' . $response->get_error_message());
        }
        
        $body = wp_remote_retrieve_body($response);
        $status_code = wp_remote_retrieve_response_code($response);
        
        if ($status_code < 200 || $status_code >= 300) {
            throw new Exception('LibreSign API Error: ' . $body);
        }
        
        return json_decode($body, true);
    }
}
```

**What this does:**

* Uploads PDF to LibreSign  
* Creates signing request with fields  
* Stores metadata (CPT ID)  
* Sets webhook URL  
* Downloads signed PDF later  
* Downloads certificate

---

#### **6.3.5 Signing Controller (`class-signing-controller.php`)**

This orchestrates the entire workflow.

```php
<?php
/**
 * Signing Controller
 * Orchestrates the entire signing workflow
 */
class Sign_Signing_Controller {
    
    /**
     * Create signing request from form submission
     * This is called when JetFormBuilder form is submitted
     */
    public function create_signing_request($form_data, $form) {
        try {
            // Step 1: Extract business ID (from form meta or user)
            $business_id = $this->get_business_id($form);
            
            // Step 2: Create or update CPT
            $cpt_id = $this->create_or_update_cpt($form_data, $business_id);
            
            // Step 3: Set initial status
            update_post_meta($cpt_id, 'esign_signing_status', 'incomplete');
            
            // Step 4: Generate unique token for this signing request
            $token = $this->generate_token($cpt_id);
            update_post_meta($cpt_id, 'esign_token', $token);
            
            // Step 5: Send notification email
            $this->send_initial_email($cpt_id, $token);
            
            // Step 6: Redirect to dashboard (or custom URL)
            $dashboard_url = home_url('/signing-dashboard/');
            wp_redirect($dashboard_url . '?token=' . $token);
            exit;
            
        } catch (Exception $e) {
            // Log error
            error_log('Sign Plugin Error: ' . $e->getMessage());
            
            // Show user-friendly message
            wp_die('Sorry, there was an error processing your request. Please try again.');
        }
    }
    
    /**
     * Generate PDF and send to LibreSign
     * This is called when customer clicks "Sign Now"
     */
    public function initiate_signing($cpt_id) {
        try {
            // Step 1: Verify CPT exists and status is incomplete
            $status = get_post_meta($cpt_id, 'esign_signing_status', true);
            if ($status === 'complete') {
                throw new Exception('This document has already been signed.');
            }
            
            // Step 2: Get business ID
            $business_id = get_post_meta($cpt_id, 'esign_business_id', true);
            
            // Step 3: Generate customer data PDF
            $pdf_generator = new Sign_PDF_Generator();
            $customer_pdf = $pdf_generator->generate_customer_data_pdf($cpt_id, $business_id);
            
            // Step 4: Get contract PDFs
            $contract_pdfs = $this->get_contract_pdfs($business_id);
            
            // Step 5: Combine all PDFs
            $pdf_combiner = new Sign_PDF_Combiner();
            $combined_pdf = $pdf_combiner->combine_pdfs(
                $customer_pdf, 
                $contract_pdfs, 
                $cpt_id
            );
            
            // Step 6: Get signature fields
            $signature_fields = $this->get_signature_fields($business_id);
            
            // Step 7: Get customer email
            $customer_email = get_post_meta($cpt_id, 'esign_email', true);
            
            // Step 8: Send to LibreSign
            $libresign = new Sign_LibreSign_Client();
            $response = $libresign->create_signing_request(
                $combined_pdf,
                $customer_email,
                $signature_fields,
                array(
                    'cpt_id' => $cpt_id,
                    'business_id' => $business_id,
                )
            );
            
            // Step 9: Store LibreSign document UUID
            update_post_meta($cpt_id, 'esign_libresign_uuid', $response['uuid']);
            
            // Step 10: Redirect to LibreSign signing URL
            wp_redirect($response['signing_url']);
            exit;
            
        } catch (Exception $e) {
            error_log('Sign Plugin Error: ' . $e->getMessage());
            wp_die('Sorry, there was an error. Please try again.');
        }
    }
    
    /**
     * Create or update CPT with form data
     */
    private function create_or_update_cpt($form_data, $business_id) {
        // Check if CPT already exists for this user
        $user_id = get_current_user_id();
        $email = $form_data['email'];
        
        $existing = get_posts(array(
            'post_type' => 'sign_request',
            'meta_query' => array(
                array(
                    'key' => 'esign_email',
                    'value' => $email,
                ),
                array(
                    'key' => 'esign_business_id',
                    'value' => $business_id,
                ),
            ),
            'posts_per_page' => 1,
        ));
        
        if (!empty($existing)) {
            $cpt_id = $existing[0]->ID;
        } else {
            // Create new CPT
            $cpt_id = wp_insert_post(array(
                'post_type' => 'sign_request',
                'post_title' => $form_data['first_name'] . ' ' . $form_data['last_name'],
                'post_status' => 'publish',
                'post_author' => $user_id,
            ));
        }
        
        // Save all form data as post meta
        foreach ($form_data as $key => $value) {
            update_post_meta($cpt_id, 'esign_' . $key, sanitize_text_field($value));
        }
        
        // Save business ID
        update_post_meta($cpt_id, 'esign_business_id', $business_id);
        
        return $cpt_id;
    }
    
    /**
     * Get contract PDFs for business
     */
    private function get_contract_pdfs($business_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'sign_documents';
        
        $documents = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT file_path FROM $table 
                WHERE business_id = %d 
                ORDER BY sequence ASC",
                $business_id
            )
        );
        
        $paths = array();
        foreach ($documents as $doc) {
            $paths[] = $doc->file_path;
        }
        
        return $paths;
    }
    
    /**
     * Get signature fields for all documents
     */
    private function get_signature_fields($business_id) {
        global $wpdb;
        $table = $wpdb->prefix . 'sign_fields';
        
        $fields = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM $table WHERE business_id = %d ORDER BY page ASC",
                $business_id
            ),
            ARRAY_A
        );
        
        return $fields;
    }
    
    /**
     * Generate unique token
     */
    private function generate_token($cpt_id) {
        return wp_hash($cpt_id . time() . wp_rand());
    }
    
    /**
     * Send initial notification email
     */
    private function send_initial_email($cpt_id, $token) {
        $email_manager = new Sign_Email_Manager();
        $email_manager->send_signing_invitation($cpt_id, $token);
    }
}
```

**What this does:**

* Handles form submission  
* Creates/updates CPT  
* Generates complete PDF package  
* Sends to LibreSign  
* Manages workflow state  
* Handles errors gracefully

---

## **7\. Feature Specifications**

### **7.1 Admin Dashboard Features**

#### **7.1.1 Branding Configuration**

**Location:** WP Admin → Sign → Branding

**Fields:**

* **Company Logo** (image upload, max 2MB, PNG/JPG)  
* **Primary Color** (color picker, hex code)  
* **Secondary Color** (color picker, hex code)  
* **Accent Color** (color picker, hex code)  
* **Company Name** (text, max 100 chars)  
* **Authorized Representative** (text, max 100 chars)  
* **Representative Title** (text, max 100 chars)  
* **Company Email** (email validation)  
* **Company Phone** (phone validation)  
* **Company Address** (textarea, max 500 chars)  
* **Custom PDF Letterhead** (PDF upload, max 5MB, optional)

**Validation:**

* Logo must be PNG or JPG  
* Colors must be valid hex codes  
* Email must be valid format  
* All required fields must be filled before activation

**Save Behavior:**

* Save to `wp_options` table with prefix `sign_branding_`  
* Show success message  
* Preview button shows sample PDF

---

#### **7.1.2 Document Management**

**Location:** WP Admin → Sign → Documents

**Interface:**

```
┌──────────────────────────────────────────────────────┐
│ Documents                             [+ Add Document]│
├──────────────────────────────────────────────────────┤
│                                                       │
│  📄 Service Agreement.pdf                            │
│     Sequence: 1  |  Fields: 3 configured             │
│     [Edit Fields] [Delete]                           │
│                                                       │
│  📄 Privacy Policy.pdf                               │
│     Sequence: 2  |  Fields: 1 configured             │
│     [Edit Fields] [Delete]                           │
│                                                       │
│  📄 Terms of Service.pdf                             │
│     Sequence: 3  |  Fields: 2 configured             │
│     [Edit Fields] [Delete]                           │
│                                                       │
└──────────────────────────────────────────────────────┘
```

**Upload Process:**

1. Click "+ Add Document"  
2. Upload PDF (max 10MB)  
3. Enter document name  
4. Set sequence number (for ordering)  
5. Click "Upload"  
6. Redirected to Field Editor

**Field Editor:**

Opens in modal with PDF preview:

```
┌─────────────────────────────────────────────────────────────┐
│ Edit Signature Fields: Service Agreement.pdf               │
├─────────────────────────────────────────────────────────────┤
│                                                              │
│  Toolbar:                                                   │
│  [+ Signature] [+ Initial] [+ Date] [+ Text Field]         │
│                                                              │
│  ┌────────────────────────────────────────────────────┐   │
│  │                                                     │   │
│  │            [PDF Preview - Page 1]                  │   │
│  │                                                     │   │
│  │                                                     │   │
│  │                                                     │   │
│  │                                                     │   │
│  │  ╔════════════════╗  ╔═══════╗                   │   │
│  │  ║ Signature     ║  ║ Date ║                   │   │
│  │  ╚════════════════╝  ╚═══════╝                   │   │
│  └────────────────────────────────────────────────────┘   │
│                                                              │
│  Pages: [1] [2] [3] [4] [5]                                │
│                                                              │
│  Configured Fields:                                         │
│  ┌──────────────────────────────────────────────────────┐ │
│  │ ✓ Signature (Page 5, Position: 100x650)             │ │
│  │   Type: Signature | Required: Yes                    │ │
│  │   [Edit] [Delete]                                     │ │
│  │                                                       │ │
│  │ ✓ Date (Page 5, Position: 320x650)                  │ │
│  │   Type: Date | Required: Yes                         │ │
│  │   [Edit] [Delete]                                     │ │
│  └──────────────────────────────────────────────────────┘ │
│                                                              │
│  [Save Fields]  [Preview Signing Experience]  [Cancel]     │
└─────────────────────────────────────────────────────────────┘
```

**How Field Editor Works:**

1. PDF.js renders PDF pages  
2. Admin clicks "Add Signature" button  
3. Crosshair cursor appears  
4. Admin clicks on PDF where signature should go  
5. Modal pops up:

```
Field Type: [Signature ▼]Label: [____________]Required: [☑]Width: [200px]Height: [50px][Add Field]
```

6. Field appears as colored box on PDF  
7. Admin can drag to reposition, resize handles on corners  
8. Click "Save Fields" → stores in database

**Database Storage:**

```
Table: wp_sign_fields
Columns:
- id (INT, auto_increment)
- business_id (INT)
- document_id (INT)
- type (VARCHAR: signature|initial|date|text)
- label (VARCHAR)
- page (INT)
- x (INT, pixels from left)
- y (INT, pixels from top)
- width (INT, pixels)
- height (INT, pixels)
- required (BOOLEAN)
- created_at (DATETIME)
```

---

#### **7.1.3 LibreSign Settings**

**Location:** WP Admin → Sign → Settings → LibreSign

**Fields:**

* **LibreSign URL** (text, required, validates URL format)  
  * Example: `https://libresign.yourserver.com`  
* **API Key** (password field, required)  
  * Hidden with dots, "Show/Hide" toggle  
* **Test Connection** (button)  
  * Makes test API call, shows success/error

**Connection Test:**

```php
public function test_libresign_connection() {
    $client = new Sign_LibreSign_Client();
    try {
        $response = $client->api_request('GET', '/api/v1/status');
        wp_send_json_success('Connection successful!');
    } catch (Exception $e) {
        wp_send_json_error('Connection failed: ' . $e->getMessage());
    }
}
```

---

#### **7.1.4 Activation Toggle**

**Location:** WP Admin → Sign → Settings → General

**Status Indicator:**

```
System Status: ○ Inactive  |  ● Active

[Toggle to Active]

Requirements Checklist:
☑ Branding configured
☑ At least one document uploaded
☑ Signature fields configured
☑ LibreSign connected
☐ JetFormBuilder form connected (optional)

[Activate System]
```

**Activation Logic:**

* Checks all requirements  
* If all met, enables hooks  
* If not, shows which are missing  
* Once active, system processes form submissions

---

### **7.2 Customer-Facing Features**

#### **7.2.1 Signing Dashboard**

**URL:** `yoursite.com/signing-dashboard/`

**Authentication:**

* Via unique token (sent in email)  
* OR via WordPress login (if user is logged in)

**Dashboard UI:**

```
┌──────────────────────────────────────────────────────────┐
│  [Logo]                                    Welcome, John! │
│  Sign by authAPI.net                                      │
├──────────────────────────────────────────────────────────┤
│                                                            │
│  Pending Signatures                                       │
│                                                            │
│  ┌────────────────────────────────────────────────────┐  │
│  │ 📄 Service Agreement & Contracts                   │  │
│  │    Created: October 19, 2025                        │  │
│  │    Status: Awaiting Your Signature                  │  │
│  │                                                      │  │
│  │    [Review & Sign] [Download Draft]                 │  │
│  └────────────────────────────────────────────────────┘  │
│                                                            │
│  Completed Signatures                                     │
│                                                            │
│  ┌────────────────────────────────────────────────────┐  │
│  │ ✅ Initial Consultation Agreement                   │  │
│  │    Signed: October 15, 2025                         │  │
│  │                                                      │  │
│  │    [Download Signed] [Download Certificate]         │  │
│  └────────────────────────────────────────────────────┘  │
│                                                            │
└──────────────────────────────────────────────────────────┘
```

**PHP Code:**

```php
public function render_dashboard() {
    // Get current user
    $user_id = get_current_user_id();
    
    // OR get by token
    if (isset($_GET['token'])) {
        $token = sanitize_text_field($_GET['token']);
        $cpt_id = $this->get_cpt_by_token($token);
        if (!$cpt_id) {
            wp_die('Invalid token');
        }
    }
    
    // Query incomplete documents
    $incomplete = get_posts(array(
        'post_type' => 'sign_request',
        'author' => $user_id,
        'meta_query' => array(
            array(
                'key' => 'esign_signing_status',
                'value' => 'incomplete',
            ),
        ),
    ));
    
    // Query complete documents
    $complete = get_posts(array(
        'post_type' => 'sign_request',
        'author' => $user_id,
        'meta_query' => array(
            array(
                'key' => 'esign_signing_status',
                'value' => 'complete',
            ),
        ),
    ));
    
    // Load template
    include plugin_dir_path(__FILE__) . '../templates/public/dashboard.php';
}
```

---

#### **7.2.2 Signing Interface**

**Flow:**

1. Customer clicks "Review & Sign" on dashboard  
2. Plugin generates PDF (on-the-fly)  
3. Combines with contracts  
4. Sends to LibreSign  
5. Redirects to LibreSign signing page

**LibreSign Interface** (external, not controlled by plugin):

* Shows PDF with highlighted signature fields  
* Customer signs/initials/dates  
* Submits

**Then:**

* LibreSign webhook fires  
* Plugin receives notification  
* Updates CPT status  
* Sends emails  
* Redirects customer back to dashboard

---

#### **7.2.3 Email Notifications**

**Email 1: Initial Invitation**

Sent immediately after form submission.

**Subject:** `Please sign your documents - [Company Name]`

**Body:**

```html
<!DOCTYPE html>
<html>
<body style="font-family: Arial, sans-serif;">
    <div style="max-width: 600px; margin: 0 auto;">
        <img src="[Company Logo]" alt="[Company Name]" style="max-width: 200px;">
        
        <h1>Thank you for your submission!</h1>
        
        <p>Hi [Customer Name],</p>
        
        <p>Thank you for completing our intake form. The next step is to review and sign your documents.</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="[Dashboard URL]" style="background: #007bff; color: white; padding: 15px 30px; text-decoration: none; border-radius: 5px; display: inline-block;">
                Review & Sign Documents
            </a>
        </p>
        
        <p>This should only take 2-3 minutes.</p>
        
        <p>If you have any questions, please reply to this email or call us at [Company Phone].</p>
        
        <p>Best regards,<br>
        [Company Name]</p>
    </div>
</body>
</html>
```

---

**Email 2: Reminder** (if not signed within 24 hours)

**Subject:** `Reminder: Please sign your documents - [Company Name]`

**Body:**

```html
<p>Hi [Customer Name],</p>

<p>This is a friendly reminder that you have documents waiting for your signature.</p>

<p style="text-align: center;">
    <a href="[Dashboard URL]">Sign Documents Now</a>
</p>

<p>If you've already signed, please disregard this email.</p>
```

---

**Email 3: Completion Confirmation**

**Subject:** `Your documents have been signed successfully - [Company Name]`

**Body:**

```html
<p>Hi [Customer Name],</p>

<p>Great news! Your documents have been successfully signed.</p>

<p>Attached to this email, you'll find:</p>
<ul>
    <li>Signed contract (PDF)</li>
    <li>Verification certificate (PDF)</li>
</ul>

<p>These documents are legally binding and include:</p>
<ul>
    <li>Digital signatures</li>
    <li>Timestamp of signing</li>
    <li>IP address verification</li>
    <li>Cryptographic proof</li>
</ul>

<p>You can also download these documents anytime from your <a href="[Dashboard URL]">dashboard</a>.</p>

<p>Thank you!</p>
```

**Attachments:**

* Signed PDF  
* Certificate PDF

---

**Email 4: Admin Notification**

Sent to business owner when document is signed.

**Subject:** `New signed contract from [Customer Name]`

**Body:**

```html
<p>A new contract has been signed by [Customer Name].</p>

<p><strong>Customer Details:</strong></p>
<ul>
    <li>Name: [Customer Name]</li>
    <li>Email: [Customer Email]</li>
    <li>Phone: [Customer Phone]</li>
    <li>Signed: [Timestamp]</li>
</ul>

<p><a href="[Admin View URL]">View in Dashboard</a></p>

<p>Signed documents are attached.</p>
```

---

## **8\. Database Schema**

### **8.1 Custom Post Type**

**Post Type:** `sign_request`

**Why CPT?**

* Native WordPress functionality  
* Easy to query  
* Works with existing WordPress tools  
* User association built-in  
* Revision history

**Registration:**

```php
register_post_type('sign_request', array(
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => 'sign-plugin',
    'supports' => array('title'),
    'labels' => array(
        'name' => 'Signing Requests',
        'singular_name' => 'Signing Request',
    ),
));
```

**Post Meta Fields:**

```
esign_first_name (VARCHAR)
esign_last_name (VARCHAR)
esign_email (VARCHAR)
esign_phone (VARCHAR)
esign_address_line1 (VARCHAR)
esign_address_line2 (VARCHAR)
esign_city (VARCHAR)
esign_state (VARCHAR)
esign_zip (VARCHAR)
esign_business_id (INT)
esign_signing_status (VARCHAR: incomplete|complete)
esign_token (VARCHAR)
esign_libresign_uuid (VARCHAR)
esign_signed_pdf_url (VARCHAR)
esign_certificate_url (VARCHAR)
esign_signed_date (DATETIME)
esign_signer_ip (VARCHAR)
[custom_field_1] (VARCHAR)
[custom_field_2] (TEXT)
[custom_field_n] (...)
```

---

### **8.2 Custom Tables**

#### **Table 1: Businesses**

```sql
CREATE TABLE {$wpdb->prefix}sign_businesses (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    logo_url VARCHAR(500),
    letterhead_path VARCHAR(500),
    primary_color VARCHAR(7) DEFAULT '#007bff',
    secondary_color VARCHAR(7) DEFAULT '#6c757d',
    accent_color VARCHAR(7) DEFAULT '#28a745',
    company_name VARCHAR(255),
    authorized_rep VARCHAR(255),
    rep_title VARCHAR(255),
    company_email VARCHAR(255),
    company_phone VARCHAR(50),
    company_address TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) {$charset_collate};
```

**Purpose:** Store business configuration for multi-tenant support

---

#### **Table 2: Documents**

```sql
CREATE TABLE {$wpdb->prefix}sign_documents (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    business_id BIGINT(20) UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    file_path VARCHAR(500) NOT NULL,
    sequence INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY business_id (business_id),
    KEY sequence (sequence)
) {$charset_collate};
```

**Purpose:** Store uploaded contract PDFs

---

#### **Table 3: Signature Fields**

```sql
CREATE TABLE {$wpdb->prefix}sign_fields (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    business_id BIGINT(20) UNSIGNED NOT NULL,
    document_id BIGINT(20) UNSIGNED NOT NULL,
    type ENUM('signature', 'initial', 'date', 'text') NOT NULL,
    label VARCHAR(255),
    page INT NOT NULL,
    x INT NOT NULL,
    y INT NOT NULL,
    width INT NOT NULL,
    height INT NOT NULL,
    required BOOLEAN DEFAULT TRUE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY business_id (business_id),
    KEY document_id (document_id)
) {$charset_collate};
```

**Purpose:** Store signature field coordinates for each document

---

#### **Table 4: Activity Log (Optional, for debugging)**

```sql
CREATE TABLE {$wpdb->prefix}sign_activity_log (
    id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    cpt_id BIGINT(20) UNSIGNED NOT NULL,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY cpt_id (cpt_id),
    KEY action (action),
    KEY created_at (created_at)
) {$charset_collate};
```

**Purpose:** Track signing workflow for debugging and auditing

**Actions:**

* `request_created`  
* `pdf_generated`  
* `sent_to_libresign`  
* `customer_opened`  
* `customer_signed`  
* `webhook_received`  
* `status_updated`  
* `email_sent`

---

## **9\. Development Phases**

### **Phase 1: Foundation (Week 1-2)**

**Deliverables:**

* Plugin scaffold with file structure  
* Database tables created  
* CPT registered  
* Admin menu pages (empty)  
* Basic settings page

**Testing:**

* Plugin activates without errors  
* Tables created successfully  
* CPT appears in admin  
* Settings page loads

---

### **Phase 2: Admin UI (Week 3-4)**

**Deliverables:**

* Branding configuration page (functional)  
* Document upload page (functional)  
* Basic field editor (can add fields manually)  
* Settings saved to database

**Testing:**

* Upload logo, save branding  
* Upload PDF document  
* Save settings and verify in database  
* Preview branding settings

---

### **Phase 3: PDF Generation (Week 5-6)**

**Deliverables:**

* PDF Generator class (complete)  
* Letterhead rendering (both custom and generated)  
* Data-to-PDF conversion  
* Multi-page overflow handling  
* PDF Combiner class

**Testing:**

* Generate test PDF from sample data  
* Verify letterhead appears correctly  
* Test with long text (multi-page)  
* Combine multiple PDFs

---

### **Phase 4: LibreSign Integration (Week 7-8)**

**Deliverables:**

* LibreSign API client (complete)  
* File upload to LibreSign  
* Signature request creation  
* Webhook endpoint  
* Webhook handler

**Testing:**

* Upload PDF to LibreSign successfully  
* Create signing request with fields  
* Receive webhook after signing  
* Update CPT status correctly

---

### **Phase 5: Workflow Orchestration (Week 9-10)**

**Deliverables:**

* Signing Controller (complete)  
* JetFormBuilder integration  
* Customer dashboard page  
* Token authentication  
* Status tracking

**Testing:**

* Submit form → Creates CPT  
* Dashboard shows pending docs  
* Click "Sign" → Generates PDF → LibreSign  
* After signing → Status updates

---

### **Phase 6: Email System (Week 11-12)**

**Deliverables:**

* Email Manager class  
* Email templates (all 4 types)  
* Reminder cron job  
* Attachment handling

**Testing:**

* Receive initial email after form submission  
* Receive reminder after 24 hours  
* Receive completion email with attachments  
* Admin receives notification

---

### **Phase 7: Visual Field Editor (Week 13-14)**

**Deliverables:**

* PDF.js integration  
* Fabric.js drag-drop interface  
* Field configuration modal  
* Save/load field coordinates

**Testing:**

* Load PDF in editor  
* Add signature field via click-drag  
* Resize and reposition fields  
* Save and reload fields

---

### **Phase 8: Polish & Testing (Week 15-16)**

**Deliverables:**

* Error handling everywhere  
* Input validation and sanitization  
* Security hardening  
* User documentation  
* Unit tests  
* Integration tests

**Testing:**

* Complete end-to-end workflow  
* Test error scenarios  
* Test with real LibreSign instance  
* Security audit

---

### **Phase 9: Launch Prep (Week 17-18)**

**Deliverables:**

* WordPress.org submission preparation  
* README.txt for plugin directory  
* Screenshots  
* Demo video  
* Marketing materials

---

## **10\. Technical Stack & Dependencies**

### **10.1 Core WordPress**

**Minimum Requirements:**

* WordPress 6.0+  
* PHP 7.4+  
* MySQL 5.7+ or MariaDB 10.2+

---

### **10.2 PHP Libraries (Composer)**

**Install via Composer:**

```json
{
    "require": {
        "mpdf/mpdf": "^8.1",
        "setasign/fpdi": "^2.3",
        "phpmailer/phpmailer": "^6.6"
    }
}
```

**Libraries:**

1. **mPDF** (`mpdf/mpdf`)

   * Purpose: Generate PDFs from HTML  
   * License: GPLv2+  
   * Use: Generate customer data page with letterhead  
2. **FPDI** (`setasign/fpdi`)

   * Purpose: Import and manipulate existing PDFs  
   * License: MIT  
   * Use: Combine generated PDF with uploaded contracts  
3. **PHPMailer** (`phpmailer/phpmailer`)

   * Purpose: Send emails with attachments  
   * License: LGPL 2.1  
   * Use: Send notification emails

---

### **10.3 JavaScript Libraries (npm)**

**Install via npm:**

```json
{
    "dependencies": {
        "pdfjs-dist": "^3.11.174",
        "fabric": "^5.3.0",
        "signature_pad": "^4.1.5"
    },
    "devDependencies": {
        "webpack": "^5.88.0",
        "webpack-cli": "^5.1.4",
        "@babel/core": "^7.22.0",
        "@babel/preset-env": "^7.22.0",
        "babel-loader": "^9.1.2"
    }
}
```

**Libraries:**

1. **PDF.js** (`pdfjs-dist`)

   * Purpose: Render PDFs in browser  
   * License: Apache 2.0  
   * Use: Display PDF preview in field editor  
2. **Fabric.js** (`fabric`)

   * Purpose: Canvas manipulation  
   * License: MIT  
   * Use: Drag-drop signature fields on PDF  
3. **Signature Pad** (`signature_pad`)

   * Purpose: Capture drawn signatures  
   * License: MIT  
   * Use: Future feature (capture signature in WordPress)

---

### **10.4 Build Process**

**Webpack Configuration:**

```javascript
// webpack.config.js
module.exports = {
    entry: {
        'admin': './assets/js/admin/admin-scripts.js',
        'field-editor': './assets/js/admin/field-editor.js',
        'dashboard': './assets/js/public/dashboard.js',
    },
    output: {
        filename: '[name].bundle.js',
        path: __dirname + '/assets/dist/',
    },
    module: {
        rules: [
            {
                test: /\.js$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                },
            },
        ],
    },
};
```

**Build Commands:**

```shell
# Install dependencies
npm install
composer install

# Build for production
npm run build

# Watch for changes during development
npm run watch
```

---

## **11\. API Integrations**

### **11.1 LibreSign API**

**Base URL:** `https://your-libresign-instance.com/api/v1`

**Authentication:** Bearer token in header

#### **Endpoint 1: Upload File**

```
POST /api/v1/file
Content-Type: multipart/form-data
Authorization: Bearer {api_key}

Body:
- file: (binary PDF data)

Response:
{
    "uuid": "abc123-def456-ghi789",
    "name": "document.pdf",
    "size": 123456,
    "created_at": "2025-10-19T10:30:00Z"
}
```

#### **Endpoint 2: Create Signing Request**

```
POST /api/v1/sign/file
Content-Type: application/json
Authorization: Bearer {api_key}

Body:
{
    "file": {
        "uuid": "abc123-def456-ghi789"
    },
    "users": [
        {
            "email": "customer@example.com",
            "description": "Customer"
        }
    ],
    "sign_fields": [
        {
            "type": "signature",
            "page": 1,
            "llx": 100,
            "lly": 100,
            "urx": 300,
            "ury": 150,
            "required": true
        }
    ],
    "metadata": {
        "cpt_id": 456,
        "business_id": 1
    },
    "callback": {
        "url": "https://yoursite.com/wp-json/sign/v1/webhook",
        "method": "POST"
    }
}

Response:
{
    "uuid": "sign-request-uuid",
    "status": "pending",
    "signing_url": "https://libresign.com/sign/abc123",
    "created_at": "2025-10-19T10:35:00Z"
}
```

#### **Endpoint 3: Get Signed PDF**

```
GET /api/v1/file/{uuid}/signed
Authorization: Bearer {api_key}

Response: Binary PDF data
```

#### **Endpoint 4: Get Certificate**

```
GET /api/v1/file/{uuid}/certificate
Authorization: Bearer {api_key}

Response: Binary PDF data
```

#### **Webhook Payload (sent by LibreSign to WordPress)**

```json
{
    "event": "document_signed",
    "uuid": "sign-request-uuid",
    "document_uuid": "doc-uuid",
    "signed_at": "2025-10-19T10:45:00Z",
    "signer": {
        "email": "customer@example.com",
        "name": "John Smith"
    },
    "signature_details": {
        "ip_address": "192.168.1.100",
        "user_agent": "Mozilla/5.0...",
        "geolocation": "New York, US"
    },
    "signed_pdf_url": "https://libresign.com/download/signed-abc123.pdf",
    "certificate_url": "https://libresign.com/download/cert-abc123.pdf",
    "metadata": {
        "cpt_id": 456,
        "business_id": 1
    }
}
```

**Webhook Verification:**

LibreSign signs webhooks with HMAC. Verify:

```php
public function verify_webhook_signature($payload, $signature) {
    $secret = get_option('sign_libresign_webhook_secret');
    $expected = hash_hmac('sha256', $payload, $secret);
    return hash_equals($expected, $signature);
}
```

---

### **11.2 JetFormBuilder Integration**

**Hook:** `jet-form-builder/form-handler/after-send`

**Parameters:**

* `$form_data` (array): Submitted form fields  
* `$form` (object): Form instance

**Example:**

```php
add_action(
    'jet-form-builder/form-handler/after-send',
    function($form_data, $form) {
        // Only process if this form is configured for signing
        $form_id = $form->get_id();
        $sign_enabled = get_post_meta($form_id, 'sign_enabled', true);
        
        if (!$sign_enabled) {
            return;
        }
        
        // Create signing request
        $controller = new Sign_Signing_Controller();
        $controller->create_signing_request($form_data, $form);
    },
    10,
    2
);
```

**Form Configuration:**

Add metabox to JetFormBuilder forms:

```php
add_action('add_meta_boxes', function() {
    add_meta_box(
        'sign-jetform-config',
        'Sign Configuration',
        'render_jetform_config_box',
        'jet-form-builder',
        'side'
    );
});

function render_jetform_config_box($post) {
    $enabled = get_post_meta($post->ID, 'sign_enabled', true);
    $business_id = get_post_meta($post->ID, 'sign_business_id', true);
    ?>
    <label>
        <input type="checkbox" name="sign_enabled" value="1" <?php checked($enabled, 1); ?>>
        Enable signing for this form
    </label>
    
    <label>
        Business:
        <select name="sign_business_id">
            <?php
            global $wpdb;
            $businesses = $wpdb->get_results("SELECT id, name FROM {$wpdb->prefix}sign_businesses");
            foreach ($businesses as $biz) {
                echo '<option value="' . $biz->id . '" ' . selected($business_id, $biz->id, false) . '>';
                echo esc_html($biz->name);
                echo '</option>';
            }
            ?>
        </select>
    </label>
    <?php
}
```

---

## **12\. Security Requirements**

### **12.1 Input Validation & Sanitization**

**All user inputs MUST be:**

1. Validated (correct type, format, range)  
2. Sanitized (remove harmful characters)  
3. Escaped (before output)

**Examples:**

```php
// Text input
$company_name = sanitize_text_field($_POST['company_name']);

// Email
$email = sanitize_email($_POST['email']);
if (!is_email($email)) {
    wp_die('Invalid email');
}

// URL
$url = esc_url_raw($_POST['url']);

// HTML (very careful!)
$html = wp_kses_post($_POST['html']); // Only safe HTML tags

// SQL queries (use prepared statements)
$wpdb->prepare("SELECT * FROM table WHERE id = %d", $id);

// Output escaping
echo esc_html($user_input); // Text
echo esc_url($url); // URL
echo esc_attr($attribute); // HTML attribute
```

---

### **12.2 Authentication & Authorization**

**User Permissions:**

```php
// Check if user can manage plugin
if (!current_user_can('manage_options')) {
    wp_die('Insufficient permissions');
}

// Check nonce for form submissions
if (!wp_verify_nonce($_POST['_wpnonce'], 'sign_save_settings')) {
    wp_die('Security check failed');
}
```

**Token-Based Access:**

For dashboard access without login:

```php
// Generate token
$token = wp_hash($cpt_id . time() . wp_rand());
update_post_meta($cpt_id, 'esign_token', $token);
update_post_meta($cpt_id, 'esign_token_expires', time() + (7 * DAY_IN_SECONDS));

// Validate token
function validate_token($token) {
    $args = array(
        'post_type' => 'sign_request',
        'meta_query' => array(
            array(
                'key' => 'esign_token',
                'value' => $token,
            ),
        ),
    );
    
    $posts = get_posts($args);
    if (empty($posts)) {
        return false;
    }
    
    $cpt_id = $posts[0]->ID;
    $expires = get_post_meta($cpt_id, 'esign_token_expires', true);
    
    if (time() > $expires) {
        return false; // Token expired
    }
    
    return $cpt_id;
}
```

---

### **12.3 Webhook Security**

**Verify LibreSign Webhooks:**

```php
public function handle_webhook($request) {
    // Get signature from header
    $signature = $request->get_header('X-LibreSign-Signature');
    
    // Get raw body
    $payload = $request->get_body();
    
    // Verify signature
    if (!$this->verify_webhook_signature($payload, $signature)) {
        return new WP_Error('invalid_signature', 'Invalid webhook signature', array('status' => 401));
    }
    
    // Process webhook
    $data = json_decode($payload, true);
    // ... process data
}

private function verify_webhook_signature($payload, $signature) {
    $secret = get_option('sign_libresign_webhook_secret');
    $expected = hash_hmac('sha256', $payload, $secret);
    return hash_equals($expected, $signature);
}
```

---

### **12.4 File Upload Security**

**Validate uploaded files:**

```php
// Check file type
$allowed_types = array('application/pdf', 'image/png', 'image/jpeg');
$file_type = wp_check_filetype($_FILES['file']['name']);

if (!in_array($file_type['type'], $allowed_types)) {
    wp_die('Invalid file type');
}

// Check file size (max 10MB)
$max_size = 10 * 1024 * 1024; // 10MB in bytes
if ($_FILES['file']['size'] > $max_size) {
    wp_die('File too large');
}

// Use WordPress upload handler
$upload = wp_handle_upload($_FILES['file'], array('test_form' => false));

if (isset($upload['error'])) {
    wp_die($upload['error']);
}

// Store file path securely
$file_path = $upload['file'];
```

---

### **12.5 Data Encryption**

**Encrypt sensitive data:**

```php
// Encrypt API key before storing
function encrypt_api_key($api_key) {
    $key = wp_salt('auth');
    return openssl_encrypt($api_key, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
}

// Decrypt when needed
function decrypt_api_key($encrypted) {
    $key = wp_salt('auth');
    return openssl_decrypt($encrypted, 'AES-256-CBC', $key, 0, substr($key, 0, 16));
}

// Save encrypted
update_option('sign_libresign_api_key', encrypt_api_key($_POST['api_key']));

// Retrieve and decrypt
$api_key = decrypt_api_key(get_option('sign_libresign_api_key'));
```

---

### **12.6 CSRF Protection**

**Use nonces for all forms:**

```php
// In form
<form method="post">
    <?php wp_nonce_field('sign_save_settings', 'sign_nonce'); ?>
    <!-- form fields -->
</form>

// When processing
if (!wp_verify_nonce($_POST['sign_nonce'], 'sign_save_settings')) {
    wp_die('Security check failed');
}
```

---

## **13\. Testing Requirements**

### **13.1 Unit Tests**

**Test Framework:** PHPUnit

**Install:**

```shell
composer require --dev phpunit/phpunit
```

**Test Structure:**

```
tests/
├── bootstrap.php
├── test-pdf-generator.php
├── test-pdf-combiner.php
├── test-libresign-client.php
└── test-signing-controller.php
```

**Example Test:**

```php
// test-pdf-generator.php
class Test_PDF_Generator extends WP_UnitTestCase {
    
    public function test_generate_customer_data_pdf() {
        // Create test CPT
        $cpt_id = wp_insert_post(array(
            'post_type' => 'sign_request',
            'post_title' => 'Test Request',
        ));
        
        update_post_meta($cpt_id, 'esign_first_name', 'John');
        update_post_meta($cpt_id, 'esign_last_name', 'Doe');
        update_post_meta($cpt_id, 'esign_email', 'john@example.com');
        
        // Generate PDF
        $generator = new Sign_PDF_Generator();
        $pdf_path = $generator->generate_customer_data_pdf($cpt_id, 1);
        
        // Assert file exists
        $this->assertFileExists($pdf_path);
        
        // Assert file is PDF
        $this->assertEquals('application/pdf', mime_content_type($pdf_path));
    }
    
    public function test_multi_page_overflow() {
        // Create CPT with very long text
        $cpt_id = wp_insert_post(array(
            'post_type' => 'sign_request',
            'post_title' => 'Test Request',
        ));
        
        $long_text = str_repeat('This is a very long description. ', 1000);
        update_post_meta($cpt_id, 'project_description', $long_text);
        
        // Generate PDF
        $generator = new Sign_PDF_Generator();
        $pdf_path = $generator->generate_customer_data_pdf($cpt_id, 1);
        
        // Parse PDF and count pages (requires pdf-parser library)
        $parser = new \Smalot\PdfParser\Parser();
        $pdf = $parser->parseFile($pdf_path);
        $pages = $pdf->getPages();
        
        // Assert multiple pages
        $this->assertGreaterThan(1, count($pages));
    }
}
```

**Run Tests:**

```shell
phpunit
```

---

### **13.2 Integration Tests**

**Test End-to-End Workflow:**

```php
class Test_Signing_Workflow extends WP_UnitTestCase {
    
    public function test_complete_signing_workflow() {
        // Step 1: Create business
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'sign_businesses', array(
            'name' => 'Test Business',
            'company_name' => 'Test Co',
            'primary_color' => '#007bff',
        ));
        $business_id = $wpdb->insert_id;
        
        // Step 2: Upload test contract
        $wpdb->insert($wpdb->prefix . 'sign_documents', array(
            'business_id' => $business_id,
            'name' => 'Test Contract',
            'file_path' => '/path/to/test-contract.pdf',
            'sequence' => 1,
        ));
        
        // Step 3: Add signature field
        $wpdb->insert($wpdb->prefix . 'sign_fields', array(
            'business_id' => $business_id,
            'document_id' => $wpdb->insert_id,
            'type' => 'signature',
            'page' => 1,
            'x' => 100,
            'y' => 650,
            'width' => 200,
            'height' => 50,
            'required' => 1,
        ));
        
        // Step 4: Submit form (simulate JetFormBuilder)
        $form_data = array(
            'first_name' => 'Jane',
            'last_name' => 'Smith',
            'email' => 'jane@example.com',
            'phone' => '555-1234',
        );
        
        $controller = new Sign_Signing_Controller();
        // This would normally redirect, so we need to capture output
        ob_start();
        $controller->create_signing_request($form_data, (object)array('id' => 1));
        ob_end_clean();
        
        // Step 5: Verify CPT created
        $cpts = get_posts(array(
            'post_type' => 'sign_request',
            'meta_query' => array(
                array(
                    'key' => 'esign_email',
                    'value' => 'jane@example.com',
                ),
            ),
        ));
        
        $this->assertCount(1, $cpts);
        $cpt_id = $cpts[0]->ID;
        
        // Step 6: Verify status is incomplete
        $status = get_post_meta($cpt_id, 'esign_signing_status', true);
        $this->assertEquals('incomplete', $status);
        
        // Step 7: Simulate signing (trigger webhook)
        $webhook_data = array(
            'event' => 'document_signed',
            'metadata' => array(
                'cpt_id' => $cpt_id,
            ),
            'signed_pdf_url' => 'https://example.com/signed.pdf',
            'certificate_url' => 'https://example.com/cert.pdf',
        );
        
        $request = new WP_REST_Request('POST', '/sign/v1/webhook');
        $request->set_body(json_encode($webhook_data));
        
        $handler = new Sign_Webhook_Handler();
        $handler->process($request);
        
        // Step 8: Verify status updated to complete
        $status = get_post_meta($cpt_id, 'esign_signing_status', true);
        $this->assertEquals('complete', $status);
    }
}
```

---

### **13.3 Manual Testing Checklist**

**Before each release, manually test:**

* \[ \] Install plugin from .zip  
* \[ \] Activate plugin  
* \[ \] Configure branding (upload logo, set colors)  
* \[ \] Upload letterhead PDF  
* \[ \] Upload contract PDF  
* \[ \] Add signature fields via visual editor  
* \[ \] Connect to LibreSign (test connection)  
* \[ \] Activate system  
* \[ \] Submit test form via JetFormBuilder  
* \[ \] Verify CPT created  
* \[ \] Check email received  
* \[ \] Access dashboard via token link  
* \[ \] Click "Sign Now"  
* \[ \] Verify PDF generation  
* \[ \] Complete signing in LibreSign  
* \[ \] Verify webhook received  
* \[ \] Check status updated  
* \[ \] Verify completion email received with attachments  
* \[ \] Download signed PDF from dashboard  
* \[ \] Download certificate  
* \[ \] Test reminder email (wait 24 hours or manually trigger)  
* \[ \] Test with multiple businesses (multi-tenant)  
* \[ \] Test on mobile device  
* \[ \] Test with different PDF sizes  
* \[ \] Test with very long form data (multi-page)

---

## **14\. Deployment & Installation**

### **14.1 Plugin Package Structure**

**Final .zip file:**

```
sign-by-authapi.zip
├── sign-by-authapi/
│   ├── sign-by-authapi.php
│   ├── readme.txt
│   ├── LICENSE.txt
│   ├── includes/
│   ├── assets/
│   ├── templates/
│   ├── languages/
│   └── vendor/ (composer packages)
```

**Do NOT include:**

* `node_modules/` (too large)  
* `.git/`  
* `tests/`  
* `package.json`, `composer.json` (source files)  
* Development files

**Include compiled assets:**

* `assets/dist/*.bundle.js` (webpack output)  
* `vendor/` (composer packages)

---

### **14.2 Installation Instructions**

**For End Users:**

1. Download `sign-by-authapi.zip`  
2. Go to WordPress Admin → Plugins → Add New  
3. Click "Upload Plugin"  
4. Choose .zip file  
5. Click "Install Now"  
6. Click "Activate"

**First-Time Setup:**

1. Go to WP Admin → Sign → Settings  
2. Enter LibreSign URL and API Key  
3. Click "Test Connection"  
4. Go to Sign → Branding  
5. Upload logo, set colors  
6. Optionally upload letterhead  
7. Enter company info  
8. Save  
9. Go to Sign → Documents  
10. Upload contract PDFs  
11. Configure signature fields  
12. Go to Sign → Settings → General  
13. Click "Activate System"

---

### **14.3 Server Requirements**

**Minimum:**

* PHP 7.4+  
* MySQL 5.7+ or MariaDB 10.2+  
* WordPress 6.0+  
* 128MB PHP memory limit  
* 30MB disk space  
* Allow outbound HTTP requests (for LibreSign API)  
* LibreSign instance (self-hosted or cloud)

**Recommended:**

* PHP 8.0+  
* 256MB PHP memory limit  
* SSL certificate (HTTPS)  
* Cron enabled (for reminders)

**PHP Extensions Required:**

* `openssl` (for encryption)  
* `curl` (for API requests)  
* `gd` or `imagick` (for image processing)  
* `mbstring` (for text encoding)

---

### **14.4 WordPress.org Submission**

**readme.txt Template:**

```
=== Sign by authAPI.net ===
Contributors: yourname
Tags: e-signature, contract, pdf, signing, document
Requires at least: 6.0
Tested up to: 6.4
Stable tag: 1.0.0
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Automate contract signing for WordPress forms. Convert form submissions into legally-signed contracts instantly.

== Description ==

Sign by authAPI.net is a WordPress plugin that transforms your form submissions into legally-signed contracts automatically. Perfect for businesses that need to onboard clients with contracts.

**Features:**

* Automatic PDF generation from form data
* Custom letterheads and branding
* Visual signature field editor
* LibreSign integration (legally-compliant e-signatures)
* Customer dashboard for signing
* Automated email notifications
* Multi-tenant support (agencies)
* Works with JetFormBuilder (more form plugins coming)

**Use Cases:**

* Client onboarding for agencies
* Consultant agreements
* Service contracts
* Rental applications
* Financial advisor intake
* Legal client intake

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/sign-by-authapi`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to Sign → Settings to configure LibreSign connection
4. Configure branding and upload contracts
5. Activate the system

== Frequently Asked Questions ==

= Do I need a LibreSign account? =

Yes, you need a LibreSign instance (self-hosted or cloud). LibreSign is open-source and free to self-host.

= Which form builders are supported? =

Currently: JetFormBuilder. Coming soon: Gravity Forms, WPForms, Formidable Forms.

= Is this legally compliant? =

Yes, LibreSign provides ESIGN Act and UETA compliant signatures with audit trails and certificates.

= Can I use my own letterhead? =

Yes, you can upload a custom PDF letterhead or generate one from your logo and colors.

== Screenshots ==

1. Admin dashboard - Branding configuration
2. Visual signature field editor
3. Customer signing dashboard
4. Email notification example
5. Generated PDF with letterhead

== Changelog ==

= 1.0.0 =
* Initial release
* JetFormBuilder integration
* LibreSign integration
* Visual field editor
* Multi-tenant support

== Upgrade Notice ==

= 1.0.0 =
Initial release of Sign by authAPI.net
```

---

## **15\. Future Enhancements**

### **15.1 Phase 2 Features (v1.1)**

* **Additional Form Builder Support:**

  * Gravity Forms  
  * WPForms  
  * Formidable Forms  
  * Contact Form 7  
* **Advanced Branding:**

  * Multiple letterhead templates  
  * Per-document branding  
  * Custom fonts  
* **Signature Capture:**

  * Sign within WordPress (without LibreSign redirect)  
  * Signature Pad integration  
  * Biometric data capture

---

### **15.2 Phase 3 Features (v1.2)**

* **Multi-Signer Support:**

  * Add multiple signers per document  
  * Sequential signing (signer 1 → signer 2\)  
  * Parallel signing (all sign simultaneously)  
* **Advanced Workflows:**

  * Conditional documents (if X, include doc Y)  
  * Approval workflows (manager approval before customer)  
  * Expiring signatures (must sign within X days)  
* **Analytics Dashboard:**

  * Signing completion rate  
  * Average time to sign  
  * Abandoned signatures  
  * Conversion funnel

---

### **15.3 Phase 4 Features (v2.0)**

* **White-Label Option:**

  * Remove "Sign by authAPI.net" branding  
  * Custom plugin name  
  * Custom admin pages  
* **API for Developers:**

  * REST API endpoints  
  * Webhooks for events  
  * Developer documentation  
* **Integrations:**

  * Salesforce  
  * HubSpot  
  * Zapier  
  * Google Drive storage

---

## **16\. Hiring Checklist**

### **16.1 Developer Requirements**

**Must Have:**

* 3+ years WordPress plugin development  
* Expert in PHP 7.4+ and OOP  
* Experience with WordPress hooks/filters  
* Experience with WordPress REST API  
* Knowledge of PDF libraries (mPDF, FPDI)  
* Experience with JavaScript (ES6+)  
* Knowledge of React or Vue (for future features)  
* Git proficiency

**Nice to Have:**

* Experience with e-signature platforms  
* Knowledge of legal compliance (ESIGN Act)  
* Experience with multi-tenant SaaS  
* UI/UX design skills  
* Experience with automated testing

---

### **16.2 Questions to Ask Candidates**

1. "Have you built WordPress plugins that integrate with third-party APIs?"  
2. "Can you explain the WordPress Plugin API (actions, filters, hooks)?"  
3. "How would you handle PDF generation and manipulation in PHP?"  
4. "Explain how you would secure a WordPress plugin against common vulnerabilities."  
5. "Have you worked with multi-tenant WordPress applications?"  
6. "How would you test a complex WordPress plugin?"  
7. "Can you walk me through the WordPress database architecture?"  
8. "How would you handle file uploads securely in WordPress?"

---

### **16.3 Test Assignment**

**Coding Challenge:**

"Create a simple WordPress plugin that:

1. Registers a custom post type called 'Contract'  
2. Adds a meta box with fields: client\_name, client\_email  
3. Has a button 'Generate PDF' that creates a simple PDF with the client data  
4. Uses mPDF or FPDI library  
5. Saves the PDF to uploads directory  
6. Displays download link

Time limit: 4 hours Deliverable: .zip file of working plugin"

This tests:

* WordPress development skills  
* PDF library knowledge  
* File handling  
* Security practices

---

### **16.4 Project Timeline & Budget**

**Estimated Hours:**

* Phase 1: Foundation (40 hours)  
* Phase 2: Admin UI (60 hours)  
* Phase 3: PDF Generation (50 hours)  
* Phase 4: LibreSign Integration (40 hours)  
* Phase 5: Workflow (50 hours)  
* Phase 6: Email System (30 hours)  
* Phase 7: Visual Editor (60 hours)  
* Phase 8: Testing & Polish (50 hours)  
* Phase 9: Launch Prep (20 hours)

**Total: \~400 hours**

**Budget Estimate:**

* Junior Developer ($30-50/hr): $12,000-$20,000  
* Mid-Level Developer ($50-80/hr): $20,000-$32,000  
* Senior Developer ($80-120/hr): $32,000-$48,000

**Recommended:** Hire mid-level developer with strong WordPress experience.

---

## **Conclusion**

This PRD provides a comprehensive blueprint for building **Sign by authAPI.net** as a WordPress plugin. It covers:

✅ **Problem & Solution** \- Clear market need and differentiation  
 ✅ **Technical Architecture** \- Detailed class structure and workflows  
 ✅ **Feature Specifications** \- Every feature explained in detail  
 ✅ **Database Design** \- Complete schema with relationships  
 ✅ **Development Phases** \- Logical build sequence  
 ✅ **Security Requirements** \- Best practices for secure coding  
 ✅ **Testing Strategy** \- Unit, integration, and manual tests  
 ✅ **Deployment Guide** \- Installation and submission process

**Next Steps:**

1. Review this PRD with stakeholders  
2. Post job listing for WordPress developer  
3. Use coding challenge to evaluate candidates  
4. Begin Phase 1 development  
5. Weekly check-ins to track progress  
6. Beta testing with real users  
7. Launch on WordPress.org

**Questions or Clarifications?** This document is designed to be comprehensive for a junior developer. If anything is unclear, please request clarification before beginning development.

