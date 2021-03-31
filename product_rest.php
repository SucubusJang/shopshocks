<?php session_start(); ?>
<?php
    include_once("class.db.php");
    if ($_SERVER["REQUEST_METHOD"] == 'GET') {
        echo json_encode(product_list(), JSON_UNESCAPED_UNICODE);
    } else if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        openbill();
    }
    function product_list(){
        $db = new database();
        $db->connect();
        $sql = "SELECT  Product_id,Product_code,Product_Name,
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
        // 1. check bill is first || SELECT COUNT(`Bill_id`) as count FROM `bill`
        // 2. last bil SELECT `Bill_id` as Id FROM `bill` ORDER BY `Bill_id` DESC LIMIT 1
        // 3. check bill || SELECT `Bill_id` as Id,`Bill_Status` as status FROM bill WHERE `Cus_ID` = 1 ORDER by `Bill_id` DESC LIMIT 1 // ไว้เช็คสเตตัสของบิลว่า เสร็จแล้ว หรือ ยังไม่เสร็จ
        $db = new database();
        $db->connect();

        $sql = ["firstbill"    =>"SELECT COUNT(`Bill_id`) count FROM `bill`",
                "last_id"      =>"SELECT `Bill_id` FROM `bill` ORDER BY `Bill_id` DESC LIMIT 1",
                "current_bill" =>"SELECT `Bill_id`,`Bill_Status` FROM bill WHERE `Cus_ID` = 1 ORDER by `Bill_id` DESC LIMIT 1",
                "ins_bill_1st" =>"INSERT INTO `bill`(`Bill_id`, `Cus_ID`, `Bill_Status`) VALUES (1,1,0)",
                "ins_detail"   =>"INSERT INTO `bill_detail`(`Bill_id`, `Product_ID`, `Quantity`, `Unit_Price`) VALUES (1,1,4,200)"
                ];
        $result = $db->query($sql["firstbill"]);
        if($result[0][0] == 0){
            $sql = "INSERT INTO `bill`(`Bill_id`, `Cus_ID`, `Bill_Status`) VALUES (1,'{$_SESSION['cus_id']}',0)";
            $result = $db->exec($sql);
            $sql = "INSERT INTO `bill_detail`(`Bill_id`, `Product_ID`, `Quantity`, `Unit_Price`) 
                    VALUES ('{$_SESSION['cus_id']}','{$_POST['p_id']}','{$_POST['p_qty']}','{$_POST['p_price']}')";
            $result = $db->exec($sql);
        }else{
            
        }
        $db->close();
        return $result;
    }

?>