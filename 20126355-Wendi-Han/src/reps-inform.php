<!-- inform if customer delete order -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Reps Inform</title>
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
session_start();
$user = $_SESSION["username"];
$sql = "SELECT * FROM ordering WHERE (repsName = '$user' and status = 1) ORDER BY time DESC";
$canceled = $conn->query($sql);
$nrows1 = $canceled->num_rows;

$conn->close();
?>

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


<div class="uk-navbar-item">
        <li>
            <?php if($nrows1 > 0) {
                while($row = $canceled->fetch_assoc()){?>
                    <div uk-alert>
                        <a class="uk-alert-close" uk-close></a>
                        <h3>Notice</h3>
                        <p>Customer <b><?=$row['customerName'] ?></b> has cancelled you order, because this order over the quota. Order information:</p>
                        <pre><p>time: <?=$row['time']?>   N95: <?=$row['N95']?>   Sm: <?=$row['sm']?>   N95m: <?=$row['N95m']?>   price: <?=$row['sumprice']?></p></pre>
                    </div>
                <?php }} else {?>
                <div class="customer-order-no" style="text-align:center"> No order be cancelled. </div>
            <?php }?>
        </li>
</div>
</body>
<?php } else {
    header("location:login.php");
} ?>
</html>