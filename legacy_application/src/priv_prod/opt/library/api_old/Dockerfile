FROM php:8-apache

# Update package indexes
RUN apt update
RUN apt upgrade -y

RUN apt-get install mariadb-client git zip -y
RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/

COPY composer.json ./
RUN composer install
COPY . /var/www/

RUN a2enmod rewrite
RUN a2enmod actions
