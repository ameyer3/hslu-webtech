create database reviews;
use reviews;
create table reviews (
    id int NOT NULL,
    title varchar(100) NOT NULL,
    content varchar(500) NOT NULL,
    room varchar(50) NOT NULL, 
    recommend bit(1) NOT NULL,
    creation_date date NOT NULL);

ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `reviews`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;