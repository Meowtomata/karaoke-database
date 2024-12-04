<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

?>
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

    // pdo will throw exceptions when error encountered
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    return $pdo;
}
?>

<?php
$pdo = setupPDO($username, $password, $dbname);
?>

<?php
$songs = [];
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];

    $getSongsQuery = $pdo->prepare(
        "SELECT s.song_id, s.song_title, sd.role_name, c.contributor_name, kf.file_id, kf.version
        FROM song s
        JOIN song_data sd ON s.song_id = sd.song_id
        JOIN contributor c ON sd.contributor_name = c.contributor_name
        LEFT JOIN karaoke_file kf ON s.song_id = kf.song_id  -- Use LEFT JOIN to include songs without karaoke files
        WHERE LOWER(s.song_title) LIKE :search
        OR LOWER(c.contributor_name) LIKE :search
        ORDER BY s.song_title, sd.role_name, kf.version"

    );
    $getSongsQuery->bindValue(':search', '%' . strtolower($searchQuery) . '%');
    $getSongsQuery->execute();
    $songs = $getSongsQuery->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($songs);
    exit();
} else {
    $getSongsQuery = $pdo->query(
        "SELECT s.song_id, s.song_title, sd.role_name, c.contributor_name, kf.file_id, kf.version
         FROM song s
         JOIN song_data sd ON s.song_id = sd.song_id
         JOIN contributor c ON sd.contributor_name = c.contributor_name
         JOIN karaoke_file kf ON s.song_id = kf.song_id
         ORDER BY s.song_title, sd.role_name, kf.version"
    );
    $songs = $getSongsQuery->fetchAll(PDO::FETCH_ASSOC);
}
?>


 <!DOCTYPE html>
 <html>
 <head>
     <title>Karaoke.com</title>

     <style>
         body{
             font-family: Arial, sans-serif;
             background-color: white;
             margin: 0;
             padding: 0;
         }
         h1{
             background-color: #9fd8e3;
             color: white;
             text-align: center;
         }
         form{ background-color: white;
            margin: 30px auto;
            padding: 20px;
            border-radius: 20px;
            max-width:600px;
            box-shadow: 0px 0px 5px 0px;
        }
        label{
            display:block;
            margin-bottom: 10px;
            font-weight:bold;
        }
        input[type="text"]{
            width: calc(100% - 20px);
            padding: 10px;
            border-radius:5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
        }
        input[type="radio"]{
            margin-right:10px
        }
        button{
            background-color:#9fd8e3;
            margin: 5px;
            padding: 10px 20px;
            color: white;
            border: none;
            border-radius: 10px;
        }
        button:hover{
            background-color:#589fad;
        }
        #paymentSection{
            background-color:#9fd8e3;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid #589fad;
        }
        .form-group{
            margin-bottom: 20px;
        }


    </style>

</head>
<body>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_POST['userID'] ?? '';
    $fileID = $_POST['file'] ?? '';
    $queuetype = $_POST['queuetype'] ?? 'queue';
    $paymentAmount = isset($_POST['paymentAmount']) ? floatval($_POST['paymentAmount']) : 0;

    if ($paymentAmount == 0 || empty($paymentAmount)) {
        $queuetype = 'queue';
    }

    if (empty($userID) || empty($fileID)) {
        echo "<script>alert('Please provide a username and song choice.');</script>";
    } else {
        $checkFileQuery = $pdo->prepare("SELECT song_id FROM karaoke_file WHERE file_id = :file_id");
        $checkFileQuery->execute([':file_id' => $fileID]);
        $song = $checkFileQuery->fetch(PDO::FETCH_ASSOC);

        if (!$song) {
            echo "<script>alert('Selected song version does not exist!');</script>";
        } else {
            $songID = $song['song_id'];
            $timestamp = date('Y-m-d H:i:s');

            if ($queuetype === 'priority' && $paymentAmount >= 5) {
                $insertIntoQueue = $pdo->prepare(
                    "INSERT INTO queue_info (karaoke_file_id, time_stamp, user_id, payment)
                     VALUES (:karaoke_file_id, :time_stamp, :user_id, :payment)"
                );
                $insertIntoQueue->execute([
                    ':karaoke_file_id' => (int)$fileID,
                    ':time_stamp' => $timestamp,
                    ':user_id' => $userID,
                    ':payment' => $paymentAmount
                ]);
            } else {
                $insertIntoQueue = $pdo->prepare(
                    "INSERT INTO queue_info (karaoke_file_id, time_stamp, user_id)
                     VALUES (:karaoke_file_id, :time_stamp, :user_id)"
                );
                $insertIntoQueue->execute([
                    ':karaoke_file_id' => (int)$fileID,
                    ':time_stamp' => $timestamp,
                    ':user_id' => $userID
                ]);
            }
            echo "<script>alert('Song added to the queue!');</script>";
        }
    }
}


?>


<h1>Welcome to Karaoke</h1>

<form id="karaokeForm" method="POST" action="">
    <label for="userID">Username: </label>
    <input type="text" id="userID" name="userID" placeholder="Enter a Username"><br><br>

    <label for="search">Song Choice: </label>
    <input type="text" id="word" oninput="searchSongs()" name="search" placeholder="Enter a Song or Artist"><br><br>

    <div id="results">
        <h2>All Songs</h2>
        <select name="file" id="songSelect">
            <option value="">Select a song </option>
            <?php foreach ($songs as $song): ?>
                <option value="<?= htmlspecialchars($song['file_id']) ?>">
                    <?= htmlspecialchars($song['song_title'] . ": " . $song['role_name'] . " - " . $song['contributor_name'] . " [" . $song['version'] . "]") ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div><br><br>

    <label>Queue Choice:</label><br>
    <div class="form-group">
        <input type="radio" id="queue" name="queuetype" value="queue"
        <?php if (isset($_POST['queuetype']) && $_POST['queuetype'] == 'queue' || !isset($_POST['queuetype'])) echo 'checked'; ?>>
        <label for="queue" style="display: inline;">Queue</label><br>

        <input type="radio" id="priorityqueue" name="queuetype" value="priority"
        <?php if (isset($_POST['queuetype']) && $_POST['queuetype'] == 'priority') echo 'checked'; ?>>
        <label for="priorityqueue" style="display: inline;">Priority Queue</label>
    </div>

    <label for="paymentAmount">Payment Amount (optional):</label>
    <input type="text" id="paymentAmount" name="paymentAmount" placeholder="Enter amount"><br><br>


    <button type="submit">Submit</button>
</form>

<script>
function searchSongs() {
    const searchQuery = document.getElementById('word').value.trim();
    const songSelect = document.getElementById('songSelect');

    songSelect.innerHTML = '<option value="" disabled selected>Select a song</option>';

    if (searchQuery.length > 0) {
        fetch(`?search=${encodeURIComponent(searchQuery)}`)
            .then(response => response.json())
            .then(songs => {
                if (songs.length > 0) {
                    songs.forEach(song => {
                        const option = document.createElement('option');
                        option.value = song.file_id;
                        option.textContent = `${song.song_title}: ${song.role_name} - ${song.contributor_name}`;
                        songSelect.appendChild(option);
                    });
                } else {
                    const option = document.createElement('option');
                    option.value = "";
                    option.textContent = "No songs found";
                    songSelect.appendChild(option);
                }
            })
            .catch(() => {
                alert("Failed to fetch songs. Please try again.");
            });
    }
}



</script>

</body>
</html>
