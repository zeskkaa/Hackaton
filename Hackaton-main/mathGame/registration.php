<?php

// Запускаем сессию, чтобы передавать id по файлам
session_start();
// Подключение к базе данных
require_once 'connection/database.php';

// Переменные для проверки на наличие данных
$has_login = false;
$has_mail = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из формы
    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['mail'];
    $password = $_POST['password'];

    // Если галочка поставлена (равна "on"), то перемененная будет 1, иначе 0
    if ($_POST["mailing"] == "on") {
        $mailing = 1;
    } else {
        $mailing = 0;
    }

    // Проверка на наличие пользователя по логину
    $sqlLogin = "SELECT * FROM users WHERE login = '$login'";
    $checkerLogin = $conn->query($sqlLogin);

    if ($checkerLogin->num_rows > 0) {
        $has_login = true;
    } else {
        $has_login = false;
    }

    // Проверка на наличие пользователя по почте
    $sqlMail = "SELECT * FROM users WHERE email = '$email'";
    $checkerMail = $conn->query($sqlMail);

    if ($checkerMail->num_rows > 0) {
        $has_mail = true;
    } else {
        $has_mail = false;
    }

    // Если ничего не занято, закодировать данные и отправить
    if (!$has_login && !$has_mail) {
        $login = htmlspecialchars($login);
        $password = password_hash(htmlspecialchars($password), PASSWORD_DEFAULT);
        $email = htmlspecialchars($email);
        $sql = "INSERT INTO users (name, login, password, email, mailing) VALUES ('$name', '$login', '$password', '$email', '$mailing')";
        $result = $conn->query($sql);
        header("Location: login.php");
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="styles/auth_style.css">

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
        <h1>Регистрация</h1>
        <form action="#" method="post" class="reg_form" onchange="changeDisabled()">
            <div class="form_field">
                <label for="name">Введите имя</label>
                <input type="text" name="name" id="name_input" class="field" placeholder="Имя..." required onchange="checkCorrect()">
            </div>
            <div class="form_field">
                <label for="login">Введите логин</label>
                <input type="text" name="login" id="login_input" class="field" placeholder="Логин..." required onchange="checkCorrect()">
            </div>
            <div class="form_field">
                <label for="mail">Введите email</label>
                <input type="email" name="mail" id="mail_input" class="field" placeholder="nick@domen.reg" required onchange="checkCorrect()">
            </div>
            <div class="form_field">
                <label for="password">Введите пароль</label>
                <input type="password" name="password" id="password_input" class="field" placeholder="Пароль..." required onchange="checkCorrect()">
            </div>
            <div class="form_field">
                <label for="confirm_password">Подтвердите пароль</label>
                <input type="password" name="confirm_password" id="confirm_password_input" class="field" placeholder="Пароль..." required onchange="checkCorrect()">
            </div>
            <div class="checkbox_form_field">
                <input type="checkbox" name="mailing" id="mailing_input">
                <label for="mailing">Я хочу получать <a href="#" class="mailing_link">рассылку</a></label>
            </div>
            <input type="submit" value="Регистрация" id="register_btn" disabled>
        </form>
        <p class="question">Уже есть аккаунт?<br><a href="login.php" class="enter_link">Войти</a></p>
        <?php
            if ($has_login && !$has_mail) {
                echo "<p class='have_acc'>Аккаунт с таким логином уже есть!</p>";
            } else if (!$has_login && $has_mail) {
                echo "<p class='have_acc'>Аккаунт с такой почтой уже есть!</p>";
            } else if ($has_login && $has_mail) {
                echo "<p class='have_acc'>Логин и почта уже заняты!</p>";
            }
        ?>
    </div>

    <script src="scripts/forms.js"></script>
</body>
</html>