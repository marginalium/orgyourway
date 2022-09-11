#!/bin/bash

service php8.1-fpm start

service nginx start

/entrypoint/waitforit.sh orgyourway-mysql:3306 -t 30
bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

exec tail -f /dev/null
