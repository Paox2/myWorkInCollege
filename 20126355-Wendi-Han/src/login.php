<!-- login page, include customer, sale reps and manager. Also, user can login as guest or register as a customer  -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title> Woolin log in</title>
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
	<div class="uk-card uk-card-default uk-card-body uk-width-1-3 login-canvas-position	shadow">
		<h1 class="uk-heading-line uk-text-center"><span>Woolin Auto</span></h1>
			
		<nav class="uk-navbar-container uk-margin" uk-navbar="mode:click">
			<div class="uk-navbar-center uk-card-header">
				<ul class="uk-subnav uk-subnav-pill" uk-switcher="connect: #loginSelect">
					<li><a href="#">Customers</a></li>
					<li><a href="#">Sales reps</a></li>
					<li><a href="#">Manager</a></li>
				</ul>
			</div>
		</nav>
		
		<div class="uk-navbar-item">
			<ul class="uk-switcher" id="loginSelect">
				<li>
					<form  method="post" class="uk-form-horizontal" action="<?php echo 'php/login-check.php?log=customer' ?>">
					    <div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">User name: </label>
							<div class="uk-form-controls">
								<input class="uk-input" name="username" type="text" placeholder="username"/>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Password: </label>
							<div class="uk-form-controls">
								<input class="uk-input" name="password" type="password" placeholder="password"/>
							</div>
						</div>
						<div class="uk-margin">
							<button class="uk-button uk-button-default" type="submit" name="submit" value="login">login</button>
							<button class="uk-button uk-button-default" type="reset">reset</button>
						</div>
					</form>
					<div class="uk-navbar-item">
						<p>no account? <a href="<?php echo 'register.php?log=customer' ?>">register</a><br/><br/>
						<a href="customer-index.php">Guest login</a></p>
					</div>
				</li>

				<li>
					<form  method="post" class="uk-form-horizontal" action="<?php echo 'php/login-check.php?log=reps' ?>">
					    <div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Reps Name: </label>
							<div class="uk-form-controls">
								<input class="uk-input" name="username" type="text" placeholder="reps name"/>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Password: </label>
							<div class="uk-form-controls">
								<input class="uk-input" name="password" type="password" placeholder="password"/>
							</div>
						</div>
						<div class="uk-margin">
							<button class="uk-button uk-button-default" type="submit" name="submit" value="login">login</button>
							<button class="uk-button uk-button-default" type="reset">reset</button>
						</div>
                    </form>
				</li>

				<li>
					<form method="post" class="uk-form-horizontal" action="<?php echo 'php/login-check.php?log=manager' ?>">
					    <div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Manager name: </label>
							<div class="uk-form-controls">
								<input class="uk-input" name="username" type="text" placeholder="managername"/>
							</div>
						</div>
						<div class="uk-margin">
							<label class="uk-form-label" for="form-horizontal-text">Password: </label>
							<div class="uk-form-controls">
								<input class="uk-input" name="password" type="password" placeholder="password"/>
							</div>
						</div>
						<div class="uk-margin">
							<button class="uk-button uk-button-default" type="submit" name="submit" value="login">login</button>
							<button class="uk-button uk-button-default" type="reset">reset</button>
						</div>
					</form>
				</li>
			</ul>
		</div>
		
	</div>
</body>
</html>