# Deploy DMS CRM on cPanel - dmssoftware.agency

This project is prepared for a cPanel domain whose document root is:

```text
public_html
```

Upload the full Laravel project contents into `public_html`. The root `index.php` and `.htaccess` are included so `https://dmssoftware.agency/` boots Laravel correctly while blocking direct web access to sensitive Laravel folders.

## Requirements

| Requirement | Value |
|-------------|-------|
| PHP | 8.2 or 8.3 |
| Extensions | `mbstring`, `openssl`, `pdo_mysql`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`, `zip` |
| Composer | cPanel Terminal or SSH |
| Domain root | `public_html` |

## Upload Layout

After upload, `public_html` should contain:

```text
public_html/
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── vendor/
├── .env
├── .htaccess
├── artisan
├── composer.json
└── index.php
```

Do not upload only the `public/` folder. This app needs the complete Laravel tree.

## Production `.env`

The local `.env` has already been prepared with:

```env
APP_NAME="DMS CRM"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dmssoftware.agency

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dmssoftware_crm
DB_USERNAME=dmssoftware_crm
DB_PASSWORD=your_live_password

SESSION_DRIVER=file
SESSION_SECURE_COOKIE=true
CACHE_STORE=file
QUEUE_CONNECTION=sync
```

In cPanel MySQL Databases, confirm user `dmssoftware_crm` is added to database `dmssoftware_crm` with ALL PRIVILEGES.

Security note: if the database password was shared in chat/email, rotate it in cPanel and update `.env`.

## Server Commands

Run from `public_html`:

```bash
cd ~/public_html
composer install --no-dev --optimize-autoloader
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

For a brand-new empty database only, seed demo users/data:

```bash
php artisan db:seed --force
```

Default seeded login:

```text
admin / admin123
```

Change seeded/default passwords immediately after login.

## Quick Installer

You can also run:

```bash
cd ~/public_html
bash deploy/cpanel-install.sh
```

The script asks before seeding demo data.

## Verify

Open:

```text
https://dmssoftware.agency/up
https://dmssoftware.agency/login
```

`/up` should return OK. If you see a 500 error, check `storage/logs/laravel.log`, confirm `.env` values, and rerun:

```bash
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
