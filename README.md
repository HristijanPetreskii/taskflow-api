
# TaskFlow API

A task management REST API built with Laravel and PostgreSQL. The API supports user authentication, task management, and ownership-based access control.

## Features

- User registration and login
- Token-based authentication using Laravel Sanctum
- Create, read, update, and delete tasks (CRUD)
- User-specific task ownership
- Protected API endpoints
- Task validation using Form Requests
- Consistent JSON responses using API Resources
- Task pagination
- Filter tasks by completion status
- Search tasks by title
- Automated feature tests

## Tech Stack

- PHP
- Laravel
- PostgreSQL
- Laravel Sanctum
- PHPUnit
- REST API
- Git

## Authentication

TaskFlow uses Laravel Sanctum for token-based authentication.

Users can register or log in to receive an API token. Protected endpoints require the token to be included in the request:

`Authorization: Bearer YOUR_TOKEN`

## API Endpoints

### Authentication

| Method | Endpoint | Description |
|---|---|---|
| POST | `/api/register` | Register a new user |
| POST | `/api/login` | Log in |
| POST | `/api/logout` | Log out |

### Tasks

All task endpoints require authentication.

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/tasks` | Get authenticated user's tasks |
| POST | `/api/tasks` | Create a task |
| GET | `/api/tasks/{id}` | Get a specific task |
| PUT | `/api/tasks/{id}` | Update a task |
| DELETE | `/api/tasks/{id}` | Delete a task |

## Example Request

Create a task:

```http
POST /api/tasks
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json
```

```json
{
    "title": "Learn Laravel",
    "description": "Build a REST API",
    "completed": false
}
```

## Security

- Only authenticated users can access task endpoints.
- Each task belongs to a specific user.
- Users can only view, update, and delete their own tasks.
- Attempts to access another user's task return `404 Not Found`.
- Task ownership is assigned through the authenticated user's relationship.

## Installation

Clone the repository:

```bash
git clone YOUR_REPOSITORY_URL
cd taskflow-api
```

Install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure your database connection in `.env`:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=taskflow
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Run database migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

The API will be available at:

`http://127.0.0.1:8000`

## Running Tests

Run the automated test suite:

```bash
php artisan test
```

The test suite covers authentication and task ownership, including protection against unauthorized access.

## Project Structure

```text
app/
  Http/
    Controllers/
    Requests/
    Resources/
  Models/

database/
  migrations/

routes/
  api.php

tests/
  Feature/
```

## License

This project is open-sourced under the MIT license.
