FROM php:8.3-fpm-alpine as app

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache \
		acl \
		file \
		gettext \
		git \
	;

RUN set -eux; \
	install-php-extensions \
		apcu \
		intl \
		opcache \
		zip \
        pdo \
        pdo_mysql \
	;


RUN addgroup -g 1000 dev \
    && adduser -G dev -u 1000 dev -D

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./app/composer.* ./

RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

COPY ./app .

RUN composer dump-autoload --optimize

RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk add symfony-cli

FROM app as app_dev

ENV XDEBUG_MODE=off

RUN set -eux; \
	install-php-extensions xdebug

USER dev