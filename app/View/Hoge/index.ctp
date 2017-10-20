hoge


<!--comment mysql-->

use cake_test
create table comments(
id int not null auto_increment primary key,
commenter varchar(255),
body text,
post_id int not null,
created datetime default null,
modified datetime default null
);
insert into comments(commenter,body, post_id, created,modified)
values
("c 1" , "b 1",1,now(),now()),
("c 2" , "b 2",1,now(),now()),
("c 3" , "b 3",1,now(),now());