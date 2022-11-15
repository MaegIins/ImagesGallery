
USE `Gallery`;

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
