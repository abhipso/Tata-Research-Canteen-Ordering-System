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
        <li class="active"><a href="#">Home</a></li>

        <li><a href="orders.php">Your orders</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="login.php" style="color: #FFFFFF;"><span class="glyphicon glyphicon-log-in"></span>Logout(<?php echo $username; ?>)</a></li>
      </ul>
    </div>
  </div>
</nav>

   
<div class="container" style=" max-width: 680px;">
	<div class="heading">
		<ul>
			<li id="headingmenu" style="width: 25%" class="headingmenu_selected"><a id="all_items" href="#">All Items</a></li>
			<li id="headingmenu" style="width: 35%" class="dropdown">
    	     	<a class="dropdown-toggle" data-toggle="dropdown"  href="#">Category<span class="caret"></span></a>
				<ul class="dropdown-menu">

						<?php
							$a=file_get_contents('./menu.json');
							$json_a=json_decode($a,true);
							$category= array();
							foreach ($json_a['menu'] as $key => $value) {
								if (!in_array($value['category'], $category))
								{
									array_push($category, $value['category']);
									$size= sizeof($category);
									echo '<li class="dd_cat" data-panelid="citems_'.str_replace(' ', '', $value['category']).'"><a href="#">'.$value['category'].'</a></li>';
								}
							}
						?>
          		</ul>	
			</li>
			<li>
				<form id="search" action="#">
					<input name="search" id="searchfield" style="background-color: #000; padding-left: 3px;border-width: 0;width: 100%;color: #FFFFFF;" placeholder="Search for item">
				</form>
			</li>
			
		</ul>


	</div>
	<div id="inbody">
				<form action="ordering.php" method="POST">
					<div>
						
					<input id="placeorder" type="submit" style="float: right;margin-left: 8px;margin-right: 18px;" value="Place order" name="submit">
					<span class="totalcost" style="float: right; margin-top: 4px;"> Total cost is <strong><span id="price">0</span> Rupees</strong></span>
					</div><br><br>
					<div id="morethan10" style="display: none; float: right; color: red;" class="morethan10">*Sorry, maximum limit of ordering is 10 items</div>
					<div id="searchresult"></div>
					<?php
						foreach ($category as $catname) 
						{
							echo '<div id="citems_'.str_replace(' ', '', $catname).'">';
							echo '<h2 class="h2">'.$catname.'</h2>';
							echo '<div class="initems">
							<table>';
							foreach ($json_a['menu'] as $key => $value) 
							{
								if ($catname==$value["category"])
								{	echo '<tr id="itemtd_'.str_replace(' ', '', $value['item']).'">';
									echo '<td width="128px"><span class="each_item">'.$value['item'].'</span></td>';
									echo '<td><span>Price per item:<span class="eachprice" id="pricePerItem_'.$value['itemId'].'">'.$value['pricePerItem'].'<span/></span></td>';
									echo '<td><select name="qty_'.$value['itemId'].'" style="display: inline;" id="qtty_'.$value['itemId'].'">';
					//				echo '<span style="display: none;" >''</span>';
									for($i=0; $i <=10 ; $i++)
									{
										echo '<option value="'.$i.'">'.$i.'</option>';
									}
									echo '</select></td>
									</tr>';
								}

							}
							echo "</table>
							</div>
							</div>";
						}
					?>
				<input type="hidden" name="wherefrom" value="notverified">
			</form>
	</div>
</div>

		

<script src="js/jquery.js"></script>
<script type="text/javascript">

   	var itemarray = [];
   	<?php
   		foreach ($json_a['menu'] as $key => $value)
   		{
		    echo 'itemarray.push("'.$value['item'].'");';
	   	}
   	?>
	var searchtext_old = $('#searchfield').val();

	setInterval(function(){
	var k=0;
	var numberofitems = 0;

	<?php
		foreach ($json_a['menu'] as $key => $value)
		{
		    				# code...
			echo 'var p = $("#pricePerItem_'.$value['itemId'].'").text();
			var d = $("#qtty_'.$value['itemId'].'").val();
			k = k + parseInt(p) * parseInt(d);
			numberofitems = numberofitems + parseInt(d);    ';
		}
	?>
	        
	    //    k=parseInt(p) * parseInt(d);
			$(function() {
			$('#price').html(k);


		});
		if (numberofitems>10) {
			$('#morethan10').show(300);
			$('#placeorder').prop('disabled',true);
			
		}
		else
		{
			$('#morethan10').hide(300);
			$('#placeorder').prop('disabled',false);

		}
							// searching.... :
		var index,avalue,fl,scount;
		if (searchtext_old !== $('#searchfield').val()) 
		{
				var scount=0;
				searchtext = $('#searchfield').val();
				if (searchtext != ''&&searchtext !=undefined) 
				{    
					$('.h2').hide();
					for (index=0; index < itemarray.length; ++index) 
					{
						avalue= itemarray[index];
						$('#itemtd_'+ avalue.replace(/ /g,'')).hide();
						if (avalue.substring(0,searchtext.length).toLowerCase() === searchtext.toLowerCase())
						{
							$('#itemtd_'+ avalue.replace(/ /g,'')).show();
							scount++;
						}
					}
					if (scount>0)
					{
						$('#searchresult').html('Here are the search results for "'+searchtext+'" :');
					}
					else if(scount==0)
					{
						$('#searchresult').html('No matches found..');
					}
				}
				
				if($('#searchfield').val()  == '' ||$('#searchfield').val()== undefined)
				{
					$('.h2').show();
					for (var i = 0; i < itemarray.length; ++i) 
					{	
						console.log(itemarray[i]);
						$('#itemtd_'+itemarray[i].replace(/ /g,'')).show();
					}
					$('#searchresult').html('');

				}
				searchtext_old=searchtext;
		}

    }, 200);
	$('.dd_cat').on('click', function() {
		var panelid = $(this).attr('data-panelid');
		//alert(panelid);
		<?php
		foreach ($json_a['menu'] as $key => $value) {
		    				# code...
		    				echo '$("#citems_'.str_replace(' ', '', $value['category']).'").slideUp();
		    				';
		    			}
		    			?>
		$('#'+panelid).slideDown();
	});
	$('#all_items').on('click', function() {
				<?php
					foreach ($json_a['menu'] as $key => $value) 
						{
		    				echo '$("#citems_'.str_replace(' ', '', $value['category']).'").slideDown(\'800\');';
		    			}
		    	?>
	});

</script>
</body>
</html>