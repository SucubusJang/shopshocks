<?php
    class database{
        private $db;
        function connect(){
            $this->db = new mysqli("localhost","root","","shopshock");
            $this->db->set_charset("UTF-8");
            if($this->db->connect_errno){
                echo "connect error";
            }
        }
        function queryV2($sql,$option=MYSQLI_NUM){
            $result = $this->db->query($sql);
            $data = $result->fetch_all($option);
        }
    
        function exec_sql($sql){
            $result = $this->db->query($sql);
            return $result;
        }

        function close(){
            $this->db->close();
        }
    }

?>