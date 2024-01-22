<?php
require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Fasting.php';
require '../../Config/database.php';


$method = $_SERVER['REQUEST_METHOD'];


// start Fast
if ($method == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $fasting = new Fasting($db);

   if (!isset($_POST['fastingId']) || !isset($_POST['endTime'])) {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }

    $result = $fasting->endFast($_POST['fastingId'], $_POST['endTime']);

    if ($result) {
        ResponseHandler::sendResponse(200, "Fast Ended");
    } else {
        ResponseHandler::sendResponse(500, "Unable to end fast");
    }
}