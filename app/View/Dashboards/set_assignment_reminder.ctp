<div class="reminder-settings">
	<h3>
		<p>Assignment Reminder</p>
	</h3>
	<span class="course-name"><?php echo 'Course - '.ucfirst($course);?></span>
	<?php echo $this->Form->create('dashboards', array('id' => 'assignment_setting_form', 'action' => 'saveAssignmentReminder')); ?>
	<ul id="asst-acc" class="accordion accordian-common">
		<?php foreach ($modules as $module) { 
		$mid = $module['PleAssignment']['module_uuid'];
			?>
		<li>
			<h4 class="h">
				<a class="trigger" href="#"><?php echo ucfirst($module['PleAssignment']['module_title']); ?>
				</a>
			</h4>
			<div class="outer">
				<div class="inner">
					<!-- get assignment of this module -->
					<!-- @TODO currently fetching by id. Later it will be replaced by pleserver id -->
					<?php $assignments = $this->requestAction('dashboards/getAssignemnts/'.$module['PleAssignment']['module_uuid'])?>
					<ul id="active-forum-area">
						<li class="assignment-rmnd-setting">
							<div class='asst-name'>Assignments</div>
							<div class='asst-date-header'>Due Date</div>
							<div class='asst-set'>
							 <div class="reminder-due"><p>Your Reminder</p></div>
								<!-- set reminder setting -->
								<div class='asst-chkbox'>Due Date</div>
								<div class='asst-chkbox'>Day Before</div>
								<div class='asst-chkbox'>Week Before</div>
								<div class='asst-calender-header'>Set Date</div>
							</div>
							
						</li>
						<?php 
					 foreach( $assignments as $assignment ){
					 	$id = $assignment['PleAssignment']['assignment_uuid'];
					 	
					 	//get setting for each assignment
					 	 $setting = $this->requestAction('dashboards/loadAssignmentSetting/'.$id.'/'.$mid);
					 	 $sid = $setting['id'];
					 	 $due_date = $setting['due_date'];
					 	 $due_checked = ($due_date == 1) ?  "checked = 'checked'" : "";
					 	 $day_before = $setting['day_before'];
					 	 $day_checked = ($day_before == 1) ?  "checked = 'checked'" : "";
					 	 $week_before = $setting['week_before'];
					 	 $week_checked = ($week_before == 1) ?  "checked = 'checked'" : "";
					 	 $set_date = $setting['on_date'];
						 $show_set_date = empty($set_date) ? "mm/dd/yy" : $set_date;
					 	 $radio = $setting['setting_type'];
					 	?>
						<li class="assignment-rmnd-setting">
							<div class='asst-name'>
								<span class='asst-img'><img
									src='<?php echo $this->webroot?>/img/asst.png' />
								</span>
								<span class="chapter-title"><?php echo $assignment['PleAssignment']['assignment_title']; ?></span>
								<a href="javascript:void(0)" class='editField' id="<?php echo 'editField-'.$id; ?>">Edit</a>
							</div>
							<div class='asst-date'>
								<?php if ($assignment['PleAssignment']['assignment_duedate'] != null) { echo date('m/d/y', strtotime($assignment['PleAssignment']['assignment_duedate']));} else { echo "NA"; } 
								
								echo $this->Form->input('adate', array('type' => 'hidden', 'id' => 'atitle-'.$id, 'name'=>"data[infos][$id][assignment_title]", 'value' =>$assignment['PleAssignment']['assignment_title']));
								echo $this->Form->input('adate', array('type' => 'hidden', 'id' => 'adate-'.$id, 'name'=>"data[infos][$id][assignment_date]", 'value' =>$assignment['PleAssignment']['assignment_duedate']));
								echo $this->Form->input('adate', array('type' => 'hidden', 'id' => 'adate2-'.$id, 'value' =>date('m/d/Y', strtotime($assignment['PleAssignment']['assignment_duedate']))));
								?>
							</div>
							<div class='asst-set'>
							  
								<!-- set reminder setting -->
								<input type='hidden' value='0' name="data[infos][<?php echo $id;?>][duedate]" />
								<input type='hidden' value='0' name="data[infos][<?php echo $id;?>][daybefore]" /> 
								<input type='hidden' value='0' name="data[infos][<?php echo $id;?>][weekbefore]" /> 
								<div id='locked-ckkbox-<?php echo $id ?>' class='locked-class-ckkbox'>
								<input class='asst-chkbox' type='checkbox' value='1'  disabled='disabled' name="data[infos][<?php echo $id;?>][duedate]" <?php echo $due_checked; ?>/> 
								<input class='asst-chkbox' type='checkbox' value='1'  disabled='disabled' name="data[infos][<?php echo $id;?>][daybefore]" <?php echo $day_checked; ?>/> 
								<input class='asst-chkbox' type='checkbox' value='1'  disabled='disabled' name="data[infos][<?php echo $id;?>][weekbefore]" <?php echo $week_checked; ?>/>
								</div>
								<div id='open-chkbox-<?php echo $id ?>' class='open-class-ckkbox'>
								<input class='asst-chkbox' type='checkbox' value='1' name="data[infos][<?php echo $id;?>][duedate]" <?php echo $due_checked; ?>/> 
								<input class='asst-chkbox' type='checkbox' value='1' name="data[infos][<?php echo $id;?>][daybefore]" <?php echo $day_checked; ?>/> 
								<input class='asst-chkbox' type='checkbox' value='1' name="data[infos][<?php echo $id;?>][weekbefore]" <?php echo $week_checked; ?>/>
							    </div>
							    <div class='asst-calender'>
								<!-- set date setting -->
								<?php echo "<div id='locked-reminder-date-$id' class='locked-reminder-date'>". $show_set_date ."</div>";
								      echo $this->Form->input('', array('div'=>array('id' =>'reminder-date-'.$id, 'class' => 'reminder-date'), 'type'=>'text', 'value'=>$set_date ,'id'=>'setdate-'.$id, 'label' => false, 'name'=> "data[infos][$id][setdate]", 'size'=>'6', 'class' => 'asst-datepicker')); 
								      echo $this->Form->input('mid', array('type' => 'hidden', 'value' => $mid, 'name'=>'data[infos]['.$id.'][module_id]'));
								      echo $this->Form->input('aid', array('type' => 'hidden', 'value' => $id, 'name'=>'data[infos]['.$id.'][assignment_id]'));
								      echo $this->Form->input('id', array('type' => 'hidden', 'value' => $sid, 'name'=>'data[infos]['.$id.'][id]'));
								?>
							    </div>
							</div>
							
							
						</li>
						<?php	
					 }
					 ?>
					</ul>
					
				</div>
			</div>
		</li>
		<?php } ?>
	</ul>
	<div class='backButton'>
	
	<?php 
	echo $this->Form->submit('Save', array('class'=> 'gobutton_outer'));
	echo $this->Form->button('Clear All', array( 'class'=>'gobutton_outer', 'onClick' => 'return clearAssignmentSetting();'));
	echo $this->Form->end(); 
	?>
	<a class='gobutton_outer' href='javascript:history.go(-1)' >Done</a>
	</div>
</div>

<script type='text/javascript'>
$('.editField').click(function(){
    var idString = $(this).attr('id');
    var id = idString.split("-");
	var cdate =  $('#adate2-'+id[1]).val();
	if(cdate != "01/01/1970") {
    $('#locked-ckkbox-'+id[1]).toggle();
    $('#open-chkbox-'+id[1]).toggle();
	}
	$('#reminder-date-'+id[1]).toggle();
    $('#locked-reminder-date-'+id[1]).toggle();
    $('#'+idString).toggleClass('activelink');
	});
$(document).ready(function(){
	 $('#flashMessage').delay(3000).fadeOut();
});

</script>
