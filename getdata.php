<?php

$mysqli = new mysqli("localhost", "root", "", "test");
if ($mysqli->connect_error) {
    exit('Could not connect');
}

$selectType = $_GET['type'];

switch ($selectType) {
    case 'employee':
        $sql = "SELECT EmployeeID, CONCAT(Firstname, \" \", Lastname) AS Name, Title, BirthDate, HireDate, CONCAT(Address, \", \", c.name) AS Address
                FROM employees e
                LEFT JOIN cities c ON c.id = e.IdCity 
                WHERE EmployeeID = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $_GET['q']);
        break;

    case 'city':
        $sql = "SELECT EmployeeID, CONCAT(Firstname, \" \", Lastname) AS Name, Title, BirthDate, HireDate, CONCAT(Address, \", \", c.name) AS Address  
                FROM employees e
                LEFT JOIN cities c ON c.id = e.IdCity 
                WHERE idCity = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $_GET['q']);
        break;

    case 'years':
        $sql = "SELECT EmployeeID, CONCAT(Firstname, \" \", Lastname) AS Name, Title, BirthDate, HireDate, CONCAT(Address, \", \", c.name) AS Address  
                FROM employees e
                LEFT JOIN cities c ON c.id = e.IdCity 
                WHERE YEAR(BirthDate) = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $_GET['q']);
        break;

    case 'title':
        $sql = "SELECT EmployeeID, CONCAT(Firstname, \" \", Lastname) AS Name, Title, BirthDate, HireDate, CONCAT(Address, \", \", c.name) AS Address  
                FROM employees e
                LEFT JOIN cities c ON c.id = e.IdCity 
                WHERE Title = \"?\"";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $_GET['q']);
        break;

    default:
        echo json_encode(["error" => "Invalid select type"]);
        exit;
}

$stmt->execute();
$result = $stmt->get_result();
$rows = [];

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
}

if (!empty($rows)) {
    echo json_encode($rows);
} else {
    echo json_encode(["error" => "Data not found"]);
}

$stmt->close();
$mysqli->close();
?>
