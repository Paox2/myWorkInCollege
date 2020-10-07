<!-- inform if the reps this manager responsible has a negative quota and cannot back to normal by cancel
 customer's order, it will show which masks and who cannot back to normal. -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Manager Inform</title>
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

$sql = "SELECT reps.username as repsName, quotaN95, quotaSm, quotaN95m FROM reps WHERE (reps.managerName = '$user' and (quotaN95 < 0 or quotaSm < 0 or quotaN95m < 0)) GROUP BY reps.username";
$result1 = $conn->query($sql);
$result2 = $conn->query($sql);
$quotaWarn = $result1->num_rows;
$n = 0;
if($quotaWarn > 0){
    while($row = $result1->fetch_assoc()){
        $repname = $row['repsName'];
        $sql = "SELECT SUM(N95) as sumN95, SUM(sm) as sumSm, SUM(N95m) as sumN95m FROM ordering WHERE ((HOUR(timediff(now(), ordering.time)) < 24) and status = 0 and repsName = '$repname')";
        $result3 = $conn->query($sql);
        $rows = $result3->num_rows;
        if($rows > 0){
            $rows = $result3->fetch_assoc();
            if(($row['quotaN95'] + $rows['sumN95']) < 0 || ($row['quotaSm'] + $rows['sumSm']) < 0 || ($row['quotaN95m'] + $rows['sumN95m']) < 0){
                $n ++;
            }
        }
    }
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

<?php if($n > 0) {
    while($row = $result2->fetch_assoc()){
        include("php/connect.php");
        $repname = $row['repsName'];
        $sql = "SELECT COALESCE(SUM(N95),0) as sumN95, COALESCE(SUM(sm),0) as sumSm, COALESCE(SUM(N95m),0) as sumN95m FROM ordering WHERE ((HOUR(timediff(now(), ordering.time)) < 24) and status = 0 and repsName = '$repname')";
        $result3 = $conn->query($sql);
        $rows = $result3->fetch_assoc();
        $conn->close();
        if(($row['quotaN95'] + $rows['sumN95']) < 0) {
            ?>
            <div uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <h3>Notice</h3>
                <p>Reps sale <b><?=$row['repsName'] ?></b> not process the ordering over the quota and cannot find suitable ordering to cancel on <b>N95 mask</b>, please mention him or re-granted</p>
            </div>
        <?php }
        if (($row['quotaSm'] + $rows['sumSm']) <0) { ?>
            <div uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <h3>Notice</h3>
                <p>Reps sale <b><?=$row['repsName'] ?></b> not process the ordering over the quota and cannot find suitable ordering to cancel on <b>Surgical Masks</b>, please mention him or re-granted</p>
            </div>
        <?php }
        if (($row['quotaN95m'] + $rows['sumN95m']) < 0) { ?>
            <div uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <h3>Notice</h3>
                <p>Reps sale <b><?=$row['repsName'] ?></b> not process the ordering over the quota and cannot find suitable ordering to cancel on <b>Surgical N95 Respirators</b>, please mention him or re-granted</p>
            </div>
        <?php }
    }
} else {?>
    <div class="customer-order-no" style="text-align:center"> There are no inform. </div>

<?php }?>
</body>
<?php } else {
    header("location:login.php");
} ?>
</html>