<?php
require_once ('ImageutilController.php');

class PublisherController extends ImageutilController {
    
    private $id = null;
    private $name = null;
    private $address = null;
    private $phone = null;
    private $site = null;
    private $clicks = null;
    private $userId = null;
    private $order = null;
	private $status = null;
	

    public function indexAction() {
        if (!isset($userSession)) {
            $userSession = new Miqo_Session_Base();
        }
    }
    
    public function listAction() {
        $servie=new Service_Publisher();
		$filter = new Filter_Publisher();
		$items = $servie->getByParams($filter);
		$this->view->items = $items; 
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            if($id){
                $service = new Service_Publisher();
                $publisher = $service->getById($id);
                $this->view->item = $publisher;
            }else{
                //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
				$date = new DateTime(date("Y-m-d H:i:s"));
				$date->modify('+1 month');
				$this->view->dateTime = $date->format('Y-m-d H:i:s');
            }
        }else{
            $this->view->isPublisher = false;
        }
       
    }
    
    public function saveAction(){
        
        $id = $this->getPublisherId();
        $service = new Service_Publisher();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Publisher();
            $item->setOrder(1);
        }
        $item->setName($this->name);
        $item->setUserId($this->getAuthUser()->getId());
        $item->setAddress($this->address);
        $item->setPhone($this->phone);
        $item->setSite($this->site);
        if(!is_dir ("users/".$this->getAuthUser()->getEmail().'/'.$this->name)){
			mkdir("users/".$this->getAuthUser()->getEmail().'/'.$this->name);
		}
        if($_FILES['path']['name'] != ''){
            $path = $_FILES['path'];
            $email = $this->getAuthUser()->getEmail().'/'.$this->name;
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
            if (!isset($userSession)) {
                $userSession = new Miqo_Session_Base();
            }
            $userSession->set('publisherId', $item->getId());
            $this->javascript()->redirect('index');
            //$this->printJsonSuccessRedirect($this->translate('success.save'),'objects');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_Publisher();
            if(!$this->getPublisherId()){
                $service->addClick($id);
            }
            $this->view->item = $service->getById($id);
		}else{
			
		}
	}
	
	public function editadminAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isAdmin = true;
            if($id){
                $service = new Service_Publisher();
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
        $service = new Service_Publisher();
        if ($id != null) {
            $item = $service->getById($id);
			$item->setStatus($this->status);
			try {
				$item = $service->save($item);
				$this->printJsonSuccessRedirect($this->translate('success.save'),'superadmin');
			} catch ( Miqo_Util_Exception_Validation $vex ) {echo "<pre>";var_dump($vex);echo "</pre>";
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
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
    public function &setAddress($val) {
        $this->address = $val;
        return $this;
    }
    public function &setPhone($val) {
        $this->phone = $val;
        return $this;
    }
    public function &setSite($val) {
        $this->site = $val;
        return $this;
    }
    public function &setClicks($val) {
        $this->clicks = $val;
        return $this;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function &setOrder($val) {
        $this->order = $val;
        return $this;
    }
	public function &setStatus($val) {
        $this->status = $val;
        return $this;
    }
    
}
