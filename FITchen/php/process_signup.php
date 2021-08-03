<?php
	// load up global things
	include_once '../autoloader.php';

	// check for user with email address
	$userInfo = getUserWithEmailAddress( trim( $_POST['signup_email'] ) );

	if ( !filter_var( trim( $_POST['signup_email'] ), FILTER_VALIDATE_EMAIL ) ) { // check email address
		$status = 'fail';
		$message = 'Invalid Email';
	} elseif ( $userInfo['email'] == trim( $_POST['signup_email'] ) ) { // user already exists with that email
		$status = 'fail';
		$message = 'Email address already taken';
	} elseif ( !$_POST['signup_password'] || $_POST['signup_password'] != $_POST['signup_confirm_password']) { // check password/confirm password
		$status = 'fail';
		$message = 'Passwords do not match';
	} elseif ( strlen( $_POST['signup_password'] ) < 8 ) { // check password/confirm password
		$status = 'fail';
		$message = 'Password must be at least 8 characters';
	} else { // all passes so we are all good!
		$status = 'ok';
		$message = '';

		// sign the user up to our site!
		$userId = signUserUp( $_POST );
		
		// get updated info
		$userInfo = getUserWithEmailAddress( trim( $_POST['signup_email'] ) );
		
		// save info to php session
		$_SESSION['is_logged_in'] = true;
		$_SESSION['user_info'] = $userInfo;
	}
	
	// return status and message
	echo json_encode(
		array(
			'status' => $status,
			'message' => $message
		)
	);
?>