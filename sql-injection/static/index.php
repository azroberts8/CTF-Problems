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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Topics</title>
</head>
<body>
    <?php
        if(isset($_SESSION["username"])) {
            echo "<div>Hello, " . $_SESSION["username"] . "!</div>";
        } else {
            echo "<a href='signin.php'>Sign In</a>";
        }
    ?>
    <h1>Welcome to Tech Topics!</h1>
    <p>Tech topics is a site where geeks can come together and share all their geeky thoughts with other like-minded geeks. Check out the discussions in our growing list of topics below or start a new one all together!</p>
    <p>We encourage you to create an account to get involved and begin making posts and topics! We kindly ask that you keep conversations respectful and not to hack other users.</p>
    <hr />
    <br>

    <h2>Topics:</h2>
    <ul>
        <?php
            $sql = "SELECT * FROM Topics;";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<li><a href='topic.php?topic=" . $row["TopicID"] . "'>" . $row["Title"] . "</a></li>";
                }
            }
        ?>
    </ul>
    <br>
    <?php 
        if(isset($_SESSION["username"])) {
            echo "<form action='newtopic.php'>
                <h3>Create Topic</h3>
                <label for='topicName'>Topic Name:</label><br>
                <input type='text' id='topicName' name='topicName'><br>
                <input type='submit' value='Create'>
            </form>";
        } else {
            echo "<p>You must be signed in to create new topics. <a href='signin.php'>Sign In</a></p>";
        }
    ?>
</body>
</html>
<?php $conn->close(); ?>