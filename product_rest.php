<?php
    include_once("class.php");

    if($_SERVER['REQUEST_METHOD'] == "GET"){

    }

    function show_product(){
        $shop = new database();
        $shop->connect();
        $sql = "SELECT * FROM `product`";
        $result = $shop->query($sql);
        $shop->close();
        return $result;
    }

?>