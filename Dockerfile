FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev \
    && docker-php-ext-install pdo_mysql zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory to /var/www
WORKDIR /var/www

# Copy Laravel app
COPY . /var/www

# Point Apache to Laravel's public folder
ENV APACHE_DOCUMENT_ROOT /var/www/public

# Update Apache config to use new document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --working-dir=/var/www

# Fix permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www
