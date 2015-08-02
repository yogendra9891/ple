<?php
/**
 * Twitter notification component.
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Component
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Component', 'Controller');

/**
 * Twitter Component yogi + abhishek
 */
class TwitterNotificationComponent extends Component  
{
    public $components = array('Session');
	
    /**
	 * Authenticate the ple user
	 */
	public function twitterAuth()
	{
		//Load the app/Vendor/twitter/twitteroauth/twitteroauth.php
		App::import('Vendor', 'twitter', array('file' => 'twitter' . DS . 'twitteroauth' . DS . 'twitteroauth.php'));
		
		//Get user access tokens from bootstrap.
		$oauth_token = Configure::read('oauth_token');
		$oauth_token_secret = Configure::read('oauth_token_secret');
		
		//get conmsumer key, consumer secret key
		$consumer_key = Configure::read('CONSUMER_KEY');
		$consumer_secret = Configure::read('CONSUMER_SECRET');
		
		//Create a TwitterOauth object with consumer/user tokens.
		$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret );
		return $connection;
	}
	
	/**
	 * Authenticate the ple user
	 */
	public function twitterUserAuth()
	{
		//Load the app/Vendor/twitter/twitteroauth/twitteroauth.php
		App::import('Vendor', 'twitter', array('file' => 'twitter' . DS . 'twitteroauth' . DS . 'twitteroauth.php'));
	
		//Get user access tokens from bootstrap.
		$oauth_token = Configure::read('oauth_token');
		$oauth_token_secret = Configure::read('oauth_token_secret');
	
		//get conmsumer key, consumer secret key
		$consumer_key = Configure::read('CONSUMER_KEY');
		$consumer_secret = Configure::read('CONSUMER_SECRET');
	
		//Create a TwitterOauth object with consumer/user tokens.
		$connection = new TwitterOAuth( $consumer_key, $consumer_secret );
		
		return $connection;
	}
	
	/**
	 * send notification to the twitter account
	 * @param array, string
	 * @return boolean
	 */
	public function sendNotification($twitter_ids, $message_string)
	{
	    //get model object
		$this->TwitterMailQueue = ClassRegistry::init('TwitterMailQueue');
		
		//get connection object
		$connection = $this->twitterAuth();
		
		//@TODO to get the users detail from twitter
		//$content = $connection->get('account/verify_credentials'); 
		
		// Send a direct message 
		foreach ($twitter_ids as $twitter_id) {
		$this->TwitterMailQueue->create();
			//$options = array("user_id" => $twitter_id, "text" => $message_string);
			//$msg = $connection->post('direct_messages/new', $options);
			//save as mail queue
			$data['TwitterMailQueue']['twitter_id'] = $twitter_id;
			$data['TwitterMailQueue']['mail_data'] = $message_string;
			
			//save data for twitter mail queue
			$this->TwitterMailQueue->save($data);
			 
		}
		return true;
	}
	
	/**
	 * Get twitter id from screen name
	 * @param string $twitter_screen_name
	 * return int
	 */
	public function getTwitterIdFromScreenName($twitter_screen_name)
	{
		//get connection object
		$connection = $this->twitterAuth();
		
		//get profile info
		$detail = $connection->get('users/show', array('screen_name' => $twitter_screen_name));
		
		//check if error found
		if ( !array_key_exists('errors', $detail) ) {
		//twitter id
		$twitter_id = $detail->id;
		} else {
			$twitter_id = -1; //not exist
		}
		return $twitter_id;
	}
	
	/**
	 * Get twitter followers lists
	 * @param void
	 * @return array
	 */
	public function getFollowers()
	{
		//get connection object
		$connection = $this->twitterAuth();
		$response = $connection->get('followers/ids', array('user_id' => '115992765'));
		return $response;
	}
	
    /**
	 * Twitter call back from twitter
	 * @param void
	 * @return array
	 */
	public function twitterCallBack()
	{
		//Load the app/Vendor/twitter/twitteroauth/twitteroauth.php
		App::import('Vendor', 'twitter', array('file' => 'twitter' . DS . 'twitteroauth' . DS . 'twitteroauth.php'));
		
		//Get user access tokens from session
		$oauth_token = $this->Session->read('twt.oauth_token');
		$oauth_token_secret = $this->Session->read('twt.oauth_token');
		
		//get conmsumer key, consumer secret key
		$consumer_key = Configure::read('CONSUMER_KEY');
		$consumer_secret = Configure::read('CONSUMER_SECRET');
		
		//Create a TwitterOauth object with consumer/user tokens.
		$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret );
		
		/* Request access tokens from twitter */
		$access_token = $connection->getAccessToken($_REQUEST['oauth_verifier']);
		$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $access_token['oauth_token'], $access_token['oauth_token_secret'] );
		
		//get connection object
	    $content = $connection->get('account/verify_credentials');
    	return $content;
	}
	
	/**
	 * Redirect to the twitter if users has not loggeg in
	 */
	public function twitterRedirect()
	{
		//get connection object
		$connection = $this->twitterUserAuth();
		
		$site_address = Configure::read('site_url'); //getting from bootstrap config file
		/* Get temporary credentials. */
		$request_token = $connection->getRequestToken($site_address.'/dashboards/twitterCallBack');
		
		/* Save temporary credentials to session. */
		$this->Session->write('twt.oauth_token', $request_token['oauth_token']);
		$this->Session->write('twt.oauth_token_secret', $request_token['oauth_token_secret']);
		
		/* Save temporary credentials to session. */
		$token = $request_token['oauth_token'];

		/* If last connection failed don't display authorization link. */
		switch ($connection->http_code) {
			case 200:
				/* Build authorize URL and redirect user to Twitter. */
				$url = $connection->getAuthorizeURL($token);
				return $url;
				//header('Location: ' . $url);
				break;
			default:
				/* Show notification if something went wrong. */
				echo 'Could not connect to Twitter. Refresh the page or try again later.';
		}
		
	}
}