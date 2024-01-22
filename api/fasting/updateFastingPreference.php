<?php
require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Fasting.php';
require '../../Config/database.php';


$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $database = new Database();
    $db = $database->connect();
    $fasting = new Fasting($db);

    if (isset($_GET['userId']) && isset($_GET['fastingPreference'])) {
        $result = $fasting->updateUserFastingPreference($_GET['fastingPreference'], $_GET['userId']);
        if ($result) {
            ResponseHandler::sendResponse(200, "Fasting Preference Updated", $result);
        } else {
            ResponseHandler::sendResponse(500, "Unable to update fasting preference");
        }
    } else {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }
}