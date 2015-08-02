<?php
/**
 * model for handling the group/section in openfire(chat server) for Properties
 */
App::uses('AppModel','Model');

class GroupProp extends AppModel
{
	// defining the different database from default database
	public $useDbConfig = 'openfire';
	// Table Name
	public $useTable = 'ofGroupProp';
	public $primaryKey = '';
	public $cacheQueries = false;
	
   /*
    * function for saving the group property to openfireProp table.
    * @params allready defined 
    */
	public function saveGroupProp($groupDataProp1, $groupDataProp2, $groupDataProp3)
	{
		$this->save($groupDataProp1);
		$this->save($groupDataProp2);
		$this->save($groupDataProp3);
		return true;
	}
}