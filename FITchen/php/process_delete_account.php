<?php
	// load up global things
	include_once '../autoloader.php';

	// get database connection
	$databaseConnection = getDatabaseConnection();

	// create our sql statment to delete account
	$statement = $databaseConnection->prepare( '
		DELETE FROM
			users
		WHERE
			id = '.$_GET['id'].'
	' );	

	// run the sql statement
	$statement->execute();
	
	// redirect to admin panel after deleting
	header("Location:http://localhost/FITchen/adminpanel.php");
	exit();
?>