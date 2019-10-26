create database twitter;

grant all on twitter.* to dbuser@localhost identified by 'vagrantVagrant@123';

create table users (
  u_id int unsigned not null auto_increment primary key,
  u_name varchar(255),
  u_email varchar(255) unique,
  u_password varchar(255),
  u_thumb varchar(255)
);
