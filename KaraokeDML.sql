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

