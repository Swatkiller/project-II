<?php
session_start();

if (isset ($_SESSION['username'])){
    if($_SESSION['is_admin.php']){
        header("admin.php");
    }else{
        header("user.php");
    }
    exit();

}
header("Location: login.php");
exit();
?>