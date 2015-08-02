<?php
//initialize the variables
$term = '';
$term_action = '';
$course = '';
$membertype = '';
?>
<div class="current-online-report-wrapper">
 <div class="current-online-report-filter-area">
	 <?php echo $this->Form->create('chatreports', array('id'=>'current-online-fileter-form', 'action'=>'currentOnlineReport'));
	 //echo "<pre>"; pr($online_logs_results); echo "</pre>";
	?>
<div id="current-onlinusers-lists" class="current-onlinusers-lists">

 <h3>Current Online Users Report</h3>
	  <div class="filter-term-course-type">
	  		<div class="selectbox-termlist" id="selectbox-termlist">
	  		    <?php 
	  		    if (isset($this->passedArgs['term']) && !empty($this->passedArgs['term'])) {
	  		    	$term = $this->passedArgs['term'];
	  		    	$term_action = '/'.$term;
	  		    }	
	  		    $terms = $this->requestAction('chatreports/getTermName');
	  		    echo $this->Form->input('term', array('div'=>'control-group',
	  		    		'type' => 'select',
	  		    		'selected'=>$term,
	  		    		'options' =>$terms,
	  		    		'empty' => 'Select Term',
	  		    		'label' => 'Terms',
	  		    		'class'=>'control-label',
	  		    		'id' =>'current-termlist'
	  		    ));
	  		    ?>

			</div>		
	  <div class="selectbox-courselist" id="selectbox-courselist">
		  		<?php
		  		if (isset($this->passedArgs['course']) && !empty($this->passedArgs['course']))
		  			$course = $this->passedArgs['course'];
		  		 $courses = $this->requestAction('chatreports/getCoursesNameArray'.$term_action);
                 echo $this->Form->input('course', array('div'=>'control-group', 
		                                 'type' => 'select',
		                                 'selected'=>$course, 
										 'options' =>$courses, 
										 'empty' => 'Select Course', 
										 'label' => 'Courses', 
										 'class'=>'control-label',
                 						 'id'=> 'current-courselist'
										));
                ?>
			</div>
			
	
	  		<div class="selectbox-membertypelist" id="selectbox-membertypelist">
	  		<?php     
	  		if (isset($this->passedArgs['membertype']) && !empty($this->passedArgs['membertype']))
	  			$membertype = $this->passedArgs['membertype'];
	  		
	  		$usertype = array('instructor'=>'Instructor', 'student' => 'Student');	
                echo $this->Form->input('membertype', array('div'=>'control-group', 
		                                 'type' => 'select',
		                                 'selected'=>$membertype, 
										 'options' =>$usertype, 
										 'empty' => '-Select Member-', 
										 'label' => 'Member Type', 
										 'class'=>'control-label',
		                                 'id'=>'current-memberlist'
										));
?>

			</div>
			</div>
 </div>		


	<?php 
	echo $this->Form->submit('Submit', array('class'=> 'gobutton_outer', 'name'=>'save'));?>
<div class="report-listing">
			<div class="outer">
				<div class="inner">
					<!-- get assignment of this module -->
					<!-- @TODO currently fetching by id. Later it will be replaced by pleserver id -->
					<ul id="active-forum-area">
						<li class="assignment-rmnd-setting">
							<div class='report-name'>
							<?php echo $this->Paginator->sort('ChatCurrentOnlineLog.user_name', 'Member Name', array( 'direction'=> 'desc', 'title'=>'sort by member name', 'class' => ('ChatCurrentOnlineLog.user_name' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('ChatCurrentOnlineLog.user_role', 'Member Role', array( 'direction'=> 'desc', 'title'=>'sort by member role', 'class' => ('ChatCurrentOnlineLog.user_role' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							<?php echo $this->Paginator->sort('ChatCurrentOnlineLog.time', 'Online time', array( 'direction'=> 'desc', 'title'=>'sort by time', 'class' => ('ChatCurrentOnlineLog.time' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							 <?php echo $this->Paginator->sort('ChatCurrentOnlineLog.section', 'Section', array( 'direction'=> 'desc', 'title'=>'sort by section', 'class' => ('ChatCurrentOnlineLog.section' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							 <?php echo $this->Paginator->sort('ChatCurrentOnlineLog.course', 'Course', array( 'direction'=> 'desc', 'title'=>'sort by course', 'class' => ('ChatCurrentOnlineLog.course' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class='report-date-header'>
							 <?php echo $this->Paginator->sort('ChatCurrentOnlineLog.session', 'Term', array( 'direction'=> 'desc', 'title'=>'sort by term', 'class' => ('ChatCurrentOnlineLog.session' == $this->Paginator->sortKey() ? 'sorting-direction-'.$this->Paginator->sortDir() : 'none')));?>
							</div>
							<div class="clear"></div>
						</li>
						<?php
						foreach($online_logs_results as $data) {
						?>
						<li class="assignment-rmnd-setting">
							<div class='report-name'>
								<span class='asst-img'><img src='<?php echo $this->webroot?>/img/asst.png' /></span>
								<span class="chapter-title"><?php echo ucwords($data['ChatCurrentOnlineLog']['user_name']);?></span>
							</div>
							<div class='report-date'><?php echo ucfirst($data['ChatCurrentOnlineLog']['user_role']);?></div>
							<div class='report-date'><?php echo date('m/d/Y h:i:s A', $data['ChatCurrentOnlineLog']['time']);?></div>
							<div class='report-date'><?php echo $data['ChatCurrentOnlineLog']['section'];?></div>
							<div class='report-date'><?php echo ucfirst($data['ChatCurrentOnlineLog']['course']);?></div>
							<div class='report-date'><?php echo $data['ChatCurrentOnlineLog']['session'];?></div>
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
if ($this->params['paging']['ChatCurrentOnlineLog']['pageCount'] > 1) {
  echo $this->Paginator->prev('« Previous', null, null, array('class' => 'disabled'));
}
echo $this->Paginator->numbers();
if ($this->params['paging']['ChatCurrentOnlineLog']['pageCount'] > 1) {
 echo $this->Paginator->next('Next »', null, null, array('class' => 'disabled'));
}

// prints X of Y, where X is current page and Y is number of pages
echo $this->Paginator->counter();
?>
</div>
<?php echo $this->Form->end(); 
	?>  

 </div>
</div>