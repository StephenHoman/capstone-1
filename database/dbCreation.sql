DROP DATABASE myDatabase;

CREATE DATABASE myDatabase;

USE myDatabase;

CREATE TABLE login (
	login_id INT NOT NULL AUTO_INCREMENT,
    user_username VARCHAR(25) NOT NULL,
    user_password VARCHAR(25) NOT NULL,
    PRIMARY KEY (login_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE images (
	image_id INT NOT NULL AUTO_INCREMENT,
    image_url VARCHAR(200) NOT NULL,
    PRIMARY KEY (image_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE users (
	user_id INT NOT NULL AUTO_INCREMENT,
    user_description VARCHAR(200),
    email VARCHAR(30) NOT NULL,
    login_id INT NOT NULL,
    image_id INT,
    address_line_one VARCHAR(200) NOT NULL,
    address_line_two VARCHAR(200),
    state CHAR(2) NOT NULL,
    city VARCHAR(30) NOT NULL,
    zip_code INT NOT NULL,
    account_creation_date DATE NOT NULL,
    last_online DATE NOT NULL,
    transaction_count INT NOT NULL,
    premium_user BOOL NOT NULL,
    CONSTRAINT PK_users PRIMARY KEY (user_id),
    CONSTRAINT FK_users_login FOREIGN KEY (login_id) REFERENCES login(login_id),
    CONSTRAINT FK_users_images FOREIGN KEY (image_id) REFERENCES images(image_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE users_login (
	user_id INT NOT NULL,
    login_id INT NOT NULL,
    PRIMARY KEY (user_id, login_id),
    CONSTRAINT FK_users_login_user FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT FK_users_login_login FOREIGN KEY (login_id) REFERENCES login(login_id)
);

CREATE TABLE users_image (
	user_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (user_id, image_id),
    CONSTRAINT FK_users_image_user FOREIGN KEY (user_id) REFERENCES users(user_id),
    CONSTRAINT FK_users_image_image FOREIGN KEY (image_id) REFERENCES images(image_id)
);

CREATE TABLE category (
	category_id INT NOT NULL AUTO_INCREMENT,
    category_name VARCHAR(20) NOT NULL,
    PRIMARY KEY (category_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE tags (
	tag_id INT NOT NULL AUTO_INCREMENT,
    tag_name VARCHAR(25) NOT NULL,
    PRIMARY KEY (tag_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE items (
	item_id INT NOT NULL AUTO_INCREMENT,
    item_name VARCHAR(100) NOT NULL,
    item_description VARCHAR(250),
    category_id INT NOT NULL,
    tag_id INT NOT NULL,
    item_price DECIMAL(7,2) NOT NULL,
    image_id INT NOT NULL,
    user_id INT NOT NULL,
    date_posted DATE NOT NULL,
    premium_status BOOL NOT NULL,
    featured_item BOOL NOT NULL,
    sold BOOL NOT NULL,
    CONSTRAINT PK_items PRIMARY KEY (item_id),
    CONSTRAINT FK_items_categories FOREIGN KEY (category_id) REFERENCES category(category_id),
    CONSTRAINT FK_items_tags FOREIGN KEY (tag_id) REFERENCES tags(tag_id),
    CONSTRAINT FK_items_images FOREIGN KEY (image_id) REFERENCES images(image_id),
    CONSTRAINT FK_items_users FOREIGN KEY (user_id) REFERENCES users(user_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE item_images (
	item_id INT NOT NULL,
    image_id INT NOT NULL,
    PRIMARY KEY (item_id, image_id),
    CONSTRAINT FK_item_images_items FOREIGN KEY (item_id) REFERENCES items(item_id),
    CONSTRAINT FK_item_images_images FOREIGN KEY (image_id) REFERENCES images(image_id)
);

CREATE TABLE item_tags (
	item_id INT NOT NULL,
    tag_id INT NOT NULL,
    PRIMARY KEY (item_id, tag_id),
    CONSTRAINT FK_item_tags_items FOREIGN KEY (item_id) REFERENCES items(item_id),
    CONSTRAINT FK_item_tags_tags FOREIGN KEY (tag_id) REFERENCES tags(tag_id)
);

CREATE TABLE transactions (
	transaction_id INT NOT NULL AUTO_INCREMENT,
    buyer_user_id INT NOT NULL,
    seller_user_id INT NOT NULL,
    item_id INT NOT NULL,
    transaction_time TIMESTAMP NOT NULL,
    CONSTRAINT PK_transactions PRIMARY KEY (transaction_id),
    CONSTRAINT FK_transaction_buyer FOREIGN KEY (buyer_user_id) REFERENCES users(user_id),
    CONSTRAINT FK_transaction_seller FOREIGN KEY (seller_user_id) REFERENCES users(user_id),
    CONSTRAINT FK_transaction_item FOREIGN KEY (item_id) REFERENCES items(item_id)
)
AUTO_INCREMENT = 100;

CREATE TABLE messages (
	message_id INT NOT NULL AUTO_INCREMENT,
    sender_user_id INT NOT NULL,
    receiver_user_id INT NOT NULL,
    message VARCHAR(250) NOT NULL,
    date_time_sent TIMESTAMP NOT NULL,
    PRIMARY KEY (message_id)
)
AUTO_INCREMENT = 100;

