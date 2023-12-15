<?php

require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Auth.php';
require '../../Config/database.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
try {
    if (!isset($_POST['firstName']) || 
    !isset($_POST['lastName']) || 
    !isset($_POST['email']) || 
    !isset($_POST['password']) || 
    !isset($_POST['createdAt']) ||
    !isset($_POST['weight']) ||
    !isset($_POST['height']) ||
    !isset($_POST['activityLevel']) ||
    !isset($_POST['goalWeight']) ||
    !isset($_POST['dailyCalories']) ||
    !isset($_POST['age']) ||
    !isset($_POST['gender']) ||
    // !isset($_POST['dietaryPreferences']) ||
    // !isset($_POST['favoriteFoods']) ||
    // !isset($_POST['dislikedFoods']) ||
    !isset($_POST['createdAt'])
    ) {
        ResponseHandler::sendResponse(400, "Please send all required fields");
        return;
    }

    $_POST['avatar'] = isset($_POST['avatar']) ? $_POST['avatar'] : null;
    $_POST['dietaryPreferences'] = isset($_POST['dietaryPreferences']) ? $_POST['dietaryPreferences'] : null;
    $_POST['favoriteFoods'] = isset($_POST['favoriteFoods']) ? $_POST['favoriteFoods'] : null;
    $_POST['dislikedFoods'] = isset($_POST['dislikedFoods']) ? $_POST['dislikedFoods'] : null;

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
} catch (\Throwable $error) {
    ResponseHandler::sendResponse(500, $error->getMessage());
}

} else if ($method == 'GET') {
    $action = isset($_GET['action']) ? $_GET['action'] : null;

    if ($action == 'checkEmail') {
        if (!isset($_GET['email'])) {
            ResponseHandler::sendResponse(400, "Please send all required fields");
            return;
        }

        $database = new Database();
        $db = $database->connect();
        $auth = new Auth($db);

        $result = $auth->checkIfUserExists($_GET['email']);

        if ($result) {
            ResponseHandler::sendResponse(200, "Email Already Exists");
        } else {
            ResponseHandler::sendResponse(404, "Email Does Not Exist");
        }
    }

} else {
    ResponseHandler::sendResponse(400, "Post Requests Only");
    return;
}