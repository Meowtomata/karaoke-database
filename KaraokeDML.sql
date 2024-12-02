-- Instance Data


-- Inserting Songs
INSERT INTO song (song_title)
    VALUES
    ("squabble up"),
    ("luther (with sza)");


-- Inserting Contributor Names
INSERT INTO contributor (contributor_name)
    VALUES
    ("Kendrick Lamar"),
    ("SZA");

-- Associating Songs With Roles and Contributors
INSERT INTO song_data (song_id, role_name, contributor_name)
    VALUES
    (1, "Artist, Writer", "Kendrick Lamar"), -- squabble up
    (2, "Artist, Writer", "Kendrick Lamar"), -- luther (with sza)
    (2, "Featured Artist", "SZA");

-- Inserting Karaoke Files
INSERT INTO karaoke_file (version, song_id)
    VALUES
    ("Solo", 1), -- squabble up
    ("Solo", 2), -- luther (with sza)
    ("Duet", 2); -- luther (with sza)


-- Insert 5 Priority Queue & 5 Normal Queue Items
INSERT INTO queue_info (song_id, time_stamp, user_id, payment)
    VALUES
    (1, '2023-10-05 14:30:00', 'Meowster', 0),
    (2, '2024-10-03 15:34:22', 'Dingus', 100);
