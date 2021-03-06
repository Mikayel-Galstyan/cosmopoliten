<?php
require_once ('SecureController.php');

class AuthController extends SecureController {
    
    private $email = null;
    private $password = null;

    public function init() {
        parent::init();    
        $this->_helper->layout()->setLayout('layout');
        $this->LOG = Zend_Registry::get('log');
    }
    
    public function indexAction() {
        $this->_forward('layout');
    }
    
    public function loginAction() {
        if($this->_request->isXmlHttpRequest()) {
            //$this->javascript()->redirect('index');
        }
        $userSession = new Miqo_Session_Base();
        if ($userSession->get('authUser')) {
            $this->view->img = $userSession->get('authUser')->getPath();
        }else{
            
        }
        $request = $this->getRequest();        
        if ($request->isPost()) {
            $email = $this->email;
            $password = $this->password;
            if (! empty($email) && ! empty($password)) {
                $userService = new Service_User();
                $user = $userService->authenticate($email, $password);              
                if ($user != null) {                    
                    $this->loginSuccess($user, $userSession);
                }else{
					$this->view->loginfailed = true;
					$this->LOG->info('Failed login with Username  "' . $email . '"');
				}
            }else{
                $this->view->loginfailed = true;
                $this->LOG->info('Failed login with Username  "' . $email . '"');
            }
        }
    }

    private function loginSuccess($user, $userSession = null) {
        $url = 'index';
        if (!$userSession) {
            $userSession = new Miqo_Session_Base();
        }
        $userSession->set('authUser', $user);
        if($user->getStatus()==1){
            $publisherService = new Service_Publisher();
            $filter = new Filter_Publisher();
            $filter->setUserId($user->getId());    
            $publisher = $publisherService->getByUserId($filter);
            if($publisher){
                $userSession->set('publisherId', $publisher->getId());
            }else{
                $url = 'publisher/add';
            }
        }else if($user->getStatus()==2){
            $url = 'superadmin';
        }
        $this->LOG->info('Success login with Username -> "' . $user->getEmail() . '"'); 
        $this->javascript()->redirect($url);
    }

    public function logoutAction() {
        @Zend_Session::destroy(true);
        $this->javascript()->redirect('index');
    }

    public function &setEmail($val) {
        $this->email = $val;
        return $this;
    }
    
    public function &setPassword($val) {
        $this->password = $val;
        return $this;
    }

}
