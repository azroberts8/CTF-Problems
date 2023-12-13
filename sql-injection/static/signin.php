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

    if(isset($_SESSION["username"])) {
        header("Location: index.php");
    }

    if(isset($_POST["action"]) && $_POST["action"] == "signin") {
        $username = htmlspecialchars($_POST["username"]);
        
        if(strlen($username) > 30 || strlen($username) < 3) {
            $error = "bad-creds";
        } else {
            $sql = "SELECT * FROM Users WHERE Username = '" . $username . "';";
            $result = $conn->query($sql);
            if($result->num_rows == 1) {
                $user = $result->fetch_assoc();
                if(password_verify($_POST['password'], $user["Password"])) {
                    $_SESSION["username"] = $username;
                    header("Location: index.php");
                } else {
                    $error = "bad-creds";
                }
            } else {
                $error = "bad-creds";
            }
        }
    } else if(isset($_POST["action"]) && $_POST["action"] == "create") {
        $username = htmlspecialchars($_POST["username"]);

        if(strlen($username) > 30 || strlen($username) < 3) {
            $error = "invalid-username";
        } else {
            $sql = "SELECT * FROM Users WHERE Username = '" . $username . "';";
            $result = $conn->query($sql);
            if($result->num_rows > 0) {
                $error = "invalid-username";
            } else {
                if(strlen($_POST["password"]) < 4) {
                    $error = "invalid-password";
                } else {
                    $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $sql = "INSERT INTO Users (Username, Password) VALUES ('" . $username . "', '" . $hash . "');";
                    if($conn->query($sql) == TRUE) {
                        $_SESSION["username"] = $username;
                        header("Location: index.php");
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tech Topics - Sign-In</title>
</head>
<body>
    <form action="signin.php" method="post">
        <h3>Sign in to Tech Topics</h3>
        <label for='username'>Username:</label><br>
        <input type='text' id='username' name='username'><br>
        <label for="password">Password:</label>
        <input type="password" id='password' name='password'><br>
        <input type="hidden" name="action" value="signin">
        <?php if(isset($error) && $error == "bad-creds") echo "<p style='color: red'>Incorrect username or password</p>" ?>
        <input type="submit" value="Sign In">
    </form>
    <hr />
    <form action="signin.php" method="post">
        <h3>Or create an account</h3>
        <label for='username'>Username:</label><br>
        <input type='text' id='username' name='username'><br>
        <?php if(isset($error) && $error == "invalid-username") echo "<p style='color: red;'>Username taken or invalid</p>" ?>
        <label for="password">Password:</label>
        <input type="password" id='password' name='password'><br>
        <input type="hidden" name="action" value="create">
        <?php if(isset($error) && $error == "invalid-password") echo "<p style='color: red'>Invalid password</p>" ?>
        <input type="submit" value="Create Account">
    </form>
</body>
</html>
<?php $conn->close(); ?>