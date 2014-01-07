<?php
class Filter_Objects {
    /**
     *
     * @var int
     */
    protected $publisherId = null;
    /**
     *
     * @var int
     */
    protected $shopListId = null;
    /**
     *
     * @var int
     */
    protected $objectTypeId = null;
    /**
     *
     * @var int
     */
    protected $costMin = null;
    /**
     *
     * @var int
     */
    protected $costMax = null;
    /**
     *
     * @var int
     */
    protected $population = null;
	/**
     *
     * @var int
     */
    protected $gender = null;
	/**
     *
     * @var int
     */
    protected $materialId = null;
	/**
     *
     * @var int
     */
    protected $colorId = null;
	/**
     *
     * @var int
     */
    protected $brandId = null;

	/**
     *
     * @var int
     */
    protected $groupId = null;
    
	
	public function getGroupId() {
        return $this->groupId;
    }
    public function &setGroupId($val) {
        $this->groupId = $val;
        return $this;
    }
    
	public function getMaterialId() {
        return $this->materialId;
    }
    public function &setMaterialId($val) {
        $this->materialId = $val;
        return $this;
    }
	
	public function getColorId() {
        return $this->colorId;
    }
    public function &setColorId($val) {
        $this->colorId = $val;
        return $this;
    }
	
	
	public function getBrandId() {
        return $this->brandId;
    }
    public function &setBrandId($val) {
        $this->brandId = $val;
        return $this;
    }
	
	public function getGender() {
        return $this->gender;
    }
    public function &setGender($val) {
        $this->gender = $val;
        return $this;
    }
	
    public function getPopulation() {
        return $this->population;
    }
    public function &setPopulation($val) {
        $this->population = $val;
        return $this;
    }
    
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    
    public function getCostMin() {
        return $this->costMin;
    }
    public function &setCostMin($val) {
        $this->costMin = $val;
        return $this;
    }
    
    public function getCostMax() {
        return $this->costMax;
    }
    public function &setCostMax ($val) {
        $this->costMax = $val;
        return $this;
    }
    
    public function getShopListId() {
        return $this->shopListId;
    }
    public function &setShopListId($val) {
        $this->shopListId = $val;
        return $this;
    }
    
    public function getObjectTypeId() {
        return $this->objectTypeId;
    }
    public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
    
}