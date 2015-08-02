<div class="active-session-report-wrapper">
<?php  
echo $this->Form->create('DashboardReports',array('action'=>'activePostForumReport','type' => 'get'));
?>
<div class='member-filter'>
<?php 
$usertype = array('0'=>'All', '1'=>'Instructor', '2' => 'Student');	
echo $this->Form->input('User Type', array('div'=>'control-group', 
		                                 'type' => 'select',
		                                 'selected'=>$selected_user_type, 
										 'options' =>$usertype, 
										// 'empty' => '--Select Member--', 
										 'label' => 'Member Type', 
		                                 'name' => 'usertype',
										 'class'=>'control-label'
										));
?>
</div>
<div class="date-filter">
<?php
echo $this->Form->input('Date Filter', array('name'=>'filter_type', 
											'value'=>$selected_date_filter_type, 
											'class' => 'datefilter',
											'type' => 'radio', 
		                                    'legend' => false,
		                                    'hiddenField'=>false,
											'options' => array('1'=>'Time Of Day', '2'=>'Day Of Week', '3'=>'Date Range'),
											));

?>
<div id="daterange">
<?php 
echo "<div class='control-group'>".$this->Form->input('datetime', array('div'=>'control-qf', 'value'=>$datepickerstartday, 'label' => false, 'class'=>'control-label','id' => 'datepicker-startday', 'name'=>'datepicker-startday'))."</div>";
echo "<div class='control-group'>".$this->Form->input('datetime', array('div'=>'control-qf', 'value'=>$datepickerendday, 'label' => false, 'class'=>'control-label','id' => 'datepicker-endday', 'name'=>'datepicker-endday'))."</div>";
?>
</div>
</div>
<div class="term-course-filter">
<div class='term-filter'>
<?php 
$terms = $this->requestAction(array('controller'=>'ChatReports', 'action'=>'getTermName'));
echo $this->Form->input('terms', array('div'=>'control-group', 
		                                 'type' => 'select',
		                                  'id' =>'terms-cs',
		                                 'selected'=>$selected_term_filter_type, 
										 'options' =>$terms, 
										 'empty' => 'Select Term', 
										 'label' => 'Terms', 
										 'class'=>'control-label',
		                                 'onChange'=>'showCourseHtml()'
										));
?>
</div>

<div class="course-filter">
<?php 
$courses = $this->requestAction(array('controller'=>'ChatReports', 'action'=>'getAllCourses'));
//$courses = array('0'=>'2014_test', '1'=>'2014_test2', '2' => '2014_test3');	
echo $this->Form->input('courses', array('div'=>'control-group', 
		                                 'type' => 'select',
		                                 'selected'=>$selected_course, 
										 'options' =>$courses, 
										 'empty' => 'All', 
										 'label' => 'Courses',
										 'class'=>'control-label'
										));
?>
</div>
</div>
<?php 
echo $this->Form->submit('Submit', array('div'=>'ques-search-btn', 'name'=>'submit', 'title'=>'', 'class'=>'qreply gobutton'));
?>
<div class="report-listing">
			<div class="outer">
				<div class="inner">
					<ul id="active-forum-area">
						<li class="assignment-rmnd-setting">
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('DashboardActiveSettingLogs.name', 'Member Name', array( 'direction'=> 'desc', 'title'=>'sort by member name', 'class' => ('DashboardActiveSettingLogs.name' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('DashboardActiveSettingLogs.user_type', 'Member Type', array( 'direction'=> 'desc', 'title'=>'sort by Member type', 'class' => ('DashboardActiveSettingLogs.user_type' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('DashboardActiveSettingLogs.time', 'Time', array( 'direction'=> 'desc', 'title'=>'sort by time', 'class' => ('DashboardActiveSettingLogs.time' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							 <?php echo $this->Paginator->sort('DashboardActiveSettingLogs.section', 'Section', array( 'direction'=> 'desc', 'title'=>'sort by section', 'class' => ('DashboardActiveSettingLogs.section' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							 <?php echo $this->Paginator->sort('DashboardActiveSettingLogs.course', 'Course', array( 'direction'=> 'desc', 'title'=>'sort by course', 'class' => ('DashboardActiveSettingLogs.course' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							 <?php echo $this->Paginator->sort('DashboardActiveSettingLogs.session', 'Term', array( 'direction'=> 'desc', 'title'=>'sort by term', 'class' => ('DashboardActiveSettingLogs.session' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
                            <div class='report-date-header'>
                             <?php echo $this->Paginator->sort('DashboardActiveSettingLogs.type', 'Type', array( 'direction'=> 'desc', 'title'=>'sort by type', 'class' => ('DashboardActiveSettingLogs.type' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
                            </div>
							<div class="clear"></div>
						</li>
						<?php
						foreach($dashboardactive_logs_results as $data) {
						?>
						<li class="assignment-rmnd-setting">
							<div class='report-name'>
								<span class='asst-img'><img src='<?php echo $this->webroot?>/img/asst.png' /></span>
								<span class="chapter-title"><?php echo ucwords($data['DashboardActiveSettingLogs']['name']);?></span>
							</div>
							<div class='report-date'><?php echo $data['DashboardActiveSettingLogs']['user_type'];?></div>
							<div class='report-date'><?php echo date('m/d/Y h:i:s A', $data['DashboardActiveSettingLogs']['time']);?></div>
							<div class='report-date'><?php echo $data['DashboardActiveSettingLogs']['section'];?></div>
							<div class='report-date'><?php echo $data['DashboardActiveSettingLogs']['course'];?></div>
							<div class='report-date'><?php echo $data['DashboardActiveSettingLogs']['session'];?></div>
                            <div class='report-date'><?php echo ($data['DashboardActiveSettingLogs']['type']) ? 'Forum':'Post';?></div>
							<div class="clear"></div>
						</li>
						<?php } ?>
				
					
					</ul>
					
				</div>
			</div>
</div>
	
<div class="pagination">

<?php 
//Shows the page numbers. Shows the next and previous links
 if ($this->params['paging']['DashboardActiveSettingLogs']['pageCount'] > 1) {
   echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
 }
 echo $this->Paginator->numbers();
 if ($this->params['paging']['DashboardActiveSettingLogs']['pageCount'] > 1) {
  echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
 }

 // prints X of Y, where X is current page and Y is number of pages
 echo $this->Paginator->counter();
?>
</div>
<?php echo $this->Form->end(); 
?>  
</div>