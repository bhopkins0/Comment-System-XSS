<?php
// You will need to enter the database credentials here
$host = '';
$user = '';
$password = '';
$database = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $connection = new mysqli($host, $user, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $comment = $_POST['comment'];

    $sql = "INSERT INTO comments (comment_text) VALUES (?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("s", $comment);

    if ($stmt->execute()) {
        echo "Comment posted successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $stmt->error;
    }

    $stmt->close();
    $connection->close();

    }
?>

<html>
<body>
    <h1>Comment System</h1>
    <form method="POST">
        <label for="comment">Add Comment</label><br>
        <textarea id="comment" name="comment" rows="4" cols="50"></textarea><br>
        <input type="submit" value="Submit">
    </form>

    <h2>Comments</h2>
    <?php
    $connection = new mysqli($host, $user, $password, $database);
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $sql = "SELECT * FROM comments ORDER BY timestamp DESC";
    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<p>" . $row['comment_text'] . "</p>";
        }
    } else {
        echo "No comments yet.";
    }

    $connection->close();
    ?>
</body>
</html>
