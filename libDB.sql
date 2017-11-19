drop table eventLog CASCADE CONSTRAINTS;
drop table Orders CASCADE CONSTRAINTS;
drop table StaffEmployment CASCADE CONSTRAINTS;
drop table event CASCADE CONSTRAINTS;
drop table Member CASCADE CONSTRAINTS;
drop table Staff CASCADE CONSTRAINTS;
drop table Location CASCADE CONSTRAINTS;
drop table Media CASCADE CONSTRAINTS;
drop table Book CASCADE CONSTRAINTS;
drop table DVD CASCADE CONSTRAINTS;
drop table Equipment CASCADE CONSTRAINTS;
drop table Room CASCADE CONSTRAINTS;
drop table RoomLog CASCADE CONSTRAINTS;
drop table Distributor cascade constraints;
drop view BookCatalog CASCADE CONSTRAINTS;
drop view DVDCatalog CASCADE CONSTRAINTS;
drop view EquipmentCatalog CASCADE CONSTRAINTS;



CREATE TABLE eventLog(
  logid NUMBER(10) not null,
  eid  NUMBER(10) not null,
  lid  NUMBER (10) not null,
  Primary key(logid)
);

CREATE TABLE Orders(
   orderId NUMBER(10) not null,
   mid NUMBER(10) not null,
   mediaid NUMBER(10) not null,
   PRIMARY KEY( orderId )
);

CREATE TABLE StaffEmployment (
  empId   NUMBER (10) not null,
  mid     NUMBER (10) not null,
  lid     NUMBER (10) not null,
  PRIMARY KEY(empId)
);

CREATE TABLE Distributor (
	dID  Number(10) not null,
	distPhone Number(10) not null,
	distName VARCHAR(10) not null,
	distSpecialty VARCHAR(10) null,
	PRIMARY KEY (dID)
);


CREATE TABLE Member(
   mid NUMBER(10) not null,
   fines NUMBER(10)  null,
   email varchar(20)  null,
   phone NUMBER(10)  null,
   name VARCHAR(20)  null,
   address varchar(20)  null,
   PRIMARY KEY( mid )
);


CREATE TABLE Staff(
  mid    NUMBER(10) not null,
  role   VARCHAR(15) not null,
  Primary Key(mid),
  Foreign key(mid) references Member(mid) on delete cascade
);

CREATE TABLE Location (
  lid NUMBER (10) not null,
  locname varchar(40)  null,
  locaddress varchar(40)  null,
  locphone NUMBER(30)  null,
  Primary Key(lid)
  );
  
  commit;
  
CREATE TABLE Media(
   mediaid NUMBER(10) not null,
   borrowDate Date not null,
   dateAdded Date not null,
   availability varchar(20) not null,
   PRIMARY KEY( mediaid ),
   lid NUMBER (10) not null,
   Foreign Key(lid) references Location(lid) on delete cascade
);

CREATE TABLE Book(
  mediaid NUMBER(10) not null,
  bISBN varchar(20) not null,
  bookTitle VARCHAR(40) not null, 
  PRIMARY KEY(mediaid),
  Foreign key(mediaid) references Media(mediaid) on delete cascade
);

CREATE TABLE DVD(
  mediaid NUMBER(10) not null,
  dISBN varchar(20) not null,
  dvdTitle VARCHAR(40) not null, 
  PRIMARY KEY(mediaid),
  Foreign key(mediaid) references Media(mediaid) on delete cascade
);

CREATE TABLE Equipment(
  mediaid NUMBER(10) not null,
  equipname varchar(40) not null,
  type VARCHAR(20) not null, 
  PRIMARY KEY(mediaid),
  Foreign key(mediaid) references Media(mediaid) on delete cascade
);


CREATE TABLE Room(
	roomNumber NUMBER(20) not null,
	lid NUMBER(20) not null,
	Primary Key(roomNumber, lid),
	Foreign Key(lid) references Location(lid) on delete cascade
);


CREATE TABLE RoomLog(
	logid NUMBER(10) not null,
	lid NUMBER(10) not null,
	roomNumber NUMBER(10) not null,
	PRIMARY Key(logid)
);


CREATE TABLE event(
  eid  NUMBER(10)  not null,
  startTime TIMESTAMP  null,
  endTime TIMESTAMP  null,
  ename VARCHAR(40) not null,
  roomNumber NUMBER(10) not null,
  lid NUMBER(10) not null,
  Primary Key(eid),
  Foreign key(roomNumber, lid) references Room(roomNumber, lid) on delete cascade
  );

commit;


insert into Location(lid, locname, locaddress, locphone) values (1, 'Vancouver Branch', '1234 Van Street', 604134567);
Insert into Location(lid, locname, locaddress, locphone) values (2, 'Burnaby Branch', '1450 Burb Ave', 604444344);
Insert into Location(lid, locname, locaddress, locphone) values (3, 'Richmond Branch', '4444 Richer Ave', 60333122);


insert into Room(roomNumber, lid) values (100, 1);
insert into Room(roomNumber, lid) values (101, 1);
insert into Room(roomNumber, lid) values (102, 1);
insert into Room(roomNumber, lid) values (101, 2);
insert into Room(roomNumber, lid) values (102, 2);
insert into Room(roomNumber, lid) values (100, 3);

insert into event(eid, startTime, endTime, ename, roomNumber, lid) values (100, '2010-11-19 9.00', '2010-11-21 9.00', 'JK Rowling Autographs', 100, 1);
insert into event(eid, startTime, endTime, ename, roomNumber, lid) values (101, '2016-10-19 14.00', '2016-10-19 16.00', 'Free Yoga Lesson', 101, 1);
insert into event(eid, startTime, endTime, ename, roomNumber, lid) values (102, '2016-10-19 10.00', '2016-10-19 11.00', 'BasketWeaving', 102, 2);
insert into event(eid, StartTime, endTime, ename, roomNumber, lid) values (103, '2014-11-19 15.00',  '2014-11-19 19.00', 'Reading Talk', 100, 3);


insert into eventLog(logid, eid, lid) values (100, 100, 1);
insert into eventLog(logid, eid, lid) values (101, 101, 1);
insert into eventLog(logid, eid, lid) values (102, 102, 1);
insert into eventLog(logid, eid, lid) values (103, 103, 2);
 
 
Insert into Member (mid, fines, email, phone, name, address) values (100, 33, 'cust3@com',12412424, 'John','NorthMall2 ave');
Insert Into Member (mid, fines, email, phone, name, address) values (101, 0, 'Ja@son.com', 12345, 'Jason', 'Street1 ave');
Insert Into Member (mid, fines, email, phone, name, address) values (102, 123, 'Ca@rol.com', 43134134, 'Carol', 'Street2 ave');
Insert Into Member (mid, fines, email, phone, name, address) values (103, 33, 'Ra@fael.com', 134134, 'Rafael','Street3 ave');
Insert into Member (mid, fines, email, phone, name, address) values (104, 0, 'He@nry.com', 413143, 'Henry', 'Street4 ave');

Insert into Member (mid, fines, email, phone, name, address) values (105, 123, 'cust1@com', 13414334,'member1','WestMall ave');
Insert into Member (mid, fines, email, phone, name, address) values (106, 0, 'cust2@com', 134134,'member2','EastMall ave');
Insert into Member (mid, fines, email, phone, name, address) values (107, 33, 'cust3@com',12412424, 'member3','NorthMall ave');




Insert Into Staff (mid, role) values (100, 'Custodian');
Insert Into Staff (mid, role) values (101, 'Security');
Insert Into Staff (mid, role) values (102, 'Librarian');
Insert into Staff (mid, role) values (103, 'Custodian');
Insert Into Staff (mid, role) values (104, 'Librarian');


Insert Into StaffEmployment values(1, 101, 1);
Insert Into StaffEmployment values(2, 101, 2);
Insert Into StaffEmployment values(3, 101, 3);
Insert Into StaffEmployment values (4, 102, 2);
Insert Into StaffEmployment values(5, 103, 1);
Insert Into StaffEmployment values(6, 104, 3);


Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (101, '2017-10-14',  '2018-01-01', 'no', '3');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (102, '2011-01-14',  '1990-11-24', 'yes', '2');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (103, '2011-02-14',  '2001-11-14', 'yes', '1');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (104, '2016-03-14',  '1999-11-10', 'yes', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (105, '2016-04-14',  '2011-11-14', 'yes', '1');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (106, '2016-05-14',  '2004-11-24', 'yes', '3');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (107, '2017-10-14',  '2002-11-14', 'no', '3');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (108, '2017-10-10',  '2001-11-14', 'no', '1');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (109, '2017-10-10',  '2001-11-14', 'no', '2');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (110, '2017-10-30',  '2001-11-14', 'no', '2');
Insert Into Media (mediaid , borrowDate , dateAdded, availability, lid) values (111, '2017-10-10',  '2001-11-14', 'no', '2');

Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (112, '2017-10-10',  '2001-11-14', 'yes', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (113, '2017-10-10',  '2001-11-14', 'no', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (114, '2017-10-10',  '2001-11-14', 'no', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (115, '2017-10-10',  '2001-11-14', 'no', '2');


Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (201, '2017-9-01',  '2016-02-01', 'no', '1');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (202, '2017-9-17',  '2016-05-12', 'no', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (203, '2017-9-18',  '2016-03-10', 'no', '3');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (250, '2017-09-15',  '2016-04-24', 'no', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (251, '2017-08-13',  '2016-07-12', 'no', '2');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (252, '2017-10-14',  '2016-01-09', 'yes', '1');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (220, '2017-10-16',  '2016-06-04', 'no', '1');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (221, '2017-10-11',  '2016-08-08', 'no', '3');
Insert Into Media (mediaid , borrowDate, dateAdded, availability, lid) values (222, '2017-10-14',  '2016-09-02', 'yes', '1');



Insert Into DVD (mediaid, dISBN, dvdtitle) values(201, 587634 ,'Frida');
Insert Into DVD (mediaid, dISBN, dvdtitle) values(202, 439852 ,'The Exorcist');
Insert Into DVD (mediaid, dISBN, dvdtitle) values(203, 920756 ,'Titanic');
Insert Into Equipment (mediaid, equipname, type) values(250, 'DVD Player' ,'media player');
Insert Into Equipment (mediaid, equipname, type) values(251, 'SONY PXW-Z90V 4K' ,'camcorder');
Insert Into Equipment (mediaid, equipname, type) values(252, 'Audio-Technica AT2020' ,'microphone');
Insert Into Book (mediaid, bISBN, bookTitle) values(220,597346, 'The Shining');
Insert Into Book (mediaid, bISBN, bookTitle) values(221,387591, 'It');
Insert Into Book (mediaid, bISBN, bookTitle) values(222,687519, 'Carrie');








Insert Into Equipment (mediaid, equipname, type) values(101, 'Laptop1', 'computer');
Insert Into Equipment (mediaid, equipname, type) values(102, 'Laptop3' ,'computer');
Insert Into Equipment (mediaid, equipname, type) values(112, 'projector1' ,'projetor');
Insert Into Equipment (mediaid, equipname, type) values(113, 'projector2' ,'projector');


Insert Into DVD (mediaid, dISBN, dvdtitle) values(103, 124444 ,'Planet earth DVD');
Insert Into DVD (mediaid, dISBN, dvdtitle) values(104, 514444 ,'Rush hour3');
Insert Into DVD (mediaid, dISBN, dvdtitle) values(114, 514444 ,'Harry Potter and Philosophers Hat');
Insert Into DVD (mediaid, dISBN, dvdtitle) values(115, 514444 ,'The Planet of Apes');

Insert Into Book (mediaid, bISBN, bookTitle) values(105, 14444 ,'Fashion today');
Insert Into Book (mediaid, bISBN, bookTitle) values(106, 34444 ,'Intro Computer');
Insert Into Book (mediaid, bISBN, bookTitle) values(107, 231312, 'Building computer');
Insert Into Book (mediaid, bISBN, bookTitle) values(108,213223, 'Harry Potter');
Insert Into Book (mediaid, bISBN, bookTitle) values(109,233213, 'Harry Potter');
Insert Into Book (mediaid, bISBN, bookTitle) values(110,233423, 'computer and society');
Insert Into Book (mediaid, bISBN, bookTitle) values(111,213221, 'Current Issues in Society');
Insert Into Book (mediaid, bISBN, bookTitle) values(112,233213, 'computer system213');




Insert Into Orders (orderId, mid, mediaid) values (100, 101, 101);
Insert Into Orders (orderId, mid, mediaid) values (101, 101, 107);
Insert Into Orders (orderId, mid, mediaid) values (102, 105, 108);
Insert Into Orders (orderId, mid, mediaid) values (103, 102, 110);
Insert Into Orders (orderId, mid, mediaid) values (104, 107, 111);
Insert Into Orders (orderId, mid, mediaid) values (105, 103, 112);

Insert Into Orders (orderId, mid, mediaid) values (106, 103, 201);
Insert Into Orders (orderId, mid, mediaid) values (107, 107, 250);
Insert Into Orders (orderId, mid, mediaid) values (108, 106, 251);
Insert Into Orders (orderId, mid, mediaid) values (109, 102, 201);
Insert Into Orders (orderId, mid, mediaid) values (110, 101, 202);
Insert Into Orders (orderId, mid, mediaid) values (111, 104, 203);




create view BookCatalog(mediaid,booktitle,availability,locname) as
	select B.mediaid,B.booktitle,M.availability,L.locname
	from book B,media M,location L
	where B.mediaid=M.mediaid and L.lid=M.lid;
commit;

create view DVDCatalog(mediaid,dvdtitle,availability,locname) as
	select D.mediaid,D.dvdtitle,M.availability,L.locname
	from DVD D,media M,location L
	where D.mediaid=M.mediaid and L.lid=M.lid;
commit;

create view EquipmentCatalog(mediaid,equipname,availability,locname) as
	select E.mediaid,E.equipname,M.availability,L.locname
	from equipment E,media M,location L
	where E.mediaid=M.mediaid and L.lid=M.lid;
commit;



