# SkillBridge — Enterprise Software Learning & Career Platform

[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Livewire 3](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-4.x-38BDF8?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)

**SkillBridge** is a commercial software course learning and placement platform built with **Laravel 12**, **Livewire 3**, and **Domain-Driven Design (DDD)** architecture.

---

## 🚀 Product Scope & Key Features

### 🔑 1. Enterprise Authentication & Authorization
- **Spatie RBAC**: 4 explicit roles (`Super Admin`, `Admin`, `Staff` / Trainer, `Student`).
- **Unified Login (`/login`)**: Single login page with role-based dashboard redirection (`RoleRedirectionService`).
- **Security & Protection**: Account lockout after 5 failed login attempts (15-min lockout + email notification + audit log).
- **User Account States**: 5 enum states (`pending_verification`, `active`, `inactive`, `suspended`, `blocked`).

### 📊 2. Student Dashboard
- **14 Livewire 3 Widgets**: Real-time learning statistics, active course hero banner, upcoming live classes, pending assignments, chapter quizzes, issued certificates with QR verification, recommended courses, verified job vacancies, ATS resume score, learning calendar, and personal AI career advisor.

### 📚 3. My Learning Workspace
- **My Courses Catalog (`/student/courses`)**: Enrolled courses with title search, status filter tabs (*All*, *In Progress*, *Completed*), Category/Trainer/Difficulty dropdown filters, sorting options (*Recently Accessed*, *Highest Progress*, *Newest*), and responsive course cards.
- **Course Details Page (`/student/courses/{courseId}`)**: Course progress widget with certificate eligibility status, 9 tabbed sections (*Overview*, *Curriculum Accordion*, *Outcomes*, *Requirements*, *Resources*, *Instructor Profile*, *Reviews*, *FAQs*, *Certificate Eligibility*).
- **Video Learning Player (`/student/courses/{courseId}/learn/{lesson?}`)**:
  - Embedded YouTube video player (no YouTube redirects).
  - Sequential lesson unlocking rule ($\ge 90\%$ watch completion required to unlock next lesson).
  - Video controls: Previous/Next lesson, Mark Complete, Resume Watching at saved timecode.
  - Timestamped lesson notes (create, edit, delete, live search).
  - Timecode bookmarks (create, remove, live search).
  - Downloadable course files with download count tracking.
  - Course reviews (guarded for 100% completed courses).
  - Real-time database learning analytics.

---

## 🛠️ Technology Stack & Architecture

- **Backend Framework**: Laravel 12.x
- **Language**: PHP 8.3
- **Database**: MySQL 8 / SQLite
- **Frontend Stack**: Livewire 3, Alpine.js, Tailwind CSS v4
- **Architecture Patterns**: Domain-Driven Design (DDD), Repository Pattern, Service Layer, Custom Middleware & Policies, SOLID Principles.
- **Design System**: Corporate Modernism (`#0B1F3A` Midnight Blue, `#D62828` Crimson Red, Inter typography).

---

## 🔐 Demo Test Credentials

| Role | Email | Password | Dashboard Endpoint |
| :--- | :--- | :--- | :--- |
| **Student** | `student@skillbridge.com` | `SkillBridge2026!` | `/student/dashboard` |
| **Super Admin** | `superadmin@skillbridge.com` | `SkillBridge2026!` | `/super-admin/dashboard` |
| **Admin** | `admin@skillbridge.com` | `SkillBridge2026!` | `/admin/dashboard` |
| **Staff (Trainer)** | `staff@skillbridge.com` | `SkillBridge2026!` | `/staff/dashboard` |

---

## 💻 Local Setup & Installation

### Prerequisites
- PHP $\ge 8.3$
- Composer
- Node.js & NPM

### Setup Instructions

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/Mohamedkassim786/SkillBridge-Laravel.git
   cd SkillBridge-Laravel
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start Local Development Servers**:
   ```bash
   npm run dev
   php artisan serve
   ```

6. **Access Application**:
   Open [http-[#]127.0.0.1:8000](http://127.0.0.1:8000) in your browser and sign in using the demo student credentials above.

---

## 📜 Documentation

Detailed architecture specifications and reviews are available in the `docs/` directory:
- [Product Requirements Specification](docs/PRODUCT_REQUIREMENTS.md)
- [System Architecture](docs/ARCHITECTURE.md)
- [Project Feature Audit & Review](docs/PROJECT_REVIEW.md)
- [UI/UX Design System](docs/UI_UX_DESIGN_SYSTEM.md)
