<?php

class Dao_User extends Miqo_Dao_Base {
    protected $primaryColumn = 'id';
    protected $columnAliases = array (
            'id' => 'id',
            'email' => 'email',
            'company' => 'company',
            'last_name' => 'lastName',
            'first_name' => 'firstName',
            'date' => 'date',
            'password' => 'password',
            'password_salt' => 'passwordSalt',
            'status' => 'status',
            'agency_id' => 'agencyId',
            'publisher_id' => 'publisherId',
            'path' => 'path',
            'gender' => 'gender',
            'oauth_uid' => 'oauthUid',
            'oauth_provider' => 'oauthProvider',
            'twitter_oauth_token' => 'twitterOauthToken',
            'twitter_oauth_token_secret' => 'twitterOauthTokenSecret',
            'username' => 'username',
			'background' => 'background',
            'country_id' => 'countryId',
            'send_discount_maile_status' => 'sendDiscountMaileStatus',
            'activate' => 'activate',
            'activation_key' => 'activationKey',
            'used_last_image' => 'usedLastImage');
    protected $dateColumns = array('date');
    protected $entityClass = 'Domain_User';

    public function __construct() {
        $this->dbTable = new Dao_DbTable_User();
        $this->dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
        $this->dbAdapter->setFetchMode(Zend_Db::FETCH_OBJ);
    }

    public function authenticate($email, $password) {//echo $email;echo $password;exit;
        $users = $this->dbTable->fetchAll(array ('email = ?' => $email));
        if (sizeof($users) == 1) {
            $user = &$this->getEntity($users[0]);
            $salt = $user->getPasswordSalt();
            $password = hash("sha512", $password.$salt);
            $users = $this->dbTable->fetchAll(array ('email = ?' => $email, 'password = ?' => $password ));
            if (sizeof($users) == 1) {
                $user = &$this->getEntity($users[0]);
                return $user;
            }
        }
        return null;
    }

    public function updateImagePath($path,$id){
        $query = 'UPDATE users SET used_last_image="'.$path.'" where `id`= '.$id;
        $result = $this->dbAdapter->query($query); 
        return $result;
    }

    
    public function &getByParams(Filter_User $filter) {
        $select = $this->dbTable->select();
        $select = $this->applyFilter($filter, $select);
        if ($filter->getStatusIds()) {
            $select->where('status NOT IN (?)', $filter->getStatusIds());
        } else if($filter->getStatusId()){
            $select->where('status = ?', $filter->getStatusId());
        }
        $select->order( array($filter->getOrder() .' ' .$filter->getSort()) );
        $result = $this->dbTable->fetchAll($select);
        $items = $this->getEntities($result);
        return $items;
    }

    public function getByAgencyId($id) {
        $items = $this->dbTable->fetchAll(array ('agency_id = ?' => $id ));
        if (sizeof($items) == 1) {
            $items = $this->getEntity($items [0]);
            return $items;
        }
        return null;
    }
    
    public function activateUser($activate) {
        $query = 'UPDATE users SET activate=true
        where activation_key = '.$activate;
        $result = $this->dbAdapter->query($query); 
        if($result){
            $result = $this->dbTable->fetchRow(array ('where activation_key = ?' => $activate));
            $result = $this->getEntity($result);
        }
        return $result;
    }
    
    public function getByPublisherId($id) {
        $items = $this->dbTable->fetchAll(
                array('publisher_id = ?' => $id)
        );
       $items = $this->getEntities($items);
       return $items;
    }
    
    public function getByFacebookId($email) {
        $item = $this->dbTable->fetchRow(
                array('email = ?' => $email)
        );
       $item = $this->getEntity($item);
       return $item;
    }
    
    private function &applyFilter(Filter_User $filter, Zend_Db_Table_Select $select) {
        if ($filter->getCountryId()) {
            $select->where('country_id = ?', $filter->getCountryId());
        }
        return $select;
    }
}

?>
