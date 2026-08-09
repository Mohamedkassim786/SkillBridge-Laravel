# SkillBridge Architecture & Project Structure Guide

## 1. Overview
SkillBridge is an enterprise Learning Management and Career Placement Platform built with **Laravel 12**, **Livewire 3/4**, **Spatie Laravel-Permission**, and **Jitsi WebRTC Engine**.

## 2. Directory Architecture

```
app/
├── Console/Commands/              # Custom Artisan CLI commands
├── Domain/                        # Business logic grouped by domain feature
│   ├── Ai/                        # LLM Provider integrations & ATS analysis
│   ├── Auth/                      # Authentication, User profiles & Login histories
│   ├── Courses/                   # Course management & review repositories
│   ├── Jobs/                      # Job postings & application sync services
│   ├── LiveClasses/               # WebRTC Live Class domain services
│   ├── Payments/                  # Gateway transactions & invoice handling
│   └── Student/                   # Student dashboard & learning repositories
├── Http/
│   ├── Controllers/               # Thin controllers (Admin, Api, Auth, Staff, Student)
│   ├── Middleware/                # Custom auth, role & profile completion middleware
│   ├── Requests/                  # Form requests (LiveClasses, Auth, Student)
│   └── Resources/                 # API JSON response transformers
├── Jobs/                          # Queued background jobs (Scheduler & Notifications)
├── Livewire/                      # Interactive Livewire components (Role-scoped)
│   ├── Admin/
│   ├── Auth/
│   ├── Public/
│   ├── Staff/
│   ├── Student/
│   └── SuperAdmin/
├── Models/                        # Centralized Eloquent Models (47 models)
├── Notifications/                 # Notification classes (LiveClasses, Courses, Payments)
├── Policies/                      # Authorization policies (CoursePolicy, LiveClassPolicy)
└── Providers/                     # Service providers & repository interface bindings

config/                            # Configuration files (jitsi.php, app.php, services.php)
database/                          # Migrations, Factories & Seeders
routes/                            # Route manifests (web.php, api.php, console.php)
tests/                             # Feature & Unit test suites (Role & Feature scoped)
```

## 3. Architecture Guidelines

### Core Principles
- **Thin Controllers**: Controllers handle request dispatching, authorization, and response formatting.
- **Domain Services**: Business logic belongs inside `app/Domain/{Feature}/Services/`.
- **Form Requests**: All HTTP input validation uses Form Requests under `app/Http/Requests/{Feature}/`.
- **Authorization Policies**: Use policies (`CoursePolicy`, `LiveClassPolicy`) and gates for model-level permission enforcement.
- **Livewire Components**: Interactive components organized under role namespaces (`app/Livewire/Student/`, `app/Livewire/SuperAdmin/`, etc.).

### WebRTC Jitsi Live Classes
- Configuration is loaded via `config/jitsi.php` and `.env` variables (`JITSI_DOMAIN`, `JITSI_USE_JWT`, `JITSI_APP_ID`, `JITSI_APP_SECRET`, `JITSI_TOKEN_TTL`).
- Domain logic is managed by `App\Domain\LiveClasses\Services\JitsiLiveClassService`.
- Automated class status updates (`UpdateClassStatusJob`) and stale attendance pruning (`PruneStaleAttendanceJob`) are scheduled in `routes/console.php`.

## 4. Useful CLI Commands

```bash
# Clear application & view caches
php artisan optimize:clear

# Regenerate Composer Autoload
composer dump-autoload

# List all registered routes
php artisan route:list

# Run automated test suite
php artisan test
```
