<?php
$username = $this->Session->read('UserData.userName');
//get content page
$data_decode = json_decode($ruserobj);
$contentPageId = $data_decode->contentPageId;
//initilises the variable
$emailValCheck = '';
$feedValCheck = '';
$facebookValCheck = '';
$twitValCheck = '';
?>
<div class="user_welcome">
<?php
echo "Hello ". ucfirst($username);
?>
</div>

<!-- Code started by Abhishek Gupta -->
<?php 
//get userType
$userType = "Instructor";
?>
<!-- Code start for Forum setting here -->
<div class="forum-settings">
	<ul id="acc4" class="accordion accordian-common">
		<li>
			<h4 class="h"><a class="trigger" href="#">Forum Setting</a></h4>
			 <div class="outer">
			   <div class="inner">

					<?php
				    //get current setting value
				    $cForumSetting = $this->requestAction(array('controller'=>'dashboards','action'=>'getForumSetting'));
				    if($cForumSetting==0){
				    	$cForumSetting = 1;
				    }
				   
					echo $this->Form->create('dashboards',array('action'=>'forumSetting','id'=>'fsetting'));?>
					<ul>
						<?php 
						$options =  array('1'=>'Enable in-section forums','2'=>'Allow all sections access','3'=>'Disable forums');
						echo $this->Form->input('Forum Setting', array('name'=>'forum_setting',
								'value'=>$cForumSetting,
								'type' => 'radio',
								'legend' => false,
								'separator'=> '</li><li>',
								'before' => '<li>',
								'after' => '</li>',
								'options' => $options
						));
						?>
					</ul>
					<?php echo $this->form->submit('Save', array('class'=> 'gobutton'));
					echo $this->form->end();
					?>
					<div id="forum-msg"></div>
				</div>
			</div>
		</li>
	</ul>
</div>
<!-- Code end for Forum setting here -->

<!-- code start for unread posts -->
<div id="w-ques-post" class="posts-lists">
	<ul id="acc2" class="accordion accordian-common">
		<li>
			<h4 class="h"><a class="trigger" href="#">Recent Forum Posts</a></h4>
			 <div class="outer">
			   <div class="inner">
					<?php
					$options =  array('4'=>'4', '5'=>'5','6'=>'6', '7'=>'7');
						
					echo $this->Form->create('dashboards', array('id'=>'unreadposts', 'action'=>'forumPosts'));
					echo $this->Form->input('unread_post', array('options' => $options, 'type'=>'select', 'label' => 'No. of Unread Forum Posts'));
					echo $this->Form->end();
					?>
					<ul id="comments">
						<?php
						if(count($posts)):
						foreach($posts as $post): ?>
							<li class="unread-postlink" id="<?php echo 'qid_'.$post['Forum']['id'];?>">
								<span class="postlink-rep"><?php 
								echo $this->Html->link(substr(ucfirst($post['Forum']['post_subject']), 0,40).'..', array('controller'=>'forums','action'=>'replyQuestion', $post['Forum']['id'], $post['Forum']['contentpage_id']));?>
								</span>
							</li>
						<?php endforeach;
						else: ?>
						<li>
						 <span class="found-post">No post found</span>
						</li>
						<?php endif;
						?>
					</ul>
       		   </div>
	    	</div>
		</li>
	</ul>
</div>

<!-- code end for unread posts -->

<div class="assignment-area">
            <ul id="acc3" class="accordion accordian-common">
                    <li>
                        <h4 class="h"><a class="trigger" href="#">Assignments</a></h4>
                        <div class="outer">
                          <div class="inner">
						   Assignments Coming soon..
						  </div>
						</div>
					</li>
			</ul>
</div>

<div class='contentpage_list'>
<?php 
  $contentPages = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getContentPages'));
  if ( count($contentPages) ) {
?>

            <ul id="acc1" class="accordion accordian-common">
                    <li>
                        <h4 class="h"><a class="trigger" href="#">Module 1</a></h4>
                        <div class="outer"><div class="inner">
                          <ul>
                          <?php foreach ($contentPages as $content_pages) { 
                          	$contentReadPage = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getReadContentPage'.'/'.$content_pages['ContentPageSetting']['contentpage_id']));
                          ?>
                            <li>
                              <h5 class="h"><a class="trigger" href="#"><?php echo $content_pages['ContentPageSetting']['contentpage_id'];?></a></h5>
                              <div style="display: block;" class="outer"><div class="inner">
                             <?php
	                              $start_date = $content_pages['ContentPageSetting']['start_date'];
	                              $end_date = $content_pages['ContentPageSetting']['end_date'];
	                              $rstart_date = $content_pages['ContentPageSetting']['rstart_date'];
	                              $rend_date = $content_pages['ContentPageSetting']['rend_date'];
	                              
	                              $start_dateval = ($start_date == '0' ? '' : date('m/d/Y', $start_date)); // returns true                              
	                              $end_dateval = (($end_date == '2020426106' || $end_date == '0') ? '' : date('m/d/Y', $end_date)); // returns true
	 
	                              $rstart_dateval = ($rstart_date == '0' ? '' : date('m/d/Y', $rstart_date)); // returns true
	                              $rend_dateval = (($rend_date == '2020426106' || $rend_date == '0') ? '' : date('m/d/Y', $rend_date)); // returns true
	
	                              //read access data
	                              $read_start_date = $contentReadPage['ReadonlySetting']['start_date'];
	                              $read_end_date = $contentReadPage['ReadonlySetting']['end_date'];
	                              
	                              $read_start_dateval = ($read_start_date == '0' ? '' : date('m/d/Y', $read_start_date)); // returns true
	                              $read_end_dateval = (($read_end_date == '2020426106' || $read_end_date == '0') ? '' : date('m/d/Y', $read_end_date)); // returns true
	                              
	                              echo $this->Form->create('dashboards',array('action'=>'saveContentAvailability', 'class'=> 'contentsavesetting', 'id'=> 'savecontent_'.$content_pages['ContentPageSetting']['contentpage_id']));
                              ?>
                               <div class="post_available_area">
                               <fieldset>
                               <legend>Post Access</legend>
	                              <?php 
							          echo $this->Form->input('Start Date', array('name'=>'start_date','div'=>'st-date', 'value'=>$start_dateval, 'label' => 'Start Date', 'class'=>'datefield clearable', 'id' => 'datepicker1_'.$content_pages['ContentPageSetting']['contentpage_id'], 'readonly'=>'readonly'));
		                              echo $this->Form->input('End Date', array('name'=>'end_date','div'=>'end-date', 'value'=>$end_dateval, 'label' => 'End Date', 'class'=>'datefield clearable', 'id' => 'datepicker_'.$content_pages['ContentPageSetting']['contentpage_id'], 'readonly'=>'readonly'));
	                              ?>
	                              </fieldset>
                              </div>
                              <div class="reply_available_area">
                              <fieldset>
                               <legend>Reply Access</legend>
	                              <?php
							          echo $this->Form->input('Reply Start Date', array('name'=>'rstart_date','div'=>'rst-date', 'value'=>$rstart_dateval, 'label' => 'Start Date', 'class'=>'datefield clearable', 'id' => 'rdatepicker1_'.$content_pages['ContentPageSetting']['contentpage_id'], 'readonly'=>'readonly'));
							          echo $this->Form->input('Reply End Date', array('name'=>'rend_date','div'=>'rend-date', 'value'=>$rend_dateval, 'label' => 'End Date', 'class'=>'datefield clearable', 'id' => 'rdatepicker_'.$content_pages['ContentPageSetting']['contentpage_id'], 'readonly'=>'readonly'));
	                              ?>
	                              </fieldset>
                              </div>
                              
                              <div class="read_available_area">
                              <fieldset>
                               <legend>Read Only Access</legend>
                              <?php
						          echo $this->Form->input('Read Start Date', array('name'=>'read_start_date','div'=>'rrst-date', 'value'=>$read_start_dateval, 'label' => 'Start Date', 'class'=>'datefield clearable', 'id' => 'readdatepicker1_'.$content_pages['ContentPageSetting']['contentpage_id'], 'readonly'=>'readonly'));
	                              echo $this->Form->input('Read End Date', array('name'=>'read_end_date','div'=>'rrend-date', 'value'=>$read_end_dateval, 'label' => 'End Date', 'class'=>'datefield clearable', 'id' => 'readdatepicker_'.$content_pages['ContentPageSetting']['contentpage_id'], 'readonly'=>'readonly'));
                              ?>
                             </fieldset>
                              </div>                              
                              <?php 
                              echo $this->Form->input('Content Page ID',  array('type'=>'hidden', 'name'=>'content_page_id', 'value'=>$content_pages['ContentPageSetting']['contentpage_id']));
                              echo $this->Form->submit('Save', array('class'=> 'gobutton'));
                              echo $this->Form->end();
                              ?>
                              <div id="<?php echo 'messagecontent_'.$content_pages['ContentPageSetting']['contentpage_id']; ?>"></div>
                              </div></div>
                            </li>
                             <?php 
                             //code start for content page id date setting
                             $data = $this->Js->get('#savecontent_'.$content_pages['ContentPageSetting']['contentpage_id'])->serializeForm(array('isForm' => true, 'inline' => true));
                             $ar = '#messagecontent_'.$content_pages['ContentPageSetting']['contentpage_id'];
                             $this->Js->get('#savecontent_'.$content_pages['ContentPageSetting']['contentpage_id'])->event(
                             		'submit',
                             		$this->Js->request(
                             				array('action' => 'saveContentAvailability', 'controller' => 'dashboards'),
                             				array(
                             						'update' => '#messagecontent_'.$content_pages['ContentPageSetting']['contentpage_id'],
                             						'data' => $data,
                             						'async' => true,
                             						'dataExpression'=>true,
                             						'method' => 'POST',
                             						'before'=>'beforeSaveDate("'.$content_pages['ContentPageSetting']['contentpage_id'].'")'
                             						)
                             				)
                             		
                             );
                             echo $this->Js->writeBuffer();
                             
                             //code end for content page id date setting
							} ?>
                          </ul>
                        </div></div>
                      </li>
                    </ul> <!-- end accordion 1 -->
   
</div>
<?php 
  }
 $unread_form_data = $this->Js->get('#unreadposts')->serializeForm(array('isForm' => true, 'inline' => true));
 //Ajax call for showing the no of unread posts.
 $this->Js->get('#dashboardsUnreadPost')->event(
   'change',
   $this->Js->request(
     array('action' => 'forumPosts', 'controller' => 'dashboards'),
     array(
       'update' => '#comments',
       'data' => $unread_form_data,
       'async' => true,    
       'dataExpression'=>true,
       'method' => 'POST'
     )
   )
 );
 echo $this->Js->writeBuffer();                                                 
?>

<!-- Code start for Who's online setting-->
<div class="online-settings">
	<ul id="acc5" class="accordion accordian-common">
		<li>
			<h4 class="h"><a class="trigger" href="#">Who's Online Setting</a></h4>
			 <div class="outer">
			   <div class="inner">
						<?php 
						//get current setting value
						$cOnlineSetting = $this->requestAction(array('controller'=>'dashboards','action'=>'getOnlineSetting'));
						if($cOnlineSetting==0){
							$cOnlineSetting = 1;
						}
						
						echo $this->Form->create('dashboards',array('action'=>'onlineSetting','id'=>'osetting'));?>
						<ul>
							<?php 
							$options =  array('1'=>'Enable in-section only','2'=>'Enable all sections','3'=>'Disable');
							echo $this->Form->input('Who\'s Online Setting', array('name'=>'online_setting',
									'value'=>$cOnlineSetting,
									'type' => 'radio',
									'legend' => false,
									'separator'=> '</li><li>',
									'before' => '<li>',
									'after' => '</li>',
									'options' => $options
							));
							?>
						</ul>
						<?php echo $this->form->submit('Save', array('class'=> 'gobutton'));
						echo $this->form->end();
						?>
						<div id="online-msg"></div>
				</div>
			 </div>
		</li>
	</ul>
</div>
<!-- Code end for Who's online setting-->

<!-- Code start for assignment reminder setting-->
<div class="reminder-settings">
            <ul id="acc6" class="accordion accordian-common">
                    <li>
                        <h4 class="h"><a class="trigger" href="#">My Reminders</a></h4>
                        <div class="outer">
                          <div class="inner">

							<?php echo $this->Form->create('dashboards',array('action'=>'reminderSetting','id'=>'rsetting'));?>
							<ul>
						   
								<?php 
								//get current setting value
								$cReminderSetting = $this->requestAction('dashboards/getReminderSetting/'.$contentPageId);
						
								if(count($cReminderSetting)>0){
								//get feed seeting
								$emailValCheck = ($cReminderSetting['ReminderSetting']['is_email'] == 1) ? 'checked="checked"' : '';
								
								//get Email seeting
								$feedValCheck = ($cReminderSetting['ReminderSetting']['is_feed_reader'] == 1) ? 'checked="checked"' : '';
								
								//get Email seeting
								$facebookValCheck = ($cReminderSetting['ReminderSetting']['is_facebook'] == 1) ? 'checked="checked"' : '';
								
								//get Email seeting
								$twitValCheck = ($cReminderSetting['ReminderSetting']['is_twitter'] == 1) ? 'checked="checked"' : '';
								} 
							
							    echo $this->Form->input('ODU email',
										array(
												'value' => '',
												'name' => 'oduemail',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												 $emailValCheck
										));
								echo $this->Form->input('Feed reader',
										array(
												'value' => '',
												'name' => 'feed',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												$feedValCheck
										));
								echo $this->Form->input('Facebook',
										array(
												'value' => '',
												'name' => 'facebook',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												$facebookValCheck
										));
								echo $this->Form->input('Twitter',
										array(
												'value' => '',
												'name' => 'twitter',
												'type'=>'checkbox',
												'legend' => false,
												'hiddenField' => false,
												$twitValCheck
										))
											
										?>
									</ul>
									<?php 
										echo $this->Form->input('contentPageId',array('type'=>'hidden','value'=>$contentPageId,'name'=>'contentPageId'));
										echo $this->form->submit('Save', array('class'=> 'gobutton'));
										echo $this->form->end();
										?>
										<div id="reminder-msg"></div>
								</div>
							</div>
						</li>
					</ul>
</div>
<!-- Code end for assignment reminder setting-->

<?php
//for forum setting
$data = $this->Js->get('#fsetting')->serializeForm(array('isForm' => true, 'inline' => true));
  $this->Js->get('#fsetting')->event(
    'submit',
    $this->Js->request(
      array('action' => 'forumSetting', 'controller' => 'dashboards'),
      array(
        'update' => '#forum-msg',
        'data' => $data,
        'async' => true,    
        'dataExpression'=>true,
        'method' => 'POST',
      	'before'=>'before("#forum-msg")',
      	'complete'=>'complete("#forum-msg")'
      )
    )
  );
  echo $this->Js->writeBuffer();        

 //end of forum setting
 
 // start online setting
  $data = $this->Js->get('#osetting')->serializeForm(array('isForm' => true, 'inline' => true));
  $this->Js->get('#osetting')->event(
  		'submit',
  		$this->Js->request(
  				array('action' => 'onlineSetting', 'controller' => 'dashboards'),
  				array(
  						'update' => '#online-msg',
  						'data' => $data,
  						'async' => true,
  						'dataExpression'=>true,
  						'method' => 'POST',
  						'before'=>'before("#online-msg")',
  						'complete'=>'complete("#online-msg")'
  				)
  		)
  );
  echo $this->Js->writeBuffer();
  //end of online setting
  
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
  						'complete'=>'complete("#reminder-msg")'
  				)
  		)
  );
  echo $this->Js->writeBuffer();
  //end of reminder setting
?>
