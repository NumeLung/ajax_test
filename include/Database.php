<?php

class Database
{
    public $connection;
    public function __construct() {

        $this->connection = mysqli_connect(HOST, DBUSER, DBPASS, DBNAME);
        if (!$this->connection) {
            die('Грешка при свързване с базата данни: ' . mysqli_connect_error());
        }
    }

    public function select($query) {
        $result = mysqli_query($this->connection, $query);

        if (!$result) {
            die('Грешка при изпълнение на заявката: ' . mysqli_error($this->connection));
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }

        return $data;
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }
}