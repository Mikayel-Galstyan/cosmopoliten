<?php
require_once ('ImageutilController.php');

class UserController extends ImageutilController {
    
    const CONTROLLER_NAME = 'user';
    const DEFAULT_ORDER = 'id';
    const DEFAULT_SORT = 'ASC';

    private $id = null;
	private $url = null;
    private $email = null;
    private $company = null;
    private $lastName = null;
    private $firstName = null;
    private $password = null;
    private $passwordConfirm = null;
    private $status = null;
    private $gender = null;
    private $oauthUid = null;
    private $path  =  null;
    private $activate  =  null;
    private $activationKey = null;
    private $age = null;
    private $type = null;
    private $sendDiscountMaileStatus  =  null;
    private $order = self::DEFAULT_ORDER;
    private $sort = self::DEFAULT_SORT;

    public function indexAction() {
    }

    public function listAction() {
        $filter = new Filter_User();
        $filter->setId(Service_User::ADMIN_ROLE);
        $filter->setOrder($this->order);
        $filter->setSort($this->sort);
        $filter->setCountryId($this->getCountryId());
        if ($this->status) {
            $filter->setStatusId($this->status);
        }else{ 
            $filter->setStatusIds($this->getUserDenyRoles());
        }
        $service = new Service_User();
        $this->view->items = $service->getAllByParams($filter);
    }

    public function editAction() {
        //$countryService = new Service_Country();
        //$this->view->countryList = $countryService->getAll();
		$this->getStatus();
        $id = $this->id;
        if ($id) {
            $service = new Service_User();
			$seviceImg = new Service_UserImage();
            $user = $service->getById($id);
			//$img = $seviceImg->getByUserId($id);
            $this->view->item = $user;
        } else {
            //$this->LOG->info($this->getUserName().' : '.self::CONTROLLER_NAME.' Controller : add Action');
        }
		
    }

    public function deleteAction() {
        $this->disableLayout();
        $this->setNoRender();
        $id = $this->id;
        $service = new Service_User();
        try {
            $service->delete($id);
            $this->printJsonSuccess($this->translate('success.delete'));
        } catch ( Miqo_Util_Exception_Base $ex ) {
            $this->printJsonFail($this->translate('cant.delete.record'));
        }
    }

    public function confirmAction() {
        $this->view->id = $this->id;
    }
    
	
    public function saveAction() {
        $id = $this->id;
        $service = new Service_User();
        if ($id != null) {
            $item = $service->getById($id);
            $authantiticate = false;
        }else{
            $item = new Domain_User();
			$item->setStatus(($this->status)?$this->status:'2');
            $authantiticate = false;
        }
        if($this->email){
            $item->setEmail($this->email);
        }
        if($this->gender){
            $item->setGender($this->gender);
        }
        if($this->lastName){
            $item->setLastName($this->lastName);
        }
        if($this->firstName){
            $item->setFirstName($this->firstName);
        }
        $item->setActivate($this->activate);
        
        
        if ($this->password) {
            $item->setPassword($this->password);
            $item->setPasswordConfirm($this->passwordConfirm);
            $item->setPasswordSalt(ControllerActionSupport::getUniqueString());
        } else if($this->type=='byMail') {
            $password = 'Qw'.rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            $item->setPassword($password);
            $item->setPasswordConfirm($password);
            $item->setPasswordSalt(ControllerActionSupport::getUniqueString());
        }else{
            $item->setPassword(null);
            $item->setPasswordConfirm(null);
        }
        
        
		if(!is_dir ("users/".$this->email)){
			mkdir("users/".$this->email);
		}
        if(isset($_FILES['path']) && $_FILES['path']['name'] != ''){
            $path = $_FILES['path'];
            $email = $this->email;
            $userfile_extn = explode(".", strtolower($path['name']));
			$userfile_extn = $userfile_extn[count($userfile_extn)-1];
            do{
                $new_name = md5(rand ( -100000 , 100000 ));
                $fullPath = "users/".$email.'/'.$new_name.'.'.$userfile_extn;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name.'.'.$userfile_extn);
            move_uploaded_file ($path['tmp_name'],$fullPath);
        }else{
            $email = $this->email;
            do{
                $new_name = md5(rand ( -100000 , 100000 ));//.$userfile_extn[1];
                $fullPath = "users/".$email.'/'.$new_name.'.jpg';
            }while(file_exists($fullPath));
            if(isset($this->gender) && $this->gender==2){
                copy ('defaultImages/women.jpg' , $fullPath);
            }else{
                copy ('defaultImages/man.jpg' , $fullPath);
            }
        }
		$new_name = $new_name.'.png';
		$mainImg = $this->resize_image($fullPath,200,200,false,0.0000000001,"users/".$email.'/'.$new_name);
		$item->setPath($mainImg);
		$this->resize_image($fullPath,100,100,false,0.0000000001,"users/".$email.'/100x100_'.$new_name);
		$this->resize_image($fullPath,500,500,false,0.0000000001,"users/".$email.'/500x500_'.$new_name);
        if(!$id){
            $item->setUsedLastImage($mainImg);
        }
        try {
            if(isset($authantiticate) && !$authantiticate){
                $item = $service->save($item,$this->type);
            }
            if($this->getAuthUser()){
                $this->userSession =  new Miqo_Session_Base();
                $this->userSession->set('authUser', $item); 
                $urlId = ($this->id)?'/'.$this->id:'';
                $this->javascript()->redirect('user/'.$id.'/edit');
            }else{
                $this->userSession =  new Miqo_Session_Base();
                $this->userSession->set('authUser', $item); 
                $urlId = ($this->id)?'/'.$this->id:'';
                $this->javascript()->redirect(($this->status==1)?'publisher'.$urlId .'/edit':'index');
            }
            //$this->printJsonSuccessRedirect($this->translate('success.save'),($this->status==1)?'publisher'.$urlId .'/edit':'index');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
			if($this->type=='byMail'){
				$this->view->error = "error";
			}else{
				$this->view->error = "regError";
			}
        }
    }
    
    public function editadminAction(){
        $id = $this->id;
        $user = $this->getAuthUser();
        if($this->getAuthUser() && $this->getAuthUser()->getStatus()== Service_User::ADMIN_ROLE){
            $this->view->isAdmin = true;
            if($id){
                $service = new Service_User();
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
        $service = new Service_User();
        if ($id != null) {
            $item = $service->getById($id);
			$item->setActivate($this->activate);
			$item->setPassword(null);
			try {
				$item = $service->save($item);
				$this->printJsonSuccessRedirect($this->translate('success.save'),'superadmin');
			} catch ( Miqo_Util_Exception_Validation $vex ) {
				$errors = $this->translateValidationErrors($vex->getValidationErrors());
				
			}
        }else{
			$this->redirect('superadmin');
		}
        
	}
	
    public function &setId($val) {
        $this->id = $val;
        return $this;
    }
    public function &setEmail($val) {
        $this->email = $val;
        return $this;
    }
    public function &setStatus($val) {
    	$this->status = $val;
    	return $this;
    }
    public function &setCompany($val) {
        $this->company = $val;
        return $this;
    }
    public function &setLastName($val) {
        $this->lastName = $val;
        return $this;
    }
    public function &setFirstName($val) {
        $this->firstName = $val;
        return $this;
    }
    public function &setPassword($val) {
        $this->password = $val;
        return $this;
    }
    public function &setPasswordConfirm($val) {
        $this->passwordConfirm = $val;
        return $this;
    }
    public function &setPublisherId($val) {
        $this->publisherId = $val;
        return $this;
    }
    public function &setOrder($val) {
        $this->order = $val;
        return $this;
    }
    public function &setSort($val) {
        $this->sort = $val;
        return $this;
    }
    public function &setGender($val) {
        $this->gender = $val;
        return $this;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
    public function &setOauthUid($val) {
        $this->oauthUid = $val;
        return $this;
    }
	public function &setUrl($val) {
        $this->url = $val;
        return $this;
    }
    public function &setAge($val) {
        $this->age = $val;
        return $this;
    }
    public function &setActivationKey($val) {
        $this->sctivationKey = $val;
        return $this;
    }
    public function &setSendDiscountMaileStatus($val) {
        $this->sendDiscountMaileStatus = $val;
        return $this;
    }
    public function &setType($val) {
        $this->type = $val;
        return $this;
    }
    public function &setActivate($val) {
        $this->activate = $val;
        return $this;
    }
}