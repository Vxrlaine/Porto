# Portfolio & Commission Management System

A professional portfolio and commission management system built with Laravel 13, featuring enterprise-level architecture and industry best practices.

## 🚀 Features

### Core Features
- **Portfolio Management** - Showcase projects with images, descriptions, and metadata
- **Commission System** - Accept and manage client commission requests
- **Skills Management** - Display technical skills with proficiency levels
- **Admin Dashboard** - Complete CRUD operations for all content
- **Activity Logging** - Automatic audit trail for all changes
- **API Support** - RESTful API with Sanctum authentication

### Enterprise Features
- ✅ **Form Request Validation** - Type-safe validation with authorization
- ✅ **Repository Pattern** - Clean data access abstraction
- ✅ **Policy Authorization** - Granular permission control
- ✅ **Event-Driven Architecture** - Decoupled notification system
- ✅ **API Resources** - Standardized JSON responses
- ✅ **Security Headers** - XSS, CSRF, and clickjacking protection
- ✅ **Activity Audit Trail** - Track all CRUD operations
- ✅ **File Upload Service** - Centralized file management
- ✅ **Comprehensive Tests** - Unit and feature test coverage

## 📋 Requirements

- PHP 8.4+
- Composer
- Node.js & NPM
- MySQL 8.0+ or SQLite
- Laravel 13

## 🛠️ Installation

### 1. Clone Repository
```bash
git clone <repository-url>
cd protof
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=protof
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migrations
```bash
php artisan migrate
```

### 6. Build Frontend
```bash
npm run build
```

### 7. Create Storage Link
```bash
php artisan storage:link
```

### 8. Create Admin User
```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@example.com',
    'password' => bcrypt('password'),
    'is_admin' => true,
]);
```

### 9. Start Development Server
```bash
php artisan serve
```

Visit: `http://localhost:8000`

## 📁 Project Structure

```
app/
├── Events/                      # Event classes
│   ├── CommissionCreated.php
│   └── CommissionStatusChanged.php
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # Admin web controllers
│   │   └── Api/                # API controllers
│   ├── Middleware/             # Custom middleware
│   ├── Requests/               # Form request validation
│   └── Resources/              # API resources
├── Listeners/                  # Event listeners
├── Models/                     # Eloquent models
├── Policies/                   # Authorization policies
├── Repositories/               # Repository pattern
├── Services/                   # Service classes
└── Traits/                     # Reusable traits

database/migrations/            # Database migrations
routes/
├── web.php                     # Web routes
└── api.php                     # API routes
tests/
├── Feature/                    # Feature tests
└── Unit/                       # Unit tests
docs/
├── ERD.md                      # Database schema documentation
└── ENTERPRISE_IMPLEMENTATION.md # Implementation guide
```

## 🔐 Authentication

### Web Authentication
- Login: `/login`
- Register: `/register`
- Logout: `POST /logout`

### API Authentication
```bash
# Login
POST /api/auth/login
{
  "email": "admin@example.com",
  "password": "password"
}

# Response
{
  "token": "1|abc123...",
  "user": {
    "id": 1,
    "name": "Admin",
    "email": "admin@example.com",
    "is_admin": true
  }
}

# Register
POST /api/auth/register
{
  "name": "New User",
  "email": "user@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}

# Logout (requires token)
POST /api/auth/logout
Authorization: Bearer {token}
```

## 🌐 API Endpoints

### Public Endpoints
```
GET    /api/health                    # Health check
GET    /api/projects                  # List active projects
GET    /api/projects/{id}             # Get project details
GET    /api/skills                    # List active skills
POST   /api/commissions               # Create commission request
```

### Admin Endpoints (Requires Authentication)
```
# Projects
POST   /api/admin/projects            # Create project
PUT    /api/admin/projects/{id}       # Update project
DELETE /api/admin/projects/{id}       # Delete project

# Skills
POST   /api/admin/skills              # Create skill
PUT    /api/admin/skills/{id}         # Update skill
DELETE /api/admin/skills/{id}         # Delete skill

# Commissions
GET    /api/admin/commissions         # List all commissions
GET    /api/admin/commissions/{id}    # Get commission details
PATCH  /api/admin/commissions/{id}/status  # Update status
POST   /api/admin/commissions/{id}/assign  # Assign to user
DELETE /api/admin/commissions/{id}    # Delete commission

# Statistics
GET    /api/admin/stats               # Get dashboard statistics
```

### API Usage Example
```bash
# Get projects
curl -X GET "http://localhost:8000/api/projects?active_only=true&per_page=10"

# Create commission (public)
curl -X POST "http://localhost:8000/api/commissions" \
  -H "Content-Type: application/json" \
  -d '{
    "client_name": "John Doe",
    "client_email": "john@example.com",
    "description": "Custom artwork request",
    "character_type": "Anime",
    "budget": 150.00
  }'

# Admin: Update commission status
curl -X PATCH "http://localhost:8000/api/admin/commissions/1/status" \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{"status": "accepted"}'
```

## 🗄️ Database Schema

See [docs/ERD.md](docs/ERD.md) for complete database documentation.

### Main Tables
- **users** - User authentication and profiles
- **projects** - Portfolio projects
- **skills** - Technical skills and proficiency
- **commissions** - Client commission requests
- **portfolio_images** - Portfolio image gallery
- **about_settings** - About page configuration
- **activity_logs** - Audit trail for all changes

## 🧪 Testing

### Run All Tests
```bash
php artisan test
```

### Run Specific Test
```bash
php artisan test tests/Feature/ProjectCrudTest.php
```

### Run with Coverage
```bash
php artisan test --coverage
```

### Test Suites
- **Unit Tests** - Model creation, validation, relationships
- **Feature Tests** - HTTP requests, authentication, CRUD operations

## 🔒 Security Features

### HTTP Security Headers
- X-Frame-Options: DENY
- X-XSS-Protection: 1; mode=block
- X-Content-Type-Options: nosniff
- Content-Security-Policy (configurable)
- Referrer-Policy: strict-origin-when-cross-origin
- Permissions-Policy

### Authorization
- Policy-based access control
- Admin role enforcement
- Request-level authorization
- API token authentication (Sanctum)

### Data Protection
- Password hashing (bcrypt)
- CSRF protection
- SQL injection prevention (Eloquent ORM)
- XSS protection
- Activity logging

## 📝 Activity Logging

All CRUD operations are automatically logged:

```php
// View recent activity
$activities = \App\Models\ActivityLog::recent(7)->get();

// Filter by model
$projectActivities = ActivityLog::forModel(\App\Models\Project::class)->get();

// Filter by user
$userActivities = ActivityLog::byUser(auth()->id())->get();
```

Logged information:
- User who performed action
- Action type (created/updated/deleted)
- Model affected
- Old and new values
- IP address
- User agent

## 🎨 Customization

### CORS Configuration
Edit `config/cors.php`:
```php
'allowed_origins' => ['https://yourdomain.com'],
'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE'],
```

### Security Headers
Edit `app/Http/Middleware/SecurityHeaders.php` to customize CSP and other headers.

### Email Notifications
Implement Mailable classes in event listeners:
```php
// In app/Listeners/SendCommissionNotification.php
Mail::to(config('mail.admin_email'))
    ->send(new NewCommissionNotification($commission));
```

## 🚀 Deployment

### Production Checklist
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure database
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Build assets: `npm run build`
- [ ] Cache config: `php artisan config:cache`
- [ ] Cache routes: `php artisan route:cache`
- [ ] Cache views: `php artisan view:cache`
- [ ] Set up queue worker
- [ ] Configure email (SMTP)
- [ ] Enable HTTPS
- [ ] Set proper file permissions
- [ ] Configure CORS for production domain

### Environment Variables for Production
```env
APP_ENV=production
APP_DEBUG=false

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_DATABASE=protof
DB_USERNAME=your-username
DB_PASSWORD=your-password

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com

CORS_ALLOWED_ORIGINS=https://yourdomain.com
```

## 📚 Documentation

- [ERD Documentation](docs/ERD.md)
- [Enterprise Implementation Guide](docs/ENTERPRISE_IMPLEMENTATION.md)

## 🤝 Contributing

1. Fork the repository
2. Create feature branch: `git checkout -b feature/amazing-feature`
3. Commit changes: `git commit -m 'Add amazing feature'`
4. Push to branch: `git push origin feature/amazing-feature`
5. Open Pull Request

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 🆘 Support

For issues and questions:
- Create an issue on GitHub
- Check documentation in `/docs`
- Review test files for usage examples

## 🏗️ Architecture Patterns

### Repository Pattern
```php
// Usage
$projectRepo = app(ProjectRepository::class);
$projects = $projectRepo->getFilteredProjects(search: 'Laravel');
```

### Event-Listener Pattern
```php
// Dispatch event
event(new CommissionCreated($commission));

// Automatically triggers SendCommissionNotification listener
```

### Policy Authorization
```php
// In controller
$this->authorize('update', $project);

// Policies check admin access automatically
```

### API Resources
```php
// Transform model to JSON
return new ProjectResource($project);
return ProjectResource::collection($projects);
```

---

**Built with Laravel 13** - Following enterprise best practices and industry standards.
