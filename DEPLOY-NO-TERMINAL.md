# Deploy Without cPanel Terminal

Use this when the hosting account has no Terminal/SSH.

## 1. Fix PHP Version First

This project uses Laravel 11 and requires PHP 8.2 or newer.

In cPanel:

1. Open MultiPHP Manager or Select PHP Version.
2. Select `dmssoftware.agency`.
3. Choose PHP 8.2 or PHP 8.3.
4. Apply/save.

The root `.htaccess` also includes a cPanel PHP 8.2 handler:

```apache
AddHandler application/x-httpd-ea-php82 .php .php8 .phtml
```

If the site still says Composer requires PHP `>= 8.2.0`, your host has not enabled PHP 8.2 for this domain. Ask hosting support to enable PHP 8.2/8.3 for `public_html`.

Do not bypass Composer's platform check on PHP 8.1 or older. Laravel 11 is not supported there.

## 2. Upload Files

Upload the complete project contents into:

```text
public_html
```

Make sure these exist directly inside `public_html`:

```text
.env
.htaccess
index.php
artisan
app/
bootstrap/
config/
database/
public/
resources/
routes/
storage/
vendor/
```

## 3. Permissions

Use cPanel File Manager permissions:

```text
storage/          775
bootstrap/cache/ 775
```

If 775 does not work on your host, try 755 for folders and 644 for files, then ask support to make `storage` and `bootstrap/cache` writable by PHP.

## 4. Database

Create/import the database manually in cPanel phpMyAdmin.

Database credentials in `.env`:

```env
DB_DATABASE=dmssoftware_crm
DB_USERNAME=dmssoftware_crm
DB_PASSWORD=your_live_password
```

If migrations were not run from Terminal/SSH, import this file through phpMyAdmin:

```text
deploy/dmssoftware_crm.sql
```

This creates the schema and default login data.

## 5. Verify

Open:

```text
https://dmssoftware.agency/up
https://dmssoftware.agency/login
```

If `/up` still shows the Composer PHP version error, PHP 8.2 is not active for this domain.
