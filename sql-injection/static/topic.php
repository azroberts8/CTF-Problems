<?php
    // Connect to the SQL server
    $servername = "localhost";
    $username = "php";
    $password = "SuperSecurePassword";
    $dbname = "app";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Handle login state
    session_start();

    if(!isset($_GET["topic"])) {
        header('Location: index.php');
    } else {
        if(isset($_POST["title"]) && isset($_POST["body"]) && isset($_SESSION["username"])) {
            // signed in and making a post
            $sql = "SELECT * FROM Users WHERE Username = '" . $_SESSION["username"] . "';";
            $result = $conn->query($sql);
            if($result->num_rows == 1) {
                $userID = $result->fetch_assoc()["UserID"];
                $topicID = preg_replace('/[^0-9]/', '', $_GET["topic"]);
                $title = substr(htmlspecialchars($_POST['title']), 0, 120);
                $body = substr(htmlspecialchars($_POST['body']), 0, 1600);
                $sql = "INSERT INTO Posts (TopicID, UserID, Title, Contents) VALUES ('" . $topicID . "', '" . $userID . "', '" . $title . "', '" . $body . "');";
                $conn->query($sql);
            } else {
                $error = "Could not identify user " . $_SESSION["username"];
            }
        }

        // get topic name
        $sql = "SELECT * FROM Topics WHERE TopicID = " . preg_replace('/[^0-9]/', '', $_GET["topic"]) . ";";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $title = $result->fetch_assoc()["Title"];
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Topics - <?php echo $title; ?></title>
</head>
<body>
    <?php
        if(isset($_SESSION["username"])) {
            echo "<div>Hello, " . $_SESSION["username"] . "!</div>";
        } else {
            echo "<a href='signin.php'>Sign In</a>";
        }
    ?>
    <h2><?php echo $title ?></h2>
    <?php
        $sql = "SELECT Users.Username AS username, Posts.Title AS title, Posts.Contents AS body, Posts.Posted AS posted FROM Posts RIGHT JOIN Users ON Posts.UserID = Users.UserID WHERE Posts.TopicID = " . preg_replace('/[^0-9]/', '', $_GET["topic"]) . " ORDER BY Posts.Posted;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div style='border: 1.5px solid black; padding: 0 15px;'>
                <h3>" . $row["title"] . "</h3>
                Author: " . $row["username"] . " on " . $row["posted"] . "
                <p>" . $row["body"] . "</p>
                </div><br>";
            }
        }
    ?>
    <br>
    <hr />
    <?php 
        if(isset($_SESSION["username"])) {
            echo "<form action='topic.php?topic=" . preg_replace('/[^0-9]/', '', $_GET["topic"]) . "' method='post'>
                <h3>Create Post</h3>
                <label for='title'>Title:</label><br>
                <input type='text' id='title' name='title'><br>
                <label for='title'>Body:</label><br>
                <textarea id='body' name='body' rows='4' cols='50'></textarea><br>
                <input type='submit' value='Post'>
            </form>";
        } else {
            echo "<p>You must be signed in to post to this topic. <a href='signin.php'>Sign In</a></p>";
        }
    ?>
</body>
</html>

<?php $conn->close(); ?>