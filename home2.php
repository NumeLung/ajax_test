<?php

require_once "include/include.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require_once "include/Database.php";
$db = new Database();
$options = $db->select("SELECT id, name FROM cities");

$summaryOption = $_POST['summary'] ?? '';
?>

<html>
    <head>
        <title>Home page</title>
        <link rel="stylesheet" href="include/style.css">
        <script src="include/script.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body>

        <div id="navbar">
            <a href="logout.php">Logout</a>
            <a href="home2.php" class="active">Home</a>
        </div>

        <?php
        if ($_SESSION["isAdmin"] == 1){ ?>
        <div style="width: 50%; float: left;">
            <form method="POST">
                <label for="summary">Тип</label>
                <select name="summary">
                    <option value="0">Избери</option>
                    <option value="city" <?= $summaryOption ?> >Град</option>
                    <option value="years">Година</option>
                    <option value="title">Работа</option>
                    <option value="employee">Работник</option>
                </select><br>
                <button style="margin-top: 20px">Обобщи</button><br>
            </form>
        </div>
        <?php } ?>

        <?php
        if ($_SESSION["isAdmin"] == 1){
            include "podrobna.php";
        } ?>

        <div class="container">
            <p style="text-align: center;">
                <?php
                require_once "include/summary.php"
                ?>
            </p>
        </div>

        <div class="footer" id="footer">
            <p> Made by:
                <a href="https://www.instagram.com/ivaylo.kolev1/" class="insta">Ivaylo Kolev</a>
            </p>
        </div>

    </body>
</html>
