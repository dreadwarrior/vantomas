FROM alpine:3.4

MAINTAINER Thomas Juhnke <dev@van-tomas.de>

RUN apk add --no-cache --virtual .php-fpm --repository=http://dl-cdn.alpinelinux.org/alpine/edge/testing \
        openssl \
        php7-apcu \
        php7-bz2 \
        php7-calendar \
        php7-curl \
        php7-ctype \
        php7-common \
        php7-dom \
        php7-enchant \
        php7-exif \
        php7-fpm \
        php7-gd \
        php7-gettext \
        php7-gmagick \
        php7-gmp \
        php7-iconv \
        php7-intl \
        php7-json \
        php7-lzf \
        php7-mcrypt \
        php7-mbstring \
        php7-mysqli \
        php7-mysqlnd \
        php7-oauth \
        php7-opcache \
        php7-openssl \
        php7-pcntl \
        php7-pdo \
        php7-pdo_mysql \
        php7-pdo_sqlite \
        php7-posix \
        php7-session \
        php7-sqlite3 \
        php7-tidy \
        php7-timezonedb \
        php7-uuid \
        php7-xdebug \
        php7-xml \
        php7-xmlreader \
        php7-xsl \
        php7-zip \
        php7-zlib \
    && rm -rf /var/cache/apk/* \
    && adduser -g '' -s /bin/false -D -H www-pub

COPY conf /

VOLUME ["/app"]

EXPOSE 9000

USER www-pub

CMD ["php-fpm7"]
