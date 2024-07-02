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
    scoreID INT(3) NOT NULL AUTO_INCREMENT,
    score INT(1) NOT NULL,
    userID INT(3) NOT NULL,
    questionID INT(3) NOT NULL,
    PRIMARY KEY(scoreID),
    FOREIGN KEY(userID) REFERENCES user(userID),
    FOREIGN KEY(questionID) REFERENCES question(questionID)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;