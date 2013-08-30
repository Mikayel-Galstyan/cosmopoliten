<?php

require_once('ImageutilController.php');

class ImageController extends ImageutilController {

    protected $widths = null;
    protected $heights = null;
	protected $lefts = null;
    protected $tops = null;
	protected $srcs = null;
    protected $rotates = null;
    protected $zIndexes = null;
    
    protected $width = null;
    protected $height = null;
    protected $path = null;
	//protected $src = null;

    public function indexAction() {
		
	}
    
    public function listAction(){
            for($i=0;$i<count($this->widths)-1;$i++){
                for($j=$i+1;$j<count($this->widths);$j++){
                    if($this->zIndexes[$i]>$this->zIndexes[$j]){
                        $zIndex = $this->zIndexes[$i];
                        $path = $this->srcs[$i];
                        $rotate = $this->rotates[$i];
                        $widths = $this->widths[$i];
                        $heights = $this->heights[$i];
                        $tops = $this->tops[$i];
                        $lefts = $this->lefts[$i];
                        
                        $this->zIndexes[$i] = $this->zIndexes[$j];
                        $this->rotates[$i] = $this->rotates[$j];
                        $this->widths[$i] = $this->widths[$j];
                        $this->heights[$i] = $this->heights[$j];
                        $this->tops[$i] = $this->tops[$j];
                        $this->lefts[$i] = $this->lefts[$j];
                        $this->srcs[$i] = $this->srcs[$j];
                        
                        $this->zIndexes[$j] = $zIndex;
                        $this->srcs[$j] = $path;
                        $this->rotates[$j] = $rotate;
                        $this->widths[$j] = $widths;
                        $this->heights[$j] = $heights;
                        $this->tops[$j] = $tops;
                        $this->lefts[$j] = $lefts;
                    }
                }
            }
			$dest = $this->resize_image($this->getAuthUser()->getPath(), $this->width,  $this->height,true);
			for($i = 0;$i<count($this->widths);$i++){ 
				$img = $this->resize_image($this->srcs[$i], $this->widths[$i],  $this->heights[$i],true, ($this->rotates[$i])?(-$this->rotates[$i]):0.1);
				imagesavealpha($dest, true);
				imagealphablending($dest, true);
				@imagecopy($dest, $img, $this->lefts[$i], $this->tops[$i], 0, 0, $this->widths[$i], $this->heights[$i]);
				imagedestroy($img);
			}
			$url = 'users/'.$this->getAuthUser()->getEmail().'/templateImg.png';
			$black = imagecolorallocate($dest, 0, 0, 0);
			imagecolortransparent($dest, $black);
			imagesavealpha($dest, true);
			imagepng($dest,$url);
			imagedestroy($dest);
			$width = $this->width;
			$height = $this->height;
			$this->view->imgSrc = $url;
    }
	
	public function saveAction(){
        $path = $this->path;
        $userDomain = $this->getAuthUser();
        $userfile_extn = explode(".", strtolower($path));
        do{
            $new_name = md5(rand ( -100000 , 100000 )).'.'.$userfile_extn[count($userfile_extn)-1];
            $url = 'users/'.$userDomain->getEmail().'/'.$new_name;
        }while(file_exists($url));
        $result  = @rename ($path,$url);
        $service = new Service_UserImage();
        $domain = new Domain_UserImage();
        $domain->setUserId($userDomain->getId());
        $domain->setPath($url);
        try {
            $service->save($domain);
            $this->javascript()->redirect('lovelist');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
        
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
    public function &setSrc($val) {
       $this->src = $val;
       return $this;
	}
    public function &setWidth($val) {
       $this->width = $val;
       return $this;
	}
	public function &setHeight($val) {
       $this->height = $val;
       return $this;
	}
    public function &setPath($val) {
       $this->path = $val;
       return $this;
	}
    public function &setZIndexes($val) {
       $this->zIndexes = $val;
       return $this;
	}
    public function &setRotates($val) {
       $this->rotates = $val;
       return $this;
	}
}

?>
