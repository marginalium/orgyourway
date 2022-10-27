FROM ubuntu/nginx:1.18-22.04_beta

RUN apt update && \
    apt install -y git zip software-properties-common curl mysql-client file sendmail

RUN add-apt-repository ppa:ondrej/php

RUN apt-get update && \
    apt install -y php8.1 php8.1-fpm php8.1-mysql php8.1-xml php8.1-intl php8.1-gd php8.1-mbstring php8.1-zip

RUN curl --silent --show-error https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
apt-get install -y nodejs

ENV ADMIN_USERNAME ${ADMIN_USERNAME}
ENV ADMIN_PASSWORD ${ADMIN_PASSWORD}
ENV APP_NAME ${APP_NAME}
ENV ORG_ENV ${ORG_ENV}
ENV MYSQL_DATABASE ${MYSQL_DATABASE}
ENV MYSQL_HOST ${MYSQL_HOST}
ENV MYSQL_USER ${MYSQL_USER}
ENV MYSQL_PASSWORD ${MYSQL_PASSWORD}
ENV MYSQL_UNIX_SOCKET ${MYSQL_UNIX_SOCKET}

COPY app /var/www/html
COPY docker/nginx/config /etc/nginx/sites-enabled
COPY docker/nginx/entrypoint /entrypoint

WORKDIR /var/www/html/
RUN if [ "$ORG_ENV" = "prod"] ; then composer install --no-dev ; else composer install --dev ; fi

RUN npm install

CMD ["bash", "/entrypoint/entrypoint.sh"]
