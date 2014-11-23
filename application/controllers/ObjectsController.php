<?php
require_once ('ImageutilController.php');

class ObjectsController extends ImageutilController {
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
	private $material = null;
	private $colorId = null;
	private $active = null;
	private $brand = null;
    
    public function indexAction() {
        $this->getStatus();
		$servicePublisher = new Service_Brand();
        $this->view->brand = $servicePublisher->getAll();
		$serviceShops = new Service_ShopList();
        $this->view->shopList = $serviceShops->getAll();
		$service = new Service_ObjectType();
        $this->view->items = $service->getAll();
        $service = new Service_ObjectType();
        $this->view->types = $service->getAll();
        $filter = new Filter_Objects();
        $type = $this->type;
		$service = new Service_Material();
        $this->view->material = $service->getAll();
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
        if($this->objectTypeId && $type == 'brand'){
            $filter->setBrandId($this->objectTypeId);
            $this->view->brandId = $this->objectTypeId;
            /*if(!$this->getBrandId()){
               $service = new Service_Brand();
               //$service->addClick($this->objectTypeId);
            }*/
        }
		if($this->getAuthUser() && !$this->for && $this->getAuthUser()->getStatus() != 1){
			$this->for = $this->getAuthUser()->getGender();
		}
		$filter->setGender($this->for);
        if($this->getPublisherId()){
            $filter->setPublisherId($this->getPublisherId());
			$this->view->isPublisher = true;
        }
        $service = new Service_Objects();
		if($this->getAuthUser()){
			$status = $this->getAuthUser()->getStatus();
		}else{
			$status = 2;
		}
        $objects = $service->getByParams($filter,$status);
        $this->view->objects = $objects;
    }
    
	public function langAction(){
		$langSession = new Miqo_Session_Base();
		$lang = $langSession->get('lang');
		if(!$lang){
			$lang = "en";
			$langSession->set('lang','en');
		}
		$this->view->lang = $lang;
	}
	
	public function menuAction(){
        $this->getStatus();
		$service = new Service_Visitors();
		$domain = new Domain_Visitors();
		$domain->setCount(1);
		$service->save($domain);
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
		$filter->setBrandId($this->brand);
		$filter->setMaterialId($this->material);
        if($this->getPublisherId()){
            $filter->setPublisherId($this->getPublisherId());
        }
		if($this->getAuthUser() && !$this->for){
			$this->for = $this->getAuthUser()->getGender();
		}
		$filter->setGender($this->for);
        $service = new Service_Objects();
		if($this->getAuthUser()){
			$status = $this->getAuthUser()->getStatus();
		}else{
			$status = 1;
		}
        $items = $service->getByParams($filter,$status);
        $this->view->items = $items;
		if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
			$this->view->isPublisher = true;
			$serviceGroup = new Service_ObjectsGroup();
			$groups = $serviceGroup->getByPublisherId($this->getPublisherId());
			$this->view->objectsGroup = $groups;
		}else{
			$this->view->isPublisher = false;
		}
        $this->getStatus();
    }
    
    public function editAction(){
        $id = $this->id;
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            $service = new Service_ObjectType();
            $this->view->types = $service->getAll();
			$service = new Service_Color();
            $this->view->colors = $service->getAll();
			$service = new Service_Material();
            $this->view->materials = $service->getAll();
			$service = new Service_Brand();
            $this->view->brands = $service->getAll();
			
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
			$objectsInGroup = null;
			if($item->getObjectGroupId()){
				$objectsInGroup = $service->getObjectsByGroupId($item->getObjectGroupId());
			}
			$this->view->item = $item;
			$this->view->objectsInGroup = $objectsInGroup;
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
		$item->setMaterialId($this->material);
		$item->setColorId($this->colorId);
		$item->setBrandId($this->brand);
        $item->setValuta($this->value);
		$item->setCost($this->cost);
        $item->setObjectTypeId($this->objectTypeId);
		$item->setDescription($this->description);
        $item->setShopListId($this->shopListId);
        $item->setGender($this->for);
        if(isset($_FILES['path']) && $_FILES['path']){
            $path = $_FILES['path'];
            $email = $this->getAuthUser()->getEmail();
            $type = $item->getObjectTypeId();
            if(!is_dir ("users/".$email.'/'.$type)){
                mkdir("users/".$email.'/'.$type);
            }
            $userfile_extn = explode(".", strtolower($path['name']));
			$userfile_extn = $userfile_extn[count($userfile_extn)-1];
            do{
                $new_name = md5(rand ( -100000 , 100000 ));
                $fullPath = "users/".$email.'/'.$type."/".$new_name.'.'.$userfile_extn;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name.'.'.$userfile_extn);
            move_uploaded_file ($path['tmp_name'],$fullPath);
			$new_name = $new_name.'.png';
            $item->setPath($this->resize_image($fullPath,200,200,0.0000000001,false,"users/".$email.'/'.$type.'/'.$new_name));
			$this->resize_image($fullPath,100,100,0.0000000001,false,"users/".$email.'/'.$type.'/100x100_'.$new_name);
			$this->resize_image($fullPath,500,500,0.0000000001,false,"users/".$email.'/'.$type.'/500x500_'.$new_name);
        }
        try {
            $service->save($item);
            $this->printJsonSuccess($this->translate('success.save'));
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
                $service = new Service_Objects();
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
        $service = new Service_Objects();
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
	public function &setMaterial($val) {
        $this->material = $val;
        return $this;
    }
	public function &setColorId($val) {
        $this->colorId = $val;
        return $this;
    }
	public function &setBrand($val) {
        $this->brand = $val;
        return $this;
    }
	public function &setActive($val) {
        $this->active = $val;
        return $this;
    }
    
}
