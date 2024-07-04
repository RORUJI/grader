CREATE TABLE level (
    levelID INT(3) NOT NULL AUTO_INCREMENT,
    levelname VARCHAR(255) NOT NULL,
    PRIMARY KEY(levelID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO level(levelname) VALUES('Member'), ('Admin');

CREATE TABLE user (
    userid INT(3) NOT NULL AUTO_INCREMENT,
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
    gendername VARCHAR(255) NOT NULL,
    PRIMARY KEY(genderID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO gender(gender) VALUES('Male'), ('Female');

CREATE TABLE manu_category (
    manu_categoryid INT(3) NOT NULL AUTO_INCREMENT,
    manu_category VARCHAR(255) NOT NULL,
    PRIMARY KEY(manu_categoryid)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO manu_category(manu_category) VALUES('Coffee'), ('Tea'), ('Other');

CREATE TABLE manu_type (
    manu_typeid INT(3) NOT NULL AUTO_INCREMENT,
    manu_type VARCHAR(255) NOT NULL,
    PRIMARY KEY(manu_typeid)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO manu_type(manu_type) VALUES('Hot'), ('Cold'), ('Blended');

CREATE TABLE manu (
    manuid INT(3) NOT NULL,
    manuname VARCHAR(255) NOT NULL,
    manu_categoryid INT(3) NOT NULL,
    manu_typeid INT(3) NOT NULL,
    manu_price INT(3) NOT NULL,
    PRIMARY KEY(manuid),
    FOREIGN KEY(manu_categoryid) REFERENCES manu_category(manu_categoryid),
    FOREIGN KEY(manu_typeid) REFERENCES manu_type(manu_typeid)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE person (
    personID INT(3) NOT NULL AUTO_INCREMENT,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    birthday DATE NOT NULL,
    height INT(3) NOT NULL,
    weight INT(3) NOT NULL,
    genderID INT(3) NOT NULL,
    PRIMARY KEY(personID),
    FOREIGN KEY(genderID) REFERENCES gender(genderID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE type (
    typeID INT(3) NOT NULL AUTO_INCREMENT,
    type VARCHAR(255) NOT NULL,
    PRIMARY KEY(typeID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

INSERT INTO type(type) VALUES('SELECT'), ('INSERT'), ('DELETE'), ('UPDATE');

CREATE TABLE quiz (
    quizid INT(3) NOT NULL AUTO_INCREMENT,
    quiz VARCHAR(255) NOT NULL,
    answercode text NOT NULL,
    resultcode text NOT NULL,
    temptablecode text NOT NULL,
    typeID INT(3) NOT NULL,
    PRIMARY KEY(quizID),
    FOREIGN KEY(typeID) REFERENCES type(typeID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE score (
    score INT(3) NOT NULL,
    recordtime DATETIME NOT NULL,
    userid INT (3) NOT NULL,
    quizid INT (3) NOT NULL,
    FOREIGN KEY(userid) REFERENCES user(userid),
    FOREIGN KEY(quizid) REFERENCES quiz(quizid)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;