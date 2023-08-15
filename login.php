<?php
include_once "include/config.php";
require_once "include/Database.php";
$db = new Database;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    $stmt = $db->connection->prepare("SELECT * FROM users WHERE username = ? AND passw = ?");
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found in the database
        $row = $result->fetch_assoc();
        session_start();
        //Store the user information in session variables
        $_SESSION["username"] = $row["username"];
        $_SESSION["isAdmin"] = $row["isAdmin"];

        if (isset($_SESSION["username"])) {
            // Redirect to the login page or display an error message
            header("Location: home2.php");
            exit();
        }
    }
}
   /*     else {
            // Redirect to regular user page
            header("Location: user.php");
            exit();
        }
    }
    else {
        // Invalid credentials, redirect to login page
        header("Location: login.php");
        exit();
    }
}*/?>
<html>
<head>
    <link rel="stylesheet" href="include/style.css">
    <title>Login</title>
    <script src="include/script.js"></script>
</head>
<body>

<div id="navbar">
    <a href="login.php" class="active">Login</a>
    <!--<a href="user.php">User DB Finder</a>-->
    <!--<a href="home.php">Admin DB Ramble</a>-->
</div>

<div class="container">
    <form action="login.php" method="post" style="text-align: center;">
        <label for="user">Username:</label><br>
        <input type="text" id="user" name="user"><br>
        <label for="pass">Password</label><br>
        <input type="password" id="pass" name="pass"><br><br>
        <input type="submit" value="Submit">
    </form>
</div>

<div class="footer" id="footer">
    <p> Made by:
        <a href="https://www.instagram.com/ivaylo.kolev1/" class="insta">Ivaylo Kolev</a>
    </p>
</div>

</body>
</html>
