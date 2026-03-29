# Task Manager API

A RESTful Task Management API built with Laravel and MySQL.

## Live URL
```
https://task-manager-production-a8ae.up.railway.app
```

## Database
MySQL — SQL dump file included as `task_manager.sql`

## Requirements
- PHP 8.2+
- Composer
- MySQL
- Laravel 11

## How to Run Locally

### 1. Clone the project
```bash
git clone https://github.com/SarahBoNjoroge/task-manager.git
cd task-manager
```

### 2. Install dependencies
```bash
composer install
```

### 3. Setup environment
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure database
Open `.env` and update:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run migrations
```bash
php artisan migrate
```

### 6. Start the server
```bash
php artisan serve
```

API is now running at `http://127.0.0.1:8000`

---
Testing the API

You can test the API using:
- **Browser** for GET requests
- **Postman** - download at https://www.postman.com/downloads/
- **Thunder Client** - VS Code extension

### Example using Live URL:
GET https://task-manager-production-a8ae.up.railway.app/api/tasks
## API Endpoints

### 1. Create Task
```
POST /api/tasks
```
Body:
```json
{
    "title": "Buy groceries",
    "due_date": "2026-04-05",
    "priority": "high"
}
```

### 2. List Tasks
```
GET /api/tasks
```
Optional filter by status:
```
GET /api/tasks?status=pending
```

### 3. Update Task Status
```
PATCH /api/tasks/{id}/status
```
Status progresses: `pending → in_progress → done`

### 4. Delete Task
```
DELETE /api/tasks/{id}
```
Only `done` tasks can be deleted. Returns 403 if not done.

### 5. Daily Report (Bonus)
```
GET /api/tasks/report?date=2026-04-05
```
Response:
```json
{
    "date": "2026-04-05",
    "summary": {
        "high": {"pending": 2, "in_progress": 1, "done": 0},
        "medium": {"pending": 1, "in_progress": 0, "done": 3},
        "low": {"pending": 0, "in_progress": 0, "done": 1}
    }
}
```

---

## Business Rules
- Task title cannot duplicate on the same due_date
- due_date must be today or in the future
- Status can only move forward: pending → in_progress → done
- Only done tasks can be deleted

---

## Deployment
Deployed on Railway with MySQL database.
Live URL: https://task-manager-production-a8ae.up.railway.app