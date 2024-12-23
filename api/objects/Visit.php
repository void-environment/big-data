<?php

/**
 * Методы для работы с посещений сайта в рамках одного класса
*/

class Visit {
    private $conn;
    private $table_name = "visit";

    /**
     * Для визуализации => DTO
     *
    */

    public $id;
     /**
      * Убрано из структуры в рамках тестового решения:
      * public $domain_id;
    */
    public $page;
    public $ip;
    public $user_agent;
    public $browser;
    public $device;
    public $platform;
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
        * Возвращает id созданого визита
        */

        $query = sprintf(
            "INSERT INTO %s (page, ip, user_agent, browser, device, platform) VALUES (:page, :ip, :user_agent, :browser, :device, :platform)",
            $this->table_name
        );

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":page",           $this->page);
        $stmt->bindParam(":ip",             $this->ip);
        $stmt->bindParam(":user_agent",     $this->user_agent);
        $stmt->bindParam(":browser",        $this->browser);
        $stmt->bindParam(":device",         $this->device);
        $stmt->bindParam(":platform",       $this->platform);

        if (!$stmt->execute()) return false;
        /**
        * Возвращаем ID последнего визита
        */
        return $this->conn->lastInsertId();
    }

    /**
    * Все записи, без пагинации
    */
    
    public function read() {

        $query = sprintf(
            "SELECT * FROM %s", 
            $this->table_name
        );

        $stmt = $this->conn->prepare($query);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
}
?>
