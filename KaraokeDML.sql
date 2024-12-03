-- Instance Data


-- Inserting Songs
INSERT INTO song (song_title)
    VALUES
    ("squabble up"),
    ("luther (with sza)"),
    ("A Bar Song(Tipsy)"),
    ("Birds Of A Feather"),
    ("Not Like Us"),
    ("tv off(feat. lefty gunplay)"),
    ("Elevated");


-- Inserting Contributor Names
INSERT INTO contributor (contributor_name)
    VALUES
    ("Kendrick Lamar"),
    ("SZA"),
    ("Shaboozey"),
    ("Billie Eilish"),
    ("lefty gunplay"),
    ("Charles Berthoud");

-- Associating Songs With Roles and Contributors
INSERT INTO song_data (song_id, role_name, contributor_name)
    VALUES
    (1, "Artist, Writer", "Kendrick Lamar"), -- squabble up
    (2, "Artist, Writer", "Kendrick Lamar"), -- luther (with sza)
    (2, "Featured Artist", "SZA"),
    (3, "Artist, Writer", "Shaboozey"); -- A Bar Song Tipsy

-- Inserting Karaoke Files
INSERT INTO karaoke_file (version, song_id)
    VALUES
    ("Solo", 1), -- squabble up
    ("Solo", 2), -- luther (with sza)
    ("Duet", 2), -- luther (with sza)
    ("Solo", 3); -- A Bar Song Tipsy


-- Insert 5 Priority Queue & 5 Normal Queue Items
INSERT INTO queue_info (song_id, time_stamp, user_id, payment)
    VALUES
    (1, '2023-10-05 14:30:00', 'Meowster', NULL),
    (2, '2024-10-03 15:34:22', 'Dingus', 100),
    (3, '2024-10-06 16:38:22', 'arnold', 30000);

