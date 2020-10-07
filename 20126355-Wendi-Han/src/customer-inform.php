<!-- Inform divide into two aspect: order cancelled by reps or order has a risk of cancelled by reps -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
    <head>
        <title> Customer Inform</title>
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
    $sql = "SELECT * FROM ordering WHERE (customerName = '$user' and status = 2)";
    $canceled = $conn->query($sql);
    $nrows1 = $canceled->num_rows;

    $sql = "SELECT quotaN95m, quotaN95, quotaSm, time, repsName, SUM(N95) as N95, SUM(sm) as sm, SUM(N95m) as N95m, SUM(sumprice) as sumprice  FROM ordering inner join reps ON reps.username = ordering.repsName WHERE (customerName='$user' and HOUR(timediff(now(), time)) < 24 and status = 0) GROUP BY repsName";
    $mayBe = $conn->query($sql);
    $nrows = $mayBe->num_rows;

    $n = 0;
    if($nrows > 0){
        while($row = $mayBe->fetch_assoc()){
            if(($row['quotaN95m']<0 and $row['N95m'] > 0) || ($row['quotaN95']<0 and $row['N95'] > 0) || ($row['quotaSm']<0 and $row['sm'] > 0)){
                $n ++;
            }
        }
    }

    $sql = "SELECT quotaN95m, quotaN95, quotaSm, time, repsName, N95, sm, N95m, sumprice  FROM ordering inner join reps ON reps.username = ordering.repsName WHERE (customerName='$user' and HOUR(timediff(now(), time)) < 24 and status = 0) ORDER BY time DESC";
    $mayBee = $conn->query($sql);

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
            <ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: #Inform">
                <li><a href="#">Cancelled order</a></li>
                <li><a href="#">Orders at risk of being cancelled</a></li>
            </ul>
        </div>
    </nav>
    <div class="uk-navbar-item">
        <ul class="uk-switcher" id="Inform">
            <li>
                <?php if($nrows1 > 0) {
                    while($row = $canceled->fetch_assoc()){?>
                        <div uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <h3>Notice</h3>
                            <p>Reps sale <b><?=$row['repsName'] ?></b> has cancelled you order, because this order over the quota. Order information:</p>
                            <p>time: <?=$row['time']?> N95: <?=$row['N95']?> Sm: <?=$row['Sm']?> N95m: <?=$row['N95m']?> price: <?=$row['sumprice']?></p>
                        </div>
                <?php }} else {?>
                    <div class="customer-order-no" style="text-align:center"> No order be cancelled. </div>
                <?php }?>
            </li>
            <li>
                <?php if($n > 0) {
                    while($row = $mayBee->fetch_assoc()){
                        if($row['quotaN95m']<0 and $row['N95m'] > 0) {?>
                            <div uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <h3>Notice</h3>
                                <p>Reps sale <b><?=$row['repsName'] ?></b> may cancel you order, because this order over the quota. Order information:</p>
                                <pre><p>time: <?=$row['time']?>   N95: <?=$row['N95']?>   Sm: <?=$row['sm']?>   N95m: <?=$row['N95m']?>   price: <?=$row['sumprice']?></p></pre>
                            </div>
                        <?php }else if ($row['quotaN95']<0 and $row['N95'] > 0) {?>
                            <div uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <h3>Notice</h3>
                                <p>Reps sale <b><?=$row['repsName'] ?></b> may cancel you order, because this order over the quota. Order information:</p>
                                <pre><p>time: <?=$row['time']?>   N95: <?=$row['N95']?>   Sm: <?=$row['sm']?>   N95m: <?=$row['N95m']?>   price: <?=$row['sumprice']?></p></pre>
                            </div>
                        <?php }else if ($row['quotaSm']<0 and $row['sm'] > 0){ ?>
                            <div uk-alert>
                                <a class="uk-alert-close" uk-close></a>
                                <h3>Notice</h3>
                                <p>Reps sale <b><?=$row['repsName'] ?></b> may cancel you order, because this order over the quota. Order information:</p>
                                <pre><p>time: <?=$row['time']?>   N95: <?=$row['N95']?>   Sm: <?=$row['sm']?>   N95m: <?=$row['N95m']?>   price: <?=$row['sumprice']?></p></pre>
                            </div>
                        <?php } ?>

                    <?php }} else {?>
                    <div class="customer-order-no" style="text-align:center"> No order has risk to be cancelled. </div>
                <?php }?>
            </li>
        </ul>
    </div>
</body>
    <?php } else {
		header("location:login.php");
 } ?>
</html>