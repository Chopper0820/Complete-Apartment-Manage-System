# Apartment Management and Utility Billing System - TODO List

## 1. Initialize Laravel Project
- Run `composer create-project laravel/laravel .` in the current directory to set up Laravel.
- [x] Laravel project initialized.

## 2. Configure Environment and Database
- Update `.env` file with MySQL database settings.
- Ensure PHP and MySQL are installed and configured.

## 3. Install Necessary Packages
- Install Spatie Laravel-Permission for roles: `composer require spatie/laravel-permission`.
- Install DomPDF for PDF generation: `composer require barryvdh/laravel-dompdf`.
- Install Laravel Excel for reports: `composer require maatwebsite/excel`.
- Install Laravel Breeze for authentication: `composer require laravel/breeze --dev` and `php artisan breeze:install`.
- Publish and configure packages.

## 4. Create Database Migrations
- Create migrations for all tables: users (extend default), apartments, units, tenants, utility_meters, utility_readings, bills, payments, maintenance.
- Define fields: Use DECIMAL for monetary values, enums for statuses, foreign keys with indexes.
- Run `php artisan migrate` after creation.

## 5. Define Eloquent Models
- Create models: User, Apartment, Unit, Tenant, UtilityMeter, UtilityReading, Bill, Payment, Maintenance.
- Define relationships: belongsTo, hasMany, hasOne as per ERD.
- Add fillable, casts, and any custom methods.

## 6. Set Up Authentication and Roles
- Run `php artisan migrate` for Breeze auth tables.
- Configure Spatie Permission: Publish config, create roles (Admin, Manager, Tenant).
- Create middleware for role checks.
- Seed initial admin user and roles.

## 7. Create Controllers and Routes
- Create resource controllers: ApartmentsController, UnitsController, TenantsController, UtilityMetersController, BillsController, PaymentsController, MaintenanceRequestsController.
- Define routes in web.php with middleware for roles.
- Implement CRUD methods in controllers.

## 8. Implement Billing Logic and Services
- Create BillingService class for calculations (units_used, amounts, total bills).
- Create command for monthly bill generation: `php artisan make:command GenerateBills`.
- Schedule the command in app/Console/Kernel.php.
- Handle edge cases like negative readings.

## 9. Create Views
- Create Blade templates for dashboards (admin/manager/tenant).
- Forms for meter readings (use Livewire if possible for real-time calc).
- Bill views and PDF templates with Philippine format (₱, itemized, QR codes).
- Tenant portal for viewing bills and payments.

## 10. Add Notifications and Reports
- Set up Laravel Notifications for email/SMS (use Twilio or local services).
- Create report views with export functionality using Laravel Excel.
- Trigger notifications on bill generation/overdue.

## 11. Integrate Payments
- Integrate GCash/Maya API using Laravel HTTP client.
- Create payment processing logic in PaymentsController.
- Ensure PCI compliance basics.

## 12. Enhance Frontend with Next.js
- Set up Next.js for modern UI.
- Install Shadcn/ui components (Button, Card, Table, Badge).
- Create glassmorphism styles and animations with Framer Motion.
- Update pages with modern design and Philippine-specific features.
- [x] Shadcn/ui components installed.
- [x] Glassmorphism styles added to globals.css.
- [x] Framer Motion animations added to _app.js.
- [x] Home page redesigned with modern UI.

## 13. Test and Finalize
- Seed sample data (apartments, tenants, readings).
- Test CRUD, billing calculations, payments, and PDFs.
- Verify Philippine features (currency, formats).
- Run `php artisan serve` and test locally.
- Add any final touches like error handling and logging.
