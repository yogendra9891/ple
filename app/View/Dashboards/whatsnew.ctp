<?php
$username = $this->Session->read('UserData.userName');
$userType = $this->Session->read('UserData.userType');
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
//echo "Hello ". ucfirst($username);
$whats_new_setting =  $this->requestAction(array('controller'=>'dashboards','action'=>'getWhatsNewSetting', $content_page_id));
$view_value = $whats_new_setting['WhatsNewSetting']['view_name'];
$count = $whats_new_setting['WhatsNewSetting']['count'];
?>
</div>

<?php
//get userType
//$userType = "Instructor";
?>
<div class="wrapper-whatsnew">
<!-- code start for unread posts -->
<?php echo $this->Form->create('dashboards', array('id'=>'unreadposts', 'action'=>'forumPostsPagesSetting', $content_page_id));
?>
<div id="w-ques-post" class="posts-lists">

 <h3>What's New</h3>
	<ul id="acc2" class="accordion accordian-common-commonsetting">
	<li><span class="course-name">
	<?php echo 'Course - '. ucfirst($course);?></span>
	</li>
		<li>
<!-- 		    <span class="ask-question-whatsnew">Ask a Question Posts</span> -->
			<h4 class="h"><a class="trigger open" href="#">Recent Questions & Replies</a></h4>
			 <div class="outer shown" style="display:block;">
			   <div class="inner">
			   <div class="selectbox" id="posts-selectbox">
				<?php
					$options =  array('4'=>'4', '5'=>'5','6'=>'6', '7'=>'7');
					echo $this->Form->input('count', array('class'=>'uread', 'options' => $options, 'type'=>'select', 'label' => 'Items', 'value'=>$count));
					echo $this->Form->input('content_page_id', array('type'=>'hidden', 'value'=>$content_page_id));
							
				?>
			</div>
			<div class="radiobox-recentposts">
			 <?php      
			   $options = array('activeposts'=>'Recent posts', 'activepagesforum'=>'Most active forums');
			   echo $this->Form->input(' ', array(
								                'div' => 'input-whatsnew-radio',
								                'type' => 'select',
								                'options' => $options,
			   		                            'separator'=> '</div><div class="input-whatsnew-radio">',
								                'value' => $view_value,
								                'name'=>'post-active-area',
								                'legend'=>false
								       ));
			   ?>
			</div>
			<div class="clear"></div>
			   <?php if ($view_value == 'activeposts') {?>
					<ul id="comments">
						<?php
						if (count($posts)) :
						foreach ($posts as $post) : 
						if ($post['Forum']['post_type'] == 'comment') {
                               $post_type = $this->Html->tag('span', 'RE:', array('class' => 'reply-head', 'title' => 'reply'));
						       $reply_class = " replytype";
						} else {
							$post_type = $this->Html->tag('span', 'Question:', array('class' => 'question-head', 'title' => 'question'));
							$reply_class = "";
						}
						//if subject length is more than 1 character then add a .. string.
						$append_string = (strlen($post['Forum']['post_subject']) > 15) ? '..' : '';
						$web_root = $this->webroot;
						?>
							<li class="unread-postlink<?php echo $reply_class;?>" id="<?php echo 'qid_'.$post['Forum']['id'];?>">
								<span class="postlink-rep"><?php echo $this->Html->link($post_type.substr(ucfirst($post['Forum']['post_subject']), 0,25).$append_string.' posted by '.ucfirst($post['Forum']['post_by']).'.', 
										array('controller'=>'forums','action'=>'forumlist', $post['Forum']['contentpage_id']), array('target'=>'_blank',
												 'onclick'=>'forumDetail("'.$web_root.'","'.$post['Forum']['id'].'","'.$post['Forum']['contentpage_id'].'");','escape' => false));?>
								</span>
							</li>
						<?php endforeach;
						else : ?>
						<li>
						 <span class="found-post">No post found</span>
						</li> 
						<?php endif;
						?>
					</ul>
                   <?php } else {?>

                   <ul id="active-forum-area">
                   <?php 
                    if (count($active_pages)) :
	                 foreach ($active_pages as $act_pages) { ?>
	                   <li class="active-page">
	                    <?php $forum_page = $this->Html->tag('span', 'ForumPage:', array('class' => 'contentpage-head', 'title' => 'forum page'));?>
	                      	<span class="pagelink-active"><?php echo $this->Html->link($forum_page.substr(ucfirst($act_pages), 0,20), array('controller'=>'forums','action'=>'forumlist', $act_pages), array('target'=>'_blank','escape' => false));?>
                            </span>
                         </li>
                       <?php  }
                    else : 
                       ?>
                       <li>
						 <span class="found-pages-active">No Active Page found</span>
					   </li>
                    <?php 
                    endif;
                    ?>  
                   </ul>
                   <?php } ?>
			
       		   </div>
	    	</div>
		</li>
	</ul>
</div>

<!-- code end for unread posts -->

<!-- code start for assignment area -->
<div class="assignment-area">
    <ul id="acc3" class="accordion accordian-common">
        <li>
<!--    <span class="assignment-whatsnew">Assignment Reminders</span> -->
          <h4 class="h"><a class="trigger" href="#">Assignments</a></h4>
            <div class="outer">
               <div class="inner" id="content">
               <ul id="comments">
						<?php
						//get assignments
						$assignments = $this->requestAction(array('controller'=>'dashboards','action'=>'getAssignments'));
						
					
						
						if (count($assignments)) :
						foreach ($assignments as $assignment) :
                        //set display date for assignments
						$originalDate = $assignment['PleAssignmentReminder']['due_date'];
						if($originalDate != ""){
						$newDate = date("F d, Y", strtotime($originalDate));
						$due_date = " due on ".$newDate;
						} else {
							$due_date = " due on NA";
						}
						
						$web_root = $this->webroot; //get site url
						$post_type = $this->Html->tag('span', 'Assignments:', array('class' => 'assignment-head', 'title' => 'assignments'));
						
						//get dynamic assignment link
						$assignment_link = $this->requestAction(array('controller' => 'dashboards', 'action' => 'getAssignmentLink', $assignment['PleAssignmentReminder']['id']));
						?>
							<li class="unread-postlink" id="<?php echo $assignment['PleAssignmentReminder']['id'];?>">
                              <span class="postlink-rep">
                              <?php echo $this->Html->link($post_type.substr(ucfirst($assignment['PleAssignmentReminder']['assignment_title']), 0,200).$due_date, $assignment_link, array('target'=>'_blank','escape' => false));?>
			                  </span>
                            </li>
						<?php endforeach;
						else : ?>
						<li>
						 <span class="found-post">No assignment found</span>
						</li> 
						<?php endif;
						?>
						
					</ul></div>
			</div>
		</li>
	</ul>
</div>


<!-- code end for assignment area -->
<div class='backButton'>
<?php
echo $this->Form->input('userdata', array('type'=>'hidden', 'value'=>$ruserobj));
echo $this->Form->submit('Save', array('class'=> 'gobutton_outer', 'name'=>'save'));
//echo $this->Form->input('userObject', array('type'=>'hidden', 'value'=>$data_decode));
echo $this->Form->end(); ?>
 <a class="gobutton_outer" href='javascript:history.go(-1)' >Done</a>
</div>
 <?php echo $this->Html->link('Set assignment reminder', array('controller'=>'dashboards','action'=>'setAssignmentReminder'));  ?>
</div>
<?php

if ($userType == 'instructor') {
   // echo $this->Html->link('Set assignment reminder', array('controller'=>'dashboards','action'=>'setAssignmentReminder')); 
} else {
	//echo $this->Html->link('Set assignment reminder', array('controller'=>'dashboards','action'=>'setStudentAssignmentReminder'));
}
?>