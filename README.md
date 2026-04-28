# Hidayah DeenHub

Hidayah DeenHub is a daily Islamic companion web app built with HTML, CSS, JavaScript, PHP and MySQL. It provides accurate prayer times, short reminders from the Quran and authentic hadith, a mini Islamic quiz with a leaderboard, the 99 Names of Allah, a Qibla compass, and a dark/light mode.

## Features

- Prayer times for any city with next-prayer countdown and Hijri date (via the Aladhan API, cached locally).
- Curated Islamic tips from the Quran and Sahih hadith, filterable by category and managed from the admin panel.
- 10-question mini quiz with instant feedback, explanations, a timer, and a score.
- Leaderboard of the top 50 attempts, ranked by score and fastest time.
- The 99 Names of Allah (Asma-ul-Husna) with Arabic, transliteration, meaning, and search.
- Qibla finder using the great-circle bearing from the user's location to the Kaaba.
- Dark/light mode that respects the system preference and is persisted in localStorage.
- Accounts with PHP sessions, bcrypt password hashing, and CSRF protection on all forms.
- Admin panel to add, toggle, and delete tips and quiz questions.

## Run locally

### Prerequisites

- PHP 7.4+ with the `pdo_mysql` and `curl` extensions
- MySQL 5.7+ or MariaDB 10.3+

### 1. Clone

```bash
git clone https://github.com/atiyakhanmlucky/Hidayah-DeenHub.git
cd Hidayah-DeenHub
```

### 2. Create the database (optional — `setup.php` will also create it)

```sql
CREATE DATABASE hidayah_deenhub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'hidayah'@'localhost' IDENTIFIED BY 'hidayah_password';
GRANT ALL ON hidayah_deenhub.* TO 'hidayah'@'localhost';
FLUSH PRIVILEGES;
```

### 3. Configure credentials

```bash
cp includes/config.php includes/config.local.php
```

Edit `includes/config.local.php` and set your DB credentials:

```php
<?php
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hidayah_deenhub');
```

You can also set the same values via the environment variables `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME`.

### 4. Start the PHP dev server

```bash
php -S 0.0.0.0:8080 -t public
```

Open `http://localhost:8080` in your browser.

### 5. First-time database setup

Visit `http://localhost:8080/setup.php` once. It will create the tables, seed the tips, quiz questions, and 99 Names, and create a default admin account.

Re-running it is safe. Delete `public/setup.php` before deploying to production.

### 6. Log in

| Role  | Username | Password    |
| ----- | -------- | ----------- |
| Admin | `admin`  | `Admin@123` |

The admin can manage tips and quiz questions from `/admin/`. Visitors can register a regular account from the Sign up page; those accounts cannot access the admin pages.

## Running with XAMPP / WAMP / LAMPP

1. Copy the project into your `htdocs` folder (for example `C:\xampp\htdocs\Hidayah-DeenHub`).
2. Start Apache and MySQL from the XAMPP control panel.
3. Open `http://localhost/Hidayah-DeenHub/public/setup.php` once.
4. Open `http://localhost/Hidayah-DeenHub/public/` to use the app.

## Project structure

```
Hidayah-DeenHub/
├── public/
│   ├── index.php
│   ├── prayer-times.php
│   ├── tips.php
│   ├── quiz.php
│   ├── leaderboard.php
│   ├── names.php
│   ├── qibla.php
│   ├── login.php / register.php / logout.php
│   ├── setup.php
│   ├── admin/
│   │   ├── index.php
│   │   ├── tips.php
│   │   └── quiz.php
│   ├── api/
│   │   ├── prayer-times.php
│   │   ├── tip.php
│   │   └── quiz.php
│   └── assets/
│       ├── css/style.css
│       ├── js/
│       └── img/
├── includes/
│   ├── config.php
│   ├── db.php
│   ├── auth.php
│   ├── header.php
│   └── footer.php
├── sql/
│   ├── schema.sql
│   └── seed.sql
└── README.md
```

## Security notes

- Passwords are hashed with `password_hash()` (bcrypt).
- Every form uses CSRF tokens from the user session.
- `session_regenerate_id()` is called on login to prevent session fixation.
- All output is escaped via the `e()` helper.
- All SQL uses PDO prepared statements.

## External data

- Prayer times and Hijri date come from the Aladhan Prayer Times API (no API key required).
- Qibla direction is computed locally with the standard great-circle bearing formula.
