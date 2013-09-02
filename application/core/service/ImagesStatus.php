<?php

class Service_ImagesStatus extends Miqo_Service_Base {
    private $validator = null;
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_ImagesStatus();
    }


}
?>