FROM php:8.2-fpm

ENV DB_USER=root
ENV DB_PASS=root
ENV DB_HOST=localhost
ENV DB_PORT=3306
ENV DB_NAME=pinarakcoffe

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
&& mv composer.phar /usr/local/bin/ \
&& ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . .

# Install dependencies
RUN composer install

# Autoload
RUN composer dump-autoload

# Run server
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]