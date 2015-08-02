<?php 
//get user name from session
$username = $this->Session->read('UserData.userName');

//get read only setting by the instructor
$readOnlySetting = $this->requestAction('forumChildren/getReadOnlySetting/'.$contentPageId);
$user_can_post = $this->requestAction('forumChildren/getPostSetting/'.$contentPageId.'/');
$replySetting    = $this->requestAction('forumChildren/getReplyDateSetting/'.$contentPageId);

if($user_can_post ==1)
	$readOnlySetting = 0;
//finding the user type
$user_type = $this->Session->read('UserData.userType');
if(count($posts)): 
?>
<div id="w" class="ask-question-area">
<div id="container-inner">
<div class="sortfield-area-ask">
<span class="sortfield-area-subject sortfield-assign">
<?php 
echo $this->Paginator->sort('Forum.post_subject', 'Subject', array( 'direction'=> 'desc', 'title'=>'sort posts by Subject', 'class' => ('Forum.post_subject' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<span class="sortfield-area-author sortfield-assign">
<?php echo $this->Paginator->sort('Forum.author_sort', 'Author',  array( 'direction'=> 'desc', 'title'=>'sort posts by Author', 'class' => ('Forum.author_sort' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<span class="sortfield-area-date sortfield-assign">
<?php echo $this->Paginator->sort('Forum.post_date', 'Date', array( 'direction'=> 'desc', 'title'=>'sort posts by Date', 'class' => ('Forum.post_date' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<span class="sortfield-area-publish sortfield-assign">
<?php echo $this->Paginator->sort('Forum.is_draft', 'UnPublish/Draft', array( 'direction'=> 'desc', 'title'=>'sort posts by UnPublished/Draft', 'class' => ('Forum.is_draft' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<?php if (($readOnlySetting == 0) || ($user_type == 'instructor')) { ?>
<span class="sortfield-area-flag sortfield-assign">
<?php echo $this->Paginator->sort('Forum.is_flag_sort', 'Flag', array( 'direction'=> 'desc', 'title'=>'sort posts by Flag/UnFlag', 'class' => ('Forum.is_flag_sort' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none'))); ?>
</span>
<?php } ?>
</div>

<!-- Listing starts here -->
<ul id="comments">
<?php foreach($posts as $post): ?>

	<li class="cmmnt-ask" id="<?php echo 'qid_'.$post['Forum']['id'];?>">
	<div class="cmmnt-content"><header>
		<div class="header-upper-area">
			<span class="userlink usr-rep">
				<b><a href='javascript:showForumDetail("<?php echo $this->webroot;?>","<?php echo $post["Forum"]["id"]?>","<?php echo $contentPageId;?>")'><?php echo substr(ucfirst($post['Forum']['post_subject']), 0,25).'..';?></a>
				</b>
			</span>- <span class="pubdate">posted on <?php echo date('m-d-Y: h:i A',$post['Forum']['post_date']);?></span>
			<span class="pubdate">By <?php echo ucfirst($post['pleuser']['name']);?></span>
		</div>
		
		<div class="flagpin-post">
		<?php if($post['Forum']['is_draft'] && $post['Forum']['post_by'] == $username): 
		$publish_image = $this->webroot.'img/publish.png';
		?>
		<span class="publish-post">
		<input width="16" type="image" value="Publish Post" label="" id="publishimage_<?php echo $post['Forum']['id']; ?>" class="publish_post" title="publish post" src="<?php echo $publish_image; ?>">
		</span>
		<?php endif;
		//Check if forum setting is enabled or user type is instructor.
		if (($readOnlySetting == 0) || ($user_type == 'instructor')) {
		?>
		<span class="pin-post">
		<?php
		$pinPost = $this->requestAction('forums/checkPostPin/'.$post['Forum']['id']);
		if ($pinPost>0 || $pinPost != '') {
			$image = $this->webroot.'img/unpin.png';
			$title = 'unpin post';
		} else {
			$image = $this->webroot.'img/pin.png';
			$title = 'pin post';
		}
		?>
		<input width="16" type="image" value="<?php echo @$post['Forum']['is_pin']; ?>" label="" id="pinimage_<?php echo $post['Forum']['id']; ?>" class="pinunpin_question" title="<?php echo $title;?>" src="<?php echo $image;?>">
		</span>
		<span class="flag-post-ask">
		<?php
		$flagPost = $this->requestAction('forums/checkPostFlag/'.$post['Forum']['id']);
		if ($flagPost>0 || $flagPost != '') {
			$flagimage = $this->webroot.'img/unflag.png';
			$flagtilte = 'unflag post';
		} else {
			$flagimage = $this->webroot.'img/flag.png';
			$flagtilte = 'flag post';
		}
		?>
		<input width="16" type="image" value="<?php echo @$post['Forum']['is_flag']; ?>" label="" id="flagimage_<?php echo $post['Forum']['id']; ?>" class="flagunflag_question" title="<?php echo $flagtilte; ?>" src="<?php echo $flagimage;?>">
		</span>
      <?php } ?>
		</div>
		</header>
<div class="post-rate-area">
	   <?php
	   $ratingCount = 0;
	   $ratingCount = $this->requestAction('forums/getOverallRate/'.$post['Forum']['id']); 
	   
       //same user can not rate the same post
	  if ($ratingCount) { 
	  	//show the user vote count
	  	$voteCount = $this->requestAction('forums/getUserVoteCount/'.$post['Forum']['id']);
	  	?>
   <div class="Clear">
    <input class="star required" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 1){echo 'checked="checked"';} ?> disabled='disabled' value="1"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>"  <?php if($ratingCount == 2){echo 'checked="checked"';} ?> disabled='disabled' value="2"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 3){echo 'checked="checked"';} ?> disabled='disabled' value="3"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 4){echo 'checked="checked"';} ?> disabled='disabled' value="4"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" <?php if($ratingCount == 5){echo 'checked="checked"';} ?> disabled='disabled' value="5"/>
   <?php    
	  if ($voteCount>1) {
	  	$voteLabel = 'Votes';
	  } else {
	  	$voteLabel = 'Vote';
	  }
	  echo "<span style='font-weight:bold;line-height:19px;' class='voted'>".$voteCount." ".$voteLabel." </span> ";
   ?>
    </div>
  <?php } else { ?>
  
  <div class="Clear">
    <input class="star required" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="1"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>"  disabled='disabled' value="2"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="3"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="4"/>
    <input class="star" type="radio" name="post-rating<?php echo $post['Forum']['id'];?>" disabled='disabled' value="5"/>
    <span style="line-height:19px;" class='voted'>Rate this</span>
  </div>
    
 <?php  }
  $unreadCount = $this->requestAction('forums/showReadUnreadOption/'.$post['Forum']['id'].'/'.$contentPageId); 
		if ($unreadCount) :
 ?>
	<span class="unread_post" id="unread_count_<?php echo $post['Forum']['id'];?>"  title="Unread Posts">
		<?php echo $unreadCount;?> 
	</span>
 <?php endif; ?>
 
 </div>
<div class="post-detail">
	<p><?php 
	    echo $this->Text->truncate($post['Forum']['post_body'], 100, array( 'ellipsis' => '...', 'exact' => true, 'html' => true )); 
	    ?>
	  <input type='image' src= '<?php echo $this->webroot;?>img/view.png' onClick='showForumDetail("<?php echo $this->webroot;?>","<?php echo $post['Forum']['id'];?>","<?php echo $contentPageId; ?>");' value='more' />
	</p>
</div>
	</div>

 <!-- Code start for showing the latest reply -->
	<?php 
	 $lastrecord = $this->requestAction('forums/getLatestReply/'.$post['Forum']['id'].'/'.$contentPageId);  
	if(count($lastrecord)){ $reply = $lastrecord[0]['Forum']; ?>
	<div class="latest-relpy" style="border: 1px solid #000;">
	 <div class="cmmnt-content"><header>
        <span class="pubdate"><b>Reply </b>posted on <?php  echo date('m-d-Y: h:i A',$reply['post_date']);?>
		</span> <span class="pubdate">By <?php echo ucfirst($lastrecord[0]['pleuser']['name']);?>
		</span>
		</header>
	<div class="latest-reply-body"><p><?php echo substr(ucfirst($reply['post_body']), 0, 100).'... '?>
	 <input type='image' src= '<?php echo $this->webroot;?>img/view.png' onClick='showForumDetail("<?php echo $this->webroot;?>","<?php echo $post['Forum']['id'];?>","<?php echo $contentPageId; ?>");' value='more' />
	</p></div>
	 </div>
	</div>
	<?php } ?>
	<!-- Code end for showing the latest reply -->
	</li>

<?php endforeach; ?>
</ul>
</div>
<div class="pagination">

<?php 
// Shows the page numbers. Shows the next and previous links
if ($this->params['paging']['Forum']['pageCount'] > 1) {
  echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
}
echo $this->Paginator->numbers();
if ($this->params['paging']['Forum']['pageCount'] > 1) {
 echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
}

// prints X of Y, where X is current page and Y is number of pages
echo $this->Paginator->counter();
?>
</div>
</div>
<?php else : ?>
<div id="w">
<div class="no-question-avail">
<h1>No Question available</h1>
</div>
</div>
<?php endif; ?>

<!-- Show dialog window -->
<div id="dialog"></div>

<!-- Script will only call for the ask question page layout.
     Script for making the post flag/unflag, pin/unpin, publish by ajax function are defined in 'forum.js' 
 -->
<script type="text/javascript">
$(document).ready(function(){
	 $('.ask-question-area').slimscroll({
		  height: '700px'
	});
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
});
</script>