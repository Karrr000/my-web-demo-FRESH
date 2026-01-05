<?php
require "config.php";

session_start();

$mysqli = new mysqli ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );
if (mysqli_connect_errno ()) {
    die ( "Connect failed: " . mysqli_connect_error () );
}
$mysqli->query ( "SET NAMES utf8" );
$success = false;
$errorMsg = "";



$id=$_SESSION["id"];
$cname=$_POST["cname"];
$cquan=$_POST["cquan"];
$cprice=$_POST["cprice"]*$cquan;


      
$sql = "INSERT INTO fresh (id,cname,cquan,cprice) values ('$id','$cname','$cquan','$cprice')";
        
        if (! $mysqli->query ( $sql )) {
            $errorMsg = "Error: " . $mysqli->error;
        }
      
    if ($errorMsg != "") {
        echo $errorMsg . "<br />";
    
    } else {
        echo "已加入購物車";
        header("Location: cartlist.php");
    }

$mysqli->close ();

