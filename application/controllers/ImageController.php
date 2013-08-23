<?php

require_once('ImageutilController.php');

class ImageController extends ImageutilController {

    protected $widths = null;
    protected $heights = null;
	protected $lefts = null;
    protected $tops = null;
	protected $srcs = null;

    public function indexAction() {
		$dest = $this->resize_image($this->getAuthUser()->getPath(), 300,  225);
		for($i = 0;$i<count($this->widths);$i++){
			$img = $this->resize_image($this->srcs[$i], $this->widths[$i],  $this->heights[$i]);
			imagecopymerge($dest, $img, $this->lefts[$i], $this->tops[$i], 0, 0, $this->widths[$i], $this->heights[$i],50);
			imagedestroy($img);
		}
		
		$url = 'users/'.$this->getAuthUser()->getEmail().'/templateImg.png';
		imagepng($dest,$url);
		imagedestroy($dest);
		$this->replaceBlackToTransparent($url);
		$this->view->imgSrc = $url;
		//$this->javascript()->redirect('lovelist');
	}
	
	public function saveAction(){
		$this->_helper->viewRenderer->setNoRender(true);
	}
	
	public function &setWidths($val) {
       $this->widths = $val;
       return $this;
	}
	public function &setHeights($val) {
       $this->heights = $val;
       return $this;
	}
    public function &setLefts($val) {
       $this->lefts = $val;
       return $this;
	}
	public function &setTops($val) {
       $this->tops = $val;
       return $this;
	}
    public function &setSrcs($val) {
       $this->srcs = $val;
       return $this;
	}
}

?>
