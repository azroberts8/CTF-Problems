# syntax=docker/dockerfile:1

FROM ubuntu:22.04
WORKDIR /
COPY ./static /var/www/html

RUN apt update && DEBIAN_FRONTEND=noninteractive apt install -y apache2 php libapache2-mod-php mariadb-server

CMD ["apache2ctl", "-D", "FOREGROUND"]

EXPOSE 80