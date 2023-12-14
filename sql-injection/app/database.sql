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
    Posted TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
INSERT INTO Users (Username, Password) VALUES ('CodeWizard87', '$2a$10$wby8FW3eSJdalvp1yTPZVuBV9YLBs1yTQbJgqVNQ.Ru4zEqL0r04y');
INSERT INTO Users (Username, Password) VALUES ('DataGeek23', '$2a$10$Mzc9zfVEnqxY.kz4VbGqju.ZUbDiae5gSCJHJJFw1QQBmJ58hpN2q');
INSERT INTO Users (Username, Password) VALUES ('Futur3_15_now', '$2a$10$4xfU9Zhnwb/b5Uyczk5QQeTOq.4u7jQgcFyV9gifZpOAhk/lmXJfK');
INSERT INTO Users (Username, Password) VALUES ('AI-Enthusiast', '$2a$10$kcRJqrYqGN0/1gnG1mJw5u5AkZy6psToTiN33xmQJu/IfVw.A/z2.');
INSERT INTO Users (Username, Password) VALUES ('not-a-bot', '$2a$10$u8zGABowhhIOMHMZmmt.kOSqlmV9aekKFaLocOFSJROneSu2M4Gsi');
INSERT INTO Users (Username, Password) VALUES ('Neo', '$2a$10$M/B77.WVmkMWyHw3bXEucuBm7T8T33FIzhHvk.Hf4Zya3g2mN56um');
INSERT INTO Users (Username, Password) VALUES ('Morpheus', '$2a$10$Ht9iLUCEY3beArzXNBhmv.VDEd6gnw7bdQC/sAWf/N0/X5ZL/El.6');
INSERT INTO Topics (Title) VALUES ('Cutting Edge Generative AI');
INSERT INTO Topics (Title) VALUES ('Embedded Software Engineering');
INSERT INTO Topics (Title) VALUES ('Cyber Security: SQL Injection?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 6, '2023-12-13 20:24:23', 'New to AI', 'Hey everyone! Just stumbled upon generative AI and Im fascinated by its potential. Can anyone recommend some cool projects or applications that showcase its capabilities?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 2, '2023-12-13 20:30:27', 'Recommended Tools', 'Absolutely! Check out projects like DALL-E and OpenAIs GPT-3. Theyre pushing the boundaries of what generative AI can do, from generating images to natural language processing. Mind-blowing stuff!');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 3, '2023-12-13 20:42:20', 'Its a Game Changer', 'Ive been experimenting with using generative AI for data augmentation in machine learning. Its been a game-changer for expanding training datasets and improving model performance. Anyone else exploring similar applications?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 4, '2023-12-13 21:01:40', 'Ethical Concerns', 'Exciting tech, no doubt, but we need to keep an eye on the ethical implications. The potential for bias in AI-generated content is a concern. How can we ensure responsible use and mitigate unintended consequences?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 5, '2023-12-13 21:14:41', 'RE: Ethical Concerns', 'Couldnt agree more! Its crucial to establish guidelines and ethical frameworks for AI development. Transparency and accountability should be at the forefront to ensure a positive impact on society.');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 6, '2023-12-13 21:23:03', 'Getting Started Tips', 'Those projects sound amazing! Any tips on getting started with experimenting on my own? What resources do you recommend for beginners?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 2, '2023-12-13 22:10:53', 'RE: Getting Started Tips', 'Start with OpenAIs documentation for GPT-3 and TensorFlow for DALL-E. There are also great online courses like Fast.ai that provide a hands-on approach to diving into generative AI.');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (1, 6, '2023-12-13 22:15:24', 'Here I go!', 'Thanks for the suggestions! Im also curious about potential challenges in implementing generative AI for data augmentation. Any experiences or advice from those whove been down that road?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (2, 2, '2023-12-13 20:30:42', 'Wheres the Hardware People?', 'Ive been watching some videos on YouTube recently about low-level firmware engineering and it seems super interesting! Anyone else here get into this area of software?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (2, 3, '2023-12-13 23:50:01', 'Somewhat...', 'Ive dabbled with chips like Ardiuno and ESP32 but Ive never explored the field too deep. Its really is a cool field though! Writing C code definitely changes your perspective on modern development tools like React and Angular. It kinda makes you wish you had a time machine to go back to the 70s.');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 8, '2023-12-12 23:02:28', 'Open your mind', 'I imagine that right now, youre feeling a bit like Alice. Tumbling down the rabbit hole? Hmm? I see it in your eyes. You have the look of a man who accepts what he sees because he is expecting to wake up. Ironically, thats not far from the truth. Do you believe in MariaDB, Neo?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 7, '2023-12-12 23:09:57', 'RE: Open your mind', 'No, I dont like the idea that Im not in control of my life.');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 8, '2023-12-12 23:14:43', 'RE: Open your mind', 'I know *exactly* what you mean. Let me tell you why youre here. Youre here because you know something. What you know you cant explain, but you feel it. Youve felt it your entire life, that theres something wrong with the internet. You dont know what it is, but its there, like a splinter in your mind, driving you mad. It is this feeling that has brought you to me. Do you know what Im talking about?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 7, '2023-12-12 23:18:26', 'RE: Open your mind', 'SQL Injection.');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 8, '2023-12-12 23:20:18', 'RE: Open your mind', 'Vulnerabilities are everywhere. They are all around us. Even now, on this very site. You can see it when you look at the post title or when you enter a message. You can feel it when you load this page... when you create a post... when you sign in. It is the world that has been pulled over your eyes to blind you from the truth.');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 7, '2023-12-12 23:21:54', 'RE: Open your mind', 'What truth?');
INSERT INTO Posts (TopicID, UserID, Posted, Title, Contents) VALUES (3, 8, '2023-12-12 23:22:32', 'RE: Open your mind', 'That Users has a Password field, Neo.');