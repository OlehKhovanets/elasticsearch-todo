FROM phpdockerio/php72-fpm:latest
WORKDIR "/application"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install cron php7.2-mysql php-redis php7.2-gd php-imagick php7.2-imap php7.2-intl php7.2-oauth php-http php-oauth php-mongodb php-ssh2 php-yaml \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY cronfile /etc/cron.d/cronfile

RUN crontab /etc/cron.d/cronfile

CMD cron -f
