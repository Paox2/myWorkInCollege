<!-- this page is statistic of sale reps for manager, only show the sale reps this manager responsible for  -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
	<title> Manager Index</title>
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

    
	$sql = "SELECT * FROM reps WHERE managerName = '$user' ORDER BY username";
	$result2 = $conn->query($sql);
	$result3 = $conn->query($sql);
	$reps = $result2->num_rows;
    $n = 0;
    $m = 0;

    $sql = "SELECT repsName From ordering inner join reps ON ordering.repsName = reps.username WHERE (ordering.status = 0 and reps.managerName = '$user') GROUP BY repsName ORDER BY sumprice DESC";
    $result4 = $conn->query($sql);
    $row = $result4->fetch_assoc();
    $nrows = $result4->num_rows;
    if($nrows > 0)
        $championReps = $row['repsName'];

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

    <?php if($nrows > 0){?>
    <div class="manager-index-p uk-margin">
        <img src="images/champion.jpg" width="40px"/> Champion sale reps(only you responsible): <?=$championReps ?>
    </div>
    <?php  } ?>
    <?php if ($reps > 0) { ?>
    <div class="manager-index-container">
        <div class="manager-select-wrapper">
            <div class="manager-index-p">
                Select reps sale to see:
            </div>
            <div class="manager-select">
                <?php while ($row = $result2->fetch_assoc()) { 
                        if($n == 0){?>
                        <div class="manager-select-show"><span><?=$row['username']?></span>
                            <div class="icon"></div>
                        </div>
                        <div class="manager-options">
                            <span class="manager-option selected" data-value="<?=$row['username']?>" onclick="show_table(this);"><?=$row['username']?></span>
                        <?php $n++; } else {?>
                            <span class="manager-option" data-value="<?=$row['username']?>" onclick="show_table(this);"><?=$row['username']?></span>
                        <?php } ?>
                <?php } ?>
                        </div>
            </div>
        </div>
    </div>
    <?php } else { ?>
        <h2> No reps sale. </h2>
    <?php } ?>

    <?php if($reps > 0) {?>
    <?php while ($row = $result3->fetch_assoc()) {
        $name = $row['username'];
        include("php/connect.php");
        $sql = "SELECT SUM(N95) as N95, SUM(N95m) as N95m, SUM(sm) as sm, SUM(sumprice) as sumprice, username FROM reps LEFT OUTER JOIN ordering ON reps.username = ordering.repsName WHERE (reps.username = '$name' and ordering.status = 0) GROUP BY username ORDER BY username";
        $result1 = $conn->query($sql);

        if(!($result1->num_rows > 0)){$row1 = $result1->fetch_assoc();$row1['N95']=0;$row1['sm']=0;$row1['N95m']=0;$row1['sumprice']=0;}else{$row1 = $result1->fetch_assoc();}
        if($m == 0){
            setcookie("show", $row['username']);?>
            <table id=<?=$row['username']?> class="manager-quota" style="display: ;" frame=hsides rules=rows cellspacing=10>
                <caption id="quota-caption">Reps Sale Information</caption>
                    <tr class="quota-table even">
                        <th>name</th>
                        <th>tel</th>
                        <th>email</th>
                        <th>region</th>
                        <th>update region</th>
                    </tr>
                    <tr class="quota-table odd">
                        <th><?=$row['username'] ?></th>
                        <th><?=$row['TEL'] ?></th>
                        <th><?=$row['email'] ?></th>
                        <th><?=$row['region'] ?></th>
                        <th><a href="<?php echo 'update.php?log=region&change='.$row['username'] ?>">update</a></th>
                    </tr>
                    <tr class="quota-table even">
                        <th>quotaN95</th>
                        <th>quotaSm</th>
                        <th>quotaN95m</th>
                        <th>re-grant quota(<0)</th>
                        <th>update quota(>=0)</th>
                    </tr>
                    <tr class="quota-table odd">
                        <th><?=$row['quotaN95'] ?></th>
                        <th><?=$row['quotaSm'] ?></th>
                        <th><?=$row['quotaN95m'] ?></th>
                        <?php if($row['quotaN95']<0 || $row['quotaSm']<0 || $row['quotaN95m']<0){ ?>
                        <th><a href="<?php echo "update.php?log=regrant&change=".$row['username']."&N95=".$row['quotaN95']."&Sm=".$row['quotaSm']."&N95m=".$row['quotaN95m'] ?>">re-grant</a></th>
                        <?php }else{ ?>
                        <th>Cannot</th>
                        <?php }?>
                        <?php if($row['quotaN95']>=0 || $row['quotaSm']>=0 || $row['quotaN95m']>=0){ ?>
                        <th><a href="<?php echo "update.php?log=update&change=".$row['username']."&N95=".$row['quotaN95']."&Sm=".$row['quotaSm']."&N95m=".$row['quotaN95m'] ?>">update</a></th>
                        <?php }else{ ?>
                        <th>Cannot</th>
                        <?php }?>
                    </tr>
                    <tr class="quota-table even">
                        <th>sale N95</th>
                        <th>sale Sm</th>
                        <th>sale N95m</th>
                        <th>total number</th>
                        <th>total revenues</th>
                    </tr>
                    <tr class="quota-table odd">
                        <?php if($row1['N95'] > 0){ ?>
                        <th><?=$row1['N95'] ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['sm'] > 0){ ?>
                        <th><?=$row1['sm'] ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['N95m'] > 0){ ?>
                        <th><?=$row1['N95m'] ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['N95'] > 0 || $row1['sm'] > 0 || $row1['N95m'] > 0){ ?>
                        <th><?=($row1['N95'] + $row1['sm'] + $row1['N95m']) ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['N95'] > 0 || $row1['sm'] > 0 || $row1['N95m'] > 0){ ?>
                        <th><?=round($row1['sumprice']) ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                    </tr>
            </table>
    <?php $m++; } else { ?>
            <table id=<?=$row['username']?> class="manager-quota quota quota1" style="display: none;" frame=hsides rules=rows cellspacing=10>
                <caption id="quota-caption">Reps Sale Information</caption>
                    <tr class="quota-table even">
                        <th>name</th>
                        <th>tel</th>
                        <th>email</th>
                        <th>region</th>
                        <th>update region</th>
                    </tr>
                    <tr class="quota-table odd">
                        <th><?=$row['username'] ?></th>
                        <th><?=$row['TEL'] ?></th>
                        <th><?=$row['email'] ?></th>
                        <th><?=$row['region'] ?></th>
                        <th><a href="<?php echo 'update.php?log=region&change='.$row['username'] ?>">update</a></th>
                    </tr>
                    <tr class="quota-table even">
                        <th>quotaN95</th>
                        <th>quotaSm</th>
                        <th>quotaN95m</th>
                        <th>re-grant quota(<0)</th>
                        <th>update quota(>=0)</th>
                    </tr>
                    <tr class="quota-table odd">
                        <th><?=$row['quotaN95'] ?></th>
                        <th><?=$row['quotaSm'] ?></th>
                        <th><?=$row['quotaN95m'] ?></th>
                        <?php if($row['quotaN95']<0 || $row['quotaSm']<0 || $row['quotaN95m']<0){ ?>
                        <th><a href="<?php echo "update.php?log=regrant&change=".$row['username']."&N95=".$row['quotaN95']."&Sm=".$row['quotaSm']."&N95m=".$row['quotaN95m'] ?>">re-grant</a></th>
                        <?php }else{ ?>
                        <th>Cannot</th>
                        <?php }?>
                        <?php if($row['quotaN95']>=0 || $row['quotaSm']>=0 || $row['quotaN95m']>=0){ ?>
                        <th><a href="<?php echo "update.php?log=update&change=".$row['username']."&N95=".$row['quotaN95']."&Sm=".$row['quotaSm']."&N95m=".$row['quotaN95m'] ?>">update</a></th>
                        <?php }else{ ?>
                        <th>Cannot</th>
                        <?php }?>
                    </tr>
                    <tr class="quota-table even">
                        <th>sale N95</th>
                        <th>sale Sm</th>
                        <th>sale N95m</th>
                        <th>total number</th>
                        <th>total revenues</th>
                    </tr>
                    <tr class="quota-table odd">
                        <?php if($row1['N95'] > 0){ ?>
                        <th><?=$row1['N95'] ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['sm'] > 0){ ?>
                        <th><?=$row1['sm'] ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['N95m'] > 0){ ?>
                        <th><?=$row1['N95m'] ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['N95'] > 0 || $row1['sm'] > 0 || $row1['N95m'] > 0){ ?>
                        <th><?=($row1['N95'] + $row1['sm'] + $row1['N95m']) ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                        <?php if($row1['N95'] > 0 || $row1['sm'] > 0 || $row1['N95m'] > 0){ ?>
                        <th><?=round($row1['sumprice']) ?></th>
                        <?php } else {?>
                        <th>0</th>
                        <?php } ?>
                    </tr>
            </table>
    <?php } 
    }}?>

    
<script> 

for (const dropdown of document.querySelectorAll(".manager-select-wrapper")) {
    dropdown.addEventListener('click', function () {
        this.querySelector('.manager-select').classList.toggle('open');
    })
}

for (const option of document.querySelectorAll(".manager-option")) {
    option.addEventListener('click', function () {
        if (!this.classList.contains('selected')) {
            this.parentNode.querySelector('.manager-option.selected').classList.remove('selected');
            this.classList.add('selected');
            this.closest('.manager-select').querySelector('.manager-select-show span').textContent = this.textContent;
        }
    })
}

window.addEventListener('click', function (e) {
    for (const select of document.querySelectorAll('.manager-select')) {
        if (!select.contains(e.target)) {
            select.classList.remove('open');
        }
    }
});

</script>

<script>
function show_table(m){
    var oldName = getCookie("show");
    var newName = m.innerHTML;
    document.cookie= "show" + "=" + newName;
    document.getElementById(oldName).style.display = "none";
    document.getElementById(newName).style.display = "";
}

function getCookie(c_name) {
	if(document.cookie.length > 0) {
		c_start = document.cookie.indexOf(c_name + "=");
		if(c_start != -1) {
			c_start = c_start + c_name.length + 1;
			c_end = document.cookie.indexOf(";", c_start);
            if(c_end == -1) 
                c_end = document.cookie.length;
            return decodeURI(document.cookie.substring(c_start, c_end));
		}
	}
	return "";
}
</script>
    
</body>
<?php } else {
    header("location:login.php");
} ?>
</html>