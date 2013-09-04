<?php
require_once ('SecureController.php');

class MaterialController extends SecureController {
    
    private $id = null;
    private $name = null;

    public function indexAction() {
       $this->getStatus();
    }
    
    public function listAction() {
        $service = new Service_Material();
        $this->view->items = $service->getAll();
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isAdmin = true;
            if($id){
                $service = new Service_Material();
                $material = $service->getById($id);
                $this->view->item = $material;
            }
        }else{
            $this->view->isAdmin = false;
        }
       
    }
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->id;
        $service = new Service_Material();
        if ($id) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Material();
        }
		$item->setName($this->name);
        try {
            $service->save($item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'shoplist');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
	
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }

}
