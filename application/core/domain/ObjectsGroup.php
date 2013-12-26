<?php

class Domain_ObjectsGroup extends Miqo_Domain_AbstractEntity {
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