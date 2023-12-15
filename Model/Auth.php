<?php

class Auth
{
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function addUser($user, $hashedPassword)
    {
        try {
            $this->conn->beginTransaction();
            $query = "INSERT INTO users 
            (firstName, lastName, email, password, avatar, created_at) VALUES (?,?,?,?,?,?)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$user['firstName'], $user['lastName'], $user['email'], $hashedPassword, $user['avatar'], (int)$user['createdAt']]);

            if ($result) {
                $userId = $this->conn->lastInsertId();
                $populateUserProfile = $this->populateUserProfile($user, $userId);
                if ($populateUserProfile) {
                    $this->conn->commit();
                    return $userId;
                } else {
                    $this->conn->rollBack();
                    ResponseHandler::sendResponse(500, "Failed To Add User Profile");
                    die();
                }
                // return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                ResponseHandler::sendResponse(400, "Email Address already exists");
                die();
            } else {
                ResponseHandler::sendResponse(500, $e->getMessage());
                die();
            }
        }
    }

    public function populateUserProfile($user, $userId) {
        $query = "INSERT INTO `user_profile` (`user_id`, `age`, `gender`, `weight`, `height`, `activity_level`, `daily_calories`, `goal_weight`, `dietary_preferences`, `favorite_foods`, `disliked_foods`, updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$userId, $user['age'], $user['gender'], $user['weight'], $user['height'], $user['activityLevel'], $user['dailyCalories'], $user['goalWeight'], $user['dietaryPreferences'], $user['favoriteFoods'], $user['dislikedFoods'], (int)$user['createdAt']]);
        if ($result) {
            $weightTrackerQuery = "INSERT INTO `weight_tracking` (`user_id`, `weight`, `date`) VALUES (?,?,?)";
            $weightTrackerStmt = $this->conn->prepare($weightTrackerQuery);
            $weightTrackerResult = $weightTrackerStmt->execute([$userId, $user['weight'], (int)$user['createdAt']]);
            if ($weightTrackerResult) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getUserAuthInformation($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$email]);


        if ($result) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            ResponseHandler::sendResponse(400, "User Not Found");
            return;
        }
    }

    public function checkIfUserExists($email)
    {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$email]);

        if ($result) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            false;
        }
    }
}
