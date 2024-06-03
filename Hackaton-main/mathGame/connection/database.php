<?php

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "solveitmath";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Ошибка подключения к БД: " . $conn->connect_error);
}
