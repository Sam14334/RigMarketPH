FROM php:8.2-apache

# Install PostgreSQL & cURL extensions required for Supabase
RUN apt-get update && apt-get install -y libpq-dev libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_pgsql pgsql curl \
    && a2enmod rewrite \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Copy website files to Apache root
COPY . /var/www/html/

# Configure Apache to listen on Render's PORT (default 10000)
RUN sed -i 's/Listen 80/Listen 10000/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:10000>/' /etc/apache2/sites-available/000-default.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 10000
CMD ["apache2-foreground"]
