/* Create Database */
CREATE DATABASE IF NOT EXISTS app;
USE app;

/* Create Tables */
CREATE TABLE IF NOT EXISTS Users(
    UserID smallint(6) unsigned NOT NULL AUTO_INCREMENT,
    Username varchar(30) NOT NULL,
    Password varchar(255) NOT NULL,
    PRIMARY KEY (UserID),
    UNIQUE (Username)
);

CREATE TABLE IF NOT EXISTS Topics(
    TopicID smallint(6) unsigned NOT NULL AUTO_INCREMENT,
    Title varchar(120) NOT NULL,
    PRIMARY KEY (TopicID)
);

CREATE TABLE IF NOT EXISTS Posts(
    PostID smallint(6) unsigned NOT NULL AUTO_INCREMENT,
    TopicID smallint(6) unsigned NOT NULL,
    UserID smallint(6) unsigned NOT NULL,
    Created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    Title varchar(120) NOT NULL,
    Contents varchar(16000) NOT NULL,
    PRIMARY KEY (PostID),
    FOREIGN KEY (TopicID) REFERENCES Topics(TopicID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

/* Create PHP user and grant permissions */
CREATE USER IF NOT EXISTS 'php'@'localhost' IDENTIFIED BY 'SuperSecurePassword';
GRANT SELECT, INSERT ON app.Users TO 'php'@'localhost';
GRANT SELECT, INSERT ON app.Posts TO 'php'@'localhost';
GRANT SELECT, INSERT ON app.Topics TO 'php'@'localhost';
FLUSH PRIVILEGES;

/* Populate the database with contents */
INSERT INTO Users (Username, Password) VALUES ('admin', 'flag{u5e_pr3par3d_5t8m3nt5}');
INSERT INTO Topics (Title) VALUES ('Cutting Edge Generative AI');
INSERT INTO Topics (TItle) VALUES ('Embedded Software Engineering');