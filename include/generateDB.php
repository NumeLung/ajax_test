<?php

require_once "include/config.php";

$db = new Database();

$query = "
SELECT e.*,CONCAT(c.name, \", \", e.Address) AS AddressWithCity  
FROM employees e
LEFT JOIN cities c ON c.id = e.IdCity 
";

if(isset($_POST['search_options'])){
    if($_POST['search_options'] == 'city'){
        if(isset($_POST['search_city_properties']) && !empty($_POST['search_city_properties'])){
            $query .= "WHERE idCity = " . intval($_POST['search_city_properties']);
        }
    } else if($_POST['search_options'] == 'years'){
        if(isset($_POST['search_year_properties']) && $_POST['search_year_properties'] != 'allyears'){
            $query .= "WHERE YEAR(BirthDate) = " . intval($_POST['search_year_properties']);
        }
    } else if($_POST['search_options'] == 'title'){
        if(isset($_POST['search_title_properties']) && $_POST['search_title_properties'] != 'alltitles'){
            $query .= "WHERE Title = '" . mysqli_real_escape_string($db->connection, $_POST['search_title_properties']) . "' ";
        }
    }
}

$employees = $db->select($query);

/*$employees = [];
if (!empty($_POST['search_city_properties'])){
    $employees = $db->select("
    SELECT e.*,CONCAT(c.name, \", \", e.Address) AS AddressWithCity  
    FROM employees e
    LEFT JOIN cities c ON c.id = e.IdCity
    WHERE idCity = " . intval($_POST['search_city_properties']));
}
else {
    $employees = $db->select("
    SELECT e.*,CONCAT(c.name, \", \", e.Address) AS AddressWithCity  
    FROM employees e
    LEFT JOIN cities c ON c.id = e.IdCity");
}*/

$aEmployeesForJS = [];
if(!empty($employees)){
    echo "<table id='result-table'>";
    echo "<thead><tr><th>ID</th><th>Име</th><th>Фамилия</th><th>Работа</th><th>Нарицание</th><th style='padding: 10px;'>Рожд. дата</th><th style='padding: 14px;'>Дата на наемане</th><th>Адрес</th></tr></thead>";
    foreach ($employees as $employee){
        $aEmployeesForJS[$employee["EmployeeID"]] = $employee;
        echo "<tr>";
        echo "<td><a href='javascript:void(0)' onclick='openModal(" . $employee["EmployeeID"] . ")' id='employee_" . $employee["EmployeeID"] . "'>" . $employee["EmployeeID"] . "</a></td>";
        echo "<td>" . htmlentities($employee["FirstName"]) . "</td>";
        echo "<td>" . $employee["LastName"] . "</td>";
        echo "<td>" . $employee["Title"] . "</td>";
        echo "<td>" . $employee["TitleOfCourtesy"];
        echo "<td>" . explode(" ", $employee["BirthDate"])[0] . "</td>";
        echo "<td>" . explode(" ", $employee["HireDate"])[0] . "</td>";
        echo "<td>" . $employee["AddressWithCity"] . "</td>";
        if(!empty($_SESSION["isAdmin"])){
        echo "<td><button onclick='confirmRemove(" . $employee["EmployeeID"] . ")' class=\"removeBttn\">Изтрии</button></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}
else {
    echo "No employees found.";
}

// Close the connection
/*CONN->close();*/
?>

<script>
    var employees = <?= json_encode($aEmployeesForJS,JSON_HEX_TAG); ?>
</script>
