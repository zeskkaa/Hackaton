<?php

session_start();
require_once '../connection/database.php';

$userId = $_SESSION['userId'];

$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['userId'];
$correctAnswersCount = $data['correctAnswersCount'];
$levelId = $data['levelId'];

$userData = "SELECT * FROM users WHERE id = $userId";
$resData = $conn->query($userData);
$result = $resData->fetch_assoc();

if ($result["progress"] < $levelId) {
    if ($correctAnswersCount >= 4) {
        $updateQuery = "UPDATE users SET progress = progress + 1 WHERE id = $userId";
        $resultQuery = $conn->query($updateQuery);
    }
}

// header("Location: ../levels.php");