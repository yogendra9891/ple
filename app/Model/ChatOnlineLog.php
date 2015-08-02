<?php
//Model for handling the online presence log

APP::uses('AppModel', 'Model');

class ChatOnlineLog extends AppModel
{
	public $useTable = 'ple_online_user_logs';
}