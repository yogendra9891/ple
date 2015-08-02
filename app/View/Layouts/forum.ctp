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

?>
<!DOCTYPE html>
<html>
<head>
<?php echo $this->Html->charset(); ?>
<title><?php echo 'PLE' ?></title>

<!-- css+js -->
<?php echo $this->Html->css('forum');?>
<link rel='stylesheet' href='<?php echo $this->webroot;?>css/jquery-ui.css'>
<script src='<?php echo $this->webroot;?>js/scripts/jquery-1.7.2.js'></script>
<script src='<?php echo $this->webroot;?>js/rating.js'></script>
<script src='<?php echo $this->webroot;?>js/jquery-ui-latest.js'></script>
<script src='<?php echo $this->webroot;?>js/jquery.rating.js'></script>
<script src='<?php echo $this->webroot;?>js/ckeditor/ckeditor.js'></script>
<script src="<?php echo $this->webroot;?>js/jquery.msgBox.js" type="text/javascript"></script>
<link href="<?php echo $this->webroot;?>css/msgBoxLight.css" rel="stylesheet" type="text/css">
<link href="<?php echo $this->webroot;?>css/jquery.rating.css" rel="stylesheet" type="text/css">
<script src='<?php echo $this->webroot;?>js/jquery.slimscroll.js'></script>
<?php echo $this->Html->script('forum');?>
</head>

<!-- Body starts here -->
<body>
<div id="container-iframe">
<div id="header"></div>
<div id="content-iframe" class="content-iframe-outer">
<?php
//get the message in array
$msgs = $this->Session->read('Message');

//check for messages count
$message = (count($msgs)) ? $msgs['flash']['message'] : "";
?>

<script type='text/javascript'>
var message_text = "";

//assign the value in js global variable
message_text = "<?php echo $message; ?>";
</script>

<?php
//check for session
$username = $this->Session->read('UserData.userName');
echo $this->Session->flash(); ?> <?php echo $this->fetch('content'); 
?>
</div>

<!-- footer starts here -->
<div id="footer"></div>
</div>
<?php //echo $this->element('sql_dump');  @TODO remove in the future ?>
</body>
</html>
