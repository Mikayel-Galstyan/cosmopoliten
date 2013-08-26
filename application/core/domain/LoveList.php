<?php

class Domain_LoveList extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var int
     */
    protected $userId = null;
    /**
     *
     * @var int
     */
    protected $objectId = null;
    /*
     *
     * @var int
     */
    protected $objectTypeName = null;
    /**
     *
     * @var string
     */
	 protected $valuta = null;
    /**
     *
     * @var string
     */
    protected $path = null;
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var int
     */
    protected $cost = null;
    /**
     *
     * @var int
     */
    protected $publisherId = null;
    /**
     *
     * @var int
     */
    protected $objectTypeId = null;
    /**
     *
     * @var int
     */
    protected $shopListId = null;
    
    
    
    public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    
	public function getValuta() {
        return $this->valuta;
    }
    public function &setValuta($val) {
        $this->valuta = $val;
        return $this;
    }
    
    public function getCost() {
        return $this->cost;
    }
    public function &setCost($val) {
        $this->cost = $val;
        return $this;
    }
    
    public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
    
    public function getObjectTypeId() {
        return $this->objectTypeId;
    }
    public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
    
    public function getShopListId() {
        return $this->shopListId;
    }
    public function &setShopListId($val) {
        $this->shopListId = $val;
        return $this;
    }
    
    public function getUserId() {
        return $this->userId;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
    
    public function getObjectTypeName() {
        return $this->objectTypeName;
    }
    public function &setObjectTypeName($val) {
        $this->objectTypeName = $val;
        return $this;
    }
	

	
	public function getObjectId() {
        return $this->objectId;
    }
    public function &setObjectId($val) {
        $this->objectId = $val;
        return $this;
    }
	
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
}
?>