<?php

class Domain_Discount extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $startDate = null;
    /**
     *
     * @var string
     */
    protected $endDate = null;
	/**
     *
     * @var int
     */
    protected $percent = null;
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
   
   
    public function getStartDate() {
        return $this->startDate;
    }
    public function &setStartDate($val) {
        $this->startDate = $val;
        return $this;
    }
	
    public function getEndDate() {
        return $this->endDate;
    }
    public function &setEndDate($val) {
        $this->endDate = $val;
        return $this;
    }
	
	public function getPercent() {
        return $this->percent;
    }
    public function &setPercent($val) {
        $this->percent = $val;
        return $this;
    }
	
	public function getShopListId() {
        return $this->shopListId;
    }
    public function &getShopListId($val) {
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
?>