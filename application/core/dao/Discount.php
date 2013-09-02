<?php

class Dao_Discount extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'start_date' => 'startDate',
			'end_date' => 'endDate',
			'shopList_id' => 'shopListId',
			'objectType_id' => 'objectTypeId',
			);
    
    protected $entityClass = 'Discount';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Discount();
    }
	
    
    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::ShopImage), array('id AS id', 'name AS name'));
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
