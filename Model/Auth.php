<?php

class Auth {
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function addUser($user, $hashedPassword) {
        try {
            $query = "INSERT INTO users (firstName, lastName, email, password, caloriesGoal, created_at) VALUES (?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $result = $stmt->execute([$user['firstName'], $user['lastName'], $user['email'], $hashedPassword, $user['caloriesGoal'], (int)$user['createdAt']]);

        if ($result) {
            return $result;
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

    public function getUserAuthInformation($email) {
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
}