<?php

require_once "include/include.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

require_once "include/Database.php";
$db = new Database();

//za selekta
$options = $db->select("SELECT id, name FROM cities");
$years = $db->select("SELECT DISTINCT(YEAR(Birthdate)) AS BirthDate FROM employees;");
$titleoptions = $db->select("SELECT DISTINCT(Title) FROM employees ORDER BY Title ASC");
$employeeoptions = $db->select("SELECT EmployeeID, CONCAT(FirstName, ' ',LastName) AS name FROM employees");

$employees = [];
if (!empty($_POST['search_city_properties'])) {
    $employees = $db->select("SELECT * FROM employees WHERE idCity = " . intval($_POST['search_city_properties']));
}
$searchOption = $_POST['search_options'] ?? '';

$query = "
SELECT e.*,CONCAT(c.name, \", \", e.Address) AS AddressWithCity  
FROM employees e
LEFT JOIN cities c ON c.id = e.IdCity 
";
$EmployeesForJS = $db->select($query);
$aEmployeesForJS = [];
?>

<?php
if ($_SESSION["isAdmin"] == 1){
    ?>
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <form id="ModalForm" method="POST" style="margin: 0px;" action="include/add_update_employee.php">
            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <span class="close" id="clearContent">&times;</span>
                    <h2>Добавяне на потербител</h2>
                </div>
                <div class="modal-body">
                    <!--<label>ID</label><br>-->
                    <input type="text" name="inputEmployeeID" id="inputEmployeeID" style="display: none;"><br>
                    <label>Име</label><br>
                    <input type="text" name="inputFirstName" id="inputFirstName"><br>
                    <label>Фамилия</label><br>
                    <input type="text" name="inputLastName" id="inputLastName"><br>
                    <label>Работно място</label><br>
                    <input type="text" name="inputTitle" id="inputTitle"><br>
                    <label>Нарицание</label><br>
                    <input type="text" name="inputTitleOfCourtesy" id="inputTitleOfCourtesy"><br>
                    <label>Рожденна дата</label><br>
                    <input type="text" name="inputBirthDate" id="inputBirthDate" value="YYYY-MM-DD"><br>
                    <label>Дата наемане</label><br>
                    <input type="text" name="inputHireDate" id="inputHireDate" value="YYYY-MM-DD"><br>
                    <label>Адрес</label><br>
                    <input type="text" name="inputAddress" id="inputAddress"><br>
                    <label>Град</label><br>
                    <?php
                    echo "<select id='inputIdCity' style=\"margin-bottom: 20px;\" name='inputIdCity'>";
                    echo "<option value=''>Град</option>";
                    foreach ($options as $option) {
                        $selected = $_POST['search_city_properties'] == $option['id'] ? 'selected' : '';
                        echo "<option $selected value='{$option['id']}'>{$option['name']}</option>";
                    }
                    echo "</select>";
                    ?>
                </div>
                <div class="modal-footer" id="submit_button">
                    <button type="submit" style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Подай</button>
                </div>
            </div>
        </form>
    </div>
    <?php
}
?>

<?php
        if ($_SESSION["isAdmin"] == 1){ ?>
        <div class="container">
            <form method="POST" action="home.php">

                <label for="search_options">Търсене по:</label>
                <select name="search_options" id="search_options" onchange="showCustomer(this.value)">
                    <option value="0">Изберете опция</option>
                    <option value="city" <?= $searchOption == 'city' ? 'selected' : '' ?>>Град</option>
                    <option value="years" <?= $searchOption == 'years' ? 'selected' : '' ?>>Година раждане</option>
                    <option value="title" <?= $searchOption == 'title' ? 'selected' : '' ?>>Длъжност</option>
                    <option value="employee" <?= $searchOption == 'employee' ? 'selected' : '' ?>>Работник</option>
                </select><br>
                <label for="search_properties" id="critlabel" style="display: <?php if(in_array($searchOption, ['city', 'years', 'title'])) { echo "";} else { echo "none";} ?> ">Критерии:</label>
<!--                <label for="search_properties" id="critlabel" style="display: --><?//= in_array($searchOption, ['city', 'years', 'title']) ? "" : "none" ?><!-- ">Критерии:</label>-->
                <select name="search_city_properties" id="search_city_properties" onchange="showCustomer(this.value, 'city')" style="margin-top: 20px; display: <?= $searchOption == 'city' ? '' : 'none' ?> ;" >
                    <option value="0">Всички градове</option>
                        <?php
                        foreach ($options as $option){
                            $selected = $_POST['search_city_properties'] == $option['id'] ? 'selected' : '';
                            echo  "<option $selected value=\"{$option['id']}\">{$option['name']}</option>";
                        }
                        ?>
                </select>
                <select name="search_year_properties" id="search_year_properties" onchange="showCustomer(this.value, 'years')" style="margin-top: 20px; display: <?= $searchOption == 'years' ? '' : 'none' ?> ;">
                    <option value="allyears" style="text-align: center;">Всички години</option>
                    <?php
                    foreach ($years as $yearsoption){
                        $selectedyear = $_POST['search_year_properties'] == $yearsoption['BirthDate'] ? 'selected' : '';
                        echo  "<option $selectedyear value=\"{$yearsoption['BirthDate']}\">{$yearsoption['BirthDate']}</option>";
                    }
                    ?>
                </select>
                <select name="search_title_properties" id="search_title_properties" onchange="showCustomer(this.value, 'title')" style="margin-top: 20px; display: <?= $searchOption == 'title' ? '' : 'none' ?> ;">
                    <option value="alltitles" style="text-align: center;">Изберете титла</option>
                    <?php
                    foreach ($titleoptions as $titleoption){
                        $selectedtitle = $_POST['search_title_properties'] == $titleoption['Title'] ? 'selected' : '';
                        echo  "<option $selectedtitle value=\"{$titleoption['Title']}\">{$titleoption['Title']}</option>";
                    }
                    ?>
                </select>
                <select name="search_employee_properties" id="search_employee_properties" onchange="showCustomer(this.value, 'employee')" style="margin-top: 20px; display: <?= $searchOption == 'employee' ? '' : 'none' ?> ;">
                    <option value="allemployee" style="text-align: center;">Изберете Служител</option>
                    <?php
                    foreach ($employeeoptions as $employeeoption){
                        $selectedemployee = $_POST['search_employee_properties'] == $employeeoption['name'] ? 'selected' : '';
                        echo  "<option $selectedemployee value=\"{$employeeoption['EmployeeID']}\">{$employeeoption['name']}</option>";
                    }
                    ?>
                </select>
                <button type="submit" style="margin-top: 20px;">Подай</button><br>
                <?php
                if ($_SERVER['PHP_SELF'] !== '/home2.php') {
                echo '<button type="button" id="myBtn" style="margin-top: 15px;">Добави потребител</button>';
                }
                ?>
            </form>
        </div>
            <!--funkciq za izvikvane na masiva-->
            <script>
                function showCustomer(value, selectType) {
                    if (value === "") {
                        document.getElementById("result-table").innerHTML = "";
                        return;
                    }
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload = function() {
                        const response = JSON.parse(this.responseText);
                        if (response.error) {
                            document.getElementById("result-table").innerHTML = "Data not found";
                        } else {
                            let tableContent = '';

                            switch (selectType) {
                                case 'employee':
                                    tableContent = response.map(row => `
                        <tr>
                            <td><a href='javascript:void(0)' onclick='openModal(${row.EmployeeID})' id='employee_${row.EmployeeID}'>${row.EmployeeID}</a></td>
                            <td>${row.Name}</td>
                            <td>${row.Title}</td>
                            <td>${row.BirthDate}</td>
                            <td>${row.HireDate}</td>
                            <td>${row.Address}</td>
                        </tr>
                    `).join('');
                                    break;
                                case 'city':
                                    tableContent = response.map(row => `
                        <tr>
                            <td><a href='javascript:void(0)' onclick='openModal(${row.EmployeeID})' id='employee_${row.EmployeeID}'>${row.EmployeeID}</a></td>
                            <td>${row.Name}</td>
                            <td>${row.Title}</td>
                            <td>${row.BirthDate}</td>
                            <td>${row.HireDate}</td>
                            <td>${row.Address}</td>
                        </tr>
                    `).join('');
                                    break;
                                case 'years':
                                    tableContent = response.map(row => `
                        <tr>
                            <td><a href='javascript:void(0)' onclick='openModal(${row.EmployeeID})' id='employee_${row.EmployeeID}'>${row.EmployeeID}</a></td>
                            <td>${row.Name}</td>
                            <td>${row.Title}</td>
                            <td>${row.BirthDate}</td>
                            <td>${row.HireDate}</td>
                            <td>${row.Address}</td>
                        </tr>
                    `).join('');
                                    break;
                                case 'title':
                                    tableContent = response.map(row => `
                        <tr>
                            <td><a href='javascript:void(0)' onclick='openModal(${row.EmployeeID})' id='employee_${row.EmployeeID}'>${row.EmployeeID}</a></td>
                            <td>${row.Name}</td>
                            <td>${row.Title}</td>
                            <td>${row.BirthDate}</td>
                            <td>${row.HireDate}</td>
                            <td>${row.Address}</td>
                        </tr>
                    `).join('');
                                    break;
                                default:
                                    tableContent = "Invalid select type";
                            }

                            document.getElementById("result-table").innerHTML = `
                <table>
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Birth Date</th>
                            <th>Hire Date</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${tableContent}
                    </tbody>
                </table>
            `;
                        }
                    };
                    // Modify the URL based on selectType and value
                    const url = `getdata.php?q=${value}&type=${selectType}`;

                    xhttp.open("GET", url);
                    xhttp.send();
                }
            </script>
            </body>
            </html>
<?php } ?>