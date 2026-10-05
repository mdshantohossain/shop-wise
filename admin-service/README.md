# Look Mart Backend 

This guide explains how to set up and run the project on a local development machine, including database migration, queue workers, frontend assets, and accessing the application through your local PC IP address.

---

## Requirements

Make sure the following are installed on your machine:

* PHP >= 8.2
* Composer
* Node.js >= 22
* NPM
* MySQL / MariaDB
* Git

Check installed versions:

```bash
php -v
composer -V
node -v
npm -v
```
---

# 2. Install Backend Dependencies

Install Laravel/PHP dependencies:

```bash
composer install
```

---

# 3. Install Frontend Dependencies

Install JavaScript dependencies:

```bash
npm install
```

---

# 4. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

For Windows:

```bash
copy .env.example .env
```

Generate the Laravel application key:

```bash
php artisan key:generate
```

---

# 5. Configure Database

Create a database in MySQL.

Example:

```text
Database Name: my_project
Username: root
Password:
```

Update your `.env` file:

```env
APP_NAME="My Project"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=my_project
DB_USERNAME=root
DB_PASSWORD=
```

---

# 6. Run Database Migration

Run migrations:

```bash
php artisan migrate
```

If the project contains seeders:

```bash
php artisan db:seed
```

Or run migration and seeding together:

```bash
php artisan migrate --seed
```

> **Warning:** Do not use `migrate:fresh` unless you intentionally want to delete all existing database tables and data.

---

# 9. Start Laravel Using Your PC IP

If you want to access the application from another device on the same local network, such as a mobile phone, tablet, or another PC, bind Laravel to all network interfaces:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Find your computer's local IP address.

### Windows

```bash
ipconfig
```

Look for:

```text
IPv4 Address
```

Example:

```text
192.168.0.106
```

Then access the application using:

```text
http://192.168.0.106:8000
```

For example:

```text
http://192.168.0.106:8000
```

### Important

The other device must be connected to the **same local network/Wi-Fi**.

If Windows Firewall blocks the connection, allow PHP through the firewall or allow inbound traffic for the development port.

---

# 10. Start Queue Worker

This project uses Laravel Queues for background jobs.

Start the queue worker:

```bash
php artisan queue:work
```

For development, you can use:

```bash
php artisan queue:listen
```

The recommended option is:

```bash
php artisan queue:work
```

Keep the queue worker running in a separate terminal.

Example:

### Terminal 1 — Laravel Server

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Terminal 2 — Queue Worker

```bash
php artisan queue:work
```

---

# 12. Recommended Development Setup

For a full-stack Laravel application, you may need multiple terminal windows.

### Terminal 1 — Laravel

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

### Terminal 2 — Queue

```bash
php artisan queue:work
```

### Terminal 3 — Vite

```bash
npm run dev -- --host 0.0.0.0
```

---

# 13. One Command to Start Everything

If the project has multiple processes, Laravel's `composer.json` can be configured to start them together.

Example:

```json
{
    "scripts": {
        "dev": [
            "Composer\\Config::disableProcessTimeout",
            "php artisan serve --host=0.0.0.0 --port=8000",
            "php artisan queue:work",
            "npm run dev -- --host 0.0.0.0"
        ]
    }
}
```

However, for most development environments, it is better to use a process manager such as `concurrently` or Laravel's supported development setup rather than manually maintaining multiple processes inside a single Composer script.

---

# 14. Clear Laravel Cache

If you face configuration, route, view, or cache-related problems:

```bash
php artisan optimize:clear
```

This clears:

* Configuration cache
* Route cache
* View cache
* Application cache
* Event cache

You can also run:

```bash
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear
```

---

# 19. Recommended Startup Checklist

After cloning the project for the first time:

```bash
git clone <repository-url>
cd <project-directory>

composer install
npm install

cp .env.example .env
php artisan key:generate

# Configure .env

php artisan migrate --seed
php artisan storage:link
php artisan optimize:clear
```
