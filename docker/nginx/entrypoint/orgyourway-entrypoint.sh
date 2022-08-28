#!/bin/bash

service php8.1-fpm start

service nginx start

exec tail -f /dev/null
