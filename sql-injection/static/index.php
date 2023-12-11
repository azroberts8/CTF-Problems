<?php
$servername = "localhost";
$username = "php";
$password = "SuperSecurePassword";
$dbname = "app";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM Users WHERE Username = '" . $_GET["name"] . "';";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hello World Application</title>
</head>
<body>
    <?php

    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p>UserID: " . $row["UserID"] . "; Username: " . $row["Username"] . "; Password: " . $row["Password"] . ";</p>";
        }
    } else {
        echo "<p>No results found for " . $_GET["name"] . "</p>";
    }

    ?>
</body>
</html>

<?php
$conn->close();
?>