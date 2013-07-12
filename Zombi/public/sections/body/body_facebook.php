<div id="boxes">
	<?php
	/**
	 * Copyright 2011 Facebook, Inc.
	 *
	 * Licensed under the Apache License, Version 2.0 (the "License"); you may
	 * not use this file except in compliance with the License. You may obtain
	 * a copy of the License at
	 *
	 *     http://www.apache.org/licenses/LICENSE-2.0
	 *
	 * Unless required by applicable law or agreed to in writing, software
	 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
	 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
	 * License for the specific language governing permissions and limitations
	 * under the License.
	 */
	require './configs/fb/facebook.php';
	
	// Create our Application instance (replace this with your appId and secret).
	$facebook = new Facebook(array(
	  'appId'  => '451561054877637',
	  'secret' => '3a90116e6c8aa22963f68a0c3e6e29d8',
	));
	
	// Get User ID
	$user = $facebook->getUser();
	echo "getUser: " . $user;
	
	// We may or may not have this data based on whether the user is logged in.
	//
	// If we have a $user id here, it means we know the user is logged into
	// Facebook, but we don't know if the access token is valid. An access
	// token is invalid if the user logged out of Facebook.
	if ($user) {
	  try {
	    // Proceed knowing you have a logged in user who's authenticated.
	    $user_profile = $facebook->api('/me');
	  } catch (FacebookApiException $e) {
	    error_log($e);
	    $user = null;
	  }
	}
	echo "<br />user_profile: " . $user;
	
	// Login or logout url will be needed depending on current user state.
	if ($user) {
	  $logoutUrl = $facebook->getLogoutUrl();
	} else {
	  $loginUrl = $facebook->getLoginUrl();
	}
	
	// This call will always work since we are fetching public data.
	$zombi = $facebook->api('/zombi.sk');
	
	?>
	
    	<h1>PHP/JS SDK</h1>
	    <?php if ($user): ?>
	      <div>
	        Logout using OAuth 2.0 handled by the PHP SDK:
	      	<a href="<?php echo $logoutUrl; ?>" onclick="FB.logout();">Logout</a>
	      </div>
	    <?php else: ?>
	      <div>
	        Login using OAuth 2.0 handled by the PHP SDK:
	        <a href="<?php echo $loginUrl; ?>">Login with Facebook</a>
	      </div>
	    <?php endif ?>
	
	    <h3>PHP Session</h3>
	    <pre><?php print_r($_SESSION); ?></pre>
	
	    <?php if ($user): ?>
	      <h3>You</h3>
	      <img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
	      <h3>Your User Object (/me)</h3>
	      <pre><?php print_r($user_profile); ?></pre>
	    <?php else: ?>
	      <strong><em>You are not Connected.</em></strong>
	    <?php endif ?>
	    
	    <div id="fb-root"></div>
	    <script>
	      window.fbAsyncInit = function() {
	        FB.init({
	          appId: '<?php echo $facebook->getAppID() ?>',
	          cookie: true,
	          xfbml: true,
	          oauth: true
	        });
	        FB.Event.subscribe('auth.login', function(response) {
	          window.location.reload();
	        });
	        FB.Event.subscribe('auth.logout', function(response) {
	          window.location.reload();
	        });
	      };
	      (function() {
	        var e = document.createElement('script'); e.async = true;
	        e.src = document.location.protocol +
	          '//connect.facebook.net/en_US/all.js';
	        document.getElementById('fb-root').appendChild(e);
	      }());
	    </script>
	    
 </div>
