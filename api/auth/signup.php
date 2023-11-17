<?php

require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Auth.php';
require '../../Config/database.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    if (!isset($_POST['firstName']) || !isset($_POST['lastName']) || !isset($_POST['email']) || !isset($_POST['password']) || !isset($_POST['caloriesGoal']) || !isset($_POST['createdAt'])) {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }
    $database = new Database();
    $db = $database->connect();
    $auth = new Auth($db);
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $result = $auth->addUser($_POST, $hashedPassword);

    if ($result) {
        ResponseHandler::sendResponse(201, "User Created", $result);
    } else {
        ResponseHandler::sendResponse(500, 'Unable to add user at this time');
    }

} else {
    ResponseHandler::sendResponse(400, "Post Requests Only");
    return;
}