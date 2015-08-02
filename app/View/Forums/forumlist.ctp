<?php
//get userName from session 
$username = $this->Session->read('UserData.userName');

//get site url
$site_url = $this->webroot;
?>
<div class='wrap-all'>
	<div class='topmenu'>
		<ul>
			<li id='homef'><?php echo $this->Html->link('Questions',array('controller'=>'forums','action'=>'forumlist',$contentPageId))?></li>
			<li id='askf' onClick="showHideQuesBox('<?php echo $site_url;?>','<?php echo $contentPageId;?>');">Ask Question</li>
			<li id='fqf' onClick="showHideFilterBox('<?php echo $site_url;?>','<?php echo $contentPageId;?>');">Filter Posts</li>
		</ul>
		
<!-- Gloabl Search button -->
		<div class='gb-search'>
			<div id="w-search">
				<?php 
				echo $this->Form->create('forums',array('action'=>'searchAll', 'type'=>'get', 'onsubmit'=>'return formSubmit();'));
				@$searchdata = $this->request->query['searchData'];
				echo $this->Form->input('Search',array('div'=>'search-field', 'name'=>'searchData', 'title'=>'Search questions', 'value'=>$searchdata, 'type'=>'text','size'=>'70','label' => false,'id'=>'forumSearchText'));
				echo $this->Form->button('Search', array('type' => 'button','div'=>'ques-search-btn', 'name'=>'submit', 'title'=>'Search questions', 'class'=>'qreply gobutton','onClick'=>'searchAll('.$this->webroot.');'));
				echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden','id'=>'globalContId'));
				echo $this->Form->end();
				?>
			</div>
		</div>
		
<!-- End Of GLobal Search -->

<!-- Show Subscribe/Unsubscribe Button -->
		<div class="question-heading">
			<span style="float: right;"><div id="w-subscribe">
					<?php 
					echo $this->Form->create('forums',array('action'=>'subscribeForum',));
					$subscribe_value =  $this->requestAction('forums/subscribeForumValue/'.$contentPageId);
					if($subscribe_value){
						$subscribetitle = 'Unubscribe Forum';
						$subscribeimage = $this->webroot.'img/unsubscribe.png';
					}
					else{
						$subscribetitle = 'Subscribe Forum';
						$subscribeimage = $this->webroot.'img/subscribe.png';
					}
					
					//show loader image
					echo "<img id='subscribe_loader' src='".$this->webroot."/img/ajax-loader.gif'/>";
					echo $this->Form->submit('subscribe/unsubscribe forum',array('div'=>'subscribe-field', 'id'=>'subid', 'type'=>'image', 'src'=>$subscribeimage, 'name'=>'subscribe', 'title'=>$subscribetitle, 'label' => false, 'onClick'=>'showSubscribeLoader();'));
					echo $this->Form->input('',array('type'=>'hidden','name'=>'subscribe_value', 'value'=>$subscribe_value, 'title'=>'','label' => false));
					echo $this->Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
					echo $this->Form->end();
					?>
				 </div> 
				</span>
		</div>
		
<!-- End Subscribe/Unsubscribe Button -->
		
	</div>
	
<!-- Left area starts here -->
	
	<div class='leftarea' id="leftarea-scroll">
		<iframe id="iframe1"
			src='<?php echo $this->webroot;?>forums/askQuestion/<?php echo $contentPageId;?>'
			width='400' scrolling="no" onLoad="autoResize('iframe1');"></iframe>
		<div class='resizer'>....</div>
	</div>
	
<!-- Left area ends here -->
	
<!-- Right area starts here -->
	
	<div class='rightarea'>
	<!--Loader Image -->
	<div id='loader' style='text-align:center'>
       <img src='<?php echo $this->webroot."/img/loader.gif"?>' />
     </div>
     <div id='forumDetailArea' class='forumDetailClass'>
		<iframe id="iframe4" src='<?php echo $this->webroot;?>forums/forumFilter/<?php echo $contentPageId;?>' width='400' height="700" onLoad="autoResize('iframe4');"></iframe>
		</div>
	</div>
	
<!-- Right area ends here -->
	
<!-- Show dialog window -->
	<div id="dialog1"></div>
	</div>
	
<!--  Script will only call for the ask question page layout. Script for making the post flag/unflag, pin/unpin, 
       publish by ajax function are defined in 'forum.js'
 -->
<script type="text/javascript">
$(document).ready(function(){
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
      //@TODO check if required
	 }else{
	 $('#forumDetailArea').removeClass('forumDetailClass');
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

/**
 * Submit the form when user click on enter
 */
function formSubmit(){
	searchAll('<?php echo $this->webroot;?>');
	return false;
}
</script>