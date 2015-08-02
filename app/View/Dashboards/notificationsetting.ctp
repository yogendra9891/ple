<?php
echo $this->Html->script('notificationsetting', array('inline' => false)); //including the js for notification..
$username = $this->Session->read('UserData.userName');
//get content page
$data_decode = json_decode($ruserobj);
$contentPageId = $data_decode->contentPageId;
//initialied the variable
$emailValCheck = '';
$feedValCheck = '';
$facebookValCheck = '';
$twitValCheck = '';
?>
<div class="user_welcome">
<?php
//echo "Hello ". ucfirst($username);
?>
</div>

<!-- Code started by Abhishek Gupta -->
<?php 
//check if following the ple
$is_follower = $this->requestAction(array('controller' =>'dashboards', 'action' => 'checkTwitterFollowers'));
?>
<!-- Message area starts here -->
<div id="loader" class='errmsg'>
       <img src="<?php echo $this->webroot;?>img/loader.gif">
     </div>
  <div id="loadererr" class='errmsg message'>
     </div>   
 <!-- Message area ends here -->  
<!-- Code start for assignment/new posts reminder setting-->
<div class="reminder-settings">
<h3>Notifications Settings</h3>
<span class="course-name"><?php echo 'Course - '.ucfirst($course);?></span>
<?php echo $this->Form->create('dashboards',array('action'=>'reminderSetting','id'=>'rsetting'));?>
   <ul id="acc6" class="accordion accordian-common-commonsetting">
      <li>
         <h4 class="h"><a class="trigger open" href="#">Check to Enable Notification Methods</a></h4>
            <div class="outer shown" style="display: block;">
               <div class="inner">
						<ul>
							<?php 
								//get current setting value
								$cReminderSetting = $this->requestAction('dashboards/getReminderSetting/'.$contentPageId);
						
								if (count($cReminderSetting)>0) {
								    //get feed seeting
							    	$emailValCheck = ($cReminderSetting['ReminderSetting']['is_email'] == 1) ? 'checked="checked"' : '';
								
								    //get Email seeting
								    $feedValCheck = ($cReminderSetting['ReminderSetting']['is_feed_reader'] == 1) ? 'checked="checked"' : '';
								
								    //get Email seeting
								    $facebookValCheck = ($cReminderSetting['ReminderSetting']['is_facebook'] == 1) ? 'checked="checked"' : '';
								
								    //get Email seeting
								    $twitValCheck = ($cReminderSetting['ReminderSetting']['is_twitter'] == 1) ? 'checked="checked"' : '';
								}
							
							   //odu email area starts 
							    echo "<li>";
								echo "<div id='oduemail'>";
							    echo $this->Form->input('Email',
										array(
												'value' => '0',
												'name' => 'oduemail',
												'id' => 'oduemail2',
												'type'=>'checkbox',
												'label'=>false,
												'legend' => false,
												'hiddenField' => false,
												'class' =>'email-notif',
												 $emailValCheck
										));
							    echo $this->Form->input('Email', array('type'=>'text', 'div' =>array('class' =>'emailclass-inner', 'id'=>'emailclass-inner'), 'value'=>$cReminderSetting["UsermapEmail"]["email"], 'name'=>'email', 'id'=>'notf-email', 'class' =>'inputs'));
								echo "<div class=\"email-notify-message\">Enter email address to be used for notifications.</div>";
									
							    echo "</div><div id='oduemail_disable'>";
							    echo $this->Form->input('Email',
							    		array(
							    				'value' => '0',
							    				'name' => 'oduemail',
							    				'id' => '',
							    				'type'=>'checkbox',
							    				'legend' => false,
							    				'hiddenField' => false,
							    				'disabled' =>'disabled',
							    				$emailValCheck
							    		));
							    echo "<div class=\"user-email-email-setting\">(".$cReminderSetting['UsermapEmail']['email'].")</div>";
							    echo '<a href="#" id="oduemail_link" class="reminder_link" onClick="enableOption(\'oduemail_disable\', \'oduemail\', \'oduemail_link\');" title="edit">Edit</a>';
							    echo "</div>";
							   
							    echo "</li><li>";
							    //odu email area ends
							    
							    //twitters starts here
							    echo "<div id='twitters'>";
							    echo $this->Form->input('Twitter',
							    		array(
							    				'value' => '0',
							    				'name' => 'twitter',
							    				'id' => 'twitter',
							    				'type'=>'checkbox',
							    				'legend' => false,
							    				'label' => false,
							    				'hiddenField' => false,
							    				'class' =>'email-notif',
							    				$twitValCheck
							    		));
							    echo $this->Form->input('Twitter ScreenName', array('type'=>'text', 'div' =>array('class' =>'twtclass twt-inner'), 'value'=>$cReminderSetting["UsermapTwitter"]["twitterScreenName"], 'name'=>'twitter_screen_name', 'id'=>'notf-twitter', 'class' =>'inputs'));
							    $content = '<div class="twtclass"> Or <a href="#" id ="twitter-login" ><img src="'.$this->webroot.'/img/twitter.png" alt="Sign in with Twitter"/></a></div>';
							    echo $content;
							    echo "<div class=\"twitter-notify-message\">Enter Twitter handle OR login for notifications.</div>";
							   
							   
							    if ( $is_follower == 0 )  {
							    	echo '<div class="twt-follow twtclass"><span>Please follow the PLE, to get twitter notification. &nbsp;&nbsp;&nbsp;&nbsp;</span><a href="https://twitter.com/abhithinker" class="twitter-follow-button" data-show-count="false" data-lang="en">Follow @twitterapi</a></div>';
							    }
							    
							    echo "</div><div id='twitter_disable'>";
							    echo $this->Form->input('Twitter',
							    		array(
							    				'value' => '0',
							    				'name' => 'twitter',
							    				'id' => 'twitter',
							    				'type'=>'checkbox',
							    				'legend' => false,
							    				'hiddenField' => false,
							    				'disabled' =>'disabled',
							    				$twitValCheck
							    		));
							    echo "<div class=\"user-twitter-twitter-setting\">(".$cReminderSetting["UsermapTwitter"]["twitterScreenName"].")</div>";
							    echo '<a href="#" id="twitters_link" class="reminder_link" onClick="enableOption(\'twitter_disable\', \'twitters\', \'twitters_link\');" title="edit">Edit</a>';
							    echo "</div>";
							    
							    echo "</li><li>";
							    //twitter ends
							    
							    //facebook starts here
							    echo "<div id='facebooks'>";
							    echo $this->Form->input('Facebook',
							    		array(
							    				'value' => '0',
							    				'name' => 'facebook',
							    				'id' => 'facebook',
							    				'type'=>'checkbox',
							    				'legend' => false,
							    				'hiddenField' => false,
							    				'label' => false,
							    				'class' =>'email-notif',
							    				$facebookValCheck
							    		));
							    $fb_user_info = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getFacebookUserInfo'));
							    echo $this->Form->input('Facebook Username', array('type'=>'text', 'div' =>array('class' =>'fbclass twt-inner'), 'value'=>$fb_user_info['FacebookUser']['facebook_username'], 'class'=>'inputs', 'name'=>'facebook_user_name', 'id'=>'notf-facebook'));
							    $fb_content = '<div class="fbclass"> Or <a href="#" id ="facebook-login" ><img src="'.$this->webroot.'/img/facebook.png" alt="Sign in with Facebook"/></a></div>';
							    echo $fb_content;
							    echo "<div class=\"facebook-notify-message\">Enter Facebook username OR login for notifications.</div>";
							    
							    $check_fb_athentication = $this->requestAction(array('controller'=>'dashboards', 'action'=>'checkFacebookAuthentication'));
							    if ($check_fb_athentication) {
							    	?>
							    <div class="fb-authen">
							    <span>Please follow the PLE, to get Facebook notification. &nbsp;&nbsp;&nbsp;&nbsp;</span>
							    <div class="fb-login-button" data-max-rows="1" data-size="medium" data-show-faces="false" data-auto-logout-link="false" onlogin="refreshParentWindow()">Authenticate</div>
							    </div>
							    <?php }
							    echo "</div><div id='facebook_disable'>";
							    echo $this->Form->input('Facebook',
							    array(
							    'value' => '0',
							    'name' => 'facebook',
							    'id' => 'facebook',
							    'type'=>'checkbox',
							    'legend' => false,
							    'hiddenField' => false,
							    'disabled' =>'disabled',
							    $facebookValCheck
							    ));
							    echo "<div class=\"user-facebook-facebook-setting\">(".$fb_user_info['FacebookUser']['facebook_username'].")</div>";
							    echo '<a href="#" id="facebooks_link" class="reminder_link" onClick="enableOption(\'facebook_disable\', \'facebooks\', \'facebooks_link\');" title="edit">Edit</a>';
							    echo "</div>";
							    
							   
							    echo "</li><li>";
							    //facebook ends
							    							    							    
							    //feedreader starts here
							    echo "<div id='feedreader'>";
								echo $this->Form->input('Feed reader Posts',
										array(
												'value' => '0',
												'name' => 'feed',
												'id' => 'feed',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												'class' => 'feed_notf',
												 $feedValCheck
										));
								echo "</div><div id='feedreader_disable'>";
								echo $this->Form->input('Feed reader posts',
										array(
												'value' => '0',
												'name' => 'feed',
												'id' => '',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												'disabled' =>'disabled',
												'class' => 'feed_notf',
												$feedValCheck
										));
								
								//creating the feed link start for a user.
								$userName = $this->Session->read('UserData.userName');
								
								//get the user course name.
								$userCourse = $this->Session->read('UserData.usersCourses');
								$user_course_section = $userCourse[0];
								
								//get Course and section name
								$course_info = $this->requestAction(array('controller'=>'dashboards','action'=>'getCourseNameOfUser', $user_course_section));
								$course_name = $course_info->course_name;
								$course_section = $course_info->section_name;
																
								//defined in bootstrap
								$feed_count = Configure::read('feed_count');
								$site_url = Configure::read('site_url');
								$link = $site_url.'/posts/index/'.$feed_count.'/'.$course_name.'/.rss';
								echo "<div id=\"feed-reader-label\">(".$link.")</div>";
								echo "</div>";
								echo "<div class=\"feed-notify-message\" id=\"feed-notify-message\">Use this url in to your Feed reader for your notifications.</div>";
								//creating the feed link end for a user.
								echo $this->Form->input('RSS Feed Reader Posts', array('type'=>'text', 'div' =>array('class' =>'feedclass-inner', 'id'=>'feed-reader'), 'value'=>$link, 'class'=>'inputs', 'name'=>'feed_reader', 'id'=>'notf-feed-reader'));
								echo '<div class="feedclass"><a href="javascript:void(0);" id="feedreader_link" class="reminder_link" title="copy">Copy</a></div>';
								echo "</li><li>";
								
								//feedreader starts here
								echo "<div id='feedreader-assignment'>";
								echo "</div><div id='feedreader_assignment_disable'>";
								echo $this->Form->input('Feed reader assignment',
										array(
												'value' => '0',
												'name' => 'feed-assignment',
												'id' => '',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												'disabled' =>'disabled',
												'class' => 'feed_notf',
												$feedValCheck
										));
								
								$assignment_feed_link = $site_url.'/posts/assignmentReminder/'.$course_name.'/'.$userName.'/.rss';
								echo "<div id=\"feed-reader-assignment-label\">(".$assignment_feed_link.")</div>";
								
								echo "</div>";
								echo "<div class=\"feed-notify-message\" id=\"feed-notify-message\">Use this url in to your Feed reader for your notifications.</div>";
								//creating the feed link end for a user.
								echo $this->Form->input('RSS Feed Reader Assignments', array('type'=>'text', 'div' =>array('class' =>'feedclass-inner', 'id'=>'feed-reader-assignment'), 'value'=>$assignment_feed_link, 'class'=>'inputs', 'name'=>'feed_reader_asignments', 'id'=>'notf-feed-reader-assignments'));
								echo '<div class="feedclass"><a href="javascript:void(0);" id="feedreader_link_assignments" class="reminder_link" title="copy">Copy</a></div>';
								
								echo "</li>";
								//feedreader ends here
  							 ?>
							</ul>
							
							<!-- twitter follow button -->
							
								<?php 
							
									echo $this->Form->input('contentPageId',array('type'=>'hidden','value'=>$contentPageId,'name'=>'contentPageId'));
								?>
					<div id="reminder-msg"></div>
				</div>
			</div>
		</li>
	</ul>
	
<!-- button -->	
<div class='backButton'>
   <?php 
   echo $this->form->submit('Save', array('class'=> 'gobutton_outer'));
   echo $this->form->end();
   ?>
   <a class='gobutton_outer' href='javascript:history.go(-1)' >Done</a>
</div>
</div>

<!-- Code end for assignment reminder setting-->
<?php
  
// start reminder setting
  $data = $this->Js->get('#rsetting')->serializeForm(array('isForm' => true, 'inline' => true));
  $this->Js->get('#rsetting')->event(
  		'submit',
  		$this->Js->request(
  				array('action' => 'reminderSetting', 'controller' => 'dashboards'),
  				array(
  						//'update' => '#reminder-msg',
  						'data' => $data,
  						'async' => true,
  						'dataExpression'=>true,
  						'method' => 'POST',
  						'before'=>'before("#reminder-msg")',
  						//'complete'=>'complete("#reminder-msg")'
						'success'=>'twitterComplete(data, "#reminder-msg")'
  				)
  		)
  );
  echo $this->Js->writeBuffer();
  //end of reminder setting
?>
