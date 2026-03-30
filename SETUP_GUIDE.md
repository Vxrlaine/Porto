# Setup Guide - Creative Portfolio System

This guide will help you set up and run the complete portfolio system with admin panel, CRUD operations, and commission ordering.

## Prerequisites

- PHP 8.4+
- Composer
- Node.js & NPM
- SQLite (or your preferred database)

## Installation Steps

### 1. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 2. Environment Setup

```bash
# Copy environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup

```bash
# Create SQLite database
type nul > database\database.sqlite

# Run migrations
php artisan migrate
```

### 4. Create Admin User

```bash
# Seed the admin user
php artisan db:seed --class=AdminUserSeeder
```

**Default Admin Credentials:**
- Email: `admin@portfolio.com`
- Password: `password`

**Default Regular User:**
- Email: `user@portfolio.com`
- Password: `password`

> ⚠️ **Important:** Change these passwords in production!

### 5. Build Assets

```bash
# Build frontend assets
npm run build

# Or for development with hot reload
npm run dev
```

### 6. Create Storage Link

```bash
# Create symbolic link for file uploads
php artisan storage:link
```

### 7. Run the Application

```bash
# Start development server
php artisan serve
```

Visit: `http://localhost:8000`

## Features Overview

### Public Features

1. **Portfolio Homepage**
   - Creative header with animations
   - About section
   - Project carousel (My Design section)
   - Experience section
   - Commission order button

2. **Commission Order System**
   - Public commission order form
   - File upload for reference images
   - Client-side and server-side validation
   - Order status tracking

3. **Authentication**
   - Login page
   - Registration page
   - Logout functionality

### Admin Features (Protected by Middleware)

1. **Dashboard**
   - Statistics overview
   - Recent commissions
   - Quick access to all sections

2. **Projects CRUD**
   - Create, Read, Update, Delete projects
   - Image upload support
   - Order management
   - Active/Inactive toggle

3. **Skills CRUD**
   - Create, Read, Update, Delete skills
   - Proficiency level slider (0-100%)
   - Category organization
   - Order management

4. **Commissions Management**
   - View all commission orders
   - Filter by status
   - Search by client
   - Update order status
   - Assign to admin users
   - Add admin notes
   - View reference images

## Routes Overview

### Public Routes
```
GET  /                    - Homepage
GET  /commissions         - Commission order form
POST /commissions         - Submit commission order
GET  /login               - Login page
POST /login               - Process login
GET  /register            - Registration page
POST /register            - Process registration
POST /logout              - Logout
```

### Admin Routes (Protected)
```
GET  /admin/dashboard     - Admin dashboard
GET  /admin/projects      - List projects
GET  /admin/projects/create - Create project form
POST /admin/projects      - Store project
GET  /admin/projects/{id} - View project
GET  /admin/projects/{id}/edit - Edit project form
PUT  /admin/projects/{id} - Update project
DELETE /admin/projects/{id} - Delete project

GET  /admin/skills        - List skills
GET  /admin/skills/create - Create skill form
POST /admin/skills        - Store skill
GET  /admin/skills/{id}   - View skill
GET  /admin/skills/{id}/edit - Edit skill form
PUT  /admin/skills/{id}   - Update skill
DELETE /admin/skills/{id} - Delete skill

GET  /admin/commissions   - List commissions
GET  /admin/commissions/{id} - View commission details
PATCH /admin/commissions/{id}/status - Update status
POST /admin/commissions/{id}/assign - Assign to user
DELETE /admin/commissions/{id} - Delete commission
```

## File Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── DashboardController.php
│   │   │   ├── ProjectController.php
│   │   │   ├── SkillController.php
│   │   │   └── CommissionController.php
│   │   ├── Auth/
│   │   │   └── AuthController.php
│   │   ├── HomeController.php
│   │   └── CommissionOrderController.php
│   └── Middleware/
│       ├── Authenticate.php
│       └── AdminMiddleware.php
├── Models/
│   ├── User.php
│   ├── Project.php
│   ├── Skill.php
│   └── Commission.php
database/
├── migrations/
│   ├── 2026_03_30_000003_add_is_admin_to_users_table.php
│   ├── 2026_03_30_000004_create_projects_table.php
│   ├── 2026_03_30_000005_create_skills_table.php
│   └── 2026_03_30_000006_create_commissions_table.php
└── seeders/
    └── AdminUserSeeder.php
resources/
├── views/
│   ├── admin/
│   │   ├── layout.blade.php
│   │   ├── dashboard.blade.php
│   │   ├── projects/
│   │   ├── skills/
│   │   └── commissions/
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── commissions/
│   │   └── create.blade.php
│   └── welcome.blade.php
```

## Commission Status Flow

```
pending → reviewing → accepted → in_progress → completed
              ↓            ↓
          rejected    cancelled
```

### Status Descriptions

- **pending**: New order awaiting review
- **reviewing**: Admin is reviewing the order
- **accepted**: Order accepted, awaiting payment
- **in_progress**: Work in progress
- **completed**: Order completed and delivered
- **cancelled**: Order cancelled by client
- **rejected**: Order rejected by admin

## Troubleshooting

### Permission Issues

```bash
# Ensure storage directory is writable
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

### Database Issues

```bash
# Fresh migration (WARNING: deletes all data)
php artisan migrate:fresh --seed

# Rollback last migration
php artisan migrate:rollback
```

### Asset Issues

```bash
# Clear asset cache
php artisan view:clear
php artisan config:clear

# Rebuild assets
npm run build
```

## Security Recommendations

1. Change default admin password immediately
2. Enable HTTPS in production
3. Set `APP_DEBUG=false` in production
4. Use strong passwords
5. Regularly update dependencies
6. Backup your database regularly

## Customization

### Adding More Admin Users

```bash
php artisan tinker

>>> App\Models\User::create([
>>>     'name' => 'New Admin',
>>>     'email' => 'newadmin@example.com',
>>>     'password' => Hash::make('password'),
>>>     'is_admin' => true,
>>> ]);
```

### Changing Commission Statuses

Edit `app/Models/Commission.php` and update the `getStatusColorAttribute()` method.

### Adding Custom Validation

Edit the respective controller's `store()` and `update()` methods.

## Support

For issues or questions, please check:
- Laravel Documentation: https://laravel.com/docs
- Project README.md

---

**Enjoy your Creative Portfolio System!** 🎨
