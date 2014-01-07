<?php

class Service_Objects extends Miqo_Service_Base {
    private $validator = null;
    private static $VALIDATION_CONFIG = array (
            'path' => array (Miqo_Validation_Base::NOT_EMPTY),
            'objectTypeId' => array (Miqo_Validation_Base::NOT_EMPTY),
            'cost' => array (Miqo_Validation_Base::NOT_EMPTY),
            'publisherId' => array (Miqo_Validation_Base::NOT_EMPTY),
    );

    
    public function __construct() {
        parent::__construct();
        $this->dao = new Dao_Objects();
    }
    
    public function getByParams(Filter_Objects $filter, $foruser = 1){
        $items = $this->dao->getByParams($filter,$foruser);
        return $items;
    }
    
    public function addClick($id){
        $this->dao->addClick($id);
    }
    
    public function &__t_save(Domain_Objects $domain) {
        $errors = $this->validate($domain);       
        if (sizeof($errors) == 0) {
            $domain = $this->dao->save($domain);
            return $domain;
        } else {
            throw new Miqo_Util_Exception_Validation($errors, "save.of.user.is.suspended.as.there.are.validation.errors");
        }
    }
    
    public function &getObjectsByGroupId($groupId) {
    	$result = $this->dao->getObjectsByGroupId($groupId);
        return $result;
    }
    
    public function &getObjectsForGrouping() {
    	$result = $this->dao->getObjectsForGrouping();
        return $result;
    }
    
    public function validate(Domain_Objects $domain) {
        $validationConf = self::$VALIDATION_CONFIG;
        if ($this->validator == null) {
            $this->validator = new Miqo_Validation_Base($validationConf);
        }
        $errors = $this->validator->validate($domain);                   
        return $errors;
    }  
    

}
?>