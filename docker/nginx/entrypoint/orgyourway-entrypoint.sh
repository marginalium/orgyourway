#!/bin/bash

phpenmod intl

service php8.1-fpm start

service nginx start

/entrypoint/waitforit.sh orgyourway-mysql:3306 -t 100
bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

cp /var/www/html/.env.dist /var/www/html/.env

HASHED_PASSWORD=`php /entrypoint/bcrypt_password_hash.php`

sed -i "s/%%MYSQL_USER%%/${MYSQL_USER}/" /var/www/html/.env
sed -i "s/%%MYSQL_PASSWORD%%/${MYSQL_PASSWORD}/" /var/www/html/.env
sed -i "s/%%MYSQL_DATABASE%%/${MYSQL_DATABASE}/" /var/www/html/.env
sed -i "s/%%ADMIN_USERNAME%%/${ADMIN_USERNAME}/" /var/www/html/.env
sed -i "s,%%ADMIN_PASSWORD%%,$HASHED_PASSWORD," /var/www/html/.env

GREEN='\033[0;32m'
NC='\033[0m' # No Color
printf "${GREEN}Setup completed!${NC}"

exec tail -f /dev/null
