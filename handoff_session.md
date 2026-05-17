# Trivalo Sourcing - Handoff Documentation

## Project Overview
**Trivalo Sourcing** is a Laravel-based B2B procurement and sourcing platform built as a Vue 3 Single Page Application (SPA). It enables buyers to create sourcing requests, receive quotes from suppliers, manage shipments, and collaborate through messaging and document sharing.

---

## What Has Been Done
- ✅ Project initialized with Laravel 11 and Vue 3
- ✅ Database schema created with migrations for all core entities
- ✅ Authentication system implemented (register, login, logout with Laravel Sanctum)
- ✅ RESTful API endpoints built for all features
- ✅ Admin dashboard with role-based access control
- ✅ Frontend SPA scaffolded with Vue Router, Pinia, and Vite
- ✅ Tailwind CSS styling configured
- ✅ Development server running at `http://127.0.0.1:8000`

---

## Website Features & Architecture

### Core Entities & Models
The platform manages the following key entities:

1. **Users** - Buyers, suppliers, and admin accounts
   - Fields: name, email, password, company, phone, country, is_admin
   - Relationships: sourcingRequests, quotes (if supplier), messages

2. **Sourcing Requests** - Procurement requests created by buyers
   - Fields: title, description, quantity, target_price, currency, destination_country, deadline, status, notes, product_images
   - Relationships: quotes, shipments, documents, messages, activity logs

3. **Quotes** - Supplier responses to sourcing requests
   - Status: pending, approved, rejected
   - Relationships: sourcing request, supplier user

4. **Shipments** - Delivery tracking and logistics
   - Related to sourcing requests
   - Tracks order fulfillment

5. **Documents** - File uploads (product specs, certifications, invoices, etc.)
   - Can be attached to sourcing requests, quotes, or shipments

6. **Messages** - Communication threads
   - Per-sourcing-request messaging between buyers and suppliers
   - Real-time collaboration

7. **Activity Logs** - Audit trail
   - Tracks all changes to sourcing requests
   - Uses LogsActivity trait for automatic tracking

---

## Functionality Breakdown

### Public Features (No Auth Required)
- **Contact Form** - Visitors can submit inquiries (throttled to 10/min)
- **Landing Page** - Marketing homepage with features overview

### Authenticated User Features (Logged-in Users)
- **Dashboard**
  - Overview stats (active requests, quotes, shipments)
  - Analytics (request trends, supplier performance)
  - Activity logs
  
- **Sourcing Requests Management**
  - Create new sourcing requests with images and specifications
  - View all created requests
  - Cancel requests
  - Track quotes and shipments
  - View request details and supplier responses

- **Quote Management**
  - View all received quotes
  - Approve individual quotes
  - Reject individual quotes
  - Bulk approve/reject quotes
  - Create counter-quotes (admin only)

- **Shipment Tracking**
  - View shipments for all requests
  - Track delivery status

- **Document Management**
  - Upload documents
  - Associate with requests, quotes, or shipments
  - Download and delete files

- **Messaging**
  - Per-request communication threads
  - Real-time chat with suppliers
  - Message history

- **User Profile**
  - View and edit profile (name, company, phone, country)
  - Change password
  - Delete account

### Admin Dashboard Features (is_admin=true)
- **Statistics** - System-wide metrics
- **User Management** - View all users and their details
- **Sourcing Request Management** - View, update status, manage all requests
- **Quote Management** - Create, update, delete quotes (admin control)
- **Shipment Management** - Create and update shipments
- **Document Management** - Upload and delete documents
- **Message Moderation** - View and respond to all message threads
- **Activity Logs** - Full audit trail

---

## Technology Stack

### Backend
- **Framework**: Laravel 11
- **Database**: MySQL/SQLite (via Eloquent ORM)
- **Authentication**: Laravel Sanctum (API token-based)
- **Mail**: Laravel Mail (configured for contact form)
- **Database Utilities**: Adminer (available at `/adminer.php`)

### Frontend
- **Framework**: Vue 3 (latest composition API)
- **Build Tool**: Vite
- **State Management**: Pinia
- **Routing**: Vue Router 4
- **HTTP Client**: Axios
- **Styling**: Tailwind CSS 3
- **Internationalization**: Vue-i18n

### Development
- **PHP Unit Tests**: Configured
- **Package Manager**: Composer (PHP), NPM (JavaScript)

---

## Project Structure

```
app/
├── Http/Controllers/          # API endpoints
│   ├── AuthController
│   ├── ContactController
│   ├── UserController
│   ├── DashboardController
│   ├── SourcingRequestController
│   ├── QuoteController
│   ├── ShipmentController
│   ├── DocumentController
│   ├── MessageController
│   └── Admin/                 # Admin-only endpoints
├── Models/                    # Eloquent models
│   ├── User
│   ├── SourcingRequest
│   ├── Quote
│   ├── Shipment
│   ├── Document
│   ├── Message
│   └── ActivityLog
├── Mail/                      # Mailable classes
└── Traits/
    └── LogsActivity           # Automatic activity logging

database/
├── migrations/                # Schema definitions
└── factories/                 # Seeders

resources/
├── js/                        # Vue components and app logic
├── views/                     # Blade templates (SPA entry point)
└── css/                       # Tailwind styles

routes/
├── api.php                    # API endpoints (all routes)
└── web.php                    # Web routes (SPA catch-all)

public/
├── index.php                  # Entry point
├── adminer.php                # Database GUI
└── storage/                   # File uploads
```

---

## API Authentication
- **Type**: Token-based (Laravel Sanctum)
- **Headers**: `Authorization: Bearer {token}`
- **Obtained**: Via `/api/auth/login` endpoint after registration/login
- **Rate Limiting**: 
  - Auth routes: 20 requests/min
  - Contact form: 10 requests/min
  - Other routes: Standard limits

---

## Running the Application

### Development Server
```bash
php artisan serve
# Runs on http://127.0.0.1:8000
```

### Build Frontend Assets
```bash
npm run dev     # Watch mode
npm run build   # Production build
```

### Database
```bash
php artisan migrate          # Run migrations
php artisan db:seed          # Seed sample data
php artisan tinker           # Interactive shell
```

### Access Database GUI
Visit `http://127.0.0.1:8000/adminer.php` for database management.

---

## Current Status (Latest Updates - May 17, 2026)

### ✅ Completed in This Session
1. **Email Verification System - Production Ready**
   - ✅ Resend.com SMTP fully integrated and tested
   - ✅ Account creation workflow: Register → Verification Email Sent → Email Verified → Login
   - ✅ Test case completed: Created "Test User" account with email verification
   - ✅ Verification email delivered successfully via Resend.com
   - ✅ Signed verification URL processed successfully
   - ✅ User authenticated and dashboard loaded
   - **Configuration:**
     - SMTP Host: `smtp.resend.com`
     - Port: `465` (SMTPS/SSL)
     - Scheme: `smtps` (not `tls`)
     - Auth: `resend` username with API key as password
     - From Address: `onboarding@resend.dev` (Resend default domain)
   - **Note:** Resend free tier requires sender to be `onboarding@resend.dev` for test emails

2. **Shipment Progress Indicators Enhanced**
   - Implemented blue-themed progress tracking (matching design specs)
   - Active circles: Blue background (`bg-blue-500`) with white checkmarks
   - Inactive circles: Light gray with step numbers
   - Animated progress line: Blue fill that extends based on shipment status (0%, 33%, 66%, 100%)
   - Vertical alignment: Progress line centered on circles using `top-1/2 transform -translate-y-1/2`
   - Four stages: Confirmed → In Transit → Customs → Delivered

3. **Frontend Refinements**
   - Animation system across all pages with smooth transitions
   - UI/UX improvements to FloatingChat, LoadingSkeleton components
   - Enhanced Auth page styling and user feedback

4. **Version Control**
   - All changes committed and pushed to GitHub (branch: main)
   - Latest commit: `7cc84bb` - "Update shipments progress indicator with blue styling, fix email verification, and UI refinements"

### Current Project Status
- ✅ Server running at `http://127.0.0.1:8001` (custom port in .env)
- ✅ All migrations executed
- ✅ API endpoints fully functional
- ✅ Frontend SPA complete with dashboard, shipments tracking, documents, messages
- ✅ Admin dashboard with comprehensive management tools
- ✅ **Email verification system PRODUCTION READY** (Resend.com SMTP)
- ✅ File upload/download functionality implemented
- ✅ Real-time shipment tracking with animated progress
- ✅ Activity logging system active
- ✅ Authentication & authorization working (Sanctum tokens)

---

## Next Steps for Development

### High Priority (Ready to Work On)
1. **Payment Gateway Integration** - Implement payment processing for quotes
   - Consider Stripe, PayPal, or other providers
   - Add payment status tracking

2. **Notification System** - Add real-time notifications for:
   - Quote responses
   - Shipment status updates
   - Message receipts
   - Request approvals

3. **Advanced Search & Filtering** - Enhance sourcing request discovery
   - Filter by category, price range, delivery time
   - Full-text search capabilities

5. **Supplier Rating System** - Add reviews and ratings for suppliers
   - Rating on quality, delivery speed, communication
   - Supplier profile credibility indicators

### Medium Priority
1. **Image Optimization** - Handle product image uploads and resizing
   - Implement image compression
   - Generate thumbnails

2. **Bulk Operations** - Improve bulk quote management
   - Bulk export to CSV
   - Bulk status updates

3. **Analytics Dashboard** - Expand admin analytics
   - Request trends over time
   - Supplier performance metrics
   - Revenue tracking

4. **Email Templates** - Style HTML email templates
   - Verification email (currently functional but basic)
   - Quote notifications
   - Shipment updates

### Low Priority (Optional Enhancements)
1. **Mobile App** - React Native or Flutter app
2. **API Documentation** - Swagger/OpenAPI spec
3. **Real-time Broadcasting** - WebSocket notifications (Laravel Broadcasting)
4. **Internationalization** - Multi-language support (Vue-i18n already configured)
5. **Dark Mode** - Theme toggle functionality

---

## Key Files to Review
- `routes/api.php` - All API endpoints
- `app/Http/Controllers/` - Business logic
- `app/Models/` - Data models and relationships
- `database/migrations/` - Schema definitions
- `resources/js/` - Vue components and app setup
- `package.json` - Frontend dependencies
- `composer.json` - PHP dependencies

---

## Important Configuration Notes

### Email System Setup
**Current (Production - Resend.com - TESTED ✅):**
```
MAIL_MAILER=smtp
MAIL_SCHEME=smtps
MAIL_HOST=smtp.resend.com
MAIL_PORT=465
MAIL_USERNAME=resend
MAIL_PASSWORD=re_5nvxMxkX_9NUgrbyb6GuG1FQXG5nDAS3K
MAIL_FROM_ADDRESS="onboarding@resend.dev"
MAIL_FROM_NAME="Trivalo Sourcing"
```

**Alternative (Development - File-based):**
```
MAIL_MAILER=file
# Emails saved to storage/app/mail/
```

**For Custom Domain (Resend - Requires Domain Verification):**
1. Verify a custom domain in Resend.com dashboard
2. Update `MAIL_FROM_ADDRESS` to use custom domain email (e.g., noreply@yourdomain.com)
3. API key remains the same
4. Port and host settings remain the same

### Key Endpoints
- **Frontend**: `http://127.0.0.1:8001/` (home, auth, dashboard)
- **API Base**: `http://127.0.0.1:8001/api/`
- **Email Verification**: `http://127.0.0.1:8001/api/auth/verify-email/{id}/{hash}`
- **Database GUI**: `http://127.0.0.1:8001/adminer.php`

### File Locations
- **Environment**: `.env`
- **Mail Config**: `config/mail.php`
- **Migrations**: `database/migrations/`
- **Email Mailables**: `app/Mail/EmailVerificationMail.php`
- **Frontend Build**: `public/build/`
- **Stored Emails**: `storage/app/mail/` (development only)

### Brand Configuration
- **Primary Color**: Navy (#284CA8)
- **Secondary Color**: Gold (#C8A45D)
- **Company Name**: Trivalo Sourcing
- **Support Email**: info@trivalo-sourcing.com (configurable in `.env`)

---

## Technical Notes

### Database & Migrations
- The application uses automatic activity logging via the `LogsActivity` trait on SourcingRequest model
- All timestamps are managed by Laravel's timestamps (created_at, updated_at)
- File uploads are stored in `storage/app/` directory
- The SPA routes are handled by a catch-all route in `routes/web.php`
- Admin access is determined by the `is_admin` boolean field on users table
- Email verification uses signed URLs (expire in 24 hours) with SHA1 hashing

### Shipment Progress Tracking
- Four stages: `pending`, `in_transit`, `customs`, `delivered`
- Progress percentage calculated: `(stageIndex / 3) * 100`
- Visual indicators update smoothly with 500ms transition
- Full-width layout with `justify-between` distribution

### Frontend Architecture
- **State Management**: Pinia stores (auth, data)
- **Routing**: Vue Router with lazy-loaded pages
- **API Communication**: Axios interceptors for token management
- **Styling**: Tailwind CSS with custom brand colors
- **Build**: Vite with ~243.5 KB bundle size (86.85 KB gzipped)
- **Build Time**: ~3 seconds

### Git Workflow
- Repository: `github.com/P3pyno/trevalo-src.git`
- Main branch: `main`
- Latest commit: `7cc84bb` - All changes tracked and documented in commits



