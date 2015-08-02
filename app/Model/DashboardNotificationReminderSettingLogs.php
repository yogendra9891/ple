<?php
/**
 * Model for handling the dashboard active post/forum logs.
 */
App::uses('AppModel','Model');

class DashboardNotificationReminderSettingLogs extends AppModel
{
	// This model uses a database table 'ple_dashboard_notification_reminder_logs'
	public $useTable = 'ple_dashboard_notification_reminder_logs'; 
}