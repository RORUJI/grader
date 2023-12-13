CREATE TABLE level (
    levelID INT(3) NOT NULL AUTO_INCREMENT,
    levelname VARCHAR(255) NOT NULL,
    PRIMARY KEY(levelID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO level(levelname) VALUES('Member'), ('Admin');

CREATE TABLE user (
    userID INT(3) NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    tel VARCHAR(10) NOT NULL,
    levelID INT(3) NOT NULL,
    PRIMARY KEY(userID),
    FOREIGN KEY(levelID) REFERENCES level(levelID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE gender (
    genderID INT(3) NOT NULL AUTO_INCREMENT,
    gender VARCHAR(255) NOT NULL,
    PRIMARY KEY(genderID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO gender(gender) VALUES('Male'), ('Female');

CREATE TABLE person (
    personID INT(3) NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    weight DECIMAL(5, 2) NOT NULL,
    height DECIMAL(5, 2) NOT NULL,
    genderID INT(3) NOT NULL,
    PRIMARY KEY(personID),
    FOREIGN KEY(genderID) REFERENCES gender(genderID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO person(firstname, lastname, birthday, weight, height, genderID) VALUES
('Nitipat', 'Jirapong', '2003-02-14', '52.21', '177.77', 1),
('Unknown', 'Personal', '1997-11-12', '69.14', '181.21', 2),
('Exam', 'Final', '2001-01-05', '100.01', '187.14', 1),
('Security', 'Guard', '1994-08-25', '70.54', '185.64', 1),
('Tele', 'Vision', '1985-01-12', '50.18', '157.25', 2),
('Smart', 'Phone', '1989-02-15', '49.55', '154.60', 2),
('Local', 'Host', '1999-05-29', '58.88', '174.95', 1),
('Spring', 'Bounce', '2000-05-05', '59.61', '178.12', 1),
('Summer', 'ItBurning', '2004-04-19', '48.47', '153.69', 2),
('Fall', 'Down', '1989-11-11', '45.54', '158.32', 2),
('Winter', 'SoCold', '1981-01-02', '59.88', '186.99', 1),
('Happy', 'Newclear', '2000-05-05', '61.54', '169.99', 1),
('I-AM', 'Batman', '1990-12-07', '66.99', '159.00', 1);

CREATE TABLE type (
    typeID INT(3) NOT NULL AUTO_INCREMENT,
    type VARCHAR(255) NOT NULL,
    PRIMARY KEY(typeID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO type(type) VALUES('SELECT'), ('INSERT'), ('DELETE');

CREATE TABLE question (
    questionID INT(3) NOT NULL AUTO_INCREMENT,
    question VARCHAR(255) NOT NULL,
    select_code VARCHAR(255) NOT NULL,
    insert_code VARCHAR(255),
    delete_code VARCHAR(255),
    typeID INT(3) NOT NULL,
    PRIMARY KEY(questionID),
    FOREIGN KEY(typeID) REFERENCES type(typeID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO question(question, select_code, typeID) VALUES('จงเรียกข้อมูลทั้งหมดจากตาราง person', "SELECT * FROM person", 1),
('จงเรียกข้อมูลเฉพาะ firstname และ lastname ทั้งหมดจากตาราง person', "SELECT firstname, lastname FROM person", 1),
('จงเรียกข้อมูลจากตาราง person จำนวน 2 แถว', "SELECT * FROM person LIMIT 2", 1),
('จงเรียกข้อมูลที่มี firstname เป็น Nitipat จากตาราง person', "SELECT * FROM person WHERE firstname = 'Nitipat'", 1),
('จงเรียกข้อมูลทั้งหมดจากตาราง gender', "SELECT * FROM gender", 1),
('จงเรียกข้อมูลที่ที gender เป็น Female จากตาราง gender', "SELECT * FROM gender WHERE gender = 'Female'", 1),
('จงเรียกข้อมูลทั้งหมดจากตาราง person โดยเรียงจาก personID มากไปน้อย', "SELECT * FROM person ORDER BY personID DESC", 1),
('จงเรียกข้อมูลเฉพาะ firstname กับ genderID ที่ genderID = 2 จากตาราง person', "SELECT firstname, genderID FROM person WHERE genderID = 2", 1),
('จงเรียกข้อมูลในตาราง person ยกเว้น genderID ที่ genderID = 1', "SELECT personID, firstname, lastname, birthday, weight, height FROM person WHERE genderID = 1",1 ),
('จงเรียกข้อมูลในตาราง person ทั้งหมดที่ weight มากกว่า 60 และ height มากกว่า 170', "SELECT * FROM person WHERE weight > 60 AND height > 170", 1),
('จงเรียกข้อมูลในตาราง person ทั้งหมดที่ weight น้อยกว่า 60 หรือ height มากกว่า 185', 'SELECT * FROM person WHERE weight < 60 OR height > 185', 1),
('จงเรียกข้อมูลในตาราง person ทั้งหมดที่ weight มากกว่า 60 และ genderID = 2', 'SELECT * FROM person WHERE weight > 60 AND genderID = 2', 1),
('จงเรียกข้อมูล firstname และ lastname ที่ personID น้อกกว่าหรือเท่ากับ 5', 'SELECT firstname, lastname FROM person WHERE personID <= 5', 1),
('จงเรียกข้อมูล firstname, lastname และ birthday ที่มี weight มากกว่า 48 และ height น้อยกว่า 180 จากตาราง person โดยเรียงจาก firstname มากไปน้อยจำนวน 5 ข้อมูล', 
"SELECT firstname, lastname, birthday FROM person WHERE weight > 48 AND height < 180 ORDER BY firstname DESC LIMIT 5", 1),
('จงเรียกข้อมูล firstname, lastname, weight, height ที่ genderID = 1 จากตาราง person โดยเรียง weight จากน้อยไปมาก', 
'SELECT firstname, lastname, weight, height FROM person WHERE genderID = 1 ORDER BY weight ASC', 1);

INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES
('จงเพิ่มข้อมูล firstname, lastname, brithday, weight, height, genderID ตามนี้ firstname = Mytester, lastname = Enjoying, birthday = 2001-12-13, weight = 52.54, height = 158.44, genderID = 2 ลงในตาราง person',
"SELECT * FROM person WHERE firstname = 'Mytester' AND lastname = 'Enjoying' AND birthday = '2001-12-13' AND weight = '52.54' AND height = '158.44' AND genderID = '2'",
"INSERT INTO person(firstname, lastname, birthday, weight, height, genderID) VALUES('Mytester', 'Enjoying', '2001-12-13', '52.54', '158.44', '2')",
"DELETE FROM person WHERE firstname = 'Mytester' AND lastname = 'Enjoying' AND birthday = '2001-12-13' AND weight = '52.54' AND height = '158.44' AND genderID = '2'",
2);

INSERT INTO question(question, select_code, insert_code, delete_code, typeID) VALUES
('จงลบข้อมูล firstname, lastname, brithday, weight, height, genderID ตามนี้ firstname = Mytester, lastname = Enjoying, birthday = 2001-12-13, weight = 52.54, height = 158.44, genderID = 2 ลงในตาราง person',
"SELECT * FROM person WHERE firstname = 'Mytester' AND lastname = 'Enjoying' AND birthday = '2001-12-13' AND weight = '52.54' AND height = '158.44' AND genderID = '2'",
"INSERT INTO person(firstname, lastname, birthday, weight, height, genderID) VALUES('Mytester', 'Enjoying', '2001-12-13', '52.54', '158.44', '2')",
"DELETE FROM person WHERE firstname = 'Mytester' AND lastname = 'Enjoying' AND birthday = '2001-12-13' AND weight = '52.54' AND height = '158.44' AND genderID = '2'",
3);


CREATE TABLE score (
    scoreID INT(3) NOT NULL AUTO_INCREMENT,
    score INT(1) NOT NULL,
    userID INT(3) NOT NULL,
    questionID INT(3) NOT NULL,
    PRIMARY KEY(scoreID),
    FOREIGN KEY(userID) REFERENCES user(userID),
    FOREIGN KEY(questionID) REFERENCES question(questionID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;