<?php
/**
 * PHP 5
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
<?php echo $this->Html->charset(); 
?>
<script>
//initialise the site url
var site_url1 = "<?php echo $this->webroot;?>";
<?php 
//getting the facebook appid, app secret from bootstrap
$app_id = Configure::read('APPID');
?>
var fb_appid = "<?php echo $app_id;?>";
</script>
<title><?php echo 'PLE' ?></title>
<link rel='stylesheet' href='<?php echo $this->webroot;?>css/jquery-ui.css'>
<link rel='stylesheet' href='<?php echo $this->webroot;?>css/dashboard.css'>
<link rel='stylesheet' href='<?php echo $this->webroot;?>css/report.css'>
<link rel='stylesheet' href='<?php echo $this->webroot;?>css/jquery.datetimepicker.css'>
<script src='<?php echo $this->webroot;?>js/scripts/jquery-1.7.2.js'></script>
<script src='<?php echo $this->webroot;?>js/jquery-ui.js'></script>
<script src='<?php echo $this->webroot;?>js/datepicker/jquery.datetimepicker.js'></script>
<script src='<?php echo $this->webroot;?>js/jquery_accordian.js'></script>
<script src="<?php echo $this->webroot;?>js/report.js" type="text/javascript"></script>
</head>

<!-- body starts here -->
<body>
<div id="container">
<div id="header"></div>
<div id="content">
<?php
echo $this->fetch('script');
echo $this->fetch('css');
//check for session. @TODO remove in the future
$username = $this->Session->read('UserData.userName');
if($username){ } 
?>

<!-- Show the content -->
<?php echo $this->Session->flash(); ?> <?php echo $this->fetch('content'); ?>
</div>

<!-- Footer starts here -->
<div id="footer"></div>
</div>
<?php  //echo $this->element('sql_dump'); //@TODO remove in the future ?>
</body>
</html>
