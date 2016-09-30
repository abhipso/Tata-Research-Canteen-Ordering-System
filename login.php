<?php 
session_start();
session_destroy();
session_start();
if (isset($_POST["username"])&&isset($_POST["password"])) {
	# code...

//	echo "<script>alert('hii');</script>";
	$a=file_get_contents('./users.json');
	$json_users_a=json_decode($a,true);
	foreach ($json_users_a['users'] as $key => $value) {
	# code...
		if (($_POST["username"]==$value['username'])&&(md5($_POST['password'])==$value['password'])) {
			# code...
			$_SESSION['auth']=1;
			$_SESSION['username']=$value['username'];
			header('Location: index.php');
			//echo "authenticatd";

		}
		else {
		
		invalid_login();
		}
	//echo 'item is: '.$value['item'].'<br>';

}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Tata Research Canteen, IIEST Shibpur </title>
	    <link rel="stylesheet" href="./css/bootstrap.min.css">
 	<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="shortcut icon" type="/favicon.ico" href="icon.jpg">
    <link rel="shortcut icon" type="/favicon.ico" href="icon.jpg">

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
      <a class="navbar-brand" href="#">Tata Research Canteen</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Home</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
	<h1>Log In</h1>
		<form id="login" action="login.php" method="POST" onsubmit="return validate()">
		<div class="holder" style="display: inline;">
			<span class="input_title" style=" width: 165px; font-size: 18px;">Username :</span>
			<div style="color: red; display: none;" id="no_username">*Enter an username</div>
			<input type="text" name="username" style="height: 38px;" placeholder=""><br>
			
		</div>

		<span>
			<div class="input_title" style="width: 165px; font-size: 18px;"> Password :</div>
			<div style="color: red; display: none;" id="no_password">*Enter a password</div>
			<input type="password" name="password" style="height: 38px;" size="14" placeholder="Password">
			<br>
			
		</span>

			<br>
			<input type="submit" name="Login" value="Log In" style="color: white;
	text-decoration: none;
	background-color: #26b67c;
	padding: 5px 10px;
	height: 38px;
	font-size: 18px;
	width: 100px;" >
			<div style="color: red; display: none;" id="invalid_login">*Invalid Login</div>

		</form>
</div>

		<?php
		function invalid_login() {

		echo "<script src='js/jquery.js'></script><script type='text/javascript'>
	$(function() {
	$('#invalid_login').show('300').delay('20000').hide('50');

	});
</script>";
		}
		?>


<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/main.js"></script>

</body>
</html>