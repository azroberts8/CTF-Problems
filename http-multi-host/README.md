# HTTPS Multiple Hosts
This problem features an NGINX web server configured to host under multiple hostnames/domain names. This is a setup used commonly for reverse proxies where an administrator may be attempting to publicly expose multiple services from the same network. (think example.com & api.example.com running on 2 different servers on the same LAN network). Inspired by a personal mistake, an admistrator would like to run both a publicly exposed service as well as a service that is privately available on the LAN network using the same reverse proxy believing the later service will remain private if there is no public DNS record resolving to the server that matches the hostname of the private host.

### Problem Goal
For this problem you are presented with a public facing webpage running behind a reverse proxy. You believe there is another service running privately behind the same proxy. You goal is to gain access to the NSA's secrets through a mistake in their configuration.

## Usage
To get the problem running first ensure that you have Docker installed. Then proceed with the following steps to build and launch the container to for hosting this problem.

### Generating public SSL certificate
The public facing webpage strictly runs on HTTPS so we will need to generate a valid SSL certificate for the domain this problem will be served under before building and running the problem. We can easily do this for free using [Letsencrypt](https://letsencrypt.org/) and certbot. To automate this we can run the following command making sure to enter your domain or subdomain in the appropriate field.
```sh
docker run -it -v ./certs:/etc/letsencrypt certbot/certbot certonly --manual --register-unsafely-without-email --agree-tos --preferred-challenges dns --cert-name public -d "YOUR-DOMAIN-HERE"
```
This command will provide a DNS challenge for validating ownership of the domain you entered. Follow the instructions certbot provides to temporarily add a DNS record to your domain then press enter to proceed. Certbot will verify the randomly generated code it provided exists as a TXT record on your domain and proceed with generating and SSL certificate for your domain.

### Building Docker Image
After we have generated the SSL certificate for our site, update the flag found in `./secrets.nsa.gov/index.html` to your desired flag for the CTF challenge. Now we can proceed to build the Docker image using the command below. This will build our image and tag it with the name `ctf-multihost`
```sh
docker build -t ctf-multihost .
```

### Launching Docker Container
Once we have build our Docker image we can now launch an active container with the command below. To run the HTTPS service we will need to expose post 443 which is included in the run command.
```sh
docker run -d -p 443:443 ctf-multihost
```

Assuming that your firewall is configured to forward this port and that you have a DNS record pointing to your server, the problem should now be active and accessible to the world. Happy hacking!