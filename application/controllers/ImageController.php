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
	protected $src = null;

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
			$dest = $this->resize_image($this->src, $this->width,  $this->height,true);
			$dest =  imagecreatefrompng($dest);
			for($i = 0;$i<count($this->widths);$i++){ 
				$img = $this->resize_image($this->srcs[$i], $this->widths[$i],  $this->heights[$i],true, ($this->rotates[$i])?(-$this->rotates[$i]):0.00000001);
				$img =  imagecreatefrompng($img);
				imagesavealpha($dest, true);
				imagealphablending($dest, true);
				@imagecopy($dest, $img, $this->lefts[$i], $this->tops[$i], 0, 0, $this->widths[$i], $this->heights[$i]);
				imagedestroy($img);
			}
			do{
				$new_name = md5(rand ( -100000 , 100000 )).'.png';
				$url = 'users/'.$this->getAuthUser()->getEmail().'/'.$new_name;
			}while(file_exists($url));
			$black = imagecolorallocate($dest, 0, 0, 0);
			imagecolortransparent($dest, $black);
			imagesavealpha($dest, true);
			imagepng($dest,$url);
			imagedestroy($dest);
			$width = $this->width;
			$height = $this->height;
			$this->view->imgSrcFrom = $this->getAuthUser()->getUsedLastImage();
			$this->view->imgSrc = $url;
    }
	
	public function saveAction(){
        $path = $this->path;
        $service = new Service_UserImage();
        $domain = new Domain_UserImage();
        $domain->setUserId($this->getAuthUser()->getId());
		$domain->setParentId($this->getAuthUser()->getUsedLastImage());
        $domain->setPath($path);
        try {
            $service->save($domain);
            $this->javascript()->redirect('lovelist');
        } catch ( Miqo_Util_Exception_Validation $vex ) {
            $errors = $this->translateValidationErrors($vex->getValidationErrors());
            $this->printJsonError($errors, $this->translate('validation.error'));
        }
        
	}
    
    public function noAction(){
		$path = $this->path;
		unlink($path);
	}
	
    public function uploadimageAction(){
         $email = $this->getAuthUser()->getEmail();
        if(!is_dir ("users/".$email)){
			mkdir("users/".$email);
		}
        if(isset($_FILES['path']) && $_FILES['path']['name'] != ''){
            $userId = $this->getAuthUser()->getId();
            $service = new Service_UserImage();
            $item = new Domain_UserImage();
            $path = $_FILES['path'];
            $userfile_extn = explode(".", strtolower($path['name']));
			$userfile_extn = $userfile_extn[count($userfile_extn)-1];
            do{
                $new_name = md5(rand ( -100000 , 100000 ));
                $fullPath = "users/".$email.'/'.$new_name.'.'.$userfile_extn;
            }while(file_exists($fullPath));
            @rename ($path['name'],$new_name.'.'.$userfile_extn);
            move_uploaded_file ($path['tmp_name'],$fullPath);
			$new_name = $new_name.'png';
			$filePath  = $this->resize_image($fullPath,200,200,false,0.0000000001,"users/".$email.'/'.$new_name);
			$this->resize_image($fullPath,100,100,false,0.0000000001,"users/".$email.'/100x100_'.$new_name);
			$this->resize_image($fullPath,500,500,false,0.0000000001,"users/".$email.'/500x500_'.$new_name);
			
            $item->setPath($filePath);
            $item->setUserId($userId);
            $this->view->imagePath = $filePath;
            $serviceUser = new Service_User();
            try {
                $item = $service->save($item);
                $serviceUser->updateImagePath($filePath,$userId);
                $item = $this->getAuthuser();
                $item->setUsedLastImage($filePath);
                if (!$this->userSession) {
                    $this->userSession = new Miqo_Session_Base();
                }
                $this->userSession->set('authUser', $item);
                //$this->printJsonSuccessRedirect($this->translate('success.save'),($this->status==1)?'publisher'.$urlId .'/edit':'index');
            } catch ( Miqo_Util_Exception_Validation $vex ) {
                $errors = $this->translateValidationErrors($vex->getValidationErrors());
                $this->printJsonError($errors, $this->translate('validation.error'));
            }
        }
    }
	
    public function myalbomAction(){
		$service = new Service_UserImages();
        //$serviceUser = new Service_User();
		//$images = $service->getByUserId()
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
