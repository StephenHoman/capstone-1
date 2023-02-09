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
    PRIMARY KEY (message_id),
    CONSTRAINT FK_message_sender FOREIGN KEY (sender_user_id) REFERENCES users(user_id),
    CONSTRAINT FK_message_receiver FOREIGN KEY (receiver_user_id) REFERENCES users(user_id)
)
AUTO_INCREMENT = 100;

INSERT INTO login VALUES ('100', 'stormbatscorpionmars', 'g66HC73hLC92PvpKD4er');
INSERT INTO login VALUES ('106', 'greenpepperspinach', '7WRLeeDASJkRJHw5L2DM');
INSERT INTO login VALUES ('107', 'seallobster', 'UsP4YWRwSj8ZLR8UrZmy');
INSERT INTO login VALUES ('109', 'scarface', 'd4EX3A4bQDhUd23smPVh');
INSERT INTO login VALUES ('112', 'hamstergreenpepper', 'w2njwTmNqxUURzBSAg6V');
INSERT INTO login VALUES ('123', 'babaisyou', 'sndfkjl345djklsfd');

INSERT INTO images VALUES ('100', 'yMiqytGk5RmjBZxfxjrw.png');
INSERT INTO images VALUES ('101', 'hjskybcGh34HFbWibXJ3.jpg');
INSERT INTO images VALUES ('102', 'vLv1hz3N13sk4lngEMec.png');
INSERT INTO images VALUES ('103', 'YsYwN65EZsdtDnn5JZKM.png');
INSERT INTO images VALUES ('104', 'dfgsdfrgdfsgdsgf.jpg');
INSERT INTO images VALUES ('105', 'osdlijsfjdkl.jpg');
INSERT INTO images VALUES ('137', 'awqsdsadsfed.png');
INSERT INTO images VALUES ('176', 'ghrtedqawed.png');
INSERT INTO images VALUES ('177', 'eashfj.png');
INSERT INTO images VALUES ('179', 'asddfssdf.png');
INSERT INTO images VALUES ('181', 'jrtyhggfhgv.png');
INSERT INTO images VALUES ('188', 'iojakhddsa.jpg');

INSERT INTO users VALUES ('100', 'I sell used video games.', 'blahblahblah@blah.com', '100', '137', '766 South Ave.', '', 'GA', 'Duluth', '30096', '2023-02-07', '2023-02-08', '5', '1');
INSERT INTO users VALUES ('101', 'She didn''t drink, but she didn''t want people to realize that, so she ordered a ginger ale at the bar.', 'aleksandrabronov@24hinbox.com', '106', '176', '53 Marshall Road', '', 'VA', 'Gainesville', '20155', '2023-02-11', '2023-02-11', '1', '1');
INSERT INTO users VALUES ('102', 'You can apply online if you want to.', 'matyflex14gb@taikz.com', '107', '177', '7283 Cambridge Drive', 'Apartment 3', 'KS', 'Emporia', '66801', '2023-02-17', '2023-03-02', '0', '0');
INSERT INTO users VALUES ('103', 'Today is Sunday, which means tomorrow is Monday and yesterday was Saturday.', 'moiiashik82@indmeds.com', '109', '179', '9559 Harvard St.', '', 'RI', 'Providence', '29041', '2023-03-11', '2023-03-12', '6', '1');
INSERT INTO users VALUES ('104', 'I started drinking when I was sixteen, but I''m European.', 'hodyuk79@boranora.com', '112', '181', '7105 Vale St.', 'Unit 21', 'PA', 'Allison Park', '15101', '2023-03-12', '2023-03-12', '7', '0');
INSERT INTO users VALUES ('105', 'I pick you up in front of the hotel.', 'tarohanzawa@gotcertify.com', '123', '188', '789 Howard Court', 'Apartment 17', 'NY', 'Ozone Park', '11417', '2023-03-12', '2023-03-13', '66', '1');

INSERT INTO users_login VALUES ('100', '100');
INSERT INTO users_login VALUES ('101', '106');
INSERT INTO users_login VALUES ('102', '107');
INSERT INTO users_login VALUES ('103', '109');
INSERT INTO users_login VALUES ('104', '112');

INSERT INTO users_image VALUES ('100', '137');
INSERT INTO users_image VALUES ('101', '176');
INSERT INTO users_image VALUES ('102', '177');
INSERT INTO users_image VALUES ('103', '179');
INSERT INTO users_image VALUES ('104', '181');

INSERT INTO category VALUES ('100', 'clothing');
INSERT INTO category VALUES ('101', 'tech');
INSERT INTO category VALUES ('102', 'books');
INSERT INTO category VALUES ('104', 'movies');
INSERT INTO category VALUES ('109', 'toys');
INSERT INTO category VALUES ('111', 'other');

INSERT INTO tags VALUES ('104', 'nintendo');
INSERT INTO tags VALUES ('106', 'harrypotter');
INSERT INTO tags VALUES ('111', 'mug');
INSERT INTO tags VALUES ('112', 'tennis');
INSERT INTO tags VALUES ('116', 'fishing');

INSERT INTO items VALUES ('100', 'jar of peanut butter', 'This glass is breakable.', '100', '104', '2.77', '100', '100', '2023-02-08', '1', '0', '0');
INSERT INTO items VALUES ('101', 'mouse pad', 'She loved Thailand so much that she seriously considered never going home.', '104', '106', '300.01', '101', '100', '2023-02-08', '0', '1', '1');
INSERT INTO items VALUES ('102', 'martini glass', 'The sun comes up in the east.', '109', '111', '15.99', '102', '101', '2023-02-10', '0', '1', '0');
INSERT INTO items VALUES ('103', 'baseball hat', 'The box was wrapped in paper with tiny silver and red glitter dots.', '102', '104', '23.87', '103', '102', '2023-02-11', '0', '1', '0');
INSERT INTO items VALUES ('104', 'keyboard', 'Get away from me, you slimy little worm!', '111', '112', '61.04', '105', '105', '2023-02-21', '0', '0', '0');

INSERT INTO item_images VALUES ('100', '100');
INSERT INTO item_images VALUES ('101', '101');
INSERT INTO item_images VALUES ('102', '102');
INSERT INTO item_images VALUES ('103', '103');
INSERT INTO item_images VALUES ('104', '105');

INSERT INTO item_tags VALUES ('100', '104');
INSERT INTO item_tags VALUES ('101', '106');
INSERT INTO item_tags VALUES ('102', '111');
INSERT INTO item_tags VALUES ('104', '112');

INSERT INTO transactions VALUES ('100', '100', '101', '100', '2023-04-06 22:32:41');
INSERT INTO transactions VALUES ('101', '101', '102', '102', '2023-07-14 05:52:26');
INSERT INTO transactions VALUES ('102', '102', '103', '104', '2023-07-24 07:42:12');
INSERT INTO transactions VALUES ('103', '103', '104', '104', '2023-12-20 02:24:02');

INSERT INTO messages VALUES ('100', '100', '101', 'She was so stupid he couldn''t help but roll his eyes.', '2023-11-20 21:29:29');
INSERT INTO messages VALUES ('101', '101', '102', 'He thought the movie was great except for the scene with the cantaloupe.', '2023-02-13 01:41:52');
INSERT INTO messages VALUES ('102', '102', '103', 'Two big powers have signed a secret agreement.', '2023-02-12 23:56:01');
INSERT INTO messages VALUES ('103', '103', '104', 'If you don''t shut up, I will turn this car around.', '2023-06-07 06:43:52');
INSERT INTO messages VALUES ('104', '104', '105', 'Let''s all just take a moment to breathe, please!', '2023-11-16 18:50:32');
