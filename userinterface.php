<?php
include 'password.php'
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
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userID = $_POST['userID'];
    $queueType = $_POST['queuetype'];
    $searchParam = '%' . ($_POST['search'] ?? '') . '%';
    $paymentAmount = $_POST['paymentAmount'] ?? 0;

    try {
        if (!isset($pdo)) {
            throw new Exception("Database connection failed. Please check setupPDO().");
        }

        $checkUserQuery = $pdo->prepare("INSERT IGNORE INTO user (user_id) VALUES (:userID)");
        $checkUserQuery->execute([':userID' => $userID]);

        $getAllSongsQuery = $pdo->prepare(
            "SELECT s.song_title, sd.role_name, c.contributor_name 
             FROM song s
             JOIN song_data sd ON s.song_id = sd.song_id
             JOIN contributor c ON sd.contributor_name = c.contributor_name
             WHERE s.song_title LIKE :search OR c.contributor_name LIKE :search
             ORDER BY s.song_title, sd.role_name"
        );
        $getAllSongsQuery->execute([':search' => $searchParam]);
        $songs = $getAllSongsQuery->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
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
        form{
            background-color: white;
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
    $showPayment = false;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['queuetype']) && $_POST['queuetype'] == 'priority') {
            $showPayment = true;
        }
    }
?>


    <h1>Welcome to Karaoke</h1>

    <form method="POST" action="">
        <label for="userID">Username: </label>
        <input type="text" id="userID" name="userID" placeholder="Enter a Username"><br><br>

        <label for="search">Song Choice: </label>
        <input type="text" id="word" name="search" placeholder="Enter a Song or Artist">
        <br><br>

        <?php if (isset($songs)): ?>
<div id="results">
    <h2>All Songs</h2>
    <select>
        <option value="" disabled selected>Select a song</option>
        <?php foreach ($songs as $song): ?>
            <option>
                <?php echo htmlspecialchars($song['song_title']) . ": " . htmlspecialchars($song['role_name']) . " - " . htmlspecialchars($song['contributor_name']); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>
<?php endif; ?>
<br>

        <label>Queue Choice:</label><br>
            <div class="form-group">
            <input type="radio" id="queue" name="queuetype" value="queue"
            <?php if (isset($_POST['queuetype']) && $_POST['queuetype'] == 'queue') echo 'checked'; ?>>
            <label for="queue" style="display: inline;">Queue</label>
        <br>
            <input type="radio" id="priorityqueue" name="queuetype" value="priority"
            <?php if (isset($_POST['queuetype']) && $_POST['queuetype'] == 'priority') echo 'checked'; ?>>
            <label for="priorityqueue" style="display: inline;">Priority Queue</label>

            </div>
        <?php if ($showPayment): ?>
            <div id="paymentSection">
                <h3>Payment Options</h3>
                <label for="paymentAmount">Amount to Pay:</label>
                <input type="text" id="paymentAmount" name="paymentAmount" placeholder="Enter amount"><br><br>

                <label>Payment Method:</label><br>
        <div class="form-group">
                <input type="radio" id="card" name="paymentMethod" value="card" checked>
                <label for="card" style="display: inline;">Debit/Credit Card</label><br>

                <input type="radio" id="cash" name="paymentMethod" value="cash">
                <label for="cash" style="display: inline;">Cash</label>
            </div>
                <div id="cardDetails">
                <label for="cardNumber">Card Number:</label>
                <input type="text" id="cardNumber" name="cardNumber"><br><br>
                
                <label for="expirationDate">Expiration Date:</label>
                <input type="text" id="expirationDate" name="expirationDate" placeholder="MM/YY"><br><br>
                
                <label for="cvv">CVV Code:</label>
                <input type="text" id="cvv" name="cvv"><br><br>
            </div>
        </div>
        <?php endif; ?>

        <button type="submit">Submit</button>
    </form>


</body>
</html>

