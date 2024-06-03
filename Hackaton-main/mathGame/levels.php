<?php

session_start();
require_once 'connection/database.php';

if ($_SESSION['userId']) {
    $userId = $_SESSION['userId'];

    // Если id администратора, то кинем его на страницу, где можно добавить задания
    if ($userId == 1) {
        header("Location: admin_panel.php");
    }
    
    // Получаем данные о пользователе
    $userDataQuery = "SELECT * FROM users WHERE id = $userId";
    $resultUserData = $conn->query($userDataQuery);
    $userData = $resultUserData->fetch_assoc();
} else {
    header("Location: logout.php");
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Игра SolveItMath</title>
    <link rel="stylesheet" href="styles/header_style.css">
    <link rel="stylesheet" href="styles/levels_style.css">

    <!-- Lexend Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&family=Lexend:wght@100..900&display=swap" rel="stylesheet">

    <script src="scripts/health.js"></script>
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
        <div class="empty_container"></div>
        <div class="level_describe_container">
            <h1>Уровень 1</h1>
            <p>Сумма, разница, произведение, частное</p>
        </div>
        <div class="empty_container"></div>

        <div class="empty_container"></div>
        <div class="start_container">
            <a href="#ft" class="start_button">Начать</a>
        </div>
    </div>
    <div class="levels_container">
        <h1 id="hd">Уровни</h1>
        <div class="levels_buttons">
            <?php
                // Делаем запрос на количество уровней
                $taskCountQuery = "SELECT * FROM levels";
                $resultCount = $conn->query($taskCountQuery);

                $percent = $resultCount->num_rows;
                $currentProgress = intval($userData["progress"]);

                if ($resultCount->num_rows > 0) {
                    $i = 1;
                    while ($row = $resultCount->fetch_assoc()) {
                        if ($row["level_number"] == $currentProgress + 1 || $row["level_number"] <= $currentProgress) {
                            echo '<a href="task.php?lvl=' . $row["level_number"] . '" class="lnk">';
                            echo '<div class="level' . $row["level_number"] . '_container lvl_cont" id="ft">';
                            echo '<img src="images/level1.svg" alt="Уровень ' . $row["level_number"] . '">';
                            echo '<div class="describe_level">';
                            echo '<h3>Уровень ' . $row["level_number"] . '</h3>';
                            echo '<p>Базовые примеры</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</a>';
                        } else {
                            echo '<div class="level' . $row["level_number"] . '_container blocked">';
                            echo '<img src="images/padlogDark.svg" alt="Иконка блокировки">';
                            echo '<div class="describe_level">';
                            echo '<h3>Уровень ' . $row["level_number"] . '</h3>';
                            echo '<p>Недоступно</p>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            ?>
        </div>
    </div>
</body>
</html>