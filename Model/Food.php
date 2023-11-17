<?php

class Food
{
    private $conn;
    private $table = 'users';

    // properties of a user
    public $id;
    public $apiFoodID;
    public $name;
    public $email;
    public $caloriesGoal;
    public $avatar;
    public $createdAt;

    public function __construct($db)
    {
        $this->conn = $db;
    }




    public function logFood($food, $nutrition)
    {
        try {
            $this->conn->beginTransaction();
            $nutritionId = $this->logNutrition($nutrition);

            // return $nutritionId;

            if ($nutritionId) {
                $query = "INSERT INTO `food` (`userId`, `name`, `apiFoodID`, `nutritionID`, `calories`, `serving`, `meal`, `note`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?)";
                $stmt = $this->conn->prepare($query);
                $executeSuccess = $stmt->execute([$food['userId'], $food['name'], $food['apiFoodID'], $nutritionId, $food['calories'], $food['serving'], $food['meal'], $food['notes'], $food['created_at']]);
                if ($executeSuccess) {
                    $this->conn->commit();
                    return true;
                }
            } else {
                $this->conn->rollBack();
                echo ResponseHandler::sendResponse(500, "Failed To Add Nutrition");
                die();
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo ResponseHandler::sendResponse(500, $e->getMessage());
            die();
        }
    }

    public function logNutrition($nutrition)
    {
        try {
            $query = "INSERT INTO `nutrition` (`userId`, `protein`, `carbohydrate`, `fat`, `created_at`) VALUES (?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $executeSuccess = $stmt->execute([$nutrition['userId'], $nutrition['protein'], $nutrition['carbohydrate'], $nutrition['fat'], $nutrition['created_at']]);

            if ($executeSuccess) {
                $nutritionID = $this->conn->lastInsertId();
                return $nutritionID;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo ResponseHandler::sendResponse(500, $e->getMessage());
            die();
        }
    }


    public function getUsersMealHistory($userID)
    {
        try {
            $query = "SELECT food.*, n.fat, u.firstName FROM food JOIN nutrition n ON food.nutritionID = n.id JOIN users u ON food.userId = u.id  WHERE food.userId = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userID]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo ResponseHandler::sendResponse(500, $e->getMessage());
        }
    }


    public function getdem($userID, $beginningOfDay, $endOfDay)
    {
        try {
            $query = "SELECT food.*, n.* FROM food JOIN nutrition n ON food.nutritionID = n.id JOIN users u ON food.userId = u.id  WHERE food.created_at BETWEEN '$beginningOfDay' AND '$endOfDay' AND food.userId = ?  ";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userID]);

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);



            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            echo ResponseHandler::sendResponse(500, $e->getMessage());
        }
    }
}
