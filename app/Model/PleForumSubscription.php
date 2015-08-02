<?php
/**
 * model for handling the enable/disable setting in forum for notification by user.
 */
App::uses('AppModel','Model');

class PleForumSubscription extends AppModel
{
	 public $useTable = 'ple_forum_subscription_setting'; 
}