<?php
	// load up global things
	include_once '../autoloader.php';
	
	// get database connection
	$databaseConnection = getDatabaseConnection();
	
	// create our sql statment
	$statement = $databaseConnection->prepare( '
		UPDATE
			users 
		SET 
			fb_user_id = :fb_user_id,				
			fb_access_token = :fb_access_token
		WHERE
			email = :email
	' );
	
	// execute sql with actual values
	$statement->execute( array(
		'fb_user_id' => '',
		'fb_access_token' => '',
		'email' => $_GET['email']
	) );			
	
	// reset session vars
	if ( $_GET['info'] == $_SESSION['user_info']['fb_access_token'] ) {
		$_SESSION['user_info']['fb_access_token'] = '';
	} else {
	}
?>
<script>
	history.go(-1);
</script>