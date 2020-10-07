<!-- to see the quota of sale reps and how many they can cancel -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
	<title> Reps Quota</title>
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
	$sql = "SELECT * FROM ordering WHERE (repsName='$reps' and HOUR(timediff(now(), time)) >= 24 and status = 0)";
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

    $conn->close();
?>  


<body>

	<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
		<nav class="uk-navbar-container" uk-navbar>

			<div class="uk-navbar-left">
				<img src="images/logo.png" class="index-logo"/>
			</div>

			<div class="uk-navbar-right">
				<ul class="customer-index-navigate  rep-index-navigate">
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
    <div style="background-color: white;">
        <table id="quota-reps" class="reps-quota" frame=hsides rules=rows cellspacing=10>
            <caption id="quota-caption">Mask Quota</caption>
            <tr>
                <th class="reps-quota"></td>
                <th class="reps-quota"><p></p>Remain Quota<p></p></th>
                <th class="reps-quota"><p></p>Statue<p></p></th>
                <th class="reps-quota"><p></p>Processing order<p></p></th>
                <th class="reps-quota"><p></p>Can Cancel<p></p></th>
            </tr>
            <tr>
                <th class="reps-quota"><p></p>N95 Respirators<p></p></th>
                <td class="reps-quota"><p></p><?=$quotaN95?><p></p></td>
                <?php if($quotaN95 > 0){ ?>
                    <td class="reps-quota"><p></p>Remain<p></p></td>
                <?php } else if ($quotaN95 == 0) { ?>
                    <td class="reps-quota"><p></p>No Remain Quota<p></p></td>
                <?php } else { ?>
                    <td class="reps-quota"><p></p>Order over Quota<p></p></td>
                <?php } ?>
                <td class="reps-quota"><p></p><?=$wholeN95?><p></p></td>
                <?php if($quotaN95 >= 0){ ?>
                    <td class="reps-quota"><p></p>0<p></p></td>
                <?php } else { ?>
                    <td class="reps-quota"><p></p><?=$wholeN95?><p></p></td>
                <?php } ?>
            </tr>
            <tr>
                <th class="reps-quota"><p></p>Surgical Masks<p></p></th>
                <td class="reps-quota"><p></p><?=$quotaSm?><p></p></td>
                <?php if($quotaSm > 0){ ?>
                    <td class="reps-quota"><p></p>Remain<p></p></td>
                <?php } else if ($quotaSm == 0) { ?>
                    <td class="reps-quota"><p></p>No Remain Quota<p></p></td>
                <?php } else { ?>
                    <td class="reps-quota"><p></p>Order over Quota<p></p></td>
                <?php } ?>
                <td class="reps-quota"><p></p><?=$wholeSm?><p></p></td>
                <?php if($quotaSm >= 0){ ?>
                    <td class="reps-quota"><p></p>0<p></p></td>
                <?php } else { ?>
                    <td class="reps-quota"><p></p><?=$wholeSm?><p></p></td>
                <?php } ?>
            </tr>
            <tr>
                <th class="reps-quota"><p></p>Surgical N95 Respirators<p></p></th>
                <td class="reps-quota"><p></p><?=$quotaN95m?><p></p></td>
                <?php if($quotaN95m > 0){ ?>
                    <td class="reps-quota"><p></p>Remain<p></p></td>
                <?php } else if ($quotaN95m == 0) { ?>
                    <td class="reps-quota"><p></p>No Remain Quota<p></p></td>
                <?php } else { ?>
                    <td class="reps-quota"><p></p>Order over Quota<p></p></td>
                <?php } ?>
                <td class="reps-quota"><p></p><?=$wholeN95m?><p></p></td>
                <?php if($quotaN95m >= 0){ ?>
                    <td class="reps-quota"><p></p>0<p></p></td>
                <?php } else { ?>
                    <td class="reps-quota"><p></p><?=$wholeN95m?><p></p></td>
                <?php } ?>
            </tr>
        </table>
    </div>


</body>
<?php } else {
    header("location:login.php");
} ?>
</html>
