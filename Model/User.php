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


public function getUser($email, $id, $method) {

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

}