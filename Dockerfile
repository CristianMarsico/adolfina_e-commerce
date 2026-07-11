FROM php:8.2-fpm

# Install system dependencies + supervisor + nginx + psql client
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev \
    libpq-dev libzip-dev libicu-dev \
    supervisor nginx postgresql-client \
    && docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath gd zip intl \
    && apt-get clean && rm -rf /var/log/nginx/* /var/lib/apt/lists/*

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create appuser
RUN groupadd -g 1000 appuser && useradd -u 1000 -g appuser -m appuser

WORKDIR /var/www/html

# Copy only composer files first for better layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Copy application code
COPY . .

# Run composer autoload (no-scripts to avoid package:discover during build)
RUN composer dump-autoload --optimize --no-scripts

# Copy custom PHP-FPM config (replaces default pool)
RUN rm -f /usr/local/etc/php-fpm.d/docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/www.conf
COPY docker/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY docker/www.conf /usr/local/etc/php-fpm.d/www.conf

# Copy PHP config
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

# Build frontend assets
RUN npm install && npm run build

# Setup nginx
RUN rm -f /etc/nginx/sites-enabled/default
COPY docker/nginx.conf /etc/nginx/conf.d/default.conf
RUN mkdir -p /var/log/nginx /var/cache/nginx /etc/supervisor/conf.d

# Setup supervisor
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Make start script executable
RUN chmod +x docker/start.sh

RUN mkdir -p /var/log/php-fpm /run/php-fpm
RUN chown -R appuser:appuser /var/log/php-fpm /run/php-fpm

EXPOSE 10000

CMD ["docker/start.sh"]
