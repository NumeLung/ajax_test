<?php
require_once "include/include.php";
// Check if the user is logged in as a regular user
if (!isset($_SESSION["username"])) {
    // Redirect to the login page or display an error message
    header("Location: login.html");
    exit();
}
require "include/Database.php";
$db = new Database();
$options = $db->select("SELECT id, name FROM cities");

$employees = [];
if (!empty($_POST['cities'])) {
    $employees = $db->select("SELECT * FROM employees WHERE idCity = " . intval($_POST['cities']));
}
?>
<html>

    <head>
        <title>Admin page</title>
        <link rel="stylesheet" href="include/style.css">
        <script src="include/script.js"></script>
    </head>
    <body>
        <div id="navbar">
            <a href="logout.php">Logout</a>
            <a href="user.php" class="active">User DB Finder</a>
            <?php if (!empty($_SESSION["isAdmin"])){
                echo "<a href=\"home.php\">Admin DB Ramble</a>";
            }
            ?>
            <!-- Debug info
            <p style="text-align: center;">ID на избрания град: <span id="selectedCity"><?php /*=($_POST['cities']??'')*/?></span></p>-->

        </div>
        <div class="container">
            <p style="text-align: center;">
                <?php require_once "include/generateDB.php" ?>
            </p>
        </div>

        <div class="footer" id="footer">
            <p> Made by:
                <a href="https://www.instagram.com/ivaylo.kolev1/" class="insta">Ivaylo Kolev</a>
            </p>
        </div>
    </body>

</html>


