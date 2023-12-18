# Basic SQL Injection
This problem features a basic LAMP stack (Linux Apache MariaDB PHP) bundled into a Docker container to recreate the same environment every time this problem is played. This problem contains a vulnerability in the PHP code that allows for SQL injection in some areas of the site through which a user could gain access to information such as user credentials that they otherwise should not have access to.

### Problem Goal
For this problem you are presented with a platform called 'Tech Topics' where users can create a topic and make posts within topics about anything technology related. It's a neat concept that allows tech geeks to connect with other tech geeks online and communicate ideas about current events and topics but there is believed to be a SQL injection vulnerabilty in this rapidly growing site. It is specualted that the flag is located in the admin user's password so it is your job as a black-hat hacker to follow the clues leading you down the rabbit hole to identify the admin's password.

## Usage
To get the problem running first ensure that you have Docker installed. Then use the following commands to build and launch the container.

Build the dockerimage:
```sh
docker build -t techtopics .
```

Launch a container:
```sh
docker run -d -p 8080:80 techtopics
```

This will launch an instance of the tech topics container on your local machine with the site accessible at `http://localhost:8080`. Visit this page in your browser and begin experimenting with the site.