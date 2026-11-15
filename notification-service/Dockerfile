# =========================================================
# 1. Base: PHP + extensions + system dependencies
# =========================================================
FROM php:8.5.12-fpm AS base

# Install system dependencies and PHP extensions for Laravel with MySQL/PostgreSQL support.
RUN apt-get update && apt-get install -y --no-install-recommends \
    curl \
    bash \
    unzip \
    libpq-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    libfcgi-bin \
     procps \
    && docker-php-ext-install -j$(nproc) \
    bcmath \
    pdo_mysql \
    pdo_pgsql \
    pgsql \
    intl \
    zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get autoremove -y && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# =========================================================
# 2. Builder: Production Composer dependencies
# =========================================================
FROM base AS builder

WORKDIR /var/www

# Install Composer and dependencies
COPY --from=composer:2.10 /usr/bin/composer /usr/bin/composer

# Copy dependency manifests first for better caching
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-scripts

COPY . .

# Generate optimized autoloader after copying source
RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --no-interaction \
    --no-scripts

# Laravel writable directories
RUN chown -R www-data:www-data \
    /var/www/storage \
    /var/www/bootstrap/cache

# =========================================================
# 3. Development
# =========================================================
FROM builder AS development

# Add dev dependencies; builder already has production dependencies
RUN composer install \
    --optimize-autoloader \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-scripts

USER www-data

EXPOSE 9000

CMD ["php-fpm"]

# =========================================================
# 4. Preview
# =========================================================
FROM builder as preview

EXPOSE 9000
CMD ["php-fpm"]

# =========================================================
# 5. Production
# =========================================================
FROM builder as production

# Download and install php-fpm health check script
RUN curl -o /usr/local/bin/php-fpm-healthcheck \
    https://raw.githubusercontent.com/renatomefi/php-fpm-healthcheck/master/php-fpm-healthcheck \
    && chmod +x /usr/local/bin/php-fpm-healthcheck

EXPOSE 9000
CMD ["php-fpm"]
