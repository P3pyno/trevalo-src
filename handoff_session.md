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

## Current Status
- ✅ Server is running and accessible at `http://127.0.0.1:8000`
- ✅ All migrations created and ready to run
- ✅ API endpoints fully defined
- ✅ Vue SPA structure scaffolded
- ⏳ Frontend components (Views) - In development
- ⏳ Frontend routing and state management - In development

---

## Next Steps for Development
1. Build Vue components for authentication (login, register)
2. Create dashboard and statistics views
3. Build sourcing request creation and management UI
4. Implement quote management interface
5. Add messaging/chat component
6. Build admin dashboard
7. Integrate with email service for notifications
8. Add image upload handling
9. Implement real-time features (optional, using Broadcasting)
10. Write comprehensive tests
11. Deploy to production

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

## Notes
- The application uses automatic activity logging via the `LogsActivity` trait on SourcingRequest model
- All timestamps are managed by Laravel's timestamps (created_at, updated_at)
- File uploads are stored in `storage/app/` directory
- The SPA routes are handled by a catch-all route in `routes/web.php`
- Admin access is determined by the `is_admin` boolean field on users table

