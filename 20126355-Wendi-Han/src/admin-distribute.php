<!-- this file is distribute reps to different manager, operation by admin roles -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
    <title> Admin Index</title>
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

$sql = "SELECT * FROM reps ORDER BY username";
$result1 = $conn->query($sql);
$reps = $result1->num_rows;
$n = 0;
?>
<body>
<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
    <nav class="uk-navbar-container" uk-navbar>

        <div class="uk-navbar-left">
            <img src="images/logo.png" class="index-logo"/>
        </div>

        <div class="uk-navbar-right">
            <ul class="customer-index-navigate">
                <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="admin-index.php">Reps Info</a></li>
                <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="admin-statistic.php">Statistics</a></li>
                <li  class="uk-active customer-index-navigate-li"><a class="customer-index-navigate-a" href="admin-distribute.php">distribute</a></li>
                <li  class="uk-active customer-index-navigate-li"><a class="customer-index-navigate-a" href="<?php echo 'register.php?log=manager' ?>">add manager</a></li>
                <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="<?php echo 'register.php?log=reps' ?>">add reps</a></li>
                <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="php/logout.php">log out</a></li>
            </ul>
        </div>
    </nav>
</div>
<?php if($reps > 0){    ?>
<div class="statistics-total shadow">
    <p><br/></p>
    <h2 class="statistics-total-title">Distribute reps to manager</h2>

    <table class="manager-quota" frame=hsides rules=rows cellspacing=10>
        <tr class="even">
            <th>Manager Name</th>
            <th>Reps Name</th>
            <th>Operation</th>
        </tr>
        <?php while($rep = $result1->fetch_assoc()) {
            if(($n%2) == 0){
        ?>
        <tr class="odd">
            <th><?=$rep['managerName']?></th>
            <th><?=$rep['username']?></th> <?php $repsName = $rep['username']?>
            <th><a href="<?php echo "update.php?log=repsMan&change=".$repsName ?>">update</a></th>
        </tr>
        <?php $n++; }else {?>
        <tr class="even">
            <th><?=$rep['managerName']?></th>
            <th><?=$rep['username']?></th> <?php $repsName = $rep['username']?>
            <th><a href="<?php echo "update.php?log=repsMan&change=".$repsName ?>">update</a></th>
        <?php $n++; }?>
        </tr>
        <?php }?>
    </table>
    <br/><br/><br/>

    <br/><br/><br/>
</div>
<?php } else {?>
    <h2> No manager. </h2>
<?php }?>

</body>
<?php } else {
    header("location:login.php");
} ?>
</html>
