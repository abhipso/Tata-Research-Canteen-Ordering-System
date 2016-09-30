<?php
	session_start();
	if (isset($_SESSION['auth'])) {
		if ($_SESSION['auth']!=1) {
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
	$numberofitems=0;
	$a=file_get_contents('./menu.json');
	$json_a=json_decode($a,true);
	$category= array();
	foreach ($json_a['menu'] as $key => $value) 
	{
		$itemId='qty_'.$value['itemId'];
		if (isset($_POST[$itemId])) 
		{
			if (htmlspecialchars($_POST[$itemId])>0)
			{
				$numberofitems=$numberofitems+htmlspecialchars($_POST[$itemId]);
			}
			$_SESSION[$itemId]=htmlspecialchars($_POST[$itemId]);
		}
	}
	if ($numberofitems>10) {
		# code...
		session_destroy();
		header("Location: login.php");
		exit();
	}

	if (isset($_POST['wherefrom'])) {
		if ((htmlspecialchars($_POST['wherefrom'])) =='notverified') {
				header('Location: orders.php');
				exit();
		}
		elseif ((htmlspecialchars($_POST['wherefrom'])) =='verified') 
		{
			
			header('Location: details.php');
			exit();	
		}
		else
		{
			header('Location: login.php');
			exit();
		}
	}
	else
	{
		header("Location: orders.php");
		exit();
	}

?>