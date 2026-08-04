# SkillBridge Platform — Complete Capability Overview & Feature Audit

> [!NOTE]
> This document details the complete feature capabilities, architecture, user workflows, database schema integration, and security model built into the **SkillBridge Commercial Software Course Learning Platform**.

---

## 🛠️ Technology Stack & Architecture

- **Backend**: Laravel 12, PHP 8.3, MySQL 8 / SQLite, Spatie Permission RBAC, Laravel Sanctum.
- **Frontend**: Blade, Livewire 3 (with `#[Lazy]` component streaming), Tailwind CSS, Alpine.js.
- **Architecture**: Domain Driven Design (DDD), Repository Pattern, Service Layer, Custom Middleware, Laravel Policies, Events & Listeners, SOLID Principles.
- **Design System**: Corporate Modernism (`#0B1F3A` Midnight Blue, `#D62828` Crimson Red, Inter Typography, Lucide Icons, Soft Shadow Rounded Cards, Responsive Reflow).

---

## 🔑 1. Enterprise Authentication & Authorization Module

- **4 Explicit Roles**: `Super Admin`, `Admin`, `Staff` (Trainer), and `Student` managed exclusively via **Spatie RBAC** (`roles`, `permissions`, `model_has_roles`). The duplicate `users.role` database column has been completely removed.
- **Single Unified Login (`/login`)**: Automatically redirects users to their dashboard based on role:
  - `super_admin` $\rightarrow$ `/super-admin/dashboard`
  - `admin` $\rightarrow$ `/admin/dashboard`
  - `staff` $\rightarrow$ `/staff/dashboard`
  - `student` $\rightarrow$ `/student/dashboard`
- **Student Self-Registration (`/register`)**: Self-registration for students with mandatory email verification workflow.
- **Account Lockout & Audit**: 5 failed login attempts $\rightarrow$ 15-minute lock + security email alert + audit log entry.
- **User Account States**: 5 enum states (`pending_verification`, `active`, `inactive`, `suspended`, `blocked`).
- **Profile & Preferences**: Profile Completion Onboarding (`/complete-profile`), Profile Settings (`/settings/profile`), Password Change (`/settings/change-password`), and Active Session Manager (`/settings/sessions`).

---

## 📊 2. Student Dashboard Module (`/student/dashboard`)

Serves as the student's primary home canvas, embedding **14 Livewire 3 widgets**:

| Widget Component | Description & Key Functionality |
| :--- | :--- |
| **WelcomeBanner** | Greeting ("Good Evening, Student"), 5-day learning streak 🔥, active cohort, "Resume Active Lesson" CTA. |
| **LearningStatistics** | 7 metric cards (Purchased, In Progress, Completed, Certificates, Watch Hours, Streak, Overall Progress %). |
| **ContinueLearning** | Hero active course card showing current module, lesson, progress bar, estimated remaining time. |
| **UpcomingClasses** | Live sessions with trainer avatars, date/time, and "Join Class" buttons. |
| **PendingAssignments** | Assignments due with priority badges (High / Medium) and submit links. |
| **UpcomingQuizzes** | Module chapter quizzes with duration and attempts left. |
| **RecentCertificates** | Issued certificates with UUID verification tokens, PDF download, and QR verify links. |
| **RecommendedCourses** | AI-matched course recommendations based on student learning history. |
| **RecommendedJobs** | Verified job vacancies matched to student skills with "Easy Apply" CTA. |
| **CareerProgress** | Resume ATS Score ring (88/100), job applications pipeline, and skill gap boosts. |
| **LearningCalendar** | Timeline schedule for classes, assignment deadlines, and interviews. |
| **NotificationsWidget** | Real-time activity feed for grades, certificates, and job updates. |
| **QuickActions** | Grid of 6 quick action shortcuts. |
| **AIInsightCard** | Personal AI career coach advice card. |

---

## 📚 3. My Learning Workspace (`/student/courses`)

### A. Enrolled Courses Catalog (`/student/courses`)
- **Query Engine**: Restricts catalog strictly to courses the authenticated student is enrolled in (`Enrollment::where('user_id', auth()->id())`).
- **Search & Filters**: Search by title, status filter tabs (*All*, *In Progress*, *Completed*), Category dropdown, Instructor dropdown, and Difficulty dropdown (*Beginner*, *Intermediate*, *Advanced*).
- **Sorting Options**: Sort by *Recently Accessed*, *Highest Progress %*, and *Newest Enrolled*.
- **Course Cards**: Thumbnail, Course Title, Category badge, Difficulty badge, Instructor name, Total Duration, Lessons Completed counter (e.g. `2 / 5 lessons completed`), Current Lesson title, Progress percentage bar, and "Continue Learning" CTA.

### B. Course Details Page (`/student/courses/{courseId}`)
- **Authorization Guard**: Blocks non-enrolled students with a `403 Unauthorized` alert.
- **Course Progress Header**: Overall progress %, lessons completed counter, current lesson indicator, and Certificate Eligibility Status (e.g., *Requires 100% Completion*).
- **Tabbed Interface**:
  - **Overview**: Description, difficulty level, watch time, access type.
  - **Curriculum Syllabus**: Expandable modules & lessons list showing lesson durations, completion state, and sequential lock status (`Completed ✓`, `Unlocked`, `Locked 🔒`).
  - **Learning Outcomes**: Key learning objectives list.
  - **Requirements**: System prerequisites.
  - **Downloadable Resources**: Real downloadable files with versions, file sizes, and download counters.
  - **Instructor Profile**: Instructor name, title, bio, and avatar.
  - **Reviews**: Rating breakdown (⭐ 4.9 / 5.0) and student reviews list.
  - **FAQs**: Frequently asked questions accordion.
  - **Certificate Eligibility**: Criteria status and requirements checklist.

### C. Video Learning Player (`/student/courses/{courseId}/learn/{lesson?}`)
- **In-LMS Video Player**: Parses YouTube URLs into clean, embedded iframe players (`youtube-nocookie.com`, `modestbranding=1`, `rel=0`). Students are never redirected to YouTube.
- **Sequential Lesson Unlocking Rule**: Lesson $N+1$ unlocks only when Lesson $N$ achieves $\ge 90\%$ watch completion.
- **Video Controls**: Previous Lesson, Next Lesson, Resume Watching indicator (saved timecode), and "Mark Lesson Complete" button.
- **Timestamped Lesson Notes**: Create, edit, delete, and search personal notes linked to specific video timecodes (e.g. `04:15`).
- **Timecode Bookmarks**: Add and search video timecode bookmarks.
- **Resource Downloads**: Download PDFs, Source Code ZIPs, and reference files with automatic `download_count` incrementing.
- **Course Reviews**: 1-5 Star Ratings and written reviews (unlocked strictly after 100% course completion).
- **Real Learning Analytics**: Computes Overall Progress %, Course Progress %, Module Progress %, Total Learning Hours & Time Spent (calculated from `lesson_progress.watch_time_seconds`), and Remaining Time.

---

## 🛠️ Test Credentials Seeded in Database

| Role | Email | Password | Dashboard Endpoint |
| :--- | :--- | :--- | :--- |
| **Student** | `student@skillbridge.com` | `SkillBridge2026!` | `/student/dashboard` |
| **Super Admin** | `superadmin@skillbridge.com` | `SkillBridge2026!` | `/super-admin/dashboard` |
| **Admin** | `admin@skillbridge.com` | `SkillBridge2026!` | `/admin/dashboard` |
| **Staff (Trainer)** | `staff@skillbridge.com` | `SkillBridge2026!` | `/staff/dashboard` |
