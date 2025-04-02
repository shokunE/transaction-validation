FROM php:8.3-fpm-alpine3.19

#Libs
RUN apk add --no-cache zlib linux-headers
RUN apk add --no-cache freetype libpng libjpeg-turbo freetype-dev libpng-dev libjpeg-turbo-dev
RUN apk add --no-cache libsodium libsodium-dev
RUN apk add --no-cache curl curl-dev
RUN apk add --no-cache oniguruma oniguruma-dev
RUN apk add --no-cache gettext gettext-dev
RUN apk add --no-cache icu icu-dev
RUN apk add --no-cache libpq
RUN apk add --no-cache libxslt libxslt-dev
RUN apk add --no-cache libzip libzip-dev
RUN apk add --no-cache pcre-dev ${PHPIZE_DEPS}
RUN apk add --no-cache imagemagick imagemagick-dev
RUN apk add --no-cache sqlite sqlite-dev

#For build sockets
ENV CFLAGS="$CFLAGS -D_GNU_SOURCE"

#Additional soft
RUN apk add vim bash

RUN docker-php-ext-configure bcmath --enable-bcmath
RUN docker-php-ext-configure pcntl --enable-pcntl
RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql
RUN docker-php-ext-configure mbstring --enable-mbstring

#Install php extensions
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install sodium
RUN docker-php-ext-install opcache
RUN docker-php-ext-install curl
RUN docker-php-ext-install fileinfo
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install gettext
RUN docker-php-ext-install intl
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install xsl
RUN docker-php-ext-install zip
RUN docker-php-ext-install xml
RUN docker-php-ext-install sockets
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install gd
RUN docker-php-ext-install simplexml

# modify www-data user to have id 1000
RUN apk --no-cache add shadow && usermod -u 1000 www-data

#Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');" \
    && mv composer.phar /usr/local/bin/composer

#Install wp-cli
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

WORKDIR /var/www/

EXPOSE 9000

USER www-data
