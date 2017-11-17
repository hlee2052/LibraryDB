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

CREATE TABLE event (
  eid  NUMBER(10)  not null,
  startTime TIMESTAMP  null,
  endTime TIMESTAMP  null,
  ename VARCHAR(40)  null,
  Primary Key(eid)
  );

CREATE TABLE Member(
   mid NUMBER(10) not null,
   fines NUMBER(10) not null,
   email varchar(20) not null,
   phone NUMBER(10) not null,
   name VARCHAR(20) not null,
   address varchar(20) not null,
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
  locname varchar(40) not null,
  locaddress varchar(40) not null,
  locphone NUMBER(30) not null,
  Primary Key(lid)
  );
  
  commit;
  
CREATE TABLE Media(
   mediaid NUMBER(10) not null,
   returnDate Date not null,
   borrowDate Date not null,
   reserved varchar(20) not null,
   dateAdded Date not null,
   availability varchar(20) not null,
   PRIMARY KEY( mediaid )
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


commit;





insert into event(eid, startTime, endTime, ename) values (100, '2010-11-19 9.00', '2010-11-21 9.00', 'JK Rowling Autographs');
insert into event(eid, startTime, endTime, ename) values (101, '2016-10-19 14.00', '2016-10-19 16.00', 'Free Yoga Lesson');
insert into event(eid, startTime, endTime, ename) values (102, '2016-10-19 10.00', '2016-10-19 11.00', 'BasketWeaving');
insert into event(eid, StartTime, endTime, ename) values (103, '2014-11-19 15.00',  '2014-11-19 19.00', 'Reading Talk');




insert into Location(lid, locname, locaddress, locphone) values (1, 'Vancouver Branch', '1234 Van Street', 604134567);
Insert into Location(lid, locname, locaddress, locphone) values (2, 'Burnaby Branch', '1450 Burb Ave', 604444344);
Insert into Location(lid, locname, locaddress, locphone) values (3, 'Richmond Branch', '4444 Richer Ave', 60333122);


insert into Room(roomNumber, lid) values (100, 1);
insert into Room(roomNumber, lid) values (101, 1);
insert into Room(roomNumber, lid) values (102, 1);
insert into Room(roomNumber, lid) values (101, 2);
insert into Room(roomNumber, lid) values (102, 2);
insert into Room(roomNumber, lid) values (100, 3);



insert into eventLog(logid, eid, lid) values (100, 100, 1);
insert into eventLog(logid, eid, lid) values (101, 101, 1);
insert into eventLog(logid, eid, lid) values (102, 102, 1);
insert into eventLog(logid, eid, lid) values (103, 103, 2);





    
Insert Into Member (mid, fines, email, phone, name, address) values (101, 0, 'Ja@son.com', 12345, 'Jason', '3333 ave');
Insert Into Member (mid, fines, email, phone, name, address) values (102, 123, 'Ca@rol.com', 43134134, 'Carol', '3333 ave');
Insert Into Member (mid, fines, email, phone, name, address) values (103, 33, 'Ra@fael.com', 134134, 'Rafael','3333 ave');
Insert into Member (mid, fines, email, phone, name, address) values (104, 0, 'He@nry.com', 413143, 'Henry', '3333 ave');

Insert into Member (mid, fines, email, phone, name, address) values (105, 123, 'cust1@com', 13414334,'generic1','3333 ave');
Insert into Member (mid, fines, email, phone, name, address) values (106, 0, 'cust2@com', 134134,'generic2','3333 ave');
Insert into Member (mid, fines, email, phone, name, address) values (107, 33, 'cust3@com',12412424, 'generic3','3333 ave');



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





Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (101, '2008-11-19' , '2017-10-14', 'no', '2018-01-01', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (102, '2011-02-19' , '2011-01-14', 'no', '1990-11-24', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (103, '2011-03-19' , '2011-02-14', 'no', '2001-11-14', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (104, '2016-04-19' , '2016-03-14', 'no', '1999-11-10', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (105, '2016-05-19' , '2016-04-14', 'no', '2011-11-14', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (106, '2016-06-19' , '2016-05-14', 'no', '2004-11-24', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (107, '2017-12-11' , '2017-10-14', 'yes', '2002-11-14', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (108, '2017-12-19' , '2017-10-10', 'yes', '2001-11-14', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (109, '2017-12-19' , '2017-10-10', 'yes', '2001-11-14', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (110, '2017-12-19' , '2017-10-10', 'yes', '2001-11-14', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (111, '2017-12-19' , '2017-10-10', 'yes', '2001-11-14', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) values (112, '2017-12-19' , '2017-10-10', 'yes', '2001-11-14', 'no');



Insert Into Equipment (mediaid, equipname, type) values(101, 'Laptop1', 'computer');
Insert Into Equipment (mediaid, equipname, type) values(102, 'Laptop3' ,'computer');

Insert Into DVD (mediaid, dISBN, dvdTitle) values(103, 124444 ,'planet earth dvd');
Insert Into DVD (mediaid, dISBN, dvdTitle) values(104, 514444 ,'rush hour3');

Insert Into Book (mediaid, bISBN, bookTitle) values(105, 14444 ,'Fashion today');
Insert Into Book (mediaid, bISBN, bookTitle) values(106, 3444 ,'Intro Computer');
Insert Into Book (mediaid, bISBN, bookTitle) values(107, 2312, 'Building computer');
Insert Into Book (mediaid, bISBN, bookTitle) values(108,23223, 'Harry Potter');
Insert Into Book (mediaid, bISBN, bookTitle) values(109,2332, 'Harry Potter');
Insert Into Book (mediaid, bISBN, bookTitle) values(110,2723, 'Harry Potter');
Insert Into DVD (mediaid, dISBN, dvdTitle) values(111,2333, 'tester');


commit;


Insert Into Orders (orderId, mid, mediaid) values (100, 101, 101);
Insert Into Orders (orderId, mid, mediaid) values (101, 101, 107);
Insert Into Orders (orderId, mid, mediaid) values (102, 105, 108);

commit;


