create database twitter;

grant all on twitter.* to dbuser@localhost identified by 'vagrantVagrant@123';

create table users (
  u_id int unsigned not null auto_increment primary key,
  u_name varchar(255),
  u_email varchar(255) unique,
  u_password varchar(255),
  u_icon varchar(255),
  u_background varchar(255)
);

create table posts (
  p_id int unsigned not null auto_increment primary key,
  p_user_id int unsigned,
  p_text varchar(140),
  p_img varchar(255),
  p_comment int unsigned default 0,
  p_like int unsigned default 0,
  p_date datetime
);
