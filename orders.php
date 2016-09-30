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
        <li class="dropdown">
        <li class="active"><a href="orders.php">Your orders</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php" style="color: #FFFFFF;"><span class="glyphicon glyphicon-log-in"></span>Logout(<?php echo $username; ?>)</a></li>
      </ul>
    </div>
  </div>
</nav>

   
<div class="container" style=" max-width: 680px; text-align: left;" >
	<h2 id="h2">Please Confirm Your Orders</h2>
	<div id="conf_orders">
		<div id="conf_orders_title">
			You have ordered for :
		</div>
		<form id="confform" action="ordering.php" method="POST">
		<?php
			$a=file_get_contents('./menu.json');
			$json_a=json_decode($a,true);
			$category= array();
			$numorders=0;
			$i=1;
			foreach ($json_a['menu'] as $key => $value)
			{
				$itemId='qty_'.$value['itemId'];
				if (isset($_SESSION[$itemId]))
				{
					if ($_SESSION[$itemId]>0) 
					{
						echo '<div class="eachfinalorder" id="eachfinalorder_'.str_replace(' ', '', $value['item']).'">'.$i.'. '.$value['item'].'-<input id="finalorderinput_'.str_replace(' ', '', $value['item']).'" name="qty_'.$value['itemId'].'" type="text" value="'.$_SESSION[$itemId].'" size="1" readonly> 
						<button type="button" class="increase" data-increase="#finalorderinput_'.str_replace(' ', '', $value['item']).'" class="ordaction">+</button> 
						<button type="button" class="decrease" data-decrease="#finalorderinput_'.str_replace(' ', '', $value['item']).'" class="ordaction">-</button>  
						<button type="button" class="cancel" href="#" data-cancel="#finalorderinput_'.str_replace(' ', '', $value['item']).'" class="ordaction">cancel</button>
						</div><br>';
						$numorders++;
						$i++;
					}
				}
			}
			if ($numorders==0) {
					echo "<script type=\"text/javascript\">
						$('#h2').html('You have not orderd anything yet.');
						$('#conf_orders_title').html('<a href=\'index.php\'>Click here</a> to order now!');
					</script>";
				}
		?>
		<input type="hidden" name="wherefrom" value="verified">
		<span class="totalcost" style="float: left; margin-top: 8px;"> Total cost is <strong><span id="fprice">0</span> Rupees</strong></span><br>
		<div style="padding-top: 8px;"><div id="cmorethan10" style="display: none;float: left;color: red;">*Sorry, maximum limit of ordering is 10 items</div><br></div>
		<a class="goback"  href="index.php">Go back</a>
		<input id="csubmit" type="submit" style="color: white;
	text-decoration: none;
	background-color: #26b67c;
	padding: 5px 10px;
	height: 38px;
	font-size: 18px;
	width: 150px;
	border-radius: 5px;
	border-width: 0;" value="Confirm Order" name="submit">
		
		</form>
	</div>
</div>

<script src="js/jquery.js"></script>
<script type="text/javascript">
	$('.cancel').on('click',function () {
		var panelid = $(this).attr('data-cancel');
		$(panelid).val(0);

	});
	$('.increase').on('click',function (){
		var panelid = $(this).attr('data-increase');
		if(parseInt($(panelid).val())<10) 
		{
			var inputval = parseInt($(panelid).val()) + 1;
			$(panelid).val(inputval);
		}
		

	});
	$('.decrease').on('click',function (){
		var panelid = $(this).attr('data-decrease');
		if (parseInt($(panelid).val())>0)
		{	
			var inputval = parseInt($(panelid).val()) - 1;
			$(panelid).val(inputval);
		}
	});
		setInterval(function()
		{
			var k=0;
			var numberofitems = 0;

			<?php
			//echo 'alert("infor");';
			foreach ($json_a['menu'] as $key => $value)
			{
		    				# code...
				//if (isset()) {}
				
				
				  //it doesn't exist
				
					echo 'if($("#finalorderinput_'.str_replace(' ', '', $value['item']).'").length != 0) 
					{	
						var p = '.$value['pricePerItem'].';
						var d = $("#finalorderinput_'.str_replace(' ', '', $value['item']).'").val();
						k = k + parseInt(p) * parseInt(d);
						numberofitems = numberofitems + parseInt(d);
					}';
				
			}
			?>
	        
	    //    k=parseInt(p) * parseInt(d);
			$(function() {
			$('#fprice').html(k);


		});

			var count =0;
			<?php
			foreach ($json_a['menu'] as $key => $value)
			{
		    				# code...
				echo 'var p = $("#finalorderinput_'.str_replace(' ', '', $value['item']).'").val();
				if (p!=NaN && p>0) 
				{
					count = count + parseInt(p);
				}
				if (count>10)
				{
					$("#csubmit").prop("disabled",true);
					$("#cmorethan10").show();
				}
				if (count<=10)
				{
					$("#csubmit").prop("disabled",false);
					$("#cmorethan10").hide();
				}
				';
		}
	?>
	    }, 200);
		<?php
				 if ($numorders==0)
				 {
				 	echo '$("#csubmit").hide();';
				 } 
		?>
</script>
</body>
</html>