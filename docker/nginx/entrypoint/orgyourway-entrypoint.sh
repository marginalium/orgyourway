#!/bin/bash

phpenmod intl
phpenmod gd
phpenmod mbstring
phpenmod zip

export ADMIN_USERNAME=$ADMIN_USERNAME
export ADMIN_PASSWORD=$ADMIN_PASSWORD
export APP_ENV=$APP_ENV
export APP_NAME=$APP_NAME
export MYSQL_DATABASE=$MYSQL_DATABASE
export MYSQL_HOST=$MYSQL_HOST
export MYSQL_UNIX_SOCKET=$MYSQL_UNIX_SOCKET
export MYSQL_USER=$MYSQL_USER
export MYSQL_PASSWORD=$MYSQL_PASSWORD
export HASHED_PASSWORD=`php /entrypoint/bcrypt_password_hash.php`

service nginx start
/etc/init.d/php8.1-fpm start

if [ "$APP_ENV" = "dev" ]
then
/entrypoint/waitforit.sh $MYSQL_HOST:3306 -t 100
fi

MYSQL_DATABASE=$MYSQL_DATABASE MYSQL_HOST=$MYSQL_HOST MYSQL_UNIX_SOCKET=$MYSQL_UNIX_SOCKET MYSQL_USER=$MYSQL_USER MYSQL_PASSWORD=$MYSQL_PASSWORD \
bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

composer install

GREEN='\033[0;32m'
NC='\033[0m' # No Color
printf "${GREEN}Setup completed!${NC}"

exec tail -f /dev/null

