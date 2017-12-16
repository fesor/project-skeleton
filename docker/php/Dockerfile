FROM php:7.2-fpm

RUN apt-get update \
    && apt-get install -y libpq-dev libgmp-dev git zip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install \
        gmp \
        mbstring \
        opcache \
        pdo pdo_pgsql

RUN yes | pecl install apcu xdebug-beta \
        && echo "extension=apcu.so" > /usr/local/etc/php/conf.d/apcu.ini \
        && echo "apc.enable_cli=1" >> /usr/local/etc/php/conf.d/apcu.ini \
        && echo ";zend_extension=xdebug.so" > /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.remote_autostart=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
        && echo "xdebug.remote_connect_back=on" >> /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /app

RUN curl --silent --show-error https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

COPY docker/php/config/www.conf /usr/local/etc/php-fpm.d/www.conf
CMD ["php-fpm", "--allow-to-run-as-root"]

ARG COMPOSER_AUTH
ADD composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader --no-interaction
COPY . /app/
RUN bin/console -e=prod cache:warmup
