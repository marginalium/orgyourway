#!/bin/bash

service php8.2-fpm start

service nginx start

exec tail -f /dev/null
