# Production 3NF Normalized Database Schema Specification - SkillBridge

This document defines the complete, production-ready **Third Normal Form (3NF)** database design for **SkillBridge Learning and Career Portal**, covering all **21 requested functional domains**.

---

## 1. Domain Coverage Matrix (21 Domains)

| Domain | Tables Included | Key Features & Constraints |
| :--- | :--- | :--- |
| **1. Authentication** | `personal_access_tokens`, `password_reset_tokens` | Sanctum tokens, token expiration, hashed reset tokens. |
| **2. Users & Roles** | `roles`, `permissions`, `role_has_permissions`, `users`, `model_has_roles` | 7-role RBAC, 2FA secret support, soft deletes. |
| **3. Courses** | `categories`, `courses`, `course_prerequisites` | Slugs, pricing, levels, status, categories taxonomy. |
| **4. Lessons** | `modules`, `lessons`, `lesson_progress` | YouTube video ID, duration, non-skippable watch time %. |
| **5. Batches** | `batches`, `batch_user` | Scheduled cohort dates, seat limits, trainer assignments. |
| **6. Enrollments** | `enrollments` | Progress %, completion status (`active`, `completed`, `refunded`). |
| **7. Quizzes** | `quizzes`, `quiz_questions`, `quiz_options`, `quiz_attempts`, `quiz_answers` | MCQ options, auto-grading, pass percentage ($\ge 80\%$). |
| **8. Assignments** | `assignments`, `assignment_submissions` | Due dates, score limits, file attachment URLs, trainer feedback. |
| **9. Certificates** | `certificates` | Cryptographic UUIDs, PDF path, public QR verification. |
| **10. Orders** | `orders`, `order_items` | Subtotal, discounts, tax, coupon codes, status. |
| **11. Payments** | `payments`, `payment_webhooks` | Gateway (`razorpay`, `stripe`), tx ID, webhook log signatures. |
| **12. Companies** | `companies` | Slug, logo URL, verification badge, domain, profile. |
| **13. Recruiters** | `recruiters` | Linking users to companies, designation, approval status. |
| **14. Jobs** | `job_categories`, `job_postings` | Source (`internal`, `adzuna`, `remoteok`), salary min/max. |
| **15. Applications** | `job_applications`, `application_status_histories` | Resume FK, ATS match score, 6-stage pipeline history. |
| **16. Resumes** | `user_resumes` | Extracted JSON skills, file path, default flag. |
| **17. AI Results** | `ai_analysis_results` | ATS score breakdown, missing keywords, course recommendations. |
| **18. Notifications** | `notifications`, `user_notification_settings` | Multi-channel dispatch (Database, Email, Push). |
| **19. Reports** | `placement_reports`, `revenue_reports` | Monthly placement rates, trainer payouts, aggregated revenue. |
| **20. Settings** | `system_settings` | Key-value application settings, gateway toggles, platform fees. |
| **21. Audit Logs** | `audit_logs` | User ID, action, IP, user-agent, JSON state before/after. |

---

## 2. Complete Mermaid Database ER Diagram

```mermaid
erDiagram
    USERS ||--o{ RECRUITERS : belongs_to
    COMPANIES ||--o{ RECRUITERS : employs
    COMPANIES ||--o{ JOB_POSTINGS : lists
    
    USERS ||--o{ ENROLLMENTS : enrolls
    COURSES ||--o{ ENROLLMENTS : has
    COURSES ||--o{ MODULES : contains
    MODULES ||--o{ LESSONS : contains
    LESSONS ||--o{ LESSON_PROGRESS : tracks
    USERS ||--o{ LESSON_PROGRESS : achieves

    MODULES ||--o{ QUIZZES : has
    QUIZZES ||--o{ QUIZ_QUESTIONS : contains
    QUIZ_QUESTIONS ||--o{ QUIZ_OPTIONS : has
    QUIZZES ||--o{ QUIZ_ATTEMPTS : receives
    USERS ||--o{ QUIZ_ATTEMPTS : attempts

    COURSES ||--o{ ASSIGNMENTS : contains
    ASSIGNMENTS ||--o{ ASSIGNMENT_SUBMISSIONS : receives
    USERS ||--o{ ASSIGNMENT_SUBMISSIONS : submits

    USERS ||--o{ CERTIFICATES : earns
    COURSES ||--o{ CERTIFICATES : grants

    USERS ||--o{ ORDERS : places
    ORDERS ||--o{ ORDER_ITEMS : contains
    ORDERS ||--o{ PAYMENTS : paid_by

    JOB_POSTINGS ||--o{ JOB_APPLICATIONS : receives
    USERS ||--o{ JOB_APPLICATIONS : applies
    USERS ||--o{ USER_RESUMES : owns
    USER_RESUMES ||--o{ JOB_APPLICATIONS : attaches

    JOB_APPLICATIONS ||--o{ APPLICATION_STATUS_HISTORIES : tracks
    JOB_APPLICATIONS ||--o{ AI_ANALYSIS_RESULTS : analyzed_by

    USERS ||--o{ AUDIT_LOGS : performs
    USERS ||--o{ NOTIFICATIONS : receives

    USERS {
        bigint id PK
        string name
        string email UK
        string password
        string phone
        enum status "active, suspended, pending"
        string two_factor_secret
        timestamp email_verified_at
        timestamps
        softDeletes
    }

    ROLES {
        bigint id PK
        string name UK "super_admin, admin, trainer, student, recruiter, company_admin, guest"
        string guard_name
        timestamps
    }

    COMPANIES {
        bigint id PK
        string name
        string slug UK
        string logo_path
        string website
        boolean is_verified
        timestamps
    }

    RECRUITERS {
        bigint id PK
        bigint user_id FK UK
        bigint company_id FK
        string designation
        boolean is_approved
        timestamps
    }

    COURSES {
        bigint id PK
        bigint category_id FK
        bigint trainer_id FK
        string title
        string slug UK
        text description
        decimal price
        enum level "beginner, intermediate, advanced"
        boolean is_published
        timestamps
    }

    LESSONS {
        bigint id PK
        bigint module_id FK
        string title
        string youtube_video_id
        integer duration_seconds
        integer sort_order
        timestamps
    }

    LESSON_PROGRESS {
        bigint id PK
        bigint user_id FK
        bigint lesson_id FK
        integer watch_time_seconds
        integer watch_percentage
        boolean is_completed
        timestamps
    }

    QUIZZES {
        bigint id PK
        bigint module_id FK
        string title
        integer pass_percentage "Default 80"
        timestamps
    }

    QUIZ_ATTEMPTS {
        bigint id PK
        bigint quiz_id FK
        bigint user_id FK
        integer score_percentage
        boolean is_passed
        timestamps
    }

    CERTIFICATES {
        bigint id PK
        string uuid UK
        bigint user_id FK
        bigint course_id FK
        string pdf_path
        timestamp issued_at
    }

    ORDERS {
        bigint id PK
        string order_number UK
        bigint user_id FK
        decimal total_amount
        enum status "pending, completed, cancelled, refunded"
        timestamps
    }

    PAYMENTS {
        bigint id PK
        bigint order_id FK
        string transaction_id UK
        string gateway "razorpay, stripe"
        decimal amount
        enum status "pending, completed, failed, refunded"
        json gateway_response
        timestamps
    }

    JOB_POSTINGS {
        bigint id PK
        bigint company_id FK "Nullable if API job"
        string source "internal, adzuna, remoteok"
        string external_id
        string title
        text description
        string location
        decimal salary_min
        decimal salary_max
        enum status "draft, active, closed"
        timestamps
    }

    JOB_APPLICATIONS {
        bigint id PK
        bigint job_posting_id FK
        bigint user_id FK
        bigint resume_id FK
        integer ai_ats_score
        enum status "submitted, under_review, shortlisted, interview_scheduled, hired, rejected"
        timestamps
    }

    USER_RESUMES {
        bigint id PK
        bigint user_id FK
        string title
        string file_path
        json parsed_skills
        boolean is_default
        timestamps
    }

    AI_ANALYSIS_RESULTS {
        bigint id PK
        bigint application_id FK
        integer ats_score
        json keyword_matches
        json missing_skills
        json recommended_course_ids
        timestamps
    }

    AUDIT_LOGS {
        bigint id PK
        bigint user_id FK
        string action
        string ip_address
        string user_agent
        json metadata
        timestamp created_at
    }
```

---

## 3. Normalized Relational Table Definitions (Detailed 3NF Specifications)

### Domain 1: Authentication & Domain 2: Users & Roles

#### `users`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `name`: `VARCHAR(255) NOT NULL`
- `email`: `VARCHAR(255) NOT NULL UNIQUE`
- `password`: `VARCHAR(255) NOT NULL`
- `phone`: `VARCHAR(20) NULL`
- `status`: `ENUM('active', 'suspended', 'pending') DEFAULT 'active'`
- `two_factor_secret`: `TEXT NULL`
- `email_verified_at`: `TIMESTAMP NULL`
- `created_at`, `updated_at`, `deleted_at` (Soft Deletes)
- **Indices**: `idx_users_email` (`email`), `idx_users_status` (`status`)

#### `roles`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `name`: `VARCHAR(255) NOT NULL UNIQUE` (`super_admin`, `admin`, `trainer`, `student`, `recruiter`, `company_admin`, `guest`)
- `guard_name`: `VARCHAR(255) DEFAULT 'web'`
- `created_at`, `updated_at`

#### `model_has_roles`
- `role_id`: `BIGINT UNSIGNED FK -> roles(id) ON DELETE CASCADE`
- `model_type`: `VARCHAR(255)`
- `model_id`: `BIGINT UNSIGNED`
- **Primary Key**: (`role_id`, `model_id`, `model_type`)

---

### Domain 3: Courses & Domain 4: Lessons

#### `categories`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `name`: `VARCHAR(255) NOT NULL`
- `slug`: `VARCHAR(255) NOT NULL UNIQUE`
- `icon_path`: `VARCHAR(255) NULL`
- `created_at`, `updated_at`

#### `courses`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `category_id`: `BIGINT UNSIGNED FK -> categories(id) ON DELETE RESTRICT`
- `trainer_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `title`: `VARCHAR(255) NOT NULL`
- `slug`: `VARCHAR(255) NOT NULL UNIQUE`
- `description`: `LONGTEXT NOT NULL`
- `price`: `DECIMAL(10,2) NOT NULL DEFAULT 0.00`
- `level`: `ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner'`
- `is_published`: `BOOLEAN DEFAULT FALSE`
- `created_at`, `updated_at`
- **Indices**: `idx_courses_slug` (`slug`), `idx_courses_trainer` (`trainer_id`), `idx_courses_published` (`is_published`)

#### `modules`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `course_id`: `BIGINT UNSIGNED FK -> courses(id) ON DELETE CASCADE`
- `title`: `VARCHAR(255) NOT NULL`
- `sort_order`: `INT UNSIGNED DEFAULT 0`
- `created_at`, `updated_at`

#### `lessons`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `module_id`: `BIGINT UNSIGNED FK -> modules(id) ON DELETE CASCADE`
- `title`: `VARCHAR(255) NOT NULL`
- `youtube_video_id`: `VARCHAR(255) NOT NULL`
- `duration_seconds`: `INT UNSIGNED NOT NULL DEFAULT 0`
- `sort_order`: `INT UNSIGNED DEFAULT 0`
- `created_at`, `updated_at`

#### `lesson_progress`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `lesson_id`: `BIGINT UNSIGNED FK -> lessons(id) ON DELETE CASCADE`
- `watch_time_seconds`: `INT UNSIGNED DEFAULT 0`
- `watch_percentage`: `TINYINT UNSIGNED DEFAULT 0` ($\ge 90\%$ unlocks next)
- `is_completed`: `BOOLEAN DEFAULT FALSE`
- `created_at`, `updated_at`
- **Unique Constraint**: (`user_id`, `lesson_id`)

---

### Domain 5: Batches & Domain 6: Enrollments

#### `batches`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `course_id`: `BIGINT UNSIGNED FK -> courses(id) ON DELETE CASCADE`
- `name`: `VARCHAR(255) NOT NULL`
- `max_seats`: `INT UNSIGNED DEFAULT 50`
- `start_date`: `DATE NOT NULL`
- `end_date`: `DATE NOT NULL`
- `created_at`, `updated_at`

#### `enrollments`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `course_id`: `BIGINT UNSIGNED FK -> courses(id) ON DELETE CASCADE`
- `batch_id`: `BIGINT UNSIGNED NULL FK -> batches(id) ON DELETE SET NULL`
- `progress_percent`: `TINYINT UNSIGNED DEFAULT 0`
- `status`: `ENUM('active', 'completed', 'refunded') DEFAULT 'active'`
- `completed_at`: `TIMESTAMP NULL`
- `created_at`, `updated_at`
- **Unique Constraint**: (`user_id`, `course_id`)

---

### Domain 7: Quizzes & Domain 8: Assignments

#### `quizzes`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `module_id`: `BIGINT UNSIGNED FK -> modules(id) ON DELETE CASCADE`
- `title`: `VARCHAR(255) NOT NULL`
- `pass_percentage`: `TINYINT UNSIGNED DEFAULT 80`
- `created_at`, `updated_at`

#### `quiz_questions`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `quiz_id`: `BIGINT UNSIGNED FK -> quizzes(id) ON DELETE CASCADE`
- `question_text`: `TEXT NOT NULL`
- `points`: `INT UNSIGNED DEFAULT 1`
- `created_at`, `updated_at`

#### `quiz_options`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `question_id`: `BIGINT UNSIGNED FK -> quiz_questions(id) ON DELETE CASCADE`
- `option_text`: `TEXT NOT NULL`
- `is_correct`: `BOOLEAN DEFAULT FALSE`
- `created_at`, `updated_at`

#### `quiz_attempts`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `quiz_id`: `BIGINT UNSIGNED FK -> quizzes(id) ON DELETE CASCADE`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `score_percentage`: `TINYINT UNSIGNED NOT NULL`
- `is_passed`: `BOOLEAN NOT NULL`
- `created_at`, `updated_at`

#### `assignments`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `course_id`: `BIGINT UNSIGNED FK -> courses(id) ON DELETE CASCADE`
- `title`: `VARCHAR(255) NOT NULL`
- `description`: `TEXT NOT NULL`
- `due_date`: `TIMESTAMP NULL`
- `max_score`: `INT UNSIGNED DEFAULT 100`
- `created_at`, `updated_at`

#### `assignment_submissions`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `assignment_id`: `BIGINT UNSIGNED FK -> assignments(id) ON DELETE CASCADE`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `submission_file_path`: `VARCHAR(255) NOT NULL`
- `score`: `INT UNSIGNED NULL`
- `feedback`: `TEXT NULL`
- `status`: `ENUM('submitted', 'graded', 'resubmit_required') DEFAULT 'submitted'`
- `created_at`, `updated_at`

---

### Domain 9: Certificates

#### `certificates`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `uuid`: `VARCHAR(36) NOT NULL UNIQUE` (e.g. `SKB-2026-8F92A-4B01`)
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `course_id`: `BIGINT UNSIGNED FK -> courses(id) ON DELETE CASCADE`
- `pdf_path`: `VARCHAR(255) NOT NULL`
- `issued_at`: `TIMESTAMP NOT NULL`
- `created_at`, `updated_at`
- **Indices**: `idx_cert_uuid` (`uuid`)

---

### Domain 10: Orders & Domain 11: Payments

#### `orders`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `order_number`: `VARCHAR(32) NOT NULL UNIQUE`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `subtotal`: `DECIMAL(10,2) NOT NULL`
- `discount_amount`: `DECIMAL(10,2) DEFAULT 0.00`
- `total_amount`: `DECIMAL(10,2) NOT NULL`
- `status`: `ENUM('pending', 'completed', 'cancelled', 'refunded') DEFAULT 'pending'`
- `created_at`, `updated_at`

#### `payments`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `order_id`: `BIGINT UNSIGNED FK -> orders(id) ON DELETE CASCADE`
- `transaction_id`: `VARCHAR(255) NOT NULL UNIQUE`
- `gateway`: `ENUM('razorpay', 'stripe') NOT NULL`
- `amount`: `DECIMAL(10,2) NOT NULL`
- `currency`: `VARCHAR(3) DEFAULT 'INR'`
- `status`: `ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending'`
- `gateway_response`: `JSON NULL`
- `created_at`, `updated_at`

---

### Domain 12: Companies, Domain 13: Recruiters, Domain 14: Jobs & Domain 15: Applications

#### `companies`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `name`: `VARCHAR(255) NOT NULL`
- `slug`: `VARCHAR(255) NOT NULL UNIQUE`
- `logo_path`: `VARCHAR(255) NULL`
- `website`: `VARCHAR(255) NULL`
- `is_verified`: `BOOLEAN DEFAULT FALSE`
- `created_at`, `updated_at`

#### `recruiters`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE UNIQUE`
- `company_id`: `BIGINT UNSIGNED FK -> companies(id) ON DELETE CASCADE`
- `designation`: `VARCHAR(255) NOT NULL`
- `is_approved`: `BOOLEAN DEFAULT FALSE`
- `created_at`, `updated_at`

#### `job_postings`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `company_id`: `BIGINT UNSIGNED NULL FK -> companies(id) ON DELETE CASCADE`
- `source`: `ENUM('internal', 'adzuna', 'remoteok') DEFAULT 'internal'`
- `external_id`: `VARCHAR(255) NULL`
- `title`: `VARCHAR(255) NOT NULL`
- `slug`: `VARCHAR(255) NOT NULL`
- `description`: `LONGTEXT NOT NULL`
- `location`: `VARCHAR(255) NOT NULL`
- `salary_min`: `DECIMAL(12,2) NULL`
- `salary_max`: `DECIMAL(12,2) NULL`
- `status`: `ENUM('draft', 'active', 'closed') DEFAULT 'active'`
- `created_at`, `updated_at`
- **Indices**: `idx_jobs_source` (`source`), `idx_jobs_status` (`status`)

#### `job_applications`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `job_posting_id`: `BIGINT UNSIGNED FK -> job_postings(id) ON DELETE CASCADE`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `resume_id`: `BIGINT UNSIGNED FK -> user_resumes(id) ON DELETE RESTRICT`
- `ai_ats_score`: `TINYINT UNSIGNED NULL`
- `status`: `ENUM('submitted', 'under_review', 'shortlisted', 'interview_scheduled', 'hired', 'rejected') DEFAULT 'submitted'`
- `created_at`, `updated_at`
- **Unique Constraint**: (`job_posting_id`, `user_id`)

#### `application_status_histories`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `application_id`: `BIGINT UNSIGNED FK -> job_applications(id) ON DELETE CASCADE`
- `changed_by_user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE RESTRICT`
- `previous_status`: `VARCHAR(50) NOT NULL`
- `new_status`: `VARCHAR(50) NOT NULL`
- `comment`: `TEXT NULL`
- `created_at`

---

### Domain 16: Resumes & Domain 17: AI Results

#### `user_resumes`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `user_id`: `BIGINT UNSIGNED FK -> users(id) ON DELETE CASCADE`
- `title`: `VARCHAR(255) NOT NULL`
- `file_path`: `VARCHAR(255) NOT NULL`
- `parsed_skills`: `JSON NULL`
- `is_default`: `BOOLEAN DEFAULT FALSE`
- `created_at`, `updated_at`

#### `ai_analysis_results`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `application_id`: `BIGINT UNSIGNED FK -> job_applications(id) ON DELETE CASCADE`
- `ats_score`: `TINYINT UNSIGNED NOT NULL`
- `keyword_matches`: `JSON NOT NULL`
- `missing_skills`: `JSON NOT NULL`
- `recommended_course_ids`: `JSON NOT NULL`
- `created_at`, `updated_at`

---

### Domain 18: Notifications, Domain 19: Reports, Domain 20: Settings & Domain 21: Audit Logs

#### `notifications`
- `id`: `CHAR(36) PRIMARY KEY` (UUID)
- `type`: `VARCHAR(255) NOT NULL`
- `notifiable_type`: `VARCHAR(255) NOT NULL`
- `notifiable_id`: `BIGINT UNSIGNED NOT NULL`
- `data`: `TEXT NOT NULL`
- `read_at`: `TIMESTAMP NULL`
- `created_at`, `updated_at`

#### `placement_reports`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `period_year`: `SMALLINT NOT NULL`
- `period_month`: `TINYINT NOT NULL`
- `total_applications`: `INT UNSIGNED DEFAULT 0`
- `total_hired`: `INT UNSIGNED DEFAULT 0`
- `placement_rate_percent`: `DECIMAL(5,2) DEFAULT 0.00`
- `created_at`, `updated_at`

#### `system_settings`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `key`: `VARCHAR(255) NOT NULL UNIQUE`
- `value`: `TEXT NULL`
- `description`: `VARCHAR(255) NULL`
- `created_at`, `updated_at`

#### `audit_logs`
- `id`: `BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY`
- `user_id`: `BIGINT UNSIGNED NULL FK -> users(id) ON DELETE SET NULL`
- `action`: `VARCHAR(255) NOT NULL`
- `ip_address`: `VARCHAR(45) NOT NULL`
- `user_agent`: `TEXT NULL`
- `metadata`: `JSON NULL`
- `created_at`
- **Indices**: `idx_audit_user` (`user_id`), `idx_audit_action` (`action`)
