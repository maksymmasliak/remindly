# Remindly

Task management app with automated email reminders sent 15 minutes before due time. Built with Laravel, Docker (Nginx, PHP-FPM, MySQL, Redis), Queue workers, and Scheduler for background job processing.

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3
- **Database:** MySQL 8.0
- **Cache & Queue:** Redis
- **Web Server:** Nginx
- **Process Manager:** Supervisor (manages PHP-FPM, cron-based Scheduler, and Queue Worker in a single container)
- **Mail:** Gmail SMTP

## Prerequisites

- Docker and Docker Compose installed
- `make` (usually pre-installed on Linux/macOS)

## Getting Started

1. Clone the repository:
```bash
   git clone git@github.com:maksymmasliak/remindly.git
   cd remindly
```

2. Create the `src` directory if it doesn't exist yet (avoids a Docker permissions issue on first run):
```bash
   mkdir -p src
```

3. Copy the environment file and configure it:
```bash
   cp src/.env.example src/.env
```
Update `MAIL_USERNAME` and `MAIL_PASSWORD` with your own Gmail account and [App Password](https://myaccount.google.com/apppasswords) if you want email reminders to work.

4. Build and start the containers:
```bash
   make up
```

5. Install dependencies and generate the application key (first run only):
```bash
   make shell
   composer install
   php artisan key:generate
   exit
```

6. Run migrations:
```bash
   make migrate
```

7. Visit the app:
   http://localhost
## Available Commands

| Command | Description |
|---|---|
| `make up` | Start all containers |
| `make down` | Stop all containers |
| `make shell` | Open a bash shell inside the app container |
| `make migrate` | Run database migrations |
| `make fresh` | Drop all tables and re-run migrations |
| `make test` | Run the test suite |
| `make logs` | Follow logs from all containers |

## Architecture

The `app` container runs three processes simultaneously via Supervisor:
- **PHP-FPM** — serves the application
- **Scheduler loop** — runs `php artisan schedule:run` every 60 seconds, which checks for tasks due within 15 minutes
- **Queue Worker** — processes the `SendTaskReminderJob` dispatched by the scheduler, sending reminder emails asynchronously via Redis

## Testing

The project includes Feature tests covering CRUD operations and security (IDOR protection, Mass Assignment, CSRF, Session Fixation):

```bash
make test
```
