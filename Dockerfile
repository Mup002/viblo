FROM php:8.3-fpm
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY composer.lock composer.json /var/www/
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    libonig-dev \
    libzip-dev \
    curl\
    procps\
    systemd-cron\
    supervisor

RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
COPY . /var/www
COPY crontab /etc/crontabs/root
RUN chmod 0644 /etc/crontabs/root
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 9000

CMD ["/usr/bin/supervisord"]
# CMD ["php-fpm"]
# /home/mup/viblo/Dockerfile