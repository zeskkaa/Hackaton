<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link rel="stylesheet" href="styles/header_style.css">
    <link rel="stylesheet" href="styles/index_style.css">

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
        <a href="index.php" class="logo_link">
            <img src="images/LOGOTYPE.svg" alt="Логотип сервиса" class="logo_image">
        </a>
        <a href="login.php" class="profile_link">
            <img src="images/profile.svg" alt="Личный кабинет" class="profile_image">
        </a>
    </header>
    <div class="info_container">
        <img src="images/mathGame.svg" alt="Название игры" class="name_of_game_image">
        <a href="registration.php" class="start_button">Начать</a>
    </div>
    <div class="about_container">
        <div class="text_about_us">
            <p class="describe_us_text">Немного о нашей игре</p>
            <h1>О нас</h1>
            <img src="images/line_about_us.svg" alt="Линия для обводки">
            <p class="full_describe_text">Добро пожаловать на <b>SolveItMath</b> – увлекательную математическую игру, которая бросает вызов вашему разуму и помогает улучшить математические навыки!<br>Наша цель – сделать обучение математике интересным и захватывающим процессом для всех возрастов.</p>
        </div>

        <div class="opportunities_container">
            <div class="opp_container">
                <h3>Возможности</h3>
                <div class="opp_needed_container study">
                    <img src="images/study.svg" alt="Логотип обучения" class="opp_image">
                    <p class="opp_text">Обучение</p>
                </div>
                <div class="opp_needed_container game">
                    <img src="images/game.svg" alt="Логотип игры" class="opp_image">
                    <p class="opp_text">Игровая форма</p>
                </div>
                <div class="opp_needed_container progress">
                    <img src="images/progressBar.svg" alt="Логотип прогресса" class="opp_image">
                    <p class="opp_text">Прогресс</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>