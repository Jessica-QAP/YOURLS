FROM php:8.1-fpm

#USER ec2-user
#WORKDIR /var/www/html
# RUN apt-get update && apt-get install -y \
#     mariadb-client \
#     vim \
#     unzip \
#     git \
#     curl \
#     libzip-dev
# RUN docker-php-ext-install pdo_mysql
# RUN docker-php-ext-configure zip
# COPY --from=builder vendor includes/vendor
# CMD ["php-fpm"]
# FROM php:7.3-fpm

RUN apt-get update
RUN docker-php-ext-install mysqli pdo pdo_mysql

# RUN php -r "copy('https://raw.githubusercontent.com/composer/getcomposer.org/55e3ac0516cf01802649468315cd863bcd46a73f/web/installer', 'composer-setup.php');"
# RUN php composer-setup.php --install-dir=/usr/bin --filename=composer --version=1.10.17
# RUN php -r "unlink('composer-setup.php');"

#CMD ["php-fpm"]