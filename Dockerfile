FROM php:8.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install --quiet --yes --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    zip unzip \
    libpq-dev \
    libmagickwand-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql pcntl zip gd bcmath  \
    && pecl install -o -f redis-6.2.0 \
    && docker-php-ext-enable redis bcmath \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/pear

COPY .docker/php/limit.ini /usr/local/etc/php/conf.d/limit.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN groupadd --gid 1000 appuser \
    && useradd --uid 1000 -g appuser -G www-data,root --shell /bin/bash --create-home appuser

USER appuser