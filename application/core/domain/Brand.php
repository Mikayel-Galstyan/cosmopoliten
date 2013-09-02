<?php

class Domain_Brand extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var string
     */
    protected $logo = null;
   
    public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function getLogo() {
        return $this->logo;
    }
    public function &setLogo($val) {
        $this->logo = $val;
        return $this;
    }
}
?>