<?php

/**
 * Методы для работы с таблицой контактов в рамках одного класса
*/

class Contact {
    private $conn;
    private $table_name = "contact";

    /**
     * Для визуализации => DTO
     */

    public $id;
    public $visit_id;
    // Разделение колонки info => email, phone
    public $email;
    public $phone;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add(
        // Request $request => DTO
    ) {

        /**
        * Формирование запроса
        * Подготовка запроса
        * Отправка запроса
        */

        $query = sprintf(
            "INSERT INTO %s (visit_id, email, phone) VALUES (:visit_id, :email, :phone)",
            $this->table_name
        );

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":visit_id",       $this->visit_id);
        $stmt->bindParam(":email",          $this->email);
        $stmt->bindParam(":phone",          $this->phone);

        return $stmt->execute();
    }

     /**
     * Все контакты по visit_id
     */

    public function readByVisitId() {

        $query = sprintf(
            "SELECT * FROM %s WHERE visit_id = :visit_id", 
            $this->table_name
        );
    
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":visit_id", $this->visit_id, PDO::PARAM_INT);
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
