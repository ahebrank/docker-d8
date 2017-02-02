FROM drupal:8-fpm

# some neccessities
RUN apt-get update -y && \
  apt-get install -y apt-utils python-software-properties git curl rsync unzip

# add in composer
RUN cd /root && \
  php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php composer-setup.php && \
  rm composer-setup.php

# install D8
RUN cd / && \
  php /root/composer.phar create-project drupal-composer/drupal-project:8.x-dev app --stability dev --no-interaction

RUN chown -R www-data /app
