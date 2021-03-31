<?php session_start(); ?>
<?php
    include_once("class.db.php");
    if ($_SERVER["REQUEST_METHOD"] == 'GET') {
        echo json_encode(product_list(), JSON_UNESCAPED_UNICODE);
    } else if ($_SERVER["REQUEST_METHOD"] == 'POST') {
        echo json_encode(openbill());
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
        $_bill[0][0] = 0;
        $_first[0][0] = 0;
        $sql = ["firstbill"    =>"SELECT COUNT(`Bill_id`) count FROM `bill`",
                "last_id"      =>"SELECT `Bill_id` FROM `bill` ORDER BY `Bill_id` DESC LIMIT 1",
                "current_bill" =>"SELECT `Bill_id`,`Bill_Status` FROM bill WHERE `Cus_ID` = 1 ORDER by `Bill_id` DESC LIMIT 1",
                "openbill"     =>"INSERT INTO `bill`(`Bill_id`, `Cus_ID`, `Bill_Status`) VALUES (1,'{$_SESSION['cus_id']}',0)",
                "ins_pro"      =>"INSERT INTO `bill_detail`(`Bill_id`, `Product_ID`, `Quantity`, `Unit_Price`) 
                                  VALUES (1,'{$_POST['p_id']}','{$_POST['p_qty']}','{$_POST['p_price']}')",
                "check_pro"    =>"SELECT COUNT(`Product_ID`) FROM `bill_detail` WHERE `Bill_id` = '{$_bill[0][0]}' AND `Product_ID` = '{$_POST['p_id']}'",
                "check_pro"    =>"UPDATE `bill_detail` SET `Quantity`='{$_POST['p_qty']}',`Unit_Price`='{$_POST['p_price']}' WHERE `Bill_id`='{$_bill[0][0]}' and `Product_ID`='{$_POST['p_id']}'"
                ];
        $_first = $db->query($sql["firstbill"]);
        if($_first[0][0] == 0){
            $result = $db->exec($sql["openbill"]);
            $result = $db->exec($sql["ins_pro"]);
        }else{
            $_bill = $db->query($sql["current_bill"]);
            if($_bill[0][1] == 0){
                 $check_pro = $db->query($sql["check_pro"]);
                 if($check_pro[0][0] == 0){
                    $result = $db->exec($sql["ins_pro"]);
                 }
            }
        }
        $db->close();
        return $result;
    }

?>