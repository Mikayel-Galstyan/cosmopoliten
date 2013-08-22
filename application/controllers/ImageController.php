<?php

require_once('SecureController.php');

class ImageController extends SecureController {

    protected $widths = null;
    protected $heights = null;
	protected $lefts = null;
    protected $tops = null;
	protected $srcs = null;

    public function indexAction() {
		$dest = $this->resize_image($this->getAuthUser()->getPath(), 300,  225);
		for($i = 0;$i<count($this->widths);$i++){
			
			$img = $this->resize_image($this->srcs[$i], $this->widths[$i],  $this->heights[$i]);
			imagecopy($dest, $img, $this->lefts[$i], $this->tops[$i], 0, 0, $this->widths[$i], $this->heights[$i]);
			imagedestroy($img);
		}
		imageJpeg($dest,$this->getAuthUser()->getPath());
		imagedestroy($dest);
		$this->javascript()->redirect('lovelist');
   }
   
	private function resize_image($file, $w, $h, $crop=FALSE) {
		list($width, $height) = getimagesize($file);
		$r = $width / $height;
		if ($crop) {
			if ($width > $height) {
				$width = ceil($width-($width*($r-$w/$h)));
			} else {
				$height = ceil($height-($height*($r-$w/$h)));
			}
			$newwidth = $w;
			$newheight = $h;
		} else {
			if ($w/$h > $r) {
				$newwidth = $h*$r;
				$newheight = $h;
			} else {
				$newheight = $w/$r;
				$newwidth = $w;
			}
		}
		$src = imagecreatefromjpeg($file);
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		return $dst;
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
