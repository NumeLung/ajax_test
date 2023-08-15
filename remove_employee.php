<?php
require "include/include.php";

if (!isset($_SESSION["username"]) || empty($_SESSION["isAdmin"])) {
    header("Location: login.html");
    exit();
}

require "include/Database.php";
$db = new Database();

if(isset($_GET['id'])) {
    $userID = $_GET['id'];
    // Prepare and execute the SQL query to delete the row
    $stmt = $db->connection->prepare("DELETE FROM employeeterritories WHERE EmployeeID = ?");
    $stmt->execute([$userID]);

    $stmt = $db->connection->prepare("
    DELETE FROM orderdetails WHERE orderid IN(SELECT orderid FROM orders WHERE employeeid = ?);");
    $stmt->execute([$userID]);

    $stmt = $db->connection->prepare("DELETE FROM orders WHERE EmployeeID = ?");
    $stmt->execute([$userID]);

    $stmt = $db->connection->prepare("DELETE FROM employees WHERE EmployeeID = ?");
    $stmt->execute([$userID]);

    // Check if the row was successfully deleted
    if ($stmt->affected_rows > 0) {
         echo "Row with UserID $userID has been deleted successfully.";
         header("Location: home.php" /*. $_GET['IdCity']*/);
    } else {
        echo "No row found with UserID $userID.";
    }
} else {
    echo "Invalid request.";
}
?>