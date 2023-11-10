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

            if ($nutritionId) {
                $query = "INSERT INTO `food` (`userId`, `name`, `apiFoodID`, `nutritionID`, `calories`, `serving`, `meal`, `note`, `created_at`) VALUES (?,?,?,?,?,?,?,?,?)";
                $stmt = $this->conn->prepare($query);
                $executeSuccess = $stmt->execute([$food['userID'], $food['name'], $food['apiFoodID'], $nutritionId, $food['calories'], $food['serving'], $food['meal'], $food['note'], $food['created_at']]);
                if ($executeSuccess) {
                    $this->conn->commit();
                    return true;
                }
            } else {
                $this->conn->rollBack();
                echo ResponseHandler::sendResponse(500, "Failed To Add Nutrition");
                return;
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo ResponseHandler::sendResponse(500, $e->getMessage());
            return;
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
            return false;
        }
    }
}
