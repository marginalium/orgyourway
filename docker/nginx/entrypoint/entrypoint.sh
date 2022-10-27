#!/bin/bash
echo "Starting entrypoint for ${ORG_ENV}...";
ls /cloudsql/
file "${MYSQL_UNIX_SOCKET}"
sh /entrypoint/orgyourway-entrypoint-"${ORG_ENV}".sh
