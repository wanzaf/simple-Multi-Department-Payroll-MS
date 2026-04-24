# Payroll Management System

A Laravel 12 web application for managing employees, departments, and payroll records.

---

## Requirements

Make sure the following are installed on your machine before proceeding.

| Requirement | Version |
|---|---|
| PHP | >= 8.2 |
| Composer | >= 2.x |
| Node.js | >= 18.x |
| npm | >= 9.x |
| MySQL | >= 5.7 / MariaDB >= 10.x |
| XAMPP (or equivalent) | Any recent version |

> **Recommended:** Use [XAMPP](https://www.apachefriends.org/) which bundles PHP, MySQL (MariaDB), and Apache. After installing, add `C:\xampp\php` and `C:\xampp\mysql\bin` to your system `PATH` so `php`, `composer`, and `mysql` are accessible from any terminal.

---

## Local Setup (Step-by-Step)

### 1. Get the project files

Copy the project folder into your XAMPP htdocs directory:

```
C:\xampp\htdocs\assessment-2\
```

Or clone via git:

```bash
git clone <your-repo-url> C:\xampp\htdocs\assessment-2
cd C:\xampp\htdocs\assessment-2
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node dependencies

```bash
npm install
```

### 4. Set up the environment file

```bash
copy .env.example .env
```

Open `.env` and confirm/update the database block:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=payroll_ms
DB_USERNAME=root
DB_PASSWORD=
```

> For a default XAMPP install, leave `DB_PASSWORD=` blank. If your MySQL root has a password, enter it here.

### 5. Generate the application key

```bash
php artisan key:generate
```

### 6. Create the database

Open `http://localhost/phpmyadmin` in your browser and create a new database named **payroll_ms**.

Or run from the terminal:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS payroll_ms;"
```

### 7. Run migrations

```bash
php artisan migrate
```

This creates all tables: `users`, `departments`, `employees`, `payroll_records`.

### 8. Seed the database

```bash
php artisan db:seed
```

This loads sample departments, employees, payroll records, and user accounts.

### 9. Build frontend assets

```bash
npm run build
```

### 10. Start the development server

```bash
php artisan serve
```

Open **http://localhost:8000** in your browser.

---

## Default Login Credentials

These accounts are created by `php artisan db:seed`.

| Name | Email | Password |
|---|---|---|
| Dev | wannaqib01@gmail.com | `Dev@1234` |
| test | test@larabel.com.my | `test1234` |

> If login fails with the seeded accounts, you can register a new account from the Register page — registration is open to anyone.

---

## Running After Initial Setup

Every time you want to start the app after the first-time setup:

```bash
php artisan serve
```

Open **http://localhost:8000**

---

## Project Structure

```
app/
  Http/Controllers/     LoginController, DepartmentController, EmployeeController, PayrollController
  Models/               Department, Employee, Payroll, User
database/
  migrations/           Table schema definitions (run with php artisan migrate)
  seeders/              Sample data (run with php artisan db:seed)
resources/views/        Blade templates: dashboard, employees, departments, payroll, payslip
public/
  css/                  Stylesheets
  js/                   Frontend JS per page
routes/
  web.php               All application routes
```

---

## Features

- User authentication (login, register, logout)
- Dashboard with summary statistics (total employees, departments, payroll total, monthly net pay)
- Department management — create, edit, delete
- Employee management — create, edit, delete, linked to departments
- Payroll processing — bulk generate payroll records for employees
- Payroll history — filter and view past records
- Payslip view — printable payslip per payroll record

---

## Assumptions & Decisions

- **No roles or permissions** — any registered or seeded user can access all pages.
- **MySQL only** — migrations use MySQL-specific column options (`useCurrentOnUpdate`). SQLite is not supported.
- **XAMPP on Windows** — setup steps above target Windows + XAMPP. On macOS/Linux replace `C:\xampp\...` paths with `/opt/lampp/...` or your system equivalents, and use `cp` instead of `copy`.
- **`mysqldump` not required** — database state is captured via migrations and seeders, not a SQL dump.
- **`.env` not committed** — environment config is excluded from version control. Always start from `.env.example`.
- **Dev-only packages** — `kitloong/laravel-migrations-generator` and `orangehill/iseed` are `require-dev` dependencies used to regenerate migration/seeder files from a live database. They are not needed to run the app.
