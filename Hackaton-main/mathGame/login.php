<?php

// Запускаем сессию, чтобы передавать id по файлам
session_start();
// Подключение к базе данных
require_once 'connection/database.php';

// Переменная на случай ошибки
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = htmlspecialchars($_POST["login"]);
    $password = htmlspecialchars($_POST["password"]);

    $sql = "SELECT * FROM users WHERE login = '$login' OR email = '$login'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            $_SESSION['userId'] = $row["id"];
            header("Location: levels.php");
            exit;
        } else {
            $error = "Неверное имя пользователя или пароль";
        }
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="styles/auth.css">

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
    <div class="container">
        <h1 class="header_text">Авторизация</h1>

        <form action="" method="post" class="auth_form">
            <div class="form_field">
                <label for="login">Введите логин</label>
                <input type="text" name="login" id="login_input" placeholder="Логин или адрес электронной почты...">
            </div>
            <div class="form_field">
                <label for="password">Введите пароль</label>
                <input type="password" name="password" id="password_input" placeholder="Пароль...">
            </div>
            <div class="checkbox_form_field">
                <input type="checkbox" name="remember_me" id="remember_me_input">
                <label for="remember_me">Запомнить меня</label>
            </div>
            <input type="submit" value="Вход" id="login_btn">
        </form>

        <p class="question">Еще нет аккаунта?<br><a href="registration.php" class="reg_link">Регистрация</a></p>
        <p class="have_acc"><?=$error?></p>
    </div>
</body>
</html>