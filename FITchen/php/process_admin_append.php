<?php
	// load up global things
	include_once '../autoloader.php';

	if ( !filter_var( trim( $_POST['email'] ), FILTER_VALIDATE_EMAIL ) ) { // check email address
		$status = 'fail';
		$message = 'Invalid Email';
	} elseif ( !$_POST['first_name'] || !$_POST['last_name'] ) { // check name
		$status = 'fail';
		$message = 'Invalid first or last name';
	} elseif ( isset( $_POST['change_password'] ) && ( !$_POST['password'] || $_POST['password'] != $_POST['confirm_password'] || strlen( $_POST['password'] ) < 8 ) ) { // check password/confirm password
		$status = 'fail';
		$message = 'Invalid password or passwords do not match and must be at least 8 characters';
	} else { // all good!
		$status = 'ok';
		$message = 'valid';

		// update the users info
		adminUpdateUserInfo( $_POST );
	}

	echo json_encode( // return json for ajaz on front end
		array(
			'status' => $status,
			'message' => $message
		)
	);
?>