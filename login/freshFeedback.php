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

$username=$_POST['username'];
$email=$_POST["email"];
$topic=$_POST["topic"];
$describess=$_POST["describess"];



      
$sql = "INSERT INTO fresh_appform (username,email,topic,describess) values ('$username','$email','$topic','$describess')";
        
        if (! $mysqli->query ( $sql )) {
            $errorMsg = "Error: " . $mysqli->error;
        }
      
    if ($errorMsg != "") {
        echo $errorMsg . "<br />";
    
    } else {
        echo "表格已送出";
    }

$mysqli->close ();
