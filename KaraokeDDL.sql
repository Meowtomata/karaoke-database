-- Drop tables if they exist to avoid conflicts when re-running the script
DROP TABLE IF EXISTS song_data;
DROP TABLE IF EXISTS contributor_group;
DROP TABLE IF EXISTS priority_queue;
DROP TABLE IF EXISTS queue_info;
DROP TABLE IF EXISTS queue;
DROP TABLE IF EXISTS contributor;
DROP TABLE IF EXISTS role;
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

CREATE TABLE role (
    role_name VARCHAR(50) PRIMARY KEY
);

CREATE TABLE contributor (
    contributor_name VARCHAR(255) PRIMARY KEY
);

CREATE TABLE song_data (
    song_id INT,
    role_name VARCHAR(50),
    contributor_name VARCHAR(255),
    PRIMARY KEY (song_id, role_name, contributor_name),
    FOREIGN KEY (song_id) REFERENCES song (song_id),
    FOREIGN KEY (role_name) REFERENCES role (role_name),
    FOREIGN KEY (contributor_name) REFERENCES contributor (contributor_name)
);

CREATE TABLE contributor_group (
    contributor_name VARCHAR(255),
    group_name VARCHAR(255),
    PRIMARY KEY (contributor_name, group_name),
    FOREIGN KEY (contributor_name) REFERENCES contributor (contributor_name),
    FOREIGN KEY (group_name) REFERENCES contributor (contributor_name)
);

CREATE TABLE queue (
    queue_id INT AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE priority_queue (
    queue_id INT,
    payment INT,
    PRIMARY KEY (queue_id, payment),
    FOREIGN KEY (queue_id) REFERENCES queue (queue_id)
);

CREATE TABLE queue_info (
    queue_id INT,
    song_id INT,
    user_id VARCHAR(255),
    time_stamp DATETIME,
    PRIMARY KEY (queue_id, song_id, user_id),
    FOREIGN KEY (song_id) REFERENCES song (song_id),
    FOREIGN KEY (user_id) REFERENCES user (user_id)
);

-- Instance Data


-- Inserting Songs
INSERT INTO song (song_title)
    VALUES
    ("squabble up"),
    ("luther (with sza)");

-- Inserting Roles
INSERT INTO role (role_name)
    VALUES
    ("Artist"),
    ("Featured Artist");

-- Inserting Contributor Names
INSERT INTO contributor (contributor_name)
    VALUES
    ("Kendrick Lamar"),
    ("SZA");

-- Associating Songs With Roles and Contributors
INSERT INTO song_data (song_id, role_name, contributor_name)
    VALUES
    (1, "Artist", "Kendrick Lamar"), -- squabble up
    (2, "Artist", "Kendrick Lamar"), -- luther (with sza)
    (2, "Featured Artist", "SZA");   -- luther (with sza)


-- Inserting Karaoke Files
INSERT INTO karaoke_file (version, song_id)
    VALUES
    ("Solo", 1), -- squabble up
    ("Solo", 2), -- luther (with sza)
    ("Duet", 2); -- luther (with sza)



