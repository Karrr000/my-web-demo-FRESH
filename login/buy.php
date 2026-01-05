<?php

require "config.php";

session_start();

$mysqli = new mysqli ( $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME );

if (mysqli_connect_errno ()) {
	die ( "Error: Connect failed: %s\n" . mysqli_connect_error () );
}

$mysqli->query ( 'SET NAMES utf8' );

$systemMsg = "";


$totalItem = 0;
$recordPerPage = 20;
$totalPage = 1;
$id=$_SESSION['id'];
$user_name = $_SESSION['username'];

$sql = 'SELECT count(*) as totalItem FROM `fresh`';
if ($result = $mysqli->query ( $sql )) {
	$row = $result->fetch_array ();
	$totalItem = $row ['totalItem'];
	$totalPage = ceil( $totalItem / $recordPerPage );
} else {
	$systemMsg = "Error: " . $mysqli->error;
}

$page = isset ( $_GET ['page'] ) && intval ( $_GET ['page'] ) > 0 ? intval ( $_GET ['page'] ) : 1;

$startRecord = ($page - 1) * $recordPerPage;

$sql = 'SELECT *, SUM(A.cquan), SUM(A.cprice) FROM `fresh` as `A`,`sba` as `B` WHERE A.id='.$id.' and B.id='.$id.' GROUP BY A.cname limit ' . $startRecord . ',' . $recordPerPage ;

//echo $sql;
$users = array ();

if ($totalItem > 0) {
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

<?php

$sql = 'SELECT SUM(A.cprice) FROM `fresh` as `A`,`sba` as `B` WHERE A.id='.$id.' and B.id='.$id.' GROUP BY A.id limit ' . $startRecord . ',' . $recordPerPage ;

//echo $sql;
$datas = array ();

if ($totalItem > 0) {
	if ($result = $mysqli->query ( $sql )) {
		while ( $row = $result->fetch_array () ) {
			$datas [] = $row;
		}
	} else {
		$systemMsg = "Error: " . $mysqli->error;
	}
}

if ($systemMsg != '') {
	echo $systemMsg . '<br />';
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>購物車</title>
<script src="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/home.css" rel="stylesheet" type="text/css" />
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/btnleft.css" rel="stylesheet" type="text/css" />
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/print.css" rel="stylesheet" type="text/css" />
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</head>

<body>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  
  <header>


      <!-- header -->


	<div id="toop" class="no-print">
  
            <div id="logo_header" class="no-print">
                <a href="https://karrr000.github.io/my-web-demo-FRESH/index.html"><img src="https://karrr000.github.io/my-web-demo-FRESH/photo/logo_icon_banner/logo.png" width="142" height="142"></a>
            </div>
  
             <div id="banner" class="no-print">
                 <img src="https://karrr000.github.io/my-web-demo-FRESH/photo/logo_icon_banner/banner.gif">
             </div>
  
        </div>

    </header>


	<div class="bucom">
  
	<div class="buttongpout no-print">
		<div class="buttongp">
		  <button class="btnleft lbtn1" value="主頁" onClick="location.href='https://karrr000.github.io/my-web-demo-FRESH/index.html'">主頁</button>
		  <div class="lbtnnone"></div>
		  <button class="btnleft lbtn2" onclick="location.href='https://karrr000.github.io/my-web-demo-FRESH/login/loggedon.php'">購物車</button>
		  <div class="lbtnnone"></div>
		  <button class="btnleft lbtn3" value="商品一覽" onClick="location.href='https://karrr000.github.io/my-web-demo-FRESH/Commodity_all.html'">商品一覽</button>
		</div>
	</div>

  <div class="nodisplay print">
    <div style="display:inline-block;">
      <br>
      <img src="https://karrr000.github.io/my-web-demo-FRESH/photo/logo_icon_banner/logo.png" width="70" height="70">
    </div>
    <div  style="display:inline-block;text-align: left">
      會員名稱:<?php echo $user_name?><br>
      會員編號:<?php echo $id?><br>
      訂單日期:<span id='date-time'></span>
    </div>
    <p>
  </div>

  <script>
      var dt = new Date();
      document.getElementById('date-time').innerHTML = dt;
  </script>

            <div class="com3" class="print">
              <center>
               <table width="577" height="158" border="0">
                    <tr align="center" valign="center">
                        <td colspan="3">你己完成購買以下商品</td>
                    </tr>


	                <?php foreach ( $users as $user ) { ?>

                        <tr align="center" valign="center">
	                         <td><?php echo $user ['cname']?></td>
			                     <td><?php echo $user ['SUM(A.cquan)']?>件</td>
	                         <td>$<?php echo $user ['SUM(A.cprice)']?></td>
                        </tr>


	                <?php } ?>
	
                </table>
              </center>
              
              <br>
              <span style="text-align: right;">
                <?php foreach ( $datas as $data ) { ?>訂單總值:$<?php echo $data ['SUM(A.cprice)']?><?php } ?>
              </span>

      

              <div class="no-print">
                <input type="button" value="列印訂單" onclick="window.print()" />
                <button onclick="location.href='buydone.php'">確定</button>
              </div>


            </div>


 </div> 
  
  <!-- footer -->
  <footer class="no-print">
       <a href="aboutus.html" >關於我們</a>
       <a href="appform.html" >意見反饋</a>
       <a href="webmap.html" >網站地圖</a>
       <div id="last-update">最後更新日期:</div>

       <audio autoplay loop id="myAudio" src="photo/soothing-sunset-116237.mp3"></audio>

        <ion-icon name="play-circle-outline" onclick="playAudio();playbgm();" class="musicimg playbgm" id="playbgm"></ion-icon>
        <ion-icon name="pause-circle-outline" onclick="pauseAudio();pausebgm();" class="musicimg pausebgm" id="pausebgm"></ion-icon>
        
      <script>
      var x = document.getElementById("myAudio"); 
      
      function playAudio() { 
        x.play(); 
      } 
      
      function pauseAudio() { 
        x.pause(); 
      } 

      var playbgm = document.getElementById('playbgm');
      var pausebgm = document.getElementById('pausebgm');

      function playbgm() {
        playbgm.className = "playbgm";
        pausebgm.className = "pausebgm";
      }

      function pausebgm() {
        playbgm.className = "pausebgm";
        pausebgm.className = "playbgm";
      }

      </script>

  </footer>

  <footer class="unfooter no-print">
  <a href="aboutus.html" >關於我們</a>
  <a href="appform.html" >意見反饋</a>
  <a href="webmap.html" >網站地圖</a>
</footer>

<footer class="unfooter no-print">
    <div id="last-update">最後更新日期:</div>

  <audio autoplay loop id="myAudio" src="photo/soothing-sunset-116237.mp3"></audio>

   <ion-icon name="play-circle-outline" onclick="playAudio();playbgm();" class="musicimg playbgm" id="playbgm"></ion-icon>
   <ion-icon name="pause-circle-outline" onclick="pauseAudio();pausebgm();" class="musicimg pausebgm" id="pausebgm"></ion-icon>
   
 <script>
 var x = document.getElementById("myAudio"); 
 
 function playAudio() { 
   x.play(); 
 } 
 
 function pauseAudio() { 
   x.pause(); 
 } 

 var playbgm = document.getElementById('playbgm');
 var pausebgm = document.getElementById('pausebgm');

 function playbgm() {
   playbgm.className = "playbgm";
   pausebgm.className = "pausebgm";
 }

 function pausebgm() {
   playbgm.className = "pausebgm";
   pausebgm.className = "playbgm";
 }

 </script>
</footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>


</body>
</html>