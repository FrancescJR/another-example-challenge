FROM php:8.1-fpm-buster
#just need PHP installed.

#install php extension for symfony to work
WORKDIR /app

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    &&  mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY . .

# Composer Dependencies (not really needed, just pretending we are using this in production, for dev
# this will be overwritten with the volume with docker compose.)
#For real in production, I'd add nginx image and not use symfony server.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --no-dev \
    && rm -rf /usr/local/bin/composer;