<?php
require_once "include/config.php";

if (isset($_POST['summary'])){

$db = new Database();
$summary = [];


switch ($_POST['summary']){
    case "city":
        $summary = $db->select("
        SELECT  c.name AS CityName, COUNT(e.IdCity) empcount, c.id AS idCity,
        CASE
            WHEN LENGTH(CONCAT(GROUP_CONCAT(' ', e.FirstName))) > 100
            THEN CONCAT(LEFT(CONCAT(GROUP_CONCAT(' ', e.FirstName)), 100), '...')
            ELSE CONCAT(GROUP_CONCAT(' ', e.FirstName))
        END AS ConcatenatedNames
        FROM employees e
        JOIN cities c ON e.IdCity = c.id
        GROUP BY e.IdCity
        ");
        echo "<table>";
        echo "<tr><th>Град</th><th>Брой Хора</th><th>Имена</th>";
        foreach ($summary as $row) {
            /*$aEmployeesForJS[$employee["EmployeeID"]] = $employee;*/
            echo "<tr>";
            echo "<td>" . $row["CityName"] . "</td>";
            echo "<td>" . $row["empcount"] . "</td>";
            echo "<td>" . $row["ConcatenatedNames"] . "</td>";
            echo "<td>";
            // Form to send data to load_summary.php
            echo "<form method=\"POST\" action=\"home.php\" style=\"margin: 0px\"'>";
            echo "<input type=\"hidden\" name=\"search_options\" value=\"city\">";
            echo "<input type=\"hidden\" name=\"search_city_properties\" value=\"" . $row["idCity"] . "\">";
            echo "<button class=\"showBttn\" onclick=\"submitForm(this.form)\">Покажи</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        break;

    case "years":
        $summary = $db->select("
        SELECT
        YEAR(BirthDate) AS YearOfBirth,
        COUNT(*) AS EmployeeCount,
        CASE
            WHEN LENGTH(CONCAT(GROUP_CONCAT(' ', FirstName))) > 100
            THEN CONCAT(LEFT(CONCAT(GROUP_CONCAT(' ', FirstName)), 100), '...')
            ELSE CONCAT(GROUP_CONCAT(' ', FirstName))
            END AS ConcatenatedNames
        FROM employees
        GROUP BY YearOfBirth
        ORDER BY YearOfBirth ASC;
        ");
        echo "<table>";
        echo "<tr><th>Нарицание</th><th>Брой Хора</th><th>Имена</th>";
        foreach ($summary as $row) {
            /*$aEmployeesForJS[$employee["EmployeeID"]] = $employee;*/
            echo "<tr>";
            /*echo "<td><a href='javascript:void(0)' onclick='openModal(" . $employee["EmployeeID"] . ")' id='employee_" . $employee["EmployeeID"] . "'>" . $employee["EmployeeID"] . "</a></td>";*/
            echo "<td>" . $row["YearOfBirth"] . "</td>";
            echo "<td>" . $row["EmployeeCount"] . "</td>";
            echo "<td>" . $row["ConcatenatedNames"] . "</td>";
            echo "<td>";
            // Form to send data to load_summary.php
            echo "<form method=\"POST\" action=\"home.php\" style=\"margin: 0px\">";
            echo "<input type=\"hidden\" name=\"search_options\" value=\"years\">";
            echo "<input type=\"hidden\" name=\"search_year_properties\" value=\"" . $row["YearOfBirth"] . "\">";
            echo "<button class=\"showBttn\" onclick=\"submitForm(this.form)\">Покажи</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        break;

    case "title":
        $summary = $db->select("
        SELECT
        Title,
        COUNT(*) AS EmployeeCount,
        CASE
        WHEN LENGTH(CONCAT(GROUP_CONCAT(' ', FirstName))) > 100
        THEN CONCAT(LEFT(CONCAT(GROUP_CONCAT(' ', FirstName)), 100), '...')
        ELSE CONCAT(GROUP_CONCAT(' ', FirstName))
        END AS ConcatenatedNames
        FROM employees
        GROUP BY Title        
        ");
        echo "<table>";
        echo "<tr><th>Работа</th><th>Брой Хора</th><th>Имена</th>";
        foreach ($summary as $row) {
            /*$aEmployeesForJS[$employee["EmployeeID"]] = $employee;*/
            echo "<tr>";
            /*echo "<td><a href='javascript:void(0)' onclick='openModal(" . $employee["EmployeeID"] . ")' id='employee_" . $employee["EmployeeID"] . "'>" . $employee["EmployeeID"] . "</a></td>";*/
            echo "<td>" . $row["Title"] . "</td>";
            echo "<td>" . $row["EmployeeCount"] . "</td>";
            echo "<td>" . $row["ConcatenatedNames"] . "</td>";
            echo "<td>";
            // Form to send data to load_summary.php
            echo "<form method=\"POST\" action=\"home.php\" style=\"margin: 0px\">";
            echo "<input type=\"hidden\" name=\"search_options\" value=\"title\">";
            echo "<input type=\"hidden\" name=\"search_title_properties\" value=\"" . $row["Title"] . "\">";
            echo "<button class=\"showBttn\" onclick=\"submitForm(this.form)\">Покажи</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        break;
}
} else {
    echo "";
}
?>
<script>
    function submitForm(form) {
        form.submit();
    }
</script>