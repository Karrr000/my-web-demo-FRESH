<?php

require "config.php";

$mysqli = new mysqli ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );

if (mysqli_connect_errno ()) {
	die ( "Connect failed: " . mysqli_connect_error () );
}

$mysqli->query ( 'SET NAMES utf8' );

$success = false;
$errorMsg = "";
if (isset ( $_POST ['username'] ) && isset ( $_POST ['password'] ) && isset ( $_POST ['confirm_password'] )) {
	
	if ($_POST ['password'] == '') {
		$errorMsg = "Please enter the old password!";
	} elseif ($_POST ['confirm_password'] != $_POST ['password']) {
		$errorMsg = "password and confirm password do not match!";
	} else {
		$username = $mysqli->real_escape_string ( $_POST ['username'] );
		$password = md5 ( $_POST ['password'] );
		
		$sql = 'INSERT INTO `sba` (`user_name`,`pwd`,`regaccdate`) values ("' . $username . '","' . $password . '",now())';
		
		if (! $mysqli->query ( $sql )) {
			$errorMsg = "Error: " . $mysqli->error;
		}
		
	}
	
	if ($errorMsg != "") {
		echo $errorMsg . '<br />';
	
	} else {
		echo "已成功登記！";
		header("refresh:2;url=https://karrr000.github.io/my-web-demo-FRESH/login.html");
		

	}
}


$mysqli->close ();
?>

<br>
