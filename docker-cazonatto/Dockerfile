FROM php:8.3-apache

RUN apt-get update && \
    apt-get install -y \
    vim \
    wget \
    gnupg2 \
    git \
    zip \
    unzip 

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apt-get update && \
    apt-get install -y libsqlite3-dev sqlite3 

RUN a2enmod rewrite

RUN ln -sf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime
