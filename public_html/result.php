<html>

<?php
require "../library/connect.php";
$conn = server_connect();

$min = 1;
$max = 1000000000;

$today = getdate();
$date = $today['year']."-".$today['mon']."-".$today['mday']." ".$today['hours'].":".$today['minutes'].":".$today['seconds'];

$old_url = $_POST["url"];
$old_url = preg_replace("#^https?://#", "", $old_url);

if ($_POST["url"] == ''){
	header("Location: http://mini.joshlarminay.com/");
}

$taken = True;
while ($taken == True){
	$number = dechex(rand($min,$max));
	
	$query = "	SELECT * 
				FROM  `url` 
				WHERE  `code` LIKE  '".$number."'";
	$result = mysqli_query($conn, $query);
	if(mysqli_num_rows($result) > 0){
		$taken = True;
	}
	else {
		$query = "	Insert Into pulotum_mini.url (code, site, date)
					values ('".$number."', '".$old_url."', '".$date."')";
		$result = mysqli_query($conn, $query);
		if ($result){
			$taken = False;
		}
	}
}

$new_url = "mini.joshlarminay.com/?c=" . $number;
$len_old = strlen($old_url);
$len_new = strlen($new_url);

?>

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
		<sub><a href="http://mini.joshlarminay.com">Go Back</a></sub>
	</div>
</header>

<body>
	<div id="bContent">

		
		<?php 
		echo ("<h2>Before</h2>");
		echo ("Originally " . $len_old . " characters.</br>");
		echo ($old_url);

		echo ("<h2>After</h2>");
		echo ("Now " . $len_new . " characters.</br>");
		echo ("<a href='http://".$new_url ."'>".$new_url."</a>");
		
		echo ("</br></br></br>");
		echo ("<img src='http://api.qrserver.com/v1/create-qr-code/?size=150x150&data=http://".$new_url."' title='QR Code'></image>");
		?>

	</div>
</body>

<footer>
	<div id="fContent">
	</div>
</footer>

</html>