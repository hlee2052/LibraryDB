CREATE TABLE eventLog(
  logid Integer(10),
  eid  Integer(10),
  lid  Integer (10),
  Primary key(logid)
);

CREATE TABLE Orders(
   orderId Integer(10),
   mid Integer(10),
   mediaid Integer(10),
   PRIMARY KEY( orderId )
);

CREATE TABLE StaffEmployment (
  empId   Integer (10),
  mid     Integer (10),
  lid     Integer (10),
  PRIMARY KEY(empId)
);

CREATE TABLE event (
  eid  Integer(10),
  startTime DateTime,
  endTime DateTime,
  ename VARCHAR(40),
  Primary Key(eid)
  );

CREATE TABLE Member(
   mid Integer(10),
   fines Integer(10),
   email varchar(20),
   phone Integer(10),
   name VARCHAR(20),
   address varchar(20),
   PRIMARY KEY( mid )
);


CREATE TABLE Staff(
  mid    Integer(10),
  role   VARCHAR(15),
  Primary Key(mid),
  Foreign key(mid) references Member(mid) on delete cascade
);

CREATE TABLE Location (
  lid Integer (10),
  locname varchar(40),
  locaddress varchar(40),
  locphone Integer(30),
  Primary Key(lid)
  );
  
CREATE TABLE Media(
   mediaid Integer(10),
   returnDate Date,
   borrowDate Date,
   reserved varchar(20),
   dateAdded Date,
   availability varchar(20),
   PRIMARY KEY( mediaid )
);

CREATE TABLE Book(
  mediaid Integer(10),
  bISBN varchar(20),
  bookTitle VARCHAR(40), 
  PRIMARY KEY(mediaid),
  Foreign key(mediaid) references Media(mediaid) on delete cascade
);

CREATE TABLE DVD(
  mediaid Integer(10),
  dISBN varchar(20),
  dvdTitle VARCHAR(40), 
  PRIMARY KEY(mediaid),
  Foreign key(mediaid) references Media(mediaid) on delete cascade
);

CREATE TABLE Equipment(
  mediaid Integer(10),
  equipname varchar(40),
  type VARCHAR(20), 
  PRIMARY KEY(mediaid),
  Foreign key(mediaid) references Media(mediaid) on delete cascade
);


CREATE TABLE Room(
	roomNumber Integer(20),
	lid Integer(20),
	Primary Key(roomNumber, lid),
	Foreign Key(lid) references Location(lid)
	

);


CREATE TABLE RoomLog(
	logid Integer(10),
	lid Integer(10),
	roomNumber Integer(10),
	PRIMARY Key(logid)
);



insert into event(eid, startTime, endTime, ename) value (100, '2010-11-19 9:00', '2010-11-21 9:00', 'JK Rowling Autographs');
insert into event(eid, startTime, endTime, ename) value (101, '2016-10-19 14:00', '2016-10-19 16:00', 'Free Yoga Lesson');
insert into event(eid, startTime, endTime, ename) value (102, '2016-10-19 10:00', '2016-10-19 11:00', 'BasketWeaving');
insert into event(eid, StartTime, endTime, ename) value (103, '2014-11-19 15:00',  '2014-11-19 19:00', 'Reading Talk');


insert into Location(lid, locname, locaddress, locphone) Value (1, 'Vancouver Branch', '1234 Van Street', 604134567);
Insert into Location(lid, locname, locaddress, locphone) value (2, 'Burnaby Branch', '1450 Burb Ave', 604444344);
Insert into Location(lid, locname, locaddress, locphone) value (3, 'Richmond Branch', '4444 Richer Ave', 60333122);


insert into eventLog(logid, eid, lid) value (100, 100, 1);
insert into eventLog(logid, eid, lid) value (101, 101, 1);
insert into eventLog(logid, eid, lid) value (102, 102, 1);
insert into eventLog(logid, eid, lid) value (103, 103, 2);




    
Insert Into Member (mid, fines, email, phone, name, address) Value (101, 0, 'Ja@son.com', 12345, 'Jason', '');
Insert Into Member (mid, fines, email, phone, name, address) Value (102, 123, 'Ca@rol.com', 43134134, 'Carol', '');
Insert Into Member (mid, fines, email, phone, name, address) Value (103, 33, 'Ra@fael.com', 134134, 'Rafael','');
Insert into Member (mid, fines, email, phone, name, address) value (104, 0, 'He@nry.com', 413143, 'Henry', '');

Insert into Member (mid, fines, email, phone, name, address) value (105, 123, 'cust1@com', 13414334,'generic1','');
Insert into Member (mid, fines, email, phone, name, address) value (106, 0, 'cust2@com', 134134,'generic2','');
Insert into Member (mid, fines, email, phone, name, address) value (107, 33, 'cust3@com',12412424, 'generic3','');


Insert Into Staff (mid, role) Value (101, 'Security');
Insert Into Staff (mid, role) Value (102, 'Librarian');
Insert into Staff (mid, role) Value (103, 'Custodian');




Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (101, '2008-11-19' , '2017-10-14', 'no', '2018-01-01', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (102, '2011-02-19' , '2011-01-14', 'no', '1990-11-24', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (103, '2011-03-19' , '2011-02-14', 'no', '2001-11-14', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (104, '2016-04-19' , '2016-03-14', 'no', '1999-11-10', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (105, '2016-05-19' , '2016-04-14', 'no', '2011-11-14', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (106, '2016-06-19' , '2016-05-14', 'no', '2004-11-24', 'yes');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (107, '2017-12-11' , '2017-10-14', 'yes', '2002-11-14', 'no');
Insert Into Media (mediaid, returnDate, borrowDate, reserved, dateAdded, availability) Value (108, '2017-12-19' , '2017-10-10', 'yes', '2001-11-14', 'no');





Insert Into Equipment (mediaid, equipname, type) Value(101, 'Laptop1', 'computer');
Insert Into Equipment (mediaid, equipname, type) Value(102, 'Laptop3' ,'computer');

Insert Into DVD (mediaid, dISBN, dvdTitle) Value(103, 124444 ,'planet earth dvd');
Insert Into DVD (mediaid, dISBN, dvdTitle) Value(104, 514444 ,'rush hour3');

Insert Into Book (mediaid, bISBN, bookTitle) Value(105, 14444 ,'Fashion today');
Insert Into Book (mediaid, bISBN, bookTitle) Value(106, 34444 ,'Intro Computer');
Insert Into Book (mediaid, bISBN, bookTitle) Value(107, 231312, 'Building computer');
Insert Into Book (mediaid, bISBN, bookTitle) Value(108,233223, 'Harry Potter');




Insert Into Orders (orderId, mid, mediaid) Value (100, 101, 101);
Insert Into Orders (orderId, mid, mediaid) Value (101, 101, 107);
Insert Into Orders (orderId, mid, mediaid) Value (102, 105, 108);




