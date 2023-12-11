# syntax=docker/dockerfile:1

FROM ubuntu:22.04
WORKDIR /app
COPY ./app /app
COPY ./static /var/www/html

RUN apt update && DEBIAN_FRONTEND=noninteractive apt install -y apache2 php php-mysqli libapache2-mod-php mariadb-server && chmod +x setup.sh
RUN ./setup.sh

CMD ["./start.sh"]

EXPOSE 80