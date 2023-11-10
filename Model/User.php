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


    public function createUser($userObject) {
        try {
            $query = 'INSERT INTO users (`FirstName`, `lastName`, `email`, `caloriesGoal`) VALUES (?, ?, ?, ?)';
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userObject['name'], $userObject['name'], $userObject['email'], $userObject['caloriesGoal']]);
            if ($stmt) {
                return $stmt;
            }
        } catch (PDOException $e) {
            echo ResponseHandler::sendResponse(500, $e->getMessage());
            return;
        }
    }

}