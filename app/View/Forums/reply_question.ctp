<?php
$currentPage = $this->Paginator->current();
//finding the user type
$user_type = $this->Session->read('UserData.userType');
//get read only setting
$readOnlySetting = $this->requestAction('forumChildren/getReadOnlySetting/'.$contentPageId);
$replySetting = $this->requestAction('forumChildren/getReplyDateSetting/'.$contentPageId);

if($readOnlySetting == 1 && $replySetting ==1)
	$readOnlySetting = 0;	
?>

<div id="w" class="main-thered-reply"> 
	<div id="container">
		<ul id="comments" class='forum-detail'>
			<li class="cmmnt">
				<!-- Edit button, Check if post has replied --> 
				<?php $checkReply = $this->requestAction('forums/checkQuestionReply/'.$quesComts['Forum']['id']);
				 
				//check for author
				if((($checkReply['cUser']==$checkReply['post_by']) && ($checkReply['is_reply']==0)) && ( ($readOnlySetting == 0) || ($user_type=='instructor') )){ ?>
					<div style="float: right;">
						<input type="image"
							src="<?php echo $this->webroot;?>/img/editpost.png"
							onClick="showEditQuesBox();" />
					</div> 
				
				<?php  }
				
				//check for instructor	
				foreach($checkReply['instructors'] as $instructor){
				if($checkReply['cUser']==$instructor['PleUser']['userName']){
				if (($checkReply['is_reply']== 0) && ( ($readOnlySetting == 0)  || ($user_type=='instructor') )) { ?>
				<div style="float: right;">
					<?php 
					echo $this->Html->link(
							$this->Html->image('post_delete.png',array('class' => '',
									'id' =>'img_id', 'title' => 'Delete Question' )), array('controller'=>'Forums','action'=>'removeQuestion',$quesComts['Forum']['id'],$contentPageId), array('escape'=>false, 'onclick' => 'return showDeleteConfirmAlert();','class'=>'linkclass'));

                    ?>
				</div> 
				<?php 
					 }
					 }
				     }
                 ?>
				
				<div class="cmmnt-content">
					<div id="questionDiv">
						<header>
							<span class="userlink  user-rep"><?php echo ucfirst($quesComts['Forum']['post_subject']);?>
							</span> - <span class="pubdate">posted on  <?php echo date('m-d-Y: h:i A',$quesComts['Forum']['post_date']);?>
							</span> <span class="pubdate">By <?php echo ucfirst($quesComts['Forum']['post_by']);?>
							</span>
						</header>
						<p>
							<?php echo $quesComts['Forum']['post_body'];?>
						</p>
					</div>
					<div id="editPostDiv">
						<?php 
						echo $this->Form->create('Forum', array('action' => 'editQuestion'));
						echo $this->Form->input('id', array('value'=>$quesComts['Forum']['id'], 'type'=>'hidden'));
						?>
						<div id="editsubjectMsg" class="error-msg"></div>
						<?php 
						echo $this->Form->input('Post Subject:',array('id'=>'editsubject','name'=>'editSubject','type'=>'text','size' => '70','value'=>$quesComts['Forum']['post_subject']));
						?>
						<div id="editcommentMsg" class="error-msg"></div>
						<?php 
						echo $this->Form->textarea('editComment', array('rows' => '5', 'cols' => '55','class'=>'ckeditor qreplybox1'.$quesComts['Forum']['id'],'value'=>$quesComts['Forum']['post_body']));
						echo $this->Form->submit('Save Editing',array('div'=>true,'class' => 'qsave gobutton','title' => 'Ask','onclick' => "return checkEditQuestValidation();"));
						echo $this->Form->button('Preview', array('class'=>'gobutton','type' => 'button','title' => 'Preview the textarea content', 'onclick'=> "ShowEditPostPreview(".$quesComts['Forum']['id'].");"));
						echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
						echo $this->Form->end();

						?>
					</div>
					<?php echo $this->Form->create('Forum', array('action' => 'ratePost')); 
					echo $this->Form->input('cpage', array('value'=>$currentPage, 'type'=>'hidden'));
					echo $this->Form->input('id', array('value'=>$quesComts['Forum']['id'], 'type'=>'hidden'));
					$checkUserVote = $this->requestAction('forums/checkUserVote/'.$quesComts['Forum']['id']);
					?>
					
					<!--  same user can not rate the same post-->
					 <?php 
                     //Check if forum setting is enabled
                     if ( ($readOnlySetting == 0 && $replySetting == 1) || ($user_type=='instructor') ) { ?>
					<div>
						<div class="Clear vote-area">
							<input class="star required" type="radio" name="post-rating"
							<?php  if($checkUserVote){echo "disabled='disabled'";if($ratingCount == 1){echo 'checked="checked"';}}?>
								value="1" /> <input class="star" type="radio" name="post-rating"
								<?php  if($checkUserVote){echo "disabled='disabled'";if($ratingCount == 2){echo 'checked="checked"';}} ?>
								value="2" /> <input class="star" type="radio" name="post-rating"
								<?php if($checkUserVote){echo "disabled='disabled'";if($ratingCount == 3){echo 'checked="checked"';}} ?>
								value="3" /> <input class="star" type="radio" name="post-rating"
								<?php if($checkUserVote){echo "disabled='disabled'";if($ratingCount == 4){echo 'checked="checked"';}} ?>
								value="4" /> <input class="star" type="radio" name="post-rating"
								<?php  if($checkUserVote){echo "disabled='disabled'";if($ratingCount == 5){echo 'checked="checked"';}} ?>
								value="5" />
						</div>

						<?php
						//show the user vote count
						$voteCount = $this->requestAction('forums/getUserVoteCount/'.$quesComts['Forum']['id']);

						//same user can not rate the same post
						if($checkUserVote){
							echo "<span class='voted'>Your vote</span>";
						}else{
							echo $this->Form->submit('Rate', array('div'=>true, 'name'=>'button_type','class'=>'ratebutton', 'title' => 'Rate the question'));
						}
						if($voteCount>1){
							$voteLabel = 'Votes';
						}else{
							$voteLabel = 'Vote';
						}
						echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
						echo $this->Form->end(); ?>
					</div>
						<?php  } ?>
				</div>
				
                <?php 
				//check if question is saved as draft
				if ( ($quesComts['Forum']['is_draft'] != 1) && ( ($readOnlySetting == 0 && $replySetting == 1) || ($user_type=='instructor') )){
					?>
				<div class="reply">
					<?php echo $this->Form->create('Forum', array('action' => 'submitComment')); 

					echo $this->Form->input('cpage', array('value'=>$currentPage, 'type'=>'hidden'));
					echo $this->Form->input('fid', array('value'=>$quesComts['Forum']['id'], 'type'=>'hidden'));
					echo $this->Form->input('rid', array('value'=>0, 'type'=>'hidden'));
					echo $this->Form->input('RE:',array('type'=>'text','size' => '88','value'=>$quesComts['Forum']['post_subject'],'disabled' => TRUE));
					echo $this->Form->input('re',array('type'=>'hidden','size' => '88','value'=>$quesComts['Forum']['post_subject']));
					?>
					<div id="reply1" class="error-msg"></div>
					<?php
					echo $this->Form->textarea('comment', array('rows' => '5', 'cols' => '55','class'=>'ckeditor qreplybox','id'=>'quest'.$quesComts['Forum']['id']));
					echo $this->Form->submit('Reply', array('div'=>true, 'name'=>'button_type','class' => 'qreply gobutton', 'title' => 'Reply','onclick' => "return checkValidation(".$quesComts['Forum']['id'].");"));
					echo $this->Form->submit('Save', array('div'=>true, 'name'=>'button_type','class' => 'gobutton','title' => 'Save as draft','onclick' => "return checkValidation(".$quesComts['Forum']['id'].");"));
					echo $this->Form->button('Preview', array('class'=>'gobutton','type' => 'button', 'title' => 'Preview the textarea content', 'onclick'=> "ShowPostPreview(".$quesComts['Forum']['id'].");"));
					echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
					echo $this->Form->end();
					?>
				</div>
				<?php } ?>
			</li>
		</ul>
	</div>
</div>

<?php
if (count($Comts)>0) {
?>
<div id="w-threaded" class="thered-reply">
	<h1>Threaded Comments Block</h1>
    
    <?php 
    $repyreadimg = $this->webroot.'img/mark_read_large.png';
    $read_relies_title = "Mark all replies as read";
    $showmarkoption = $this->requestAction('forums/showReadUnreadOption/'.$quesComts['Forum']['id'].'/'.$contentPageId);

    if ( ($showmarkoption) && ( ($replySetting == 1) || ($user_type=='instructor') ) ) {
    ?>
    <span class="mark_global_read">
     <input type="image" class="mark_read_replies" id='markreadreplies_<?php echo $quesComts['Forum']['id'];?>' title="<?php echo $read_relies_title; ?>" src="<?php echo $repyreadimg;?>">
    </span>
    <span class="mark-readconfirmation" style="display:none;">
      You have marked all replies as read.
    </span>
    <?php }?>
	<div id="container">
		<ul id="comments">
			<?php
			foreach($Comts as $quesComt) {
				//encode the sunject
				$encode_subj = base64_encode($quesComts['Forum']['post_subject']);
				
				//load parent comment
				$passString = $quesComt['Forum']['id'].'/'.$currentPage.'/'.$quesComts['Forum']['id'].'/'.$encode_subj.'/'.$contentPageId;
				$resultarray = $this->requestAction('forums/loadChildComments/'.$passString);
			}	
     }
			 ?>
		 </ul>
	 </div>
</div>
	<div class="pagination">
	
		<?php 
		// Shows the page numbers, Shows the next and previous links
		if($this->params['paging']['Forum']['pageCount'] > 1){
			echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
		}
		echo $this->Paginator->numbers();
		if($this->params['paging']['Forum']['pageCount'] > 1){
			echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
		}

		// prints X of Y, where X is current page and Y is number of pages
		echo $this->Paginator->counter();

		?>
		
	</div>
		
		
<!-- Show dialog window -->
<div id="dialog"></div>	

<!-- Script will only call for the reply question page layout -->
<script type="text/javascript">
	$(document).ready(function(){
	    $('#loader', window.parent.document).hide();
	    
	    //hide flash message after 3 sec
	    $('#flashMessage').delay(3000).fadeOut();
	    $('#editPostDiv').hide();
	    $('#flashMessage', window.parent.document).hide();
		var site_base_url = '<?php echo $this->webroot;?>';
		$('.mark_read_replies').click(function(){
			currentreply_id = $(this).attr('id');
			reply_title= $(this).attr('title');
			markGlobalRread(site_base_url, currentreply_id, reply_title);
		});
	});
	
	//call this function after save the record.
   function complete(cmtId){
     var rateCount = $('#cmt-counttext'+cmtId).val();
     newrateCount = parseInt(rateCount)+1;
     $('#cmt-countid'+cmtId).html(newrateCount+" Votes");
     $('#vote'+cmtId).hide();
    }
	
	//check form response
 function checkData(data,cmtId){
    if(data == 'valid'){
    	 var rateCount = $('#cmt-counttext'+cmtId).val();
         newrateCount = parseInt(rateCount)+1;
         $('#cmt-countid'+cmtId).html(newrateCount+" Votes");
         $('#vote'+cmtId).hide();
    }else{
       $.msgBox({
		    title:"Alert",
		    content:'Please select stars'
		});
    	return false;
    }
   }
</script>
<!-- End of script -->	