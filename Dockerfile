# Use the official PHP image as the base image
FROM php:latest

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libldap2-dev \
    libcurl4-openssl-dev \
    libffi-dev \
    libgmp-dev \
    libicu-dev \
    libxml2-dev \
    libssl-dev \
    libsqlite3-dev \
    libpq-dev \
    && docker-php-ext-configure ldap --with-libdir=lib/x86_64-linux-gnu/ \
    && docker-php-ext-install \
        gd \
        ldap \
        curl \
        ffi \
        ftp \
        fileinfo \
        gettext \
        gmp \
        intl \
        imap \
        mbstring \
        exif \
        mysqli \
        odbc \
        openssl \
        pdo_mysql \
        pdo_odbc \
        pdo_pgsql \
        pdo_sqlite \
        pgsql \
        shmop \
        zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install docker php ext
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd ldap curl ffi ftp fileinfo gettext gmp intl imap exif mysqli odbc openssl pdo_mysql pdo_odbc pdo_pgsql pdo_sqlite pgsql shmop zip

# Copy the Laravel files to the container
COPY . /var/www/html

# Copy custom PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Install Laravel dependencies
RUN composer install

# Expose port 80 (adjust if using a different port)
EXPOSE 80

# Command to start PHP server
CMD php artisan serve --host=0.0.0.0 --port=80
