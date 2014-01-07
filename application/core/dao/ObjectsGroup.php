<?php

class Dao_ObjectsGroup extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'name' => 'name',
            'active' => 'active',
			'publisher_id' => 'publisherId',
			'path' => 'path'
			);
    
    protected $entityClass = 'Domain_ObjectsGroup';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_ObjectsGroup();
    }
	
    
    
   public function getByPublisherId($publisherId){
		$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::OBJECTSGROUP));
		$select->where('publisher_id = ?', $publisherId);
		$result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
	}

    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::OBJECTSGROUP), array('id AS id', 'name AS name'));
    	if($filter) {
    		$select->order( array($filter->getOrder().' '.$filter->getSort()));
    	} else {
    		$select->order('name ASC');
    	}
    	$result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
    }
}

?>
