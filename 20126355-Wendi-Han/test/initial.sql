INSERT INTO customer (username,password,realname,passport,tel,email,region) values('CHINAboy','85bf25001ea9d1c256983a951be449a7330cce1aabefd374d67cad2aa00aaf54','jack','1111111','123-4567-8910','aaa@aaa.aaa','China');
INSERT INTO customer (username,password,realname,passport,tel,email,region) values('william','d0784c6b1785dcd474688d46b1fe99792ff66f6b56bebf26dda0c08516bac22e','William','2222222','123-4567-8911','bbb@bbb.bbb','China');
INSERT INTO customer (username,password,realname,passport,tel,email,region) values('goodnight','55f444d50e5af6bd1ff2c737ab09b613b77be2dc00dc2f330f23d9dc02291517','Paul','3333333','123-4567-8912','ccc@ccc.ccc','United States');

INSERT INTO manager (username,password,realname,passport,tel,email,region) values ('admin','8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918','admin','admin','111','111','china');
INSERT INTO manager (username,password,realname,passport,tel,email,region) values('manCHINA','8d971acc1f30515307abea2ced00c4a4d43d88466392221292a3f29261d61a80','Tom','6666666','123-4567-8915','fff@fff.fff','China');
INSERT INTO manager (username,password,realname,passport,tel,email,region) values('manCHINA2','0334b83f5c234b3a1709c41d86f7b7628cb66761b3f252c0f589792c0818a80f','Bob','7777777','123-4567-8916','ggg@ggg.ggg','United States');


INSERT INTO reps (ID, username,password,realname,passport,tel,email,region,quotaN95,quotaN95m,quotaSm, managerName) values(20200526,'repsCHINA','a12be54200ea14f082529d7d39ba0805bc6fd3dc6a094e6e7e4e4ad2dfb12a74','Richard','4444444','123-4567-8913','ddd@ddd.ddd','China',10,10,10, 'manCHINA');
INSERT INTO reps (ID, username,password,realname,passport,tel,email,region,quotaN95,quotaN95m,quotaSm, managerName) values(20200526,'repsCHINA2','abf7e4010787936fd56c509732b539e8da6850564c4ea26cfed0896960441df4','Wendy','5555555','123-4567-8914','eee@eee.eee','United States',10,-5,10, 'manCHINA');
INSERT INTO reps (ID, username,password,realname,passport,tel,email,region,quotaN95,quotaN95m,quotaSm, managerName) values(20200526,'repsCHINA3','46d459a8857569e0e792fdbe92763f1315cbd3e1ae171694975867379d1109ed','lamb','7777777','123-4567-8916','ggg@ggg.ggg','China',10,10,10, 'manCHINA');


INSERT INTO ordering (orderID,time,customerName,repsName,region,N95,Sm,N95m,sumprice,status) value ('1','2020-05-11 00:00:00','CHINAboy','repsCHINA','China','1','1','1','59.7','0');
INSERT INTO ordering (orderID,time,customerName,repsName,region,N95,Sm,N95m,sumprice,status) value ('2','2020-05-23 22:00:00','goodnight','repsCHINA2','United States','1','1','1','59.7','0');
INSERT INTO ordering (orderID,time,customerName,repsName,region,N95,Sm,N95m,sumprice,status) value ('3','2020-05-11 00:00:00','CHINAboy','repsCHINA','China','1','1','1','59.7','2');
INSERT INTO ordering (orderID,time,customerName,repsName,region,N95,Sm,N95m,sumprice,status) value ('4','2020-05-11 00:00:00','CHINAboy','repsCHINA3','China','1','1','1','59.7','0');
INSERT INTO ordering (orderID,time,customerName,repsName,region,N95,Sm,N95m,sumprice,status) value ('5','2020-05-11 00:00:00','CHINAboy','repsCHINA3','China','1','1','1','59.7','1');
