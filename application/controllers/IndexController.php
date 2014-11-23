<?php
require_once('SecureController.php');

class IndexController extends SecureController{

	private $lang = null;
	
    public function  indexAction() {
        if(!$this->getUserName()){
            $this->_redirect('objecttype');
        }else if($this->getAuthUser()->getStatus()==1){
            $this->_redirect('objecttype');
        }else if($this->getAuthUser()->getStatus()==2){
            $this->_redirect('objecttype');
        }
    }
	
	public function changelangAction(){
		$this->setNoRender();
		$langSession = new Miqo_Session_Base();
		if(!$this->lang){
			$langSession->set('lang', "en");
		}else{
			$langSession->set('lang', $this->lang);
		}
		$this->redirect('index');
	}

	public function setLang($val){
		$this->lang = $val;
	}	
}