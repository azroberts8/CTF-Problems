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

    if(!isset($_SESSION['username'])) {
        header("Location: index.php");
    } else {
        $topic = substr(htmlspecialchars($_POST['topicName']), 0, 120);
        $sql = "INSERT INTO Topics (Title) VALUES ('" . $topic . "');";
        $conn->query($sql);
        $sql = "SELECT * FROM Topics WHERE Title = '" . $topic . "' ORDER BY TopicID DESC;";
        $result = $conn->query($sql);
        if($result->num_rows > 0) {
            $topic = $result->fetch_assoc();
            header("Location: topic.php?topic=" . $topic["TopicID"]);
        } else {
            echo "Something went wrong.";
        }
    }

    $conn->close();
?>