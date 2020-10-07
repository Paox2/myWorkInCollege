<!-- customer index page, include masks information, guest also can check this page -->
<!DOCTYPE html>
<html>
<head>
	<title> Customer Index</title>
	<link rel="shortcut icon" href="images/logo1.ico" />
	<meta charset="utf-8">
	<link href="css/Woolin.css" type="text/css" rel="stylesheet"/>
		
	<!-- UIkit CSS -->
	<link rel="stylesheet" href="../published/UIkit.css" />
	<!-- UIkit JS -->
	<script src="../published/uikit_min.js"></script>
	<script src="../published/uikit_icons_min.js"></script>
</head>
<?php session_start();?>
<body>
	<div uk-sticky="sel-target: .uk-navbar-container; cls-active: uk-navbar-sticky">
		<nav class="uk-navbar-container" uk-navbar>

			<div class="uk-navbar-left">
				<img src="images/logo.png" class="index-logo"/>
			</div>

			<div class="uk-navbar-right">
				<ul class="customer-index-navigate">
					    <li  class="uk-active customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-index.php">Mask Info</a></li>
					<?php if(isset($_SESSION["username"])){?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-purchase.php">Mask Purchase</a></li>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-inform.php">Inform</a></li>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-order.php">Order list</a></li>
                        <li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="customer-account.php">Account</a></li>
					<?php } else { ?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" onclick="UIkit.notification({message: 'log in first'})">Mask Purchase</a></li>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" onclick="UIkit.notification({message: 'log in first'})">Inform</a></li>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" onclick="UIkit.notification({message: 'log in first'})">Order list</a></li>
					<?php }?>
					<?php if(isset($_SESSION["username"])){?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="php/logout.php">Log out</a></li>
					<?php } else { ?>
						<li class="customer-index-navigate-li"><a class="customer-index-navigate-a" href="login.php">Sign in</a></li>
					<?php }?>
				</ul>
			</div>
		</nav>
	</div>

		<div class="uk-child-width-1-3@m customer-index-photo-table" uk-grid>
			<div>
				<div class="uk-card uk-card-default shadow">
                    <img src="images/n95p.png" style="width:60%; box-shadow: 10px 10px 5px #888888;" alt="N95">
					<div class="uk-card-body" style="font-family: Trebuchet MS, sans-serif">
						<p class="customer-index-photo-name">N95 respirators</p>
                        <p class="customer-index-photo-name"><a href="customer-purchase.php">purchase it</a></p>
						info:<br/>
						An N95 mask or N95 respirator is a particulate-filtering facepiece respirator that meets the U.S. National Institute for Occupational Safety and Health (NIOSH) N95 classification of air filtration, 
                        meaning that it filters at least 95% of airborne particles. This standard does not require that the respirator be resistant to oil; another standard, P95, adds that requirement. 
                        The N95 type is the most common particulate-filtering facepiece respirator. It is an example of a mechanical filter respirator, which provides protection against particulates but not against gases or vapors.
					</div>
				</div>
			</div>
			<div>
				<div class="uk-card uk-card-default shadow">
					<img src="images/smp.png" style="width:67%; box-shadow: 10px 10px 5px #888888;" alt="surgical masks">
					<div class="uk-card-body" style="font-family: Trebuchet MS, sans-serif">
						<p class="customer-index-photo-name">surgical masks</p>
                        <p class="customer-index-photo-name"><a href="customer-purchase.php">purchase it</a></p>
						info:<br/>
						Surgical masks are the most commonly used masks at Mass General. “The benefit of the surgical mask is that it is fluid-resistant and can protect you against large droplets or splashed bodily fluids. Plus, it doesn’t require fit testing,” says Alba.
						Unlike N95s, surgical masks do not protect against aerosols and are not sufficient protection when in direct contact with COVID patients during aerosol-generating procedures, he explains.
					</div>
				</div>
			</div>
			<div>
				<div class="uk-card uk-card-default shadow">
                    <img src="images/n95mp.png" style="width:67%; box-shadow: 10px 10px 5px #888888;" alt="surgical masks">
					<div class="uk-card-body" style="font-family: Trebuchet MS, sans-serif">
						<p class="customer-index-photo-name">surgical N95 respirators</p>
                        <p class="customer-index-photo-name"><a href="customer-purchase.php">purchase it</a></p>
						info:<br/>
						N95 Respirators. An N95 respirator is a respiratory protective device designed to achieve a very close facial fit and very efficient filtration of airborne particles. The 'N95' designation means that when subjected to careful testing, the respirator blocks at least 95 percent of very small (0.3 micron) test particles.
					</div>
				</div>
			</div>
		</div>
    
    <footer>
        <p> copyright: Woolin Auto</p>
        <p> thanks for purchase </p>
    </footer>

</body>
</html>
