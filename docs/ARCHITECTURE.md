# System Architecture Specification - SkillBridge

## 1. High-Level Architecture Diagram

```mermaid
graph TB
    subgraph Client Layer
        Browser[Desktop Browser - Chrome/Firefox/Edge]
        MobileWeb[Mobile Responsive Web App]
    end

    subgraph Security & Edge Layer
        Cloudflare[Cloudflare DNS & DDoS Protection]
        Nginx[Nginx Web Server & SSL TLS 1.3]
        WAF[Rate Limiter & CSRF/XSS Middleware]
    end

    subgraph Laravel Application Core
        Sanctum[Laravel Sanctum Auth Guard]
        WebRoutes[Web / Livewire Controllers]
        ApiRoutes[RESTful API Controllers]
        Services[Service Layer - Business Logic]
        Repos[Repository Layer - Data Access]
        Horizon[Laravel Horizon Queue Workers]
    end

    subgraph Persistence Layer
        MySQL[(MySQL 8 Database)]
        Redis[(Redis Cache & Session Store)]
        S3[(AWS S3 / Cloudflare R2 Storage)]
    end

    subgraph External Services
        Razorpay[Razorpay Payment API]
        Stripe[Stripe Payment API]
        Adzuna[Adzuna Job API]
        RemoteOK[RemoteOK Job API]
        OpenAI[OpenAI / Gemini AI API]
    end

    Browser --> Cloudflare
    MobileWeb --> Cloudflare
    Cloudflare --> Nginx
    Nginx --> WAF
    WAF --> Sanctum
    Sanctum --> WebRoutes
    Sanctum --> ApiRoutes
    WebRoutes --> Services
    ApiRoutes --> Services
    Services --> Repos
    Repos --> MySQL
    Services --> Redis
    Services --> Horizon
    Horizon --> S3
    Services --> Razorpay
    Services --> Stripe
    Horizon --> Adzuna
    Horizon --> RemoteOK
    Services --> OpenAI
```

---

## 2. Layered Architecture Pattern

The system follows the **Controller - Service - Repository** pattern in Laravel:

- **Http Controllers** (`app/Http/Controllers`): Handles incoming request validation, middleware checks, and maps service outputs to HTTP responses.
- **Service Layer** (`app/Services`): Encapsulates pure business logic (e.g., `PaymentService`, `AIService`, `CertificateService`, `JobSyncService`).
- **Repository Layer** (`app/Repositories`): Abstracts database queries using Eloquent ORM, ensuring testability and clean query separation.
- **Queue Workers** (`app/Jobs`): Offloads asynchronous tasks (sending emails, processing webhooks, fetching external jobs, generating PDF certificates) via Laravel Horizon and Redis queues.

---

## 3. Security Architecture & Audit System

1. **Authentication**: Token-based authentication via Laravel Sanctum for API endpoints; session-based guard for Web/Livewire routes.
2. **Authorization**: Custom `CheckRole` middleware enforcing access gates for the 7 user roles (`super_admin`, `admin`, `trainer`, `student`, `recruiter`, `company_admin`, `guest`).
3. **Audit Logging**: Sensitive system events automatically write to the `audit_logs` database table tracking actor ID, action name, IP address, user agent, and JSON payload diffs.
4. **File Upload Security**: All file uploads (resumes, course resources, logos) undergo strict MIME verification, filesize limits, and randomized S3 object keys to prevent arbitrary script execution.

---

## 4. Deployment & Infrastructure Architecture

```mermaid
graph TD
    subgraph Traffic Routing
        DNS[DNS - Cloudflare]
        LB[Nginx Load Balancer]
    end

    subgraph Web App Nodes
        Node1[App Server 1 - PHP 8.3 FPM]
        Node2[App Server 2 - PHP 8.3 FPM]
    end

    subgraph Async Workers
        Worker1[Horizon Queue Worker 1]
        Worker2[Horizon Queue Worker 2]
    end

    subgraph Data Tier
        DB_Primary[(MySQL 8 Primary)]
        DB_Replica[(MySQL 8 Read Replica)]
        RedisCluster[(Redis Cluster)]
    end

    DNS --> LB
    LB --> Node1
    LB --> Node2
    Node1 --> DB_Primary
    Node2 --> DB_Primary
    Node1 --> DB_Replica
    Node2 --> DB_Replica
    Node1 --> RedisCluster
    Node2 --> RedisCluster
    Worker1 --> RedisCluster
    Worker2 --> RedisCluster
    Worker1 --> DB_Primary
    Worker2 --> DB_Primary
```
