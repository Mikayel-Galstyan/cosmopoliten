<?php

class Domain_Material extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
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
}
?>