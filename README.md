# 🚀 SkillBridge — AI-Powered Enterprise Learning, Universal Code Sandbox & Placement Platform

[![Live Demo](https://img.shields.io/badge/LIVE_DEMO-skillbridge--laravel.onrender.com-00C853?style=for-the-badge&logo=render&logoColor=white)](https://skillbridge-laravel.onrender.com)
[![Laravel 12](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![PHP 8.3](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)](https://php.net)
[![Livewire 3](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire)](https://livewire.laravel.com)
[![NVIDIA AI](https://img.shields.io/badge/NVIDIA_NIM-Llama_3.3_70B-76B900?style=for-the-badge&logo=nvidia)](https://build.nvidia.com)
[![Tailwind CSS v4](https://img.shields.io/badge/Tailwind_CSS-4.x-38BDF8?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)

---

### 🌐 Live Production Application
🔗 **Live Application URL**: **[https://skillbridge-laravel.onrender.com](https://skillbridge-laravel.onrender.com)**

---

## 🌟 Overview & Platform Architecture

**SkillBridge** is an enterprise-grade Software Learning Management System (LMS), AI-powered Career Preparation Suite, and Real-Time Live Masterclass Platform built with **Laravel 12**, **Livewire 3**, **Alpine.js**, **Tailwind CSS v4**, **NVIDIA NIM AI (Llama 3.3 70B)**, and **Domain-Driven Design (DDD)** architecture.

It bridges the gap between software engineering education and job placement by providing students with hands-on multi-language coding sandboxes, AI resume analyzers, personalized AI cover letters, mock interview simulations, and live video masterclasses.

---

## 🚀 Core Features & Modules

### 💻 1. Universal Multi-Language Code Playground & AI Examiner
* **15 Supported Languages**: PHP (8.2), JavaScript (Node 22), TypeScript (5.4), Python (3.12), SQL (SQLite 3.45), Java (21), C++ (GCC 13), C# (.NET 8), Go (1.22), Rust (1.77), Ruby (3.3), Swift (5.10), Kotlin (1.9), HTML/CSS Sandbox, and Custom Runtimes.
* **Sequential Stdin Input Wizard**: Automatically analyzes source code to detect stdin requirements (`input()`, `Scanner`, `cin`, `fgets(STDIN)`) and prompts users one input at a time (e.g. *Step 1 of 3: Name* $\rightarrow$ *Step 2 of 3: Age*).
* **Isolated SQL Sandbox**: Executes SQL queries in an isolated SQLite memory database with preloaded schemas (`employees`, `departments`) and renders structured data tables.
* **Compiler & Error Marker**: Parses stderr to pinpoint exact line and column error markers, displaying editor error overlays.
* **AI Diagnostics & Big-O Analysis**: Leverages NVIDIA AI to provide step-by-step root cause analysis, Big-O Time/Space complexity (`O(1)`, `O(N)`), and single-click **Apply Suggested Fix** code refactoring.
* **Session Execution History**: Tracks session run history (`Run #1 FAILED`, `Run #2 PASSED`).

---

### 📄 2. AI ATS Resume Builder & Content Analyzer
* **Automated ATS Scoring**: Calculates real-time 0–100% ATS optimization scores with actionable feedback.
* **Technical Skills Categorizer**: Organizes raw skills into structured categories (`Programming Languages`, `Frontend Technologies`, `Backend Technologies`, `Databases`, `Cloud & DevOps`, `Tools`).
* **Smart Soft Skills Extractor**: Parses unformatted soft skills into clean Title Case lists (e.g., `Communication`, `Teamwork`, `Leadership`) and formats them left-aligned with bullet dot separators (`•`) on PDFs.
* **Professional PDF Generation**: Downloads clean ATS-compliant PDF resumes built with DomPDF.

---

### ✉️ 3. Personalized AI Cover Letter Generator
* **Truthful & Grounded Output**: Generates role-specific, company-tailored cover letters using ONLY actual candidate data (no invented years of experience, production scale, or unverified claims).
* **Role & Skill Normalization**: Normalizes inputs (e.g., `full stack` $\rightarrow$ `Full Stack Developer`, `reactjs` $\rightarrow$ `React.js`, `nodejs` $\rightarrow$ `Node.js`).
* **Structured JSON AI Engine**: Enforces structured 4-paragraph letter outputs with 3–4 grounded qualification bullet points.
* **1:1 Matching PDF & Preview**: Web preview and downloaded business letter PDF use identical structured data.

---

### 📹 4. Video Lessons & Cloudinary CDN Streaming
* **Cloudinary CDN Integration**: Direct HTML5 streaming from Cloudinary CDN (`https://res.cloudinary.com/...`) for high-speed playback without local storage limits on cloud deployments like Render.
* **Interactive Player (`/student/courses/{courseId}/learn`)**: Resume watch time, timestamped notes, bookmarks, download resources, and auto-unlocking next lesson at $\ge 90\%$ completion.

---

### 🎙️ 5. Jitsi Live Masterclasses & Real-Time Attendance
* **Embedded Jitsi Engine**: Real-time video masterclasses hosted inside student/trainer portals via Jitsi Meet External API (`meet.jit.si`).
* **Real-Time Attendance Engine**: 60-second automated heartbeat tracking, attendance classification (*attended*, *partial*, *absent*), and CSV export.
* **Recording Uploads**: Trainers can upload and publish private session recordings for enrolled students.

---

### 🎯 6. Technical Mock Interviews & Skill Assessments
* **AI Mock Interview Simulator**: Dynamic AI-driven technical interviews for Laravel Architect, Full-Stack, and AI Engineer roles with scorecards.
* **Skill Assessment Suite**: Timed multiple-choice software architecture quizzes with instant scoring and performance breakdown.

---

### 👑 7. Admin & Trainer Management Suite
* **Executive Admin Dashboard (`/admin/dashboard`)**: Platform metrics, student enrollment controls, financial invoices, system audit logs, and course syllabus management.
* **Trainer Control Center (`/staff/dashboard`)**: Manage course curriculum, grade assignments, organize student cohorts, and host live masterclasses.

---

## 🛠️ Technology Stack

| Component | Technology |
| :--- | :--- |
| **Backend Framework** | Laravel 12.x |
| **Language** | PHP 8.3 |
| **Database** | MySQL 8 (Aiven Cloud Production) / SQLite Local |
| **Frontend Stack** | Livewire 3, Alpine.js, Tailwind CSS v4 |
| **AI Engine** | NVIDIA NIM AI (Llama 3.3 70B Model) |
| **Media & CDN** | Cloudinary Video CDN (`res.cloudinary.com`) |
| **Video Conferencing** | Jitsi Meet IFrame API (`meet.jit.si`) |
| **PDF Suite** | DomPDF (`barryvdh/laravel-dompdf`) |
| **Deployment** | Render Cloud PaaS (`render.com`) |

---

## 🔐 Demo User Credentials

Test the live application using the preconfigured demo accounts below:

| Role | Email | Password | Live Access Link |
| :--- | :--- | :--- | :--- |
| **Student** | `student@skillbridge.com` | `SkillBridge2026!` | [Student Dashboard](https://skillbridge-laravel.onrender.com/student/dashboard) |
| **Super Admin** | `superadmin@skillbridge.com` | `SkillBridge2026!` | [Super Admin Portal](https://skillbridge-laravel.onrender.com/super-admin/dashboard) |
| **Admin** | `admin@skillbridge.com` | `SkillBridge2026!` | [Admin Dashboard](https://skillbridge-laravel.onrender.com/admin/dashboard) |
| **Staff (Trainer)** | `staff@skillbridge.com` | `SkillBridge2026!` | [Trainer Dashboard](https://skillbridge-laravel.onrender.com/staff/dashboard) |

---

## 💻 Local Installation & Setup

### Prerequisites
* PHP $\ge 8.3$
* Composer
* Node.js & NPM
* MySQL / SQLite

### Quick Start Commands

```bash
# 1. Clone the repository
git clone https://github.com/Mohamedkassim786/SkillBridge-Laravel.git
cd SkillBridge-Laravel

# 2. Install Dependencies
composer install
npm install

# 3. Environment Setup
cp .env.example .env
php artisan key:generate

# 4. Database Setup & Seed
php artisan migrate:fresh --seed

# 5. Start Local Development Server
php artisan serve --port=8000
```

Open `http://127.0.0.1:8000` in your browser and sign in using any demo account above!

---

## 📄 License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
