#!/bin/bash
echo "Starting entrypoint for ${ORG_ENV}... Unix socket is ${MYSQL_UNIX_SOCKET}";
sh /entrypoint/orgyourway-entrypoint-"${ORG_ENV}".sh
