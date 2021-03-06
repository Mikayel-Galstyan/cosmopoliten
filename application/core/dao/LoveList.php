
<?php

class Dao_LoveList extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'user_id' => 'userId',
			'object_id' => 'objectId',
			'publisher_id' => 'publisherId',
            'object_type_name' => 'objectTypeName',
            'name' => 'name',
            'cost' => 'cost',
            'valuta' => 'valuta',
            'objectTypeId' => 'objectTypeId',
            'publisherId'=>'publisherId',
            'shopListId'=>'shopListId',
			'path'=>'path');
    
    protected $entityClass = 'Domain_LoveList';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_LoveList();
		$this->dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        $this->dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
    }
	
    public function getByUserId($id){
		$select = $this->dbAdapter->select()->from(array('c'=>Dao_DbTable_List::LOVELIST),array('id', 'user_id', 'object_id','publisher_id'))
		->joinLeft(Dao_DbTable_List::OBJECTS, 'objects.id=c.object_id',array(
        'objects.path as path', 
        'objects.name as name', 
        'objects.cost as cost', 
        'objects.valuta as valuta', 
        'objects.publisher_id as publisherId', 
        'objects.objectType_id as objectTypeId', 
        'objects.shopList_id as shopListId'))
        ->joinLeft(Dao_DbTable_List::OBJECTTYPE, 'objectType.id=objects.objectType_id',array( 'objectType.name as object_type_name'));
        $select->where('user_id =?',$id);
		$result = $this->dbAdapter->fetchAll($select);
        $result = $this->getEntities($result);
        return $result;
	}
    
    public function &getOrderedList(Filter_LoveList $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::LOVELIST), array('id AS id', 'name AS name'));
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


