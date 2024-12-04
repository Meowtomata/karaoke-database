-- Drop tables if they exist to avoid conflicts when re-running the script
DROP TABLE IF EXISTS song_data;
DROP TABLE IF EXISTS queue_info;
DROP TABLE IF EXISTS contributor;
DROP TABLE IF EXISTS user;
DROP TABLE IF EXISTS karaoke_file;
DROP TABLE IF EXISTS song;

-- Create tables
CREATE TABLE user (
    user_id VARCHAR(255) PRIMARY KEY
);

CREATE TABLE song (
    song_id INT AUTO_INCREMENT PRIMARY KEY,
    song_title VARCHAR(255) NOT NULL
);

CREATE TABLE karaoke_file (
    file_id INT AUTO_INCREMENT PRIMARY KEY,
    version VARCHAR(10) DEFAULT 'SOLO',
    song_id INT NOT NULL,
    FOREIGN KEY (song_id) REFERENCES song (song_id)
);


CREATE TABLE contributor (
    contributor_name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE song_data (
    song_id INT,
    role_name VARCHAR(50),
    contributor_name VARCHAR(255),
    PRIMARY KEY (song_id, contributor_name),
    FOREIGN KEY (song_id) REFERENCES song (song_id),
    FOREIGN KEY (contributor_name) REFERENCES contributor (contributor_name)
);


CREATE TABLE queue_info (
    karaoke_file_id INT,
    user_id VARCHAR(255),
    time_stamp DATETIME,
    payment INT,
    PRIMARY KEY (karaoke_file_id, time_stamp),
    FOREIGN KEY (karaoke_file_id) REFERENCES karaoke_file (file_id)
);

