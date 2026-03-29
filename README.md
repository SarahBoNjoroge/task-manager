# Task Manager API

A RESTful Task Management API with a Vanilla JS frontend interface, built with Laravel and MySQL.

## Live URL
https://task-manager-production-a8ae.up.railway.app

## Interface
The application has a beautiful web interface where you can:
- ➕ Create new tasks
- 📝 View all tasks in a table
- ▶ Update task status (pending → in_progress → done)
- 🗑 Delete completed tasks
- 📊 View daily task reports

## Database
MySQL — SQL dump file included as `task_manager.sql`

## Tech Stack
| Layer | Technology |
|-------|-----------|
| Frontend | HTML + CSS + Vanilla JS |
| Backend | Laravel 11 (PHP) |
| Database | MySQL |
| Hosting | Railway |

## Requirements
- PHP 8.2+
- Composer
- MySQL
- Laravel 11

---

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

Visit `http://127.0.0.1:8000` to see the interface! 

---

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
Rules:
- Title cannot duplicate on the same due_date
- due_date must be today or in the future
- priority must be low, medium or high

---

### 2. List Tasks
```
GET /api/tasks
```
Optional filter by status:
```
GET /api/tasks?status=pending
GET /api/tasks?status=in_progress
GET /api/tasks?status=done
```

---

### 3. Update Task Status
```
PATCH /api/tasks/{id}/status
```
Status progresses only forward:
```
pending → in_progress → done
```
Cannot skip or revert status.

---

### 4. Delete Task
```
DELETE /api/tasks/{id}
```
- Only `done` tasks can be deleted
- Returns 403 Forbidden if task is not done

---

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
- Only done tasks can be deleted (403 Forbidden otherwise)

---

## Testing the API
You can test using:
- **Browser** → visit https://task-manager-production-a8ae.up.railway.app
- **Postman** → download at https://www.postman.com/downloads/
- **Thunder Client** → VS Code extension

---

## Deployment
Deployed on Railway with MySQL database.
Live URL: https://task-manager-production-a8ae.up.railway.app

---

## Author
Sarah Bonjoroge