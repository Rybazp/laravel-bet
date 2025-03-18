FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      libjpeg-dev \
      libfreetype6-dev \
      zip unzip \
      git \
      libmemcached-dev \
      librabbitmq-dev   \
      libcurl4-openssl-dev \
      pkg-config \
      libssl-dev \
      libxml2-dev \
      gcc \
      make \
      autoconf \
      libc-dev \
      && docker-php-ext-install pdo_mysql bcmath gd zip sockets \
      && pecl install memcached \
      && pecl install mongodb \
      && docker-php-ext-enable memcached mongodb sockets \
      && apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin


WORKDIR /var/www

RUN composer require php-amqplib/rabbitmq-bundle
RUN composer require jenssegers/mongodb
