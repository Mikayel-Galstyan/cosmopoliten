<?php
require_once ('SecureController.php');

class ObjectsgroupController extends SecureController {
    
    private $id = null;
	private $ids = null;
    private $name = null;
    private $path = null;
	private $active = null;

    public function indexAction() {
        
    }
    
    public function listAction() {
       
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isAdmin = true;
			$serviceShops = new Service_Objects();
			$filter = new Filter_Objects();
			$filter->setPublisherId($this->getPublisherId());
            if($id){
                $service = new Service_ObjectsGroup();
                $group = $service->getById($id);
                $this->view->item = $group;
            }
			$this->view->shops = $serviceShops->getByParams($filter);
        }else{
            $this->view->isAdmin = false;
        }
    }
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        $id = $this->id;
        $service = new Service_ObjectsGroup();
        if ($id) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_ObjectsGroup();
        }
		$item->setName($this->name);
		$item->setPublisherId($this->getPublisherId());
        if(!is_dir ("users/".$this->getAuthUser()->getEmail().'/'.$this->name)){
			mkdir("users/".$this->getAuthUser()->getEmail().'/'.$this->name);
		}
        if(isset($_FILES['path']) && $_FILES['path']['name'] != ''){
            $path = $_FILES['path'];
            $email = $this->getAuthUser()->getEmail().'/'.$this->name;
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
            $item = $service->save($item);
			$ids = $this->ids;
			if($ids){
				$serviceShops = new Service_Objects();
				foreach($ids as $id1){
					try {
						$shop = $serviceShops->getById($id1);
						$shop->setObjectGroupId($item->getId());
						$serviceShops->save($shop);
					} catch ( Miqo_Util_Exception_Validation $vex1 ) {
						$errors = $this->translateValidationErrors($vex1->getValidationErrors());
						$this->printJsonError($errors, $this->translate('validation.error'));
					}
				}
			}
            $this->printJsonSuccessRedirect($this->translate('success.save'),'objects');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
	
	
	public function editadminAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isAdmin = true;
            if($id){
                $service = new Service_ObjectsGroup();
                $user = $service->getById($id);
                $this->view->item = $user;
            }
        }else{
            $this->view->isAdmin = false;
        }
    }
    
	public function saveadminAction(){
        $this->setNoRender();
		$id = $this->id;
        $service = new Service_ObjectsGroup();
        if ($id != null) {
            $item = $service->getById($id);
			$item->setActive($this->active);
			try {
				$item = $service->save($item);
				$this->printJsonSuccessRedirect($this->translate('success.save'),'superadmin');
			} catch ( Miqo_Util_Exception_Validation $vex ) {
				$errors = $this->translateValidationErrors($vex->getValidationErrors());
				
			}
        }else{
			$this->redirect('index');
		}
	}
	
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
	public function &setIds($val) {
        $this->ids = $val;
        return $this;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
	public function &setActive($val) {
        $this->active = $val;
        return $this;
    }

}
