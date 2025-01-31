<?php

require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Auth.php';
require '../../Config/database.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        ResponseHandler::sendResponse(400, "Email and Password Required");
        return;
    }
    $database = new Database();
    $db = $database->connect();
    $auth = new Auth($db);
    $user = new User($db);
    $password = $_POST['password'];

    $result = $auth->getUserAuthInformation($_POST['email']);
    if ($result) {
        $hashedPassword = $result[0]['password'];

        if (password_verify($password, $hashedPassword)) {
            $userInfo = $user->getUser($_POST['email'], $result[0]['id'], 'id');
            ResponseHandler::sendResponse(200, 'logged in', $userInfo);
            return;
        } else {
            ResponseHandler::sendResponse(401, "Wrong username/password");
            return;
        }
    } else {
        ResponseHandler::sendResponse(400, 'User not found');
    }

} else {
    ResponseHandler::sendResponse(400, "Post Requests Only");
    return;
}