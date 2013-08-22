<?php

class Dao_Publisher extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'name' => 'name',
			'status' => 'status',
    		'order' => 'order',
            'address' => 'address',
            'phone' => 'phone',
            'site' => 'site',
            'clicks' => 'clicks',
            'user_id' => 'userId',
            'end_order_date' => 'endOrderDate',
            'population' => 'population');
    
    protected $entityClass = 'Domain_Publisher';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_Publisher();
        $this->dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        $this->dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
    }
    
    public function addClick($id){
        $query = 'UPDATE publishers
        SET publishers.clicks = publishers.clicks + 1
        WHERE publishers.id ='.$id;
        $this->dbAdapter->query($query);
    }
    
    public function &getByParams(Filter_Publisher $filter) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::PUBLISHER));
    	if($filter->getUserId()){
            $select->where('user_id = ?', $filter->getUserId());
        }
    	$result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
    }
}

?>
