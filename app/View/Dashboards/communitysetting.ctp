<?php
$username = $this->Session->read('UserData.userName');
//get content page
$data_decode = json_decode($ruserobj);
$contentPageId = $data_decode->contentPageId;
//initilises the variables
$emailValCheck = '';
$feedValCheck = '';
$facebookValCheck = '';
$twitValCheck = '';
?>
<div class="user_welcome">
	<?php //echo "Hello ". ucfirst($username); ?>
</div>
<!-- Message area starts here -->
<div id="loader" class='errmsg'>
       <img src="<?php echo $this->webroot;?>img/loader.gif">
     </div>
  <div id="loadererr" class='errmsg message'>
     </div>   
 <!-- Message area ends here --> 
<!-- Code started by Abhishek Gupta -->
<?php 
//get userType
$userType = "Instructor";
?>
<div class="community-setting-wrapper">
<!-- Code start for Who's online setting-->
<div class="online-settings">
<h3>Community Settings</h3>
<span class="course-name"><?php echo 'Course - '.ucfirst($course);?></span>
	<ul id="acc5" class="accordion accordian-common-forum-setting">
		<li>
<!--    <span class="aske-question-general">Who is Online</span> -->
			<h4 class="h"><a class="trigger open" href="#">Who is Online Settings</a></h4>
			 <div class="outer shown" style="display:block;">
			   <div class="inner">
						<?php 
						//get current setting value
						$cOnlineSetting = $this->requestAction(array('controller'=>'dashboards','action'=>'getOnlineSetting'));
						if ($cOnlineSetting == 0)
							$cOnlineSetting = 1;
						
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
						<!-- div for showing the success message -->
						<div id="online-msg"></div>
				</div>
			 </div>
		</li>
	</ul>
</div>
<!-- Code start for Forum setting here -->
<div class="forum-settings">

	<ul id="acc4" class="accordion accordian-common">
		<li>
<!-- 		<span class="aske-question-general">Ask A Question General</span> -->
			<h4 class="h"><a class="trigger" href="#">Ask A Question Settings</a></h4>
			 <div class="outer">
			   <div class="inner">

					<?php
				    //get current setting value
				    $cForumSetting = $this->requestAction(array('controller'=>'dashboards','action'=>'getForumSetting'),array('pass' => array($contentPageId)));
				    if ($cForumSetting == 0)
				    	$cForumSetting = 1;
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
						
						echo $this->Form->input('content_page_id', array('type'=>'hidden', 'value' => $contentPageId, 'name' => 'content_page_id'));
						?>
					</ul>
					<?php echo $this->form->submit('Save', array('class'=> 'gobutton'));
					echo $this->form->end();
					?>
					<!-- div for showing the success message -->
					<div id="forum-msg"></div>
				</div>
			</div>
		</li>
	</ul>
</div>
<!-- Code end for Forum setting here -->


<div class='backButton'>
<a class="gobutton_outer" href='javascript:history.go(-1)' >Done</a>
</div>
</div>
<!-- Code end for Who's online setting-->
<?php
//ajax code forum available setting
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
 
 // ajax code start who's online setting
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
  
?>
