FROM nginx:latest

COPY ./helloworld.com /var/www/html
COPY ./secrets.nsa.gov /var/www/secrets.nsa.gov
COPY ./default.conf /etc/nginx/conf.d
COPY ./certs /certs

WORKDIR /certs/secrets.nsa.gov
RUN openssl req -x509 -newkey rsa:4096 -keyout private.key -out cert.pem -sha256 -days 730 -nodes -subj "/C=US/ST=DC/L=Washington/O=NSA/OU=Secrets/CN=secrets.nsa.gov"

EXPOSE 443