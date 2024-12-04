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
    ("Elevated"),
    ("Rolled up"),
    ("Snake walk"),
    ("All, I want for Christmas Is You"),
    ("Heat Waves"),
    ("As It Was"),
    ("Anti-Hero"),
    ("Flowers"),
    ("Bad Habit"),    
    ("Kill Bill"),
    ("Last Night"),
    ("Calm Down"),
    ("Blinding Lights"),
    ("Save Your Tears"),
    ("Shivers"),
    ("Stay"),
    ("Good 4 U"),
    ("Drivers License"),
    ("Dance Monkey"),
    ("Power Of The Beast"),
    ("The Reckoning"),
    ("War of Change"),
    ("PvP"),
    ("Basket Case"),
    ("American Idiot");


-- Inserting Contributor Names
INSERT INTO contributor (contributor_name)
    VALUES
    ("Kendrick Lamar"),
    ("SZA"),
    ("Shaboozey"),
    ("Billie Eilish"),
    ("lefty gunplay"),
    ("Charles Berthoud"),
    ("mobbu"),
    ("Mariah Carey"),
    ("Glass Animals"),
    ("Harry Styles"),
    ("Taylor Swift"),
    ("Miley Cyrus"),
    ("Steve Lacy"),
    ("Doja Cat"),
    ("The Weeknd"),
    ("Ed Sheeran"),
    ("Justin Bieber"),    
    ("Olivia Rodrigo"),
    ("Tones and I"),
    ("Beast In Black"),
    ("Dom Fera"),
    ("Thousand Foot Krutch"),
    ("Amaranthe"),
    ("Green Day");


-- Associating Songs With Roles and Contributors
INSERT INTO song_data (song_id, role_name, contributor_name)
    VALUES
    (1, "Artist, Writer", "Kendrick Lamar"), -- squabble up
(2, "Artist, Writer", "Kendrick Lamar"), -- luther (with sza)
(2, "Featured Artist", "SZA"),
(3, "Artist, Writer", "Shaboozey"), -- A Bar Song(Tipsy)
(4, "Artist, Writer", "Billie Eilish"), -- Birds Of A Feather
(5, "Artist, Writer", "endrick Lamar"), -- Not Like Us
(6, "Artist, Writer", "lefty gunplay"), -- tv off(feat. lefty gunplay)
(7, "Artist, Writer", "Charles Berthoud"), -- Elevated
(8, "Artist, Writer", "mobbu"), -- Rolled up
(9, "Artist, Writer", "mobbu"), -- Snake walk
(10, "Artist, Writer", "Mariah Carey"), -- All I Want for Christmas Is You
(11, "Artist, Writer", "Glass Animals"), -- Heat Waves
(12, "Artist, Writer", "Harry Styles"), -- As It Was
(13, "Artist, Writer", "Taylor Swift"), -- Anti-Hero
(14, "Artist, Writer", "Miley Cyrus"), -- Flowers
(15, "Artist, Writer", "Steve Lacy"), -- Bad Habit
(16, "Artist, Writer", "Doja Cat"), -- Kill Bill
(17, "Artist, Writer", "Doja Cat"), -- Last Night
(18, "Artist, Writer", "The Weeknd"), -- Calm Down
(19, "Artist, Writer", "The Weeknd"), -- Blinding Lights
(20, "Artist, Writer", "The Weeknd"), -- Save Your Tears
(21, "Artist, Writer", "Ed Sheeran"), -- Shivers
(22, "Artist, Writer", "Justin Bieber"), -- Stay
(23, "Artist, Writer", "Olivia Rodrigo"), -- Good 4 U
(24, "Artist, Writer", "Olivia Rodrigo"), -- Drivers License
(25, "Artist, Writer", "Tones and I"), -- Dance Monkey
(26, "Artist, Writer", "Beast In Black"), -- Power Of The Beast
(27, "Artist, Writer", "Dom Fera"), -- The Reckoning
(28, "Artist, Writer", "Thousand Foot Krutch"), -- War of Change
(29, "Artist, Writer", "Amaranthe"), -- PvP
(30, "Artist, Writer", "Green Day"), -- Basket Case
(31, "Artist, Writer", "Green Day") -- American Idiot
;

-- Inserting Karaoke Files
INSERT INTO karaoke_file (version, song_id)
    VALUES
    ("Solo", 1), -- squabble up
("Solo", 2), -- luther (with sza)
("Duet", 2), -- luther (with sza)
("Solo", 3), -- A Bar Song(Tipsy)
("Solo", 4), -- Birds Of A Feather
("Solo", 5), -- Not Like Us
("Solo", 6), -- tv off(feat. lefty gunplay)
("Solo", 7), -- Elevated
("Solo", 8), -- Rolled up
("Solo", 9), -- Snake walk
("Solo", 10), -- All I Want for Christmas Is You
("Solo", 11), -- Heat Waves
("Duet", 11), -- Heat Waves
("Solo", 12), -- As It Was
("Solo", 13), -- Anti-Hero
("Solo", 14), -- Flowers
("Solo", 15), -- Bad Habit
("Solo", 16), -- Kill Bill
("Duet", 16), -- Kill Bill
("Solo", 17), -- Last Night
("Solo", 18), -- Calm Down
("Duet", 18), -- Calm Down
("Solo", 19), -- Blinding Lights
("Solo", 20), -- Save Your Tears
("Solo", 21), -- Shivers
("Duet", 21), -- Shivers
("Solo", 22), -- Stay
("Solo", 23), -- Good 4 U
("Solo", 24), -- Drivers License
("Duet", 24), -- Drivers License
("Solo", 25), -- Dance Monkey
("Solo", 26), -- Power Of The Beast
("Duet", 26), -- Power Of The Beast
("Solo", 27), -- The Reckoning
("Solo", 28), -- War of Change
("Solo", 29), -- PvP
("Solo", 30), -- Basket Case
("Solo", 31), -- American Idiot
("Duet", 5), -- Not Like Us
("Duet", 13), -- Anti-Hero
("Duet", 14), -- Flowers
("Duet", 19), -- Blinding Lights
("Duet", 20), -- Save Your Tears
("Duet", 22), -- Stay
("Duet", 23), -- Good 4 U
("Duet", 27), -- The Reckoning
("Duet", 28), -- War of Change
("Duet", 29), -- PvP
("Duet", 30), -- Basket Case
("Duet", 31), -- American Idiot
("Duet", 17), -- Last Night
("Duet", 6), -- tv off(feat. lefty gunplay)
("Duet", 8) -- Rolled up
    ;

-- Insert 5 Priority Queue & 5 Normal Queue Items
INSERT INTO queue_info (song_id, time_stamp, user_id, payment)
    VALUES
    (1, '2023-10-05 14:30:00', 'Meowster', NULL),
    (2, '2024-10-03 15:34:22', 'Dingus', 100),
    (3, '2024-10-06 16:38:22', 'arnold', 30000),
    (31, '2024-10-07 14:26:23', 'sleepyGuy', NULL),
    (15, '2024-10-07 16:14:13', 'Patrick', NULL),
    (9, '2024-11-03 11:15:45', 'Max Verstappen', 1000000),
    (22,'2024-12-02 19:24:23' 'Sonic', NULL),
    (26, '2024-12-03 14:26:23','Celica', NULL),
    (17, '2024-12-04 12:15:23', 'Supra', 20),
     (13, '2024-12-05 17:30:23', 'Rashid', 30);

