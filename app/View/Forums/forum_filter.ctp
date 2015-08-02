<?php
//get user name from session 
$username = $this->Session->read('UserData.userName');
//finding the user type
$user_type = $this->Session->read('UserData.userType');
//get read only setting
$readOnlySetting = $this->requestAction('forumChildren/getReadOnlySetting/'.$contentPageId.'/');
$user_can_post = $this->requestAction('forumChildren/getPostSetting/'.$contentPageId.'/'); 
$user_can_reply = $this->requestAction('forumChildren/getReplyDateSetting/'.$contentPageId.'/');
$msg = "<div class='ask-question-form-inner'><span class='ask-question-title'>Forum is in read only mode.</span></div>";
if($readOnlySetting == 1 && $user_can_post == 1){
	$readOnlySetting = 0;
	$msg = '';
}
if ($readOnlySetting == 1 && $user_can_reply == 1) {
	$msg = '';
} else if($user_can_reply == 1) {
	$msg = '';
} else {
	$msg = '';
}

//get site url
$site_url = $this->webroot;
?>

<!-- -----Filter starts here -->
<div id="w-filter">
<div id="w-filter-inner" class="filter-box filter-question-form">
<span class="ask-question-title">Filter Posts(Questions/Replies)</span>
<?php 
if($this->Paginator->sortKey()):
//action adding manually for sorting.
@$action_add = '/sort:'.$this->Paginator->sortKey().'/direction:'.$this->Paginator->sortDir(); 
endif;
echo $this->Form->create('forums',array('action'=>'filterQuestions'.@$action_add,'type' => 'get'),array('class'=>'form-horizontal'));
?>

<?php
@$post_subject_value = $this->request->query['post_subject'];
echo $this->Form->input('post_subject', array('div'=>'control-group', 'value'=>$post_subject_value, 'label' => 'Post Subject', 'class'=>'control-label'));
$register_users =  $this->requestAction('forums/findRegisteredUsers/'.$contentPageId);

//initialise the uses array
$postsusers = array();

//preparing users key/value array for the drop dowm
foreach ($register_users as $post_users)
	if(!array_key_exists($post_users['PleUser']['userName'], $postsusers))
	
$postsusers[$post_users['PleUser']['userName']] = $post_users['PleUser']['name'];
@$post_ques_by = $this->request->query['post_by'];
echo $this->Form->input('post_by', array('div'=>'control-group', 'type' => 'select', 'selected'=>$post_ques_by, 'options' =>$postsusers, 'empty' => '--Select Author--', 'label' => 'Post By', 'class'=>'control-label'));

//for start date
@$post_ques_from = $this->request->query['ques_from'];
echo "<div class='control-group'>".$this->Form->input('ques_from', array('div'=>'control-qf', 'value'=>$post_ques_from, 'label' => 'From', 'class'=>'control-label','id' => 'datepicker'))."</div>";

//for end date
@$post_ques_to = $this->request->query['ques_to'];
echo "<div class='control-group'>".$this->Form->input('ques_to', array('div'=>'control-qf', 'value'=>$post_ques_to , 'label' => 'To', 'class'=>'control-label','id' => 'datepicker2'));
echo "</div><br /><br />";

//for question/reply status
echo "<div class='control-group'>";
@$ques_status_value = $this->request->query['ques_status'];
echo $this->Form->input('Post Status', array('name'=>'ques_status', 'value'=>$ques_status_value, 'type' => 'radio', 'options' => array('Published','Draft')));
echo "</div>";

//for question/reply type
echo "<div class='control-group'>";
@$ques_type_value = $this->request->query['ques_type'];
echo $this->Form->input('Post Type', array('name'=>'ques_type', 'type' => 'radio', 'value'=>$ques_type_value, 'options' => array('UnRead','Read')));
echo "</div>";

//for question flag
echo "<div class='control-group'>";
if(@$this->request->query['ques_flag'])
$post_ques_flag = 'true';
echo $this->Form->input('Flag', array('name'=>'ques_flag', 'checked' =>@$post_ques_flag, 'type' => 'checkbox'));
echo "</div>";

//form end. Submit the forum. 
//echo $this->Form->submit('Search', array('div'=>'control-group control-search','name'=>'submit', 'class'=>'qreply', 'title'=>'Filter questions','type'=>'image','src' => $this->webroot.'/img/filtersearch.png'));
echo $this->Form->submit('Search', array('div'=>'ques-search-btn', 'name'=>'submit', 'title'=>'Search questions', 'class'=>'qreply gobutton'));
echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
echo $this->Form->end();
?>
</div>
</div>
<!-- Filter end here -->

<!-- Ask question starts here -->
<div id="w-ques-inner" class="ask-question-form" >
<?php
//Check if forum setting is enabled
if(($readOnlySetting == 0) || ($user_type=='instructor')){
?>
<div class="ask-question-form-inner">
<?php if ($user_can_post || ($user_type=='instructor')) {?>
<span class="ask-question-title">Ask Question</span>
<?php echo $this->Form->create('forums',array('action'=>'askQuestion')); ?>
<div id="subject-error-msg" class="error-msg"></div>
<?php echo $this->Form->input('post_subject', array('label' => 'Post Subject', 'class'=>'postsubject', 'size'=>'84','id'=>'subject')); ?>
<div id="content-error-msg" class="error-msg"></div>
<?php
echo $this->Form->textarea('post_body', array('class'=>'ckeditor', 'id'=>'content', 'label' =>'Post Body'));
echo $this->Form->submit('Ask', array('name'=>'submit', 'class'=>'qreply gobutton', 'title'=>'Ask question','onclick' => "return checkAskValidation();"));
echo $this->Form->submit('Save', array('name'=>'submit', 'class'=>'qsave gobutton', 'title'=>'save as draft','onclick' => "return checkAskValidation();"));
echo $this->Form->button('Preview', array('type' => 'button','onclick'=> 'ShowQuestionPreview();', 'class'=>'preview_question gobutton'));
echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
echo $this->Form->end();
}
?>
</div>
<?php 
}
//if ($readOnlySetting == 1){
echo $msg;
//} else {
//	echo "ss";
//}


//end of forum check
?>
</div>

<!-- Ask question ends here -->

<div class="clear"></div>
<?php if(count($posts)): ?>
<div id="w" class='search-results-area'>
<div id="container">
<div class="sortfield-area">
<span class="sortfield-area-subject">
<?php 
echo $this->Paginator->sort('Forum.post_subject', 'Subject', array('title'=>'sort posts by Subject', 'class' => ('Forum.post_subject' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<span class="sortfield-area-author">
<?php echo $this->Paginator->sort('Forum.author_sort', 'Author',  array('title'=>'sort posts by Author', 'class' => ('Forum.author_sort' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<span class="sortfield-area-date">
<?php echo $this->Paginator->sort('Forum.post_date', 'Date', array('title'=>'sort posts by Date', 'class' => ('Forum.post_date' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<span class="sortfield-area-publish">
<?php echo $this->Paginator->sort('Forum.is_draft', 'UnPublish/Draft', array('title'=>'sort posts by UnPublished/Draft', 'class' => ('Forum.is_draft' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<?php
//Check if forum setting is enabled
if(($readOnlySetting == 0) || ($user_type=='instructor')){
?>
<span class="sortfield-area-flag">
<?php echo $this->Paginator->sort('Forum.is_flag_sort', 'Flag', array('title'=>'sort posts by Flag/UnFlag', 'class' => ('Forum.is_flag_sort' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<?php }?>
</div>
<ul id="comments" class='forumsearch'>
<?php foreach($posts as $post): ?>

	<li class="cmmnt" id="<?php echo 'qid_'.$post['Forum']['id'];?>">
	<div class="cmmnt-content"><header>
<?php 
      //check for forum question id
      if($post['Forum']['question_id']==""){
         $qqid = $post['Forum']['id'];
       }else{
         $qqid = $post['Forum']['question_id'];
       }
?>
	<span class="userlink usr-rep">
	     <b><a href='javascript:showForumDetail("<?php echo $this->webroot;?>","<?php echo $qqid;?>","<?php echo $contentPageId;?>")'><?php echo substr(ucfirst($post['Forum']['post_subject']), 0,25).'..';?></a>
		</b></span>- <span class="pubdate">posted on <?php echo date('m-d-Y: h:i A',$post['Forum']['post_date']);?>
		</span>
		<span class="pubdate">By <?php echo ucfirst($post['pleuser']['name']);?>
		</span>
		<div class="flagpin-post">
		<?php if($post['Forum']['is_draft'] && $post['Forum']['post_by'] == $username): 
		$publish_image = $this->webroot.'img/publish.png';
		?>
		<span class="publish-post">
		<input width="16" type="image" value="Publish Post" id="publishimage_<?php echo $post['Forum']['id']; ?>" class="publish_post" title="publish post" src="<?php echo $publish_image; ?>">
		</span>
		<?php endif; ?>
		<?php 
		//check for post type and read only setting
		if ($post['Forum']['post_type'] == 'question') { 
		if (($readOnlySetting == 0) || ($user_type == 'instructor')) {
		?>
		<span class="pin-post">
		<?php
		//call checkPostPin action from forums controller.
		$pinPost = $this->requestAction('forums/checkPostPin/'.$post['Forum']['id']);
		if($pinPost>0 || $pinPost != ''){
			$image = $this->webroot.'img/unpin.png';
			$title = 'unpin post';
		}
		else{
			$image = $this->webroot.'img/pin.png';
			$title = 'pin post';
		}
		?>
		<input width="16" type="image" value="<?php echo @$post['Forum']['is_pin']; ?>" id="pinimage_<?php echo $post['Forum']['id']; ?>" class="pinunpin_question" title="<?php echo $title;?>" src="<?php echo $image;?>">
		</span>
		<span class="flag-post">
		<?php
		//call checkPostFlag action from forums controller.
		$flagPost = $this->requestAction('forums/checkPostFlag/'.$post['Forum']['id']);
		
		//check form flagPost
		if ($flagPost>0 || $flagPost != '') {
			$flagimage = $this->webroot.'img/unflag.png';
			$flagtilte = 'unflag post';
		} else {
			$flagimage = $this->webroot.'img/flag.png';
			$flagtilte = 'flag post';
		}
		?>
		<input width="16" type="image" value="<?php echo @$post['Forum']['is_flag']; ?>" id="flagimage_<?php echo $post['Forum']['id']; ?>" class="flagunflag_question" title="<?php echo $flagtilte; ?>" src="<?php echo $flagimage;?>">
		</span>
		<?php } }else{?>
				<span class="pin-post"><img src="<?php echo $this->webroot;?>/img/comment.png" title='Reply' /></span>			
				<?php }?>
		</div>
		</header>
<div>
	   <?php
	   //initialise the variable.
	   $ratingCount = 0;
	   
	   //call getOverallRate action from forums controller.
	   $ratingCount = $this->requestAction('forums/getOverallRate/'.$post['Forum']['id']);
	    
       //same user can not rate the same post
       if($ratingCount){ 
  	   //show the user vote count
  	   $voteCount = $this->requestAction('forums/getUserVoteCount/'.$post['Forum']['id']);
  	   ?>
	   <div class="Clear">
	    <input class="star required" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 1){echo 'checked="checked"';} ?> disabled='disabled' value="1"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>"  <?php if($ratingCount == 2){echo 'checked="checked"';} ?> disabled='disabled' value="2"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 3){echo 'checked="checked"';} ?> disabled='disabled' value="3"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 4){echo 'checked="checked"';} ?> disabled='disabled' value="4"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 5){echo 'checked="checked"';} ?> disabled='disabled' value="5"/>
	   <?php    if($voteCount>1){
	  	$voteLabel = 'Votes';
	  }else{
	  	$voteLabel = 'Vote';
	  }
	  echo "<span style='font-weight:bold;line-height:19px;' class='voted'>".$voteCount." ".$voteLabel." </span> ";?>
	    </div>
	  <?php }
	  else{ ?>
	  <div class="Clear">
	   <input class="star required" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="1"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>"  disabled='disabled' value="2"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="3"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="4"/>
	    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="5"/>
	    <span style="line-height:19px;" class='voted'>Rate this</span>
	    </div>
	 <?php  }  ?>
 </div>

	<p>
	<?php 
	echo $this->Text->truncate($post['Forum']['post_body'], 200, array( 'ellipsis' => '...', 'exact' => true, 'html' => true ));
	
	//check for forum question id
	if($post['Forum']['question_id']==""){
		$post['Forum']['question_id'] = $post['Forum']['id'];
	}
	?>
	 <input type='image' src= '<?php echo $this->webroot;?>img/view.png' onClick='showForumDetail("<?php echo $this->webroot;?>","<?php echo $post['Forum']['question_id'];?>","<?php echo $contentPageId; ?>");' value='more' />
	</p>
	</div>
	</li>

<?php endforeach;?>
</ul>
</div>

<!--Pagination starts here -->
<div class="pagination">
<?php 
// Shows the page numbers. Shows the next and previous links

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
<!-- Pagination ends here -->

</div>
<?php else: ?>
<div id="no-result" style='display:none'>
<h1>No Result found</h1>
</div>
<?php 
?>
<?php endif; ?>

<!-- Show dialog window -->
<div id="dialog1"></div>

<!-- Script will only call for the ask forum filter page layout. -->
<script type="text/javascript">
$(document).ready(function(){
    $('#loader', window.parent.document).hide();
    
	//check for success message
	if(message_text == "Your post saved successfully."){
	//if succsess message the rload the left iframe
	$('#iframe1', window.parent.document).each(function() {
		  this.contentWindow.location.reload(true);
	});
	}
	
    //hide flash message after 3 sec
    $('#flashMessage').delay(3000).fadeOut();
	var site_base_url = '<?php echo $this->webroot;?>';
	var contentpageid = '<?php echo $contentPageId;?>';
	$('.pinunpin_question').click(function(){
		current_id = $(this).attr('id');
		title= $(this).attr('title');
		pinunpinpost(site_base_url,current_id ,title);
	});
	$('.flagunflag_question').click(function(){
		current_id = $(this).attr('id');
		title= $(this).attr('title');
		flagunflagpost(site_base_url,current_id ,title);
	});
	$('.publish_post').click(function(){
		current_id = $(this).attr('id');
		publishpost(site_base_url,current_id,contentpageid);
	});

	// we can check any filed of the query string, this can be changed,
	// just we have to check its a search url to showing the search area div open.
	 var d = '<?php echo array_key_exists('submit', $this->request->query) ? "close":'open'; ?>';
	 if (d=='close'){
     $('#w-ques-inner').hide();
     $('#no-result').show();
	 	  $('.forumDetailClass').slimscroll({
		  height: '700px'
	      });
	 }else{
	 $('#forumDetailArea').removeClass('forumDetailClass');
	 }
	 
	 //get iframe name
	var caction = parent.document.getElementById('iframe4').name;
	
	//check for action
	if (caction == 'iframeFilter' && d !='close'){
	 $('#w-ques-inner').hide();
	 $('#w-filter-inner').show();
	}
});

/**
 * set iframe height according to screen
 */
function autoResize(id){
    var newheight;
    var newwidth;
    if(document.getElementById){
        newheight= $( document ).height()-90;
    }
    document.getElementById(id).height= (newheight) + "px";
}
</script>