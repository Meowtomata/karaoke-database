-- Instance Data


-- Inserting Songs
INSERT INTO song (song_title)
    VALUES
    ("squabble up"),
    ("luther (with sza)"),
    ("Yesterday");


-- Inserting Contributor Names
INSERT INTO contributor (contributor_name)
    VALUES
    ("Kendrick Lamar"),
    ("SZA"),
    ("Scott Bridgeway"),
    ("Jack Antonoff"),
    ("Sounwave"),
    ("Matthew \"MTech\" Bernard"),
    ("Sam Dew"),
    ("Ink"),
    ("Roselilah"),
    ("Cardo Got Wings"),
    ("Kamasi Washington"),
    ("The Beatles"),
    ("George Harrison"),
    ("John Lennon"),
    ("Paul McCartney"),
    ("Ringo Starr"),
    ("George Martin");

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
    ("Duet", 2), -- luther (with sza)
    ("Solo", 3); -- Yesterday

