<script src='<?php echo $this->webroot;?>js/groupie.js'></script>
<script>
window.onload = function(e){

               Groupie.room = "<?php echo $room_name;?><?php echo $roomHostName;?>";
                Groupie.nickname = '<?php echo $user ;?>';

                $(document).trigger('connect', {
                    jid: '<?php echo $user ;?><?php echo $hostName;?>',
                    password:'123456' 
                });
           $('#room-name').html(Groupie.room); //set the roomid

           $('#imoticons').click(function(){ //open the emoticons popup
               $('#smileyarea').toggle();
             });           


        $(document).click(function(e) {
           var t = (e.target);
               if(t!= $("#imoticons").get(0) &&  t!=$("#smileyarea").get(0)) {
                   $("#smileyarea").hide();
               }
               
               if(t==$("#smileyarea").get(0)) {
                   $("#smileyarea").hide();
               }
       });
        $("#email_chatt").on('click', function(){
      	  emailChat(Groupie.room);
      	});
        //code for slim scrollbar
    	$('#chat').slimscroll({
    		 height: '240px'
    		});
    	$('#roster-area-group-inner').slimscroll({
    		  height: '280px'
    	});
    	$('#participants-inner').slimscroll({
     		  height: '282px'
     	});
    	$.ajaxSetup({ cache: false }); //removing the browser cache......
}
 setInterval(getRoomUsers,15000);//fucntion calling for getting the current users of the chat room. sending the ajax on a interval.
 setInterval(showUsersforInvitation,15000);
</script>

    <div id='toolbar'>
     <div class="toolbar-inner">
     <input title="Start chat" type="image" src="<?php echo $this->webroot;?>img/icon_chat.png" alt='show_chat' onClick="showChat()" />
     <input title="Add users for group chat" type="image" src="<?php echo $this->webroot;?>img/add-groupusers.png" alt='add_users' onClick="showNewUsers()" />
     <input  title="Chat users" type="image" src="<?php echo $this->webroot;?>img/group_users.png" alt='joined_users' onClick="showJoinedUsers('<?php echo $room_name;?>')" />
     <input title="Email Chat" id="email_chatt" type="image" src="<?php echo $this->webroot;?>img/email.png" alt='email_chat' onClick="emailChat('<?php echo $room_name;?>')" style="width: 24px;"/>
     <input title="Sending Email" id="email_loader" type="image" src="<?php echo $this->webroot;?>img/loader.gif" alt='email_loader' style="width: 24px; display:none;" />
     </div>
     <div class="toolbar-inner2">
     <input title="Minimize" id='minimise' type='image' src="<?php echo $this->webroot;?>img/min.png" alt='min' onClick="minmiseRoom('<?php echo $room_name;?>')" />
     <input title="Leave from chat" id='leave' type='image' src="<?php echo $this->webroot;?>img/cross.png" alt='leave' onClick="leaveRoom('<?php echo $room_name;?>')" />
     </div>
    </div>

<!-- code edit by yogendra -->

<div id='roster-area-group'>
	<div id="roster-area-group-inner">
		<div class="add_in_group"> <a href="javascript:void(0);" id="add_rosters_ingroup" title="add users">
		  <img src="<?php echo $this->webroot.'img/join.png';?>" height="14px;" /> </a>
		</div>
		<ul class="online_users_list"></ul>
	</div>
</div>

<div id='participants'>
 <div id='participants-inner'>
     <p>Current Chat Users</p>
        <ul id='participant-list'>
        </ul>
 </div>
</div>

 <div>
         <div id='room-name' style="display: none;"></div>
          <?php
          $userCourse = $this->Session->read('UserData.usersCourses');
          $user_course_section = $userCourse[0];
          //get Course and section name
          $course_info = $this->requestAction(array('controller'=>'chats','action'=>'getCourseNameOfUser', $user_course_section));
          $course_name = $course_info->course_name;
          $course_section = $course_info->section_name;
          $new_room = explode('_', $room_name); 
          ?>
          <div class='room-name'><?php echo ucfirst($course_name).'-'.date('m/d/Y/h:i:s A', $new_room[1])?></div>
          <div id='room-topic'></div>
        </div>
        
<!-- code edit by yogendra end. -->
<div id='chat-area-<?php echo $room_name;?>'>
      <div id='chat-area'>
        <div id='chat'>
        </div>
<div id="smileyarea" style="display:none;">
<table width="100" border="0" cellspacing="0" cellpadding="5">
<tr align="center" valign="middle">
<td><a href="javascript:void(0);" onclick="emoticon(':D')"><img src="<?php echo $this->webroot.'img/smiley/icon_biggrin.gif'; ?>" border="0" alt=":D" title="Very Happy"></a></td>
<td><a href="javascript:emoticon(':)')"><img src="<?php echo $this->webroot.'img/smiley/icon_smile.gif'; ?>" border="0" alt=":)" title="Smile"></a></td>
<td><a href="javascript:emoticon(':(')"><img src="<?php echo $this->webroot.'img/smiley/icon_sad.gif'; ?>" border="0" alt=":(" title="Sad"></a></td>
<td><a href="javascript:emoticon(':o')"><img src="<?php echo $this->webroot.'img/smiley/icon_surprised.gif'; ?>" border="0" alt=":o" title="Surprised"></a></td>
<td><a href="javascript:emoticon(':shock:')"><img src="<?php echo $this->webroot.'img/smiley/icon_eek.gif'; ?>" border="0" alt=":shock:" title="Shocked"></a></td>
</tr>
<tr align="center" valign="middle">
<td><a href="javascript:emoticon(':?')"><img src="<?php echo $this->webroot.'img/smiley/icon_confused.gif'; ?>" border="0" alt=":?" title="Confused"></a></td>
<td><a href="javascript:emoticon('8)')"><img src="<?php echo $this->webroot.'img/smiley/icon_cool.gif'; ?>" border="0" alt="8)" title="Cool"></a></td>
<td><a href="javascript:emoticon(':lol:')"><img src="<?php echo $this->webroot.'img/smiley/icon_lol.gif'; ?>" border="0" alt=":lol:" title="Laughing"></a></td>
<td><a href="javascript:emoticon(':x')"><img src="<?php echo $this->webroot.'img/smiley/icon_mad.gif'; ?>" border="0" alt=":x" title="Mad"></a></td>
<td><a href="javascript:emoticon(':P')"><img src="<?php echo $this->webroot.'img/smiley/icon_razz.gif'; ?>" border="0" alt=":P" title="Razz"></a></td>
</tr>
<tr align="center" valign="middle">
<td><a href="javascript:emoticon(':red:')"><img src="<?php echo $this->webroot.'img/smiley/icon_redface.gif'; ?>" border="0" alt=":red:" title="Embarassed"></a></td>
<td><a href="javascript:emoticon(':cry:')"><img src="<?php echo $this->webroot.'img/smiley/icon_cry.gif'; ?>" border="0" alt=":cry:" title="Crying"></a></td>
<td><a href="javascript:emoticon(':evil:')"><img src="<?php echo $this->webroot.'img/smiley/icon_evil.gif'; ?>" border="0" alt=":evil:" title="Evil or Very Mad"></a></td>
<td><a href="javascript:emoticon(':twisted:')"><img src="<?php echo $this->webroot.'img/smiley/icon_twisted.gif'; ?>" border="0" alt=":twisted:" title="Twisted Evil"></a></td>
<td><a href="javascript:emoticon(':roll:')"><img src="<?php echo $this->webroot.'img/smiley/icon_rolleyes.gif'; ?>" border="0" alt=":roll:" title="Rolling Eyes"></a></td>
</tr>
<tr align="center" valign="middle">
<td><a href="javascript:emoticon(':wink:')"><img src="<?php echo $this->webroot.'img/smiley/icon_wink.gif'; ?>" border="0" alt=":wink:" title="Wink"></a></td>
<td><a href="javascript:emoticon(':!:')"><img src="<?php echo $this->webroot.'img/smiley/icon_exclaim.gif'; ?>" border="0" alt=":!:" title="Exclamation"></a></td>
<td><a href="javascript:emoticon(':q')"><img src="<?php echo $this->webroot.'img/smiley/icon_question.gif'; ?>" border="0" alt=":q" title="Question"></a></td>
<td><a href="javascript:emoticon(':idea:')"><img src="<?php echo $this->webroot.'img/smiley/icon_idea.gif'; ?>" border="0" alt=":idea:" title="Idea"></a></td>
<td><a href="javascript:emoticon(':arrow:')"><img src="<?php echo $this->webroot.'img/smiley/icon_arrow.gif'; ?>" border="0" alt=":arrow:" title="Arrow"></a></td>
</tr>
</table>
</div>
        <div class="chat-textarea"> <textarea id='input'></textarea>
		 <img src="<?php echo $this->webroot.'img/smiley/happy.png'; ?>" id="imoticons" />
		</div>
      
      </div>
 </div>
