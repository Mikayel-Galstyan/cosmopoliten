<?php
require_once ('SecureController.php');

class SuperadminController extends SecureController {
    
  

    public function indexAction() {
       $user = $this->getAuthUser();
       if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isAdmin = true;
           $serviceUser = new Service_User();
           $servicePublisher = new Service_Publisher();
           $serviceShopList = new Service_ShopList();
           $serviceObjects = new Service_Objects();
           $serviceBrand = new Service_Brand();
           $serviceColor = new Service_Color();
           $serviceMaterial = new Service_Material();
           $serviceObjectsGroup = new Service_ObjectsGroup();
           $serviceObjectsType = new Service_ObjectType();
           $serviceShopsGroup = new Service_ShopGroup();
           
           $this->view->objects = $serviceObjects->getAll();
           $this->view->objectsGroup = $serviceObjectsGroup->getAll();
           $this->view->users = $serviceUser->getAll();
           $this->view->shops = $serviceShopList->getAll();
           $this->view->shopsGroup = $serviceShopsGroup->getAll();
           $this->view->brand = $serviceBrand->getAll();
           $this->view->type = $serviceObjectsType->getAll();
           $this->view->color = $serviceColor->getAll();
           $this->view->publishers = $servicePublisher->getAll();
           $this->view->matreial = $serviceMaterial->getAll();
        }
    }
    
    public function listAction() {
        
    }
    
    

}
