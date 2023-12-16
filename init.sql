CREATE DATABASE IF NOT EXISTS autobase2;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT, UPDATE, DELETE, INSERT ON autobase2.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE autobase2;
create table clients 
(
id_client int (10) AUTO_INCREMENT,
address text NOT NULL,
number int (10) NOT NULL,
name text NOT NULL,
documents int (10) NOT NULL,
car_rights int (10) NOT NULL,
PRIMARY KEY (id_client)
);

create table ArendCar (
id_arend_c int (10) AUTO_INCREMENT,
marka varchar (20) NOT NULL,
time_arend int (10),
price_arend int (5) NOT NULL,
PRIMARY KEY (id_arend_c)
);

create table Parking (
id_parking int (10) AUTO_INCREMENT,
numb_parking varchar (3) NOT NULL,
status_p boolean NOT NULL,
PRIMARY KEY (id_parking)
);

create table Ticket (
id_ticket int (10) AUTO_INCREMENT,
id_client_t  int (10) NOT NULL,
id_car_t  int (10) NOT NULL,
id_parking_t  int (10) NOT NULL,
price int NOT NULL,
PRIMARY KEY (id_ticket),
FOREIGN KEY (id_client_t) REFERENCES clients (id_client),
FOREIGN KEY (id_car_t) REFERENCES ArendCar (id_arend_c),
FOREIGN KEY (id_parking_t) REFERENCES Parking (id_parking)
);

INSERT INTO clients (address, number, name, documents, car_rights) VALUES (
'Moscow', '8985', 'AAA',  '1234', '1111');
INSERT INTO clients (address, number, name, documents, car_rights) VALUES (
'Moscow', '8984', 'BBB',  '5678', '2222');
INSERT INTO clients (address, number, name, documents, car_rights) VALUES (
'Moscow', '8983', 'CCC',  '9012', '3333');

INSERT INTO ArendCar (marka, time_arend, price_arend) VALUES (
'BMV', '12', '15000');
INSERT INTO ArendCar (marka, price_arend) VALUES (
'LADA', '25000');

INSERT INTO Parking (numb_parking, status_p) VALUES (
'A01', '0');
INSERT INTO Parking (numb_parking, status_p) VALUES (
'A02', '1');

CREATE DATABASE IF NOT EXISTS api_db;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT, UPDATE, DELETE, INSERT ON api_db.* TO 'user'@'%';
FLUSH PRIVILEGES;

USE api_db;

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(256) NOT NULL,
  `lastname` varchar(256) NOT NULL,
  `email` varchar(256) NOT NULL,
   `role` int(3) NOT NULL,
  `password` varchar(2048) NOT NULL,
  `corp_password` varchar(2048),
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);
  
  ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;COMMIT;
  
  
CREATE DATABASE IF NOT EXISTS corp;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT, UPDATE, DELETE, INSERT ON corp.* TO 'user'@'%';
FLUSH PRIVILEGES;

use corp;

  CREATE TABLE `corp_password` (
  `id` int(2) NOT NULL AUTO_INCREMENT,
  `password` varchar(2048) NOT NULL,
   PRIMARY KEY (`id`)
) ;
  
  INSERT INTO corp_password (password) VALUES (
'qwe123r');
INSERT INTO corp_password (password) VALUES (
'zxc123v');