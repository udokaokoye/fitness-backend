<?php

require '../../utils/ResponseHandler.php';
require '../../Model/User.php';
require '../../Model/Food.php';
require '../../Config/database.php';
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $database = new Database();
    $db = $database->connect();

    $foodModel = new Food($db);

    $json = file_get_contents('php://input');

    $data = json_decode($json, true);
    $food = $data['food'];
    $nutrition = $data['nutrition'];



    if (!validateFood($food) || !validateNutrition($nutrition)) {
        echo ResponseHandler::sendResponse(400, "Food/Nutrition Data Not Complete");
        return;
    }

    // ResponseHandler::sendResponse(200, $data);

    $result = $foodModel->logFood($food, $nutrition);

    if ($result) {
        ResponseHandler::sendResponse(201, 'Food Added');
        return;
    } else {
        ResponseHandler::sendResponse(500, 'Failed To Add Food');
        return;
    }

    //    return;
} else if ($method == "GET") {
    $database = new Database();
    $db = $database->connect();

    $foodModel = new Food($db);

    if (!isset($_GET['userId']) || !isset($_GET['beginningOfDay']) || !isset($_GET['endOfDay'])) {
        ResponseHandler::sendResponse(400, "UserId, beginningOfDay and endOfDay Required");
        return;
    }

    $userId = $_GET['userId'];

    $result = $foodModel->getdem($userId, $_GET['beginningOfDay'], $_GET['endOfDay']);

    if ($result) {
        ResponseHandler::sendResponse(200, $result);
    } else {
        ResponseHandler::sendResponse(200, []);
    }
} else {
    ResponseHandler::sendResponse(401, 'UN AUTHORIZED');
}

function validateFood($foodObject)
{
    if (isset($foodObject['userId']) && isset($foodObject['name']) && isset($foodObject['apiFoodID']) && isset($foodObject['calories']) && isset($foodObject['serving']) && isset($foodObject['meal']) && isset($foodObject['created_at'])) {
        return true;
    } else {
        return false;
    }
}

function validateNutrition($nutritionObject)
{
    if (isset($nutritionObject['userId']) && isset($nutritionObject['protein']) && isset($nutritionObject['carbohydrate']) && isset($nutritionObject['fat'])) {
        return true;
    } else {
        return false;
    }
}
