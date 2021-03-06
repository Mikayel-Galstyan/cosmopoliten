<?php

class Domain_Objects extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $description = null;
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
    /**
     *
     * @var int
     */
    protected $population = null;
    /**
     *
     * @var int
     */
	protected $gender;
    
    /**
     *
     * @var string
     */
    protected $materialId = null;
    /**
     *
     * @var string
     */
	 protected $brandId = null;
     /**
     *
     * @var string
     */
    protected $colorId = null;
    /**
     *
     * @var string
     */
	protected $objectGroupId = null;
    
    /**
     *
     * @var string
     */
	protected $pathBack = null;
    /**
     *
     * @var boolean
     */
	protected $active = null;
    
    public function getActive() {
        return $this->active;
    }
    public function &setActive($val) {
        $this->active = $val;
        return $this;
    }
    
    public function getPathBack() {
        return $this->pathBack;
    }
    public function &setPathBack($val) {
        $this->pathBack = $val;
        return $this;
    }
    
    public function getMaterialId() {
        return $this->materialId;
    }
    public function &setMaterialId($val) {
        $this->materialId = $val;
        return $this;
    }
    public function getBrandId() {
        return $this->brandId;
    }
    public function &setBrandId($val) {
        $this->brandId = $val;
        return $this;
    }
    public function getColorId() {
        return $this->colorId;
    }
    public function &setColorId($val) {
        $this->colorId = $val;
        return $this;
    }
    public function getObjectGroupId() {
        return $this->objectGroupId;
    }
    public function &setObjectGroupId($val) {
        $this->objectGroupId = $val;
        return $this;
    }

    
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
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
    public function getDescription() {
        return $this->description;
    }
    public function &setDescription($val) {
        $this->description = $val;
        return $this;
    }
    
    public function getCost() {
        return $this->cost;
    }
    public function &setCost($val) {
        $this->cost = $val;
        return $this;
    }
	public function getGender() {
        return $this->gender;
    }
	
    public function &setGender($val) {
        $this->gender = $val;
        return $this;
    }
    public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
    
     public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
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
}
?>