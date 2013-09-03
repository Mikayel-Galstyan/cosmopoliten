<?php
require_once ('SecureController.php');

class BrandController extends ImageutilController {
    
    private $id = null;
    private $name = null;
    private $logo = null;

    public function indexAction() {
       $this->getStatus();
    }
    
    public function listAction() {
        $service = new Service_Brand();
        $this->view->items = $service->getAll();
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isAdmin = true;
            if($id){
                $service = new Service_Brand();
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
        $service = new Service_Brand();
        if ($id) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Brand();
        }
		$item->setName($this->name);
        if(!is_dir ("users/".$this->getAuthUser()->getEmail().'/'.$this->name)){
			mkdir("users/".$this->getAuthUser()->getEmail().'/'.$this->name);
		}
        if($_FILES['path']['name'] != ''){
            $path = $_FILES['path'];
            $email = $this->getAuthUser()->getEmail().'/'.$this->name;
            $userfile_extn = explode(".", strtolower($path['name']));
            do{
                $new_name = md5(rand ( -100000 , 100000 )).'.'.$userfile_extn[1];
                $fullPath = "users/".$email.'/'.$new_name;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name);
            move_uploaded_file ($path['tmp_name'],$fullPath);
            $item->setLogo($this->fullPath);
        }
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
    public function &setLogo($val) {
        $this->logo = $val;
        return $this;
    }

}