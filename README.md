# Learner Progress Dashboard - Coding Challenge

A modern web application for tracking learner progress across multiple courses, built with Laravel and Bootstrap. Features include course filtering, progress sorting, and responsive design.

## Prerequisites

- PHP 8.1 or higher
- Composer
- SQLite3

## Getting Started

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd learner-progress
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Set up environment file:
   ```bash
   cp .env.example .env
   ```

4. Generate application key:
   ```bash
   php artisan key:generate
   ```

5. Create SQLite database:
   ```bash
   touch database/database.sqlite
   ```

6. Configure database in `.env`:
   ```
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database/database.sqlite
   ```

7. Set proper permissions (Linux only):
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

8. Run migrations and seed the database:
   ```bash
   php artisan migrate --seed
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

The application will be available at `http://localhost:8000/learner-progress`

## Features

- Filter learners by course
- Sort by progress (ascending/descending)
- Modern UI with responsive design
- Pagination with 10 entries per page
- Progress tracking with visual indicators