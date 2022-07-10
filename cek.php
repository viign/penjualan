<?php

require 'function.php';

if(isset($_SESSION['login'])){
    //udah login
} else {
    //belom ngab
    header('location:login.php');
}

?>