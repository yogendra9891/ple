<?php

/**
 * UserDashboard management controller.
 *
 * This file will render views from views/ForumUsers/
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

/**
 * ForumUser management controller yogi + abhishek
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class DashboardsController extends AppController {

    //get model object
    public $uses = array('ForumUser', 'PleUser', 'Forum', 'PleSetting', 'PleForumSetting', 'PleForumSubscription',
        'AccessQuestion', 'ContentPageSetting', 'ReminderSetting', 'ReadonlySetting', 'ContentTopic',
        'InstructorAssignmentSetting', 'StudentAssignmentSetting', 'WhatsNewSetting', 'EmailUser',
        'TwitterUser', 'FacebookUser', 'PleForumAvailability', 'PleAssignmentReminder', 'ContentPageStructure', 'DashboardActiveSettingLogs', 'DashboardNotificationReminderSettingLogs',
		'AssignmentReminderLog', 'OnlineSettingLog'
    );
    public $components = array('TwitterNotification', 'FacebookNotification', 'Paginator');

    /**
     * Method to check the user login
     * Also checking the forum is enable+available for the current date
     */
    public function beforeFilter() {
        if ($this->action != 'login') {
            //get user session
            $user = $this->Session->read('UserData.userName');
            if ($user == "") {
            	$logout_url = Configure::read('logout_url');
                return	$this->redirect($logout_url);
            }
        }
    }

    /**
     * Get the user logged in forum
     * @param string $ruserobj
     * @return none
     */
    public function login($ruserobj = null) {
        if ($ruserobj) {
            //decode the bash64 encoded $ruserobj
            $ruserobj = base64_decode($ruserobj);

            //json decode
            $ruserdecodeObj = json_decode($ruserobj);
            $user = $ruserdecodeObj->userName;
            $myCourse = $ruserdecodeObj->course;
            //check for content page id
			//if login is for chat then no content page id required
			$contentpageId = empty($ruserdecodeObj->contentPageId) ? 0 : $ruserdecodeObj->contentPageId;
            $userType = $ruserdecodeObj->userType;
            $useremail = $ruserdecodeObj->email;
        
            //@TODO we will change it by the data from PLE app of the current logged in user.
            $proposed_coursers = $myCourse;
            $explored_courses = explode('/', $proposed_coursers);
            $course_data = $data['user']['course'] = $proposed_coursers;
            
            //get Course and section name
            $course_info = $this->getCourseNameOfUser($course_data);
			
            $course_name = $course_info->course_name;
            $course_section = $course_info->section_name;
            
            $midasId = $data['user']['midasId'] = $user;

            $name = $user;
            $email = $useremail;
            //prepare an array for saving the data in local DB.
            //$userData = array("userName"=>$user, "midasId"=>$user, "course"=>$course_name, "section"=>$course_section, "password"=>123456);
            $userData = array("userName" => trim($user),
                "midasId" => trim($user),
                "course" => trim($course_info->course_name),
                "section" => trim($course_info->section_name),
                "password" => 123456,
                "user_type" => trim($userType),
                "name" => trim($name),
                "email" => trim($email)
            );
            //register user in ple/daffodil server
            $regisetUser = $this->__registerPleUser($userData);
            if ($regisetUser) {
                //saving the PLE user in our local database.
                //check if user is already login
                $isLogin = $this->ForumUser->find('count', array('conditions' => array('midasId' => $midasId, 'course' => $course_info->course_name)));
                //if user is already logged in then it remove the prevoius entry
                if ($isLogin == 1) {
                    $isLogin = $this->ForumUser->deleteAll(array('midasId' => $midasId, 'course' => $course_info->course_name));
                }
                $this->ForumUser->save($userData);
                //set the user session
                $this->Session->write('UserData.userType', $userType);
                $this->Session->write('UserData.userName', $user);
                $this->Session->write('UserData.usersCourses', $explored_courses);
                $ruserdata = array('userName' => $user, 'course' => $explored_courses[0], 'email'=>$email,'contentPageId' => $contentpageId, 'userType' => $userType);
                $encodedata = base64_encode(json_encode($ruserdata));
                //$this->Session->write('UserData.ruserobject', $encodedata);

                $this->redirect(array('controller' => 'dashboards', 'action' => 'index', $encodedata));
            }
        }
    }

    /**
     * Register user in PLE.
     * User will get register in every login, to get the update if user has changed his profile
     * from ple site.
     * @param user info
     * @return boolean
     */
    public function __registerPleUser($userData) {
        if ($userData) {
            //check if user is already registered
            $is_register = $this->PleUser->find('first', array('conditions' => array('midasId' => $userData['midasId'], 'course' => $userData['course']), 'fields' => array('id')));
            //check if id exist
            if (isset($is_register['PleUser']['id'])) {
                $userData['id'] = $is_register['PleUser']['id'];
                $this->PleUser->save($userData);
            } else {
                $this->PleUser->save($userData);
            }
            //register the user for email subscription.
            if ($this->PleUser->id)
                $this->_saveEmailConfiguration($userData);

            return true;
        }
        return false;
    }

    /**
     * show the dashboard home page
     * @param string $encodedata
     * @return void
     */
    public function index($encodedata = null) {
        //@TODDO need to be implemented
        $this->layout = 'dashboard';
        $this->set('ruser_object', $encodedata);
    }

    /**
     * Showing the dashboard setting area.
     * @param userObject
     * @return none
     */
    public function home($type = null, $ruserobj = null) {
        //code for facebook login handling.
        if (isset($_REQUEST['code'])) {
            $this->facebookCallBack(@$_REQUEST['code']);
        } else if ((@$_REQUEST['error'] == 'access_denied') && (@$_REQUEST['error_code'] == 200)) {
            $this->_facebookErrorReport();
        }

        //code for facebook notification layout
        if (isset($_REQUEST['fb_source'])) {
            //here we consider the ruser object as the question body.
            $this->redirect(array('controller' => 'posts', 'action' => 'showNotification', $ruserobj));
        }

        $this->layout = 'dashboard';
        //$data = $this->request['data'];
        if ($ruserobj) {

            $cUserType = $this->Session->read('UserData.userType');

            //decode the bash64 encoded $ruserobj
            $ruserobj = base64_decode($ruserobj);
            //json decode
            $ruserdecodeObj = json_decode($ruserobj);
            $user = $ruserdecodeObj->userName;
            $myCourse = $ruserdecodeObj->course;
            $contentPageId = $ruserdecodeObj->contentPageId;
            
            //get Course and section name
            $course_info = $this->getCourseNameOfUser($myCourse);
            
            //$explored_course = explode('-', $myCourse);//separate to course and section by '-' character.
            $explored_courseName = $course_info->course_name;
            $explored_section = $course_info->section_name;

            //check if userType is instructor
            if ($userType = $cUserType) {
                //set the content page setting if content page setting do not exist
                $this->__setContentPageDefaultSetting($user, $explored_courseName, $explored_section, $contentPageId);

                //set the read only content page setting if not exist
                $this->__setReadOnlytSetting($user, $explored_courseName, $explored_section, $contentPageId);

                //set the notification content page setting if not exist
                $this->__setNotificationSetting($user, $explored_courseName, $explored_section, $contentPageId);

                //set the default twitter info 
                $this->_setDefaultTwitterValue($user);

                //set the default facebook info
                $this->_setDefaultFacebookValue($user);
            }

            //checking the setting for a content page for a user
            $this->_findWhatsNewSetting($contentPageId);

            //get allsection setting sections for same course
            $sections_list = $this->__allSections($contentPageId);
            $postdata = $this->forumPosts($contentPageId);
            $this->set('posts', $postdata);

            $this->set('course', $explored_courseName);
            $this->set('content_page_id', $contentPageId);
            $this->set('ruserobj', $ruserobj);

            //check for dashboard type
            switch ($type) {
                case 'whatsnew':
                	//finding the pages of most active forums
                	$active_posts_pages = $this->_mostActiveForumPosts($contentPageId);
                	$this->set('active_pages', $active_posts_pages);
                    $this->render('whatsnew');
                    break;
                case 'askaquestion':
                	$module_structure = $this->getContentPageStructure();
                	$this->set('module_structure', $module_structure['structure']);
                	$this->set('structure_title', $module_structure['title']);
                    $this->render('askaquestion');
                    break;
                case 'communitysetting':
                    $this->render('communitysetting');
                    break;
                case 'notificationsetting':
                    $this->render('notificationsetting');
                    break;
                default:
                    $this->render('home');
                    break;
            }
        }
    }

    /**
     * Set content page setting
     * @param username, courseName, sectionName, contentPageId
     * @return boolean
     */
    public function __setContentPageDefaultSetting($user, $explored_courseName, $explored_section, $contentpage_id) {
        //check if exist
        $resultsCount = $this->ContentPageSetting->find('count', array('conditions' =>
            array(
                'ContentPageSetting.contentpage_id' => $contentpage_id,
                'ContentPageSetting.section' => $explored_section,
                'ContentPageSetting.course' => $explored_courseName
        )));

        //check if resultCount is 0 then default setting will be saves
        if ($resultsCount == 0) {
            $data['ContentPageSetting']['instructor_id'] = $user;
            $data['ContentPageSetting']['contentpage_id'] = $contentpage_id;
            $data['ContentPageSetting']['section'] = $explored_section;
            $data['ContentPageSetting']['course'] = $explored_courseName;
            $this->ContentPageSetting->save($data);
        }
        return true;
    }

    /**
     * Set read only content page setting
     * @param username, courseName, sectionName, contentPageId
     * @return boolean
     */
    private function __setReadOnlytSetting($user, $explored_courseName, $explored_section, $contentpage_id) {
        //check if exist
        $resultsCount = $this->ReadonlySetting->find('count', array('conditions' =>
            array(
                'ReadonlySetting.contentpage_id' => $contentpage_id,
                'ReadonlySetting.section' => $explored_section,
                'ReadonlySetting.course' => $explored_courseName
        )));

        //check if resultCount is 0 then default setting will be saves
        if ($resultsCount == 0) {
            $data['ReadonlySetting']['instructor_id'] = $user;
            $data['ReadonlySetting']['contentpage_id'] = $contentpage_id;
            $data['ReadonlySetting']['section'] = $explored_section;
            $data['ReadonlySetting']['course'] = $explored_courseName;
            $this->ReadonlySetting->save($data);
        }
        return true;
    }

    /**
     * Set notification reminder setting
     * @param username, courseName, sectionName, contentPageId
     * @return boolean
     */
    private function __setNotificationSetting($user, $explored_courseName, $explored_section, $contentpage_id) {
        //check if exist
        $resultsCount = $this->ReminderSetting->find('count', array('conditions' =>
            array(
                'ReminderSetting.user_name' => $user,
                'ReminderSetting.content_page_id' => $contentpage_id,
                'ReminderSetting.section' => $explored_section,
                'ReminderSetting.course' => $explored_courseName
        )));

        //check if resultCount is 0 then default setting will be saves
        if ($resultsCount == 0) {
            $data['ReminderSetting']['user_name'] = $user;
            $cUserType = $this->Session->read('UserData.userType');
            $data['ReminderSetting']['user_type'] = $cUserType;
            $data['ReminderSetting']['content_page_id'] = $contentpage_id;
            $data['ReminderSetting']['section'] = $explored_section;
            $data['ReminderSetting']['course'] = $explored_courseName;
            $this->ReminderSetting->save($data);
        }
        return true;
    }

    /**
     * saving the default setting for a user for a content page whats new setting
     * @param none
     * @return boolean
     */
    private function _findWhatsNewSetting($conent_id) {
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
	 	$course_info = $this->getCourseNameOfUser($user_course_section);

        $result = $this->WhatsNewSetting->find('first', array('conditions' => array('WhatsNewSetting.contentpage_id' => $conent_id,
                'WhatsNewSetting.user_name' => $userName,
                'WhatsNewSetting.course_name' => $course_info->course_name,
                'WhatsNewSetting.section_name' => $course_info->section_name
        )));
        if (!count($result)) {
            $data = array();
            $data['WhatsNewSetting']['contentpage_id'] = $conent_id;
            $data['WhatsNewSetting']['user_name'] = $userName;
            $data['WhatsNewSetting']['course_name'] = $course_info->course_name;
            $data['WhatsNewSetting']['section_name'] = $course_info->section_name;
            $this->WhatsNewSetting->save($data);
        }
        return true;
    }

    /**
     * Save default user twitter id
     * @param string $user
     * @return boolean
     */
    private function _setDefaultTwitterValue($user) {
        //check if exist
        $resultsCount = $this->TwitterUser->find('count', array('conditions' =>
            array(
                'TwitterUser.midasId' => $user
        )));

        //check if resultCount is 0 then default setting will be saves
        if ($resultsCount == 0) {
            $data['TwitterUser']['midasId'] = $user;
            $data['TwitterUser']['twitterId'] = 0;
            $data['TwitterUser']['twitterScreenName'] = '';
            $this->TwitterUser->save($data);
        }
        return true;
    }

    /**
     * Save default user facebook id
     * @param string $user
     * @return boolean
     */
    private function _setDefaultFacebookValue($user) {
        //check if exist
        $resultsCount = $this->FacebookUser->find('count', array('conditions' =>
            array(
                'FacebookUser.midas_id' => $user
        )));

        //check if resultCount is 0 then default setting will be saves
        if ($resultsCount == 0) {
            $data['FacebookUser']['midas_id'] = $user;
            $data['FacebookUser']['facebook_id'] = 0;
            $data['FacebookUser']['facebook_username'] = '';
            $this->FacebookUser->save($data);
        }
        return true;
    }

    /**
     * Finding the insection-allsection setting for the course
     * @params course-section
     * @return string
     */
    private function __findForumSetting($explored_course) {
        $result = $this->PleForumSetting->find('first', array('conditions' => array('PleForumSetting.course' => $explored_course[0]), 'fileds' => array('PleForumSetting.setting_value')));
        if (@$result['PleForumSetting']['setting_value'])
            return $result['PleForumSetting']['setting_value'];
        return 2; //by default we are assuming it is the all section setting
    }

    /**
     * Finding the posts unread according to the ajax call.
     * @params none
     * @return string
     */
    public function forumPostsPagesSetting() { //exit('dd');
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);

        $conent_id = $this->request->data['dashboards']['content_page_id'];
        $options['conditions'][] = array('WhatsNewSetting.contentpage_id' => $conent_id,
            'WhatsNewSetting.user_name' => $userName,
            'WhatsNewSetting.course_name' => $course_info->course_name,
            'WhatsNewSetting.section_name' => $course_info->section_name);

        $result = $this->WhatsNewSetting->find('first', $options);

        $data_test = array();
        $data_test['WhatsNewSetting']['contentpage_id'] = $conent_id;
        $data_test['WhatsNewSetting']['user_name'] = $userName;
        $data_test['WhatsNewSetting']['course_name'] = $course_info->course_name;
        $data_test['WhatsNewSetting']['section_name'] = $course_info->section_name;
        $data_test['WhatsNewSetting']['count'] = $this->request->data['dashboards']['count'];
        $data_test['WhatsNewSetting']['view_name'] = $this->request->data['post-active-area'];

        if (count($result))
            $data_test['WhatsNewSetting']['id'] = $result['WhatsNewSetting']['id'];

        $this->WhatsNewSetting->save($data_test);

        $this->set('course', $course_info->course_name);
        $this->set('content_page_id', $this->request->data['dashboards']['content_page_id']);
// 		$object = array();
// 		$object['userName'] = $userName;
// 		$object['course'] = $user_course_section;
// 		$object['contentPageId'] = $this->request->data['dashboards']['content_page_id'];
// 		$user_object = json_encode($object);
// 		$user_object_data = base64_encode($user_object);
        $json_user_data = $this->request->data['dashboards']['userdata'];
        $user_object_data = base64_encode($json_user_data);

        $type = 'whatsnew';

        //checking save button is clicked...
        if (isset($this->request->data['save'])) {
        	//save the dashboard active forum/post active setting logs
        	$this->_saveActiveSettingLogs($data_test);
            $this->Session->setFlash('What\'s new setting saved successfully.');
        }
        $this->redirect(array('controller' => 'dashboards', 'action' => 'home', $type, $user_object_data));
    }

    /**
     * Forum Setting
     * 1 for inSection
     * 2 for allSection
     * @return string
     */
    public function forumSetting() {
        //get data
        if ($this->request->is('ajax')) {
            $data = $this->request['data'];

            $forum_setting = $data['forum_setting'];
            $content_page_id = $data['content_page_id'];

            $userName = $this->Session->read('UserData.userName');
            //get the user course name.
            $userCourse = $this->Session->read('UserData.usersCourses');

            $user_course_section = $userCourse[0];
            $user_exploded_course = explode('-', $user_course_section);
            $users_section = $user_exploded_course[1];
            $data['PleForumSetting']['course'] = $user_exploded_course[0];
            $data['PleForumSetting']['setting_value'] = $forum_setting;
            $data['PleForumSetting']['contentpage_id'] = $content_page_id;
            $data['PleForumSetting']['section'] = $users_section;
            //check if exist in db
            $result = $this->PleForumSetting->find('first', array('conditions' => array('PleForumSetting.course' => $data['PleForumSetting']['course'], 'PleForumSetting.section' => $users_section, 'PleForumSetting.contentpage_id' => $content_page_id), 'fields' => 'PleForumSetting.id'));
            $result_count = count($result);
            if ($result_count > 0) {
                //update the table
                $data['PleForumSetting']['id'] = $result['PleForumSetting']['id'];
                $this->PleForumSetting->save($data);
				
				$type = 2;
                $this->__communitySettingLog($type);
				
            } else {
                //insert the new entry
                $this->PleForumSetting->save($data);
				
				$type = 2;
                $this->__communitySettingLog($type);
            }
            exit;
        }
        echo "Some error occured";
        exit;
    }

    /**
     * Online users setting
     * 1 for inSection
     * 2 for allSection
     * @return string
     */
    public function onlineSetting() {
        //get data
        if ($this->request->is('ajax')) {
            $data = $this->request['data'];
            $online_setting = $data['online_setting'];
            $userName = $this->Session->read('UserData.userName');
            //get the user course name.
            $userCourse = $this->Session->read('UserData.usersCourses');

            $user_course_section = $userCourse[0];
            $user_exploded_course = explode('-', $user_course_section);
            $users_section = $user_exploded_course[1];
            $data['PleSetting']['course'] = $user_exploded_course[0];
            $data['PleSetting']['setting_type'] = 'section';
            $data['PleSetting']['setting_value'] = $online_setting;
            $data['PleSetting']['define_setting_value'] = 'test';
            $data['PleSetting']['section'] = $users_section;

            //check if exist in db
            $result = $this->PleSetting->find('first', array('conditions' => array('PleSetting.course' => $data['PleSetting']['course'], 'PleSetting.section' => $users_section), 'fields' => 'PleSetting.id'));
            $result_count = count($result);
            if ($result_count > 0) {
                //update the table
                $data['PleSetting']['id'] = $result['PleSetting']['id'];
                $this->PleSetting->save($data);
				
				$type = 1;
                $this->__communitySettingLog($type); //save the community setting log
				
            } else {
                //insert the new entry
                $this->PleSetting->save($data);
				
				$type = 1;
                $this->__communitySettingLog($type);//save the community setting log
            }
            exit;
        }
        echo "Some error occured";
        exit;
    }

    /**
     * Get forum setting of current login user
     * Forum setting is on the basis of forum name.
     * @params none
     * @return int
     */
    public function getForumSetting() {
        $userName = $this->Session->read('UserData.userName');

        //content page id
        $content_page_id = $this->params->params['pass'][0];

        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $result = $this->PleForumSetting->find('first', array('conditions' => array('PleForumSetting.course' => $course_info->course_name, 'PleForumSetting.section' => $course_info->section_name, 'PleForumSetting.contentpage_id' => $content_page_id), 'fields' => 'PleForumSetting.setting_value'));
        if ($result) {
            return $result['PleForumSetting']['setting_value'];
        } else {
            return 0;
        }
    }

    /**
     * Get online setting of current login user
     * Forum setting is on the basis of forum name.
     * @params none.
     * @return int
     */
    public function getOnlineSetting() {
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $result = $this->PleSetting->find('first', array('conditions' => array('PleSetting.course' => $course_info->course_name, 'PleSetting.section' => $course_info->section_name), 'fields' => 'PleSetting.setting_value'));
        if ($result) {
            return $result['PleSetting']['setting_value'];
        } else {
            return 0;
        }
    }

    /**
     * Save Reminder seeting done by student/instructor
     * ajax call
     */
    public function reminderSetting() {
        //initialise the array
        $results = array();
        //get user info
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $userType = $this->Session->read('UserData.userType');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course = $course_info->course_name;
        //get form data
        $data = $this->request['data'];

        //get email
        $email = trim($data['email']);
        
        //check if email is valid
        if (empty($email)) {
        	echo "Email id is required.";
        	exit;
        }
       
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        	echo "Invalid email id";
        	exit;
        }

        //get twitter screen name
        $twitter_screen_name = $data['twitter_screen_name'];

        //get facebook userid.
        $facebook_user_name = $data['facebook_user_name'];

        //check for oduEmail
        $oduEmail = (empty($data['oduemail'])) ? 0 : 1;

        //check for RssFeed
        $feed = (empty($data['feed'])) ? 0 : 1;

        //check for facebook
        $facebook = (empty($data['facebook'])) ? 0 : 1;

        //check for twitter
        $twitter = (empty($data['twitter'])) ? 0 : 1;

        //get contentPageId
        $cPageId = $data['contentPageId'];

        //register user in twitter
        if ($twitter == 1) {
            if (trim($twitter_screen_name) != "") {
                $twt_resp = $this->mapTwitterUser($twitter_screen_name, $userName);
                if (!$twt_resp) {
                    echo "Twitter screen name is invalid.";
                    exit;
                }
            } else {
                echo "Twitter screen name is required.";
                exit;
            }
        } else {
            //unregister user from twitter
            $twt_resp = $this->unMapTwitterUser($twitter_screen_name, $userName);
            if (!$twt_resp) {
                echo "Twitter screen name is invalid.";
                exit;
            }
        }
        //register user in facebook setting table 
        if ($facebook == 1) {
            if (trim($facebook_user_name) != '') {
                //check for register user on facebook
                $fb_response = $this->mapFacebookUser($facebook_user_name, $userName);
                if (!$fb_response) {
                    echo "Facebook user name is Invalid.";
                    exit;
                }
            } else {
                echo "Facebook username is required.";
                exit;
            }
        } else {
            //check for register user on facebook
            $fb_response = $this->unMapFacebookUser($facebook_user_name, $userName);
            if (!$fb_response) {
                echo "Facebook user name is Invalid.";
                exit;
            }
        }

        $data['ReminderSetting']['user_name'] = $userName;
        $data['ReminderSetting']['user_type'] = $userType;
        $data['ReminderSetting']['content_page_id'] = $cPageId;
        $data['ReminderSetting']['section'] = $users_section;
        $data['ReminderSetting']['course'] = $users_course;
        $data['ReminderSetting']['is_email'] = $oduEmail;
        $data['ReminderSetting']['is_feed_reader'] = $feed;
        $data['ReminderSetting']['is_text_msg'] = '0';
        $data['ReminderSetting']['is_facebook'] = $facebook;
        $data['ReminderSetting']['is_twitter'] = $twitter;

        //set the data array for emailUser model
        $email_data['EmailUser']['midas_id'] = $userName;
        $email_data['EmailUser']['email'] = $email;
//         $email_data['EmailUser']['section'] = $users_section;
//         $email_data['EmailUser']['course'] = $users_course;

        //check if already saved
        //get setting count
        $resultsCount = $this->ReminderSetting->find('count', array('conditions' =>
            array('ReminderSetting.user_name' => $userName,
                'ReminderSetting.content_page_id' => $cPageId,
                'ReminderSetting.section' => $users_section,
                'ReminderSetting.course' => $users_course
        )));

        //if setting exist then it will update the row
        if ($resultsCount > 0) {
            $results = $this->ReminderSetting->find('first', array('conditions' =>
                array('ReminderSetting.user_name' => $userName,
                    'ReminderSetting.content_page_id' => $cPageId,
                    'ReminderSetting.section' => $users_section,
                    'ReminderSetting.course' => $users_course
            )));
            $data['ReminderSetting']['id'] = $results['ReminderSetting']['id'];
        }

        //saving the data in EmailUser
        //check if exist
        $email_result = $this->EmailUser->find('first', array('conditions' => array('EmailUser.midas_id' => $userName)));

        if (count($email_result) > 0) {
            //get inserted id
            $email_id = $email_result['EmailUser']['id'];
            $email_data['EmailUser']['id'] = $email_id;
        }

        //fire query
        $this->EmailUser->save($email_data);

        //saving the remider setting data
        $this->ReminderSetting->save($data);
        
        //saving the notification reminder setting logs
        $this->_saveNotificationReminderLogs($data);
        $this->Session->setFlash('Notifications setting saved successfully.');
        exit;
    }

    /**
     * register the user in twitter table
     * @param string $twitter_screen_name
     * @param string $userName
     * return string
     */
    public function mapTwitterUser($twitter_screen_name, $userName) {
        $twitter_id = $this->TwitterNotification->getTwitterIdFromScreenName($twitter_screen_name);
        if ($twitter_id != -1) {
            //check if already registerd
            $result = $this->TwitterUser->find('first', array('conditions' => array('TwitterUser.midasId' => $userName)));
            if (count($result) == 0) {
                //Save new record
                $data['TwitterUser']['midasId'] = $userName;
                $data['TwitterUser']['twitterId'] = $twitter_id;
                $data['TwitterUser']['twitterScreenName'] = $twitter_screen_name;
                $this->TwitterUser->save($data);
            } else {
                $data['TwitterUser']['id'] = $result['TwitterUser']['id'];
                $data['TwitterUser']['midasId'] = $userName;
                $data['TwitterUser']['twitterId'] = $twitter_id;
                $data['TwitterUser']['twitterScreenName'] = $twitter_screen_name;
                $this->TwitterUser->save($data);
            }
            return true;
        }
        return false;
    }

    /**
     * Unregister the user in twitter table
     * @param string $twitter_screen_name
     * @param string $userName
     * return string
     */
    public function unMapTwitterUser($twitter_screen_name, $userName) {
        $twitter_id = 0;
        $twitter_screen_name = trim($twitter_screen_name);

        //check if twitter screen name is not empty
        if (!empty($twitter_screen_name)) {
            $twitter_id = $this->TwitterNotification->getTwitterIdFromScreenName($twitter_screen_name);
        }

        //if user is correct
        if ($twitter_id != -1) {
            //check if already registerd
            $result = $this->TwitterUser->find('first', array('conditions' => array('TwitterUser.midasId' => $userName)));
            if (count($result) == 0) {
                //Save new record
                $data['TwitterUser']['midasId'] = $userName;
                $data['TwitterUser']['twitterId'] = $twitter_id;
                $data['TwitterUser']['twitterScreenName'] = $twitter_screen_name;
                $this->TwitterUser->save($data);
            } else {
                $data['TwitterUser']['id'] = $result['TwitterUser']['id'];
                $data['TwitterUser']['midasId'] = $userName;
                $data['TwitterUser']['twitterId'] = $twitter_id;
                $data['TwitterUser']['twitterScreenName'] = $twitter_screen_name;
                $this->TwitterUser->save($data);
            }
            return true;
        }
        return false;
    }

    /**
     * Checking the user is a real facebook user.
     * @param string $facebook_user_name
     * @param string $userName
     * @return 
     */
    public function mapFacebookUser($facebook_user_name, $userName) {
        $facebook_user_id = $this->FacebookNotification->getFacebookIdFromUserName($facebook_user_name);
        if ($facebook_user_id) {
            //check if already registerd
            $result = $this->FacebookUser->find('first', array('conditions' => array('FacebookUser.midas_id' => $userName)));
            $data = array();
            if (count($result) == 0) {
                $data['midas_id'] = $userName;
                $data['facebook_id'] = $facebook_user_id;
                $data['facebook_username'] = $facebook_user_name;
                $this->FacebookUser->save($data);
            } else {
                $this->FacebookUser->id = $result['FacebookUser']['id'];
                $data['midas_id'] = $userName;
                $data['facebook_id'] = $facebook_user_id;
                $data['facebook_username'] = $facebook_user_name;
                $this->FacebookUser->save($data);
            }
            return true;
        }
        return false;
    }

    /**
     * Unregister the user in facebook table
     * @param string $facebook_user_name
     * @param string $userName
     * return string
     */
    public function unMapFacebookUser($facebook_user_name, $userName) {
        $facebook_user_id = -1;
        $facebook_user_name = trim($facebook_user_name);

        //check if twitter screen name is not empty
        if (!empty($facebook_user_name)) {
            $facebook_user_id = $this->FacebookNotification->getFacebookIdFromUserName($facebook_user_name);
        }
        if ($facebook_user_id || $facebook_user_id == -1) {
            if ($facebook_user_id == -1)
                $facebook_user_id = 0;
            //check if already registerd
            $result = $this->FacebookUser->find('first', array('conditions' => array('FacebookUser.midas_id' => $userName)));
            $data = array();
            if (count($result) == 0) {
                $data['midas_id'] = $userName;
                $data['facebook_id'] = $facebook_user_id;
                $data['facebook_username'] = $facebook_user_name;
                $this->FacebookUser->save($data);
            } else {
                $this->FacebookUser->id = $result['FacebookUser']['id'];
                $data['midas_id'] = $userName;
                $data['facebook_id'] = $facebook_user_id;
                $data['facebook_username'] = $facebook_user_name;
                $this->FacebookUser->save($data);
            }
            return true;
        }
        return false;
    }

    /**
     * Get the reminder Setting
     * @params varchar contentPageId
     * @return array
     */
    public function getReminderSetting($contentPageId = null) {
        //get user info
        $results = array();
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        //get setting
        $options['conditions'][] = array('ReminderSetting.user_name' => $userName,
            'ReminderSetting.content_page_id' => $contentPageId,
            'ReminderSetting.section' => $course_info->section_name,
            'ReminderSetting.course' => $course_info->course_name
        );
        $options['fields'] = array('ReminderSetting.*', 'UsermapEmail.email', 'UsermapTwitter.twitterScreenName');

        //join the table with ple_user_map_email.
        $options['joins'][] = array(
            'table' => 'ple_user_map_email',
            'alias' => 'UsermapEmail',
            'type' => 'INNER',
            'conditions' => array(
                'ReminderSetting.user_name = UsermapEmail.midas_id'
            )
        );

        //join the table with ple_user_map_twitter.
        $options['joins'][] = array(
            'table' => 'ple_user_map_twitter',
            'alias' => 'UsermapTwitter',
            'type' => 'INNER',
            'conditions' => array(
                'ReminderSetting.user_name = UsermapTwitter.midasId'
            )
        );
        $results = $this->ReminderSetting->find('first', $options);

        return $results;
    }

    /**
     * Get Content pages list
     * @param null
     * @return array
     */
    public function getContentPages() {
        //get current login users info
        //get user session data
        $user = $this->Session->read('UserData.userName');
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $get_pages = $this->ContentPageSetting->find('all', array(
            'conditions' => array('ContentPageSetting.course' => $course_info->course_name, 'ContentPageSetting.section' => $course_info->section_name)
        ));
        return $get_pages;
    }

    /**
     * get section based on all section setting and if content page lie in that date
     * @param contentPageId
     * @return array
     */
    public function __allSections($contentPageId = null) {
        $resultList = array();
        $result_list_not_exist = array();
        $results_exits = array();
        $sectionList = array();
        //current user course
        //$contentPageId = 'topic1';
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $sections = $this->PleForumSetting->find('all', array('conditions' => array('PleForumSetting.course' => $course_info->course_name, 'PleForumSetting.setting_value' => 2, 'PleForumSetting.contentpage_id' => $contentPageId), 'fields' => array('course', 'section')));
        foreach ($sections as $section) {
            $sectionList[] = trim($section['PleForumSetting']['course']) . '-' . trim($section['PleForumSetting']['section']);
        }
        //add current user login section
        $sectionList[] = $user_course_section;
        $tzs = array_unique($sectionList);
        
        //START
        //check if record exists
        $results_exits = $this->PleForumAvailability->find('list', array('conditions' =>array(
        		'PleForumAvailability.course_id' => $tzs,
        		'PleForumAvailability.uuid' => $contentPageId,
        		'PleForumAvailability.type' => 'contentpage'
        ),
        		'fields'=>array('PleForumAvailability.course_id')));
        
        //get the cours_id whose setting is not set
        $result_not_extsts = array_diff($tzs, $results_exits);
        
        //get section list of  content page for which setting is not set.
        foreach($result_not_extsts as $result_not_extst) {
        	$course_not_exist = explode('-', trim($result_not_extst));//@TODO need to work
        	$result_list_not_exist[] = $course_not_exist[1]; //get section name
        }
        //END
        
        
        //get current time
        $ctime = date('Y-m-d H:i:s');
        //get sections on the basis of content page date setting
        $results = $this->PleForumAvailability->find('all', array('conditions' =>
            array(
                'PleForumAvailability.course_id' => $tzs,
                'PleForumAvailability.uuid' => $contentPageId,
            	'PleForumAvailability.type' => 'contentpage',
                //'PleForumAvailability.post_begin_date <=' => $ctime,
                'PleForumAvailability.post_end_date >=' => $ctime,
            	array('OR'=>array('PleForumAvailability.post_begin_date <='=>$ctime, 'PleForumAvailability.post_begin_date ='=>NULL))
        )));
        foreach ($results as $result) {
            $alter_course = explode('-', trim($result['PleForumAvailability']['course_id']));
            $resultList[] = $alter_course[1];
        }
        
        //merge the result with not exist section for which setting is not set
        $result_list_updated = array_merge($resultList, $result_list_not_exist);
        
        //HANDLING OF DUPLICACY..
        $tyzs = array_unique($result_list_updated);
        return $tyzs;
    }

    /**
     * Get Content Read page data
     * @param int content_page_id
     * @return array
     */
    public function getReadContentPage($content_page_id) {
        //get current login users info
        //get user session data
        $user = $this->Session->read('UserData.userName');
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $get_page = $this->ReadonlySetting->find('first', array(
            'conditions' => array('ReadonlySetting.course' => $course_info->course_name, 'ReadonlySetting.section' => $course_info->section_name, 'ReadonlySetting.contentpage_id' => $content_page_id)
        ));
        return $get_page;
    }

    /**
     * Finding the content pages of topics
     * @param string
     * @return array
     */
    public function getContentPagesFromTopics($topic_id) {
        $content_pages_result = $this->ContentTopic->find('all', array('conditions' => array('ContentTopic.topic_name' => $topic_id)));
        return $content_pages_result;
    }

    /**
     * Finding the Post/Reply date setting
     * @param contentpage
     * @return array
     */
    public function getPostReplyContentPage($content_page) {
        //get current login users info
        //get user session data
        $user = $this->Session->read('UserData.userName');
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $get_pages = $this->ContentPageSetting->find('all', array(
            'conditions' => array('ContentPageSetting.course' => $course_info->course_name, 'ContentPageSetting.section' => $course_info->section_name, 'ContentPageSetting.contentpage_id' => $content_page)
        ));
        return $get_pages;
    }

    /**
     * set assignment reminder
     */
    public function setAssignmentReminder() {
        //get user info
        $results = array();
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course = $course_info->course_name;
        $this->layout = 'dashboard';
        $this->loadModel('PleAssignment');

        //module loaded first
        $results = $this->PleAssignment->find('all', array('conditions' => array('PleAssignment.course_id LIKE ' => $users_course."[-]%"),
            'fields' => array('DISTINCT PleAssignment.module_uuid', 'PleAssignment.module_title'),
            //'group' => array('PleAssignment.module_uuid')
        ));
		$this->set('course', $users_course);
        $this->set('modules', $results);
    }

    /**
     * get the assignments list from the pleserver
     * @param int $module_id
     * @return array
     */
    public function getAssignemnts($module_id) {
        //get user info
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course = $course_info->course_name;

        $this->loadModel('PleAssignment');
        //get assignments list
        $results = $this->PleAssignment->find('all', array('conditions' => array('PleAssignment.course_id LIKE ' => $users_course."[-]%", 'PleAssignment.module_uuid' => $module_id)));
		return $results;
    }

    /**
     * Save assignment reminder setting
     */
    public function saveAssignmentReminder() {
        //get user info
        $userName = $this->Session->read('UserData.userName');

        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course  = $course_info->course_name;

        //get form data
        $datas = $this->request['data'];
       
        //get global setting for student, instructor, both
        //$assgmt_group_setting = $datas['forum_option_setting'];

        $ctime = date('Y-m-d');
        foreach ($datas['infos'] as $data) {
            //get field value
        
            $this->PleAssignmentReminder->create();
           
            $fields['PleAssignmentReminder']['id'] = $data['id'];
            $fields['PleAssignmentReminder']['course_id'] = $user_course_section;
            $fields['PleAssignmentReminder']['assignment_uuid'] = $data['assignment_id'];
            $fields['PleAssignmentReminder']['user_id'] = $userName;
            $fields['PleAssignmentReminder']['assignment_title'] = $data['assignment_title'];
            $fields['PleAssignmentReminder']['due_date'] = $data['assignment_date'];
            $fields['PleAssignmentReminder']['remind_week_before'] = $data['weekbefore'];
            $fields['PleAssignmentReminder']['remind_day_before'] = $data['daybefore'];
            $fields['PleAssignmentReminder']['remind_day_of'] = $data['duedate'];
            
            $fields['PleAssignmentReminder']['remind_custom_date'] = "";
            if (!empty($data['setdate'])) {
            	
            	$new_date = strtotime($data['setdate']);
            	$ctime1 = date('Y-m-d',$new_date);
            	
                $fields['PleAssignmentReminder']['remind_custom_date'] = $ctime1;
            }

            //save the data in instructor assignment setting table
            $result = $this->PleAssignmentReminder->save($fields);
            unset($fields['PleAssignmentReminder']);
        }
        //generate the logs
        $this->__assignmentSettingLog();
		
        $this->Session->setFlash('Assignment setting saved successfully.');
        $this->redirect(array('controller' => 'dashboards', 'action' => 'setAssignmentReminder'));
    }

     /**
     * load the assignment setting on the page load
     * @param int $aid
     * @param int $mid
     * @return array
     */
    public function loadAssignmentSetting($aid) 
    {
        //get user info
        $userName = $this->Session->read('UserData.userName');

        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course  = $course_info->course_name;

        $result = $this->PleAssignmentReminder->find('first', array('conditions' => array('assignment_uuid' => $aid, 'course_id LIKE'=>$course_info->course_name.'[-]%', 'user_id' => $userName)));

        //check if result exist
        if (count($result) > 0) {
            $resp['due_date'] = $result['PleAssignmentReminder']['remind_day_of'];
            $resp['day_before'] = $result['PleAssignmentReminder']['remind_day_before'];
            $resp['week_before'] = $result['PleAssignmentReminder']['remind_week_before'];
            $resp['on_date'] = ( $result['PleAssignmentReminder']['remind_custom_date'] != 0 ) ? date('m/d/y', strtotime($result['PleAssignmentReminder']['remind_custom_date'])) : '';
            $resp['id'] = $result['PleAssignmentReminder']['id'];
           // $resp['setting_type'] = $result['PleAssignmentReminder']['setting_type'];
        } else {
            $resp['due_date'] = 0;
            $resp['day_before'] = 0;
            $resp['week_before'] = 0;
            $resp['id'] = 0;
            $resp['on_date'] = '';
            //$resp['setting_type'] = 0;
        }
        
        return $resp;
    }

    /**
     * set assignment reminder for student
     */
    public function setStudentAssignmentReminder() {
        //get user info
        $results = array();
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course  = $course_info->course_name;
        $this->layout = 'dashboard';
        $this->loadModel('PleAssignment');

        //module loaded first
        $results = $this->PleAssignment->find('all', array('conditions' => array('PleAssignment.course' => $users_course),
            'fields' => array('module'),
            'group' => array('PleAssignment.module')
        ));
        $this->set('modules', $results);
    }

    /**
     * load the assignment setting on the page load
     * @param int $aid
     * @param int $mid
     * @return array
     */
    public function loadStudentAssignmentSetting($aid, $mid) {
        //get user info
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course = $course_info->course_name;

        $result = $this->StudentAssignmentSetting->find('first', array('conditions' => array('aid' => $aid, 'mid' => $mid, 'course' => $users_course, 'midas_id' => $userName)));

        //check if result exist
        if (count($result) > 0) {
            $resp['due_date'] = $result['StudentAssignmentSetting']['due_date'];
            $resp['day_before'] = $result['StudentAssignmentSetting']['day_before'];
            $resp['week_before'] = $result['StudentAssignmentSetting']['week_before'];
            $resp['on_date'] = ( $result['StudentAssignmentSetting']['on_date'] != 0 ) ? date('m/d/y', $result['StudentAssignmentSetting']['on_date']) : '';
            $resp['id'] = $result['StudentAssignmentSetting']['id'];
        } else {
            $resp['due_date'] = 0;
            $resp['day_before'] = 0;
            $resp['week_before'] = 0;
            $resp['id'] = 0;
            $resp['on_date'] = '';
        }
        return $resp;
    }

    /**
     * Save student assignment reminder setting
     */
    public function saveStudentAssignmentReminder() {
        //get user info
        $userName = $this->Session->read('UserData.userName');

        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);
        $users_section = $course_info->section_name;
        $users_course = $course_info->course_name;

        //get form data
        $datas = $this->request['data'];
        foreach ($datas['infos'] as $data) {
            //get field value
            $this->StudentAssignmentSetting->create();
            $fields['StudentAssignmentSetting']['id'] = $data['id'];
            $fields['StudentAssignmentSetting']['aid'] = $data['assignment_id'];
            $fields['StudentAssignmentSetting']['mid'] = $data['module_id'];
            $fields['StudentAssignmentSetting']['midas_id'] = $userName;
            $fields['StudentAssignmentSetting']['course'] = $users_course;
            $fields['StudentAssignmentSetting']['section'] = $users_section;
            $fields['StudentAssignmentSetting']['due_date'] = $data['duedate'];
            $fields['StudentAssignmentSetting']['day_before'] = $data['daybefore'];
            $fields['StudentAssignmentSetting']['week_before'] = $data['weekbefore'];
            $fields['StudentAssignmentSetting']['on_date'] = 0;
            if (!empty($data['setdate'])) {
                $fields['StudentAssignmentSetting']['on_date'] = strtotime($data['setdate']);
            }

            //save the data in instructor assignment setting table
            $result = $this->StudentAssignmentSetting->save($fields);
        }

        $this->Session->setFlash('Assignment setting saved successfully.');
        $this->redirect(array('controller' => 'dashboards', 'action' => 'setStudentAssignmentReminder'));
    }

    /**
     * Finding the posts of most active forum
     * @param none
     * @return array
     */
    private function _mostActiveForumPosts($content_page_id)
    {

        $user = $this->Session->read('UserData.userName');
        $course = $this->Session->read('UserData.usersCourses'); // is an array..
        
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($course[0]);
       
        //get allsection setting sections for same course
        $sections_list = $this->__allSections($content_page_id);

        //finding the limit for showing the unread posts
        $whats_new_setting = $this->getWhatsNewSetting($content_page_id);
        $limit = $whats_new_setting['WhatsNewSetting']['count'];
        if (!$limit)
            $limit = 4;

        $options['conditions'][] = array('Forum.user_coursename' =>$course_info->course_name, 'Forum.user_sectionname' => $sections_list);

        $options['recursive'] = -1;
        $options['fields'] = array('Forum.question_id as ids');
        $options['order']  = array('count(Forum.question_id) desc');
        $options['group']  = array('Forum.question_id');
        $postdata = $this->Forum->find('all', $options);
        $question_ids = array();
        foreach ($postdata as $post_id) {
            if ($post_id[0]['ids'])
                $question_ids[] = $post_id[0]['ids'];
        }

        $content_page_ids = array();
        $i = 0;
        //finding the content page id from question ids
        foreach ($question_ids as $qid) {
            if ($i == $limit)
                break;
            $forum_data = $this->Forum->find('first', array('conditions' => array('Forum.id' => $qid),
                'fields' => array('contentpage_id'), 'recursive' => '-1'));
            if (isset($forum_data['Forum']['contentpage_id']))
            $content_page_ids[] = $forum_data['Forum']['contentpage_id'];
        }
        $unique_content_pages = array_unique($content_page_ids);
        return $unique_content_pages;
    }

    /**
     * Finding the most recent posts
     * @params none
     * @return array
     */
    public function forumPosts($content_page_id) {
        $user = $this->Session->read('UserData.userName');
        $course = $this->Session->read('UserData.usersCourses'); // is an array..
        
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($course[0]);

        //get allsection setting sections for same course
        $sections_list = $this->__allSections($content_page_id);

        $options['conditions'][] = array('Forum.user_coursename' => $course_info->course_name, 'Forum.user_sectionname' => $sections_list);
        $postoptions['recursive'] = 0;
        $postoptions['conditions'][] = array('Forum.user_coursename' => $course_info->course_name, 'Forum.user_sectionname' => $sections_list, 'Forum.is_draft' => 1);
        $accessoptions['conditions'][] = array('AccessQuestion.user_id' => $user, 'AccessQuestion.course_name' => $course_info->course_name, 'AccessQuestion.section_name' => $sections_list, 'AccessQuestion.is_read' => 1);
        $postoptions['fields'] = array('Forum.id');

        //finding the limit for showing the unread posts
        $whats_new_setting = $this->getWhatsNewSetting($content_page_id);
        $limit = $whats_new_setting['WhatsNewSetting']['count'];
        if (!$limit)
            $limit = 4;
        //finding the read post ids by the current user.
        $accessoptions['order'] = array('AccessQuestion.question_id' => 'asc');
        $access_posts_ids = $this->AccessQuestion->find('all', $accessoptions);
        $access_question_ids = array();
        foreach ($access_posts_ids as $access_postids_data) {
            $access_question_ids[] = $access_postids_data['AccessQuestion']['question_id'];
        }
        //finding the posts id those are draft and draft by the not logged user..
        $posts_ids = $this->Forum->find('all', $postoptions);
        $question_ids = array();
        foreach ($posts_ids as $postids_data) {
            $question_ids[] = $postids_data['Forum']['id'];
        }
        $options['recursive'] = 0;
        $options['conditions'][] = array('NOT' => array('Forum.id' => $question_ids)); // handling for those are draft by any user..
        $options['conditions'][] = array('NOT' => array('Forum.id' => $access_question_ids)); // handling for those are read by the current user..
        $options['order'] = array('Forum.id' => 'desc');
        $options['limit'] = $limit;
        $post_data = $this->Forum->find('all', $options);
        return $post_data;
    }

    /**
     * Finding the whats new setting
     * @params content_page_id
     * @return array
     */
    public function getWhatsNewSetting($content_page_id) {
        $userName = $this->Session->read('UserData.userName');
        //get the user course name.
        $userCourse = $this->Session->read('UserData.usersCourses');
        $user_course_section = $userCourse[0];
        
        //get Course and section name
        $course_info = $this->getCourseNameOfUser($user_course_section);

        $result = $this->WhatsNewSetting->find('first', array('conditions' => array('WhatsNewSetting.contentpage_id' => $content_page_id,
                'WhatsNewSetting.user_name' => $userName,
                'WhatsNewSetting.course_name' => $course_info->course_name,
                'WhatsNewSetting.section_name' => $course_info->section_name
        )));
        return $result;
    }

    /**
     * Saving the user data for email configuration
     * @param unknown_type $userData
     */
    private function _saveEmailConfiguration($userData) {
        $id = $this->EmailUser->find('count', array('conditions' => array('EmailUser.midas_id' => $userData['midasId'])));
        if (!$id) {
            $data = array();
            $data['midas_id'] = $userData['midasId'];
            $data['course'] = $userData['course'];
            $data['section'] = $userData['section'];
            $data['email'] = $userData['email'];
            $this->EmailUser->save($data);
        }
        return true;
    }

    /**
     * Check if logged in user is following the twitter PLE APP
     * @param none
     * @return int
     */
    public function checkTwitterFollowers() {
        //get user info
        $userName = $this->Session->read('UserData.userName');

        //get twitterId
        $result = $this->TwitterUser->find('first', array('conditions' => array('TwitterUser.midasId' => $userName)));
        $twitter_id = $result['TwitterUser']['twitterId'];

        //defing the object array..
        $pleFollowers = new stdClass();
        //get followers lists
        $pleFollowers = $this->TwitterNotification->getFollowers();

        //handling for the array key is defined.
        if (isset($pleFollowers->ids)) {
            if (in_array($twitter_id, $pleFollowers->ids))
                return 1;
        }
        return 0;
    }

    /**
     * Checking a user is authenticate the app
     */
    public function checkFacebookAuthentication() {
        //get user info
        $userName = $this->Session->read('UserData.userName');

        //get facebookId
        $result = $this->FacebookUser->find('first', array('conditions' => array('FacebookUser.midas_id' => $userName)));
        if (count($result)) {

            //get followers lists
            if ($result['FacebookUser']['facebook_id']) {
                $fb_id = $result['FacebookUser']['facebook_id'];
                $ple_follower = $this->FacebookNotification->getFacebookAuthenticInfo($fb_id);
                if ($ple_follower)
                    return 0; //user already authenticated PLE app by facebook
                else
                    return 1; //user didn't yet authenticate PLE app by facebook
            }
        }
        return 0; //its means user have not saved yet his facebook username..	
    }

    /**
     * Redirect the user to twitter login
     * @return void
     */
    public function twitterRedirect() {
        $api_url = $this->TwitterNotification->twitterRedirect();
        $this->redirect($api_url);
    }

    /**
     * Call back function from twitter
     */
    public function twitterCallBack() {
        //get user info
        $userName = $this->Session->read('UserData.userName');

        $users_info = $this->TwitterNotification->twitterCallBack();

        //get twitter userinfo
        $twitter_id = $users_info->id;
        $twitter_screen_name = $users_info->screen_name;
        $midas_id = $userName;

        if ($twitter_id != "") {
            //check if already registerd
            $result = $this->TwitterUser->find('first', array('conditions' => array('TwitterUser.midasId' => $userName)));
            if (count($result) == 0) {
                //Save new record
                $data['TwitterUser']['midasId'] = $userName;
                $data['TwitterUser']['twitterId'] = $twitter_id;
                $data['TwitterUser']['twitterScreenName'] = $twitter_screen_name;
                $this->TwitterUser->save($data);
            } else {
                $data['TwitterUser']['id'] = $result['TwitterUser']['id'];
                $data['TwitterUser']['midasId'] = $userName;
                $data['TwitterUser']['twitterId'] = $twitter_id;
                $data['TwitterUser']['twitterScreenName'] = $twitter_screen_name;
                $this->TwitterUser->save($data);
            }
        }
        echo "<script type=\"text/javascript\">window.close();window.opener.location.reload(false);</script>";
        exit();
    }

    /**
     * Facebook redirect function
     * @param none
     * @return none
     */
    public function facebookRedirect() {
        $fb_api_url = $this->FacebookNotification->facebookRedirect();
        $this->redirect($fb_api_url);
    }

    /**
     * Facebook call back function for saving the new information in our db
     * @param string
     * @return none
     */
    public function facebookCallBack($fb_code) {
        //get user info
        $userName = $this->Session->read('UserData.userName');
        $facebook_info = $this->FacebookNotification->facebookCallBack($fb_code);
        if ($facebook_info['facebook_id']) {
            $result = $this->FacebookUser->find('first', array('conditions' => array('FacebookUser.midas_id' => $userName)));
            $data = array();
            if (count($result) == 0) {
                $data['midas_id'] = $userName;
                $data['facebook_id'] = $facebook_info['facebook_id'];
                $data['facebook_username'] = $facebook_info['facebook_username'];
                $this->FacebookUser->save($data);
            } else {
                $this->FacebookUser->id = $result['FacebookUser']['id'];
                $data['midas_id'] = $userName;
                $data['facebook_id'] = $facebook_info['facebook_id'];
                $data['facebook_username'] = $facebook_info['facebook_username'];
                $this->FacebookUser->save($data);
            }
        }
        //refresh the parent window and close the poup window.
        echo "<script type=\"text/javascript\">
                function refreshParent() {
                        window.opener.location.reload(); 
                        window.close();
                  }refreshParent();
		        </script>";
        exit();
    }

    /**
     * Closing the popup window and refresh the child window.
     * @param none
     * @return none
     */
    private function _facebookErrorReport() {
        //refresh the parent window and close the poup window.
        echo "<script type=\"text/javascript\">
		   function refreshParentCloseChild() {
		         window.opener.location.reload();
		         window.close();
		         }refreshParentCloseChild();
		   </script>";
        exit();
    }

    /**
     * Finding the facebook user info
     * @param none
     * @return Array
     */
    public function getFacebookUserInfo() {
        //get user info
        $userName = $this->Session->read('UserData.userName');
        //get facebookId
        $result = $this->FacebookUser->find('first', array('conditions' => array('FacebookUser.midas_id' => $userName)));
        return $result;
    }
	
	 /**
	 * Get assignments for the course of loggged in user
	 * @NOTE For the day before reminder, We assume 24 Hrs before of due date time.
	 * 
	 * @param  void
	 * @return array
	 */
	public function getAssignments()
	{
		$user = $this->Session->read('UserData.userName');
		
		//get user course detail
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		
		//get course info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		//finding the assignment criteria for day before, week before, custom date.
		$assignment_crieteria = $this->getAssignmentConstraints();
	
		$options['limit'] = 10;
		$options['conditions'][] = array('PleAssignmentReminder.user_id' => $user);
		$options['conditions'][] = array('PleAssignmentReminder.course_id LIKE'=>$course_info->course_name.'[-]%'); //check for course name
		$options['conditions'][] = $assignment_crieteria;
		$options['fields'] = array('id', 'assignment_uuid', 'assignment_title', 'due_date');
		
		$options['order'] = array('PleAssignmentReminder.id desc');
        
		
		$this->Paginator->settings = $options;
		$assignmnet_detail = $this->Paginator->paginate('PleAssignmentReminder');
	
		return $assignmnet_detail;

	}

	/**
	 * Finding the contentpage stucture
	 * @param none
	 * @return array
	 */
	public function getContentPageStructure()
	{
		//getting the user info from  session
		$user = $this->Session->read('UserData.userName');
		
		//get user course detail
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		
		//get course info
		$course_info = $this->getCourseNameOfUser($course[0]);
	//	$options['conditions'][] = array('ContentPageStructure.course_id'=> $course[0]); //check for course name
	    //ODU will save the content page structure for a course thats why we are using the LIKE operator eg.(2014_test-section1)
		$options['conditions'][] = array('ContentPageStructure.course_id LIKE ' => $course_info->course_name."[-]%");
	//	$options['order'] = array('ContentPageStructure.content_page_uuid'=> 'desc');
		$results = $this->ContentPageStructure->find('all', $options);
		$structure = array();
		$title = array();
		$final_array = array();
		foreach ($results as $result) {
			if ($result['ContentPageStructure']['module_uuid'] != '') {
				   if ($result['ContentPageStructure']['topic_uuid'] == '') {
				     $structure[$result['ContentPageStructure']['module_uuid']]['content_id'][] = $result['ContentPageStructure']['content_page_uuid'];
				   } else { 
				   	$structure[$result['ContentPageStructure']['module_uuid']][$result['ContentPageStructure']['topic_uuid']][] = $result['ContentPageStructure']['content_page_uuid'];
				   	$title['title'][$result['ContentPageStructure']['topic_uuid']] = $result['ContentPageStructure']['topic_title'];
				   }
				   $title['title'][$result['ContentPageStructure']['module_uuid']] = $result['ContentPageStructure']['module_title'];
			} else {
				$structure['content_id'][] = $result['ContentPageStructure']['content_page_uuid'];
			}
			
			$title['title'][$result['ContentPageStructure']['content_page_uuid']] = $result['ContentPageStructure']['content_page_title'];
			
		}
		$final_array['structure'] = $structure;
		$final_array['title'] = $title;
       return $final_array;
	}
	
	/**
	 * Set the Content page date setting
	 * @request data
	 * @params
	 */
	public function saveContentAvailability()
	{
		//getting the user info from  session
		$user = $this->Session->read('UserData.userName');
		
		//get user course detail
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		
		//get course info
		$course_info = $this->getCourseNameOfUser($course[0]);
		//$course_name = $course_info->course_name;
		$course_name = $course[0]; // here we saving the full course(course+section)
		$section_name = $course_info->section_name;
		$request_data = $this->request->data;
		$user_object = $request_data['user_object'];
		if ($this->request->data['clear-all'] == 'clear') {
			$this->_makeClearAllEntries($user_object, $course_name);
		}
		$current_date_extra_time = Configure::read('future_date_formated');
		$one_day_time = ((24*60*60)-1);
		unset($request_data['user_object']); //unset the user object from request array because we have not to save it with date setting.
		unset($request_data['save']);
		unset($request_data['clear-all']); // unset the clear-all from request array.
		foreach ($request_data as $key=>$date_setting) {
			if ($key != 'contentpage') {
				$data = array();
				$this->PleForumAvailability->create();
				$module_exists_id = $this->_checkModuleExists($course_name, $key);
				($module_exists_id >0 || $module_exists_id != '') ? ($this->PleForumAvailability->id = $module_exists_id) : '';
				if ($module_exists_id == 0 || $module_exists_id == '') {
					$data['post_begin_date'] = $data['reply_begin_date'] = $data['read_only_begin_date'] = '';
					$data['post_end_date'] = $data['reply_end_date']  = $data['read_only_end_date'] = $current_date_extra_time;
				}
				$data['course_id']            = $course_name;
				$data['uuid']                 = $key;
				$data['user_id']              = $user;
				$data['page_title']           = $date_setting['title'];
				if (($date_setting['poststartdate'] != $date_setting['poststartdate-hidden']) || ($date_setting['postenddate'] != $date_setting['postenddate-hidden'])) {
					$data['post_begin_date']      = (($date_setting['poststartdate'] != '') ? (date('Y-m-d', strtotime($date_setting['poststartdate']))) : '');
					$data['post_end_date']        = (($date_setting['postenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($date_setting['postenddate'])+($one_day_time))) : $current_date_extra_time);
				}
				if (($date_setting['replystartdate'] != $date_setting['replystartdate-hidden']) || ($date_setting['replyenddate'] != $date_setting['replyenddate-hidden'])) {
					$data['reply_begin_date']     = (($date_setting['replystartdate'] != '') ? (date('Y-m-d', strtotime($date_setting['replystartdate']))) : '');
					$data['reply_end_date']       = (($date_setting['replyenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($date_setting['replyenddate'])+($one_day_time))) : $current_date_extra_time);
				}
				if (($date_setting['readstartdate'] != $date_setting['readstartdate-hidden']) || ($date_setting['readenddate'] != $date_setting['readenddate-hidden'])) {
				$data['read_only_begin_date'] = (($date_setting['readstartdate'] != '') ? (date('Y-m-d', strtotime($date_setting['readstartdate']))) : '');
				$data['read_only_end_date']   = (($date_setting['readenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($date_setting['readenddate'])+($one_day_time))) : $current_date_extra_time);
				}

				$data['type']                 = 'module';
				$this->PleForumAvailability->save($data);
				
				//saving the same module data in child topic
				$this->_saveModuleDataToChild($course_name, $data, $key, $date_setting);
			} else {
				//saving course wide date setting of content pages
				foreach ($date_setting as $contentpage_uuid=>$course_wide_pages) {
					$this->PleForumAvailability->create();
					$content_page_data = array();
					$content_page_exists_id = $this->_checkContentPageExists($course_name, $contentpage_uuid);
					($content_page_exists_id >0 || $content_page_exists_id != '') ? ($this->PleForumAvailability->id = $content_page_exists_id) : '';
					if ($content_page_exists_id == 0 || $content_page_exists_id == '') {
						$content_page_data['post_begin_date'] = $content_page_data['reply_begin_date'] = $content_page_data['read_only_begin_date'] = '';
						$content_page_data['post_end_date'] = $content_page_data['reply_end_date'] = $content_page_data['read_only_end_date'] = $current_date_extra_time;
					}
					$content_page_data['course_id'] = $course_name;
					$content_page_data['uuid'] = $contentpage_uuid;
					$content_page_data['user_id'] = $user;
					$content_page_data['page_title'] = $course_wide_pages['title'];
					if (($course_wide_pages['poststartdate'] != $course_wide_pages['poststartdate-hidden']) || ($course_wide_pages['postenddate'] != $course_wide_pages['postenddate-hidden'])) {
						$content_page_data['post_begin_date'] = (($course_wide_pages['poststartdate'] != '') ? (date('Y-m-d', strtotime($course_wide_pages['poststartdate']))) : '');
						$content_page_data['post_end_date'] = (($course_wide_pages['postenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($course_wide_pages['postenddate'])+($one_day_time))) : $current_date_extra_time);
					}
					if (($course_wide_pages['replystartdate'] != $course_wide_pages['replystartdate-hidden']) || ($course_wide_pages['replyenddate'] != $course_wide_pages['replyenddate-hidden'])) {
						$content_page_data['reply_begin_date'] = (($course_wide_pages['replystartdate'] != '') ? (date('Y-m-d', strtotime($course_wide_pages['replystartdate']))) : '');
						$content_page_data['reply_end_date'] = (($course_wide_pages['replyenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($course_wide_pages['replyenddate'])+($one_day_time))) : $current_date_extra_time);
					}
					if (($course_wide_pages['readstartdate'] != $course_wide_pages['readstartdate-hidden']) || ($course_wide_pages['readenddate'] != $course_wide_pages['readenddate-hidden'])) {
						$content_page_data['read_only_begin_date'] = (($course_wide_pages['readstartdate'] != '') ? (date('Y-m-d', strtotime($course_wide_pages['readstartdate']))) : '');
						$content_page_data['read_only_end_date'] = (($course_wide_pages['readenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($course_wide_pages['readenddate'])+($one_day_time))) : $current_date_extra_time);
				    }
					$content_page_data['type'] = 'contentpage';
					$this->PleForumAvailability->save($content_page_data);
			    } 
		    }
	}
		$this->Session->setFlash('Ask a Question date setting saved successfully.');
		$this->redirect(array('controller' => 'dashboards', 'action' => 'home', 'askaquestion', $user_object));
   }	
	/**
	 * Saving the date setting data of a module into its children(topic/content page)
	 * @param array $data
	 * @param string $key
	 * @param array $date_setting
	 * @return boolean
	 */
	private function _saveModuleDataToChild($course_name, $data, $module_key, $date_setting)
	{
		$current_date_extra_time = Configure::read('future_date_formated');
		$one_day_time = ((24*60*60)-1);
		foreach ($date_setting as $child_key=>$module_child_array) {
			$this->PleForumAvailability->create();
			if ((is_array($module_child_array)) && ($child_key != 'contentpage')) {//save module data to topic id
				$topic_exists_id = $this->_checkTopicExists($course_name, $child_key); //checking if topic date setting is already saved
			    ($topic_exists_id >0 || $topic_exists_id != '') ? ($this->PleForumAvailability->id = $topic_exists_id) : '';
			    if ($topic_exists_id == 0 || $topic_exists_id == '') {
			    	$data['post_begin_date'] = $data['reply_begin_date'] = $data['read_only_begin_date'] = '';
			    	$data['post_end_date'] = $data['reply_end_date']  = $data['read_only_end_date'] = $current_date_extra_time;
			    }
			    $data['uuid'] = $child_key;
				$data['type'] = 'topic';
				$data['page_title'] = $module_child_array['title'];
				$this->PleForumAvailability->save($data);
				
				//saving module data to its topic content page
				$this->_saveModuleDataToContentPage($course_name, $module_child_array, $data);
				
				//saving topic data to its content page
				$this->_saveTopicDataAndToContentPage($course_name, $child_key, $module_child_array, $data);
			} else if ((is_array($module_child_array)) && ($child_key == 'contentpage')) { //save module data to direct content page under a module
				foreach ($module_child_array as $content_page_module_id=>$direct_content_page) {
					$this->PleForumAvailability->create();
					$content_page_exists_id = $this->_checkContentPageExists($course_name, $content_page_module_id);//checking if content page date setting is already saved
					($content_page_exists_id > 0 || $content_page_exists_id != '') ? ($this->PleForumAvailability->id = $content_page_exists_id) : '';
					if ($content_page_exists_id == 0 || $content_page_exists_id == '') {
						$data['post_begin_date'] = $data['reply_begin_date'] = $data['reply_end_date'] = '';
						$data['post_end_date'] = $data['reply_end_date']  = $data['read_only_end_date'] = $current_date_extra_time;
					}
					$data['uuid'] = $content_page_module_id;
					$data['type'] = 'contentpage';
					$data['page_title'] = $direct_content_page['title'];
					$this->PleForumAvailability->save($data);
					
					//saving the content page data those are directly under a module.
					$this->_contentPagedateSetting($course_name, $content_page_module_id, $this->PleForumAvailability->id, $direct_content_page, $data);
				}
			}
		}
		return true;
	}
	
	/**
	 * Saving the date setting data for content pages those are under module or topics
	 * @param string $course_name
	 * @param int $id
	 * @param array $direct_content_page
	 * @return boolean
	 */
	private function _contentPagedateSetting($course_name, $contentpage_uuid, $id, $direct_content_page, $data)
	{
		//getting the user info from  session
		$user = $this->Session->read('UserData.userName');
		$content_page_data['course_id']             =  $course_name;
		$content_page_data['uuid']                  =  $contentpage_uuid;
		$content_page_data['user_id']               =  $user;
		$content_page_data['page_title']            =  $direct_content_page['title'];
		$current_date_extra_time = Configure::read('future_date_formated');
		$one_day_time = ((24*60*60)-1);
			
		if (($direct_content_page['poststartdate'] != $direct_content_page['poststartdate-hidden']) || ($direct_content_page['postenddate'] != $direct_content_page['postenddate-hidden'])) {
			$content_page_data['post_begin_date']       =  (($direct_content_page['poststartdate'] != '') ? (date('Y-m-d', strtotime($direct_content_page['poststartdate']))) : '');
			$content_page_data['post_end_date']         =  (($direct_content_page['postenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($direct_content_page['postenddate'])+($one_day_time))) : $current_date_extra_time);
		}
		if (($direct_content_page['replystartdate'] != $direct_content_page['replystartdate-hidden']) || ($direct_content_page['replyenddate'] != $direct_content_page['replyenddate-hidden'])) {
			$content_page_data['reply_begin_date']      =  (($direct_content_page['replystartdate'] != '') ? (date('Y-m-d', strtotime($direct_content_page['replystartdate']))) : '');
			$content_page_data['reply_end_date']        =  (($direct_content_page['replyenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($direct_content_page['replyenddate'])+($one_day_time))) : $current_date_extra_time);
		}
		if (($direct_content_page['readstartdate'] != $direct_content_page['readstartdate-hidden']) || ($direct_content_page['readenddate'] != $direct_content_page['readenddate-hidden'])) {
			$content_page_data['read_only_begin_date']  =  (($direct_content_page['readstartdate'] != '') ? (date('Y-m-d', strtotime($direct_content_page['readstartdate']))) : '');
			$content_page_data['read_only_end_date']    =  (($direct_content_page['readenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($direct_content_page['readenddate'])+($one_day_time))) : $current_date_extra_time);
		}
		
		//new code edit
// 		if ($direct_content_page['poststartdate'] == '') {
// 			$content_page_data['post_begin_date']       = $data['post_begin_date'];
// 			$content_page_data['post_end_date']         = $data['post_end_date'];
// 		}
// 		if ($direct_content_page['replystartdate'] == '') {
// 			$content_page_data['reply_begin_date']      = $data['reply_begin_date'];
// 			$content_page_data['reply_end_date']        = $data['reply_end_date'];
// 		}
// 		if ($direct_content_page['readstartdate'] == '') {
// 			$content_page_data['read_only_begin_date']  = $data['read_only_begin_date'];
// 			$content_page_data['read_only_end_date']    = $data['read_only_end_date'];
// 		}
		//new code edit
		$content_page_data['type']                  =  'contentpage';
		$this->PleForumAvailability->id          =  $id;
		$this->PleForumAvailability->save($content_page_data);
		return true;
	}
	
	/**
	 * Saving the module data to content pages under topics
	 * @param string $course_name
	 * @param string $child_key
	 * @param array $module_child_array
	 * @param array $data
	 * @return boolean
	 */
	private function _saveModuleDataToContentPage($course_name, $module_child_array, $data)
	{
		$current_date_extra_time = Configure::read('future_date_formated');
		foreach ($module_child_array as $content_key=>$content_array) {
			if (is_array($content_array)) {
				$this->PleForumAvailability->create();
				$content_page_exists_id = $this->_checkContentPageExists($course_name, $content_key);//checking if content page date setting is already saved
				($content_page_exists_id > 0 || $content_page_exists_id != '') ? ($this->PleForumAvailability->id = $content_page_exists_id) : '';
				if ($content_page_exists_id == 0 || $content_page_exists_id == '') {
					$data['post_begin_date'] = $data['reply_begin_date'] = $data['read_only_begin_date'] = '';
					$data['post_end_date'] = $data['reply_end_date']  = $data['read_only_end_date'] = $current_date_extra_time;
				}
				$data['uuid'] = $content_key;
				$data['type'] = 'contentpage';
				$data['page_title'] = $content_array['title'];
				$this->PleForumAvailability->save($data);
		   }
		}
		return true;
	}

	/**
	 * Saving the date setting of topics to itself and its children(content page)
	 * @param string $course_name
	 * @param array $module_child_array
	 * @return boolean
	 */
	private function _saveTopicDataAndToContentPage($course_name, $topic_key, $topic_array, $data)
	{
		    $user = $this->Session->read('UserData.userName');
		    $one_day_time = ((24*60*60)-1);
		    $current_date_extra_time = Configure::read('future_date_formated');
		    $this->PleForumAvailability->create();
			$topic_exists_id = $this->_checkTopicExists($course_name, $topic_key); //checking if topic date setting is already saved
			($topic_exists_id >0 || $topic_exists_id != '') ? ($this->PleForumAvailability->id = $topic_exists_id) : '';
			$topic_data = array();
			if ($topic_exists_id == 0 || $topic_exists_id == '') {
				$topic_data['post_begin_date'] = $topic_data['reply_begin_date'] = $topic_data['read_only_begin_date'] = '';
				$topic_data['post_end_date'] = $topic_data['reply_end_date']  = $topic_data['read_only_end_date'] = $current_date_extra_time;
			}
			$topic_data['course_id']            = $course_name;
			$topic_data['uuid']                 = $topic_key;
			$topic_data['user_id']              = $user;
			$topic_data['page_title']           = $topic_array['title'];
			if (($topic_array['poststartdate'] != $topic_array['poststartdate-hidden']) || ($topic_array['postenddate'] != $topic_array['postenddate-hidden'])) {
				$topic_data['post_begin_date']      = (($topic_array['poststartdate'] != '') ? (date('Y-m-d', strtotime($topic_array['poststartdate']))) : '');
				$topic_data['post_end_date']        = (($topic_array['postenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($topic_array['postenddate'])+($one_day_time))) : $current_date_extra_time);
			}
			if (($topic_array['replystartdate'] != $topic_array['replystartdate-hidden']) || ($topic_array['replyenddate'] != $topic_array['replyenddate-hidden'])) {
				$topic_data['reply_begin_date']     = (($topic_array['replystartdate'] != '') ? (date('Y-m-d', strtotime($topic_array['replystartdate']))) : '');
				$topic_data['reply_end_date']       = (($topic_array['replyenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($topic_array['replyenddate'])+($one_day_time))) : $current_date_extra_time);
			}
			if (($topic_array['readstartdate'] != $topic_array['readstartdate-hidden']) || ($topic_array['readenddate'] != $topic_array['readenddate-hidden'])) {
				$topic_data['read_only_begin_date'] = (($topic_array['readstartdate'] != '') ? (date('Y-m-d', strtotime($topic_array['readstartdate']))) : '');
				$topic_data['read_only_end_date']   = (($topic_array['readenddate'] != '') ? (date('Y-m-d H:i:s', strtotime($topic_array['readenddate'])+($one_day_time))) : $current_date_extra_time);
			}
			//new code edit
// 			if ($topic_array['poststartdate'] == '') {
// 				$topic_data['post_begin_date']      = $data['post_begin_date'];
// 				$topic_data['post_end_date']        = $data['post_end_date'];
// 			}
// 			if ($topic_array['replystartdate'] == '') {
// 				$topic_data['reply_begin_date']     = $data['reply_begin_date'];
// 				$topic_data['reply_end_date']       = $data['reply_end_date'];
// 			}
// 			if ($topic_array['readstartdate'] == '') {
// 				$topic_data['read_only_begin_date'] = $data['read_only_begin_date'];
// 				$topic_data['read_only_end_date']   = $data['read_only_end_date'];
// 			}
			//new code edit end
			$topic_data['type']                 = 'topic';
			$this->PleForumAvailability->save($topic_data);
			if (is_array($topic_array)) {
			   	$this->_saveTopicDataToContentPage($course_name, $topic_array, $topic_data); //saving the topic date setting data to its content page
			}
			return true;
	}

	/**
	 * Saving the topic data to content pages under topics
	 * @param string $course_name
	 * @param string $topic_child_array
	 * @param array $data
	 * @return boolean
	 */
	private function _saveTopicDataToContentPage($course_name, $topic_child_array, $data)
	{
		$current_date_extra_time = Configure::read('future_date_formated');
		foreach ($topic_child_array as $content_key=>$content_array) {
			if (is_array($content_array)) {
				$this->PleForumAvailability->create();
				$content_page_exists_id = $this->_checkContentPageExists($course_name, $content_key); //checking if content page date setting is already saved
				($content_page_exists_id > 0 || $content_page_exists_id != '') ? ($this->PleForumAvailability->id = $content_page_exists_id) : '';
				if ($content_page_exists_id == 0 || $content_page_exists_id == '') {
					$data['post_begin_date'] = $data['reply_begin_date'] = $data['read_only_begin_date'] = '';
					$data['post_end_date'] = $data['reply_end_date']  = $data['read_only_end_date'] = $current_date_extra_time;
				}
				$data['uuid'] = $content_key;
				$data['type'] = 'contentpage';
				$data['page_title'] = $content_array['title'];
				$this->PleForumAvailability->save($data);
				
				//saving the content page data those are directly under a topic.
				$this->_contentPagedateSetting($course_name, $content_key, $this->PleForumAvailability->id, $content_array, $data);
			}
		}
		return true;
	}
	
	/**
	 * Checking if a topic entry is already exists
	 * @param string $course_name
	 * @param string $child_key
	 * @return int
	 */
	private function _checkTopicExists($course_name, $child_key)
	{
		$topic_result = $this->PleForumAvailability->find('first', array('conditions' => array('course_id' => $course_name, 'uuid' => $child_key, 'type' => 'topic')));
		if (isset($topic_result['PleForumAvailability']['id'])) {
			return $topic_result['PleForumAvailability']['id'];
		}
		return 0;
	}
	
	/**
	 * Checking if a module entry is already exists
	 * @param string $course_name
	 * @param string $key
	 * @return int
	 */
	private function _checkModuleExists($course_name, $module_uuid)
	{
		$result = $this->PleForumAvailability->find('first', array('conditions' => array('course_id' => $course_name, 'uuid' => $module_uuid, 'type' => 'module')));
		if (isset($result['PleForumAvailability']['id'])) {
			return $result['PleForumAvailability']['id'];
		}
		return 0;
	}
	
	/**
	 * Checking if a content page entry is already exists
	 * @param string $course_name
	 * @param string $contentpage_uuid
	 * @return int
	 */
	private function _checkContentPageExists($course_name, $contentpage_uuid)
	{
		$content_page_result = $this->PleForumAvailability->find('first', array('conditions' => array('course_id' => $course_name, 'uuid' => $contentpage_uuid, 'type' => 'contentpage')));
		if (isset($content_page_result['PleForumAvailability']['id'])) {
			return $content_page_result['PleForumAvailability']['id'];
		}
		return 0;
	}
	
	/**
	 * Finding the module/Topic/ContentPage date setting(generic function)
	 * @param string $uuid
	 * @return array
	 */
	public function getReadModuleTopicContentPagedateSetting($uuid, $type)
	{
		//getting the user info from  session
		$user = $this->Session->read('UserData.userName');
		
		//get user course detail
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		
		//get course info
		$course_info = $this->getCourseNameOfUser($course[0]);
		$course_name = $course_info->course_name;
		$section_name = $course_info->section_name;
		$result = $this->PleForumAvailability->find('first', array('conditions' => array('course_id' => $course[0], 'uuid' => $uuid, 'type' => $type)));
		$result_array = new stdClass(); //defining the object array
		//initialised the array varaibles
		$result_array->poststartdate = $result_array->postenddate = $result_array->replystartdate = $result_array->replyenddate = $result_array->readstartdate = $result_array->readenddate = '';
		
		if (isset($result['PleForumAvailability']['id'])) {
			$result_array->poststartdate    = ($result['PleForumAvailability']['post_begin_date'] != '') ? date('m/d/Y', strtotime($result['PleForumAvailability']['post_begin_date'])) : '';
			$result_array->postenddate      = date('m/d/Y', strtotime($result['PleForumAvailability']['post_end_date']));
			$result_array->replystartdate   = ($result['PleForumAvailability']['reply_begin_date'] != '') ? date('m/d/Y', strtotime($result['PleForumAvailability']['reply_begin_date'])) : '';
			$result_array->replyenddate     = date('m/d/Y', strtotime($result['PleForumAvailability']['reply_end_date']));
			$result_array->readstartdate    = ($result['PleForumAvailability']['read_only_begin_date'] != '') ? date('m/d/Y', strtotime($result['PleForumAvailability']['read_only_begin_date'])) : '';
			$result_array->readenddate      = date('m/d/Y', strtotime($result['PleForumAvailability']['read_only_end_date']));
		}
		return $result_array;
	}

	/**
	 * Making the forum avalibilty blank
	 * @param string $user_object
	 * @param string $course_name
	 * @return redirect to main screen 
	 */
	private function _makeClearAllEntries($user_object, $course_name)
	{
		$current_date_extra_time =Configure::read('future_date_formated');
		$new_date = strtotime($current_date_extra_time);
        $ctime = date('Y-m-d',$new_date);
		$this->PleForumAvailability->updateAll(array('PleForumAvailability.post_begin_date' => NULL, 'PleForumAvailability.post_end_date' => "'".$ctime."'", 'PleForumAvailability.reply_begin_date' => NULL, 'PleForumAvailability.reply_end_date' => "'".$ctime."'", 'PleForumAvailability.read_only_begin_date' => NULL, 'PleForumAvailability.read_only_end_date' => "'".$ctime."'"),
				array('PleForumAvailability.course_id' => $course_name));
		$this->Session->setFlash('Ask a Question date setting saved successfully.');
		$this->redirect(array('controller' => 'dashboards', 'action' => 'home', 'askaquestion', $user_object));
	}
	
	/**
	 * saving the logs for active forum/post setting
	 * @param array $data_test
	 * @return int
	 */
	private function _saveActiveSettingLogs($data_test)
	{
		$data = array();
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
		
		//get Course and section name
		$course_info     = $this->getCourseNameOfUser($course_name_explode);
		$course_name     = $course_info->course_name;
		$course_section  = $course_info->section_name;
		//getting session info
		$session_info  = $this->getSessionNameOfUser($course_name_explode);
		$session_name  = $session_info->session_name;
		
		//prepare the data to be saved.
		$data['DashboardActiveSettingLogs']['midas_id']        = $user;
		$data['DashboardActiveSettingLogs']['time']            = time();
		$data['DashboardActiveSettingLogs']['course']          = $course_name;
		$data['DashboardActiveSettingLogs']['section']         = $course_section;
		$data['DashboardActiveSettingLogs']['session']         = $session_name;
		if ( $data_test['WhatsNewSetting']['view_name'] == 'activepagesforum')
		   $data['DashboardActiveSettingLogs']['type']         = 1; // 1 for activepagesforum
		else
		   $data['DashboardActiveSettingLogs']['type']         = 0; // 0 for activeposts

		$this->DashboardActiveSettingLogs->save($data);
		return true;
	}
	
	/**
	 * saving the logs for active notification reminder setting
	 * @param array $data_test
	 * @return int
	 */
	private function _saveNotificationReminderLogs($data)
	{
		$data = array();
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
		
		//get Course and section name
		$course_info     = $this->getCourseNameOfUser($course_name_explode);
		$course_name     = $course_info->course_name;
		$course_section  = $course_info->section_name;
		//getting session info
		$session_info  = $this->getSessionNameOfUser($course_name_explode);
		$session_name  = $session_info->session_name;
		
		//prepare the data to be saved.
		$data['DashboardNotificationReminderSettingLogs']['midas_id']        = $user;
		$data['DashboardNotificationReminderSettingLogs']['time']            = time();
		$data['DashboardNotificationReminderSettingLogs']['course']          = $course_name;
		$data['DashboardNotificationReminderSettingLogs']['section']         = $course_section;
		$data['DashboardNotificationReminderSettingLogs']['session']         = $session_name;
		$this->DashboardNotificationReminderSettingLogs->save($data);
		return true;
	}
	
	
	/**
	 * Create the assignment setting log
	 */
	private function __assignmentSettingLog()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$section_name = $course_info->section_name;
		
		//get session name
		$session_info = $this->getSessionNameOfUser($course_name_explode);
		$session_name = $session_info->session_name;
		
		$this->AssignmentReminderLog->create();
		//create data array
		$data['AssignmentReminderLog']['midas_id'] = $user;
		$data['AssignmentReminderLog']['time'] = time(); //current time
		$data['AssignmentReminderLog']['course'] = $course_name;
		$data['AssignmentReminderLog']['section'] = $section_name;
		$data['AssignmentReminderLog']['session'] = $session_name;
		$log_err = $this->AssignmentReminderLog->save($data);
	}
	
	/**
	 * Create the online setting log
	 */
	private function __communitySettingLog($type)
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$section_name = $course_info->section_name;
		
		//get session name
		$session_info = $this->getSessionNameOfUser($course_name_explode);
		$session_name = $session_info->session_name;
		
		$this->OnlineSettingLog->create();
		//create data array
		$data['OnlineSettingLog']['midas_id'] = $user;
		$data['OnlineSettingLog']['time'] = time(); //current time
		$data['OnlineSettingLog']['course'] = $course_name;
		$data['OnlineSettingLog']['section'] = $section_name;
		$data['OnlineSettingLog']['session'] = $session_name;
		$data['OnlineSettingLog']['type'] = $type;
		$log_err = $this->OnlineSettingLog->save($data);
	}
	
}
?>