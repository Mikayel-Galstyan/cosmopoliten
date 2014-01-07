<?php

class Service_ObjectsGroup extends Miqo_Service_Base {
    private $validator = null;
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ObjectsGroup();
    }
	
	public function &__t_save(Domain_ObjectsGroup $domain) {
		$domain = $this->dao->save($domain);
		return $domain;
        
    }

	
	public function getByPublisherId($publisherId){
		$item = $this->dao->getByPublisherId($publisherId);
		return $item;
	}

}
?>