<?php

require "config.php";

session_start();

$mysqli = new mysqli ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );

if (mysqli_connect_errno ()) {
	die ( "Error: Connect failed: %s\n" . mysqli_connect_error () );
}

$mysqli->query ( 'SET NAMES utf8' );

$systemMsg = "";

$totalUser = 0;
$recordPerPage = 2;
$totalPage = 1;

$sql = 'Select count(*) as totalUser FROM `sba`';
if ($result = $mysqli->query ( $sql )) {
	$row = $result->fetch_array ();
	$totalUser = $row ['totalUser'];
	$totalPage = ceil( $totalUser / $recordPerPage );
} else {
	$systemMsg = "Error: " . $mysqli->error;
}

$page = isset ( $_GET ['page'] ) && intval ( $_GET ['page'] ) > 0 ? intval ( $_GET ['page'] ) : 1;

$startRecord = ($page - 1) * $recordPerPage;

$sql = 'Select `user_name`, `pwd` FROM `sba` limit ' . $startRecord . ',' . $recordPerPage;
//echo $sql;

$users = array ();

if ($totalUser > 0) {
	if ($result = $mysqli->query ( $sql )) {
		while ( $row = $result->fetch_array () ) {
			$users [] = $row;
		}
	} else {
		$systemMsg = "Error: " . $mysqli->error;
	}
}

if ($systemMsg != '') {
	echo $systemMsg . '<br />';
}

?>

<table>
	<tr>
		<td>Username
		</td>
		<td>Password
		</td>
	
	</tr>
	<?php
	foreach ( $users as $user ) {
		?>
	<tr>
		<td><?php
		echo $user ['user_name'];
		?></td>
		<td><?php
		echo $user ['pwd'];
		?></td>
	</tr>
	<?php
	} ?>
	
</table>

Page: 
<?php for($i=1;$i<=$totalPage;$i++){ ?>
	<a href="userlist.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
<?php } ?>