FROM php:8.1-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends \
            libcurl4-openssl-dev \
            libicu-dev \
            libzip-dev \
            wget \
            git \
            libssl-dev \
            libsasl2-dev \
            libsasl2-modules \
            libc6-dev
RUN docker-php-ext-install -j$(nproc) zip intl
RUN rm -rf /var/lib/apt/lists/*

# Redis
RUN pecl install -o -f redis && rm -rf /tmp/pear && docker-php-ext-enable redis

# Composer
RUN wget https://github.com/composer/composer/releases/download/2.3.10/composer.phar && \
    mv composer.phar /usr/local/bin/composer && \
    chmod +x /usr/local/bin/composer

#xDebug
RUN pecl install xdebug-3.1.5 && \
    docker-php-ext-enable xdebug
COPY ./conf/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Kafka
## librdkafka
RUN git clone --depth 1 --branch v1.8.2 https://github.com/edenhill/librdkafka.git \
    && cd librdkafka \
    && ./configure \
    && make \
    && make install
## rdkafka extension
RUN pecl install rdkafka-6.0.1 && docker-php-ext-enable rdkafka

ARG PUID=1000
RUN usermod -u ${PUID} www-data
USER www-data