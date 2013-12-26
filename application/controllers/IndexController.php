<?php
require_once('SecureController.php');

class IndexController extends SecureController{

   public function  indexAction() {
        if(!$this->getUserName()){
            $this->_redirect('objecttype');
        }else if($this->getAuthUser()->getStatus()==1){
            $this->_redirect('objecttype');
        }else if($this->getAuthUser()->getStatus()==2){
            $this->_redirect('objecttype');
        }
   }       
}