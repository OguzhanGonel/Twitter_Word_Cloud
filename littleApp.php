<?php

	echo "<h2>Simple Twitter API Test</h2>";
	require_once('TwitterAPIExchange.php');
 
	/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
	$settings = array(
    'oauth_access_token' => "2746316008-O3Yp8bRbETmC5MWyYEy4gwXXRwOeCQrhyvUJjH9",
    'oauth_access_token_secret' => "0ust5dNkuJnzMZiKr4JQ0Ow5i4mmVqXGxhU85Q13rlAEJ",
    'consumer_key' => "0yEc8mPJLS2EKCtHV06FCZTwc",
    'consumer_secret' => "foGajnRW4km0u71E68vKAkraMGbfohZuokiJPlIDt4p8pVmYia"
);	

	$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
 
$requestMethod = "GET";
 
$getfield = '?screen_name=iagdotme&count=20';
 
$twitter = new TwitterAPIExchange($settings);
echo $twitter->setGetfield($getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest();

?>