<?php
	//Config file is used to store creds we want to keep out of our repository and www root.

	// define db creds
	 define( 'DB_HOST', 'localhost' ); // database host
	 define( 'DB_NAME', 'fitchen' ); // database name
	 define( 'DB_USER', 'root' ); // database username
	 define( 'DB_PASS', '' ); // database password

	// fb creds
	 define( 'FB_APP_ID', '208895404290104' );
	 define( 'FB_APP_SECRET', 'c2e06cebf120b6d16540b725b1293e82' );
	 define( 'FB_REDIRECT_URI', 'http://localhost/FITchen/signup_or_login.php' );
	 define( 'FB_CONNECT_REDIRECT_URI', 'http://localhost/FITchen/myaccount.php' );
	 define( 'FB_APPEND_REDIRECT_URI', 'http://localhost/FITchen/admin_append.php' );
?>