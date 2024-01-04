# Use the official PHP image as the base image
FROM php:latest

# Set the working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

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
