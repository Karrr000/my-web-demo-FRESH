<?php
require "config.php";

session_start();

$mysqli = new mysqli ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );

if (mysqli_connect_errno ()) {
	die ( "Error: Connect failed: %s\n" . mysqli_connect_error () );
}

$mysqli->query ( 'SET NAMES utf8' );

$systemMsg = "";

if ( !isset($_SESSION['username']) && isset ( $_POST ['username'] ) && isset ( $_POST ['password'] )) {
	$username = $mysqli->real_escape_string ( $_POST ['username'] );
	$password = md5 ( $_POST ['password'] );
	
	$sql = 'Select `user_name`,`id` FROM `sba` where `user_name` = "' . $username . '" and `pwd` = "' . $password . '" limit 1';
	$result = $mysqli->query ( $sql );
	
	if ($result) {
		if ($row = $result->fetch_array ()) {
			$_SESSION['username'] = $row['user_name'];
			$_SESSION['id'] = $row['id'];
			//may do something here
		} else {
			$systemMsg = "Error: 用戶不存在或密碼錯誤！";
                        echo'<br><a href="https://karrr000.github.io/my-web-demo-FRESH/login.html">請重新登入！</a>';
		}
	} else {
		
		$systemMsg = "Error: " . $mysqli->error;
	}
}

if(isset($_SESSION['username']) && $_SESSION['username'] != ""){
	header("Location: cartlist.php");
	exit;
}

if ($systemMsg != "") {
	echo $systemMsg . '<br />';
}else{
	echo "User logged on!";
}

$mysqli->close();