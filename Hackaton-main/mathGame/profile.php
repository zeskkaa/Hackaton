<?php

session_start();
require_once 'connection/database.php';

$userId = $_SESSION['userId'];

// Получаем данные пользователя из БД
$getInfo = "SELECT * FROM users WHERE id = $userId";
$resultInfo = $conn->query($getInfo);
$resultArr = $resultInfo->fetch_assoc();

// Получаем данные о уровнях
$taskCountQuery = "SELECT * FROM levels";
$resultCount = $conn->query($taskCountQuery);

// 
if ($resultCount->num_rows > 0) {
    $percent = 100 / $resultCount->num_rows;
    $progress = intval($resultArr["progress"]) * $percent;
} else {
    $progress = 0;
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="styles/header_style.css">
    <link rel="stylesheet" href="styles/profile.css">

    <!-- Lexend Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="empty_container"></div>
        <a href="levels.php" class="logo_link">
            <img src="images/LOGOTYPE.svg" alt="Логотип сервиса" class="logo_image">
        </a>
        <a href="profile.php" class="profile_link">
            <img src="images/profile.svg" alt="Личный кабинет" class="profile_image">
        </a>
    </header>
    <div class="info_container">
        <?php
            echo "<h1>Привет, " . $resultArr["name"] . "!</h1>";
            echo "<h3 class='ty'>Спасибо, что ты с нами:)<h3>";
            echo "<h3>Твой прогресс составляет: $progress%</h3>";
        ?>
    </div>
    <div class="logout">
        <a href="logout.php">Выйти</a>
    </div>
</body>
</html>