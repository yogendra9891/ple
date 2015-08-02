<div class="report-wrapper">
<!-- code start for Chat reports-->
<div class="assignment-area">
    <ul id="acc3" class="accordion accordian-common">
        <li>
<!--    <span class="assignment-whatsnew">Assignment Reminders</span> -->
          <h4 class="h"><a class="trigger" href="#">Chat Reports</a></h4>
            <div class="outer">
               <div class="inner" id="content">
               <ul id="comments">
						<li class="unread-postlink" id="testid4">
                             <span class="postlink-rep">
                              <?php echo $this->Html->link('Current members online', array('controller'=>'ChatReports', 'action'=>'currentOnlineReport'))?>
			                  </span>
                            </li>
                            <li class="unread-postlink" id="testid4">
                              <span class="postlink-rep">
                              <?php echo $this->Html->link('Tracking Members Online', array('controller'=>'ChatReports', 'action'=>'trackingMemberOnline'))?>
			                  </span>
                            </li>
                            <li class="unread-postlink" id="testid4">
                              <span class="postlink-rep">
                              <?php echo $this->Html->link('Chat sessions', array('controller'=>'ChatReports', 'action'=>'chatSessionReport'))?>
			                  </span>
                            </li>
                            <li class="unread-postlink" id="testid4">
                              <span class="postlink-rep">
                                <?php echo $this->Html->link('Meeting Invites',array('controller'=>'ChatReports', 'action'=>'meetingInvite'))?>
			                  </span>
                            </li>
						
						
				</ul></div>
			</div>
		</li>
	</ul>
</div>


<!-- code end for chat reports -->

<!-- code start for Forum reports-->
<div class="assignment-area">
    <ul id="acc4" class="accordion accordian-common">
        <li>
<!--    <span class="assignment-whatsnew">Assignment Reminders</span> -->
          <h4 class="h"><a class="trigger" href="#">Forum Reports</a></h4>
            <div class="outer">
               <div class="inner" id="content">
               <ul id="comments">
						
							<li class="unread-postlink" id="testid4">
                              <span class="postlink-rep">
                              Page Forums
			                  </span>
                            </li>
                            <li class="unread-postlink" id="testid4">
                              <span class="postlink-rep">
                             Forum Post Submissions
			                  </span>
                            </li>
                            <li class="unread-postlink" id="testid4">
                              <span class="postlink-rep">
                              Forums Rating
			                  </span>
                            </li>
						
					</ul></div>
			</div>
		</li>
	</ul>
</div>


<!-- code end for Forum reports -->

<!-- code start for Dashboard reports-->
<div class="assignment-area">
    <ul id="acc5" class="accordion accordian-common">
        <li>
<!--    <span class="assignment-whatsnew">Assignment Reminders</span> -->
          <h4 class="h"><a class="trigger" href="#">Dashboard Reports</a></h4>
            <div class="outer">
               <div class="inner" id="content">
               <ul id="comments">
				<li class="unread-postlink" id="testi5">
						    <ul id="acc6" class="accordion accordian-common">
							 <li>
							<!--    <span class="assignment-whatsnew">Assignment Reminders</span> -->
							   <h4 class="h"><a class="trigger" href="#">Customize Dashboards</a></h4>
							     <div class="outer">
							        <div class="inner" id="content">
									 <ul id="lastdashboard">
										<li>
											<span class="postlink-rep">
                                              <?php echo $this->Html->link('Active posts or forum', array('controller'=>'DashboardReports', 'action'=>'activePostForumReport'))?>
			                                </span>
										 </li>
										<li>
											<span class="postlink-rep">
                                              <?php echo $this->Html->link('Assignment Reminder Setting', array('controller' =>'dashboardReports', 'action'=>'assignmentReminderSetting'))?>
			                                </span>
										 </li>
										<li>
											<span class="postlink-rep">
                                              <?php echo $this->Html->link('Reminder Setting', array('controller'=>'DashboardReports', 'action'=>'notificationReminderSettingReport'))?>
			                                </span>
										 </li>
									 </ul>
									</div>
								  </div>
							  </li>
						    </ul>
                    </li>
                            <li class="unread-postlink" id="testi5">
                            
                            	<ul id="acc7" class="accordion accordian-common">
							        <li>
							<!--    <span class="assignment-whatsnew">Assignment Reminders</span> -->
							          <h4 class="h"><a class="trigger" href="#">Instructor Community Setting</a></h4>
							            <div class="outer">
							               <div class="inner" id="content">
												<ul id="lastdashboard">
												 <li>  <?php echo $this->Html->link('Instructor Community Setting', array('controller' =>'dashboardReports', 'action'=>'communitySetting'))?></li>
												
												</ul>
											</div>
										</div>
									</li>
						     </ul>
                            </li>
						
						
					</ul></div>
			</div>
		</li>
	</ul>
</div>


<!-- code end for Dashboard reports -->
</div>