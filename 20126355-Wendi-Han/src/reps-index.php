<!-- sale reps can scan order need to process by him, include processing and finished, for the processing
 order, if one type of mask over the quota, it will have a warning and reps can choose to delete order contains
  this type of masks-->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
	<title> Reps Index</title>
	<link rel="shortcut icon" href="images/logo1.ico" />
	<meta charset="utf-8">
	<link href="css/Woolin.css" type="text/css" rel="stylesheet"/>
		
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="../published/UIkit.css" />
	<!-- UIkit JS -->
	<script src="../published/uikit_min.js"></script>
	<script src="../published/uikit_icons_min.js"></script>
</head>

<?php
    include("php/connect.php");
    session_start();
	$reps = $_SESSION["username"];
	
    $sql = "SELECT quotaN95, quotaN95m, quotaSm FROM reps WHERE username='$reps'";
    $resultQuota = $conn->query($sql);
    $rows = $resultQuota->fetch_assoc();
    $quotaN95 = $rows['quotaN95']; 
    $quotaN95m = $rows['quotaN95m'];
    $quotaSm = $rows['quotaSm'];
    
    $wholeN95 = 0;
    $wholeN95m = 0;
    $wholeSm = 0;
    
	$sql = "SELECT * FROM ordering WHERE (repsName='$reps' and HOUR(timediff(now(), time)) >= 24  and status = 0)";
	$resultFinish = $conn->query($sql);
	$finishs = $resultFinish->num_rows;
	
	$sql = "SELECT * FROM ordering WHERE (repsName='$reps' and HOUR(timediff(now(), time)) < 24 and status = 0)";
	$resultProcessing = $conn->query($sql);
    $resultProcessing2 = $conn->query($sql);
	$processing = $resultProcessing->num_rows;
    
    while($row = $resultProcessing2->fetch_assoc()){
        $wholeN95 += $row['N95'];
        $wholeN95m += $row['N95m'];
        $wholeSm += $row['sm'];
    }
    $pro = 1;
    $fin = 1;
    $conn->close();
?>  


<body>
	<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
		<nav class="uk-navbar-container" uk-navbar>

			<div class="uk-navbar-left">
				<img src="images/logo.png" class="index-logo"/>
			</div>

			<div class="uk-navbar-right">
				<ul class="customer-index-navigate rep-index-navigate">
					<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="reps-index.php">Order list</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="reps-statistics.php">Customer Statistics</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="reps-quota.php">Mask Quota</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="reps-inform.php">Inform</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="reps-account.php">Account</a></li>
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
			<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: #repsOrderSelect">
				<li><a href="#">Finished Order</a></li>
				<li><a href="#">Processing Order</a></li>
			</ul>
		</div>
	</nav>
	
	<div class="uk-overflow-auto uk-navbar-item">
		<ul class="uk-switcher customer-order-list" id="repsOrderSelect">
			<li>
				<div>
				<?php 	if($finishs > 0){?>
					<?php	while($row = $resultFinish->fetch_assoc()){ ?>
							<div class="uk-card uk-card-default uk-card-body uk-margin customer-order-card">
								<ul class="customer-order-list">
                                    <li class="customer-order-list order-ID"><?=$fin?></li><br/><?php $fin++; ?>
                                    <hr/>
									<li class="customer-order-list" style="background-image: url('images/region.png');background-size: 20px;background-repeat:no-repeat;padding-left: 40px; ">Region: <?=$row['region']?></li>
									<li class="customer-order-list" style="background-image: url('images/reps.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Customer: <?=$row['customerName']?></li>
                                    <?php
                                        include("php/connect.php");
                                        $customerName = $row['customerName'];
                                        $sql = "SELECT tel FROM customer WHERE username = '$customerName'";
                                        $result = $conn->query($sql);
                                        $rows = $result->fetch_assoc();
                                        $customerPhone = $rows['tel'];
                                        $conn->close();
                                    ?>
									<li class="customer-order-list" style="background-image: url('images/tel.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Customer Phone: <?=$customerPhone?></li>
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
				</div>
			</li>
			<li>
				<div>
				<form method="post">
				<?php 	if($processing > 0){
                            
                            if($wholeN95 > $quotaN95){ ?>
                                    <div class="uk-alert-danger" uk-alert>
                                        <p class="reps-alert-notes">The number of N95 Respirators: over the quota, please choose to delete someone's order within 24h</p>
                                    </div>
                            <?php    }
                            if($wholeN95m > $quotaN95m){ ?>
                                    <div class="uk-alert-danger" uk-alert>
                                        <p class="reps-alert-notes">The number of Surgical N95 Respirators over the quota, please choose to delete someone's order within 24h</p>
                                    </div>
                            <?php    }
                            if($wholeSm > $quotaSm){ ?>
                                    <div class="uk-alert-danger" uk-alert>
                                        <p class="reps-alert-notes">The number of Surgical Masks: over the quota, please choose to delete someone's order within 24h</p>
                                    </div>
                            <?php   }
                            
							while($row = $resultProcessing->fetch_assoc()){?>
							<div class="uk-card uk-card-default uk-card-body uk-margin customer-order-card">
								<ul class="customer-order-list">
                                        <li class="customer-order-list order-ID"><?=$pro?></li><br/><?php $pro++; ?>
                                        <hr/>
                                        <li class="customer-order-list" style="background-image: url('images/region.png');background-size: 20px;background-repeat:no-repeat;padding-left: 40px; ">Region: <?=$row['region']?></li>
                                        <li class="customer-order-list" style="background-image: url('images/reps.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Customer: <?=$row['customerName']?></li>
                                    <?php
                                    include("php/connect.php");
                                        $customerName = $row['customerName'];
                                        $sql = "SELECT tel FROM customer WHERE username = '$customerName'";
                                        $result = $conn->query($sql);
                                        $rows = $result->fetch_assoc();
                                        $customerPhone = $rows['tel'];
                                        $conn->close();
                                    ?>
                                        <li class="customer-order-list" style="background-image: url('images/tel.jpg');background-size: 30px;background-repeat:no-repeat;padding-left: 40px; ">Customer Phone: <?=$customerPhone?></li>
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
                                        <li class="customer-order-tt" style="background-image: url('images/prize.jpg');background-size: 20px;background-repeat:no-repeat;padding-left: 40px; ">Sum price: <?=$row['sumprice']?></li><br/>
                                    <?php if(((0 > $quotaN95) &&  ($row['N95'] != 0)) || ((0 > $quotaN95m) && ($row['N95m'] != 0)) || ((0 > $quotaSm) && ($row['sm'] != 0))){ ?>
                                        <button class="uk-button uk-button-default" type="button"  style="float: right; background-color:#2a5caa; color: white;"onclick="setID(<?=$row['orderID']?>);">>Delete</button>
                                    <?php } ?>
                                </ul>
							</div>

					<?php 	}
						} else {?>
						<div class="customer-order-no"> There are no processing order. </div>
				<?php 	}?>
				</form>
				</div>
			</li>
		</ul>
	</div>


<script type="text/javascript">

	function setID(n){
		document.cookie = "orderID" + "=" + n;
		window.location.href="php/delete-order2.php";
	}

</script>
    
</body>
<?php } else {
    header("location:login.php");
} ?>
</html>
