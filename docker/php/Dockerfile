FROM yiisoftware/yii2-php:8.2-fpm-nginx-min
ARG EXT_PHP_USER_ID
ARG EXT_PHP_USER_GID

RUN apt-get update && \
    apt-get install -y --no-install-recommends libpq-dev apt-utils unzip p7zip-full && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install pdo pcntl pgsql pdo_pgsql

# user runned a php will be same as current host user
RUN groupmod -g $EXT_PHP_USER_ID www-data
RUN usermod -u $EXT_PHP_USER_ID -g $EXT_PHP_USER_GID www-data
RUN chown -R www-data:www-data /var/www
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'e21205b207c3ff031906575712edab6f13eb0b361f2085f1f1237b7126d785e826a450292b6cfd1d64d92e6563bbde02') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
WORKDIR /app
#RUN composer create-project --prefer-dist yiisoft/yii2-app-basic .