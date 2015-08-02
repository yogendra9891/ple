<?php
/**
 * Facebook Component
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Facebook Component
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */

App::uses('Controller', 'Controller');
class FacebookNotificationComponent extends Component
{
	public $components = array('Session');
	
	/**
	 * Sending the Facebook notification.
	 * @params array, string
	 * @return boolean
	 */
	public function sendNotification($users, $msg)
	{
		//get facebook model object
		$this->FacebookMailQueue = ClassRegistry::init('FacebookMailQueue');
		
		//getting the facebook object
		$facebook = $this->getFacebookConfiguration();
		
		//getting the facebook appid, app secret from bootstrap
		$app_id = Configure::read('APPID');
		$app_secret = Configure::read('APPSECRET');
				
		//create the access token by combination of appid and app secret.
		$app_access_token = $app_id . '|' . $app_secret;

		//sending the message to each user..
		foreach ( $users as $user ) {
// 			$authentic = $this->getFacebookAuthenticInfo($user);
// 			if ($authentic)
// 			$response = $facebook->api( '/'.$user.'/notifications', 'POST', array(
// 									   'template' => $msg,
// 					                   'href' => base64_encode($msg),
// 					                   'access_token' => $app_access_token
// 			));
			$this->FacebookMailQueue->create();
			$data['FacebookMailQueue']['facebook_id'] = $user;
			$data['FacebookMailQueue']['mail_data'] = $msg;
			//save data for facebook mail queue
			$this->FacebookMailQueue->save($data); //saving data for the facebook notifications.
		}
	    return true;
	}
	
	/**
	 * Getting the common configuratio
	 * @param none
	 * @return object
	 */
	public function getFacebookConfiguration()
	{
		CakeSession::start();
		//Load the app/Vendor/Facebook/facebook.php
		App::import('Vendor', 'Facebook', array('file' =>  'Facebook' . DS . 'facebook.php'));
		
		//getting the facebook appid, app secret from bootstrap
		$app_id = Configure::read('APPID');
		$app_secret = Configure::read('APPSECRET');
	
		//getting the facebook object
		$facebook_object = new Facebook(array( 'appId'  => $app_id, 'secret' => $app_secret));
		return $facebook_object;
	}
	
	/**
	 * Finding the user id from facebookm user name
	 * @param string
	 * @return int/boolean
	 */
	public function getFacebookIdFromUserName($facebook_user_name)
	{

		$timeout = 5;
		$url = "https://graph.facebook.com/".$facebook_user_name;
		
		// set URL and other appropriate options
		$ch = curl_init($url);
		
		//TRUE to return the transfer as a string of the return value
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		//binary transfer
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, 1);
		
		//restrict it to ssl
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		
		// grab URL and pass it to the browser
		$contents = curl_exec($ch);

		//decode the returened data
		$pageData = json_decode($contents);
		
		//check for if Face-book is not allowed on system.
		if (!$pageData) {
			echo $contents;
			exit;
		}
		//object to array
		$objtoarr = get_object_vars($pageData);
		curl_close($ch);
		
		if (@$objtoarr[error]->code == 100 || @$objtoarr[error]->code == 803) {
			return 0; //a invalid username..
		} else if (isset($objtoarr['id'])) {
			return $objtoarr['id'];
		}
		return 0;
	}
	
	/**
	 * Getting the facebook app authentic info for a user
	 * @param int
	 * @return int
	 */
	public function getFacebookAuthenticInfo($fb_uid)
	{
		//getting the facebook object
		$facebook = $this->getFacebookConfiguration();
		$result = $facebook->api(array(
				'method' => 'fql.query',
				'query' => "SELECT is_app_user FROM user WHERE uid=".$fb_uid
		));
		if (count($result)) {
			$is_installed = $result[0]['is_app_user'];
			if ($is_installed) 
				return 1; //user already authenticated PLE app
			 return 0; //user didn't yet authenticate PLE app
		} return 0;
	}
	
	/**
	 * make facebook login url and object
	 * @param none
	 * @return url 
	 */
	public function facebookRedirect()
	{
		//getting the facebook object
		$facebook = $this->getFacebookConfiguration();
		
		//getting from bootstrap config file
		$site_address = Configure::read('site_url');
		$params = array(
				'scope' => 'read_stream, friends_likes, email',
				'redirect_uri' => $site_address.'/dashboards/home/notificationsetting/'
		);

		$loginUrl = $facebook->getLoginUrl($params);
		return $loginUrl;
	}
	
	/**
	 * Facebook call back function for checking the current login user  info
	 * @param none
	 * @return ArrayObject
	 */
	public function facebookCallBack($fb_code)
	{
		$user_object = array();
		if (!empty($fb_code)) {
			//getting the facebook object
			$facebook = $this->getFacebookConfiguration();
			
			$fb_token = $facebook->getAccessToken();
			if (!empty($fb_token)) {
			 $user = $facebook->getUser();
			 $user_profile = $facebook->api('/me');
			 
			 if (isset($user_profile['username']))
			 	$user_object['facebook_username'] = $user_profile['username'];
			 else 
			 	$user_object['facebook_username'] =  $user_profile['email'];

			 $user_object['facebook_id'] = $user_profile['id'];
			 return $user_object;
			}
		}
		return $user_object;
	}
}
