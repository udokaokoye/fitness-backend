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


       $result = $foodModel->logFood($food, $nutrition);

       if ($result) {
        ResponseHandler::sendResponse(201, 'Food Added');
        return;
       } 

    //    return;
} else {
    ResponseHandler::sendResponse(401, 'UN AUTHORIZED');
}

function validateFood ($foodObject) {
    if (isset($foodObject['userId']) || isset($foodObject['name']) || isset($foodObject['apiFoodID']) || isset($foodObject['calories']) || isset($foodObject['serving']) || isset($foodObject['meal']) || isset($foodObject['created_at'])) {
        return true;
    } else {
        return false;
    }
}

function validateNutrition ($nutritionObject) {
    if (isset($nutritionObject['userId']) || isset($nutritionObject['protein']) || isset($nutritionObject['carbohydrate']) || isset($nutritionObject['fat'])) {
        return true;
    } else {
        return false;
    }
}