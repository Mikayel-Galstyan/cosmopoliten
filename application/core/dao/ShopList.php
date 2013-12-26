<?php

class Dao_ShopList extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'name' => 'name',
            'address' => 'address',
			'phone' => 'phone',
			'description' => 'description',
			'publisher_id' => 'publisherId',
            'population' => 'population',
			'site' => 'site',
            'path' => 'path',
			'mapControl' => 'mapControl');
    
    protected $entityClass = 'Domain_ShopList';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_ShopList();
        $this->dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        $this->dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
    }
	
    public function addClick($id){
        $query = 'UPDATE shopList,publishers
        SET shopList.population = shopList.population + 1,
        publishers.clicks = publishers.clicks + 1
        WHERE shopList.publisher_id = publishers.id
        AND shopList.id ='.$id;
        $this->dbAdapter->query($query);  
    }
    
    public function &getByParams(Filter_ShopList $filter){
        $select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::SHOPLIST));
        if($filter->getPublisherId()){
            $select->where('publisher_id = ?', $filter->getPublisherId());
        }
       /* if($filter->getObjectTypeId()){
            $select->where('objectType_id = ?', $filter->getObjectTypeId());
        }
        if($filter->getCostMin()){
            $select->where('cost >=', $filter->getCostMin());
        }
        if($filter->getCostMax()){
            $select->where('cost <=', $filter->getCostMax());
        }*/
        $result = $this->dbTable->fetchAll($select);
    	$items = &$this->getEntities($result);
    	return $items;
    }
    
    public function &getOrderedList(Filter_Object $filter = null) {
    	$select = $this->dbTable->select()->from(array('c' => Dao_DbTable_List::SHOPLIST), array('id AS id', 'name AS name'));
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
