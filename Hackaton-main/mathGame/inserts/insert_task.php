<?php

session_start();
require_once "../connection/database.php";

$userId = $_SESSION['userId'];

// Массив с примерами
$taskArr = array();

// Заполняем его
for ($i = 1; $i < 7; $i++) {
    $taskArr[] = $_POST["task$i"];
}

$getTaskCount = "SELECT * FROM levels";
$resultCount = $conn->query($getTaskCount);
$levelNum = $resultCount->num_rows + 1;


// Примеры преображаем в строку (тоже самое, что в питоне join)
$result_tasks = implode("???", $taskArr);

// Вставка в БД
// Вставить в ТАБЛИЦА (колонка1, колонка2) ЗНАЧЕНИЯ ('значение1', 'значение2')
$insertQuery = "INSERT INTO levels (level_number, tasks) VALUES ($levelNum, '$result_tasks')";
$resultInsert = $conn->query($insertQuery);

header("Location: ../admin_panel.php");