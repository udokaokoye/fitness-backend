<?php

class User
{
    private $conn;
    private $table = 'users';

    // properties of a user
    public $id;
    public $name;
    public $email;
    public $caloriesGoal;
    public $avatar;
    public $createdAt;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getUser($email, $id, $method)
    {

        if ($method == 'id') {
            $query = "SELECT * FROM `users` JOIN user_profile up ON up.user_id = users.id WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$id]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    }

    public function updateSingle($field, $value, $id, $updatedAt)
    {
        try {
            $query = "UPDATE `users` SET $field = ?, `updated_at` = ? WHERE id = ?";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$value, $updatedAt, $id]);
            if ($result) {
                return true;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            // check if error is due to invalid field name
            if ($e->getCode() == '42S22') {
                try {
                    $query = "UPDATE `user_profile` SET $field = ?, `updated_at` = ? WHERE user_id = ?";
                    $stmt = $this->conn->prepare($query);
                    $result = $stmt->execute([$value, $updatedAt, $id]);
                    if ($result) {
                        return $result;
                    } else {
                        return null;
                    }
                } catch (PDOException $e) {
                    ResponseHandler::sendResponse(500, $e->getMessage());
                    die();
                }
            } else {
                ResponseHandler::sendResponse(500, $e->getMessage());
                die();
            }
        }
    }

    public function updateWeightTracking ($id, $weight, $updatedAt) {
        try {
            $query = "INSERT INTO `weight_tracking` (`user_id`, `weight`, `date`) VALUES (?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$id, $weight, $updatedAt]);
            if ($result) {
                return true;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            ResponseHandler::sendResponse(500, $e->getMessage());
            die();
        }
    }
}
