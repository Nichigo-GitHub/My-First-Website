<?php
	/* Make call to facebook endpoint
	 * parameter: string $endpoint make call to this enpoint
	 *            array $params array keys are the variable names required by the endpoint
	 * return   : array $response */
	function makeFacebookApiCall( $endpoint, $params ) {
		// open curl call, set endpoint and other curl params
		$ch = curl_init();
		curl_setopt( $ch, CURLOPT_URL, $endpoint . '?' . http_build_query( $params ) );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
		curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
		
		// get curl response, json decode it, and close curl
		$fbResponse = curl_exec( $ch );
		$fbResponse = json_decode( $fbResponse, TRUE );
		curl_close( $ch );
		
		return array( // return response data
			'endpoint' => $endpoint,
			'params' => $params,
			'has_errors' => isset( $fbResponse['error'] ) ? TRUE : FALSE, // boolean for if an error occured
			'error_message' => isset( $fbResponse['error'] ) ? $fbResponse['error']['message'] : '', // error message
			'fb_response' => $fbResponse // actual response from the call
		);
	}
	
	/* Get facebook api login url that will take the user to facebook and present them with login dialog
	 * Endpoint : https://www.facebook.com/{fb-graph-api-version}/dialog/oauth?client_id={app-id}&redirect_uri={redirect-uri}&state={state}&scope={scope}&auth_type={auth-type}
	 * parameter: none
	 * return   : string */
	function getFacebookLoginUrl() {
		// endpoint for facebook login dialog
		$endpoint = 'https://www.facebook.com/' . FB_GRAPH_VERSION . '/dialog/oauth';
		
		$params = array( // login url params required to direct user to facebook and promt them with a login dialog
			'client_id' => FB_APP_ID,
			'redirect_uri' => FB_REDIRECT_URI,
			'state' => FB_APP_STATE,
			'scope' => 'email',
			'auth_type' => 'rerequest'
		);
		
		// return login url
		return $endpoint . '?' . http_build_query( $params );
	}
	
	/* Get an access token with the code from facebook
	 * Endpoint : https://graph.facebook.com/{fb-graph-version}/oauth/access_token?client_id{app-id}&client_secret={app-secret}&redirect_uri={redirect_uri}&code={code}
	 * parameter: string $code
	 * return   : array $response */
	function getAccessTokenWithCode( $code ) {
		// endpoint for getting an access token with code
		$endpoint = FB_GRAPH_DOMAIN . FB_GRAPH_VERSION . '/oauth/access_token';
		
		$params = array( // params for the endpoint
			'client_id' => FB_APP_ID,
			'client_secret' => FB_APP_SECRET,
			'redirect_uri' => FB_REDIRECT_URI,
			'code' => $code
		);
		
		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}

	/* Get a users facebook info
	 * Endpoint : https://graph.facebook.com/me?fields={fields}&access_token={access-token}
	 * parameter: string $accessToken
	 * return   : array $response */
	function getFacebookUserInfo( $accessToken ) {
		// endpoint for getting a users facebook info
		$endpoint = FB_GRAPH_DOMAIN . 'me';

		$params = array( // params for the endpoint
			'fields' => 'first_name,last_name,email,picture',
			'access_token' => $accessToken
		);

		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}

	/* Try and log a user in with facebook
	 * parameter: array $get contains the url $_GET variables from the redirect uri after user authenticates with facebook
	 * return   : array $response */
	function tryAndLoginWithFacebook( $get ) {
		// assume fail
		$status = 'fail';
		$message = '';

		// reset session vars
		$_SESSION['fb_access_token'] = array();
		$_SESSION['fb_user_info'] = array();
		$_SESSION['facebook_account_already_exists'] = false;

		if ( isset( $get['error'] ) ) { // error comming from facebook GET vars
			$message = $get['error_description'];
		} else { // no error in facebook GET vars
			// get an access token with the code facebook sent us
			$accessTokenInfo = getAccessTokenWithCode( $get['code'] );

			if ( $accessTokenInfo['has_errors'] ) { // there was an error getting an access token with the code
				$message = $accessTokenInfo['error_message'];
			} else { // we have access token! :D
				// set access token in the session
				$_SESSION['fb_access_token'] = $accessTokenInfo['fb_response']['access_token'];

				// get facebook user info with the access token
				$fbUserInfo = getFacebookUserInfo( $_SESSION['fb_access_token'] );

				if ( !$fbUserInfo['has_errors'] && !empty( $fbUserInfo['fb_response']['id'] ) && !empty( $fbUserInfo['fb_response']['email'] ) ) { // facebook gave us the users id/email
					// 	all good!
					$status = 'ok';

					// save user info to session
					$_SESSION['fb_user_info'] = $fbUserInfo['fb_response'];

					// check for user with facebook id
					$userInfoWithId = getRowWithValue( 'users', 'fb_user_id', $fbUserInfo['fb_response']['id'] );

					if ( $userInfoWithId ) { // user has logged in with facebook before so we found them
						// update user
						updateRow( 'users', 'fb_access_token', $_SESSION['fb_access_token'], $userInfoWithId['id'] );
						$userInfo = getRowWithValue( 'users', 'id', $userInfoWithId['id'] );

						// save info to php session so they are logged in
						$_SESSION['is_logged_in'] = true;
						$_SESSION['user_info'] = $userInfo;
					} else { // user not found with id sign them up and log them in
						// sign user up
						$fbUserInfo['fb_response']['fb_access_token'] = $_SESSION['fb_access_token'];
						$userId = signUserUp( $fbUserInfo['fb_response'] );
						$userInfo = getRowWithValue( 'users', 'id', $userId );

						// save info to php session so they are logged in
						$_SESSION['is_logged_in'] = true;
						$_SESSION['user_info'] = $userInfo;
					}
				} else {
					$message = 'Invalid creds';
				}
			}
		}

		return array( // return status and message of login
			'status' => $status,
			'message' => $message,
		);
	}

	/* Get debug info on an access token
	 * Endpoint : https://graph.facebook.com/debug_token?input_token={access-token}&access_token={access-token}
	 * parameter: string $accessToken
	 * return   : array $response */
	function getDebugAccessTokenInfo( $accessToken ) {
		// endpoint for getting debug info
		$endpoint = FB_GRAPH_DOMAIN . 'debug_token';

		$params = array( // params for the endpoint
			'input_token' => $accessToken,
			'access_token' => $accessToken
		);

		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}
	
	
	
	
	
	
	
	
	/* Get facebook api login url that will take the user to facebook and present them with login dialog
	 * Endpoint : https://www.facebook.com/{fb-graph-api-version}/dialog/oauth?client_id={app-id}&redirect_uri={redirect-uri}&state={state}&scope={scope}&auth_type={auth-type}
	 * parameter: none
	 * return   : string */
	function getFacebookLoginUrlToConnect() {
		// endpoint for facebook login dialog
		$endpoint = 'https://www.facebook.com/' . FB_GRAPH_VERSION . '/dialog/oauth';
		
		$params = array( // login url params required to direct user to facebook and promt them with a login dialog
			'client_id' => FB_APP_ID,
			'redirect_uri' => FB_CONNECT_REDIRECT_URI,
			'state' => FB_APP_STATE,
			'scope' => 'email',
			'auth_type' => 'rerequest'
		);
		
		// return login url
		return $endpoint . '?' . http_build_query( $params );
	}
	
	/* Get an access token with the code from facebook
	 * Endpoint : https://graph.facebook.com/{fb-graph-version}/oauth/access_token?client_id{app-id}&client_secret={app-secret}&redirect_uri={redirect_uri}&code={code}
	 * parameter: string $code
	 * return   : array $response */
	function getAccessTokenWithCodeToConnect( $code ) {
		// endpoint for getting an access token with code
		$endpoint = FB_GRAPH_DOMAIN . FB_GRAPH_VERSION . '/oauth/access_token';
		
		$params = array( // params for the endpoint
			'client_id' => FB_APP_ID,
			'client_secret' => FB_APP_SECRET,
			'redirect_uri' => FB_CONNECT_REDIRECT_URI,
			'code' => $code
		);
		
		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}
	
	/* Get a users facebook info
	 * Endpoint : https://graph.facebook.com/me?fields={fields}&access_token={access-token}
	 * parameter: string $accessToken
	 * return   : array $response */
	function getFacebookUserInfoToConnect( $accessToken ) {
		// endpoint for getting a users facebook info
		$endpoint = FB_GRAPH_DOMAIN . 'me';

		$params = array( // params for the endpoint
			'fields' => 'first_name,last_name,email,picture',
			'access_token' => $accessToken
		);

		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}
	
	/* Try and log a user in with facebook
	 * parameter: array $get contains the url $_GET variables from the redirect uri after user authenticates with facebook
	 * return   : array $response */
	function tryAndConnectFacebookAccount( $get, $email ) {
		// assume fail
		$status = 'fail';
		$message = '';
		$go_back = false;

		// reset session vars
		$_SESSION['fb_access_token'] = array();
		$_SESSION['fb_user_info'] = array();
		$_SESSION['facebook_account_already_exists'] = false;

		if ( isset( $get['error'] ) ) { // error comming from facebook GET vars
			$message = $get['error_description'];
		} else { // no error in facebook GET vars
			// get an access token with the code facebook sent us
			$accessTokenInfo = getAccessTokenWithCodeToConnect( $get['code'] );

			if ( $accessTokenInfo['has_errors'] ) { // there was an error getting an access token with the code
				$message = $accessTokenInfo['error_message'];
			} else { // we have access token! :D
				// set access token in the session
				$_SESSION['fb_access_token'] = $accessTokenInfo['fb_response']['access_token'];

				// get facebook user info with the access token
				$fbUserInfo = getFacebookUserInfoToConnect( $_SESSION['fb_access_token'] );

				if ( !$fbUserInfo['has_errors'] && !empty( $fbUserInfo['fb_response']['id'] ) && !empty( $fbUserInfo['fb_response']['email'] ) ) { // facebook gave us the users id/email					
					// check for user with facebook id
					$userInfoWithId = getRowWithValue( 'users', 'fb_user_id', $fbUserInfo['fb_response']['id'] );
					
					if ( $userInfoWithId ) { // user has logged in with facebook before so we found them
						// 	all good!
						$status = 'ok';
						
						// facebook account already exists is true
						$message = 'Facebook account is already connected with another user\nPlease log in a different Facebook account';
						$_SESSION['facebook_account_already_exists'] = true;					
					} else { // user not found with id sign them up and log them in
						// 	all good!
						$status = 'ok';
						$go_back = true;
						
						// Connect Facebook account						
						$fbUserInfo['fb_response']['fb_access_token'] = $_SESSION['fb_access_token'];
						$userId = connectFacebookAccount( $fbUserInfo['fb_response'], $email );						
						$userInfo = getRowWithValue( 'users', 'email', $email );		
						$_SESSION['user_info'] = $userInfo;
						$_SESSION['user_info']['fb_access_token'] = $_SESSION['fb_access_token'];
					}
				} else {
					$message = 'Invalid creds';
				}
			}
		}

		return array( // return status and message of login
			'status' => $status,
			'message' => $message,
			'go_back' => $go_back
		);
	}
	
	
	
	
	
	
	
	
	/* Get facebook api login url that will take the user to facebook and present them with login dialog
	 * Endpoint : https://www.facebook.com/{fb-graph-api-version}/dialog/oauth?client_id={app-id}&redirect_uri={redirect-uri}&state={state}&scope={scope}&auth_type={auth-type}
	 * parameter: none
	 * return   : string */
	function getFacebookLoginUrlToAppend( $id ) {
		// endpoint for facebook login dialog
		$endpoint = 'https://www.facebook.com/' . FB_GRAPH_VERSION . '/dialog/oauth';
		
		$params = array( // login url params required to direct user to facebook and promt them with a login dialog
			'client_id' => FB_APP_ID,
			'redirect_uri' => FB_APPEND_REDIRECT_URI . '?id=' . $id,
			'state' => FB_APP_STATE,
			'scope' => 'email',
			'auth_type' => 'rerequest'
		);
		
		// return login url
		return $endpoint . '?' . http_build_query( $params );
	}
	
	/* Get an access token with the code from facebook
	 * Endpoint : https://graph.facebook.com/{fb-graph-version}/oauth/access_token?client_id{app-id}&client_secret={app-secret}&redirect_uri={redirect_uri}&code={code}
	 * parameter: string $code
	 * return   : array $response */
	function getAccessTokenWithCodeToAppend( $code, $id ) {
		// endpoint for getting an access token with code
		$endpoint = FB_GRAPH_DOMAIN . FB_GRAPH_VERSION . '/oauth/access_token';
		
		$params = array( // params for the endpoint
			'client_id' => FB_APP_ID,
			'client_secret' => FB_APP_SECRET,
			'redirect_uri' => FB_APPEND_REDIRECT_URI . '?id=' . $id,
			'code' => $code
		);
		
		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}
	
	/* Get a users facebook info
	 * Endpoint : https://graph.facebook.com/me?fields={fields}&access_token={access-token}
	 * parameter: string $accessToken
	 * return   : array $response */
	function getFacebookUserInfoToAppend( $accessToken ) {
		// endpoint for getting a users facebook info
		$endpoint = FB_GRAPH_DOMAIN . 'me';

		$params = array( // params for the endpoint
			'fields' => 'first_name,last_name,email,picture',
			'access_token' => $accessToken
		);

		// make the api call
		return makeFacebookApiCall( $endpoint, $params );
	}
	
	/* Try and log a user in with facebook
	 * parameter: array $get contains the url $_GET variables from the redirect uri after user authenticates with facebook
	 * return   : array $response */
	function tryAndAppendFacebookAccount( $get, $email, $id ) {
		// assume fail
		$status = 'fail';
		$message = '';
		$go_back = false;
		$_SESSION['facebook_account_already_exists'] = false;

		if ( isset( $get['error'] ) ) { // error comming from facebook GET vars
			$message = $get['error_description'];
		} else { // no error in facebook GET vars
			// get an access token with the code facebook sent us
			$accessTokenInfo = getAccessTokenWithCodeToAppend( $get['code'], $id );
			
			if ( $accessTokenInfo['has_errors'] ) { // there was an error getting an access token with the code
				$message = $accessTokenInfo['error_message'];				
				
			} else { // we have access token! :D
				// get facebook user info with the access token
				$fbUserInfo = getFacebookUserInfoToAppend( $accessTokenInfo['fb_response']['access_token'] );
				
				if ( !$fbUserInfo['has_errors'] && !empty( $fbUserInfo['fb_response']['id'] ) && !empty( $fbUserInfo['fb_response']['email'] ) ) { // facebook gave us the users id/email					
					// check for user with facebook id
					$userInfoWithId = getRowWithValue( 'users', 'fb_user_id', $fbUserInfo['fb_response']['id'] );
					
					if ( $userInfoWithId ) { // user has logged in with facebook before so we found them
						// 	all good!
						$status = 'ok';
						
						// facebook account already exists is true
						$message = 'Facebook account is already connected with another user\nPlease log in a different Facebook account';
						$_SESSION['facebook_account_already_exists'] = true;					
					} else { // user not found with id sign them up and log them in
						// 	all good!
						$status = 'ok';
						$go_back = true;
						
						// Connect Facebook account						
						$fbUserInfo['fb_response']['fb_access_token'] = $accessTokenInfo['fb_response']['access_token'];
						$userId = connectFacebookAccount( $fbUserInfo['fb_response'], $email );						
						$userInfo = getRowWithValue( 'users', 'email', $email );		
						
						if ( $email == $_SESSION['user_info']['email'] ) {
							$_SESSION['user_info'] = $userInfo;
							$_SESSION['user_info']['fb_access_token'] = $accessTokenInfo['fb_response']['access_token'];
						}
					}
				} else {
					$message = 'Invalid creds';
				}
			}
		}

		return array( // return status and message of login
			'status' => $status,
			'message' => $message,
			'go_back' => $go_back
		);
	}
?>