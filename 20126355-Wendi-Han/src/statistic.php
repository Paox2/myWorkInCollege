<!-- statistics for manager, include total statistic, processing order statistic, finished order statistic,
 statistic by time, region and customer, also, manager can modify the price in these page. -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
	<title> Manager Statistic</title>
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
	$user = $_SESSION["username"];

	$sql = "SELECT SUM(N95) as sumN95, SUM(sm) as sumSM, SUM(N95m) as sumN95M, (SUM(N95) + SUM(Sm) + SUM(N95m)) as totalNum, SUM(sumprice) as totalRevenues FROM ordering WHERE ordering.status = 0";
	$result1 = $conn->query($sql);
	$totalSale = $result1->num_rows;
    $row = $result1->fetch_assoc();
    $sumN95 = $row['sumN95'];
    $sumSm = $row['sumSM'];
    $sumN95m = $row['sumN95M'];
    $totalNum = $row['totalNum'];
    $totalRevenues = $row['totalRevenues'];

    $sql = "SELECT region, SUM(N95) as sumN95, SUM(sm) as sumSM, SUM(N95m) as sumN95M, (SUM(N95) + SUM(Sm) + SUM(N95m)) as totalNum, SUM(sumprice) as totalRevenues FROM ordering WHERE ordering.status = 0 GROUP BY region ORDER BY region";
    $result2 = $conn->query($sql);
    $result6 = $conn->query($sql);
    $regionSale = $result2->num_rows;

	$sql = "SELECT SUM(N95) as sumN95, SUM(sm) as sumSM, SUM(N95m) as sumN95M, (SUM(N95) + SUM(Sm) + SUM(N95m)) as totalNum, SUM(sumprice) as totalRevenues FROM ordering WHERE (Hour(timediff(now(), time)) >= 24 and status = 0)";
	$result3 = $conn->query($sql);
	$finishs = $result3->num_rows;

	$sql = "SELECT SUM(N95) as sumN95, SUM(sm) as sumSM, SUM(N95m) as sumN95M, (SUM(N95) + SUM(Sm) + SUM(N95m)) as totalNum, SUM(sumprice) as totalRevenues FROM ordering WHERE (HOUR(timediff(now(), time)) < 24 and status = 0)";
	$result4 = $conn->query($sql);
	$processing = $result4->num_rows;

    $sql = "SELECT customerName, SUM(N95) as sumN95, SUM(sm) as sumSM, SUM(N95m) as sumN95M, (SUM(N95) + SUM(Sm) + SUM(N95m)) as totalNum, SUM(sumprice) as totalRevenues FROM ordering WHERE ordering.status = 0 GROUP BY customerName ORDER BY totalRevenues DESC";
    $result5 = $conn->query($sql);
    $customerStatistic = $result5->num_rows;



    $rows = $result6->fetch_assoc();
    $region = $rows['region'];
    $sql = "SELECT COUNT(username) as customerNum FROM customer WHERE region='$region'";
    $result7 = $conn->query($sql);
    $row = $result7->fetch_assoc();
    $customerNum = $row['customerNum'];

    $sql = "SELECT region From ordering WHERE status = 0 GROUP BY region ORDER BY sumprice DESC";
    $result8 = $conn->query($sql);
    $row = $result8->fetch_assoc();
    $championRegion = $row['region'];

    $sql = "SELECT customerName From ordering WHERE status = 0 GROUP BY customerName ORDER BY sumprice DESC";
    $result9 = $conn->query($sql);
    $row = $result9->fetch_assoc();
    $championCus = $row['customerName'];

    $sql = "SELECT customerName as customerNumber FROM ordering WHERE status = 0 GROUP BY customerName";
    $result10 = $conn->query($sql);
    $customerNumber = $result10->num_rows;

    $sql = "SELECT SUM(sumprice) as championCustomerCost, (SUM(N95)+SUM(sm)+SUM(N95m)) as championCustomerNum FROM ordering WHERE (customerName = '$championCus' and status = 0)";
    $result11 = $conn->query($sql);
    $row = $result11->fetch_assoc();
    $championCustomerCost = $row['championCustomerCost'];
    $championCustomerNum = $row['championCustomerNum'];

    $sql = "SELECT name, price FROM prices WHERE (name='N95' or name='Sm' or name='N95m')";
    $result12 = $conn->query($sql);
    while ($prices = $result12->fetch_assoc()) {
        if ($prices['name'] == 'N95') {
            $N95prices = $prices['price'];
        } else if ($prices['name'] == 'N95m') {
            $N95mprices = $prices['price'];
        } else if ($prices['name'] == 'Sm') {
            $Smprices = $prices['price'];
        }
    }

    $n = 0;

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
					<li  class="uk-active customer-index-navigate-li"><a class="customer-index-navigate-a" href="manager-index.php">Manage Reps Sale</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="statistic.php">Statistics</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="manager-inform.php">Inform</a></li>
                    <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="manager-account.php">Account</a></li>
					<?php if(isset($_SESSION["username"])){?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="php/logout.php">Log out</a></li>
					<?php } else { ?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="login.php">Sign in</a></li>
					<?php }?>
				</ul>
			</div>
		</nav>
	</div>

    <!-- check and update price -->
    <div class="statistics-total shadow">
        <p><br/></p>
        <h2 class="statistics-total-title">N95 respirators price: $<?=$N95prices?> <a href="<?php echo "update.php?change=N95price&log=N95price&price=".$N95prices ?>"><img src="images/set.png" width="20px" height="20px" /></a></h2>
        <h2 class="statistics-total-title">surgical masks: $<?=$Smprices?> <a href="<?php echo "update.php?change=Smprice&log=Smprice&price=".$Smprices ?>"><img src="images/set.png" width="20px" height="20px" /></a></h2>
        <h2 class="statistics-total-title">surgical N95 respirators: $<?=$N95mprices?> <a href="<?php echo "update.php?change=N95mprice&log=N95mprice&price=".$N95mprices ?>"><img src="images/set.png" width="20px" height="20px" /></a></h2>
        <p><br/></p>
    </div>

    <!-- total statistics table -->
    <div class="statistics-total shadow">
        <p><br/></p>
        <h2 class="statistics-total-title">Total Statistics</h2>

        <table class="manager-quota" frame=hsides rules=rows cellspacing=10>
            <tr class="even">
                <th>Total N95</th>
                <th>Total Sm</th>
                <th>Total N95m</th>
                <th>Total Number</th>
                <th>Total Revenues</th>
            </tr>
            <tr class="odd">
                <th><?=$sumN95?></th>
                <th><?=$sumSm?></th>
                <th><?=$sumN95m?></th>
                <th><?=$totalNum?></th>
                <th><?=round($totalRevenues)?></th>
            </tr>
        </table>
        <br/><br/><br/>


        <!-- total statistics table(processing) -->
        <h2 class="statistics-total-title">Total Statistics(Processing)</h2>

        <table class="manager-quota" frame=hsides rules=rows cellspacing=10>
            <tr class="even">
                <th>Total N95</th>
                <th>Total Sm</th>
                <th>Total N95m</th>
                <th>Total Number</th>
                <th>Total Revenues</th>
            </tr>
            <tr class="odd">
                <?php $row = $result4->fetch_assoc();
                if ($row['sumN95'] > 0){ ?>
                    <th><?=$row['sumN95']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['sumSM'] > 0){ ?>
                    <th><?=$row['sumSM']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['sumN95M'] > 0){ ?>
                    <th><?=$row['sumN95']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['totalNum'] > 0){ ?>
                    <th><?=$row['totalNum']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['totalRevenues'] > 0){ ?>
                    <th><?=round($row['totalRevenues'])?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php } ?>
            </tr>
        </table>
        <br/><br/><br/>

        <!-- total statistics table(finished) -->
        <h2 class="statistics-total-title">Total Statistics(Finished)</h2>

        <table class="manager-quota" frame=hsides rules=rows cellspacing=10>
            <tr class="even">
                <th>Total N95</th>
                <th>Total Sm</th>
                <th>Total N95m</th>
                <th>Total Number</th>
                <th>Total Revenues</th>
            </tr>
            <tr class="odd">
                <?php $row = $result3->fetch_assoc();
                if ($row['sumN95'] > 0){ ?>
                    <th><?=$row['sumN95']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['sumSM'] > 0){ ?>
                    <th><?=$row['sumSM']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['sumN95M'] > 0){ ?>
                    <th><?=$row['sumN95']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['totalNum'] > 0){ ?>
                    <th><?=$row['totalNum']?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php }
                if ($row['totalRevenues'] > 0){ ?>
                    <th><?=round($row['totalRevenues'])?></th>
                <?php } else{ ?>
                    <th>0</th>
                <?php } ?>
            </tr>
        </table>
        <br/><br/><br/>

    </div>
    <br/>

    <!-- total statistics by region -->
    <div class="statistics-total shadow">
        <p><br/></p>
        <div class="manager-index-container">
            <div class="manager-select-wrapper">
                <div class="manager-index-p">
                    <img src="images/champion.jpg" width="40px"/> Sale champion region: <?=$championRegion ?>
                </div>
                <div class="manager-index-p">
                    Select region to see(only the region have orders):
                </div>
                <select id="selectRegion" onchange="changeRegion(this.value);" class="region">
                    <?php while ($row = $result2->fetch_assoc()) {?>
                        <option value="<?=$row['region'] ?>" class="region"><?=$row['region'] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="manager-index-container2 clearfix" id="showRegion">
                <table class="manager-quota2" frame=hsides rules=rows cellspacing=10>
                    <caption class="statistics-total-title" id="quota-caption">Region statistics</caption>
                    <tr class="quota-table even">
                        <th>N95 respirators</th>
                        <th>surgical masks</th>
                        <th>surgical N95 respirators</th>
                        <th>total Number</th>
                        <th>total Revenues</th>
                        <th>customer number</th>
                    </tr>
                    <tr class="quota-table odd">
                        <th><?=$rows['sumN95'] ?></th>
                        <th><?=$rows['sumSM'] ?></th>
                        <th><?=$rows['sumN95M'] ?></th>
                        <th><?=$rows['totalNum'] ?></th>
                        <th><?=round($rows['totalRevenues'])?></th>
                        <th><?=$customerNum ?></th>
                    </tr>
                </table>
        </div><br/>
    </div>
    <br/>

    <!-- total statistics by time -->
    <div class="statistics-total shadow">
        <p><br/></p>
        <h2 class="statistics-total-title">Statistics(A range of time)</h2>

        <div class = "manager-index-container" style="font-size:25px; font-family: Trebuchet MS, sans-serif;">
            <label>Start Date: &nbsp&nbsp&nbsp&nbsp<input style="height: 30px; font-size: 20px;margin: 10px;" id="startDate" type="text" placeholder="2020-05-19" required pattern="^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$"/></label><br>
            <label>End Date(not include): <input style="height: 30px; font-size: 20px;margin: 10px;" id="endDate" type="text" placeholder="2020-05-19"  required pattern="^(?:(?!0000)[0-9]{4}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-8])|(?:0[13-9]|1[0-2])-(?:29|30)|(?:0[13578]|1[02])-31)|(?:[0-9]{2}(?:0[48]|[2468][048]|[13579][26])|(?:0[48]|[2468][048]|[13579][26])00)-02-29)$"/></label><br>
            <input class="uk-button uk-button-default" style="margin: 10px; background-color:#2a5caa; color: white;" type="submit" onclick="showDate(startDate.value, endDate.value);"/>
        </div><br/>

        <div id="tableShow"></div>
    </div><br/>

    <!-- total statistics by customer -->
    <div class="statistics-total shadow">
        <p><br/></p>
        <div class="manager-index-container2 clearfix">
        <table class="manager-quota2" frame=hsides rules=rows cellspacing=10>
            <caption class="statistics-total-title" style="font-size: 2em">Statistics(Customer)</caption>
            <tr class="quota-table even">
                <th>Number</th>
                <th>Ave(cost)</th>
                <th>Average(purchase)</th>
                <th>Purchase most</th>
                <th>Purchase cost</th>
                <th>Purchase number</th>
            </tr>
            <tr class="quota-table odd">
                <th><?=$customerNumber ?></th>
                <th><?=round(($totalRevenues/$customerNumber)) ?></th>
                <th><?=round(($totalNum/$customerNumber))  ?></th>
                <th><?=$championCus ?></th>
                <th><?=round($championCustomerCost) ?></th>
                <th><?=$championCustomerNum ?></th>
            </tr>
        </table>
        </div>

        <div class="manager-index-container2 clearfix">
            <table class="manager-quota2" frame=hsides rules=rows cellspacing=10>
                <caption class="statistics-total-title" style="font-size: 2em">customer(only have ordering)</caption>
                <tr class="quota-table even">
                    <th>name</th>
                    <th>total cost</th>
                    <th>N95 respirators</th>
                    <th>surgical masks</th>
                    <th>surgical N95 respirators</th>
                </tr>
                <?php while($row = $result5->fetch_assoc()) {
                    if($n / 2 == 0){?>
                    <tr class="quota-table odd">
                        <th><?=$row['customerName'] ?></th>
                        <th><?=round($row['totalRevenues']) ?></th>
                        <th><?=$row['sumN95'] ?></th>
                        <th><?=$row['sumSM'] ?></th>
                        <th><?=$row['sumN95M'] ?></th>
                    </tr>
                    <?php $n++;} else {?>
                    <tr class="quota-table odd">
                        <th><?=$row['customerName'] ?></th>
                        <th><?=round($row['totalRevenues']) ?></th>
                        <th><?=$row['sumN95'] ?></th>
                        <th><?=$row['sumSM'] ?></th>
                        <th><?=$row['sumN95M'] ?></th>
                    </tr>
                <?php $n++;}}?>
            </table>
        </div>

        <br/><br/><br/>

    </div><br/><br/><br/>


    <script>

        function changeRegion(region)
        {
            if (region=="")
            {
                document.getElementById("txtHint").innerHTML="no input";
                return;
            }
            if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("showRegion").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","php/showR.php?region="+region,true);
            xmlhttp.send();
        }

        function showDate(start, end)
        {
            if (start=="" || end=="")
            {
                document.getElementById("txtHint").innerHTML="no input";
                return;
            }
            if (window.XMLHttpRequest)
            {
                xmlhttp=new XMLHttpRequest();
            }
            else
            {
                xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange=function()
            {
                if (xmlhttp.readyState==4 && xmlhttp.status==200)
                {
                    document.getElementById("tableShow").innerHTML=xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET","php/showT.php?start="+start+"&end="+end,true);
            xmlhttp.send();
        }
    </script>

</body>
<?php } else {
    header("location:login.php");
} ?>
</html>
