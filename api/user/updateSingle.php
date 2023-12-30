<?php
require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Auth.php';
require '../../Config/database.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $database = new Database();
    $db = $database->connect();
    $user = new User($db);
    $field = $_POST['field'];
    $value = $_POST['value'];
    $id = $_POST['id'];
    $updatedAt = $_POST['updatedAt'];

    if ($field == '' || $value == '' || $id == '' || $updatedAt == '') {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }

    $result = $user->updateSingle($field, $value, $id, $updatedAt);

    if ($result) {
        if ($field == 'weight') {
            $weightTrackingResult = $user->updateWeightTracking($id, $value, $updatedAt);
            if ($weightTrackingResult) {
                ResponseHandler::sendResponse(200, "Updated", $result);
            } else {
                ResponseHandler::sendResponse(500, "Unable to update user");
            }
        } else {
            ResponseHandler::sendResponse(200, "Updated", $result);
        }
    } else {
        ResponseHandler::sendResponse(500, "Unable to update user");
    }
} else {

    ResponseHandler::sendResponse(405, "Request Method Not Allowed");
}