<?php

class Service_ShopGroup extends Miqo_Service_Base {
    private $validator = null;
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ShopGroup();
    }
	
	public function &__t_save(Domain_ShopGroup $domain) {
		$domain = $this->dao->save($domain);
		return $domain;
        
    }

	
	public function getByPublisherId($publisherId){
		$item = $this->dao->getByPublisherId($publisherId);
		return $item;
	}


}
?>