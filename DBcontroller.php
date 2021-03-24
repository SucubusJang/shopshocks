<?php

class db{
    public $dbConn = null; // สร้างตัวแปรการเก็บ ค่า connect
    public function connect() //เชื่อมต่อฐานข้อมูล
    {
        define("host", "localhost");
        define("username", "root");
        define("password", "");
        define("database", "iti_store");
        $this->dbConn = new mysqli(host, username, password, database);
        if ($this->dbConn->connect_error) //แสดง error เมื่อเชิ่มต่อไม่ได้
            die("Database Connection Error,Error No.:" .
                $this->dbConn->connect_errno . " | " . $this->dbConn->connect->connect_error);
        $this->dbConn->query("SET NAMES UTF8");
    }
    public function disconnect() //ตัดการเชื่อมต่อฐานข้อมูล
    {
        $this->dbConn->close();
    }
}
?>