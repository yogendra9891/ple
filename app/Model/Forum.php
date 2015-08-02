<?php
/**
 * Model for handling the forum posts
 * ple_questions table is common for chat and forum usres.
 */
App::uses('AppModel','Model');

class Forum extends AppModel
{
	//Table Name
       public $useTable = 'ple_questions';
       public $hasMany = array(
       'Comment' => array(
           'className' => 'Comment',
           'foreignKey' => 'question_id',
       		'order' => 'id DESC',
       		'limit' =>'1',
           'dependent' => true
       ),
       'AccessQuestion' => array(
       				'className' => 'AccessQuestion',
       				'foreignKey' => 'question_id',
       				'dependent' => true
       		)
       		
   );
       public $validate = array(
       		'login' => 'alphaNumeric',
       		'email' => 'email',
       		'born'  => 'date'
       );
      /**
       * Finding the current page number for pagination
       * @param int $id
       * @param int $rowsPerPage
       */
      public function getPageNumber($id, $rowsPerPage)
       {
       	$result = $this->find('list'); // id => name
       	$resultIDs = array_keys($result); // position - 1 => id
       	$resultPositions = array_flip($resultIDs); // id => position - 1
       	$position = $resultPositions[$id] + 1; // Find the row number of the record
       	$page = ceil($position / $rowsPerPage); // Find the page of that row number
       	return $page;
       }
}