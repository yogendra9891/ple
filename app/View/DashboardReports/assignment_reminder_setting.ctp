<div class="report-wrapper">
<?php  
echo $this->Form->create('DashboardReports',array('action'=>'assignmentReminderSetting','type' => 'get'));
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
<div id="datetime">
<?php 
echo "<div class='control-group'>".$this->Form->input('datetime', array('div'=>'control-qf', 'value'=>$datepickertime, 'label' => false, 'class'=>'control-label','id' => 'datepicker-time', 'name'=>'datepicker-time'))."</div>";
?></div>
<div id="dateonly">
<?php echo "<div class='control-group'>".$this->Form->input('date', array('div'=>'control-qf', 'value'=>$datepickerday, 'label' => false, 'class'=>'control-label','id' => 'datepicker-day', 'name'=>'datepicker-day'))."</div>";
?>
</div>
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
echo $this->Form->end();
?>
<div class="report-listing">
			<div class="outer">
				<div class="inner">
					<!-- get assignment of this module -->
					<!-- @TODO currently fetching by id. Later it will be replaced by pleserver id -->
					<ul id="active-forum-area">
						<li class="assignment-rmnd-setting">
							<div class='report-name'>
							<?php echo $this->Paginator->sort('AssignmentReminderLog.name', 'Member Name', array( 'direction'=> 'desc', 'title'=>'sort by member name', 'class' => ('AssignmentReminderLog.name' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('AssignmentReminderLog.user_type', 'Member Type', array( 'direction'=> 'desc', 'title'=>'sort by member role', 'class' => ('AssignmentReminderLog.user_type' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('AssignmentReminderLog.time', 'Setting time', array( 'direction'=> 'desc', 'title'=>'sort by online time', 'class' => ('AssignmentReminderLog.time' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('AssignmentReminderLog.section', 'Section', array( 'direction'=> 'desc', 'title'=>'sort by section', 'class' => ('AssignmentReminderLog.section' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
	                        </div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('AssignmentReminderLog.course', 'Course', array( 'direction'=> 'desc', 'title'=>'sort by course', 'class' => ('AssignmentReminderLog.course' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
	                       </div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('AssignmentReminderLog.session', 'Term', array( 'direction'=> 'desc', 'title'=>'sort by term', 'class' => ('AssignmentReminderLog.session' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
	                       </div>
							<div class="clear"></div>
						</li>
						<?php 
						foreach($datas as $data) {
						?>
						<li class="assignment-rmnd-setting">
							<div class='report-name'>
								<span class='asst-img'><img
									src='<?php echo $this->webroot?>/img/asst.png' />
								</span>
								<span class="chapter-title"><?php echo ucfirst($data['AssignmentReminderLog']['name']);?></span>
							</div>
							<div class='report-date'><?php echo ucfirst($data['AssignmentReminderLog']['user_type']);?></div>
							<div class='report-date'><?php echo date('m/d/Y h:i:s A', $data['AssignmentReminderLog']['time']); ?></div>
							<div class='report-date'><?php echo ucfirst($data['AssignmentReminderLog']['section']);?></div>
							<div class='report-date'><?php echo $data['AssignmentReminderLog']['course'];?></div>
							<div class='report-date'><?php echo $data['AssignmentReminderLog']['session'];?></div>
							<div class="clear"></div>
						</li>
						<?php } ?>
				
					
					</ul>
					
				</div>
			</div>
</div>
<!--Pagination starts here -->
<div class="pagination">
<?php 
// Shows the page numbers. Shows the next and previous links

if ($this->params['paging']['AssignmentReminderLog']['pageCount'] > 1) {
 echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
}
echo $this->Paginator->numbers();
if ($this->params['paging']['AssignmentReminderLog']['pageCount'] > 1) {
 echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
}


// prints X of Y, where X is current page and Y is number of pages
echo $this->Paginator->counter();

?>
</div>
<!-- Pagination ends here -->
</div>
