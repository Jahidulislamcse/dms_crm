# DMS CRM — Laravel Edition
## Digital Marketing Agency Management System

---

## ✅ Features Included

| Module | Description |
|--------|-------------|
| **CRM Pipeline** | Lead management, 7-stage kanban, requirements tracking |
| **Client Management** | Full profiles, service packages, satisfaction ratings |
| **Task Board** | Custom stages per client, recurring tasks, sub-task breakdown |
| **SMM Dashboard** | Client timeline, designer progress tracking |
| **Designer Dashboard** | Work grouped by client, brief visible, approval flow |
| **Content Calendar** | Per-client monthly calendar with designer briefs |
| **Invoice System** | Generate, track, PDF download, payment reminders |
| **Expense Tracking** | Category-wise, monthly P&L |
| **Sales Targets** | Service-based targets per salesperson |
| **Requisitions** | Sales → Admin approval → Team assignment → Auto client creation |
| **Work Reports** | Daily worklogs, SMM review, quality ratings |
| **Team Workload** | Weekly capacity grid |
| **Day Planner** | Drag-to-schedule weekly view |
| **Notifications** | Role-based (financial = admin only) |
| **AI Agent** | Claude AI assistant |
| **Google Calendar** | ICS export for meetings & tasks |

---

## 🚀 Deployment Guide

**cPanel (dmssoftware.agency):** see **[DEPLOY-CPANEL.md](DEPLOY-CPANEL.md)** for the full production checklist and `deploy/cpanel-install.sh`.

### Option A: Shared Hosting (cPanel — Hostinger, Namecheap, etc.)

**Step 1: Upload files**
```bash
# Zip the dms-crm folder on your computer
# Upload via cPanel File Manager to public_html/dms-crm
# OR use FTP
```

**Step 2: Set document root**
- In cPanel → Domains → point your domain to `public_html/dms-crm/public`
- OR rename `public` folder contents to root of domain

**Step 3: Create database**
- cPanel → MySQL Databases → Create database `dms_crm`
- Create a user and assign it to the database (All Privileges)
- Note down: database name, username, password

**Step 4: Configure .env**
```bash
# Copy .env.example to .env
# Edit these values:
DB_DATABASE=your_cpanel_username_dms_crm
DB_USERNAME=your_cpanel_username_dbuser
DB_PASSWORD=your_db_password
APP_URL=https://yourdomain.com
```

**Step 5: Install via SSH or cPanel Terminal**
```bash
cd /home/username/public_html/dms-crm
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --seed
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

**Step 6: Set permissions**
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

### Option B: VPS (DigitalOcean, Vultr, Linode — $6/month)

**Step 1: Server setup**
```bash
# Ubuntu 24.04
sudo apt update && sudo apt upgrade -y
sudo apt install nginx mysql-server php8.2-fpm php8.2-mysql php8.2-mbstring \
     php8.2-xml php8.2-curl php8.2-zip php8.2-gd unzip git -y

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

**Step 2: MySQL setup**
```bash
sudo mysql_secure_installation
sudo mysql
CREATE DATABASE dms_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'dmsuser'@'localhost' IDENTIFIED BY 'StrongPassword123!';
GRANT ALL PRIVILEGES ON dms_crm.* TO 'dmsuser'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

**Step 3: Upload project**
```bash
cd /var/www
sudo git clone https://your-repo-url.git dms-crm
# OR upload via SFTP/SCP

cd dms-crm
composer install --no-dev --optimize-autoloader
cp .env.example .env
nano .env  # Edit DB credentials, APP_URL, etc.
php artisan key:generate
php artisan migrate --seed
```

**Step 4: Nginx config**
```nginx
# /etc/nginx/sites-available/dms-crm
server {
    listen 80;
    server_name yourdomain.com www.yourdomain.com;
    root /var/www/dms-crm/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/dms-crm /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx

# Set permissions
sudo chown -R www-data:www-data /var/www/dms-crm
sudo chmod -R 775 /var/www/dms-crm/storage /var/www/dms-crm/bootstrap/cache
```

**Step 5: SSL (Free)**
```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

---

## 🔑 Default Login Credentials

| Role | Username | Password |
|------|----------|----------|
| Admin/Owner | `admin` | `admin123` |
| Sales 1 | `rahim` | `rahim123` |
| Sales 2 | `karim` | `karim123` |
| Designer | `rafi` | `rafi123` |
| Motion | `nafi` | `nafi123` |
| SMM | `sara` | `sara123` |
| SEO | `tariq` | `tariq123` |

**⚠️ Change all passwords after first login!**
Admin → Settings → Team → Edit each user

---

## 🛠 Project Structure

```
dms-crm/
├── app/
│   ├── Http/Controllers/     ← All 15+ controllers
│   ├── Http/Middleware/      ← Role-based access
│   └── Models/               ← All 20+ models
├── database/
│   ├── migrations/           ← 8 migration files (25+ tables)
│   └── seeders/              ← Demo data seeder
├── resources/views/
│   ├── app.blade.php         ← Main SPA view (full CRM UI)
│   └── auth/login.blade.php  ← Login page
├── routes/
│   ├── web.php               ← Web routes
│   └── api.php               ← 50+ API endpoints
├── .env.example              ← Configuration template
└── composer.json
```

---

## ⚙️ Configuration

**AI Agent (Claude)**
```env
ANTHROPIC_API_KEY=sk-ant-api03-xxxxx
```
Get from: https://console.anthropic.com

**Email Reminders (Gmail)**
1. Gmail → Settings → 2-Factor Auth → App Passwords
2. Generate password for "Mail"
3. Add to .env:
```env
MAIL_USERNAME=youremail@gmail.com
MAIL_PASSWORD=xxxx xxxx xxxx xxxx
```

---

## 📱 Adding More Staff

Admin → Team & Access → Add Member
- Name, username, password
- Role: sales / smm / designer / motion / seo / developer
- They get their own dashboard immediately

---

## 🔄 Updating

```bash
cd /var/www/dms-crm
git pull origin main
composer install --no-dev
php artisan migrate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 💬 Support

Built by Claude (Anthropic) for DMS Digital Marketing Agency.
For feature requests or bugs, extend the codebase following Laravel conventions.

**Key files to customize:**
- `app/Models/User.php` — Add new roles → update `canAccess()` method
- `database/seeders/DatabaseSeeder.php` — Change demo data
- `resources/views/app.blade.php` — Frontend UI changes
- `routes/api.php` — Add new API endpoints
