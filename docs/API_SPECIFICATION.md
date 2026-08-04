# RESTful API Specification - SkillBridge

All API endpoints are versioned under `/api/v1/` and return standard JSON responses.

## Standard Response Format

### Success Response
```json
{
  "success": true,
  "data": {},
  "meta": {}
}
```

### Error Response
```json
{
  "success": false,
  "error": {
    "code": "UNAUTHORIZED_ROLE",
    "message": "User does not possess the required permission.",
    "details": []
  }
}
```

---

## Endpoint Definitions

### 1. Authentication Endpoints

#### POST `/api/v1/auth/login`
- **Request**:
  ```json
  {
    "email": "student@skillbridge.com",
    "password": "SecretPassword123!"
  }
  ```
- **Response (200 OK)**:
  ```json
  {
    "success": true,
    "data": {
      "token": "1|sanctum_token_string",
      "user": {
        "id": 42,
        "name": "Aarav Sharma",
        "email": "student@skillbridge.com",
        "role": "student"
      }
    }
  }
  ```

---

### 2. Jobs & Application Endpoints

#### GET `/api/v1/jobs?source=all&search=laravel`
- **Response (200 OK)**:
  ```json
  {
    "success": true,
    "meta": { "total": 24, "page": 1 },
    "data": [
      {
        "id": 101,
        "title": "Full-Stack Laravel Engineer",
        "company": "TechCorp Global",
        "source": "internal",
        "location": "Bengaluru, India",
        "salary_range": "₹1,200,000 - ₹1,800,000"
      }
    ]
  }
  ```

#### POST `/api/v1/jobs/{id}/apply`
- **Headers**: `Authorization: Bearer <token>`
- **Request** (Multipart Form Data): `resume_file` (PDF)
- **Response (201 Created)**:
  ```json
  {
    "success": true,
    "data": {
      "application_id": 881,
      "job_id": 101,
      "status": "submitted",
      "ai_ats_score": 88
    }
  }
  ```

---

### 3. Public Certificate Verification Endpoint

#### GET `/api/v1/certificates/verify/{uuid}`
- **Response (200 OK)**:
  ```json
  {
    "valid": true,
    "certificate": {
      "uuid": "SKB-2026-8F92A-4B01",
      "student_name": "Aarav Sharma",
      "course_title": "Full-Stack Web Development with Laravel",
      "issued_at": "2026-08-03T18:00:00Z",
      "pdf_url": "https://skillbridge.com/storage/certs/SKB-2026-8F92A-4B01.pdf"
    }
  }
  ```
