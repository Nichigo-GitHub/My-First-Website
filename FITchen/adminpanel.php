<?php
	// load up global things
	include_once 'autoloader.php';

	if ( !isAdmin() ) {
		header( 'location: index.php' );
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- icon of our page -->
		<link rel="icon" type="image/png" sizes="32x32" href="css/favicon-32x32.png">
		
		<!-- title of our page -->
		<title>FITchen | Admin Panel</title>

		<!-- need this so everything looks good on mobile devices -->
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

		<!-- css styles for our signup page-->
		<link href="css/global.css" rel="stylesheet" type="text/css">
		<link href="css/adminpanel.css" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="css/style.css">

		<!-- jquery -->
		<script type="text/javascript" src="js/jquery.js"></script>
	</head>
	<body>
		<div class="site-header">
			<div class="site-header-pad">
				<a class="header-home-link" href="homepage.html">
					FITchen
				</a>
			</div>
		</div>
		<div class="site-content-container">
			<div class="site-content-centered">
				<div class="site-content-section">
					<div class="site-content-section-inner">
						<div class="section-heading">Admin Panel</div>
						<div class="admin-sub-heading">Logged in as <?php echo $_SESSION['user_info']['first_name']; ?> <?php echo $_SESSION['user_info']['last_name']; ?></div>
						<br><br>
					</div>
				</div>
			</div>	
			<div class="site-table-centered">
			<?php 
				include_once ( 'php/functions.php' );
				getAllUserInfo();								
			?>
			</div>
			<div class="site-content-centered">
				<div class="site-content-section">
					<div class="site-content-section-inner">						
						<div class="section-action-container">
							<div class="section-button-container" id="return_button">
								<div>Return</div>
							</div>
						</div>
					</div>
				</div>
			</div>			
		</div>
	</body>
	<script>
		$( '#return_button' ).on( 'click', function() { // onclick for our return button
			history.go(-1);
		} );
	</script>
</html>