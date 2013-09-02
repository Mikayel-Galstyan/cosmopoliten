<?php

class Domain_Comment extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $tableName = null;
    /**
     *
     * @var string
     */
    protected $message = null;
	/**
     *
     * @var int
     */
    protected $subjectId = null;
	/**
     *
     * @var int
     */
    protected $userId = null;
   
   
    public function getTableName() {
        return $this->tableName;
    }
    public function &setTableName($val) {
        $this->tableName = $val;
        return $this;
    }
	
    public function getMessage() {
        return $this->message;
    }
    public function &setMessage($val) {
        $this->message = $val;
        return $this;
    }
	
	public function getUserId() {
        return $this->userId;
    }
    public function &setUserId($val) {
        $this->userId = $val;
        return $this;
    }
	
	public function getSubjectId() {
        return $this->subjectId;
    }
    public function &setSubjectId($val) {
        $this->subjectId = $val;
        return $this;
    }
}
?>