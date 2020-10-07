<!-- sale reps can scan and update his account in this page -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Reps Account</title>
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
$sql = "SELECT * FROM reps WHERE reps.username='$user'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

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

<table id=<?=$row['username']?> class="manager-quota" style="display: ;" frame=hsides rules=rows cellspacing=10>
    <caption id="quota-caption">Reps Information</caption>
    <tr class="quota-table even">
        <th>ID</th>
        <th>username</th>
        <th>password</th>
        <th>realname</th>
        <th>passport</th>
        <th>tel</th>
        <th>email</th>
        <th>region</th>
    </tr>
    <tr class="quota-table odd">
        <th><?=$row['ID'] ?></th>
        <th><?=$row['username'] ?></th>
        <th bgcolor="red">Cannot check</th>
        <th><?=$row['realname'] ?></th>
        <th><?=$row['PASSPORT'] ?></th>
        <th><?=$row['TEL'] ?></th>
        <th><?=$row['email'] ?></th>
        <th><?=$row['region'] ?></th>
    </tr>
    <tr class="quota-table even">
        <th></th>
        <th></th>
        <th><a href="<?php echo "update.php?change=password&log=reps" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=realname&log=reps" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=passport&log=reps" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=tel&log=reps" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=email&log=reps" ?>">update</a></th>
        <th><a href="cannot update</a></th>
    </tr>
</table>


</body>
<?php } else {
                header("location:login.php");
} ?>
</html>
