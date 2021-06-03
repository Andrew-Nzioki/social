CREATE DATABASE scheduleApp;
use scheduleApp;

CREATE TABLE bucket(
    id INT PRIMARY KEY AUTO_INCREMENT,
    bucket_name VARCHAR(100) NOT NULL UNIQUE,
    created_on TIMESTAMP NOT NULL,
    updated_on TIMESTAMP NULL
);
CREATE TABLE document(
    id INT PRIMARY KEY AUTO_INCREMENT,
    bucket_id INT NOT NULL,
    document_name VARCHAR(200) NOT NULL,

    FOREIGN KEY(bucket_id) REFERENCES bucket(id) ON DELETE CASCADE
);
CREATE TABLE images(
    id INT PRIMARY KEY AUTO_INCREMENT,
    bucket_id INT NOT NULL,
    image_name VARCHAR(200) NOT NULL,

    FOREIGN KEY(bucket_id) REFERENCES bucket(id) ON DELETE CASCADE
    );
CREATE TABLE media(
    id INT PRIMARY KEY AUTO_INCREMENT,
    bucket_id INT NOT NULL,
    media_name VARCHAR(200) NOT NULL,

    FOREIGN KEY(bucket_id) REFERENCES bucket(id) ON DELETE CASCADE
);
CREATE TABLE post(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    bucket_id INT NOT NULL,
    title VARCHAR(50) NOT NULL UNIQUE,
	created_on TIMESTAMP NOT NULL,
    edited_on TIMESTAMP NULL,
    
    FOREIGN KEY(bucket_id) REFERENCES bucket(id) ON DELETE CASCADE
    );
CREATE TABLE post_message(
    post_id INT NOT NULL,
    post_message VARCHAR(250) NOT NULL,

    FOREIGN KEY(post_id) REFERENCES post(id) ON DELETE CASCADE
);
CREATE TABLE post_keywords(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    post_id INT NOT NULL,
    keyword VARCHAR(20) NOT NULL,

    FOREIGN KEY(post_id) REFERENCES post(id) ON DELETE CASCADE
);

CREATE TABLE platform(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    post_id INT NULL,
    platform ENUM('facebook','instagram','linkedin') NOT NULL,
    profile_url VARCHAR(250) NOT NULL,

    FOREIGN KEY(post_id) REFERENCES post(id) ON DELETE CASCADE
);

CREATE TABLE scheduler(
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    post_id INT NOT NULL,
    date_to_Post DATETIME NOT NULL,

    FOREIGN KEY(post_id) REFERENCES post(id)
);

