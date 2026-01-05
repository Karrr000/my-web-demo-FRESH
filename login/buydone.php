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

$id=$_SESSION['id'];

$sql = "DELETE FROM fresh WHERE id='".$id."'";


if ($mysqli->query($sql) === TRUE) {
    echo "Record deleted successfully";
    header("Location: cartlist.php");
} else {
    echo "Error deleting record: " . $mysql->error;
}


$mysqli->close ();
?>