<?php
include 'password.php';
session_start();
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
try {
    $regularQueue = $pdo->query("
        SELECT queue_info.*, karaoke_file.version, song.song_title 
        FROM queue_info
        JOIN karaoke_file ON queue_info.karaoke_file_id = karaoke_file.file_id
        JOIN song ON song.song_id = karaoke_file.song_id
        WHERE payment IS NULL
        ORDER BY queue_info.time_stamp ASC
    ")->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOexception $e) {
    echo $e->getMessage();
    return;
}
// Fetch priority queue
try {
    $priorityQueue = $pdo->query("
        SELECT queue_info.*, karaoke_file.version, song.song_title 
        FROM queue_info
        JOIN karaoke_file ON queue_info.karaoke_file_id = karaoke_file.file_id
        JOIN song ON song.song_id = karaoke_file.song_id
        WHERE payment IS NOT NULL
        ORDER BY queue_info.time_stamp ASC
    ")->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOexception $e) {
    echo $e->getMessage();
    return;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Check if an entry in the queue has been pressed to deqeue
    if (isset($_POST['submit-queue'])) {


        // SQL Statement to remove song from queue
        $deleteQueue = $pdo->prepare(
            "DELETE FROM queue_info WHERE time_stamp = ? AND karaoke_file_id = ? AND user_id = ?");

        // Get value from button to decide which button to remove
        $primary_key = explode(",", $_POST["submit-queue"]);
        $time_stamp = $primary_key[0];
        $user_id = $primary_key[1];
        $karaoke_file_id = $primary_key[2];
        
        try {
            // Remove song entry from queue
            $deleteQueue->execute(array($time_stamp, $karaoke_file_id, $user_id));
            // Immediately refresh the page to see results
           $_SESSION['current-song'] = $primary_key[3]; 
           $_SESSION['user-id'] = $primary_key[1];
            header("Refresh: 0");
        }
        catch (PDOexception $e) {
            echo $e->getMessage();
        }
    }
}
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
            display: flex;
            flex-direction: column;
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
            text-align: left;
            padding: 15px;
            margin: 10px 0;
            border-radius: 10px;
            box-shadow: 0px 0px 5px 0px;
        }
        .song-box p {
            margin: 5px 0;
        }

        .form {
            flex: 1;
        }
    </style>
</head>
<body>
    <h1>DJ Interface - Karaoke</h1>
    <?php
    // Show the current song playing popped from queue
    if (isset($_SESSION['current-song']) && isset($_SESSION['user-id']))
    {
        echo "Current song playing: " . $_SESSION['current-song'] . ", Requested
            by: " . $_SESSION['user-id'];
    }
    ?>


    <div class="queue-wrapper">
        <!-- Priority Queue -->
        <form method="POST" action="" class="form">
        <div class="queue-column">
        <h2>Priority Queue</h2>
            <?php if (!empty($priorityQueue)): ?>
                <?php foreach ($priorityQueue as $entry): ?>
                    <!-- Store information to button to dequeue later -->
                    <?php
                    $timestamp = $entry['time_stamp'];
                    $user_id = $entry['user_id'];
                    $version = $entry['karaoke_file_id'];
                    $title = $entry['song_title'];
                    echo "
                    <button type='submit' name='submit-queue'
                    value='$timestamp,$user_id,$version,$title' class='song-box'>";
                    ?>
                        <p><strong>Username:</strong> <?= htmlspecialchars($entry['user_id']) ?></p>
                        <p><strong>Song:</strong> <?= htmlspecialchars($entry['song_title']) ?></p>
                        <p><strong>Karaoke Version:</strong> <?= htmlspecialchars($entry['version']) ?></p>
                        <p><strong>Submitted At:</strong> <?= htmlspecialchars($entry['time_stamp']) ?></p>
                        <p><strong>Payment:</strong> $<?= htmlspecialchars($entry['payment']) ?></p>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No songs in the priority queue.</p>
            <?php endif; ?>
        </div>
        </form>


        <!-- Regular Queue -->
        <form method="POST" action="" class="form">
        <div class="queue-column">
        <h2>Regular Queue</h2>
            <?php if (!empty($regularQueue)): ?>
                <?php foreach ($regularQueue as $entry): ?>
                    <!-- Store information to button to dequeue later -->
                    <?php
                    $timestamp = $entry['time_stamp'];
                    $user_id = $entry['user_id'];
                    $version = $entry['karaoke_file_id'];
                    $title = $entry['song_title'];
                    echo "
                    <button type='submit' name='submit-queue'
                    value='$timestamp,$user_id,$version,$title' class='song-box'>";
 
                   ?>
                        <p><strong>Username:</strong> <?= htmlspecialchars($entry['user_id']) ?></p>
                        <p><strong>Song:</strong> <?= htmlspecialchars($entry['song_title']) ?></p>
                        <p><strong>Karaoke Version:</strong> <?= htmlspecialchars($entry['version']) ?></p>
                        <p><strong>Submitted At:</strong> <?= htmlspecialchars($entry['time_stamp']) ?></p>
                    </button>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No songs in the priority queue.</p>
            <?php endif; ?>
        </div>
        </form>

    </div>
</body>
</html>
