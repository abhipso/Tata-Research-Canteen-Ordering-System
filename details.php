<?php 
session_start();
	if (isset($_SESSION['auth'])) {
		# code...
	
		if ($_SESSION['auth']!=1) {
			# code...
				header('Location: login.php');
				exit();
		}

	}
	else
	{
		header('Location: login.php');
		exit();
	}
	$username = $_SESSION['username'];

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Tata Research Canteen | IIEST Shibpur </title>
    <link rel="shortcut icon" type="/favicon.ico" href="icon.jpg">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
	<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/global.css">

</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="index.php">Tata Research Canteen</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="index.php">Home</a></li>
        <li><a href="orders.php">Your orders</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php" style="color: #FFFFFF;"><span class="glyphicon glyphicon-log-in"></span>Logout(<?php echo $username; ?>)</a></li>
      </ul>
    </div>
  </div>
</nav>

   
<div class="container" style=" max-width: 580px;">
	<?php
		$numberofitems=0;
		$a=file_get_contents('./menu.json');
		$json_a=json_decode($a,true);
		$category= array();
		foreach ($json_a['menu'] as $key => $value) 
		{
			$itemId='qty_'.$value['itemId'];
			if (isset($_SESSION[$itemId])) 
			{
				if ($_SESSION[$itemId]>0)
				{
					$numberofitems=$numberofitems+$_SESSION[$itemId];
				}
				elseif ($_SESSION[$itemId]<0) {
					# code...
					session_destroy();
					header("Location: login.php");
					exit();
				}
			}
		}
	if ($numberofitems>10) {
		# code...
		session_destroy();
		header("Location: login.php");
		exit();
	}
	?>
	<h2>Your order was successful!</h2>
	<div class="summery_head" style="text-align: left;font-size: 21px;">Order summary:</div>
	<div style="text-align: left; margin: 7px; font-size: 16px;">
	<?php
			$price=0;
			foreach ($json_a['menu'] as $key => $value) 
			{
				$itemId='qty_'.$value['itemId'];
				if (isset($_SESSION[$itemId])) 
				{
					if ($_SESSION[$itemId]>0)
					{
						echo $value['item'].'-'.$_SESSION[$itemId].'<br>';
						$price= $price+ $_SESSION[$itemId]*$value['pricePerItem'];
					}
			}
		}
	?>
	</div>
	<?php
		include('ordernumber.php');
		if (!isset($currentnumber)) {
			# code...
			$currentnumber=1;
			$odate=date('Y:m:d');
		}
		if (isset($currentnumber)&&($odate==date('Y:m:d'))) {
			# code...
			$currentnumber=$currentnumber+1;
		}
		if (isset($currentnumber)&&($odate!=date('Y:m:d'))) {
			# code...
			$currentnumber=1;
			$odate=date('Y:m:d');
			file_put_contents('ordernumber.php', '');			
		}
		$fh = fopen('ordernumber.php', "a");
		$new='<?php
		$currentnumber='.$currentnumber.';
		$odate="'.$odate.'";
		?>';
		fwrite($fh, $new);
		fclose($fh);
	?>

	<div class="ordernumber" style="text-align: left;font-size: 20px;">
		Order Number: <?php echo $currentnumber ?>
	</div>
	<div style="text-align: left;font-size: 20px;">Total price:  ₹ <?php echo $price ?></div><br>
	<div style="font-size: 18px;">Collect your order in some time.</div>
</div>

		

<script src="js/jquery.js"></script>
</body>
</html>