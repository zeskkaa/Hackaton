<?php

session_start();
require_once 'connection/database.php';

$userId = $_SESSION['userId'];

function getTaskType($elem) {
    $type = '';
    if (stripos($elem, "cos") !== false || stripos($elem, "sin") !== false || stripos($elem, "tg") !== false || stripos($elem, "ctg") !== false) {
        $type = 'geometry';
    } else {
        if (stripos($elem, "log") !== false) {
            $type = 'log';
        } else {
            if (stripos($elem, "^") !== false) {
                $type = 'degree';
            } else {
                if (stripos($elem, "/") !== false) {
                    $type = 'fraction';
                } else {
                    if (stripos($elem, ":") !== false) {
                        $type = 'typicalDefault';
                    } else {
                        $type = 'default';
                    }
                }
            }
        }
    }
    return $type;
}

function getTextFromLog($text, $symbol) {
    $text = explode($symbol, $text);
    for ($i = 0; $i < count($text); $i++) {
        if (substr_count($text[$i], " ") > 0) {
            $needed = explode(" ", $text[$i]);
            for ($j = 0; $j < count($needed); $j++) {
                if (substr_count($needed[$j], "Math.log") == 0) {
                    $needed[$j] = "Math.log(" . $needed[$j] . ")";
                }
            }
            $text[$i] = implode(" / ", array_reverse($needed));
        }
    }
    $text = implode(" * ", $text);

    return $text;
}

function getDefaultExample($elem) {
    if ((stripos($elem, '+') !== false || stripos($elem, '-') !== false || stripos($elem, '*') !== false || stripos($elem, ':') !== false) && substr_count($elem, 'log') == 0 && substr_count($elem, 'cos') == 0 && substr_count($elem, 'sin') == 0 && substr_count($elem, 'tg') == 0 && substr_count($elem, 'ctg') == 0) {
        $modified_string = str_replace(['+', '-', '*', ':'], [' + ', ' - ', ' * ', ' / '], $elem);
    } else if (stripos($elem, '/') !== false) {
        if (stripos($elem, 'cos') !== false || stripos($elem, 'sin') !== false || stripos($elem, 'tg') !== false || stripos($elem, 'ctg') !== false) {
            $modified_string = explode(" ", $elem);
            if (in_array('pi', explode("/", $modified_string[1]))) {
                if (stripos($elem, 'cos') !== false) {
                    $modified_string = 'Math.cos(Math.PI/' . explode("/", $modified_string[1])[1] . ")";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                } else if (stripos($elem, 'sin') !== false) {
                    $modified_string = 'Math.sin(Math.PI/' . explode("/", $modified_string[1])[1] . ")";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                } else if (stripos($elem, 'tg') !== false) {
                    $modified_string = 'Math.tan(Math.PI/' . explode("/", $modified_string[1])[1] . ")";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                } else if (stripos($elem, 'ctg') !== false) {
                    $modified_string = '1 / Math.tan(Math.PI/' . explode("/", $modified_string[1])[1] . ")";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                }
                
            } else {
                if (stripos($elem, 'cos') !== false) {
                    $modified_string = 'Math.cos("' . $modified_string[1] . "')";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                } else if (stripos($elem, 'sin') !== false) {
                    $modified_string = 'Math.sin("' . $modified_string[1] . '")';
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                } else if (stripos($elem, 'tg') !== false) {
                    $modified_string = 'Math.tan("' . $modified_string[1] . "')";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                } else if (stripos($elem, 'ctg') !== false) {
                    $modified_string = '1 / Math.tan("' . $modified_string[1] . "')";
                    if (stripos($modified_string, 'sqrt') !== false) {
                        $modified_string = str_replace('sqrt', 'Math.sqrt', $modified_string);
                    }
                }
            }
        } else {
            $modified_string = str_replace('/', ' / ', $elem);
        }
    } else if (stripos($elem, '^') !== false) {
        $modified_string = str_replace('^', ' ** ', $elem);
    } else if (stripos($elem, 'log') !== false) {
        if (substr_count($elem, 'log') > 1) {
            $modified_string = str_replace("log", "Math.log", $elem);
            if (substr_count($modified_string, '+') > 0) {
                $modified_string = getTextFromLog($modified_string, ' + ');
            } else if (substr_count($modified_string, '*') > 0) {
                $modified_string = getTextFromLog($modified_string, ' * ');
                $modified_string = array_reverse(explode(" * ", $modified_string));
                $modified_string[0] = "Math.log(" . $modified_string[0] . ")";
                $modified_string = implode(" / ", $modified_string);
            } else if (substr_count($modified_string, '-') > 0) {
                $modified_string = getTextFromLog($modified_string, ' - ');
            } else if (substr_count($modified_string, ':') > 0) {
                $modified_string = getTextFromLog($modified_string, ' : ');
            }
        } else {
            if (substr_count($elem, 'x') == 0) {
                $modified_string = str_replace("log", "Math.log", $elem);
                $modified_string = explode(" ", $modified_string);
                $modified_string = array_reverse($modified_string);
                $modified_string[0] = "Math.log(" . $modified_string[0] . ")";
                $modified_string = implode(" / ", $modified_string);
            } else {
                $modified_string = explode(" = ", $elem);
                $regex = "/\(([^)]+)\)/";
                if (preg_match($regex, $modified_string[0], $matches)) {
                    $modified_string = $matches[1] . " ** " . $modified_string[1];
                }
            }
        }
    } else if (stripos($elem, 'deg') !== false) {
        $modified_string = explode(" ", $elem);
        $modified_string[1] = str_replace("deg", "", $modified_string[1]);
        $degree = intval($modified_string[1]) * (M_PI / 180);
        $modified_string = "Math.sin(" . $degree . ")";
    }
    return $modified_string;
}

if (isset($_GET['lvl'])) {
    // Получаем id задания, которое передаем ссылкой из файла levels на 78 строке
    // <a href="ссылка?lvl=id">
    $lvlId = $_GET['lvl'];
    
    // Выбираем это задание
    // Выбрать все задания из таблицы levels где level_number=id
    $getLevelTasks = "SELECT * FROM levels WHERE level_number=$lvlId";
    $resultTasks = $conn->query($getLevelTasks);

    $getUserInfo = "SELECT * FROM users WHERE id=$userId";
    $res = $conn->query($getUserInfo);
    $rest = $res->fetch_assoc();

    // Берем из массива только столбец tasks
    $tasks = $resultTasks->fetch_assoc()["tasks"];
    // Преобразовываем в массив
    $arr = explode("???", $tasks);
    $tasksForShow = array();
    $types = '';

    foreach ($arr as $key => $val) {
        if (getTaskType($val) == 'default' || getTaskType($val) == 'typicalDefault') {
            $tasksForShow[] = getDefaultExample($val);
            $types = 'default';
        } else if (getTaskType($val) == 'fraction') {
            $tasksForShow[] = getDefaultExample($val);
            $types = 'fraction';
        } else if (getTaskType($val) == 'degree') {
            $tasksForShow[] = getDefaultExample($val);
            $types = 'degree';
        } else if (getTaskType($val) == 'log') {
            $tasksForShow[] = getDefaultExample($val);
            $types = 'log';
        } else if (getTaskType($val) == 'geometry') {
            $tasksForShow[] = getDefaultExample($val);
            $types = 'geometry';
        }
    }

    $tasksForShow_json = json_encode($tasksForShow);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
        echo "<title>Уровень № $lvlId</title>"
    ?>
    <link rel="stylesheet" href="styles/header_style.css">
    <link rel="stylesheet" href="styles/task_style.css">

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

    <?php if ($lvlId > $rest["progress"]): ?>
        <div class="info_container">
            <?php
                echo "<h1>Уровень $lvlId</h1>";

                if ($lvlId == '1') {
                    echo "<p>Сумма, разница, произведение, частное</p>";
                }
            ?>
        </div>
        <div id="quiz-container">
            <h1>Пример</h1>
            <div id="question"></div>
            <div id="answers">
                <button onclick="checkAnswer(0)">A</button>
                <button onclick="checkAnswer(1)">B</button>
                <button onclick="checkAnswer(2)">C</button>
                <button onclick="checkAnswer(3)">D</button>
            </div>
            <div id="feedback"></div>
            <button id="next-question" onclick="nextQuestion()">Следующий вопрос</button>
        </div>
        <script>
            const questions = <?php echo $tasksForShow_json; ?>;
            const userId = <?php echo $userId; ?>;
            const levelId = <?php echo $lvlId; ?>;

            console.log(questions);

            let currentQuestionIndex = 0;
            let correctAnswersCount = 0;

            function createFormula(logExpression) {
                // Создаем регулярное выражение для извлечения чисел
                let innerMatch = logExpression.match(/Math\.log\((\d+)\) \/ Math\.log\((\d+)\)/);
                if (innerMatch) {
                    let baseInner = innerMatch[2];
                    let valueInner = innerMatch[1];

                    // Формируем внутреннюю часть формулы
                    let innerLog = `log<sub>${baseInner}</sub>(${valueInner})`;

                    // Изменяем основание внешнего логарифма на 3
                    let outerLog = `log<sub>3</sub>(${innerLog})`;

                    return outerLog;
                }
                return 'Формула не распознана';
            }

            function showQuestion() {
                const currentQuestion = questions[currentQuestionIndex];
                let displayedText = currentQuestion;

                if (currentQuestion.includes('/')) {
                    if (!currentQuestion.includes('Math.log')) {
                        if (!currentQuestion.includes('sin') && !currentQuestion.includes('cos'))
                        displayedText = currentQuestion.replace('/', ':');
                    } else {
                        const arr = currentQuestion.split(" / ");
                        if (arr.length == 2) {
                            let numerator = arr[0].match(/Math\.log\((\d+)\)/)[1];
                            let denominator = arr[1].match(/Math\.log\((\d+)\)/)[1];
                            displayedText = `log<sub>${denominator}</sub>(${numerator})`;
                        } else if (arr.length > 2) {
                            displayedText = createFormula(currentQuestion);
                        }
                    }
                } else if (currentQuestion.includes('**')) {
                    if (!questions[0].includes('Math.log')) {
                        displayedText = currentQuestion.replace('**', '^');
                    } else {
                        const arr =currentQuestion.split(" ** ");
                        displayedText = "log<sub>" + arr[0] + "</sub> x = " + arr[1];
                    }
                } 

                document.getElementById('question').innerHTML = displayedText;
                let correctAnswer = eval(currentQuestion);

                if (questions[0].includes('/')) {
                    correctAnswer = parseFloat(eval(currentQuestion).toFixed(2));
                }

                const answers = generateAnswers(correctAnswer);

                const buttons =document.querySelectorAll('#answers button');
                for (let i = 0; i < buttons.length; i++) {
                    buttons[i].innerText = answers[i];
                }

                document.getElementById('feedback').innerText = '';
            }

            function generateAnswers(correctAnswer) {
                let answers = [correctAnswer];
                while (answers.length < 4) {
                    let randomAnswer = Math.floor(Math.random() * 30);

                    if (questions[0].includes('/')) {
                        randomAnswer = parseFloat((Math.random() * 30).toFixed(2));
                    }

                    if (!answers.includes(randomAnswer)) {
                        answers.push(randomAnswer);
                    }
                }
                return answers.sort(() => Math.random() - 0.5);
            }

            function checkAnswer(index) {
                const buttons = document.querySelectorAll('#answers button');
                let userAnswer = parseInt(buttons[index].innerText);
                let correctAnswer = eval(questions[currentQuestionIndex]);

                if (questions[0].includes('/')) {
                    userAnswer = parseFloat(buttons[index].innerText);
                    correctAnswer = parseFloat(eval(questions[currentQuestionIndex]).toFixed(2));
                }

                if (userAnswer === correctAnswer) {
                    document.getElementById('feedback').innerText = 'Верно!';
                    correctAnswersCount++;
                } else {
                    document.getElementById('feedback').innerText = 'Ошибка:(';
                }
            }

            function nextQuestion() {
                currentQuestionIndex++;
                if (currentQuestionIndex < questions.length) {
                    showQuestion();
                } else {
                    endQuiz();
                }
            }

            function endQuiz() {
                if (correctAnswersCount > 4) {
                    document.getElementById('quiz-container').innerHTML = 'Вопросы решены верно! Поздравляем!';
                    sendResultsToServer();
                } else {
                    document.getElementById('quiz-container').innerHTML = 'Вопросы решены неверно, попробуйте еще раз:(';
                }
            }

            function sendResultsToServer() {
                const xhr = new XMLHttpRequest();
                xhr.open("POST", "inserts/save_results.php", true);
                xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        console.log(xhr.responseText);
                    }
                };
                const data = JSON.stringify({ userId: userId, correctAnswersCount: correctAnswersCount, levelId: levelId });
                xhr.send(data);
            }

            showQuestion();
        </script>
    <?php else: ?>
        <div class="info_container">
            <?php
                echo "<h1>Уровень $lvlId</h1>";

                if ($lvlId == '1') {
                    echo "<p>Сумма, разница, произведение, частное</p>";
                }
            ?>
        </div>
        <h3 class="info">Вы уже закончили этот уровень</h3>
        <a href="levels.php" class="info back_link">Вернуться назад</a>
    <?php endif; ?>
</body>
</html>