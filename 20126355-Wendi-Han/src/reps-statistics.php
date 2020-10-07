<!-- help reps to statistics customer and check who buy most from he -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Reps Statistics</title>
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
$sql = "SELECT customerName, SUM(N95) as sumN95, SUM(Sm) as sumSm, SUM(N95m) as sumN95m, SUM(sumprice) as sumprice, tel, email FROM ordering inner join customer ON ordering.customerName = customer.username WHERE (repsName='$user' and status = 0) GROUP BY customerName ORDER BY sumprice DESC";
$result = $conn->query($sql);
$row = $result->num_rows;

$sql = "SELECT SUM(sumprice), SUM(N95), SUM(Sm), SUM(N95m) FROM ordering WHERE (repsName = '$user' and status = '0')";
$result1 = $conn->query($sql);
$nrow1 = $result1->num_rows;

if ($nrow1 > 0){
    $sql = "SELECT SUM(sumprice) as sumprice, repsName FROM ordering WHERE status = 0 GROUP BY repsName ORDER BY sumprice DESC";
    $a = $conn->query($sql);
    $b = $a->fetch_assoc();
    $n = 1;
    while ($b['repsName'] <> $user){
        $n = $n + 1;
        $b = $a->fetch_assoc();
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

<div class="manager-index-p uk-margin">
<?php if($nrow1 > 0) {
    $row1 = $result1->fetch_assoc();?>

    Congratulations! You have sold ($<?=$row1['SUM(sumprice)']?>). Include  (<?=$row1['SUM(N95)']?>)  N95,  (<?=$row1['SUM(Sm)']?>)  Sm and  (<?=$row1['SUM(N95m)']?>)  N95m.<br/>
    Your sales rank among sales representatives: <?=$n?>
<?php }else{ ?>
    Sorry! You have not sell anything.
<?php } ?>
</div>

<table class="manager-quota" style="display: ;" frame=hsides rules=rows cellspacing=10>
    <caption id="quota-caption">Customer Statistics(For you)</caption>
    <tr class="quota-table even">
        <th>name</th>
        <th>total cost</th>
        <th>N95 Respirators</th>
        <th>Surgical Masks</th>
        <th>Surgical N95 Respirators</th>
        <th>tel</th>
        <th>email</th>
    </tr>
    <?php if($row > 0){
        while($row = $result->fetch_assoc()){?>
            <tr class="quota-table odd">
                <th><?=$row['customerName'] ?></th>
                <th><?=round($row['sumprice']) ?></th>
                <th><?=$row['sumN95'] ?></th>
                <th><?=$row['sumSm'] ?></th>
                <th><?=$row['sumN95m'] ?></th>
                <th><?=$row['tel'] ?></th>
                <th><?=$row['email'] ?></th>
            </tr>
    <?php }}else{ ?>
    <tr colspan="7"><p>No customer</p></tr>
    <?php }?>
</table>


</body>
<?php } else {
    header("location:login.php");
} ?>
</html>
