<?php
require "config.php";
session_start();

if( !isset($_SESSION['username'])){
  header("Location: https://karrr000.github.io/my-web-demo-FRESH/login.html");

} else{
  header("Location: cartlist.php");
}
?>