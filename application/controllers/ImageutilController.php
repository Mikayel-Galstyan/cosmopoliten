<?php
require_once ('SecureController.php');

class ImageutilController extends SecureController {
    
	protected function imageCreateTransparent($img,$x, $y) {
        $colourBlack = imagecolorallocate($img, 0, 0, 0);
        imagefill ( $img, 0, 0, $colourBlack );
        imagecolortransparent($img, $colourBlack);
        return $imageOut;
    }
    
    protected function getPixel($image, $x, $y) {
        @$colorAt  = imagecolorat($image, $x, $y);
        $colors = imagecolorsforindex($image,$colorAt);
        
        $inrgba = 'rgba(' . $colors['red'] . ',' . $colors['green'] . ',' . $colors['blue'] . ',' . $colors['alpha'] . ')';
        if($colors['red']==0 && $colors['green']==0 && $colors['blue']==0){
             imagecolorallocate ( $image , 255 , 255 , 255 );
        }
        return $inrgba;
    }
    
    
	protected function resize_image($file, $w, $h, $crop=FALSE,$degrees = 0.0000000001,$newPath=null) {
        $src = $this->imagecreatefromfile($file);
         /*rotate*/
            $src = imagerotate($src, $degrees, imageColorAllocateAlpha($src, 0, 0, 0, 127));
            imagealphablending($src, false);
            imagesavealpha($src, false);
			if($newPath){
				$file = $newPath;
			}else{
				$file = 'users/'.$this->getAuthUser()->getEmail().'/templateImg1.png';
			}
			imagepng($src, $file);
        /**/
		list($width, $height) = getimagesize($file);
		$r = $width / $height;
		if ($crop) {
			/*if ($width > $height) {
				$width = ceil($width-($width*($r-$w/$h)));
			} else {
				$height = ceil($height-($height*($r-$w/$h)));
			}*/
			$newwidth = $w;
			$newheight = $h;
		} else {
			if ($h != 0 && $w/$h > $r) {
				$newwidth = round($h*$r);
				$newheight = round($h);
			} else {
				$newheight = round($w/$r);
				$newwidth = round($w);
			}
		}
		$dst = imagecreatetruecolor($newwidth, $newheight);
		imagealphablending($dst, false);
		imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
		imagesavealpha($dst, true);
		imagepng($dst, $file);
        $width = $newwidth;
        $height = $newheight;
		return $file;
	}
	
	protected function imageToPng($srcFile) {
		$array =  $userfile_extn = explode(".", strtolower($srcFile));
		$type = $array[count($array)-1];
		if($type != "png"){
			$type = $array[count($array)-1];
			$filePath = $array[0];
			for($i=1;$i<count($array)-1;$i++){
				$filePath = $filePath.'.'.$array[$i];
			}
			$filePath = $filePath.'.png';
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
			
			imagePng($image,$filePath);
			return $filePath;
		}else{
			return $srcFile;
		}
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