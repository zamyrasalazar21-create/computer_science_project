FROM php:8.2-apache

# Install PostgreSQL driver
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy all project files into Apache's web root
COPY . /var/www/html/

# Allow .htaccess overrides (optional but good practice)
RUN sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
