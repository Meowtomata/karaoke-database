CREATE DATABASE karaokeDatabase;

USE karaokeDatabase;

CREATE TABLE users (
	userID VARCHAR(30) PRIMARY KEY,
);


CREATE TABLE Song (
	songID INT AUTO_INCREMENT PRIMARY KEY,
	songTitle VARCHAR(30) NOT NULL,
);

CREATE TABLE KaraokeFiles (
	fileID INT AUTO_INCREMENT PRIMARY KEY,
	songID INT,
	version VARCHAR(5) DEFAULT 'SOLO',
	FOREIGN KEY (songID) REFERENCES Song(SongID)
);


CREATE TABLE Role (
	roleID INT,
	songID INT,
	type VARCHAR(20),
);

CREATE TABLE contributor (
	contributorName VARCHAR(20) PRIMARY KEY DEFAULT 'Han Solo'
);

CREATE TABLE songData (
	songID INT,
	type VARCHAR(20),
	contributorName VARCHAR(20),
	PRIMARY KEY ( songID,type, contributorName),
	FOREIGN KEY (songID) REFERENCES Song(SongID),
	FOREIGN KEY (type) REFERENCES Role(roleID),
	FOREIGN KEY (contributorName) REFERENCES contributor(contributorName)
);




CREATE TABLE group (
	contributorName VARCHAR(20),
	groupName VARCHAR(20),
	PRIMARY KEY(contributorName, groupName),
	FOREIGN KEY (contributorName) REFERENCES contributor(contributorName)
);


CREATE TABLE queue (
	QueueID INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE priorityQueue (
	QueueID INT,
	Payment INT,
	PRIMARY KEY ( QueueID,Payment),
	FOREIGN KEY (QueueID) REFERENCES queue(QueueID)
	
);


CREATE TABLE queueInfo (
	QueueID INT,
	SongID INT,
	userID VARCHAR(30),
	timeStamp time,
	PRIMARY KEY (QueueID, SongID, userID)
	FOREIGN KEY (SongID) REFERENCES Song(SongID)
	FOREIGN KEY (userID) REFERENCES users(userID)
);

