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
('Winter', 'SoCold', '1981-01-02', '59.88', '186.99', 1);

CREATE TABLE question (
    questionID INT(3) NOT NULL AUTO_INCREMENT,
    question VARCHAR(255) NOT NULL,
    code VARCHAR(255) NOT NULL,
    PRIMARY KEY(questionID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO question(question, code) VALUES('จงเรียกข้อมูลทั้งหมดจากตาราง person', "SELECT * FROM person"),
('จงเรียกข้อมูลเฉพาะ firstname และ lastname ทั้งหมดจากตาราง person', "SELECT firstname, lastname FROM person"),
('จงเรียกข้อมูลจากตาราง person จำนวน 2 แถว', "SELECT * FROM person LIMIT 2"),
('จงเรียกข้อมูลที่มี firstname เป็น Nitipat จากตาราง person', "SELECT * FROM person WHERE firstname = 'Nitipat'"),
('จงเรียกข้อมูลทั้งหมดจากตาราง gender', "SELECT * FROM gender");

CREATE TABLE score (
    scoreID INT(3) NOT NULL AUTO_INCREMENT,
    score INT(1) NOT NULL,
    userID INT(3) NOT NULL,
    questionID INT(3) NOT NULL,
    PRIMARY KEY(scoreID),
    FOREIGN KEY(userID) REFERENCES user(userID),
    FOREIGN KEY(questionID) REFERENCES question(questionID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;