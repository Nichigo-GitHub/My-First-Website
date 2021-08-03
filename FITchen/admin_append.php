<?php
	// load up global things
	include_once 'autoloader.php';
	
	// load up functions
	include_once 'php/functions.php';

	if ( !isAdmin() ) {
		header( 'location: index.php' );
	}
	
	$databaseConnection = getDatabaseConnection();

	// create our sql statment
	$statement = $databaseConnection->prepare( '
		SELECT
			*
		FROM
			users
		WHERE
			id = :id
	' );

	// execute sql with actual values
	$statement->setFetchMode( PDO::FETCH_ASSOC );
	$statement->execute( array(
		'id' => trim( $_GET['id'] )
	) );

	// get and return user
	$info = $statement->fetch();
	
	if ( !empty( $info['fb_access_token'] ) ) { // get users facebook info is we have an access token
		$fbUserInfo = getFacebookUserInfo( $info['fb_access_token'] );
		$fbDebugTokenInfo = getDebugAccessTokenInfo( $info['fb_access_token'] );
	}
	
	if ($info[ 'user_level'] == 1) {
		$user_level = 'Admin';
		$not_user_level = 'User';
		$not_user_level_value = '0';
	} elseif ($info['user_level'] == 0) {
		$user_level = 'User';
		$not_user_level = 'Admin';
		$not_user_level_value = '1';
	}
	
	if ( isset( $_GET['state'] ) && FB_APP_STATE == $_GET['state'] ) { // coming from facebook
		// Try and log the user in with $_GET vars from facebook
		$fbLogin = tryAndAppendFacebookAccount( $_GET, $info['email'], $info['id'] );
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
						<form id="myaccount_form" name="myaccount_form">
							<div>
								<div><input class="update-input" type="hidden" name="id" value="<?php echo $_GET[ 'id' ]; ?>" /></div>
							</div>
							<div>
								<div class="section-label">Email</div>
								<div><input class="update-input" type="email" name="email" value="<?php echo $info[ 'email' ]; ?>" /></div>
							</div>
							<div class="section-mid-container">
								<div class="section-label">First Name</div>
								<div><input class="update-input" type="text" name="first_name" value="<?php echo $info[ 'first_name' ]; ?>" /></div>
							</div>
							<div class="section-mid-container">
								<div class="section-label">Last Name</div>
								<div><input class="update-input" type="text" name="last_name" value="<?php echo $info[ 'last_name']; ?>"/></div>
							</div>
							<div class="section-mid-container">
								<div class="section-label">User Level</div>
								<div>
									<select class="update-input" name="user_level">
										<option value=<?php echo $info[ 'user_level']; ?>><?php echo $user_level; ?></option>
										<option value=<?php echo $not_user_level_value; ?>><?php echo $not_user_level; ?></option>
									</select>
								</div>
							</div>
							<div>
								<div class="section-label">
									<input type="checkbox" name="change_password" id="change_password" style="width:10px"/>
									<label for="change_password">Change Password</label>
								</div>
							</div>
							<div id="change_password_section" style="display:none">
								<div class="section-mid-container">
									<div class="section-label">Password</div>
									<div><input class="update-input" type="password" name="password" /></div>
								</div>
								<div class="section-mid-container">
									<div class="section-label">Confirm Password</div>
									<div><input class="update-input" type="password" name="confirm_password" /></div>
								</div>
							</div>
						</form>
						<div class="section-action-container">
							<div class="section-button-container" id="update_button">
								<div>Update</div>
							</div>
						</div>	
						<div class="section-action-container">
							<div class="section-button-container" id="return_button">
								<div>Return</div>
							</div>
						</div>	
					</div>
				</div>
			</div>
		</div>
		<div class="site-content-container">
			<div class="site-content-centered">
				<div class="site-content-section">
					<div class="site-content-section-inner">		
						<?php if ( empty( $fbUserInfo ) || $fbUserInfo['has_errors'] ) : // could not get facebook user info ?>									
							<a href="<?php echo getFacebookLoginUrlToAppend( trim( $_GET['id'] ) ); ?>" class="fb-link">
								<button type="button" class="fb-btn">						
									Connect <span>facebook</span> account				
								</button>
							</a>
							<?php if ( isset( $_SESSION['facebook_account_already_exists'] ) && $_SESSION['facebook_account_already_exists'] ) : // enter password to connect account ?>
								<script>
									alert( '<?php echo $fbLogin['message'] ?>' );
									<?php $_SESSION['facebook_account_already_exists'] = false; ?>
									window.history.go(-1);
									FB.logout(function(response){
										FB.Auth.setAuthResponse(null,'unknown'); 										
									});
								</script>	
							<?php elseif ( !empty( $fbLogin['go_back'] ) && $fbLogin['go_back'] ) : ?>
								<script> window.history.go(-1); </script>
							<?php endif; ?>
						<?php else : // display facebook user info ?> 
							<div class="section-heading">Facebook Account</div>
							<div>
								<div class="pro-img-cont">
									<img class="pro-img" src="<?php echo $fbUserInfo['fb_response']['picture']['data']['url']; ?>" />
								</div>
							</div>
							<div class="section-mid-container">
								<div class="section-label">
									Email
								</div>
								<div>
									<?php echo $fbUserInfo['fb_response']['email']; ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									First Name
								</div>
								<div>
									<?php echo $fbUserInfo['fb_response']['first_name']; ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									Last Name
								</div>
								<div>
									<?php echo $fbUserInfo['fb_response']['last_name']; ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									Account Status
								</div>
								<div>
									<?php echo $user_level;	?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									User Access Token Facebook Application
								</div>
								<div>
									<?php echo $fbDebugTokenInfo['fb_response']['data']['application']; ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									User Access Token Issued
								</div>
								<div>
									<?php echo "Date: ".date( 'm-d-Y', $fbDebugTokenInfo['fb_response']['data']['issued_at'] )."<br>"; ?>
									<?php echo "Time: ".date( 'h:i:s a', $fbDebugTokenInfo['fb_response']['data']['issued_at'] ); ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									User Access Token Expires
								</div>
								<div>
									<?php echo "Date: ".date( 'm-d-Y', $fbDebugTokenInfo['fb_response']['data']['expires_at'] )."<br>"; ?>
									<?php echo "Time: ".date( 'h:i:s a', $fbDebugTokenInfo['fb_response']['data']['expires_at'] ); ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									User Access Token Scope
								</div>
								<div>
									<?php echo implode( ', ', $fbDebugTokenInfo['fb_response']['data']['scopes'] ); ?>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									User Info Raw FB Response
								</div>
								<div>
									<div class="a-default show-hide" data-section="fb_user_info">
										show
									</div>
									<div id="fb_user_info" class="show-hide-section">
										<textarea class="show-hide-textarea"><?php print_r( $fbUserInfo['fb_response'] ); ?></textarea>
									</div>
								</div>
							</div>
							<br>
							<div class="section-mid-container">
								<div class="section-label">
									User Access Token Debug Info Raw FB Response
								</div>
								<div>
									<div class="a-default show-hide" data-section="fb_user_access_token_debug">
										show
									</div>
									<div id="fb_user_access_token_debug" class="show-hide-section">
										<textarea class="show-hide-textarea"><?php print_r( $fbDebugTokenInfo['fb_response'] ); ?></textarea>
									</div>
								</div>
							</div>
							<br>
							<a href="<?php echo getFacebookLoginUrlToAppend( trim( $_GET['id'] ) ); ?>" class="fb-link">
								<button type="button" class="fb-btn">						
									Change <span>facebook</span> account					
								</button>
							</a>		
							<br><br>
							<a href="php/process_disconnect_facebook.php?email=<?php echo $info['email'] ?>&info=<?php echo $info['fb_access_token'] ?>" class="section-action-container">
								<button type="button" class="section-red-button-container" id="disconnect_button">
									Disconnect <span>facebook</span> account
								</button>
							</a>	
							<?php if ( isset( $_SESSION['facebook_account_already_exists'] ) && $_SESSION['facebook_account_already_exists'] ) : // enter password to connect account ?>
								<script>
									alert( '<?php echo $fbLogin['message'] ?>' );
									<?php $_SESSION['facebook_account_already_exists'] = false; ?>
									window.history.go(-1);
									FB.logout(function(response){
										FB.Auth.setAuthResponse(null,'unknown'); 										
									});
								</script>	
							<?php elseif ( !empty( $fbLogin['go_back'] ) && $fbLogin['go_back'] ) : ?>
								<script> window.history.go(-1); </script>
							<?php endif; ?>
							
							<br><br>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</body>
	<script>
		$( function() { // once the document is ready, do things
			$( '#change_password' ).on( 'click', function() { // onclick for our change password check box
				if ( $( '#change_password_section' ).is( ':visible' ) ) { // if visible, hide it
					$( '#change_password_section' ).hide();
				} else { // if hidden, show it
					$( '#change_password_section' ).show();
				}
			} );

			$( '#update_button' ).on( 'click', function() { // onclick for our update button
				processAdminUpdateAccount();
			} );
			
			$( '#return_button' ).on( 'click', function() { // onclick for our return button
				history.go(-1);
			} );

			$( '.update-input' ).keyup( function( e ) {
				if ( e.keyCode == 13 ) { // our enter key
					processAdminUpdateAccount();
				}
			} );
			
			$( '.show-hide' ).on( 'click', function() { // on click for show hide section
				// get section we are showing/hiding
				var showHideSection = $( this ).data( 'section' );

				if ( $( '#' + showHideSection ).is( ':visible' ) ) { // section is currently visible
					// change text to show
					$( this ).html( 'show' );

					// hide section
					$( '#' + showHideSection ).hide();
				} else { // section is currently hidden
					// changet text to hide
					$( this ).html( 'hide' );

					// show section
					$( '#' + showHideSection ).show();
				}
			} );			
			
			$( '#disconnect_button' ).on( 'click', function() { // onclick for our return button
				alert( 'Facebook disconnected successfully' );
				location.reload();				
			} );
		} );		
		
		function processAdminUpdateAccount() {		
			$.ajax( {
				url: 'php/process_admin_append.php',
				data: $( '#myaccount_form' ).serialize(),
				type: 'post',
				dataType: 'json',
				success: function( data ) {
					if ( 'ok' == data.status ) {						
						alert( 'Profile Updated Successfully' );
						history.go(-1);
					} else if ( 'fail' == data.status ) {
						alert( data.message );
					}
				}
			} );
		}
	</script>
</html>