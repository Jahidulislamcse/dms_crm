#!/usr/bin/env bash
# DMS CRM - cPanel post-upload setup. Run from project root.
set -euo pipefail

echo "==> DMS CRM cPanel install"
echo "Working directory: $(pwd)"

if [[ ! -f artisan ]]; then
  echo "ERROR: artisan not found. Run this script from the Laravel project root."
  exit 1
fi

if [[ ! -f .env ]]; then
  echo "ERROR: .env missing. Copy .env.example to .env and configure DB + APP_URL first."
  exit 1
fi

if ! command -v composer >/dev/null 2>&1; then
  echo "ERROR: composer not found. Enable it in cPanel or install Composer."
  exit 1
fi

composer install --no-dev --optimize-autoloader

php artisan key:generate --force
php artisan migrate --force

read -r -p "Seed demo users/data? Use only on a fresh database. [y/N] " seed_answer
case "$seed_answer" in
  [yY][eE][sS]|[yY])
    php artisan db:seed --force
    ;;
  *)
    echo "Skipping db:seed."
    ;;
esac

php artisan storage:link || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo ""
echo "==> Done. Visit your APP_URL/login."
echo "    Change any default/demo passwords immediately if you seeded data."
