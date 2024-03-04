FROM php:8.1.7-fpm-alpine3.15

WORKDIR /var/www/html

RUN apk add  libzip-dev bash \
    g++ \
    gcc \
    make \
    autoconf

ENV COMPOSER_HOME /composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

COPY . . 

ENV LIBRDKAFKA_VERSION=2.3.0
WORKDIR /tmp
# Building librdkafka
RUN wget https://github.com/edenhill/librdkafka/archive/v$LIBRDKAFKA_VERSION.tar.gz \
    && tar -xvf v$LIBRDKAFKA_VERSION.tar.gz \
    && cd librdkafka-$LIBRDKAFKA_VERSION \
    && ./configure --install-deps \
    && make \
    && make install \
    && rm -rf /tmp/*

RUN pecl install rdkafka

RUN docker-php-ext-install \
        mysqli \
        pcntl \
        zip

RUN docker-php-ext-enable rdkafka

WORKDIR /var/www/html

RUN composer install

CMD ["./run.sh"]