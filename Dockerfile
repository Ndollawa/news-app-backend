# Use the official PHP image as the base image
FROM php:8.10.apache

# Set the working directory in the container
WORKDIR /var/www/html

# Install PHP extensions and dependencies
RUN apt-get update -y && apt-get install -y --no-cache \
    openssl \
    git \
    bash \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libxml2-dev \
    libonig-dev \
    libmcrypt-dev \
    zlib1g-dev \
    libmemcached-dev \
    && docker-php-ext-install pdo_mysql gd zip exif bcmath

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-ext-install pdo mbstring pdo_mysql

# Copy the composer.json and composer.lock files to the container
COPY composer.json composer.lock ./

WORKDIR /app/backend

# Copy the rest of the project files to the container
COPY . .

# Install project dependencies
RUN composer install --no-scripts --no-autoloader

# Generate the autoload files
RUN composer dump-autoload --optimize

# Expose the desired port (e.g., 8000 for Laravel's default)
EXPOSE 8000

# Start the PHP development server when the container starts
CMD ["php", "artisan", "serve", "--host", "0.0.0.0", "--port", "8000"]
