<?php
require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Fasting.php';
require '../../Config/database.php';


$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $userId = isset($_GET['userId']) ? $_GET['userId'] : null;

    if ($userId) {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }

    $database = new Database();
    $db = $database->connect();
    $fasting = new Fasting($db);

    $result = $fasting->getFasts($userId);

    if ($result) {
        ResponseHandler::sendResponse(200, "Fasts Retrieved", $result);
    } else {
        ResponseHandler::sendResponse(500, "Unable to retrieve fasts");
    }
} 

if ($method == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $fasting = new Fasting($db);

   if (!isset($_POST['userId']) || !isset($_POST['fastingStart']) || !isset($_POST['fastingEnd'])) {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }

    $result = $fasting->logFast($_POST['userId'], $_POST['fastingStart'], $_POST['fastingEnd']);

    if ($result) {
        ResponseHandler::sendResponse(200, "Fast Logged");
    } else {
        ResponseHandler::sendResponse(500, "Unable to log fast");
    }

    if ($result) {
        ResponseHandler::sendResponse(200, "Fast Logged", $result);
    } else {
        ResponseHandler::sendResponse(500, "Unable to log fast");
    }
}