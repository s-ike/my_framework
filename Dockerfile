FROM php:5.4-apache

RUN apt update \
    && apt install -y vim less \
    && mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled

RUN /bin/sh -c a2enmod rewrite
