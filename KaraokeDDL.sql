


CREATE TABLE users (
    userID VARCHAR(30) PRIMARY KEY
);

CREATE TABLE Song (
    songID INT AUTO_INCREMENT PRIMARY KEY,
    songTitle VARCHAR(30) NOT NULL
);

CREATE TABLE KaraokeFiles (
    fileID INT AUTO_INCREMENT PRIMARY KEY,
    songID INT,
    version VARCHAR(5) DEFAULT 'SOLO',
    FOREIGN KEY (songID) REFERENCES Song(songID)
);

CREATE TABLE Role (
    roleID INT PRIMARY KEY,
    songID INT,
    roleType VARCHAR(20),
    FOREIGN KEY (songID) REFERENCES Song(songID)
);

CREATE TABLE contributor (
    contributorName VARCHAR(20) PRIMARY KEY
);

CREATE TABLE songData (
    songID INT,
    roleType VARCHAR(20),
    contributorName VARCHAR(20),
    PRIMARY KEY (songID, roleType, contributorName),
    FOREIGN KEY (songID) REFERENCES Song(songID),
    FOREIGN KEY (roleType) REFERENCES Role(roleType),
    FOREIGN KEY (contributorName) REFERENCES contributor(contributorName)
);

CREATE TABLE groups (
    contributorName VARCHAR(20),
    groupName VARCHAR(20),
    PRIMARY KEY(contributorName, groupName),
    FOREIGN KEY (contributorName) REFERENCES contributor(contributorName),
    FOREIGN KEY (groupName) REFERENCES contributor(contributorName)
);

CREATE TABLE queue (
    QueueID INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE priorityQueue (
    QueueID INT,
    Payment INT,
    PRIMARY KEY (QueueID, Payment),
    FOREIGN KEY (QueueID) REFERENCES queue(QueueID)
);

CREATE TABLE queueInfo (
    QueueID INT,
    songID INT,
    userID VARCHAR(30),
    timeStamp DATETIME,
    PRIMARY KEY (QueueID, songID, userID),
    FOREIGN KEY (songID) REFERENCES Song(songID),
    FOREIGN KEY (userID) REFERENCES users(userID)
);
