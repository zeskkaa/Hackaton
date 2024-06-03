<!-- Страница администратора -->
<!-- Она нужна, чтобы добавлять примеры -->

<?php

session_start();
require_once 'connection/database.php';

// Получаем id пользователя через сессию
$userId = $_SESSION['userId'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Административная панель</title>
    <link rel="stylesheet" href="styles/header_style.css">
    <link rel="stylesheet" href="styles/admins_style.css">

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
            // Получаем все уровни из БД
            // ВЫБРАТЬ ВСЕ ИЗ таблица
            $queryLevelCount = "SELECT * FROM levels";
            // Выполнить запрос
            $resCount = $conn->query($queryLevelCount);

            // Если заданий больше 0
            if ($resCount->num_rows > 0) {
                // Проходимся по массиву строк
                // Например, строка, где id = 1, level_number = 1, tasks = '1+1???2+2???3+3'
                while ($row = $resCount->fetch_assoc()) {
                    // Выводим начало блока task
                    echo "<div class='task'>";

                    // Выводим блок task_item
                    // Внутри блока выводим текст h3 с текстом row["level_number"] (1) + 1 и закрываем
                    echo "<div class='task_item'><h3>Уровень №" . $row["level_number"] . "</h3></div>";

                    // Разбиваем задачи из строки в массив (тоже самое, что split в python)
                    // Получается что-то типа ['1+1', '2+2', '3+3']
                    $arr = explode("???", $row["tasks"]);

                    // Создаем блок для вывода задач для админа
                    echo "<div class='task_item'>";

                    // Выводим их списком
                    // 1+1
                    // 2+2
                    // 3+3
                    echo "<ul>";
                    foreach ($arr as $key => $value) {
                        echo "<li>$value</li>";
                    }
                    echo "</ul></div>";
                    echo "</div>";
                }
            } else { // Если уровней нет
                echo "<h2>Пока нет уровней</h2>";
            }
        ?>

        <!-- Кнопка добавить задание -->
        <button class="open_form">Добавить задание</button>

        <!-- Форма добавления заданий для уровня -->
        <form action="inserts/insert_task.php" class="task_add" method="POST">
            <?php
                echo "<h3>Добавить уровень № " . $resCount->num_rows + 1 . "</h3>";
                // Выводим 6 input
                for ($i = 1; $i < 7; $i++) {
                    echo "<div class='form_field'>";
                    echo "<label for='task$i'>Пример № $i</label>";
                    echo "<input type='text' name='task$i' class='field' id='task$i' placeholder='Пример №$i' required>";
                    echo "</div>";
                }
                echo "<input type='hidden' name='level' value='" . $resCount->num_rows + 1 . "'>"
            ?>
            <input type="submit" value="Добавить" id="add_btn">
        </form>
    </div>

    <!-- Подключение JavaScript асинхронно -->
    <script src="scripts/admin_script.js" defer></script>
</body>
</html>