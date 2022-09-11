#!/bin/bash

service php8.1-fpm start

service nginx start

/entrypoint/waitforit.sh orgyourway-mysql:3306 -t 30
bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

cp /var/www/html/.env.dist /var/www/html/.env

sed -i "s/%%MYSQL_USER%%/${MYSQL_USER}/" /var/www/html/.env
sed -i "s/%%MYSQL_PASSWORD%%/${MYSQL_PASSWORD}/" /var/www/html/.env
sed -i "s/%%MYSQL_DATABASE%%/${MYSQL_DATABASE}/" /var/www/html/.env
sed -i "s/%%ADMIN_USERNAME%%/${ADMIN_USERNAME}/" /var/www/html/.env
sed -i "s/%%ADMIN_PASSWORD%%/${ADMIN_PASSWORD}/" /var/www/html/.env

exec tail -f /dev/null
