DROP DATABASE IF EXISTS `Gallery`;
CREATE DATABASE `Gallery`;
USE `Gallery`;

CREATE TABLE `Image` (
                         `id_img` int(11) NOT NULL AUTO_INCREMENT,
                         `tag` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                         `path` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                         PRIMARY KEY (`id_img`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


-- Gallery.`User` definition

CREATE TABLE `User` (
                        `id_user` int(11) NOT NULL AUTO_INCREMENT,
                        `name` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                        `first_name` varchar(255) COLLATE utf8mb3_unicode_ci DEFAULT NULL,
                        `username` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                        `password` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                        PRIMARY KEY (`id_user`),
                        UNIQUE KEY `UNIQ_2DA17977F85E0677` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


-- Gallery.Gallery definition

CREATE TABLE `Gallery` (
                           `id_gal` int(11) NOT NULL AUTO_INCREMENT,
                           `user_creator` int(11) DEFAULT NULL,
                           `title` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                           `date_creation` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                           `private` tinyint(1) NOT NULL,
                           PRIMARY KEY (`id_gal`),
                           KEY `IDX_889641A6E40BF469` (`user_creator`),
                           CONSTRAINT `FK_889641A6E40BF469` FOREIGN KEY (`user_creator`) REFERENCES `User` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


-- Gallery.UserToGallery definition

CREATE TABLE `UserToGallery` (
                                 `id_gal` int(11) NOT NULL,
                                 `id_user` int(11) NOT NULL,
                                 PRIMARY KEY (`id_gal`,`id_user`),
                                 KEY `IDX_A8B5C28E149F9B78` (`id_gal`),
                                 KEY `IDX_A8B5C28E6B3CA4B` (`id_user`),
                                 CONSTRAINT `FK_A8B5C28E149F9B78` FOREIGN KEY (`id_gal`) REFERENCES `Gallery` (`id_gal`),
                                 CONSTRAINT `FK_A8B5C28E6B3CA4B` FOREIGN KEY (`id_user`) REFERENCES `User` (`id_user`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


-- Gallery.AssignmentImage definition

CREATE TABLE `AssignmentImage` (
                                   `id_gal` int(11) NOT NULL,
                                   `id_img` int(11) NOT NULL,
                                   `date_add` varchar(255) COLLATE utf8mb3_unicode_ci NOT NULL,
                                   PRIMARY KEY (`id_gal`,`id_img`),
                                   KEY `IDX_8A1AA842149F9B78` (`id_gal`),
                                   KEY `IDX_8A1AA842256620F6` (`id_img`),
                                   CONSTRAINT `FK_8A1AA842149F9B78` FOREIGN KEY (`id_gal`) REFERENCES `Gallery` (`id_gal`),
                                   CONSTRAINT `FK_8A1AA842256620F6` FOREIGN KEY (`id_img`) REFERENCES `Image` (`id_img`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


INSERT INTO Gallery.AssignmentImage (id_gal,id_img,date_add) VALUES
                                                                 (16,10,'Monday 14th of November 2022 06:29:18 PM'),
                                                                 (17,11,'Monday 14th of November 2022 06:30:02 PM'),
                                                                 (18,12,'Monday 14th of November 2022 06:30:42 PM');
INSERT INTO Gallery.Gallery (user_creator,title,date_creation,private) VALUES
                                                                           (8,'testGallery','Monday 14th of November 2022 06:29:18 PM',0),
                                                                           (8,'testGalleryPrivate','Monday 14th of November 2022 06:30:02 PM',1),
                                                                           (8,'testGalleryPrivate','Monday 14th of November 2022 06:30:42 PM',1);
INSERT INTO Gallery.Image (tag,`path`) VALUES
                                           ('test','/public/data/img/619maquette2.png'),
                                           ('aaaa','/public/data/img/71maquette2.png'),
                                           ('testencore','/public/data/img/1029maquette2.png');
INSERT INTO Gallery.`User` (name,first_name,username,password) VALUES
                                                                   ('root','root','root','$2y$10$5fL3Tpsx9/GBX5dpQqPICunyaX9AquuuKpZ2ggLtWiGnG9sypIFhy'),
                                                                   ('test','test','test','$2y$10$T/GnIoOHxyvBkHLqewIXT.5inEpRmVHvFfhVCV0T1JDqLMXYANqve');
INSERT INTO Gallery.UserToGallery (id_gal,id_user) VALUES
    (18,7);




















