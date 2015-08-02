<?php
/**
 * Student management controller.
 *
 * This file will render views from views/pages/
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
App::uses('AppController', 'Controller');
App::import('Controller', 'Users');
/**
 * Student controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class StudentsController extends AppController {

	/**
	 *
	 * @var array
	 */
	public $uses = array();
	/**
	 * function for finding the data from the PLE site
	 */

	private function __call_curl($data_array)
	{
		// create a new cURL resource
		$ch = curl_init();
		$timeout=5;
		$data = array('cat' => '', 'size' => '', 'style'=> '', 'function'=> '');
		// set URL and other appropriate options
		curl_setopt($ch,CURLOPT_URL,"http://www.actronmfginc.com/search/Latches.php");
		curl_setopt($ch, CURLOPT_POST, 1);
		//passing the post fields.
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		// defining the connection time out
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		// grab URL and pass it to the browser
		$data = curl_exec($ch);
		curl_close($ch);

		echo"<pre>";
		print_r($data);
		die;
	} 

	public function beforeFilter()
	{
		 $users = new UsersController; 
		//get login userId
	    $url_data = $this->request->params['named'];
	    $uid = $url_data['uid'];
		$result = $users->__checkLoginSession($uid);
		if (!$result) {
			die('invalid user');
		}
	}
	/**
	 * function for display the dashboard of a student
	 * @params site_id, student_id
	 */
	public function dashboard()
	{
		$url_data = $this->request->params['named'];
		$student_id = $url_data['uid'];
		$path = func_get_args();
		$count = count($url_data);
		try {
			if ($count) {

				$this->set('user_id', $student_id);
				$this->render();
			}else{
				throw new NotFoundException('Argument missing');
			}
		} catch (NotFoundException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException($e);
		}
	}
}