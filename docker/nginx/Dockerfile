FROM ubuntu/nginx

RUN apt update && \
    apt install -y git zip software-properties-common curl mysql-client

RUN add-apt-repository ppa:ondrej/php

RUN apt-get update && \
    apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-xml

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

CMD ["/entrypoint/orgyourway-entrypoint.sh"]
