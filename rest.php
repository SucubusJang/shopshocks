<?php
    include_once("dbcontrol.php");
    include_once("util.php");
    $debug_mode = false;
    
    if($_SERVER['REQUEST_METHOD'] == 'GET'){ # select
        debug_text("for GET Method" ,$debug_mode); 
    }else if($_SERVER['REQUEST_METHOD'] == 'POST'){ # insert , update //ถ้ามีตัวแปรเข้ามาจะทำการเช็ค
        debug_text("for POST Method", $debug_mode);
    }else{
        debug_text("Error Unknow this Request" ,$debug_mode);
        http_response_code(405);
    }
?>