<?php 
    session_start();
?>
<?php
    include_once("class.db.php");
    if($_SERVER["REQUEST_METHOD"]=='GET'){
        echo json_encode(product_list(),JSON_UNESCAPED_UNICODE);
        //echo json_encode(openbill());
    }else if($_SERVER["REQUEST_METHOD"]=='POST'){
        echo json_encode(openbill());

    }
    function product_list(){
        $db = new database();
        $db->connect();
        $sql = "SELECT Product_id,Product_code,Product_Name,
                       brand.Brand_name, unit.Unit_name,
                       product.Cost, product.Stock_Quantity
                FROM  product,brand,unit 
                WHERE product.Brand_ID = brand.Brand_id
                and   product.Unit_ID  = unit.Unit_id";
        $result = $db->query($sql);
        $db->close();
        return $result;
    }
    
    function openbill(){
        $_bill[0][0] = 0;
        $_first[0][0] = 0;
        $sql= [ "firstbill"   =>"SELECT count(Bill_id) FROM bill",
                "last_id"     =>"SELECT Bill_id FROM bill order by Bill_id desc limit 1",
                "current_bill"=>"SELECT Bill_id, Bill_Status, Cus_id, Bill_date FROM bill 
                                 WHERE Cus_ID = {$_SESSION['cus_id']} and Bill_id = {$_bill[0][0]}",
                "current_detail"=>"SELECT Bill_id, Product_ID, Quantity, Unit_Price FROM bill_detail where Bill_id={$_bill[0][0]}",
                "openbill"    =>"INSERT INTO bill(Bill_id, Cus_ID, Bill_Status) 
                                 VALUES ('{$_bill[0][0]}','{$_SESSION['cus_id']}',0)",
                "ins_pro"     =>"INSERT INTO bill_detail(Bill_id, Product_ID, Quantity, Unit_Price) 
                                 VALUES ({$_bill[0][0]},{$_POST['p_id']},{$_POST['p_qty']},{$_POST['p_price']})",
                "check_pro"   =>"SELECT count(Product_ID) FROM bill_detail 
                                 WHERE Bill_id={$_bill[0][0]} and Product_ID ={$_POST['p_id']}", 
                "check_pro"   =>"UPDATE bill_detail SET Quantity={$_POST['p_qty']},Unit_Price={$_POST['p_price']} 
                                 WHERE Bill_id = {$_bill[0][0]} and Product_ID = {$_POST['p_id']}"                  
                                ];
        $db = new database();
        $db->connect();
        $_first = $db->query($sql["firstbill"]);
        if($_first[0][0]==0){
            $_bill[0][0] = 1;
            $result = $db->exec($sql["openbill"]);
            $result = $db->exec($sql["ins_pro"]);
        }else{
            $_bill = $db->query($sql["current_bill"]);
            if($_bill[0][1]==0){
                $check_pro = $db->query($sql["check_pro"]);
                if($check_pro[0][0]==0){
                    $result = $db->exec($sql["ins_pro"]); 
                }else{
                    // update
                }
            }
        }
        
        $_result1 = $db->query($sql["current_bill"]);
        $_result2 = $db->query($sql["current_detail"]);
        $db->close();
        return [$_result1, $_result2];
    }   
?>