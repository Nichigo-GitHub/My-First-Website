<?php
	// Load up Global things
	include_once 'autoloader.php';
	
	if ( isset( $_GET['state'] ) && FB_APP_STATE == $_GET['state'] ) { // coming from facebook
		// Try and log the user in with $_GET vars from facebook
		$fbLogin = tryAndLoginWithFacebook( $_GET );
		
		if ( !empty( $fbLogin['status'] ) && 'fail' == $fbLogin['status'] ) : // we have to check if facebook has error ?>
			<script> alert( <?php $fbLogin['message'] ?> ); </script>
		<?php endif;
	}
	
	// Only if you are logged out can you view the login page
	loggedInRedirect();
?>
<!DOCTYPE html>
<html>
	<head>
		<!-- Icon of our Signup / Login Page -->
		<link rel="icon" type="image/png" sizes="32x32" href="css/favicon-32x32.png">
		
		<!-- Title of our Signup / Login Page -->
		<title>FITchen | Signup or Login</title>
		
		<!-- need this so everything looks good on mobile devices -->
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		
		<!-- CSS Styles for our Signup / Login Page -->
		<link href="css/global.css" rel="stylesheet" type="text/css">
		<link href="css/signup_or_login_style.css" rel="stylesheet" type="text/css">
		
		<!-- jquery -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>
	<body>
		<!-- Sign up / Log in page for Mobile Devices -->
		<div class="form-structor">
		
			<!-- Sign up form for Mobile Devices-->
			<form class="signup" id="signup_form_mobile">
				
				<!-- Sign up header for Mobile Devices -->
				<h2 class="form-title" id="signup">
					<span>or</span>Sign up
				</h2>
				
				<!-- Sign up inputs for Mobile Devices -->
				<div class="signup-form-holder">
					<input type="text" name="signup_first_name" class="signup-input-mobile" placeholder="First Name" />
					<input type="text" name="signup_last_name" class="signup-input-mobile" placeholder="Last Name" />
					<input type="text" name="signup_email" class="signup-input-mobile" placeholder="Email" />
					<input type="password" name="signup_password" class="signup-input-mobile" placeholder="Password" />
					<input type="password" name="signup_confirm_password" class="signup-input-mobile" placeholder="Confirm Password" />
				</div>
				
				<!-- Sign up button for Mobile Devices -->
				<button type="button" class="submit-btn" id="signup_button_mobile">
					Sign up
				</button>
				
				<!-- Sign up with Facebook Button for Mobile Devices -->
				<div class="section-action-container">
					<a href="<?php echo getFacebookLoginUrl(); ?>" class="a-fb">
						<div class="fb-button-container">
							Join with <span>facebook</span>
						</div>
					</a>
				</div>
				
			</form>
			
			<!-- Log in form for Mobile Devices -->
			<form class="login slide-up" id="login_form_mobile">
				<div class="center">
				
					<!-- Log in header for Mobile Devices -->
					<h2 class="form-title" id="login">
						<span>or</span>Log in
					</h2>
										
					<!-- Log in inputs for Mobile Devices -->
					<div class="login-form-holder">
						<input type="email" name="email" class="login-input-mobile" placeholder="Email" />
						<input type="password" name="password" class="login-input-mobile" placeholder="Password" />
					</div>
					
					<br>
					
					<!-- Log in button for Mobile Devices -->
					<button type="button" class="submit-btn" id="login_button_mobile">
						Log in
					</button>
					
					<!-- Log in with Facebook Button for Mobile Devices -->
					<div class="section-action-container">
						<a href="<?php echo getFacebookLoginUrl(); ?>" class="a-fb">
							<div class="fb-button-container">
								Connect with <span>facebook</span>
							</div>
						</a>
					</div>
					
				</div>
			</form>
		</div>
		
		<!-- Sign up / Log in page for Desktop Devices -->
		<div class="cont">
			
			<!-- Log in form for Desktop Devices -->
			<form class="form sign-in" id="login_form_desktop">
				
				<!-- Log in header for Desktop Devices -->
				<h2>Welcome back,</h2>
					
				<!-- Log in inputs for Desktop Devices -->
				<label>
					<span>Email</span>
					<input type="email" name="email" class="login-input-desktop"/>
				</label>
				<label>
					<span>Password</span>
					<input type="password" name="password" class="login-input-desktop"/>
				</label>
				
				<!-- Log in forgot password button for Desktop Devices (Not Ready) -->
				<!-- <p class="forgot-pass">
					Forgot password?
				</p> -->
				
				<!-- Log in button for Desktop Devices -->
				<button type="button" class="submit" id="login_button_desktop">
					Log in
				</button>
								
				<!-- Log in with Facebook Button for Desktop Devices -->
				<a href="<?php echo getFacebookLoginUrl(); ?>" class="fb-link">
					<button type="button" class="fb-btn">						
						Connect with <span>facebook</span>						
					</button>
				</a>
				
			</form>
			
			<!-- Sign up form for Desktop Devices -->
			<form class="sub-cont" id="signup_form_desktop">
			
				<!-- Sign up / Log in Switcher for Desktop Devices -->
				<div class="img">
				
					<div class="img__text m--up">
						<h2>New here?</h2>
						<p>Sign up and discover great amount of new opportunities!</p>
					</div>
					
					<div class="img__text m--in">
						<h2>One of us?</h2>
						<p>If you already have an account, just log in. We've missed you!</p>
					</div>
					
					<div class="img__btn">
						<span class="m--up">Sign Up</span>
						<span class="m--in">Log In</span>
					</div>
					
				</div>
				
				<div class="form sign-up">
					
					<!-- Sign up header for Desktop Devices -->
					<h2>Time to feel like home,</h2>
					
					<!-- Sign up inputs for Desktop Devices -->
					<label><input type="text" name="signup_first_name" class="signup-input-desktop" placeholder="First Name"/></label>
					<label><input type="text" name="signup_last_name" class="signup-input-desktop" placeholder="Last Name"/></label>
					<label><input type="email" name="signup_email" class="signup-input-desktop" placeholder="Email"/></label>
					<label><input type="password" name="signup_password" class="signup-input-desktop" placeholder="Password"/></label>
					<label><input type="password" name="signup_confirm_password" class="signup-input-desktop" placeholder="Confirm Password"/></label>
					
					<!-- Sign up button for Desktop Devices -->
					<button type="button" class="submit" id="signup_button_desktop">
						Sign Up
					</button>
					
					<!-- Sign up with Facebook Button for Desktop Devices -->
					<a href="<?php echo getFacebookLoginUrl(); ?>" class="fb-link">
						<button type="button" class="fb-btn">						
							Join with <span>facebook</span>						
						</button>
					</a>
					
				</div>
			</form>
		</div>
	</body>
	<script language = "JavaScript">
		const loginBtn = document.getElementById('login');
		const signupBtn = document.getElementById('signup');
		
		loginBtn.addEventListener('click', (e) => { // click button to expand login form 
			let parent = e.target.parentNode.parentNode;
			Array.from(e.target.parentNode.parentNode.classList).find((element) => {
				if(element !== "slide-up") { // if login form is not expanded
					parent.classList.add('slide-up') // expand login form
					loginBtn.parentNode.parentNode.classList.remove('slide-up') // disable login expand button
				}else{
					signupBtn.parentNode.classList.add('slide-up') // enable signup expand button
					parent.classList.remove('slide-up')	// retract signup form
				}
			});
		});
		
		signupBtn.addEventListener('click', (e) => { // click button to expand signup form 
			let parent = e.target.parentNode;
			Array.from(e.target.parentNode.classList).find((element) => {
				if(element !== "slide-up") { // if signup form is not expanded
					parent.classList.add('slide-up') // expand signup form
					signupBtn.parentNode.classList.remove('slide-up') // disable signup expand button
				}else{
					loginBtn.parentNode.parentNode.classList.add('slide-up') // enable login expand button
					parent.classList.remove('slide-up') // retract login form
				}
			});
		});
		
		// Desktop slider that switches log in & sign up pages
		document.querySelector('.img__btn').addEventListener('click', function() {
			document.querySelector('.cont').classList.toggle('s--signup');
		});
		
		$( '#login_button_mobile' ).on( 'click', function() { // onclick for our login button on mobile devices
			processLoginMobile();
		} );
		
		$( '.login-input-mobile' ).keyup( function( e ) {
			if ( e.keyCode == 13 ) { // Press enter key to login in mobile input
				processLoginMobile();
			}
		} );
		
		$( '#login_button_desktop' ).on( 'click', function() { // onclick for our login button on desktop devices
			processLoginDesktop();
		} );		
		
		$( '.login-input-desktop' ).keyup( function( e ) {
			if ( e.keyCode == 13 ) { // Press enter key to login in desktop input
				processLoginDesktop();
			}
		} );
		
		$( '#signup_button_mobile' ).on( 'click', function() { // onclick for our signup button
			processSignupMobile();
		} );
		
		$( '.signup-input-mobile' ).keyup( function( e ) {
			if ( e.keyCode == 13 ) { // Press enter key to signup in mobile input
				processSignupMobile();
			}
		} );
		
		$( '#signup_button_desktop' ).on( 'click', function() { // onclick for our signup button in desktop devices
			processSignupDesktop();
		} );		
		
		$( '.signup-input-desktop' ).keyup( function( e ) {
			if ( e.keyCode == 13 ) { // Press enter key to signup in desktop inputs
				processSignupDesktop();
			}
		} );
		
		// Sign up Process for Mobile Devices
		function processSignupMobile() {
			// assume no fields are blank
			var allFieldsFilledIn = true;
			
			$( '.signup-input-mobile' ).each( function() { // simple front end check, loop over signup inputs for mobile devices
				if ( '' == $( this ).val() ) { // input is blank, set flag to false
					allFieldsFilledIn = false;
				}
			} );
			
			if ( allFieldsFilledIn ) { // all fields are filled in!				
				// server side signup
				$.ajax( {
					url: 'php/process_signup.php',
					data: $( '#signup_form_mobile' ).serialize(),
					type: 'post',
					dataType: 'json',
					success: function( data ) {
						if ( 'ok' == data.status ) {
							window.location.href = "homepage.html";
						} else if ( 'fail' == data.status ) {
							alert( data.message );
						}
					}
				} );
			} else { // some fields are not filled in, show error message
				alert('All fields must be filled in.');
			}
		}		
		
		// Sign up Process for Desktop Devices
		function processSignupDesktop() {
			// assume no fields are blank
			var allFieldsFilledIn = true;
			
			$( '.signup-input-desktop' ).each( function() { // simple front end check, loop over signup inputs for desktop devices
				if ( '' == $( this ).val() ) { // input is blank, set flag to false
					allFieldsFilledIn = false;
				}
			} );
			
			if ( allFieldsFilledIn ) { // all fields are filled in!				
				// server side signup
				$.ajax( {
					url: 'php/process_signup.php',
					data: $( '#signup_form_desktop' ).serialize(),
					type: 'post',
					dataType: 'json',
					success: function( data ) {
						if ( 'ok' == data.status ) {
							window.location.href = "homepage.html";
						} else if ( 'fail' == data.status ) {
							alert( data.message );
						}
					}
				} );
			} else { // some fields are not filled in, show error message
				alert('All fields must be filled in.');
			}
		}		
		
		// Log in Process for Mobile Devices
		function processLoginMobile() {
			// assume no fields are blank
			var allFieldsFilledIn = true;
			
			$( '.login-input-mobile' ).each( function() { // simple front end check, loop over login inputs for mobile devices
				if ( '' == $( this ).val() ) { // input is blank, set flag to false
					allFieldsFilledIn = false;
				}
			} );
			
			if ( allFieldsFilledIn ) { // all fields are filled in!
				// server side login
				$.ajax( {
					url: 'php/process_login.php',
					data: $( '#login_form_mobile' ).serialize(),
					type: 'post',
					dataType: 'json',
					success: function( data ) {
						if ( 'ok' == data.status ) {
							window.location.href = "homepage.html";
						} else if ( 'fail' == data.status ) {
							alert( data.message );
						}
					}
				} );
			} else { // some fields are not filled in, show error message
				alert('All fields must be filled in.');
			}
		}
		
		// Log in Process for Desktop Devices
		function processLoginDesktop() {
			// assume no fields are blank
			var allFieldsFilledIn = true;
			
			$( '.login-input-desktop' ).each( function() { // simple front end check, loop over login inputs for desktop devices
				if ( '' == $( this ).val() ) { // input is blank, set flag to false
					allFieldsFilledIn = false;
				}
			} );
			
			if ( allFieldsFilledIn ) { // all fields are filled in!
				// server side login
				$.ajax( {
					url: 'php/process_login.php',
					data: $( '#login_form_desktop' ).serialize(),
					type: 'post',
					dataType: 'json',
					success: function( data ) {
						if ( 'ok' == data.status ) {
							window.location.href = "homepage.html";
						} else if ( 'fail' == data.status ) {
							alert( data.message );
						}
					}
				} );
			} else { // some fields are not filled in, show error message
				alert('All fields must be filled in.');
			}
		}
	</script>
</html>