<?php
class Filter_ShopList {
    /**
     *
     * @var int
     */
    protected $publisherId = null;
	/**
     *
     * @var int
     */
    protected $groupId = null;
	
    public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
	
	public function getGroupId() {
        return $this->groupId;
    }
    public function &setGroupId($val) {
        $this->groupId = $val;
        return $this;
    }
  
}