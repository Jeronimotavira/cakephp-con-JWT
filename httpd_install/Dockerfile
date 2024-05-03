FROM php:8.3-rc-apache
#ls FROM php:8.2-rc-apache
ENV TZ="Europe/Madrid"
RUN apt update \
    && apt install -y git acl openssl openssh-client wget zip libssh-dev \
    && apt install -y libpng-dev zlib1g-dev libzip-dev libxml2-dev libicu-dev \
    libpq-dev \
    #&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl pdo pdo_mysql pdo_pgsql pgsql\
    && pecl install xdebug \
    && docker-php-ext-enable --ini-name 05-opcache.ini opcache xdebug

RUN docker-php-ext-install zip

RUN docker-php-ext-install gd

# Install and update composer
#RUN curl https://getcomposer.org/composer.phar -o /usr/bin/composer && chmod +x /usr/bin/composer
#RUN composer self-update
#
## Install PHP-CS-FIXER
#RUN wget https://cs.symfony.com/download/php-cs-fixer-v3.phar -O php-cs-fixer
#RUN chmod a+x php-cs-fixer
#RUN mv php-cs-fixer /usr/local/bin/php-cs-fixer
#
#RUN apt-get install -y libpq-dev \
#    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
#    && docker-php-ext-install pdo pdo_pgsql pgsql

RUN php -r "copy('https://getcomposer.org/installer', '/tmp/composer-setup.php');"
RUN php /tmp/composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm /tmp/composer-setup.php
RUN rm -rf /var/www/html
RUN a2enmod rewrite
RUN a2enmod ssl
ADD 000-default.conf /etc/apache2/sites-enabled/000-default.conf
WORKDIR /var/www/
EXPOSE 80 443


#CMD ["apachectl", "-k", "start", "-DFOREGROUND"]
#ENTRYPOINT [ "/bin/bash" ] 