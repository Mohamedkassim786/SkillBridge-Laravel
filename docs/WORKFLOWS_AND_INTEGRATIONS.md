# Workflows & Integrations - SkillBridge

## 1. Sequential Lesson Progression & Video Tracking
```mermaid
sequenceDiagram
    autonumber
    actor Student
    participant Player as YouTube iFrame API
    participant JS as Lesson Tracker JS
    participant API as Laravel Progress API
    participant DB as MySQL DB

    Student->>Player: Start Lesson Video (Lesson N)
    Player->>JS: Dispatch Time Update Event
    JS->>JS: Calculate Watch Percentage
    alt Watch Time < 90%
        JS-->>Student: Keep Lesson N+1 Locked
    else Watch Time >= 90%
        JS->>API: POST /api/v1/lessons/{id}/complete
        API->>DB: Mark Lesson N Complete & Recalculate Course %
        API-->>JS: Return Unlocked Status for Lesson N+1
        JS-->>Student: Highlight & Unlock Lesson N+1
    end
```

---

## 2. Dynamic Certificate Generation & Public UUID Verification
```mermaid
sequenceDiagram
    autonumber
    actor Student
    participant System as SkillBridge Engine
    participant CertService as PDF & QR Generator
    participant Public as External Recruiter / Public

    System->>System: Check Enrollment Progress = 100% AND Quizzes >= 80%
    System->>CertService: Request Certificate Generation
    CertService->>CertService: Generate Cryptographic UUID (SKB-2026-XXXX)
    CertService->>CertService: Render PDF & Embed QR Code (Link to /certificates/verify/{uuid})
    CertService-->>System: Save PDF to Storage & Write Record to DB
    
    Public->>System: Scan QR Code / Open /certificates/verify/{uuid}
    System-->>Public: Render Public Verification Badge & Student Name
```

---

## 3. External Job Sync Queue Workflow (Adzuna / RemoteOK)
- **Schedule**: Cron job triggers every 6 hours (`php artisan jobs:sync-external`).
- **Fetch**: Horizon worker dispatches HTTP requests to Adzuna REST API & RemoteOK API.
- **Deduplication**: Checks `external_id` against `job_postings` table to prevent duplicates.
- **Mapping**: Normalizes job title, location, salary range, and tags into standard `job_postings` schema with `source = 'adzuna'` or `source = 'remoteok'`.
