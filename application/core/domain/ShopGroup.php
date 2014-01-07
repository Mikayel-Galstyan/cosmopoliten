<?php

class Domain_ShopGroup extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var string
     */
    protected $path = null;
	/**
     *
     * @var string
     */
    protected $publisherId = null;
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
	public function getPublisherId() {
        return $this->publisherId;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
}
?>