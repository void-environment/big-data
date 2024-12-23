<?php

class Database
{
    public $conn;
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function __construct() {
        
        $this->host = getenv('MYSQL_HOST');
        $this->db_name = getenv('MYSQL_DATABASE');
        $this->username = getenv('MYSQL_USER');
        $this->password = getenv('MYSQL_PASSWORD');
    }

    public function getConnection()
    {
        $this->conn = null;
        
        try {

            $this->conn = new PDO(
                sprintf(
                    "mysql:host=%s;dbname=%s", $this->host, $this->db_name
                ), 
                $this->username, $this->password
            );
            
            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $e) {
            echo "Ошибка подключения: " . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
