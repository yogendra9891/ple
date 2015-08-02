<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
<?php 
$userCourse = $this->Session->read('UserData.usersCourses');
$user_course_section = $userCourse[0];
//get Course and section name
$course_info = $this->requestAction(array('controller'=>'chats','action'=>'getCourseNameOfUser', $user_course_section));
$course_name = $course_info->course_name;
$course_section = $course_info->section_name;
?>
<script>
//initialise the site url
var site_url = "<?php echo $siteUrl;?>";
//below site url is using in js file for ajax call 
var site_url1 = "<?php echo $this->webroot;?>";
var bosh_url = "<?php echo $boshUrl;?>";
var userCourse = "<?php echo $course_name;?>";
</script>
<?php echo $this->Html->charset(); ?>
<title><?php //echo $cakeDescription ?>: <?php //echo $title_for_layout; ?>
</title>
<?php
echo $this->Html->css('gab');
echo $this->Html->css('groupie');
?>
<link rel='stylesheet' href='<?php echo $this->webroot;?>css/jquery-ui.css'>
<script src='<?php echo $this->webroot;?>js/scripts/jquery-1.7.2.js'></script>
<script src='<?php echo $this->webroot;?>js/jquery-ui.js'></script>
<script src='<?php echo $this->webroot;?>js/scripts/strophe.js'></script>

<script src='<?php echo $this->webroot;?>js/scripts/jquery.tinysort.js'></script>

<script src='<?php echo $this->webroot;?>js/groupchat.js'></script>
<script src='<?php echo $this->webroot;?>js/meeting.js'></script>
<script src='<?php echo $this->webroot;?>js/jquery.slimscroll.js'></script>
<script src="<?php echo $this->webroot;?>js/jquery.msgBox.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot;?>css/msgBoxLight.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
<div id="header"></div>
<div id="content">

<!--<div id = "loadContainer" style="border:1px solid red">-->
<!--<span style="background-color:#000;">asqaw</span>-->
<!--</div>-->
<?php
//check for session
$username = $this->Session->read('UserData.userName');
if($username){
?>
<div class="logout">
<?php 
//id "disconnect" is used to logout the user from openfire 
// echo $this->Html->link(
//     'Logout',
//     array('controller' => 'users', 'action' => 'logOut', 'full_base' => true),
//     array('id' => 'disconnect','class' => 'logOutClass')
// );
?>
</div>
<?php }
?>
<?php echo $this->Session->flash(); ?> <?php echo $this->fetch('content'); ?>
</div>
<div id="footer"></div>
</div>

<?php 
//echo $this->element('sql_dump'); 
?>
</body>
</html>
