# SkillBridge — Enterprise Software Learning, Live Masterclasses & Career Placement Platform

[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Livewire 3](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-4.x-38BDF8?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)

**SkillBridge** is a full-featured enterprise software learning management system (LMS), real-time live masterclass platform, and developer placement hub built with **Laravel 12**, **Livewire 3**, **Alpine.js**, **Tailwind CSS v4**, and **Domain-Driven Design (DDD)** architecture.

---

## 🌟 Complete Platform Capabilities & Modules

### 🔐 1. Authentication & Security Suite
- **Spatie Role-Based Access Control (RBAC)**: 4 explicit roles (`Super Admin`, `Admin`, `Staff` / Trainer, `Student`).
- **Unified Login (`/login`)**: Role-based automatic dashboard redirection (`RoleRedirectionService`).
- **Brute-Force Protection**: Automatic account lockout after 5 consecutive failed login attempts (15-minute lockout + email notification + audit log entry).
- **5 User States**: Enforces `pending_verification`, `active`, `inactive`, `suspended`, and `blocked` statuses.
- **Profile Completion Wizard (`/complete-profile`)**: Guards student portal routes until profile completion reaches 100%.

---

### 📹 2. Jitsi Live Masterclass & Real-Time Attendance Engine
- **Jitsi Meet IFrame API**: Integrated with `https://meet.jit.si/external_api.js` and configurable `.env` (`JITSI_DOMAIN=meet.jit.si`).
- **Backend Room Security**: Cryptographically generated unpredictable room names (`live_class_` + ULID token).
- **Trainer Live Control Center (`/staff/live-classes`)**:
  - Schedule sessions for assigned courses and cohort batches.
  - Launch Jitsi meeting host room.
  - View real student attendee list, joined/left timestamps, and duration.
  - Export real-time attendance to CSV.
  - Upload private session MP4 recordings and publish for enrolled students.
- **Student Interactive Live Room (`/student/live-classes`)**:
  - View upcoming, starting soon, and live masterclass sessions.
  - Embedded Jitsi meeting with student's real name and email passed into Jitsi `userInfo`.
  - Automated 60-second JavaScript heartbeat ping (`POST /student/live-classes/{liveClass}/heartbeat`).
  - Attendance status rules (`absent` < 10m, `partial` 10m–50%, `attended` >= 50%).
  - Post-session rating (1–5 stars) and feedback form.
- **Admin Oversight (`/admin/live-classes`)**: Global masterclass audit overview, administrative cancellation override, and recording inspection.
- **Scheduled Attendance Pruning (`PruneStaleAttendanceJob`)**: Auto-cleanup for abandoned heartbeat sessions.

---

### 👑 3. Admin Management Portal (`/admin/...`)
- **Executive Dashboard (`/admin/dashboard`)**: Platform Revenue KPI cards, total enrolled students, course completion rates, active trainers, job applications, and quick action shortcuts.
- **User Management (`/admin/users`)**: Search, filter by role/status, edit profiles, assign Spatie roles, suspend, or block accounts.
- **Course & Syllabus Manager (`/admin/courses`, `/admin/lessons`)**: Author courses, categories, versions, modules, and video lessons.
- **Job & Company Management (`/admin/jobs`, `/admin/companies`)**: Manage partner companies, developer job vacancies, requirements, and salaries.
- **Applications & Enrollments (`/admin/applications`, `/admin/enrollments`)**: Track student job applications and manually grant or revoke course access.
- **Financials & Invoices (`/admin/payments`)**: View transaction histories, payment status, orders, and generated PDF invoices.
- **System Audit Logs & Backups (`/admin/activity-logs`, `/admin/backups`)**: Immutable audit logs of sensitive user actions and automated database backups.
- **CMS Manager (`/admin/cms`)**: Edit public landing pages, FAQs, banners, and success stories.

---

### 👨‍🏫 4. Staff & Trainer Portal (`/staff/...`)
- **Trainer Control Center (`/staff/dashboard`)**: Active courses taught, enrolled student counts, assignment submissions pending review, upcoming masterclass schedules.
- **My Courses & Creation (`/staff/dashboard?tab=courses`)**: Manage course curriculum, upload lessons, create chapter quizzes and homework assignments.
- **Cohort & Batch Management (`/staff/dashboard?tab=batches`)**: Organize enrolled students into active learning cohorts with start/end dates and seat limits.
- **Assignment & Quiz Evaluator (`/staff/dashboard?tab=assignments`)**: Grade student code submissions and quiz attempts with feedback.
- **Live Masterclass Management (`/staff/live-classes`)**: Schedule Jitsi sessions, host live video classes, export CSV attendance reports, and publish private video recordings.

---

### 🎓 5. Student Learning Workspace & Dark Navy Theme
- **Theme Aesthetics**: Unified `#0B1F3A` Dark Navy containers with `#07162C` canvas background and `#D62828` Crimson accents.
- **14 Livewire 3 Dashboard Widgets (`/student/dashboard`)**:
  1. Real-time Learning Statistics (Watch time hours, active streak days, progress %).
  2. Active Course Hero Banner with one-click lesson resume.
  3. Upcoming Live Masterclasses Widget.
  4. Pending Assignments Widget.
  5. Chapter Quizzes Widget.
  6. Issued Verified Certificates Widget.
  7. Recommended Courses Widget.
  8. Verified Job Vacancies Widget.
  9. AI ATS Resume Score Widget.
  10. Interactive Learning Calendar.
  11. Continue Learning Shortcut Widget.
  12. Quick Action Shortcuts.
  13. Notifications Widget.
  14. Career Progress Tracker.
- **Enrolled Courses Catalog (`/student/courses`)**: Title search, status filter tabs (*All*, *In Progress*, *Completed*), dropdown filters (*Category*, *Trainer*, *Difficulty*), and sorting (*Recently Accessed*, *Highest Progress*, *Newest*).
- **Course Details Page (`/student/courses/{courseId}`)**: Course progress widget with certificate eligibility status, 9 tabbed sections (*Overview*, *Curriculum Accordion*, *Outcomes*, *Requirements*, *Resources*, *Instructor Profile*, *Reviews*, *FAQs*, *Certificate Eligibility*).
- **Video Learning Player (`/student/courses/{courseId}/learn/{lesson?}`)**:
  - Embedded YouTube player with zero distraction elements.
  - $\ge 90\%$ watch completion sequential unlocking rule.
  - Video controls: Resume watching at saved timecode, Mark Complete, Previous/Next lesson.
  - Timestamped lesson notes (create, edit, delete, live search).
  - Timecode bookmarks (create, remove, live search).
  - Downloadable course attachments with download tracking.
  - Course review submission (guarded for 100% completion).

---

### 💼 6. Career Placement & Practice Hub
- **AI ATS Resume Builder (`/student/career/resume`)**: Create developer resumes, calculate ATS compatibility scores, and generate tailored cover letters.
- **Job Marketplace & Saved Jobs (`/student/career/saved`, `/jobs`)**: Browse tech job vacancies, bookmark postings, set job alerts, and submit applications.
- **Interactive Coding Sandbox (`/student/practice/coding`)**: Browser-based code execution sandbox supporting HTML, CSS, JavaScript, and PHP snippet execution.
- **AI Technical Mock Interviews (`/student/practice/mock`)**: Technical interview simulator for Laravel Architect and Full-Stack roles with instant AI feedback.
- **Skill Assessment Tests (`/student/practice/assessments`)**: Timed multiple-choice software architecture quizzes with score report generation.
- **Verified Certificates (`/student/certificates`)**: Download official certificates with QR code verification.

---

### 🌐 7. Public Website & E-Commerce Storefront
- **Public Home (`/`)**: High-converting LMS landing page, featured courses, career tracks, student success stories, instructor directory, and live statistics.
- **Course & Job Catalog (`/courses`, `/jobs`, `/instructors`, `/blog`, `/pricing`)**: Public course catalog, instructor profiles, blog posts, pricing plans, and events.
- **Checkout & Payment Gateway (`/pricing`, `/checkout`)**: Order processing, checkout interface, and payment gateway integration (`PaymentGatewayService`).

---

## 🛠️ Technology Stack & Architecture

- **Backend Framework**: Laravel 12.x
- **Language**: PHP 8.3
- **Database**: MySQL 8 / SQLite
- **Frontend Stack**: Livewire 3, Alpine.js, Tailwind CSS v4
- **Live Streaming Engine**: Jitsi Meet External API (`JITSI_DOMAIN=meet.jit.si`)
- **Architecture Patterns**: Domain-Driven Design (DDD), Repository Pattern, Service Layer (`JitsiLiveClassService`, `PaymentGatewayService`, `AdzunaJobSyncService`, `RagKnowledgeService`), Custom Middleware & Policies, SOLID Principles.
- **Design System**: Corporate Dark Navy (`#0B1F3A` Midnight Blue, `#07162C` Canvas, `#D62828` Crimson Red, Inter typography).

---

## 🗄️ Core Database Models & Schema

- `User`: User accounts, Spatie roles, profile relations, status states.
- `UserProfile`: Avatars, bios, social links, education, profile completion %.
- `Category`: Course and domain categories.
- `Course`: Title, slug, description, thumbnail, instructor link, pricing.
- `CourseVersion`: Versioning control for course curricula (v1, v2).
- `Module`: Course modules and chapters.
- `Lesson`: Video URL, duration, position, preview status.
- `LessonProgress`: Per-student watch percentage, timecode, completion status.
- `LessonNote`: Student timecode notes.
- `LessonBookmark`: Student timestamped bookmarks.
- `Batch` (`course_cohorts`): Cohort batches, start/end dates, max seat capacity.
- `Enrollment`: Student course access, progress %, active/completed status.
- `LiveClass`: Jitsi room name, trainer ID, course/batch links, start/end times, status, recording URL.
- `LiveClassAttendee`: Joined/left timestamps, heartbeat last seen, duration mins, attendance status.
- `LiveClassMaterial`: PDF slide decks, links, and documents.
- `LiveClassFeedback`: Student 1–5 star ratings and reviews.
- `JobPosting`: Tech vacancies, salaries, locations, company links.
- `JobApplication`: Student resume attachments, cover letters, application status.
- `SavedJob`: Bookmarked job postings & job alert preferences.
- `Certificate`: Verified certificates with unique verification codes.
- `Order` & `OrderItem`: E-commerce purchases and course enrollments.
- `Payment` & `Invoice`: Payment gateway transactions and PDF invoice records.
- `AuditLog`: System audit trail for security and administrative actions.

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
   Add Jitsi configuration parameters to `.env`:
   ```env
   JITSI_DOMAIN=meet.jit.si
   JITSI_USE_JWT=false
   ```

4. **Run Migrations & Seeders**:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Run Automated Test Suite**:
   ```bash
   php artisan test tests/Feature/LiveClassTest.php
   ```

6. **Start Local Development Server**:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

7. **Access Application**:
   Open [http://127.0.0.1:8000](http://127.0.0.1:8000) or `http://192.168.1.15:8000` in your browser and sign in using the demo credentials above.

---

## 📜 Documentation

Detailed architecture specifications and reviews are available in the `docs/` directory:
- [Product Requirements Specification](docs/PRODUCT_REQUIREMENTS.md)
- [System Architecture](docs/ARCHITECTURE.md)
- [Project Feature Audit & Review](docs/PROJECT_REVIEW.md)
- [UI/UX Design System](docs/UI_UX_DESIGN_SYSTEM.md)
