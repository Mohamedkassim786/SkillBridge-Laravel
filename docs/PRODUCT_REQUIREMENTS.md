# Product Requirements Specification (SRS) - SkillBridge

## 1. Product Vision & Business Purpose
SkillBridge is a commercial, production-grade Software Learning & Career Placement Platform built to bridge the gap between software education and professional recruitment. It combines structured e-learning with an integrated job portal, AI career tools, and automated certificate verification.

---

## 2. Target User Personas & 7-Tier Role Model

```
                                Guest Visitor
                                      │
           ┌──────────────┬───────────┴───────────┬──────────────┐
           ▼              ▼                       ▼              ▼
        Student        Trainer                Recruiter       Company Admin
                                                  │              │
                                                  └──────┬───────┘
                                                         ▼
                                                       Admin
                                                         │
                                                         ▼
                                                    Super Admin
```

1. **Guest Visitor**: Unauthenticated public user. Can browse public courses, view public job listings, and verify student certificates via public UUID QR links.
2. **Student / Job Seeker**: Learns through sequential video lessons, takes chapter quizzes, builds AI-analyzed resumes, and applies for verified jobs.
3. **Course Trainer**: Authors and manages courses, embeds YouTube lesson videos, defines quizzes, evaluates assignments, and views earnings analytics.
4. **Recruiter**: Sub-account associated with a verified hiring company. Posts job vacancies, manages applicant pipelines, shortlists candidates, and schedules interviews.
5. **Company Admin**: Corporate account administrator. Manages company profile, branding assets, recruiter team accounts, and recruitment analytics.
6. **Admin**: System moderator. Audits courses, verifies new hiring companies, manages taxonomy, handles user support, and reviews refunds.
7. **Super Admin**: Platform owner. Full system access, commission configuration, gateway credentials, security policy enforcement, and audit logs.

---

## 3. Core Business Goals

- **Course Monetization**: Sell single software courses with promotional coupons and subscription tier readiness.
- **Enforced E-Learning**: Guarantee course quality via non-skippable sequential lesson progression ($90\%+$ watch time).
- **Competency Verification**: Automate quiz evaluation and issue tamper-proof PDF certificates with public UUID verification.
- **Talent Placement Marketplace**: Dual-source hiring portal integrating direct recruiter job posts with aggregated external job feeds (Adzuna, RemoteOK).
- **AI Career Accelerator**: Provide students with AI resume scoring, skill-gap analysis, and course recommendation.

---

## 4. Business Rules

- **BR-01 (Course Access)**: Course player access is granted only after payment status reaches `COMPLETED`.
- **BR-02 (Sequential Lesson Unlocking)**: Lesson $N+1$ unlocks only when lesson $N$ achieves $\ge 90\%$ watch completion.
- **BR-03 (Certificate Criteria)**: Certificates are generated ONLY when course completion reaches $100\%$ AND quiz average is $\ge 80\%$.
- **BR-04 (Quiz Attempt Limits)**: Maximum 3 attempts per quiz. Failing 3 attempts enforces a 2-hour cooldown period.
- **BR-05 (Single Application Rule)**: Students can apply to a specific job posting once. Application status tracks through a 6-stage pipeline.

---

## 5. Non-Functional Requirements

- **Performance**: API response $< 2.0\text{s}$ under peak load; cached catalog responses $< 150\text{ms}$.
- **Scalability Target**: 10,000+ active students, 500+ trainers, 100+ hiring companies, 100,000+ job listings, 1M progress records.
- **Security**: Sanctum API auth, RBAC middleware, 2FA-ready DB schema, strict rate limiting, AES-256 data encryption, audit logging.
- **Accessibility**: WCAG 2.1 AA compliant color contrast, keyboard navigation, responsive layouts for Mobile ($390\text{px}+$), Tablet ($768\text{px}+$), and Desktop ($1280\text{px}+$).
