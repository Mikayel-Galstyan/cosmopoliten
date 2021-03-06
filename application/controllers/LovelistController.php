<?php
require_once ('SecureController.php');

class LovelistController extends SecureController {
    
    private $id = null;
	private $objectIds = null;
	private $ids = null;
	private $objectTypeId = null;
    

    public function indexAction() {
        $this->view->isAuth = false;
        if($this->getAuthUser()){
            $this->view->isAuth = true;
            $this->view->id = $this->getAuthUser()->getId();
            $this->view->img = $this->getAuthUser()->getUsedLastImage();
			$service = new Service_LoveList();
			$items = $service->getByUserId($this->getAuthUser()->getId());
			$this->view->items = $items;   
        }
    }
    
    public function listAction() {
           
    }
	
    public function deleteAction() {
        $this->setNoRender();
        if(!is_null($this->objectsIds)){
            $service = new Service_LoveList();
            try{
                $service->__t_deleteList($this->objectsIds);
                $this->printJsonSuccessRedirect($this->translate('success.delete'),'lovelist');
            } catch ( Miqo_Util_Exception_Service $ex ) {
                $this->printJsonFailRedirect($this->translate('cant.delete.record'),'lovelist');
            }
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
        $userId = $this->getAuthUser()->getId();
        $service = new Service_LoveList();
		$mainCollumn = ($this->objectsIds)?$this->objectsIds:$this->publisherIds;
		try {
			for($i=0;$i<count($mainCollumn); $i++){
				$item = new Domain_LoveList();
				if(!$this->objectsIds){
					$item->setPublisherId($mainCollumn[$i]);
				}else{
                    $item->setObjectId($mainCollumn[$i]);
                    $serviceObj = new Service_Objects();
                    $serviceObj->addClick($mainCollumn[$i]);
				}
				$item->setUserId($userId);
				$service->save($item);
				
			}
			$this->printJsonSuccessRedirect($this->translate('success.save'),'lovelist');
		} catch ( Miqo_Util_Exception_Validation $vex ) {
			$errors = $this->translateValidationErrors($vex->getValidationErrors());
			$this->printJsonError($errors, $this->translate('validation.error'));
		}
    }
    
	public function overviewAction(){
		$id = $this->id;
		if($id){
			$service = new Service_ShopList();
			$this->view->item = $service->getById($id);
		}else{
			
		}
	}
	
    public function &setObjectsIds($val) {
        $this->objectsIds = $val;
        return $this;
    }
    public function &setObjectsId($val) {
        $this->objectsId = $val;
        return $this;
    }
	public function &setObjectTypeId($val) {
        $this->objectTypeId = $val;
        return $this;
    }
	public function &setIds($val) {
        $this->objectIds = $val;
        return $this;
    }
	public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    
}
