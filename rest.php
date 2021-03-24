<?php
    include_once("dbcontrol.php");
    include_once("util.php");
    $debug_mode = false;
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){ # select
        debug_text("for GET Method" ,$debug_mode); 
    }else if($_SERVER['REQUEST_METHOD'] == 'POST'){ # insert , update //ถ้ามีตัวแปรเข้ามาจะทำการเช็ค
        debug_text("for POST Method", $debug_mode);
        if(isset($_POST['name']) && isset($_POST['nickname'])){
           if($_POST['password'] == $_POST['con_pass']){
            $name = $_POST['name'];
            $nickname = $_POST['nickname'];
            $pass = $_POST['password'];
            regis($name,$nickname,$pass,$debug_mode);
           }else{
               echo "<script>alert('Password Not Match')</script>";
           }
        }
    }else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }

    function regis($name,$nickname,$pass,$debug_mode){
        $mydb = new db("root","","shopshock",$debug_mode);
        $id = $mydb->query("SELECT MAX(member_id)+1 as id FROM `member`");
        $data = $mydb->query_only("INSERT INTO `member`(`member_id`, `name`, `user`, `password`, `type`) VALUES ('{$id}','{$nickname}','{$name}','{$pass}','01'");
        return $data;
    }
