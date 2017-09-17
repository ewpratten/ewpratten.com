<html lang="en"><head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, minimumscale=1.0, maximum-scale=1.0">

	
    <title>RetryLife Community</title>
  
<style>
	body {
		font-family: Roboto;
		margin: 0;
		padding: 0;
		background-image: url("../img/Background.png");
		background-size: 100% 100%;
		background-attachment: fixed;
		
	}
	.rant-top-bar {
		background-color:white;
	}
</style>
    

    <link href="https://fonts.googleapis.com/css?family=Comfortaa" rel="stylesheet" type="text/css">

    <link href="./style.css" rel="stylesheet" type="text/css">
    <link href="https://devrant.io/static/devrant/css/font-style.css?v=5" rel="stylesheet" type="text/css">



  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>


    <script src="/widgets.js" async></script>
    
</head>
<body >


  

	





<div class="container">

    <div class="interior-centered">
        <div class="interior-content" style="min-height: 804px;background-color:white;">

            <div class="body-col1">
            	<div class="body-col1-content">
            		
            		<div style="background-color:#243447;padding:15px;border-radius:10px;color:white;">
            			<img src="https://pbs.twimg.com/profile_images/884167837891342336/F8JOfFAf_400x400.jpg">
                <h1>RetryLife</h1>
                <p>Canada</p>
                <br>
                <br>
                
                <div style="padding:6px; background-color:#1ca2f2; border-radius:8px;">
                <a href="https://twitter.com/retrylife_music" class="twitter-follow-button" data-show-count="false">Follow @retrylife_music</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#1ca2f2; border-radius:8px;">
                <a href="https://twitter.com/ewpratten" class="twitter-follow-button" data-show-count="false">Follow @ewpratten</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#1ca2f2; border-radius:8px;">
                <a href="https://twitter.com/nsdesjardins345" class="twitter-follow-button" data-show-count="false">Follow @nsdesjardins345</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#ff0000; border-radius:8px;">
                <a href="https://www.youtube.com/channel/UCrHT3Lt0Mg90bspbMHJfTcA?sub_confirmation=1">Subscribe to RetryLife Official</a>
                </div>
                <br>
                <div style="padding:6px; background-color:#ff0000; border-radius:8px;">
                <a href="https://www.youtube.com/channel/UCxzARKt0_U0sLHbF4pDN1Pw?sub_confirmation=1">Subscribe to Nathan Desjardins</a>
                </div>
                <br>
                
                </div>
                <br>
                
                <div style="background-color:#243447;padding:15px;border-radius:10px;color:white;">
                	<?php
                	require_once('login/twitteroauth/OAuth.php');
require_once('login/twitteroauth/twitteroauth.php');
// define the consumer key and secet and callback
define('CONSUMER_KEY', 'YOUR_CONSUMER_KEY');
define('CONSUMER_SECRET', 'YOUR_CONSUMER_SECRET');
define('OAUTH_CALLBACK', 'YOUR_CONSUMER_CALLBACK_URL');
// start the session
session_start();

/*
 * PART 2 - PROCESS
 * 1. check for logout
 * 2. check for user session
 * 3. check for callback
 */

// 1. to handle logout request
if(isset($_GET['logout'])){
	//unset the session
	session_unset();
	// redirect to same page to remove url paramters
	$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}


// 2. if user session not enabled get the login url
if(!isset($_SESSION['data']) && !isset($_GET['oauth_token'])) {
	// create a new twitter connection object
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);
	// get the token from connection object
	$request_token = $connection->getRequestToken(OAUTH_CALLBACK);
	// if request_token exists then get the token and secret and store in the session
	if($request_token){
		$token = $request_token['oauth_token'];
		$_SESSION['request_token'] = $token ;
		$_SESSION['request_token_secret'] = $request_token['oauth_token_secret'];
		// get the login url from getauthorizeurl method
		$login_url = $connection->getAuthorizeURL($token);
	}
}

// 3. if its a callback url
if(isset($_GET['oauth_token'])){
	// create a new twitter connection object with request token
	$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['request_token'], $_SESSION['request_token_secret']);
	// get the access token from getAccesToken method
	$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
	if($access_token){
		// create another connection object with access token
		$connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $access_token['oauth_token'], $access_token['oauth_token_secret']);
		// set the parameters array with attributes include_entities false
		$params =array('include_entities'=>'false');
		// get the data
		$data = $connection->get('account/verify_credentials',$params);
		if($data){
			// store the data in the session
			$_SESSION['data']=$data;
			// redirect to same page to remove url parameters
			$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  			header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
		}
	}
}

/*
 * PART 3 - FRONT END
 *  - if userdata available then print data
 *  - else display the login url
*/

if(isset($login_url) && !isset($_SESSION['data'])){
	// echo the login url
	echo "<a href='$login_url'><button>Login with twitter </button></a>";
}
else{
	// get the data stored from the session
	$data = $_SESSION['data'];
	// echo the name username and photo
	echo "Name : ".$data->name."<br>";
	echo "Username : ".$data->screen_name."<br>";
	echo "Photo : <img src='".$data->profile_image_url."'/><br><br>";
	// echo the logout button
	echo "<a href='?logout=true'><button>Logout</button></a>";
}
                	?>
                	</div>
                
                
                
                
                </div>
            </div>

<div class="body-col2 page-feed">
    
    

		<div class="rantlist-bg">
			<ul class="rantlist">
				
				
					<a class="twitter-timeline" data-dnt="true" data-theme="dark" href="https://twitter.com/RetryLife_Music">Tweets by RetryLife_Music</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				
					<a class="twitter-timeline" data-dnt="true" data-theme="dark" href="https://twitter.com/nsdesjardins345">Tweets by RetryLife_Music</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				

<a class="twitter-timeline" data-dnt="true" data-theme="dark" href="https://twitter.com/ewpratten">Tweets by RetryLife_Music</a> <script async src="Https://platform.twitter.com/widgets.js" charset="utf-8"></script>
				
				

	

	    </ul>
</div>
<div class="clearfix"></div>
</div>
</div>





</div>  <!-- end container -->



</body></html>
