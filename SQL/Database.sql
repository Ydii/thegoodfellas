CREATE TABLE FORUMTITLE (
    ID NUMBER,
    TITLE VARCHAR2,
    ACCESSRIGHTS VARCHAR2,
    PRIMARY KEY (ID)
);

CREATE TABLE FORUMSUBTITLE (
    ID NUMBER,
    SUBTITLE VARCHAR2,
    PRIMARY KEY (ID)
);

CREATE TABLE POSTMESSAGE (
    ID NUMBER,
    MESSAGE VARCHAR2,
    USERNAME VARCHAR2,
    CREATIONTIME TIME,
    PRIMARY KEY (ID)
);

CREATE TABLE USERS (
    ID NUMBER,
    USERNAME VARCHAR2,
    PASSWORD VARCHAR2
    CLASSNAME VARCHAR2,
    CREATIONDATE DATE,
    PRIMARY KEY (ID)
);