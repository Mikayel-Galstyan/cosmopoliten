<?php
/**
 * @package application_views_helpers
 */

/**
 * View helper for translating strings.
 *
 * @package application_core_views_helpers
 **/

class Zend_View_Helper_getStatus extends Zend_View_Helper_Abstract {

    /**
     * Looks up in the translation keys.
     * 
     * If the $key is found returns the value of it, otherwise returns the $key.
     * 
     * @param string $keys
     * @param string $sep
     */
    public function getStatus($value) {
        
        if($value===1){
            $return = "IHaveNotSee";
        }else if($value===0){
            $return = "deactive";
        }else{
            $return = "active";
        }
        return $return;
    }
}

