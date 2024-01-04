FROM php:latest

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd ldap curl ffi ftp fileinfo gettext gmp intl imap exif mysqli odbc openssl pdo_mysql pdo_odbc pdo_pgsql pdo_sqlite pgsql shmop

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the Laravel files to the container
COPY . /var/www/html

# Copy custom PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Install Laravel dependencies
RUN composer install

# # Set working directory
# WORKDIR /var/www

# Expose port 80 (adjust if using a different port)
EXPOSE 80

# Command to start PHP server
CMD php artisan serve --host=0.0.0.0 --port=80

