<?php
require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Fasting.php';
require '../../Config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $userId = $_POST['userId'];
    $fastingStart = $_POST['fastingStart'];
    $fastingEnd = $_POST['fastingEnd'];

    if ($userId == '' || $fastingStart == '' || $fastingEnd == '') {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }

    $database = new Database();
    $db = $database->connect();
    $fasting = new Fasting($db);

    $result = $fasting->logFast($userId, $fastingStart, $fastingEnd);

    if ($result) {
        ResponseHandler::sendResponse(200, "Fasting Logged", $result);
    } else {
        ResponseHandler::sendResponse(500, "Unable to log fasting");
    }
}