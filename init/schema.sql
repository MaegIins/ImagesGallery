DROP DATABASE IF EXISTS `Gallery`;
CREATE DATABASE `Gallery`;
USE `Gallery`;

create or replace table Image
(
    id_img int auto_increment
        primary key,
    tag    varchar(255) not null,
    path   varchar(255) not null
)
    collate = utf8mb3_unicode_ci;

create or replace table User
(
    id_user    int auto_increment
        primary key,
    name       varchar(255) not null,
    first_name varchar(255) not null,
    email      varchar(255) not null,
    password   varchar(255) not null
)
    collate = utf8mb3_unicode_ci;

create or replace table Gallery
(
    id_gal        int auto_increment
        primary key,
    user_creator  int          null,
    title         varchar(255) not null,
    date_creation date         not null,
    tag           varchar(255) not null,
    visibility    tinyint(1)   not null,
    constraint FK_889641A6E40BF469
        foreign key (user_creator) references User (id_user)
)
    collate = utf8mb3_unicode_ci;

create or replace index IDX_889641A6E40BF469
    on Gallery (user_creator);

create or replace table ImageToGalery
(
    id_gal int not null,
    id_img int not null,
    primary key (id_gal, id_img),
    constraint FK_26A514B8149F9B78
        foreign key (id_gal) references Gallery (id_gal),
    constraint FK_26A514B8256620F6
        foreign key (id_img) references Image (id_img)
)
    collate = utf8mb3_unicode_ci;

create or replace index IDX_26A514B8149F9B78
    on ImageToGalery (id_gal);

create or replace index IDX_26A514B8256620F6
    on ImageToGalery (id_img);

create or replace table UserToGalery
(
    id_gal  int not null,
    id_user int not null,
    primary key (id_gal, id_user),
    constraint FK_40F7CD63149F9B78
        foreign key (id_gal) references Gallery (id_gal),
    constraint FK_40F7CD636B3CA4B
        foreign key (id_user) references User (id_user)
)
    collate = utf8mb3_unicode_ci;

create or replace index IDX_40F7CD63149F9B78
    on UserToGalery (id_gal);

create or replace index IDX_40F7CD636B3CA4B
    on UserToGalery (id_user);

