<?php
require_once ('SecureController.php');

class ObjectsController extends SecureController {
    private $id = null;
    private $name = null;
    private $description = null;
    private $objectTypeId = null;
    private $publisherId = null;
    private $shopListId = null;
    private $path = null;
    private $cost = null;
    private $costMin = null;
    private $costMax = null;
    private $objectsIds = null;
	private $for = null;
    private $type = null;
	private $value = null;
    
    public function indexAction() {
        $this->getStatus();
		$servicePublisher = new Service_Publisher();
        $this->view->publishers = $servicePublisher->getAll();
		$serviceShops = new Service_ShopList();
        $this->view->shopList = $serviceShops->getAll();
		$service = new Service_ObjectType();
        $this->view->items = $service->getAll();
        $service = new Service_ObjectType();
        $this->view->types = $service->getAll();
        $filter = new Filter_Objects();
        $type = $this->type;
        if($this->objectTypeId && $type == 'objectType'){
            $filter->setObjectTypeId($this->objectTypeId);
            $this->view->objectTypeId = $this->objectTypeId;
        }
        if($this->objectTypeId && $type == 'shopList'){
            $filter->setShopListId($this->objectTypeId);
            $this->view->shopListId = $this->objectTypeId;
            if(!$this->getPublisherId()){
                $service = new Service_ShopList();
                $service->addClick($this->objectTypeId);
            }
        }
        if($this->objectTypeId && $type == 'publisher'){
            $filter->setPublisherId($this->objectTypeId);
            $this->view->publisherId = $this->objectTypeId;
            if(!$this->getPublisherId()){
               $service = new Service_Publisher();
               $service->addClick($this->objectTypeId);
            }
        }
		if($this->getAuthUser() && !$this->for && $this->getAuthUser()->getStatus() != 1){
			$this->for = $this->getAuthUser()->getGender();
		}
		$filter->setGender($this->for);
        if($this->getPublisherId()){
            $filter->setPublisherId($this->getPublisherId());
        }
        $service = new Service_Objects();
        $objects = $service->getByParams($filter);
        $this->view->objects = $objects;
    }
    
	public function menuAction(){
        $this->getStatus();
		if($this->getAuthUser()){
			$this->view->publisherId = $this->getPublisherId();
			$this->view->userId = $this->getAuthUser()->getId();
            $this->view->name =  $this->getAuthUser()->getFirstName();
            $this->view->path = $this->getAuthUser()->getPath();
		}
	}
	
    public function listAction() {
        $filter = new Filter_Objects();
        //$filter->setId($this->id);
        if($this->id){
            $filter->setObjectTypeId($this->id);
        }else{
            $filter->setObjectTypeId($this->objectTypeId);
        }
        $filter->setPublisherId($this->publisherId);
        $filter->setShopListId($this->shopListId);
        $filter->setCostMin($this->costMin);
        $filter->setCostMax($this->costMax);
        if($this->getPublisherId()){
            $filter->setPublisherId($this->getPublisherId());
        }
		if($this->getAuthUser() && !$this->for){
			$this->for = $this->getAuthUser()->getGender();
		}
		$filter->setGender($this->for);
        $service = new Service_Objects();
        $items = $service->getByParams($filter);
        $this->view->items = $items;
        $this->getStatus();
    }
    
    public function editAction(){
        $id = $this->id;
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            $service = new Service_ObjectType();
            $this->view->types = $service->getAll();
            $filterPublisher = new Filter_Publisher();
            $filterShop = new Filter_ShopList();
            $sevicePublisher = new Service_Publisher();
            $seviceShopList = new Service_ShopList();
            $filterPublisher->setUserId($this->getAuthUser()->getId());
            $publisher = $sevicePublisher->getByParams($filterPublisher);
            $publisherId = $publisher[0]->getId();
            $filterShop->setPublisherId($publisherId);
            
            $this->view->publisherId = $publisherId;
            $this->view->shopList = $seviceShopList->getByParams($filterShop);
            if($id){
                $service = new Service_Objects();
                $item = $service->getById($id);
                $this->view->item = $item;
            }else{
                //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
            }
        }else{
            $this->view->isPublisher = false;
        }
       
    }
    
    
    public function deleteAction() {
        $this->setNoRender();
        if(!is_null($this->objectsIds)){
            $service = new Service_Objects();
            try{
                $service->__t_deleteList($this->objectsIds);
                $msg = (count($this->objectsIds)>1)?$this->translate('success.delete.items'):$this->translate('success.delete');
                $this->printJsonSuccessRedirect($msg,'objects');
            } catch ( Miqo_Util_Exception_Service $ex ) {
                $msg = (!is_null($this->objectsIds) && count($this->objectsIds)>1)?$this->translate('cant.delete.records'):$this->translate('cant.delete.record');
                $this->printJsonFailRedirect($msg,'objects');
            }
        }    
    }
	
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_Objects();
            if(!$this->getPublisherId()){
                $service->addClick($id);
            }
			$item = $service->getById($id);
			$this->view->item = $item;
			$publisherService = new Service_Publisher();
			$shopService = new Service_ShopList();
			$this->view->shopList = $shopService->getById($item->getShopListId());
		}else{
			
		}
	}
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        //$userId = $this->userId;
        $id = $this->id;
        $service = new Service_Objects();
        if ($id != null) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Objects();
        }   
        $item->setName($this->name);
        $item->setPublisherId($this->publisherId);
        $item->setValuta($this->value);
		$item->setCost($this->cost);
        $item->setObjectTypeId($this->objectTypeId);
		$item->setDescription($this->description);
        $item->setShopListId($this->shopListId);
        $item->setGender($this->for);
        if($_FILES['path']){
            $path = $_FILES['path'];
            $email = $this->getAuthUser()->getEmail();
            $type = $item->getObjectTypeId();
            if(!is_dir ("users/".$email.'/'.$type)){
                mkdir("users/".$email.'/'.$type);
            }
            $userfile_extn = explode(".", strtolower($path['name']));
            do{
                $new_name = md5(rand ( -100000 , 100000 )).'.'.$userfile_extn[1];
                $fullPath = "users/".$email.'/'.$type."/".$new_name;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name);
            move_uploaded_file ($path['tmp_name'],$fullPath);
            $item->setPath($fullPath);
        }
        try {
            $service->save($item);
            $this->printJsonSuccess($this->translate('success.save'));
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
    }
    
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    
    public function &setObjectsIds($val) {
        $this->objectsIds = $val;
        return $this;
    }
    
    
    public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
	public function &setShopListId($val) {
        $this->shopListId = $val;
        return $this;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function &setCostMin($val) {
        $this->costMin = $val;
        return $this;
    }
    public function &setCostMax($val) {
        $this->costMax = $val;
        return $this;
    }
    public function &setDescription($val) {
        $this->description = $val;
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
    public function &setCost($val) {
        $this->cost = $val;
        return $this;
    }
	public function &setFor($val) {
        $this->for = $val;
        return $this;
    }
    public function &setType($val) {
        $this->type = $val;
        return $this;
    }
	public function &setValue($val) {
        $this->value = $val;
        return $this;
    }
    
}
