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

$sql = 'SELECT count(*) as totalItem FROM `fresh` as `A`,`sba` as `B` WHERE A.id='.$id.' and B.id='.$id.' ';
if ($result = $mysqli->query ( $sql )) {
	$row = $result->fetch_array ();
	$totalItem = $row ['totalItem'];
	$totalPage = ceil( $totalItem / $recordPerPage );
} else {
	$systemMsg = "Error: " . $mysqli->error;
}

$page = isset ( $_GET ['page'] ) && intval ( $_GET ['page'] ) > 0 ? intval ( $_GET ['page'] ) : 1;

$startRecord = ($page - 1) * $recordPerPage;

$sql = 'SELECT * FROM `fresh` as `A`,`sba` as `B` WHERE A.id='.$id.' and B.id='.$id.' limit ' . $startRecord . ',' . $recordPerPage ;

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>購物車</title>
<script src="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/home.css" rel="stylesheet" type="text/css" />
<link href="https://karrr000.github.io/my-web-demo-FRESH/SpryAssets/btnleftcartlist.css" rel="stylesheet" type="text/css" />
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</head>

<body>
  <dialog id="confirmbox">
      <table>
        <tr>
          <th>商品名稱</th>
          <th>商品數量</th>
          <th>商品價格</th>
          <th>訂購日期</th>
        </tr>
        <?php foreach ( $users as $user ) { ?>
        <tr align="center" valign="center">
          <td><?php echo $user ['cname']?></td>
          <td><?php echo $user ['cquan']?></td>
          <td><?php echo $user ['cprice']?></td>
          <td><?php echo $user ['orderdate']?></td>
        </tr>
        <?php } ?>

      </table>
      </form>
      <div style="text-align:right;">
        <button onclick="confirmbox.close();">取消</button>
        <button onClick="location.href='buy.php'">確認</button>
      </div>
  </dialog>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
  
  <header>


      <!-- header -->


	<div id="toop">
  
            <div id="logo_header">
                <a href="https://karrr000.github.io/my-web-demo-FRESH/index.html"><img src="https://karrr000.github.io/my-web-demo-FRESH/photo/logo_icon_banner/logo.png" width="142" height="142"></a>
            </div>
  
             <div id="banner">
                 <img src="https://karrr000.github.io/my-web-demo-FRESH/photo/logo_icon_banner/banner.gif">
             </div>
  
        </div>

    </header>


	<div class="bucom">
  
	<div class="buttongpout">
		<div class="buttongp">
		  <button class="btnleft lbtn1" value="主頁" onClick="location.href='https://karrr000.github.io/my-web-demo-FRESH/index.html'">主頁</button>
		  <div class="lbtnnone"></div>
		  <button class="btnleft lbtn2" onclick="location.href='loggedon.php'">購物車</button>
		  <div class="lbtnnone"></div>
		  <button class="btnleft lbtn3" value="商品一覽" onClick="location.href='https://karrr000.github.io/my-web-demo-FRESH/Commodity_all.html'">商品一覽</button>
      <div class="lbtnnone"></div>
		  <button class="btnleft lbtn4" onClick="location.href='logout.php'">登出</button>
		</div>
	</div>
  

            <div class="com3">
              <center>
               <table width="577" height="158">
                    <tr>
	                    <th height="56" colspan="4"><?php echo $user_name?>
	                    [會員編號:
	                    <?php echo $id?>]的購物車
                        </th>
                    </tr>

                    <tr>
                      <th>商品名稱</th>
	                    <th>商品數量</th>
	                    <th>商品價格</th>
                      <th>訂購日期</th>

                    </tr>

	                <?php foreach ( $users as $user ) { ?>

                        <tr align="center" valign="center">
                        <td><?php echo $user ['cname']?></td>
                        <td><?php echo $user ['cquan']?></td>
                        <td><?php echo $user ['cprice']?></td>
                        <td><?php echo $user ['orderdate']?></td>
                        </tr>

	                <?php } ?>
	
                </table>
                Page: 
                <?php for($i=1;$i<=$totalPage;$i++){ ?>
              	<a style="color:cyan;" href="cartlist.php?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                <?php } ?>
                <br>
              </center>
              <button onclick="confirmbox.show();">付款</button>
              <br><p></p>


            </div>
 </div> 
  
  <!-- footer -->
  <footer>
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

  <footer class="unfooter">
  <a href="aboutus.html" >關於我們</a>
  <a href="appform.html" >意見反饋</a>
  <a href="webmap.html" >網站地圖</a>
</footer>

<footer class="unfooter">
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