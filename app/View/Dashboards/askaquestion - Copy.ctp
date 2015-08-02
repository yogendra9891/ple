<?php 
echo $this->Html->script('jquery.treeview', array('inline' => false)); //including the js for tree view of structure..
echo $this->Html->css('jquery.treeview', array('inline' => false)); //including the css for tree view..
$username = $this->Session->read('UserData.userName');
//get content page
$data_decode = json_decode($ruserobj);
$contentPageId = $data_decode->contentPageId;
//initialises the variable
$emailValCheck = '';
$feedValCheck  = '';
$facebookValCheck = '';
$twitValCheck = '';
$future_date = Configure::read('future_date');
?>
<div class="user_welcome">
<?php
//echo "Hello ". ucfirst($username);
?>
<h3>Ask a Question Date Access</h3>
<span class="course-name">
<?php echo 'Course - '. ucfirst($course);?></span>
</div>
<?php 
//get userType
$userType = "Instructor";
?>

<div class='contentpage_list'>


<div id="sidetree">
<!-- <div class="treeheader">&nbsp;</div> -->

<?php 
echo $this->Form->create('dashboards',array('action'=>'saveContentAvailability', 'class'=> 'contentsavesetting', 'id'=> 'savecontent-askquestion'));?>

<ul class="treeview" id="tree">

     <li class="forHeadings">
          <div class="toAlign">
           <div class="content forModule"><div id="sidetreecontrol"> <a href="?#">Collapse All</a> | <a href="?#">Expand All</a> </div></div>
           <div class="post1">
                 <h3>Posts</h3>
           </div>
           <div class="replies1">
               <h3>Replies</h3>
               
           </div>
           <div class="readOnly1">
                 <h3>Read Only</h3>
                  
           </div>
           <div class="clear"></div>
        
        </div>
     </li>
  <?php foreach ($module_structure as $k=>$module) {
	   if ($k != 'content_id') { ?>
		  <li class="collapsable"><div class="hitarea collapsable-hitarea"></div><span class="toAbsolute forModule"><?php echo $k.'('.$structure_title['title'][$k].')';?>
		  <a href="javascript:void(0);" title="edit" class="editdatesetting" id="edit_<?php echo $k;?>">Edit</a>
		  </span> 
			  <div class="folder toAlign">
		           <div class="content toIndent">Module 1</div>
		           <div class="post1">
		           		<!-- finding the module date setting saved in DB -->
		                <?php $module_date_setting = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getReadModuleTopicContentPagedateSetting'.'/'.$k.'/module'));?>
		                <?php //title for module 
							echo $this->Form->input('module tilte', array('type'=>'hidden', 'name'=>"data[$k][title]", 'value'=>$structure_title['title'][$k], 'id' =>'title_'.$k));
							//hidden flag filed 
							echo $this->Form->input('post hidden flag', array('type'=>'hidden', 'name'=>"data[$k][postflag]", 'value'=>'0', 'id'=>'post-flag_'.$k));
					    ?>
		                 <div id="poststartdateinput_<?php echo $k;?>" class="post_start_date_wrraper_input">
		                          <span>Begin</span>
<!-- 		                          <input type="text"> -->
		                   <?php 
		                     $module_date_setting->poststartdate = ($module_date_setting->poststartdate == $future_date) ? '' : $module_date_setting->poststartdate;
							 echo $this->Form->input('Start Date', array('name'=>"data[$k][poststartdate]", 'size'=>'10', 'value'=>$module_date_setting->poststartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'post_startdate_'.$k, 'readonly'=>'readonly'));
							 echo $this->Form->input('Start Date hidden', array('type'=>'hidden', 'name'=>"data[$k][poststartdate-hidden]", 'value'=>$module_date_setting->poststartdate, 'id'=>'post_startdate-hidden_'.$k));
						   ?>
		                          <div class="clear"></div>
		                 </div>
		                <div id="postenddateinput_<?php echo $k;?>" class="post_end_date_wrraper_input">
		                          <span>End</span>
<!-- 		                          <input type="text"> -->
		                 <?php 
		                     $module_date_setting->postenddate = ($module_date_setting->postenddate == $future_date) ? '' : $module_date_setting->postenddate;
							 echo $this->Form->input('End Date', array('name'=>"data[$k][postenddate]", 'size'=>'10', 'value'=>$module_date_setting->postenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'post_enddate_'.$k, 'readonly'=>'readonly'));
							 echo $this->Form->input('End date hidden', array('type'=>'hidden', 'name'=>"data[$k][postenddate-hidden]", 'value'=>$module_date_setting->postenddate, 'id'=>'post_enddate-hidden_'.$k));
			             ?>
		                          <div class="clear"></div>
		                </div>
		                <!-- posts start date on label start-->
		                <div id="poststartdatelabel_<?php echo $k;?>" class="post_start_date_wrraper_label">
		                          <span>Begin</span>
		                   <?php 
							  echo empty($module_date_setting->poststartdate)? 'NA' : $module_date_setting->poststartdate;
						   ?>
		                          <div class="clear"></div>
		                 </div>
		                <!-- posts start date on label end-->
		                <!-- posts end date on label start -->
		                <div id="postenddatelabel_<?php echo $k;?>" class="post_end_date_wrraper_label">
		                          <span>End</span>
<!-- 		                          <input type="text"> -->
		                 <?php 
							  echo empty($module_date_setting->postenddate)? 'NA' : $module_date_setting->postenddate;
			             ?>
		                          <div class="clear"></div>
		                </div>
		                <!-- posts end date on label end -->
		           </div>
		           <div class="replies1">
			           <div id="replystartenddateinput_<?php echo $k;?>" class="reply_date_wrraper_input">
			               <p>
							<?php 
							 //hidden flag filed for reply
 							 echo $this->Form->input('reply hidden flag', array('type'=>'hidden', 'name'=>"data[$k][replyflag]", 'value'=>'0', 'id'=>'reply-flag_'.$k));
							?>	
			                <?php 
			                    $module_date_setting->replystartdate = ($module_date_setting->replystartdate == $future_date) ? '' : $module_date_setting->replystartdate;
								echo $this->Form->input('Reply Start Date', array('name'=>"data[$k][replystartdate]", 'value'=>$module_date_setting->replystartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'reply_startdate_'.$k, 'readonly'=>'readonly'));
								echo $this->Form->input('Reply Start hidden', array('type'=>'hidden', 'name'=>"data[$k][replystartdate-hidden]", 'value'=>$module_date_setting->replystartdate, 'id'=>'reply_startdate-hidden_'.$k));
							?>
			               </p>
			               <p>
			              <?php
			                 $module_date_setting->replyenddate = ($module_date_setting->replyenddate == $future_date) ? '' : $module_date_setting->replyenddate;
							 echo $this->Form->input('Reply End Date', array('name'=>"data[$k][replyenddate]", 'value'=>$module_date_setting->replyenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'reply_enddate_'.$k, 'readonly'=>'readonly'));
							 echo $this->Form->input('Reply end hidden', array('type'=>'hidden', 'name'=>"data[$k][replyenddate-hidden]", 'value'=>$module_date_setting->replyenddate, 'id'=>'reply_enddate-hidden_'.$k));
				          ?>
			               
			               </p>
		               </div>
		               <!-- reply start/end date label start-->
			           <div id="replystartenddatelabel_<?php echo $k;?>"class="reply_date_wrraper_label">
			               <p><?php echo empty($module_date_setting->replystartdate)? 'NA' : $module_date_setting->replystartdate;?></p>
			               <p><?php echo empty($module_date_setting->replyenddate)? 'NA' : $module_date_setting->replyenddate;?></p>
		               </div>
		               
		               <!-- reply start/end date label end -->
		           </div>
		           <div class="readOnly1">
			            <div id="readonlystartenddateinput_<?php echo $k;?>" class="read_date_wrraper_input">
			                 <p>
						  <?php 
							 //hidden flag filed for read
							 echo $this->Form->input('read hidden flag', array('type'=>'hidden', 'name'=>"data[$k][readflag]", 'value'=>'0', 'id'=>'read-flag_'.$k));
							?>	
		                  <?php 
		                    $module_date_setting->readstartdate = ($module_date_setting->readstartdate == $future_date) ? '' : $module_date_setting->readstartdate;
							echo $this->Form->input('Read Start Date', array('name'=>"data[$k][readstartdate]", 'value'=>$module_date_setting->readstartdate, 'div'=>false, 'label'=>'', 'class'=>'startdatefield clearable', 'id' => 'read_startdate_'.$k, 'readonly'=>'readonly'));
							echo $this->Form->input('Read Start hidden', array('type'=>'hidden', 'name'=>"data[$k][readstartdate-hidden]", 'value'=>$module_date_setting->readstartdate, 'id'=>'read_startdate-hidden_'.$k));
						  ?>
			                 </p>
			               <p>
			               <?php 
			                 $module_date_setting->readenddate = ($module_date_setting->readenddate == $future_date) ? '' : $module_date_setting->readenddate;
			                 echo $this->Form->input('Read End Date', array('name'=>"data[$k][readenddate]", 'value'=>$module_date_setting->readenddate, 'div'=>false, 'label'=>'', 'class'=>'enddatefield clearable', 'id' => 'read_enddate_'.$k, 'readonly'=>'readonly'));
			                 echo $this->Form->input('Read End hidden', array('type'=>'hidden', 'name'=>"data[$k][readenddate-hidden]", 'value'=>$module_date_setting->readenddate, 'id'=>'read_enddate-hidden_'.$k));
		                  ?>
			               </p>
			               </div>
			               <!--  read only start/end label start-->
			             <div id="readonlystartenddatelabel_<?php echo $k;?>" class="read_date_wrraper_label">
			                 <p><?php echo empty($module_date_setting->readstartdate)? 'NA' : $module_date_setting->readstartdate;?></p>
			                 <p><?php echo empty($module_date_setting->readenddate)? 'NA' : $module_date_setting->readenddate;?></p>
			              </div>
			               
			               <!-- read only start/end label end-->
		           </div>
		           <div class="clear"></div>
		        
	        </div>
		  <ul>
			  <?php 
			   foreach ($module as $key=>$value) {
			   	if($key != 'content_id') { ?>
				     <li class="collapsable"><div class="hitarea collapsable-hitarea"></div>
				     <span class="toAbsolute"><?php echo $key.'('.$structure_title['title'][$key].')';?>&nbsp;&nbsp;<a href="javascript:void(0);" title="edit" class="editdatesetting" id="edit_<?php echo $key;?>">Edit</a></span>
				     	 <div class="folder">
					           <div class="content toIndent"><?php echo $key.'('.$structure_title['title'][$key].')';?></div>
					           <div class="post1">
					           <!-- finding the topic date setting saved in DB -->
		                       <?php $topic_date_setting = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getReadModuleTopicContentPagedateSetting'.'/'.$key.'/topic'));?>
	                       
					           <?php //title for topic
								 echo $this->Form->input('topic tilte', array('type'=>'hidden' ,'name'=>"data[$k][$key][title]", 'value'=>$structure_title['title'][$key], 'id' => 'topictitle_'.$key));
								?>
							   <?php 
							    //hidden flag filed for post
							    echo $this->Form->input('post hidden flag', array('type'=>'hidden', 'name'=>"data[$k][$key][postflag]", 'value'=>'0', 'id'=>'post-flag_'.$key));
							   ?>						           
					  <div id="poststartdateinput_<?php echo $key;?>" class="post_start_date_wrraper_input">
					                          <span>Begin</span>
<!-- 					                          <input type="text"> -->
									      <?php 
									        $topic_date_setting->poststartdate = ($topic_date_setting->poststartdate == $future_date) ? '' : $topic_date_setting->poststartdate;
											echo $this->Form->input('Start Date', array('name'=>"data[$k][$key][poststartdate]", 'size'=>'10', 'value'=>$topic_date_setting->poststartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'post_startdate_'.$key, 'readonly'=>'readonly'));
											echo $this->Form->input('Posts start date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][poststartdate-hidden]", 'value'=>$topic_date_setting->poststartdate, 'id'=>'post_startdate-hidden_'.$key));
										  ?>
					                          
					                          <div class="clear"></div>
					                     </div>
					                     <div id="postenddateinput_<?php echo $key;?>" class="post_end_date_wrraper_input">
					                          <span>End</span>
<!-- 					                          <input type="text"> -->
		                               <?php 
		                                  $topic_date_setting->postenddate = ($topic_date_setting->postenddate == $future_date) ? '' : $topic_date_setting->postenddate;
							              echo $this->Form->input('End Date', array('name'=>"data[$k][$key][postenddate]", 'size'=>'10', 'value'=>$topic_date_setting->postenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'post_enddate_'.$key, 'readonly'=>'readonly'));
							              echo $this->Form->input('Posts end date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][postenddate-hidden]", 'value'=>$topic_date_setting->postenddate, 'id'=>'post_enddate-hidden_'.$key));
			                           ?>
					                    <div class="clear"></div>
					                </div>
					                     
					                <!-- posts start date on label start-->
					                <div id="poststartdatelabel_<?php echo $key;?>" class="post_start_date_wrraper_label">
					                          <span>Begin</span>
					                   <?php 
										 echo empty($topic_date_setting->poststartdate)? 'NA' : $topic_date_setting->poststartdate;
									   ?>
					                   <div class="clear"></div>
					                 </div>
					                <!-- posts start date on label end-->
					                <!-- posts end date on label start -->
					                <div id="postenddatelabel_<?php echo $key;?>" class="post_end_date_wrraper_label">
					                          <span>End</span>
					                 <?php 
										 echo empty($topic_date_setting->postenddate)? 'NA' : $topic_date_setting->postenddate;
						             ?>
					                <div class="clear"></div>
					                </div>
					                <!-- posts end date on label end -->
								                     
					       </div>
					           <div class="replies1">
						           <div id="replystartenddateinput_<?php echo $key;?>" class="reply_date_wrraper_input">
						               <p>
							   <?php 
							    //hidden flag filed for reply
							    echo $this->Form->input('reply hidden flag', array('type'=>'hidden', 'name'=>"data[$k][$key][replyflag]", 'value'=>'0', 'id'=>'reply-flag_'.$key));
							   ?>						           
					                <?php
					                    $topic_date_setting->replystartdate = ($topic_date_setting->replystartdate == $future_date) ? '' : $topic_date_setting->replystartdate;
										echo $this->Form->input('Reply Start Date', array('name'=>"data[$k][$key][replystartdate]", 'value'=>$topic_date_setting->replystartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'reply_startdate_'.$key, 'readonly'=>'readonly'));
										echo $this->Form->input('Reply Start date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][replystartdate-hidden]", 'value'=>$topic_date_setting->replystartdate, 'id'=>'reply_startdate-hidden_'.$key));
									?>
					               </p>
					               <p>
					              <?php
					                 $topic_date_setting->replyenddate = ($topic_date_setting->replyenddate == $future_date) ? '' : $topic_date_setting->replyenddate;
									 echo $this->Form->input('Reply End Date', array('name'=>"data[$k][$key][replyenddate]", 'value'=>$topic_date_setting->replyenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'reply_enddate_'.$key, 'readonly'=>'readonly'));
									 echo $this->Form->input('Reply End date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][replyenddate-hidden]", 'value'=>$topic_date_setting->replyenddate, 'id'=>'reply_enddate-hidden_'.$key));
						          ?>
						               </p>
					               </div>
				               <!-- reply start/end date label start-->
					           <div id="replystartenddatelabel_<?php echo $key;?>" class="reply_date_wrraper_label">
					               <p><?php echo empty($topic_date_setting->replystartdate)? 'NA' : $topic_date_setting->replystartdate;?></p>
					               <p><?php echo empty($topic_date_setting->replyenddate)? 'NA' : $topic_date_setting->replyenddate;?></p>
				               </div>
				               
				               <!-- reply start/end date label end -->
							               
					               </div>
					           <div class="readOnly1">
						            <div id="readonlystartenddateinput_<?php echo $key;?>" class="read_date_wrraper_input">
							           <p>
							        <?php 
							         //hidden flag filed for read only
							         echo $this->Form->input('read hidden flag', array('type'=>'hidden', 'name'=>"data[$k][$key][readflag]", 'value'=>'0', 'id'=>'read-flag_'.$key));
							        ?>
					                <?php 
					                    $topic_date_setting->readstartdate = ($topic_date_setting->readstartdate == $future_date) ? '' : $topic_date_setting->readstartdate;
					                    echo $this->Form->input('Read Start Date', array('name'=>"data[$k][$key][readstartdate]", 'value'=>$topic_date_setting->readstartdate, 'div'=>false, 'label'=>'', 'class'=>'startdatefield clearable', 'id' => 'read_startdate_'.$key, 'readonly'=>'readonly'));
					                    echo $this->Form->input('Read Start date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][readstartdate-hidden]", 'value'=>$topic_date_setting->readstartdate, 'id'=>'read_startdate-hidden_'.$key));
									?>
						               </p>
						               <p>
									 <?php 
									     $topic_date_setting->readenddate = ($topic_date_setting->readenddate == $future_date) ? '' : $topic_date_setting->readenddate;
						                 echo $this->Form->input('Read End Date', array('name'=>"data[$k][$key][readenddate]", 'value'=>$topic_date_setting->readenddate, 'div'=>false, 'label'=>'', 'class'=>'enddatefield clearable', 'id' => 'read_enddate_'.$key, 'readonly'=>'readonly'));
						                 echo $this->Form->input('Read End date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][readenddate-hidden]", 'value'=>$topic_date_setting->readenddate, 'id'=>'read_enddate-hidden_'.$key));
					                  ?>
	   			                     </p>
					                  </div>
					               <!--  read only start/end label start-->
					            <div id="readonlystartenddatelabel_<?php echo $key;?>" class="read_date_wrraper_label">
					                 <p><?php echo empty($topic_date_setting->readstartdate)? 'NA' : $topic_date_setting->readstartdate;?></p>
					                 <p><?php echo empty($topic_date_setting->readenddate)? 'NA' : $topic_date_setting->readenddate;?></p>
					            </div>
					               <!-- read only start/end label end-->
					          </div>
					           <div class="clear"></div>
					        
				        </div>
					     <ul>
					      <?php foreach ($value as $file) { ?>
					  	    <li>
						  	    <div class="content">
	                              <img src="<?php echo $this->webroot.'img/file.gif'; ?>"><?php echo $file.'('.$structure_title['title'][$file].')'; ?>
	                              <a href="javascript:void(0);" title="edit" class="editdatesetting" id="edit_<?php echo $file;?>">Edit</a>
	                            </div>
	                            <div class="post">
				                <!-- finding the topic date setting saved in DB -->
	                            <?php $contentpage_date_setting = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getReadModuleTopicContentPagedateSetting'.'/'.$file.'/contentpage'));?>
				                <?php  //content page title
								 echo $this->Form->input('content page title', array('type'=>'hidden','name'=>"data[$k][$key][$file][title]", 'value'=>$structure_title['title'][$file], 'id' => 'contentpagetitle_'.$file));
								?>
							   <?php 
							    //hidden flag filed for post
							    echo $this->Form->input('post hidden flag', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][postflag]", 'value'=>'0', 'id'=>'post-flag_'.$file));
							   ?>						           
								
	                            <div id="poststartdateinput_<?php echo $file;?>" class="post_start_date_wrraper_input">
				                          <span>Begin</span>
<!-- 				                          <input type="text"> -->
				                          <?php 
				                            $contentpage_date_setting->poststartdate = ($contentpage_date_setting->poststartdate == $future_date) ? '' : $contentpage_date_setting->poststartdate;
											echo $this->Form->input('Start Date', array('name'=>"data[$k][$key][$file][poststartdate]", 'size'=>'10', 'value'=>$contentpage_date_setting->poststartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'post_startdate_'.$file, 'readonly'=>'readonly'));
											echo $this->Form->input('Start Date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][poststartdate-hidden]", 'value'=>$contentpage_date_setting->poststartdate, 'id'=>'post_startdate-hidden_'.$file));
										  ?>
				                          <div class="clear"></div>
				                     </div>
				                     <div id="postenddateinput_<?php echo $file;?>" class="post_end_date_wrraper_input">
				                          <span>End</span>
<!-- 				                          <input type="text"> -->
				                          <?php 
				                           $contentpage_date_setting->postenddate = ($contentpage_date_setting->postenddate == $future_date) ? '' : $contentpage_date_setting->postenddate;
							               echo $this->Form->input('End Date', array('name'=>"data[$k][$key][$file][postenddate]", 'size'=>'10', 'value'=>$contentpage_date_setting->postenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'post_enddate_'.$file, 'readonly'=>'readonly'));
							               echo $this->Form->input('End Date hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][postenddate-hidden]", 'value'=>$contentpage_date_setting->postenddate, 'id'=>'post_enddate-hidden_'.$file));
			                              ?>
				                          <div class="clear"></div>
				                     </div>
				                     <!-- posts start date on label start-->
					                <div id="poststartdatelabel_<?php echo $file;?>" class="post_start_date_wrraper_label">
					                 <span>Begin</span>
					                   <?php echo empty($contentpage_date_setting->poststartdate)? 'NA' : $contentpage_date_setting->poststartdate;?>
					                   <div class="clear"></div>
					                 </div>
					                <!-- posts start date on label end-->
					                <!-- posts end date on label start -->
					                <div id="postenddatelabel_<?php echo $file;?>" class="post_end_date_wrraper_label">
					                 <span>End</span>
					                 <?php echo empty($contentpage_date_setting->postenddate)? 'NA' : $contentpage_date_setting->postenddate;?>
					                  <div class="clear"></div>
					                </div>
					                <!-- posts end date on label end -->
				                     
				                </div>
				                  <div class="replies">
					                  <div id="replystartenddateinput_<?php echo $file;?>" class="reply_date_wrraper_input">
				                        <p>
							      <?php 
							        //hidden flag field for reply
							        echo $this->Form->input('reply hidden flag', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][replyflag]", 'value'=>'0', 'id'=>'reply-flag_'.$file));
							       ?>						           
				                        
						                <?php 
						                    $contentpage_date_setting->replystartdate = ($contentpage_date_setting->replystartdate == $future_date) ? '' : $contentpage_date_setting->replystartdate;
											echo $this->Form->input('Reply Start Date', array('name'=>"data[$k][$key][$file][replystartdate]", 'value'=>$contentpage_date_setting->replystartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'reply_startdate_'.$file, 'readonly'=>'readonly'));
											echo $this->Form->input('Reply Start hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][replystartdate-hidden]", 'value'=>$contentpage_date_setting->replystartdate, 'id'=>'reply_startdate-hidden_'.$file));
										?>
						               </p>
						               <p>
		                              <?php 
		                                $contentpage_date_setting->replyenddate = ($contentpage_date_setting->replyenddate == $future_date) ? '' : $contentpage_date_setting->replyenddate;
						                echo $this->Form->input('Reply End Date', array('name'=>"data[$k][$key][$file][replyenddate]", 'value'=>$contentpage_date_setting->replyenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'reply_enddate_'.$file, 'readonly'=>'readonly'));
						                echo $this->Form->input('Reply End hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][replyenddate-hidden]", 'value'=>$contentpage_date_setting->replyenddate, 'id'=>'reply_enddate-hidden_'.$file));
							          ?>
					                  </p>
				                        </div>
					               <!-- reply start/end date label start-->
						           <div id="replystartenddatelabel_<?php echo $file;?>" class="reply_date_wrraper_label">
						               <p><?php echo empty($contentpage_date_setting->replystartdate)? 'NA' : $contentpage_date_setting->replystartdate;?></p>
						               <p><?php echo empty($contentpage_date_setting->replyenddate)? 'NA' : $contentpage_date_setting->replyenddate;?></p>
					               </div>
				               
				               <!-- reply start/end date label end -->
		                        
				                </div>
			                      <div class="readOnly">
				                      <div id="readonlystartenddateinput_<?php echo $file;?>" class="read_date_wrraper_input">
					                        <p>
							            <?php 
							               //hidden flag field for read
							               echo $this->Form->input('read hidden flag', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][readflag]", 'value'=>'0', 'id'=>'read-flag_'.$file));
							              ?>						           
					                        
						                  <?php 
						                    $contentpage_date_setting->readstartdate = ($contentpage_date_setting->readstartdate == $future_date) ? '' : $contentpage_date_setting->readstartdate;
											echo $this->Form->input('Read Start Date', array('name'=>"data[$k][$key][$file][readstartdate]", 'value'=>$contentpage_date_setting->readstartdate, 'div'=>false, 'label'=>'', 'class'=>'startdatefield clearable', 'id' => 'read_startdate_'.$file, 'readonly'=>'readonly'));
											echo $this->Form->input('Read Start hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][readstartdate-hidden]", 'value'=>$contentpage_date_setting->readstartdate, 'id'=>'read_startdate-hidden_'.$file));
										  ?>
										  </p>
							            <p>
							              <?php 
							                 $contentpage_date_setting->readenddate = ($contentpage_date_setting->readenddate == $future_date) ? '' : $contentpage_date_setting->readenddate;
							                 echo $this->Form->input('Read End Date', array('name'=>"data[$k][$key][$file][readenddate]", 'value'=>$contentpage_date_setting->readenddate, 'div'=>false, 'label'=>'', 'class'=>'enddatefield clearable', 'id' => 'read_enddate_'.$file, 'readonly'=>'readonly'));
							                 echo $this->Form->input('Read End hidden', array('type'=>'hidden', 'name'=>"data[$k][$key][$file][readenddate-hidden]", 'value'=>$contentpage_date_setting->readenddate, 'id'=>'read_enddate-hidden_'.$file));
						                  ?>
					                   </p>
					                  </div>
							           <!--  read only start/end label start-->
							            <div id="readonlystartenddatelabel_<?php echo $file;?>" class="read_date_wrraper_label">
							                 <p><?php echo empty($contentpage_date_setting->readstartdate)? 'NA' : $contentpage_date_setting->readstartdate;?></p>
							                 <p><?php echo empty($contentpage_date_setting->readenddate)? 'NA' : $contentpage_date_setting->readenddate;?></p>
							               </div>
					               <!-- read only start/end label end-->
				                 </div>
				                   <div class="clear"></div>
					  	    </li>
					      <?php  } ?>
					     </ul>
				     </li>
			  <?php 
			   	 } else {
			      foreach ($value as $file) { ?>
			   	 	<li>
					   <div class="singleLi toAlign1">
				           <div class="content"><img src="<?php echo $this->webroot.'img/file.gif'; ?>"><?php echo $file.'('.$structure_title['title'][$file].')'; ?>
				           <a href="javascript:void(0);" title="edit" class="editdatesetting" id="edit_<?php echo $file;?>">Edit</a></div>
				           <div class="post1">
					      <!-- finding the topic date setting saved in DB -->
		                  <?php $contentpage_date_setting = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getReadModuleTopicContentPagedateSetting'.'/'.$file.'/contentpage'));?>
				          <?php //content page title
							echo $this->Form->input('content page title', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][title]", 'value'=>$structure_title['title'][$file],'id' => 'contentpagetitle_'.$file));
						  ?>				                          
						<?php 
						  //hidden flag field for post
						   echo $this->Form->input('post hidden flag', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][postflag]", 'value'=>'0', 'id'=>'post-flag_'.$file));
						?>						           
				           
				           <div id="poststartdateinput_<?php echo $file;?>" class="post_start_date_wrraper_input">
				                          <span>Begin</span>
				                          <?php 
				                            $contentpage_date_setting->poststartdate = ($contentpage_date_setting->poststartdate == $future_date) ? '' : $contentpage_date_setting->poststartdate;
											echo $this->Form->input('Start Date', array('name'=>"data[$k][contentpage][$file][poststartdate]", 'size'=>'10', 'value'=>$contentpage_date_setting->poststartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'post_startdate_'.$file, 'readonly'=>'readonly'));
											echo $this->Form->input('Start Date hidden', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][poststartdate-hidden]", 'value'=>$contentpage_date_setting->poststartdate, 'id'=>'post_startdate-hidden_'.$file));
										  ?>				                          
				                          <div class="clear"></div>
				                     </div>
				                     <div id="postenddateinput_<?php echo $file;?>" class="post_end_date_wrraper_input">
				                          <span>End</span>
				                          <?php 
				                           $contentpage_date_setting->postenddate = ($contentpage_date_setting->postenddate == $future_date) ? '' : $contentpage_date_setting->postenddate;
							               echo $this->Form->input('End Date', array('name'=>"data[$k][contentpage][$file][postenddate]", 'size'=>'10', 'value'=>$contentpage_date_setting->postenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'post_enddate_'.$file, 'readonly'=>'readonly'));
							               echo $this->Form->input('End Date hidden', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][postenddate-hidden]", 'value'=>$contentpage_date_setting->postenddate, 'id'=>'post_enddate-hidden_'.$file));
			                              ?>
				                          <div class="clear"></div>
				                     </div>
				                     <!-- posts start date on label start-->
					                <div id="poststartdatelabel_<?php echo $file;?>" class="post_start_date_wrraper_label">
					                          <span>Begin</span>
					                   <?php echo empty($contentpage_date_setting->poststartdate)? 'NA' : $contentpage_date_setting->poststartdate;?>
					                   <div class="clear"></div>
					                 </div>
					                <!-- posts start date on label end-->
					                <!-- posts end date on label start -->
					                <div id="postenddatelabel_<?php echo $file;?>" class="post_end_date_wrraper_label">
					                          <span>End</span>
					                 <?php echo empty($contentpage_date_setting->postenddate)? 'NA' : $contentpage_date_setting->postenddate;?>
					                 <div class="clear"></div>
					                </div>
					                <!-- posts end date on label end -->
				                     
				            </div>
				           <div class="replies1">
				            <div id="replystartenddateinput_<?php echo $file;?>" class="reply_date_wrraper_input">
				               <p>
						      <?php 
						        //hidden flag field for reply
						        echo $this->Form->input('reply hidden flag', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][replyflag]", 'value'=>'0', 'id'=>'reply-flag_'.$file));
						      ?>						           
				           
				                <?php 
				                    $contentpage_date_setting->replystartdate = ($contentpage_date_setting->replystartdate == $future_date) ? '' : $contentpage_date_setting->replystartdate;
									echo $this->Form->input('Reply Start Date', array('name'=>"data[$k][contentpage][$file][replystartdate]", 'value'=>$contentpage_date_setting->replystartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'reply_startdate_'.$file, 'readonly'=>'readonly'));
									echo $this->Form->input('Reply Start hidden', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][replystartdate-hidden]", 'value'=>$contentpage_date_setting->replystartdate, 'id'=>'reply_startdate-hidden_'.$file));
								?>
				               </p>
				               <p>
				              <?php 
				                 $contentpage_date_setting->replyenddate = ($contentpage_date_setting->replyenddate == $future_date) ? '' : $contentpage_date_setting->replyenddate;
								 echo $this->Form->input('Reply End Date', array('name'=>"data[$k][contentpage][$file][replyenddate]", 'value'=>$contentpage_date_setting->replyenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'reply_enddate_'.$file, 'readonly'=>'readonly'));
								 echo $this->Form->input('Reply End hidden', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][replyenddate-hidden]", 'value'=>$contentpage_date_setting->replyenddate, 'id'=>'reply_enddate-hidden_'.$file));
					          ?>
			                  </p>
			                  </div>
					        <!-- reply start/end date label start-->
						    <div id="replystartenddatelabel_<?php echo $file;?>" class="reply_date_wrraper_label">
						               <p><?php echo empty($contentpage_date_setting->replystartdate)? 'NA' : $contentpage_date_setting->replystartdate;?></p>
						               <p><?php echo empty($contentpage_date_setting->replyenddate)? 'NA' : $contentpage_date_setting->replyenddate;?></p>
					        </div>
				            <!-- reply start/end date label end -->
			              </div>
				           <div class="readOnly1">
					            <div id="readonlystartenddateinput_<?php echo $file;?>" class="read_date_wrraper_input">
					                 <p>
								<?php 
								  //hidden flag field for read
								   echo $this->Form->input('read hidden flag', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][readflag]", 'value'=>'0', 'id'=>'read-flag_'.$file));
								?>						           
					                 
					               <?php 
					                $contentpage_date_setting->readstartdate = ($contentpage_date_setting->readstartdate == $future_date) ? '' : $contentpage_date_setting->readstartdate;
									echo $this->Form->input('Read Start Date', array('name'=>"data[$k][contentpage][$file][readstartdate]", 'value'=>$contentpage_date_setting->readstartdate, 'div'=>false, 'label'=>'', 'class'=>'startdatefield clearable', 'id' => 'read_startdate_'.$file, 'readonly'=>'readonly'));
									echo $this->Form->input('Read Start hidden', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][readstartdate-hidden]", 'value'=>$contentpage_date_setting->readstartdate, 'id'=>'read_startdate-hidden_'.$file));
								  ?>
					                 </p>
					                  <p>
					              <?php 
					                 $contentpage_date_setting->readenddate = ($contentpage_date_setting->readenddate == $future_date) ? '' : $contentpage_date_setting->readenddate;
					                 echo $this->Form->input('Read End Date', array('name'=>"data[$k][contentpage][$file][readenddate]", 'value'=>$contentpage_date_setting->readenddate, 'div'=>false, 'label'=>'', 'class'=>'enddatefield clearable', 'id' => 'read_enddate_'.$file, 'readonly'=>'readonly'));
					                 echo $this->Form->input('Read End hidden', array('type'=>'hidden', 'name'=>"data[$k][contentpage][$file][readenddate-hidden]", 'value'=>$contentpage_date_setting->readenddate, 'id'=>'read_enddate-hidden_'.$file));
				                  ?>
					                 </p>
				                 </div>
					             <!--  read only start/end label start-->
					              <div id="readonlystartenddatelabel_<?php echo $file;?>" class="read_date_wrraper_label">
						              <p><?php echo empty($contentpage_date_setting->readstartdate)? 'NA' : $contentpage_date_setting->readstartdate;?></p>
						              <p><?php echo empty($contentpage_date_setting->readenddate)? 'NA' : $contentpage_date_setting->readenddate;?></p>
					              </div>
					             <!-- read only start/end label end-->
				                 
				         </div>
				           <div class="clear"></div>
				        
				        </div>
							                   
			   	 	</li>
			   	 	<?php  } ?>
			 <?php }
			  }  ?>
		   	</ul>
			</li>
	  <?php }  else { foreach ($module as $another_file) {?>
	   <li>
		   <div class="singleLi toAlign">
	           <div class="content"><img src="<?php echo $this->webroot.'img/file.gif'; ?>"><?php echo $another_file.'('.$structure_title['title'][$another_file].')';?>
	           <a href="javascript:void(0);" title="edit" class="editdatesetting" id="edit_<?php echo $another_file;?>">Edit</a></div>
	           <div class="post1">
			   <!-- finding the topic date setting saved in DB -->
	           <?php $contentpage_date_setting = $this->requestAction(array('controller'=>'dashboards', 'action'=>'getReadModuleTopicContentPagedateSetting'.'/'.$another_file.'/contentpage'));?>
	           
	           <?php //title for content page
			   echo $this->Form->input('content page title', array('type'=>'hidden','name'=>"data[contentpage][$another_file][title]", 'value'=>$structure_title['title'][$another_file],'id' => 'contentpagetitle_'.$another_file));
			   ?>				                          
			   <?php 
				   //hidden flag field for post
				  echo $this->Form->input('post hidden flag', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][postflag]", 'value'=>'0', 'id'=>'post-flag_'.$another_file));
			   ?>						           
				           
			   
	           <div id="poststartdateinput_<?php echo $another_file;?>" class="post_start_date_wrraper_input">
	                          <span>Begin</span>
	                          <?php 
	                            $contentpage_date_setting->poststartdate = ($contentpage_date_setting->poststartdate == $future_date) ? '' : $contentpage_date_setting->poststartdate;
								echo $this->Form->input('Start Date', array('name'=>"data[contentpage][$another_file][poststartdate]", 'size'=>'10', 'value'=>$contentpage_date_setting->poststartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'post_startdate_'.$another_file, 'readonly'=>'readonly'));
								echo $this->Form->input('Start Date hidden', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][poststartdate-hidden]", 'value'=>$contentpage_date_setting->poststartdate, 'id'=>'post_startdate-hidden_'.$another_file));
							  ?>				                          
	                          <div class="clear"></div>
	                 </div>
	                 <div id="postenddateinput_<?php echo $another_file;?>" class="post_end_date_wrraper_input">
	                          <span>End</span>
				            <?php 
				              $contentpage_date_setting->postenddate = ($contentpage_date_setting->postenddate == $future_date) ? '' : $contentpage_date_setting->postenddate;
							  echo $this->Form->input('End Date', array('name'=>"data[contentpage][$another_file][postenddate]", 'size'=>'10', 'value'=>$contentpage_date_setting->postenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'post_enddate_'.$another_file, 'readonly'=>'readonly'));
							  echo $this->Form->input('End Date hidden', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][postenddate-hidden]", 'value'=>$contentpage_date_setting->postenddate, 'id'=>'post_enddate-hidden_'.$another_file));
			                ?>
                          
	                          <div class="clear"></div>
	                 </div>
	                 <!-- posts start date on label start-->
					 <div id="poststartdatelabel_<?php echo $another_file;?>" class="post_start_date_wrraper_label">
					         <span>Begin</span>
					          <?php echo empty($contentpage_date_setting->poststartdate)? 'NA' : $contentpage_date_setting->poststartdate; ?>
					         <div class="clear"></div>
					 </div>
					 <!-- posts start date on label end-->
					 <!-- posts end date on label start -->
					 <div id="postenddatelabel_<?php echo $another_file;?>" class="post_end_date_wrraper_label">
					        <span>End</span>
					          <?php echo empty($contentpage_date_setting->postenddate)? 'NA' : $contentpage_date_setting->postenddate;?>
					        <div class="clear"></div>
					 </div>
					 <!-- posts end date on label end -->
	             
	           </div>
	           <div class="replies1">
	              <div id="replystartenddateinput_<?php echo $another_file;?>" class="reply_date_wrraper_input">
		               <p>
			   <?php 
				   //hidden flag field for reply
				  echo $this->Form->input('reply hidden flag', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][replyflag]", 'value'=>'0', 'id'=>'reply-flag_'.$another_file));
			   ?>						           
                           <?php
                            $contentpage_date_setting->replystartdate = ($contentpage_date_setting->replystartdate == $future_date) ? '' : $contentpage_date_setting->replystartdate;
							echo $this->Form->input('Reply Start Date', array('name'=>"data[contentpage][$another_file][replystartdate]", 'value'=>$contentpage_date_setting->replystartdate, 'div'=>false, 'label' => '', 'class'=>'startdatefield clearable', 'id' => 'reply_startdate_'.$another_file, 'readonly'=>'readonly'));
							echo $this->Form->input('Reply Start hidden', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][replystartdate-hidden]", 'value'=>$contentpage_date_setting->replystartdate, 'id'=>'reply_startdate-hidden_'.$another_file));
							?>
					   </p>
					   <p>
			           <?php
			             $contentpage_date_setting->replyenddate = ($contentpage_date_setting->replyenddate == $future_date) ? '' : $contentpage_date_setting->replyenddate;
						 echo $this->Form->input('Reply End Date', array('name'=>"data[contentpage][$another_file][replyenddate]", 'value'=>$contentpage_date_setting->replyenddate, 'div'=>false, 'label' => '', 'class'=>'enddatefield clearable', 'id' => 'reply_enddate_'.$another_file, 'readonly'=>'readonly'));
						 echo $this->Form->input('Reply End hidden', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][replyenddate-hidden]", 'value'=>$contentpage_date_setting->replyenddate, 'id'=>'reply_enddate-hidden_'.$another_file));
						?>
		               </p>
		           </div>
		       <!-- reply start/end date label start-->
				<div id="replystartenddatelabel_<?php echo $another_file;?>" class="reply_date_wrraper_label">
					<p><?php echo empty($contentpage_date_setting->replystartdate)? 'NA' : $contentpage_date_setting->replystartdate;?></p>
					<p><?php echo empty($contentpage_date_setting->replyenddate)? 'NA' : $contentpage_date_setting->replyenddate;?></p>
				</div>
				 <!-- reply start/end date label end -->
		           
	           </div>
	           <div class="readOnly1">
		           <div id="readonlystartenddateinput_<?php echo $another_file;?>" class="read_date_wrraper_input">
		              <p>
			   <?php 
				   //hidden flag field for read
				  echo $this->Form->input('read hidden flag', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][readflag]", 'value'=>'0', 'id'=>'read-flag_'.$another_file));
			   ?>						           
				      <?php
				        $contentpage_date_setting->readstartdate = ($contentpage_date_setting->readstartdate == $future_date) ? '' : $contentpage_date_setting->readstartdate;
						echo $this->Form->input('Read Start Date', array('name'=>"data[contentpage][$another_file][readstartdate]", 'value'=>$contentpage_date_setting->readstartdate, 'div'=>false, 'label'=>'', 'class'=>'startdatefield clearable', 'id' => 'read_startdate_'.$another_file, 'readonly'=>'readonly'));
						echo $this->Form->input('Read Start hidden', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][readstartdate-hidden]", 'value'=>$contentpage_date_setting->readstartdate, 'id'=>'read_startdate-hidden_'.$another_file));
					  ?>
					 </p>
					    <p>
					  <?php
					    $contentpage_date_setting->readenddate = ($contentpage_date_setting->readenddate == $future_date) ? '' : $contentpage_date_setting->readenddate;
					    echo $this->Form->input('Read End Date', array('name'=>"data[contentpage][$another_file][readenddate]", 'value'=>$contentpage_date_setting->readenddate, 'div'=>false, 'label'=>'', 'class'=>'enddatefield clearable', 'id' => 'read_enddate_'.$another_file, 'readonly'=>'readonly'));
					    echo $this->Form->input('Read End hidden', array('type'=>'hidden', 'name'=>"data[contentpage][$another_file][readenddate-hidden]", 'value'=>$contentpage_date_setting->readenddate, 'id'=>'read_enddate-hidden_'.$another_file));
				       ?>
		               </p>
		           </div>
		           	<!--  read only start/end label start-->
				   <div id="readonlystartenddatelabel_<?php echo $another_file;?>" class="read_date_wrraper_label">
					  <p><?php echo empty($contentpage_date_setting->readstartdate)? 'NA' : $contentpage_date_setting->readstartdate; ?></p>
					  <p><?php echo empty($contentpage_date_setting->readenddate)? 'NA' : $contentpage_date_setting->readenddate;?></p>
				   </div>
					<!-- read only start/end label end-->
		           
	           </div>
	           <div class="clear"></div>
	        
	        </div>
	   </li>
   <?php } } 
  } ?> 
  </ul>
  </div>
  <div class='backButton-askaquestion'>
<?php 
echo $this->Form->input('clear hidden field', array('type'=>'hidden', 'name'=>'clear-all', 'id'=>'clear-field','value'=>'not-clear', 'div'=>false));
echo $this->Form->submit('Clear All', array('name'=>'clear', 'div'=>array('id'=>'submit_clearall', 'class'=>'submit-clearsave'), 'class'=>'gobutton', 'onClick' => 'return clearAskQuestionSetting();'));
echo $this->Form->submit('Save Changes', array('name'=>'save','div'=>array('id'=>'submit_changes', 'class'=>'submit-datesave'), 'class'=>'gobutton'));
echo $this->Form->input('user objcet', array('type'=>'hidden', 'name'=>'user_object', 'value'=>base64_encode(json_encode($data_decode)), 'div'=>false));
echo $this->Form->end();
?>
<a class='gobutton_outer' href='javascript:history.go(-1)' >Done</a>
</div>
<!-- js for tree view -->
<script type="text/javascript">
		$(function() {
			   //js for tree view.
			$("#tree").treeview({
				animated: "fast",
				control:"#sidetreecontrol"
			});
		});
		
</script>