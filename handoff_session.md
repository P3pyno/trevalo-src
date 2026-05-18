# Trivalo Sourcing - Handoff Documentation

## Project Overview
**Trivalo Sourcing** is a Laravel-based B2B procurement and sourcing platform built as a Vue 3 Single Page Application (SPA). It enables buyers to create sourcing requests, receive quotes from suppliers, manage shipments, and collaborate through messaging and document sharing.

---

## What Has Been Done
- ✅ Project initialized with Laravel 13 and Vue 3
- ✅ Database schema created with migrations for all core entities
- ✅ Authentication system implemented (register, login, logout with Laravel Sanctum)
- ✅ RESTful API endpoints built for all features
- ✅ Admin dashboard with role-based access control
- ✅ Frontend SPA scaffolded with Vue Router, Pinia, and Vite
- ✅ Tailwind CSS styling configured
- ✅ Development server configured for local and LAN testing

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
- **Framework**: Laravel 13
- **Database**: MySQL/SQLite (via Eloquent ORM)
- **Authentication**: Laravel Sanctum (API token-based)
- **Mail**: Laravel Mail (configured for contact form)
- **Database Utilities**: Adminer exists in `public/adminer.php` but should be treated as local-only and not deployed publicly

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

### LAN Testing
```bash
php artisan serve --host=0.0.0.0 --port=8000
# Reachable from another device at http://192.168.205.171:8000
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
Visit `http://127.0.0.1:8000/adminer.php` only for local development. Do not expose this publicly.

---

## Current Status (Latest Updates - May 18, 2026)

### ✅ Completed in This Session

1. **Real-time Messaging — Unread Badges & Typing Indicators**
   - Unread message counts tracked per conversation using `reactive({})` keyed by request ID
   - Unread badge shown on conversation list items; total unread shown on Messages nav tab
   - Typing indicator: debounced Pusher `whisper` emit (300ms) + auto-hide after 2500ms
   - Animated bouncing dots shown while remote user is typing
   - Applied to both buyer Dashboard and Admin Dashboard
   - Note: Pusher client events must be enabled in Pusher dashboard for typing to work

2. **Real-time Shipment Updates**
   - Shipment list updates in real-time via `.shipment.updated` broadcast event
   - Updates existing shipment in-place or prepends new one to the list

3. **Duplicate Message Fix**
   - Messages no longer appear twice without a page refresh
   - Root cause: `->toOthers()` on the server requires the `X-Socket-ID` header to identify the sender's socket
   - Fix: `echo.socketId()` captured and sent as `X-Socket-ID` header in both Dashboard and AdminDashboard `sendMessage()` calls

4. **Messages Layout Rewrite**
   - Conversation list was collapsing to 160px when a request was selected
   - Root cause: bad `maxHeight` hack on the conversation list container
   - Fix: rewrote with `-m-4 sm:-m-6 lg:-m-8` negative-margin pattern + `flex h-full` for full-height panel layout matching the admin dashboard

5. **Onboarding Flow**
   - New `/onboarding` page shown to new users immediately after email verification
   - Two-step form: Step 1 (company, country, phone) + Step 2 (product categories, referral source)
   - Gold progress bar at top, step indicators on left panel, "Skip for now" link on each step
   - Auto-login on email verification: backend now returns token + user in verify response
   - `VerifyEmail.vue` calls `authStore.setSession()` then redirects to `/onboarding` after 1.5s
   - Router guard redirects any `!onboarding_completed` user to `/onboarding` before any auth'd route
   - New `onboarding_completed` boolean on users table; existing verified users auto-set `true` in migration
   - Backend: `POST /api/onboarding` stores company/country/phone and sets `onboarding_completed = true`

6. **Pre-Hosting Fixes (Code)**
   - `Pusher.logToConsole` now only set to `true` in `DEV` mode (`echo.js`)
   - Sanctum token expiration set to 30 days (was `null` = never expires) (`config/sanctum.php`)
   - Resend verification email endpoint throttled to 3 requests per 10 minutes (`routes/api.php`)

7. **WCAG Contrast Ratio Fixes (Accessibility)**
   - All `text-white/40` → `text-white/70` (3.6:1 → 8.5:1 on navy)
   - All `text-white/30` → `text-white/55`
   - All `text-gray-400` → `text-gray-500` (2.5:1 → 4.7:1 on white) — ~80 instances across 24 files
   - `text-gold-500/600` → `text-gold-700` on white/light backgrounds (2.9:1 → 5.9:1) — section labels, badges, nav links, stat numbers, supplier codes, link text
   - Navbar active link: now conditional — `!text-gold-400` when navbar is transparent (dark bg), `!text-gold-700` when scrolled (white bg)
   - Instances on dark navy backgrounds (hero sections, sidebars, left panels) kept at gold-400 which passes on dark

### Current Project Status
- ✅ Server currently tested on LAN at `http://192.168.205.171:8000`
- ✅ All migrations execute on the working local database
- ✅ Test suite passes: `7` tests, `15` assertions
- ✅ API endpoints functional for auth, sourcing requests, quotes, shipments, documents, and messages
- ✅ Frontend SPA and admin dashboard both operational for cross-device testing
- ⚠️ `.env` must keep `APP_URL` and `FRONTEND_URL` set to a real reachable host, not `0.0.0.0`
- ✅ **Email verification system PRODUCTION READY** (Resend.com SMTP)
- ✅ File upload/download functionality implemented
- ✅ Real-time shipment tracking with animated progress
- ✅ Real-time messaging with unread badges and typing indicators
- ✅ Onboarding flow for new users after email verification
- ✅ Activity logging system active
- ✅ Authentication & authorization working (Sanctum tokens, 30-day expiry)
- ✅ WCAG AA contrast compliance across all public and authenticated pages
- ⚠️ Pusher client events must be enabled in Pusher dashboard for typing indicators to work

---

## Next Steps for Development

### Before Hosting (Required)
1. **Environment Configuration** - Set production `.env` values:
   - `APP_ENV=production`, `APP_DEBUG=false`
   - `APP_URL` and `FRONTEND_URL` to real domain
   - `MAIL_FROM_ADDRESS` to verified custom domain email
   - `QUEUE_CONNECTION=database` (or Redis) for email queuing
   - Real database credentials (MySQL recommended for production)
2. **Pusher Client Events** - Enable in Pusher App Settings dashboard for typing indicators to function
3. **Remove Adminer** - Delete or password-protect `public/adminer.php` before going live
4. **Storage Symlink** - Run `php artisan storage:link` on the server after deployment
5. **Run Migrations** - `php artisan migrate --force` on production database

### High Priority (Ready to Work On)
1. **Payment Gateway Integration** - Implement payment processing for quotes
   - Consider Stripe, PayPal, or other providers
   - Add payment status tracking

2. **Advanced Search & Filtering** - Enhance sourcing request discovery
   - Filter by category, price range, delivery time
   - Full-text search capabilities

3. **Supplier Rating System** - Add reviews and ratings for suppliers
   - Rating on quality, delivery speed, communication
   - Supplier profile credibility indicators

### Medium Priority
1. **Auth Hardening**
   - Move away from bearer tokens stored in `localStorage`
   - Prefer Sanctum SPA cookie auth if going to production

2. **Image Optimization**
   - Implement compression and resizing for uploaded product images
   - Generate thumbnails if gallery size grows

3. **Bulk Operations**
   - Bulk export to CSV
   - Bulk status updates

4. **Analytics Dashboard**
   - Expand request trends and supplier performance views

### Low Priority (Optional Enhancements)
1. **Mobile App** - React Native or Flutter app
2. **API Documentation** - Swagger/OpenAPI spec
3. **Internationalization** - Multi-language support (Vue-i18n already configured)
4. **Dark Mode** - Theme toggle functionality

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
**Current SMTP shape:**
```
MAIL_MAILER=smtp
MAIL_SCHEME=smtp
MAIL_HOST=smtp.resend.com
MAIL_PORT=587
MAIL_USERNAME=resend
MAIL_PASSWORD=<set real resend api key in local .env only>
MAIL_FROM_ADDRESS="onboarding@resend.dev"
MAIL_FROM_NAME="Trivalo Sourcing"
APP_URL=http://192.168.205.171:8000
FRONTEND_URL=http://192.168.205.171:8000
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
- **Frontend**: `http://192.168.205.171:8000/`
- **API Base**: `http://192.168.205.171:8000/api/`
- **Email Verification Frontend Route**: `http://192.168.205.171:8000/verify-email/{id}/{hash}?expires=...&signature=...`
- **Email Verification Backend Route**: `http://192.168.205.171:8000/api/auth/verify-email/{id}/{hash}?expires=...&signature=...`
- **Database GUI**: local only, avoid exposing `/adminer.php`

### File Locations
- **Environment**: `.env`
- **Mail Config**: `config/mail.php`
- **Migrations**: `database/migrations/`
- **Email Mailables**: `app/Mail/EmailVerificationMail.php`, `app/Mail/PasswordResetMail.php`
- **Verification SPA Page**: `resources/js/pages/VerifyEmail.vue`
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
- Publicly served uploads are exposed through `/storage/...` via the Laravel storage symlink
- The SPA routes are handled by a catch-all route in `routes/web.php`
- Admin access is determined by the `is_admin` boolean field on users table
- Email verification now requires valid signed URLs with expiry
- Attachment-related migrations were made idempotent to support clean test/database bootstrap

### Shipment Progress Tracking
- Four stages: `pending`, `in_transit`, `customs`, `delivered`
- Progress percentage calculated: `(stageIndex / 3) * 100`
- Visual indicators update smoothly with 500ms transition
- Full-width layout with `justify-between` distribution

### Frontend Architecture
- **State Management**: Pinia stores (auth, data)
- **Routing**: Vue Router with lazy-loaded pages
- **API Communication**: Axios interceptors for token management
- **Base URL**: Axios defaults to `/api`, so frontend code should not prefix requests with `/api` again
- **Styling**: Tailwind CSS with custom brand colors
- **Build**: Vite with ~250 KB bundle size (~90 KB gzipped)
- **Build Time**: ~3 seconds

### Real-time Features (Pusher / Laravel Echo)
- **Broadcasting driver**: Pusher (configured via `PUSHER_APP_*` env vars)
- **Frontend**: Laravel Echo + `pusher-js`, instantiated in `resources/js/echo.js`
- **Auth channel**: Custom axios-based authorizer sends `X-Socket-ID` header automatically via `echo.socketId()`
- **Unread counts**: `reactive({})` keyed by request ID, incremented on incoming messages when that conversation is not open, cleared on `selectConversation()`
- **Typing indicator**: `channel.whisper('typing', {})` emitted with 300ms debounce; receiver hides after 2500ms. Requires "Enable client events" turned on in Pusher App Settings.
- **Shipment updates**: `.shipment.updated` event on user's private channel; updates list in-place
- **Duplicate message prevention**: `X-Socket-ID` header sent with every `sendMessage()` call so `->toOthers()` correctly suppresses echo back to sender

### Onboarding Flow
- New users land on `/onboarding` after email verification (auto-login via token in verify response)
- Router guard in `resources/js/router/index.js` catches any authenticated user with `onboarding_completed = false` and redirects to `/onboarding`
- Existing verified users had `onboarding_completed` set to `true` by migration `2026_05_17_200310_add_onboarding_completed_to_users_table.php`
- Admins skip the onboarding redirect

### Accessibility (WCAG AA)
- All text contrast ratios verified against WCAG AA (4.5:1 for normal text, 3:1 for large text/icons)
- `text-gray-500` used throughout for secondary text on white (4.7:1)
- `text-gold-700` used for gold text on white/light backgrounds (5.9:1)
- `text-gold-400` retained on dark navy backgrounds where it passes (6.7:1)
- Navbar active link uses conditional class: `!text-gold-400` when transparent (dark bg), `!text-gold-700` when scrolled (white bg)

### Git Workflow
- Repository: `github.com/P3pyno/trevalo-src.git`
- Main branch: `main`
- Latest commit: `d9c4fbe` - All changes tracked and documented in commits


