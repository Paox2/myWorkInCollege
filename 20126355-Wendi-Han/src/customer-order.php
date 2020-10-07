<!-- this page show the order of customer, including processing and finished order -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
	<title> Customer Order</title>
	<link rel="shortcut icon" href="images/logo1.ico" />
	<meta charset="utf-8">
	<link href="css/Woolin.css" type="text/css" rel="stylesheet"/>
		
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="../published/UIkit.css" />
	<!-- UIkit JS -->
	<script src="../published/uikit_min.js"></script>
	<script src="../published/uikit_icons_min.js"></script>
</head>

<body>

	<?php
    include("php/connect.php");
	$user = $_SESSION["username"];
	
	$sql = "SELECT * FROM ordering WHERE ((customerName='$user' and HOUR(timediff(now(), time)) >= 24) and status = 0) ORDER BY time DESC";
	$result1 = $conn->query($sql);
	$finishs = $result1->num_rows;
	
	$sql = "SELECT * FROM ordering WHERE ((customerName='$user' and HOUR(timediff(now(), time)) < 24) and status = 0) ORDER BY time DESC";
	$result2 = $conn->query($sql);
	$processing = $result2->num_rows;
    $pro = 1;
    $fin = 1;
	$conn->close();
	?>

	<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
		<nav class="uk-navbar-container" uk-navbar>

			<div class="uk-navbar-left">
				<img src="images/logo.png" class="index-logo"/>
			</div>

			<div class="uk-navbar-right">
				<ul class="customer-index-navigate">
					<li  class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-index.php">Mask Info</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-purchase.php">Mask Purchase</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-inform.php">Inform</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-order.php">Order list</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-account.php">Account</a></li>
					<?php if(isset($_SESSION["username"])){?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="php/logout.php">Log out</a></li>
					<?php } else { ?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="login.php">Sign in</a></li>
					<?php }?>
				</ul>
			</div>
		</nav>
	</div>
	
	<nav class="uk-navbar-container uk-margin" uk-navbar="mode:click">
		<div class="uk-navbar-center uk-card-header">
			<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: #customerOrderSelect">
				<li><a href="#">Finished Order</a></li>
				<li><a href="#">Processing Order</a></li>
			</ul>
		</div>
	</nav>

	<div class="uk-overflow-auto uk-navbar-item">
		<ul class="uk-switcher customer-order-list" id="customerOrderSelect">
			<li>
				<div>
				<form method="post" action='php/delete-order.php'>
				<?php 	if($finishs > 0){
							while($row = $result1->fetch_assoc()){?>
							<div class="uk-card uk-card-default uk-card-body uk-margin customer-order-card">
								<ul class="customer-order-list">
                                    <li class="customer-order-list order-ID"><?=$fin?></li><br/><?php $fin++; ?>
                                    <hr/>
									<li class="customer-order-list" style="background-image: url('images/region.png');background-size: 20px;background-repeat:no-repeat;padding-left: 40px; ">Region: <?=$row['region']?></li>
									<li class="customer-order-list" style="background-image: url('images/reps.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Reps Sale: <?=$row['repsName']?></li>
                                    <?php
                                        include("php/connect.php");
                                        $repsName = $row['repsName'];
                                        $sql = "SELECT tel FROM reps WHERE username = '$repsName'";
                                        $result = $conn->query($sql);
                                        $rows = $result->fetch_assoc();
                                        $repsPhone = $rows['tel'];
                                        $conn->close();
                                    ?>
									<li class="customer-order-list" style="background-image: url('images/tel.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Reps Phone: <?=$repsPhone?></li>
									<li class="customer-order-list" style="background-image: url('images/time.png');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Order Time: <?=$row['time']?></li><br/>
                                    <?php if($row['N95']>0){?>
                                    <li class="customer-order-tt" style="background-image: url('images/n95p.png');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">N95 Respirators: <?=$row['N95']?></li>
                                    <?php }
                                    if($row['sm']>0){?>
                                    <li class="customer-order-tt" style="background-image: url('images/smp.png');background-size: 35px;background-repeat:no-repeat;padding-left: 40px; ">Surgical Masks: <?=$row['sm']?></li>
                                    <?php }
                                    if($row['N95m']>0){?>
                                    <li class="customer-order-tt" style="background-image: url('images/n95mp.png');background-size: 35px;background-repeat:no-repeat;padding-left: 40px; ">Surgical N95 Respirators: <?=$row['N95m']?></li>
                                    <?php } ?>
									<li class="customer-order-tt" style="background-image: url('images/prize.jpg');background-size: 15px;background-repeat:no-repeat;padding-left: 40px; ">Sum price: <?=$row['sumprice']?></li><br/>
								</ul>
							</div>

					<?php	}
						} else {?>
						<div class="customer-order-no"> There are no finished order. </div>
				<?php	}?>
				</form>
				</div>
			</li>
			<li>
				<div>
				<?php 	if($processing > 0){
							while($row = $result2->fetch_assoc()){?>
							<div class="uk-card uk-card-default uk-card-body uk-margin customer-order-card">
								<ul class="customer-order-list">
                                    <li class="customer-order-list order-ID"><?=$fin?></li><br/><?php $fin++; ?>
                                    <hr/>
									<li class="customer-order-list" style="background-image: url('images/region.png');background-size: 20px;background-repeat:no-repeat;padding-left: 40px; ">Region: <?=$row['region']?></li>
                                    <li class="customer-order-list" style="background-image: url('images/reps.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Reps Sale: <?=$row['repsName']?></li>
                                    <?php
                                        include("php/connect.php");
                                        $repsName = $row['repsName'];
                                        $sql = "SELECT tel FROM reps WHERE username = '$repsName'";
                                        $result = $conn->query($sql);
                                        $rows = $result->fetch_assoc();
                                        $repsPhone = $rows['tel'];
                                        $conn->close();
                                    ?>
									<li class="customer-order-list" style="background-image: url('images/tel.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Reps Phone: <?=$repsPhone?></li>
									<li class="customer-order-list" style="background-image: url('images/time.png');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Order Time: <?=$row['time']?></li><br/>
									<?php if($row['N95']>0){?>
									<li class="customer-order-tt" style="background-image: url('images/n95p.png');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">N95 Respirators: <?=$row['N95']?></li>
									<?php }
									if($row['sm']>0){?>
									<li class="customer-order-tt" style="background-image: url('images/smp.png');background-size: 35px;background-repeat:no-repeat;padding-left: 40px; ">Surgical Masks: <?=$row['sm']?></li>
									<?php }
									if($row['N95m']>0){?>
									<li class="customer-order-tt" style="background-image: url('images/n95mp.png');background-size: 35px;background-repeat:no-repeat;padding-left: 40px; ">Surgical N95 Respirators: <?=$row['N95m']?></li>
									<?php } ?>
									<li class="customer-order-tt" style="background-image: url('images/prize.jpg');background-size: 15px;background-repeat:no-repeat;padding-left: 40px; ">Sum price: <?=$row['sumprice']?></li><br/>
									<button class="uk-button uk-button-default" type="button"  style="float: right; background-color:#2a5caa; color: white;" onclick="setID(<?=$row['orderID']?>);">>Delete</button>
								</ul>
							</div>

					<?php 	}
						} else {?>
						<div class="customer-order-no"> There are no processing order. </div>
				<?php 	}?>
				</div>
			</li>
		</ul>
	</div>

    
<script type="text/javascript">
	
	function setID(n){
		document.cookie = "orderID" + "=" + n;
		window.location.href="php/delete-order.php";
	}

</script>
	
	
</body>
<?php } else { 
		header("location:login.php");
 } ?> 
</html>