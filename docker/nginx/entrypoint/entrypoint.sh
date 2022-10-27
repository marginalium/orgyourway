#!/bin/bash
echo "Starting entrypoint for ${ORG_ENV}...";
sh /entrypoint/orgyourway-entrypoint-"${ORG_ENV}".sh
