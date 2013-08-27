<?php
require_once ('ImageutilController.php');

class ObjectTypeController extends ImageutilController {
    private $id = null;
    private $name = null;
    public function indexAction() {
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
        }else{
            $this->view->isPublisher = false;
        }
    }
    
    public function listAction() {
        $service = new Service_ObjectType();
        $this->view->items = $service->getAll();
    }
    
    public function editAction(){
		if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
			if($this->id){
				$service = new Service_ObjectType();
				$this->view->item = $service->getById($this->id);
			}else{
				$this->view->item = null;
			}
			$this->view->isPublisher = true;
		}else{
            $this->view->isPublisher = false;
        }
    }
    
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->id;
        $service = new Service_ObjectType();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_ObjectType();
        }

        $item->setName($this->name);
        if(!is_dir ("users/".$this->name)){
			mkdir("users/".$this->name);
		}
        if($_FILES['path']['name'] != ''){
            $path = $_FILES['path'];
            $email = $this->name;
            $userfile_extn = explode(".", strtolower($path['name']));
            do{
                $new_name = md5(rand ( -100000 , 100000 )).'.'.$userfile_extn[1];
                $fullPath = "users/".$email.'/'.$new_name;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name);
            move_uploaded_file ($path['tmp_name'],$fullPath);
            $item->setPath($fullPath);
        }
        try {
            $service->save($item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'objecttype');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
    public function setName($val){
        $this->name = $val;
    }
    
    public function setId($val){
        $this->id = $val;
    }
    
}
