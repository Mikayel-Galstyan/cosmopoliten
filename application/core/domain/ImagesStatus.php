<?php

class Domain_ImagesStatus extends Miqo_Domain_AbstractEntity {
    /**
     *
     * @var string
     */
    protected $name = null;
    /**
     *
     * @var string
     */
    protected $path = null;
	/**
     *
     * @var int
     */
    protected $likes = null;
   
    public function getName() {
        return $this->name;
    }
    public function &setName($val) {
        $this->name = $val;
        return $this;
    }
    public function getPath() {
        return $this->path;
    }
    public function &setPath($val) {
        $this->path = $val;
        return $this;
    }
	public function getLikes() {
        return $this->likes;
    }
    public function &setLikes($val) {
        $this->likes = $val;
        return $this;
    }
}
?>