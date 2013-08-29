<?php
require_once ('ImageutilController.php');

class ShoplistController extends ImageutilController {
    
    private $id = null;
    private $name = null;
    private $address = null;
    private $phone = null;
    private $description = null;
    private $publisherId = null;
	private $site = null;
    private $order = null;

    public function indexAction() {
        $publisherService = new Service_Publisher();
		$items = $publisherService->getAll();
		$this->view->items = $items;
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
        }else{
            $this->view->isPublisher = false;
        }
    }
    
    public function listAction() {
        $this->getStatus();
        if(!$this->getAuthUser() || !$this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $servie=new Service_ShopList();
            $filter = new Filter_ShopList();
            $filter->setPublisherId($this->publisherId);
            $items = $servie->getByParams($filter);
            $this->view->items = $items;
        }else{
            $servie=new Service_ShopList();
            $filter = new Filter_ShopList();
            $filter->setPublisherId($this->getPublisherId());
            $items = $servie->getByParams($filter);
            $this->view->items = $items;
        }
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            if($id){
                $service = new Service_ShopList();
                $shop = $service->getById($id);
                $this->view->item = $shop;
            }else{
                //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
            }
        }else{
            $this->view->isPublisher = false;
        }
       
    }
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        /*$userId = $this->userId;*/
        $id = $this->id;
        $service = new Service_ShopList();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_ShopList();
           // $item->setOrder(1);
        }
		$sevicePublisher = new Service_Publisher();
		$filterPublisher = new Filter_Publisher();
		$filterPublisher->setUserId($this->getAuthUser()->getId());
		$publisher = $sevicePublisher->getByParams($filterPublisher);
        $publisherId = $publisher[0]->getId();
        $item->setName($this->name);
		$item->setSite($this->site);
        $item->setPublisherId($publisherId);
        $item->setAddress($this->address);
        $item->setPhone($this->phone);
        $item->setDescription($this->description);
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
            $item->setPath($fullPath);
        }
        try {
            $service->save($item);
            $this->printJsonSuccessRedirect($this->translate('success.save'),'shoplist');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_ShopList();
            if(!$this->getPublisherId()){
                $service->addClick($id);
            }
			$item = $service->getById($id);
			$this->view->item = $item;
			$servicePublisher =  new Service_Publisher();
			$this->view->publisher = $servicePublisher->getById($item->getId());
		}else{
			
		}
	}
	
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setDescription($val) {
        $this->description = $val;
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
    public function &setPublisherId($val) {
        $this->publisherId = $val;
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
}
