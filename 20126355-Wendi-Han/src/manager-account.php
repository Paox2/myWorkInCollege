<!-- Manager can scan and update their information in this page -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Manager Account</title>
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
$sql = "SELECT * FROM manager WHERE manager.username='$user'";
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

<table id=<?=$row['username']?> class="manager-quota" style="display: ;" frame=hsides rules=rows cellspacing=10>
    <caption id="quota-caption">Manager Information</caption>
    <tr class="quota-table even">
        <th>username</th>
        <th>password</th>
        <th>realname</th>
        <th>passport</th>
        <th>tel</th>
        <th>email</th>
        <th>region</th>
    </tr>
    <tr class="quota-table odd">
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
        <th><a href="<?php echo "update.php?change=password&log=manager" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=realname&log=manager" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=passport&log=manager" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=tel&log=manager" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=email&log=manager" ?>">update</a></th>
        <th><a href="<?php echo "update.php?change=region&log=manager" ?>">update</a></th>
    </tr>
</table>


</body>
<?php } else {
    header("location:login.php");
} ?>
</html>
