<?php
require_once ('SecureController.php');

class CommentController extends ImageutilController {
    
    private $id = null;
    private $tableName = null;
    private $message = null;
    private $userId = null;
    private $subjectId = null;

    public function indexAction() {
        
    }
    
    public function listAction() {
       
    }
    
    public function editAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::USER_ROLE){
            $this->view->isUser = true;
            if($id){
                $service = new Service_Comment();
                $material = $service->getById($id);
                $this->view->item = $material;
            }
        }else{
            $this->view->isUser = false;
        }
       
    }
    
    public function saveAction(){
        $this->_helper->viewRenderer->setNoRender(true);
        if($this->getAuthUser()){
            $userId = $this->getAuthUser()->getId();
        }else{
            $this->_redirect('auth/login');
        }
        $service = new Service_Comment();
        if ($id) {
            $item = $service->getById($id);
        } else {
            $item = new Domain_Comment();
        }
        $item->setTableName($this->tableName);
        $item->setMessage($this->userId);
        $item->setSubjectId($this->subjectId);
        $item->setMessage($this->message);
        try {
            if($this->message){
                $service->save($item);
            }
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
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }

}
