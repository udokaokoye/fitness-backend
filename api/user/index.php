<?php
require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Config/database.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
   $user = $_POST;
   $database = new Database();
   $db = $database->connect();

   $userModel = new User($db);

   if (!$user['name'] || !$user['email'] || !$user['caloriesGoal'] || !$user['created_at']) {
        ResponseHandler::sendResponse(400, 'In-complete Request - This request requires the users - name, email, caloriesGoal and created_at fields');
        return;
   }

//    ResponseHandler::sendResponse(200, 'Correct Data recieved');

   $result = $userModel->createUser($user);

   if ($result) {
    ResponseHandler::sendResponse(201, 'User Created');
    return;
   } 

   return;
} else if($method == 'GET') {
   echo 'GET request';
} else {
    ResponseHandler::sendResponse(401, 'UN AUTHORIZED');
}