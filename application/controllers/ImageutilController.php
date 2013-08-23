
	
	<?php
require_once ('SecureController.php');

class ImageutilController extends SecureController {
    
	
	protected function resize_image($file, $w, $h, $crop=FALSE) {
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
		$src = $this->imagecreatefromfile($file);
		/*$array =  $userfile_extn = explode(".", strtolower($file));
		$type = $array[count($array)-1];*/
		//list($width_orig, $height_orig, $type) = getimagesize($file); 
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($dst, false);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagesavealpha($dst, true);
		imagepng($dst,'users/'.$this->getAuthUser()->getEmail().'/templateImg1.png');
		return $dst;
	}
	
	protected function copyImage($mainPng,$file, $w, $h, $crop=FALSE) {
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
		$src = $this->imagecreatefromfile($file);
		/*$array =  $userfile_extn = explode(".", strtolower($file));
		$type = $array[count($array)-1];*/
		//list($width_orig, $height_orig, $type) = getimagesize($file); 
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($dst, false);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagesavealpha($dst, true);
		imagepng($dst,'users/'.$this->getAuthUser()->getEmail().'/templateImg1.png');
		return $dst;
	}
	
	protected function replaceBlackToTransparent($stype){
		
	}
	
	
	
	protected function imageToPng($srcFile) {
		$array =  $userfile_extn = explode(".", strtolower($srcFile));
		$type = $array[count($array)-1];
		$filePath = '';
		for($i=0;$i<count($array)-1;$i++){
			$filePath = $filePath.$array[$i];
		}
		switch ($type) 
		{
			case 'gif': 
				$image = imagecreatefromgif($srcFile); 
				break;   
			case 'jpg':  
				$image = imagecreatefromjpeg($srcFile); 
				break;
			case 'jpeg':  
				$image = imagecreatefromjpeg($srcFile); 
				break;   				
			case 'png':  
				$image = imagecreatefrompng($srcFile);
				break; 
			default:
				throw new Exception('Unrecognized image type ' . $type);
		}

		imagegif($image,$filePath);
		//throw new Exception('Image conversion failed.');
	}
	
	protected function imagecreatefromfile($path, $user_functions = false){
		$info = @getimagesize($path);
		 
		if(!$info){
			 return false;
		}
		 
		$functions = array(
			IMAGETYPE_GIF => 'imagecreatefromgif',
			IMAGETYPE_JPEG => 'imagecreatefromjpeg',
			IMAGETYPE_PNG => 'imagecreatefrompng',
			IMAGETYPE_WBMP => 'imagecreatefromwbmp',
			IMAGETYPE_XBM => 'imagecreatefromwxbm',
			);
		 
		if($user_functions){
			$functions[IMAGETYPE_BMP] = 'imagecreatefrombmp';
		}
		 
		if(!$functions[$info[2]]){
			 return false;
		}
		 
		if(!function_exists($functions[$info[2]])){
			 return false;
		}
		 
		return $functions[$info[2]]($path);
	}
}