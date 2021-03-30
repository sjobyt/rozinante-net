FROM php:5.6-apache

# Container configuration
ENV APACHE_DOCUMENT_ROOT=/web/public \
    APACHE_SSL_CERT_FILE=/etc/ssl/certs/ssl-cert-snakeoil.pem \
    APACHE_SSL_KEY_FILE=/etc/ssl/private/ssl-cert-snakeoil.key \
    XDEBUG_ENABLED=0 \
    XDEBUG_REMOTE_ENABLE=0 \
    XDEBUG_REMOTE_AUTOSTART=0 \
    XDEBUG_REMOTE_CONNECT_BACK=0 \
    XDEBUG_REMOTE_HOST=localhost \
    XDEBUG_IDEKEY=docker \
    XDEBUG_VAR_DISPLAY_MAX_CHILDREN=128 \
    XDEBUG_VAR_DISPLAY_MAX_DATA=512 \
    XDEBUG_VAR_DISPLAY_MAX_DEPTH=5 \
    PHP_OPCACHE_ENABLED=1 \
    PHP_MEMORY_LIMIT=16M \
    PHP_POST_MAX_SIZE=32M \
    PHP_UPLOAD_MAX_FILESIZE=16M \
    PHP_ERROR_REPORTING="E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED" \
    PHP_MAX_INPUT_VARS=2000

# Fixes issues with docker exec
# See https://github.com/dockerfile/mariadb/issues/3
RUN echo "export TERM=xterm" >> ~/.bashrc

# Default site is phpinfo()
RUN rm -rf /var/www \
    && mkdir -p /web/public \
    && chown -R www-data.www-data /web/public


# Generate SSL cert
# Get environment variable for cert password
ARG DOCKER_SSL_SECRET
RUN cd /tmp \
    && openssl genrsa -des3 -passout pass:$DOCKER_SSL_SECRET -out snakeoil.pass.key 2048 \
    && openssl rsa -passin pass:$DOCKER_SSL_SECRET -in snakeoil.pass.key -out snakeoil.key \
    && openssl req -new -subj "/C=US/ST=California/L=San Francisco/O=Dis/CN=localhost" -key snakeoil.key -out snakeoil.csr \
    && openssl x509 -req -days 365 -in snakeoil.csr -signkey snakeoil.key -out snakeoil.pem \
    && mv ./snakeoil.key /etc/ssl/private/ssl-cert-snakeoil.key \
    && mv ./snakeoil.pem /etc/ssl/certs/ssl-cert-snakeoil.pem \
    && rm -rf /tmp/*

# Update
RUN apt-get update

# PHP Extensions
RUN apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libmcrypt-dev \
    libzip-dev \
    libssh2-1-dev \
    libxml2-dev \
    git \
    && pecl channel-update pecl.php.net \
    && pecl install ssh2-0.13 \
    && docker-php-ext-enable ssh2 \
    && docker-php-ext-install -j$(nproc) soap iconv mcrypt zip mysqli pdo pdo_mysql json exif \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

# Xdebug
RUN cd /tmp \
    && curl -o xdebug-2.5.0.tgz https://xdebug.org/files/xdebug-2.5.0.tgz \
    && tar -xvzf xdebug-2.5.0.tgz \
    && cd xdebug-2.5.0 \
    && phpize \
    && ./configure \
    && make \
    && mv modules/xdebug.so /usr/local/lib/php/extensions/no-debug-non-zts-20131226/

# Copy Rozinante.net to webroot
COPY /wwwroot /web/public

# Working directory
WORKDIR /web/public

# Configure Apache
COPY ./apache-docker.conf /etc/apache2/sites-available/docker.conf
RUN a2enmod actions ssl rewrite headers \
    && a2dissite 000-default default-ssl \
    && a2ensite docker

# Configure PHP
COPY /php-conf.d/shared/* /usr/local/etc/php/conf.d/
COPY /php-conf.d/php5.6/* /usr/local/etc/php/conf.d/

# Run
COPY /docker-entrypoint.sh /docker-entrypoint.sh
COPY /docker-entrypoint.d /docker-entrypoint.d
RUN chmod +x /docker-entrypoint.sh /docker-entrypoint.d/*
ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2-foreground"]