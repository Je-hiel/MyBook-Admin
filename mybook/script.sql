drop database if exists mybook_test;

create database mybook_test;
show databases;
use mybook_test;

drop table if exists user;
drop table if exists friend;
drop table if exists profile;
drop table if exists photo;
drop table if exists user_group;
drop table if exists group_creator;
drop table if exists group_member;
drop table if exists content_editor;
drop table if exists post;
drop table if exists post_creator;
drop table if exists post_photo;
drop table if exists group_post;
drop table if exists comment;
drop table if exists commenter;
drop table if exists likes;
drop table if exists liked_by;
drop table if exists dislikes;
drop table if exists disliked_by;

drop trigger if exists createProfile;


create table user(
	user_id int AUTO_INCREMENT not null,
	username varchar(20) not null unique,
	email varchar(70) not null unique,
	password varchar(20) not null, -- Will have to encrypt this with PHP
	first_name varchar(20) not null,
	last_name varchar(20) not null,
	date_of_birth date not null,
	primary key (user_id)
);

-- user is a friend of user
create table friend(
	user_id int not null,
	friend_id int not null,
	type varchar(30) not null,
	primary key (user_id, friend_id),
	foreign key (user_id) references user(user_id) on delete cascade on update cascade,
	foreign key (friend_id) references user(user_id) on delete cascade on update cascade
);

-- Weak entity 
create table profile(
	profile_id int AUTO_INCREMENT not null, -- Each profile associated with a unique user
	user_id int not null, -- user can only have one profile
	primary key (profile_id),
	foreign key (user_id) references user(user_id) on delete cascade on update cascade
);

-- Weak entity
create table photo(
	user_id int not null,
	profile_id int not null, -- All photos attached to a profile
	photo_id int not null,
	url varchar(255) not null, -- All photos will be retrieved from the internet
	primary key (user_id, profile_id, photo_id),
	foreign key (user_id, profile_id) references profile(user_id, profile_id) on delete cascade on update cascade
);

create table user_group(
	group_id int AUTO_INCREMENT not null,
	name varchar(100) not null,
	primary key (group_id)
);

-- User that created a group
create table group_creator(
	group_id int not null,
	user_id int not null,
	primary key (group_id),
	foreign key (group_id) references user_group(group_id) on delete cascade on update cascade,
	foreign key (user_id) references user(user_id) on delete restrict on update cascade
);

-- Member of a group
create table group_member(
	user_id int not null,
	group_id int  not null,
	primary key (user_id, group_id),
	foreign key (user_id) references user(user_id) on delete cascade on update cascade,
	foreign key (group_id) references user_group(group_id) on delete cascade on update cascade
);

-- Content editor for a group
create table content_editor(
	user_id int not null,
	group_id int  not null,
	primary key (user_id, group_id),
	foreign key (user_id) references user(user_id) on delete cascade on update cascade,
	foreign key (group_id) references user_group(group_id) on delete cascade on update cascade
);

create table post(
	post_id int AUTO_INCREMENT not null,
	title varchar(255) not null,
	content text not null,
	created_at timestamp default current_timestamp(),
	primary key (post_id)
);

-- User that made a post
create table post_creator(
	post_id int not null,
	user_id int not null,
	primary key (post_id),
	foreign key (post_id) references post(post_id) on delete cascade on update cascade,
	foreign key (user_id) references user(user_id) on delete cascade on update cascade
);

-- Weak entity
-- Derived from IS-A relationship (ie. post photo is a photo)
create table post_photo(
	user_id int not null,
	profile_id int not null,
	photo_id int not null,
	post_id int not null,
	primary key (user_id, profile_id, photo_id),
	foreign key (user_id, profile_id, photo_id) references photo(user_id, profile_id, photo_id) on delete cascade on update cascade,
	foreign key (post_id) references post(post_id) on delete cascade on update cascade
);

-- Weak entity
-- Derived from IS-A relationship (ie. group post is a post)
create table group_post(
	post_id int not null,
	group_id int not null,
	primary key (post_id),
	foreign key (post_id) references post(post_id) on delete cascade on update cascade,
	foreign key (group_id) references user_group(group_id) on delete cascade on update cascade
);

create table comment(
	comment_id int AUTO_INCREMENT not null,
	post_id int not null,
	content text,
	created_at timestamp default current_timestamp(),
	primary key (comment_id),
	foreign key (post_id) references post(post_id) on delete cascade on update cascade
);

create table commenter(
	comment_id int not null,
	user_id int not null,
	primary key (comment_id),
	foreign key (user_id) references user(user_id) on delete cascade on update cascade
);

create table likes(
	like_id int AUTO_INCREMENT not null,
	post_id int not null,
	primary key (like_id),
	foreign key (post_id) references post(post_id) on delete cascade on update cascade
);

create table liked_by(
	like_id int not null,
	user_id int not null,
	primary key (like_id),
	foreign key (like_id) references likes(like_id) on delete cascade on update cascade,
	foreign key (user_id) references user(user_id) on delete cascade on update cascade
);

create table dislikes(
	dislike_id int AUTO_INCREMENT not null,
	post_id int not null,
	primary key (dislike_id),
	foreign key (post_id) references post(post_id) on delete cascade on update cascade
);

create table disliked_by(
	dislike_id int not null,
	user_id int not null,
	primary key (dislike_id),
	foreign key (dislike_id) references dislikes(dislike_id) on delete cascade on update cascade,
	foreign key (user_id) references user(user_id) on delete cascade on update cascade
);

describe user;
describe friend;
describe profile;
describe photo;
describe user_group;
describe group_creator;
describe group_member;
describe content_editor;
describe post;
describe post_creator;
describe post_photo;
describe group_post;
describe comment;
describe commenter;
describe likes;
describe liked_by;
describe dislikes;
describe disliked_by;

DELIMITER $$
	CREATE TRIGGER createProfile 
	AFTER INSERT ON user 
	FOR EACH ROW
	BEGIN 
		INSERT INTO profile(user_id) VALUES(NEW.user_id);
	END $$	
DELIMITER ;

DELIMITER $$
	CREATE TRIGGER reverseFriendship 
	AFTER INSERT ON friend 
	FOR EACH ROW
	BEGIN 
		INSERT INTO friend(user_id, friend_id, type) VALUES(NEW.friend_id, NEW.user_id, NEW.type);
	END $$	
DELIMITER ;

DELIMITER $$
	CREATE TRIGGER addCreatorAsMember 
	AFTER INSERT ON group_creator 
	FOR EACH ROW 
	BEGIN
		INSERT INTO group_member(user_id, group_id) VALUES(NEW.user_id, NEW.group_id);
	END $$
DELIMITER ;

DELIMITER $$
	CREATE TRIGGER addContentEditor
	AFTER INSERT ON group_creator 
	FOR EACH ROW 
	BEGIN
		INSERT INTO content_editor(user_id, group_id) VALUES(NEW.user_id, NEW.group_id);
	END $$
DELIMITER ;

DELIMITER $$
	CREATE PROCEDURE getUserFriends(IN user_id INT) 
	BEGIN 
		SELECT user.user_id, user.first_name, user.last_name, user.username 
		FROM friend 
		JOIN user 
		ON friend.friend_id = user.user_id 
		WHERE friend.user_id = user_id; 
	END $$
DELIMITER ;

DELIMITER $$
	CREATE PROCEDURE getUserGroups(IN user_id INT) 
	BEGIN 
		SELECT user.user_id, user.first_name, user.last_name, user.username 
		FROM friend 
		JOIN user
		ON friend.friend_id = user.user_id 
		WHERE friend.user_id = user_id; 
	END $$
DELIMITER ;


DELIMITER $$
	CREATE PROCEDURE getUserPosts(IN user_id INT)
    BEGIN
        SELECT  user.username, post.title, post.content
        FROM 
            post_creator
                INNER JOIN 
            user
                ON user.user_id = post_creator.user_id
                INNER JOIN
            post
                ON post.post_id = post_creator.post_id
        WHERE user.user_id = user_id AND post_creator.user_id = user_id;	
	END $$
DELIMITER ;


load data infile 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/mybook_test_user.csv'
into table user
fields terminated by ','
lines terminated by '\n'
ignore 1 rows
(username, email, password, first_name, last_name, date_of_birth);

/***
load data infile 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/mybook_test_friend.csv'
into table friend
fields terminated by ','
lines terminated by '\n'
ignore 1 rows
(user_id, friend_id, type);


load data infile 'C:/ProgramData/MySQL/MySQL Server 8.0/Uploads/mybook_test_profile.csv'
into table profile
fields terminated by ','
lines terminated by '\n'
ignore 1 rows
(user_id);
***/

select * from user;
select * from friend;