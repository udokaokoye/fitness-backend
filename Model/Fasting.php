<?php

class Fasting
{
    private $conn;


    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function logFast($user, $fastingStart, $fastingEnd)
    {
        try {
            $query = "INSERT INTO fasting (user_id, startTime, endTIme) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($query);
            $result = $stmt->execute([$user, $fastingStart, $fastingEnd]);

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return ResponseHandler::sendResponse(500, $e->getMessage());
            die();
        }
    }

    public function getFasts($userId)
    {
        try {
            $query = "SELECT * FROM fasting WHERE user_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userId]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result) {
                return $result;
            } else {
                return null;
            }
        } catch (PDOException $e) {
            return ResponseHandler::sendResponse(500, $e->getMessage());
            die();
        }
    }

}