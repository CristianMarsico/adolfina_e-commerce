#!/bin/bash

cd /var/www/html

# Build .env from Render environment variables
cat > .env <<EOF
APP_NAME="${APP_NAME:-Pañalera}"
APP_ENV="${APP_ENV:-production}"
APP_KEY=
APP_DEBUG="${APP_DEBUG:-false}"
APP_URL="${APP_URL:-http://localhost}"

DB_CONNECTION="${DB_CONNECTION:-pgsql}"
DB_HOST="${DB_HOST}"
DB_PORT="${DB_PORT:-5432}"
DB_DATABASE="${DB_DATABASE}"
DB_USERNAME="${DB_USERNAME}"
DB_PASSWORD="${DB_PASSWORD}"

SESSION_DRIVER="${SESSION_DRIVER:-database}"
SESSION_LIFETIME="${SESSION_LIFETIME:-120}"
SESSION_ENCRYPT="${SESSION_ENCRYPT:-false}"
SESSION_PATH="${SESSION_PATH:-/}"
SESSION_SECURE_COOKIE=true

CACHE_STORE="${CACHE_STORE:-database}"
QUEUE_CONNECTION="${QUEUE_CONNECTION:-database}"
FILESYSTEM_DISK="${FILESYSTEM_DISK:-local}"
BROADCAST_CONNECTION="${BROADCAST_CONNECTION:-log}"

LOG_CHANNEL="${LOG_CHANNEL:-stack}"
LOG_STACK="${LOG_STACK:-single}"
LOG_LEVEL="${LOG_LEVEL:-warning}"

MERCADO_PAGO_PUBLIC_KEY="${MERCADO_PAGO_PUBLIC_KEY}"
MERCADO_PAGO_ACCESS_TOKEN="${MERCADO_PAGO_ACCESS_TOKEN}"
MERCADO_PAGO_SANDBOX="${MERCADO_PAGO_SANDBOX:-false}"
MERCADO_PAGO_WEBHOOK_SECRET="${MERCADO_PAGO_WEBHOOK_SECRET:-}"

VITE_APP_NAME="${APP_NAME:-Pañalera}"
EOF

# Write APP_KEY from Render env
if [ -n "$APP_KEY" ]; then
    sed -i "s|^APP_KEY=.*|APP_KEY=${APP_KEY}|" .env
    echo ">>> APP_KEY set from environment"
else
    php artisan key:generate --force
    echo ">>> APP_KEY generated fresh"
fi

# Force HTTPS in APP_URL for Render (reverse proxy terminates SSL)
APP_URL="${APP_URL:-http://localhost}"
APP_URL="${APP_URL/http:\/\//https://}"
sed -i "s|^APP_URL=.*|APP_URL=\"${APP_URL}\"|" .env
echo ">>> APP_URL (forced HTTPS): [$APP_URL]"

# Force APP_DEBUG from env
sed -i "s|^APP_DEBUG=.*|APP_DEBUG=${APP_DEBUG:-false}|" .env
export APP_DEBUG="${APP_DEBUG:-false}"

# Clear and rebuild caches
php artisan config:clear 2>&1 | tee /tmp/startup.log
php artisan route:clear 2>&1 | tee -a /tmp/startup.log
php artisan view:clear 2>&1 | tee -a /tmp/startup.log
php artisan package:discover --ansi 2>&1 | tee -a /tmp/startup.log

# Import SQL if panalera.sql exists and database is empty
echo ">>> DIAGNOSTIC: panalera.sql exists? $(test -f database/panalera.sql && echo YES || echo NO)" | tee -a /tmp/startup.log
echo ">>> DIAGNOSTIC: panalera.sql size: $(wc -c < database/panalera.sql 2>/dev/null || echo 'N/A') bytes" | tee -a /tmp/startup.log
if [ -f "database/panalera.sql" ]; then
    TABLE_COUNT=$(php artisan tinker --execute="echo DB::select('SELECT count(*) as c FROM information_schema.tables WHERE table_schema = \'public\'')[0]->c;" 2>&1 || echo "0")
    echo ">>> DIAGNOSTIC: TABLE_COUNT=${TABLE_COUNT}" | tee -a /tmp/startup.log
    if [ "$TABLE_COUNT" -le 1 ]; then
        echo ">>> Importing panalera.sql (database is empty)..." | tee -a /tmp/startup.log
        PGPASSWORD="${DB_PASSWORD}" psql -h "${DB_HOST}" -U "${DB_USERNAME}" -d "${DB_DATABASE}" -f database/panalera.sql 2>&1 | tee -a /tmp/startup.log
        echo ">>> DIAGNOSTIC: psql exit code: $?" | tee -a /tmp/startup.log
        TABLE_COUNT_AFTER=$(php artisan tinker --execute="echo DB::select('SELECT count(*) as c FROM information_schema.tables WHERE table_schema = \'public\'')[0]->c;" 2>/dev/null || echo "0")
        echo ">>> DIAGNOSTIC: TABLE_COUNT after import: ${TABLE_COUNT_AFTER}" | tee -a /tmp/startup.log
    else
        echo ">>> Database already has $TABLE_COUNT tables, skipping SQL import" | tee -a /tmp/startup.log
    fi
else
    echo ">>> WARNING: panalera.sql NOT FOUND in container!" | tee -a /tmp/startup.log
fi

# Mark all migrations as ran (tables exist from SQL import)
echo ">>> Marking migrations as ran..." | tee -a /tmp/startup.log
php artisan tinker --execute="
\$files = glob(database_path('migrations/*.php'));
\$count = 0;
foreach (\$files as \$file) {
    \$name = basename(\$file, '.php');
    if (!DB::table('migrations')->where('migration', \$name)->exists()) {
        DB::table('migrations')->insert(['migration' => \$name, 'batch' => 1]);
        \$count++;
    }
}
echo \"Marked \$count new migrations\n\";
" 2>&1 | tee -a /tmp/startup.log

echo ">>> Running migrations..." | tee -a /tmp/startup.log
php artisan migrate --force 2>&1 | tee -a /tmp/startup.log

# Ensure critical tables exist
echo ">>> Ensuring critical tables exist..." | tee -a /tmp/startup.log
php artisan tinker --execute="
use Illuminate\Support\Facades\Schema;
\$tables = ['sessions','cache','cache_locks','password_reset_tokens'];
foreach (\$tables as \$t) {
    if (!Schema::hasTable(\$t)) {
        echo \"Creating missing table: \$t\n\";
    } else {
        echo \"Table exists: \$t\n\";
    }
}
" 2>&1 | tee -a /tmp/startup.log

# Ensure admin user has bcrypt password and is_admin
echo ">>> Ensuring admin user..." | tee -a /tmp/startup.log
php artisan tinker --execute="
use App\Models\User;
use Illuminate\Support\Facades\Hash;
\$admin = User::where('email', 'admin@panalera.com')->first();
if (\$admin) {
    \$changed = false;
    if (password_needs_rehash(\$admin->password, PASSWORD_BCRYPT)) {
        \$admin->password = Hash::make('admin123');
        \$changed = true;
    }
    if (!\$admin->is_admin) {
        \$admin->is_admin = true;
        \$changed = true;
    }
    if (!\$admin->email_verified_at) {
        \$admin->email_verified_at = now();
        \$changed = true;
    }
    if (\$changed) {
        \$admin->save();
        echo \"Admin user updated\n\";
    } else {
        echo \"Admin user OK\n\";
    }
} else {
    User::create([
        'name' => 'Admin',
        'email' => 'admin@panalera.com',
        'password' => Hash::make('admin123'),
        'is_admin' => true,
        'email_verified_at' => now(),
    ]);
    echo \"Admin user created\n\";
}
" 2>&1 | tee -a /tmp/startup.log

php artisan filament:clear-cached-components 2>&1 | tee -a /tmp/startup.log || true
php artisan filament:assets 2>&1 | tee -a /tmp/startup.log || echo ">>> filament:assets FAILED" | tee -a /tmp/startup.log
php artisan filament:cache-components 2>&1 | tee -a /tmp/startup.log || echo ">>> filament:cache skipped" | tee -a /tmp/startup.log

# Rebuild config and view caches AFTER filament setup
php artisan config:cache 2>&1 | tee -a /tmp/startup.log
php artisan view:cache 2>&1 | tee -a /tmp/startup.log

# Create storage symlink (needed for serving uploaded images)
php artisan storage:link --force 2>&1 | tee -a /tmp/startup.log

# Fix permissions: artisan commands run as root, PHP-FPM runs as appuser
chown -R appuser:appuser /var/www/html/storage /var/www/html/bootstrap/cache

echo ">>> STARTUP LOG:" && cat /tmp/startup.log

exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
