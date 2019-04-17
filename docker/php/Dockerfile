FROM php:fpm

LABEL maintainer="Ilya Shashilov"

# Install xdebug
RUN pecl install xdebug-2.7.0 \
    && docker-php-ext-enable xdebug
COPY ./docker/php/*.ini /usr/local/etc/php/conf.d/

# Install composer
COPY ./docker/php/composer-installer.sh /usr/local/bin/composer-installer
RUN apt-get -yqq update \
    && apt-get -yqq install --no-install-recommends git unzip \
    && chmod +x /usr/local/bin/composer-installer \
    && composer-installer \
    && mv composer.phar /usr/local/bin/composer \
    && chmod +x /usr/local/bin/composer \
    && composer --version

#install some base extensions
RUN apt-get install -y \
        libzip-dev \
        zip \
  && docker-php-ext-configure zip --with-libzip \
  && docker-php-ext-install zip


WORKDIR /srv/app