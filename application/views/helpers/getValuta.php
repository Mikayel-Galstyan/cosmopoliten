<?php
/**
 * @package application_views_helpers 
 */

/**
 * View helper for escaping characters with special significances in HTML.
 *
 * @package application_views_helpers
 */
class Zend_View_Helper_getValuta extends Zend_View_Helper_Abstract {
    private $valuta = array('AMD','USD','EUR');
	
    public function getValuta($val) {
		if(isset($this->valuta[$val])){
			$valuta = $this->valuta[$val-1];
		}else{
			$valuta = $this->valuta[0];
		}
		return $valuta;
    }
}
?>