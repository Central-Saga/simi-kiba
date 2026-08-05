FROM docker.io/serversideup/php:8.4-cli

USER root
RUN install-php-extensions intl

USER www-data
