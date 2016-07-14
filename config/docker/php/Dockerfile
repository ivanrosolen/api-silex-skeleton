FROM phpdockerio/php7-fpm

# copy carrefour-web-view app
COPY . /var/www/html/

# php custom configs
COPY ./config/docker/php/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./config/docker/php/php-fpm.d/docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY ./config/docker/php/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./config/docker/php/php-fpm.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN cd /var/www/html/ && composer install
