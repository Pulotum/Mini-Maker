<?php
require "../library/connect.php";
$conn = server_connect();

$url = $_GET["c"];
if (!empty($url)){
	$query = "	SELECT * 
				FROM  `url` 
				WHERE  `code` LIKE  '".$url."'";
	if ($result = mysqli_query($conn,$query)){
		if(mysqli_num_rows($result) > 0){
			
			$row = mysqli_fetch_array($result);
			
			$query1 = "	UPDATE `url` 
						SET `used` = `used` + 1
						WHERE `id` LIKE '".$row[0]."'";
			
			$result1 = mysqli_query($conn,$query1);
			
			header("Location: http://".$row[2]);
		}
	}
}

?>

<html>

<head>
	<!-- Meta -->
	<title>Mini Maker</title>
	
	<!-- Css -->
	<link rel="stylesheet" type="text/css" href="style.css">
	
	<!-- JavaScript -->
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	
</head>

<header>
	<div id="hContent">
		<h1>Mini Maker</h1>
		<sub><a href="http://joshlarminay.com">Main Site</a></sub>
	</div>
</header>

<body>
	<div id="bContent">
		<p>Here you can make a slightly smaller url!</p>
		
		<form action="result.php" method="post">
			<table id="inpat">
				<tr>
					<td>
						<input type="text" name="url" placeholder="URL To Shorten" required"></input>
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit"></input>
					</td>
				</tr>
			</table>
		</form>
		<h3>Most Recent</h3>
		<?php
		
		$query = "	SELECT * 
					FROM  `url` 
					WHERE CHAR_LENGTH(`site`) > 1
					Order by id desc
					LIMIT 10";
		$result = mysqli_query($conn, $query);
		$rows = mysqli_num_rows($result);
		
		echo ("<table border>");
		
		while ($row = mysqli_fetch_array($result)){
			$site = "mini.joshlarminay.com/?c=".$row[1];
			$length = strlen($site);
			echo ("<tr>");
			echo ("<td>");
			echo ("<a href='http://".$row[2]."'class='".$row[0]."'>http://".mb_strimwidth($row[2],0,$length,'...')."</a>");
			echo ("<br/>Turned To<br/>");
			echo ("<a href='http://".$site."' class='".$row[0]."'>http://".$site."</a>");
			echo ("</td><td>");
			echo ("<div class='show_".$row[0]."' style='border:1px solid grey;margin:10px;background-color:#cfcdcd'><b>Click To Show QR</b></div>");
			echo ("<div class='hide_".$row[0]."' style='border:1px solid grey;margin:10px;background-color:#cfcdcd;display:none;'><b>Click To Hide QR</b></div>");
			echo ("<img src='http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://".$site."' title='QR Code' class='".$row[0]."' style='display:none;padding:20px;'></image>");
			echo ("</td>");
			echo ("</tr>");
			echo ("
					<script>
						$('div[class=show_".$row[0]."]')
							.click(function(){
								$('img[class=".$row[0]."]').toggle('fast');
								$('div[class=show_".$row[0]."]').toggle();
								$('div[class=hide_".$row[0]."]').toggle();
							});
						$('div[class=hide_".$row[0]."]')
							.click(function(){
								$('img[class=".$row[0]."]').toggle('fast');
								$('div[class=show_".$row[0]."]').toggle();
								$('div[class=hide_".$row[0]."]').toggle();
							});
					</script>
				");
		}
		
		?>
	</div>
</body>

<footer>
	<div id="fContent">
		
	</div>
</footer>

</html>