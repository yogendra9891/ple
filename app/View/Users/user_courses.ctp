<?php 
/*
 * template file for showing the courses
 */
?>
<div class="user-courses">
<h1>User Courses</h1>
<?php
foreach($usersCourses as $courses)
echo $this->Html->link($courses, array('controller' => 'chats', 'action' => 'home', $user, $courses), array('class' => 'button')); 

?>
</div>