<?php
require_once ('SecureController.php');

class AdminController extends SecureController {
    
  

    public function indexAction() {
       $this->getStatus();
    }
    
    public function listAction() {
        $service = new Service_Brand();
        $this->view->items = $service->getAll();
    }
    
    

}
