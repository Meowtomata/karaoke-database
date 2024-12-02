<?php
include 'password.php';
?>

<?php
function setupPDO($username, $password, $dbname) {
    try {
        $dsn = "mysql:host=courses;dbname=$dbname";
        $pdo = new PDO($dsn, $username, $password);
    }
    catch (PDOexception $e) {
        echo "Connection to database failed: ". $e->getMessage();
        return;
    }

    // PDO will throw exceptions when error encountered
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}
?>
<?php
$pdo = setupPDO($username, $password, $dbname);

// Fetch regular queue
$regularQueue = $pdo->query("
    SELECT q.queue_id, u.user_id, s.song_title, qinfo.time_stamp 
    FROM queue_info qinfo 
    JOIN queue q ON q.queue_id = qinfo.queue_id 
    JOIN user u ON qinfo.user_id = u.user_id 
    JOIN song s ON qinfo.song_id = s.song_id 
    WHERE q.queue_id NOT IN (SELECT queue_id FROM priority_queue)
    ORDER BY qinfo.time_stamp ASC
")->fetchAll(PDO::FETCH_ASSOC);

// Fetch priority queue
$priorityQueue = $pdo->query("
    SELECT pq.queue_id, u.user_id, s.song_title, qinfo.time_stamp, pq.payment 
    FROM queue_info qinfo 
    JOIN priority_queue pq ON qinfo.queue_id = pq.queue_id 
    JOIN user u ON qinfo.user_id = u.user_id 
    JOIN song s ON qinfo.song_id = s.song_id 
    ORDER BY qinfo.time_stamp ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>DJ Interface - Karaoke.com</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: #9fd8e3;
            color: white;
            text-align: center;
            padding: 10px;
        }
        .queue-wrapper {
            display: flex;
            justify-content: space-around;
            margin: 30px;
        }
        .queue-column {
            flex: 1;
            margin: 10px;
            padding: 20px;
            border-radius: 20px;
            background-color: #f9f9f9;
            box-shadow: 0px 0px 5px 0px;
        }
        .queue-column h2 {
            text-align: center;
            background-color: #9fd8e3;
            color: white;
            padding: 10px;
            border-radius: 10px;
        }
        .song-box {
            background-color: white;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0px 0px 5px 0px;
        }
        .song-box p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>DJ Interface - Karaoke</h1>

    <div class="queue-wrapper">
        <!-- Priority Queue -->
        <div class="queue-column">
            <h2>Priority Queue</h2>
            <?php if (!empty($priorityQueue)): ?>
                <?php foreach ($priorityQueue as $entry): ?>
                    <div class="song-box">
                        <p><strong>Username:</strong> <?= htmlspecialchars($entry['user_id']) ?></p>
                        <p><strong>Song:</strong> <?= htmlspecialchars($entry['song_title']) ?></p>
                        <p><strong>Submitted At:</strong> <?= htmlspecialchars($entry['time_stamp']) ?></p>
                        <p><strong>Payment:</strong> $<?= htmlspecialchars($entry['payment']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No songs in the priority queue.</p>
            <?php endif; ?>
        </div>

        <!-- Regular Queue -->
        <div class="queue-column">
            <h2>Regular Queue</h2>
            <?php if (!empty($regularQueue)): ?>
                <?php foreach ($regularQueue as $entry): ?>
                    <div class="song-box">
                        <p><strong>Username:</strong> <?= htmlspecialchars($entry['user_id']) ?></p>
                        <p><strong>Song:</strong> <?= htmlspecialchars($entry['song_title']) ?></p>
                        <p><strong>Submitted At:</strong> <?= htmlspecialchars($entry['time_stamp']) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No songs in the regular queue.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
