<?php

class Domain_Color extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var string
     */
    protected $code = null;
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
    public function getCode() {
        return $this->code;
    }
    public function &setCode($val) {
        $this->code = $val;
        return $this;
    }
}
?>