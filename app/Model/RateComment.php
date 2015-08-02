<?php
/**
 * Model for handling the rating of posts(reply)
 */
App::uses('AppModel','Model');

class RateComment extends AppModel
{
	public $useTable = 'ple_comment_rating';
}