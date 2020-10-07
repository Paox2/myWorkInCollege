create database if not exists scywh1;
drop table if exists ordering;
drop table if exists reps;
drop table if exists manager;
drop table if exists customer;
create table customer(
                         username CHAR(255) Primary key,
                         password CHAR(255) not null,
                         realname CHAR(255) not null,
                         PASSPORT CHAR(255) not null,
                         TEL CHAR(13) not null,
                         email CHAR(255) not null,
                         region CHAR(255) not null
);
create table manager(
                        username CHAR(255) primary KEY,
                        password CHAR(255) not null,
                        realname CHAR(255) not null,
                        PASSPORT CHAR(255) not null,
                        TEL CHAR(13) not null,
                        email CHAR(255) not null,
                        region CHAR(255) not null
);
create table reps(
                     ID int not null,
                     username CHAR(255) primary KEY not null,
                     password CHAR(255) not null,
                     realname CHAR(255) not null,
                     PASSPORT CHAR(255) not null,
                     TEL CHAR(13) not null,
                     email CHAR(255) not null,
                     region CHAR(255) not null,
                     quotaN95 int not null default 0,
                     quotaN95m int not null default 0,
                     quotaSm int not null default 0,
                     managerName CHAR(255) not null,

                     constraint repsFK FOREIGN key (managerName)
                         references manager (username)
                         on update cascade
);
create table ordering(
                         orderID bigint primary KEY auto_increment,
                         time datetime not null,
                         customerName CHAR(255) not null,
                         repsName CHAR(255) not null,
                         region char(255) not null,
                         N95 int not null,
                         sm int not null,
                         N95m int not null,
                         sumprice DOUBLE not null,
                         status int not null default 0,

                         constraint ordFKcus FOREIGN key (customerName)
                             references customer (username)
                             on update cascade,

                         constraint ordFKrep FOREIGN key (repsName)
                             references reps (username)
                             on update cascade
);
drop table if exists prices;
create table prices(
                       name char(255) Primary key not null,
                       price double not null
);


INSERT INTO prices (name, price) values ('N95', 19.9);
INSERT INTO prices (name, price) values ('Sm', 9.9);
INSERT INTO prices (name, price) values ('N95m', 29.9);
