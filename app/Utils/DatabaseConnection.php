<?php

namespace App\Utils;

use PDO;
use PDOException;

class DatabaseConnection 
{
    protected $conn;
    public $result;

    public function __construct($host, $dbname, $username, $password) {
        try{
            $dsn = "mysql:host=" . $host . ";dbname=" . $dbname;
            $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
            $this->conn = new PDO($dsn, $username, $password, $options);
        } catch(PDOException $e) {
            echo 'Connection failed'. $e->getMessage();
        }
    }

    public function DbQuery(string $query, array $params = []) {
        $this->result = $this->conn->prepare($query);
        if (empty($params)){
            return $this->result->execute();
        }else{
            return $this->result->execute($params);
        }
    }

    public function rowCount() {
        return $this->result->rowCount();
    }

    public function fetch() {
        return $this->result->fetch(PDO::FETCH_OBJ);
    }

    public function fetchAll() {
        return $this->result->fetchAll(PDO::FETCH_OBJ);
    }

    public function closeConnection() {
        $this->conn = null;
    }
}
