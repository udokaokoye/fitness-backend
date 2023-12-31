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
} else {

    ResponseHandler::sendResponse(405, "Request Method Not Allowed");
}