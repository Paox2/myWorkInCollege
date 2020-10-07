<!-- customer purchase page, customer can choose number of masks to buy and choose a rep to process his(her) order -->
<!DOCTYPE html>
<html>
<?php session_start();
if(isset($_SESSION["username"])){?>
<head>
	<title> Customer Purchase</title>
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
	
	$user = $_SESSION["username"];
	$sql = "SELECT region FROM customer WHERE customer.username='$user'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$value = array_values($row);
	$region = $value[0];

    $sql = "SELECT name, price FROM prices WHERE (name='N95' or name='Sm' or name='N95m')";
    $result2 = $conn->query($sql);
    while ($prices = $result2->fetch_assoc()) {
        if ($prices['name'] == 'N95') {
            $N95prices = $prices['price'];
        } else if ($prices['name'] == 'N95m') {
            $N95mprices = $prices['price'];
        } else if ($prices['name'] == 'Sm') {
            $Smprices = $prices['price'];
        }
    }

	$sql = "SELECT username, quotaN95, quotaSm, quotaN95m FROM reps WHERE region='$region'";
	$result = $conn->query($sql);
	$nrows = $result->num_rows;
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
	

	<div class="customer-purchase-prompt" style="font-size: 20px;"><p>Hi, <?=$user?>!</p></div>

    <div style="text-align:center">
		<table class="customer-purchase-table">
			<tr>
				<td class="customer-purchase-table">&mdash; N95 respirators &mdash;</td>
				<td class="customer-purchase-table">&mdash; surgical masks &mdash;</td>
				<td class="customer-purchase-table">&mdash; surgical N95 respirators &mdash;</td>
			</tr>
			<tr class="customer-purchase-table">
				<td style="width: 30%;"><img src="images/n95p.png" style="width: 45%;" alt="N95 respirators"/></td>
				<td style="width: 37%;"><img src="images/smp.png" style="width: 45%;" alt="N95 respirators"/></td>
				<td><img src="images/n95mp.png" style="width: 90%;" alt="N95 respirators"/></td>
			</tr>
			<tr class="customer-purchase-table">
				<td>
					<div class="shoes-cnt-notice" id="eachN95" value="<?=$N95prices ?>">$<?=$N95prices ?> / each</div>
					<button onclick=Sub1('N95')>-</button>
					<input type="number" id="inputN95" value="0" min="0" onchange="priceShow();"/>
					<button onclick=Add1('N95')>+</button><br/>
					price: $<span id="N95price">0.00</span>
				</td>
				<td>
					<div class="shoes-cnt-notice" id="eachSm" value="<?=$Smprices ?>">$<?=$Smprices ?> / each</div>
					<button onclick=Sub1('Sm')>-</button>
					<input type="number" id="inputSm" value="0" min="0" onchange="priceShow();"/>
					<button onclick=Add1('Sm')>+</button><br/>
					price: $<span id="Smprice">0.00</span>
				</td>
				<td>
					<div class="shoes-cnt-notice" id="eachN95m" value="<?=$N95mprices ?>">$<?=$N95mprices ?> / each</div>
					<button onclick=Sub1('N95m')>-</button>
					<input type="number" id="inputN95m" value="0" min="0" onchange="priceShow();"/>
					<button onclick=Add1('N95m')>+</button><br/>
					price: $<span id="N95mprice">0.00</span>
				</td>
			</tr>
		</table>
	</div>
	<div class="customer-purchase-prompt2 uk-margin">
		<br/> Sum: $<span id="sumprice">0.0</span><br/>	
			<?php if(isset($_SESSION["username"])){?>
				<button class="uk-button uk-button-primary uk-width-1-2 uk-margin-small-bottom" type="submit" onclick="showReps();">
					Purchase it
				</button>
			<?php } else { ?>
				<button class="demo uk-button uk-button-primary uk-width-1-2 uk-margin-small-bottom" type="button" onclick="UIkit.notification({message: 'log in first'})">
					Purchase it
				</button>
			<?php }?>
    </div>
	
	<div class="uk-margin customer-purchase-chooseReps" id="chooseReps" style="display: none;">
		<hr class="uk-divider-icon uk-margin-top"/>
			<div>
			<form method="post" action="php/customer-subOrder.php">
				<span style="margin-bottom: 15%;">You default region is <span id="region"><?=$region ?></span></span><br/>
				<?php if($nrows > 0){?>
					<label class=" customer-purchase-reps" for="form-horizontal-select">Please select a sales reps contact with you</label>
					<div class="uk-form-controls" style="margin: 3%;">			
						<select class="uk-select customer-purchase-reps" id="reps" name="selectReps">
							<?php while ($row = $result->fetch_assoc()){?>
								<option value="<?=$row['username']?>"><?=$row['username']?>(quota: N95:<?=$row['quotaN95']?> sm:<?=$row['quotaSm']?> N95m:<?=$row['quotaN95m']?>)</option>
							<?php }?>
                        </select><br/><br/><p style="color:red">Mention: if you ordering has masks which over the quota of reps sale, ordering may be cancel !!!</p>
						<button class="demo uk-button uk-button-primary uk-width-1-3 uk-margin-small-bottom" type="submit" onclick="passValue();">
							Choose it
						</button>
					</div>
				<?php } else {?>
					<label class="uk-form-label" for="form-stacked-select">Sorry, no sales reps in your region. You can update you information to choose another region.</label>
				<?php } ?>
			</form>
			</div>
    </div>

	<script type="text/javascript">
	
	function Add1(n) {
		switch(n){
			case 'N95':
				var inputN95 = document.getElementById("inputN95");
				vN95 = document.getElementById("inputN95").value;
				inputN95.value = (parseInt(vN95) + 1).toString();
				var N95 = document.getElementById("N95price");
				pN95 = document.getElementById("N95price").innerHTML;
				N95.innerHTML = (parseFloat(pN95) - parseFloat(document.getElementById("eachN95").getAttribute('value'))).toFixed(2).toString();
				priceShow();
				break;
			case 'Sm':
				var inputSm = document.getElementById("inputSm");
				vSm = document.getElementById("inputSm").value;
				inputSm.value = (parseInt(vSm) + 1).toString();
				var Sm = document.getElementById("Smprice");
				pSm = document.getElementById("Smprice").innerHTML;
				Sm.innerHTML = (parseFloat(pSm) - parseFloat(document.getElementById("eachSm").getAttribute('value'))).toFixed(2).toString();
				priceShow();
				break;
			case 'N95m':
				var inputN95m = document.getElementById("inputN95m");
				vN95m = document.getElementById("inputN95m").value;
				inputN95m.value = (parseInt(vN95m) + 1).toString();
				var N95m = document.getElementById("N95mprice");
				pN95m = document.getElementById("N95mprice").innerHTML;
				N95m.innerHTML = (parseFloat(pN95m) - parseFloat(document.getElementById("eachN95m").getAttribute('value'))).toFixed(2).toString();
				priceShow();
				break;
		}
	}

	function Sub1(n) {
		switch(n){
			case 'N95':
				var inputN95 = document.getElementById("inputN95");
				vN95 = document.getElementById("inputN95").value;
				if(vN95 > 0){
					inputN95.value = (parseInt(vN95) - 1).toString();	
					var N95 = document.getElementById("N95price");
					pN95 = document.getElementById("N95price").innerHTML;
					N95.innerHTML = (parseFloat(pN95) - parseFloat(document.getElementById("eachN95").getAttribute('value'))).toFixed(2).toString();
					priceShow();
				}
				break;
			case 'Sm':
				var inputSm = document.getElementById("inputSm");
				vSm = document.getElementById("inputSm").value;
				if(vSm > 0){
					inputSm.value = (parseInt(vSm) - 1).toString();
					var Sm = document.getElementById("Smprice");
					pSm = document.getElementById("Smprice").innerHTML;
					Sm.innerHTML = (parseFloat(pSm) - parseFloat(document.getElementById("eachSm").getAttribute('value'))).toFixed(2).toString();
					priceShow();
				}
				break;
			case 'N95m':
				var inputN95m = document.getElementById("inputN95m");
				vN95m = document.getElementById("inputN95m").value;
				if(vN95m>0){
					inputN95m.value = (parseInt(vN95m) - 1).toString();
					var N95m = document.getElementById("N95mprice");
					pN95m = document.getElementById("N95mprice").innerHTML;
					N95m.innerHTML = (parseFloat(pN95m) - parseFloat(document.getElementById("eachN95m").getAttribute('value'))).toFixed(2).toString();
					priceShow();
				}
				break;
		}
	}
	
	function priceShow(){
		var inputN95m = document.getElementById("inputN95m").value;
		var inputSm = document.getElementById("inputSm").value;
		var inputN95 = document.getElementById("inputN95").value;
		if(inputN95m == ''){
		    inputN95m = 0;
            document.getElementById("inputN95m").value = 0;
        }
        if(inputN95 == ''){
            inputN95 = 0;
            document.getElementById("inputN95").value = 0;
        }
        if(inputSm == ''){
            inputSm = 0;
            document.getElementById("inputSm").value = 0;
        }
		if(inputN95 >= 0) {
            document.getElementById("N95price").innerHTML = (parseInt(inputN95) * parseFloat(document.getElementById("eachN95").getAttribute('value'))).toFixed(2).toString();
        } else {
            document.getElementById("inputN95").value = 0;
            inputN95 = 0;
            document.getElementById("N95price").innerHTML = (0 * 19.9).toFixed(2).toString()
        }
		if(inputSm >= 0) {
            document.getElementById("Smprice").innerHTML = (parseInt(inputSm) * parseFloat(document.getElementById("eachSm").getAttribute('value'))).toFixed(2).toString();
        } else{
            document.getElementById("inputSm").value = 0;
            inputSm = 0;
            document.getElementById("Smprice").innerHTML = (0 * 9.9).toFixed(2).toString()
        }
        if(inputN95m >= 0) {
            document.getElementById("N95mprice").innerHTML = (parseInt(inputN95m) * parseFloat(document.getElementById("eachN95m").getAttribute('value'))).toFixed(2).toString();
        } else {
            document.getElementById("inputN95m").value = 0;
            inputN95m = 0;
            document.getElementById("N95mprice").innerHTML = (0 * 29.9).toFixed(2).toString()
        }

        var sum = inputN95 * parseFloat(document.getElementById("eachN95").getAttribute('value')) + inputSm * parseFloat(document.getElementById("eachSm").getAttribute('value')) + inputN95m * parseFloat(document.getElementById("eachN95m").getAttribute('value'));
		var sumPrice = document.getElementById("sumprice");
		sumPrice.innerHTML = sum.toFixed(2).toString();
	}
	
	function showReps(){
	    if(	Math.round(document.getElementById("inputN95m").value + document.getElementById("inputSm").value + document.getElementById("inputN95").value) == document.getElementById("inputN95m").value + document.getElementById("inputSm").value + document.getElementById("inputN95").value)
		    document.getElementById("chooseReps").style.display = "block";
	    else
	        alert("Please input integer");
	}
	
	function passValue(){
		if(document.getElementById("sumprice").innerHTML == '0.00' || document.getElementById("sumprice").innerHTML == '0.0'){
			alert('please add product in ordering');
		}
		document.cookie = "reps" + "=" + document.getElementById("reps").value;
		document.cookie = "N95" + "=" + document.getElementById("inputN95").value;
		document.cookie = "Sm" + "=" + document.getElementById("inputSm").value;
		document.cookie = "N95m" + "=" + document.getElementById("inputN95m").value;
		document.cookie = "sum" + "=" + document.getElementById("sumprice").innerHTML;
		document.cookie = "region" + "=" + document.getElementById("region").innerHTML;
	}

    function showClear(x){
        x.style.shadow = "60px -16px teal";
    }
    
    function showNormal(x){
        x.style.shadow = "0";
    }

	</script>

</body>
<?php } else {
		header("location:login.php");
 } ?> 
</html>