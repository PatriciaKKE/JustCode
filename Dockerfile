FROM php:8.3-fpm-alpine

# Install dependencies
RUN apk add --no-cache postgresql-dev libzip-dev icu-dev g++ make autoconf libtool

# Install extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql intl zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application source code into the Docker container
COPY . .

# Install PHP dependencies
RUN composer install --no-ansi --no-interaction --optimize-autoloader

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm", "-F"]

