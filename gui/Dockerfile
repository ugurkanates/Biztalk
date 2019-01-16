FROM php:7.2.12-apache-stretch

# Install composer dependencies
RUN apt-get update && apt-get install -y --no-install-recommends git zip unzip libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install soap

# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '93b54496392c062774670ac18b134c3b3a95e5a5e5c8f1a9f115f203b75bf9a129d5daa8ba6a13e2cc8a1da0806388a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"

# Composer move global
RUN mv composer.phar /usr/local/bin/composer

WORKDIR /var/www/html/

# Copy projejct files
COPY . .

ENV DB_HOST=db
ENV DB_PORT=3306
ENV DB_NAME=db
ENV DB_USER=root
ENV DB_PASS=qwerty

EXPOSE 80
