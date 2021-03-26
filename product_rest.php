<?php
    include_once("class.php");

    if($_SERVER['REQUEST_METHOD'] == "GET"){
        echo json_encode(show_product(),JSON_UNESCAPED_UNICODE);
    }

    function show_product(){
        $shop = new database();
        $shop->connect();
        $sql = "SELECT product.Product_id, product.Product_code, 
        product.Product_Name, brand.Brand_name, unit.Unit_name, 
        product.Cost, product.Stock_Quantity 
 FROM  product,brand,unit 
 WHERE product.Brand_ID = brand.Brand_id 
 and   product.Unit_ID = unit.Unit_id LIMIT 1";
        $result = $shop->query($sql);
        $shop->close();
        return $result;
    }
