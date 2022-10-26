#!/bin/bash

phpenmod intl
phpenmod gd
phpenmod mbstring
phpenmod zip

export ADMIN_USERNAME=$ADMIN_USERNAME
export ADMIN_PASSWORD=$ADMIN_PASSWORD
export APP_ENV=$ORG_ENV
export APP_NAME=$APP_NAME
export MYSQL_DATABASE=$MYSQL_DATABASE
export MYSQL_HOST=$MYSQL_HOST
export MYSQL_UNIX_SOCKET=$MYSQL_UNIX_SOCKET
export MYSQL_USER=$MYSQL_USER
export MYSQL_PASSWORD=$MYSQL_PASSWORD
export HASHED_PASSWORD=`php /entrypoint/bcrypt_password_hash.php`

service nginx start
/etc/init.d/php8.1-fpm start

chown -R www-data:www-data /var/www/html

if [ "$APP_ENV" = "dev" ]
then
  echo "Executing commands for the dev environment"
  composer install --dev
fi

composer assets:install %PUBLIC_DIR%

chown -R www-data:www-data /var/www/html

bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

GREEN='\033[0;32m'
NC='\033[0m' # No Color
printf "${GREEN}Setup completed!${NC}"

exec tail -f /dev/null

