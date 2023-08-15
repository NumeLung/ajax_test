<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $summaryType = $_POST["summary_type"];
    $cityName = $_POST["city_name"];

    // Process the data or perform any action you want based on the selected summary type and city name.
    // For example, you can use these values to query the database again and show specific details related to the selected city.

    // Example: Display the selected city name and summary type.
    echo "Selected Summary Type: " . $summaryType . "<br>";
    echo "Selected City Name: " . $cityName;
}
