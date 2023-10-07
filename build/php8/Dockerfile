FROM    php:8.2.11-fpm
LABEL   maintainer="Siddhant Baviskar <@siddhantfriends>"

RUN     apt-get update -y && apt-get install -y git \
        zip unzip \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libxpm-dev \
        libfreetype6-dev \
        zlib1g-dev \
        libzip-dev \
        build-essential \
        locales \
        jpegoptim optipng pngquant gifsicle \
        libmagickwand-dev \
        libjpeg-dev libgif-dev librsvg2-dev
 
RUN     apt-get clean
 
RUN     pecl install imagick && docker-php-ext-enable imagick
 
RUN     pecl install redis && docker-php-ext-enable redis
 
RUN     pecl install xdebug-3.2.1 && docker-php-ext-enable xdebug \ 
        && echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
        && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
 
RUN     docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp --with-xpm
RUN     docker-php-ext-install bcmath pcntl pdo pdo_mysql gd mysqli zip sockets exif intl
 
RUN     mkdir -p /var/lib/php/sessions && chmod a+rwx /var/lib/php/sessions \
        && cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini \
        && echo "session.save_path = \"/var/lib/php/sessions\"" >> /usr/local/etc/php/php.ini
 
RUN     cd ~ && curl -sS https://getcomposer.org/installer -o composer-setup.php \
        && php composer-setup.php --install-dir=/usr/local/bin --filename=composer
