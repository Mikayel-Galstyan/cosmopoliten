<?php

require_once ('ControllerActionSupport.php');

abstract class SecureController extends ControllerActionSupport {
    protected $userSession = null;
    private $userName = null;

    public function preDispatch() {
        parent::preDispatch();
        $userSession = new Miqo_Session_Base();
        $this->userSession = $userSession;
        if($this->isXmlHttpRequest()) {
            $this->disableLayout();
        }
        $this->setHTMLContentType();
        $page = $this->getRequest()->getControllerName();
        
        //$this->LOG->info($this->getUserName().' : '.$this->getRequest()->getControllerName().' Controller : '.$this->getRequest()->getActionName().' Action');
    }
    

    public function postDispatch() {
        parent::postDispatch();
    }

    public function getAuthUser(){
        $authUser = $this->userSession->get('authUser');
        return $authUser;
    }
    
    public function getPublisherId(){
        $authUser = $this->userSession->get('publisherId');
        return $authUser;
    }
    
    public function getUserDenyRoles(){
    	return self::$ACCESS_DEFINITIONS[$this->view->getUser()->getStatus()]['deny']['viewuser'];
    }
    
    public function getCountryId(){
        return $this->userSession->get('countryId');
    }

    protected function getUniqueKey() {
        return Zend_Session::getId();
    }
    
    protected function getStatus(){
        $auth = $this->getAuthUser();
        if($auth && $auth->getStatus()== Service_User::PUBLISHER_ROLE){
            $this->view->isPublisher = true;
            $this->view->isUser = false;
			$this->view->isAdmin = false;
        }else if($auth && $auth->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isPublisher = false;
            $this->view->isUser = false;
			$this->view->isAdmin = true;
        }else if($auth){
			$this->view->isPublisher = false;
            $this->view->isUser = true;
			$this->view->isAdmin = false;
		}else{
            $this->view->isPublisher = false;
            $this->view->isUser = false;
			$this->view->isAdmin = false;
        }
    }
    
    protected function getUserName() {
        if(!$this->userName) {
            $userSession = new Miqo_Session_Base();
            $userDomain = $userSession->get('authUser');
            if($userDomain){
                $this->userName = $userDomain->getEmail();
            }
        }
        return $this->userName;
    }
}
