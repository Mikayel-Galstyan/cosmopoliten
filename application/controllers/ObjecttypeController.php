<?php
require_once ('ImageutilController.php');

class ObjectTypeController extends ImageutilController {
    private $id = null;
    private $name = null;
    public function indexAction() {
       $this->getStatus();
    }
    
    public function listAction() {
        $service = new Service_ObjectType();
        $this->view->items = $service->getAll();
    }
    
    public function editAction(){
		if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
			if($this->id){
				$service = new Service_ObjectType();
				$this->view->item = $service->getById($this->id);
			}else{
				$this->view->item = null;
			}
		}
		$this->getStatus();
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
			$userfile_extn = $userfile_extn[count($userfile_extn)-1];
            do{
                $new_name = md5(rand ( -100000 , 100000 ));
                $fullPath = "users/".$email.'/'.$new_name.'.'.$userfile_extn;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name.'.'.$userfile_extn);
            move_uploaded_file ($path['tmp_name'],$fullPath);
            $item->setPath($this->resize_image($fullPath,200,200,false,0.0000000001,"users/".$email.'/'.$new_name.'.png'));
			$this->resize_image($fullPath,100,100,false,0.0000000001,"users/".$email.'/100x100_'.$new_name.'.png');
			$this->resize_image($fullPath,500,500,false,0.0000000001,"users/".$email.'/500x500_'.$new_name.'.png');
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
