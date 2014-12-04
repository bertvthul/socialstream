<?php
require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'TwitterAPIExchange.php');



/** Set access tokens here - see: https://dev.twitter.com/apps/ **/
$settings = array(
    'oauth_access_token' => "2290859910-H7oDQDnhA72DUgP2clkkinkRwsmUq8daSVPwbo2",
    'oauth_access_token_secret' => "vR7STLAtkXsW4JwAfROIgnUS1r50fsmZ2rZRqOBSbUEEh",
    'consumer_key' => "06cg4PXhZDx80yZLV2a1lNL28",
    'consumer_secret' => "zg7F8EZiImlIzsTXOUlgsIpXVryvodYqgEPUsoYPLV2IfOE3AU"
);

$count = 30;
$getter = "timeline"; //timeline, zoek
$username = "cliqid_web";
$search="500px";
$include_retweets = 1;
$include_replies = 1;

if(empty($username)){
	echo JText::_("NO_USERNAME_DEFINED");
	return false;
}




if($getter == "followers"){
	/*//get your followers
	$url = 'https://api.twitter.com/1.1/followers/list.json';
	$getfield = '?username='.$username.'&skip_status=1';
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	echo $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();  
	*/
} else if($getter=="timeline"){
	//get user timeline
	$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
	$getfield = '?screen_name='.$username.'&count='.$count.'&exclude_replies='.$include_replies.'&include_rts='.$include_retweets.'&contributor_details=false&trim_user=0';
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$tweets = $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest(); 	
	$tweets = json_decode($tweets);
} else if($getter=="zoek"){
	//get user timeline
	/*
$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$getfield = 'q='.$username.'&count='.$count.'';
	$requestMethod = 'GET';
	$twitter = new TwitterAPIExchange($settings);
	$tweets = $twitter->setGetfield($getfield)
				 ->buildOauth($url, $requestMethod)
				 ->performRequest();
	
	$tweets = json_decode($tweets);
*/

	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$getfield = '?q=#'.$search.'&count='.$count;
	$requestMethod = 'GET';
	
	$twitter = new TwitterAPIExchange($settings);
	$response = $twitter->setGetfield($getfield)
	    ->buildOauth($url, $requestMethod)
	    ->performRequest();
	
	$tweets = json_decode($response);
	$tweets=$tweets->statuses;
} else if ($getter=="geocode"){
	$url = 'https://api.twitter.com/1.1/search/tweets.json';
	$requestMethod = 'GET';
	
	$getfield = '?q=test&geocode=0,0,1mi&count=100";';
	
	$twitter = new TwitterAPIExchange($settings);
	$response =  $twitter->setGetfield($getfield)
	    ->buildOauth($url, $requestMethod)
	    ->performRequest();
	
	$tweets = json_decode($response);
	//$tweets=$tweets->statuses;
}
