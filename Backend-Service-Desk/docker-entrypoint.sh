#!/bin/sh

# Hentikan script kalau ada error
set -e

# Install dependencies (kalau vendor tidak ada)
if [ ! -d "vendor" ]; then
    echo "📦 Installing composer dependencies..."
    composer install --no-interaction --prefer-dist
fi

# Pastikan key Laravel sudah dibuat
if ! grep -q "APP_KEY=base64" .env 2>/dev/null; then
    echo "🔑 Generating Laravel APP_KEY..."
    php artisan key:generate --force
fi

# Jalankan migrasi
echo "🔄 Running migrations..."
php artisan migrate --force || true

# Jalankan seeder jika ada yang pending
echo "🔄 Running seeders..."
if ! php artisan tinker --execute="echo \DB::table('migrations')->where('migration', 'seed_flag')->exists();" | grep -q 1; then
    php artisan db:seed --force
    php artisan tinker --execute="\DB::table('migrations')->insert(['migration' => 'seed_flag', 'batch' => 1]);"
fi

# Buat symbolic link storage
echo "🔗 Linking storage..."
php artisan storage:link || true

# Jalankan Laravel di port 8000
echo "🚀 Starting Laravel server..."
exec php artisan serve --host=0.0.0.0 --port=8000
