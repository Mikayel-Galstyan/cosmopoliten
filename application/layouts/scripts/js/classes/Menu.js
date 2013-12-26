/**
* Navigation Menu class
* 
* Version 1.0
* 
* @author sourcio.com  
* 
*/
function Menu() {
    /**
     * SubMenu
     *
     * Display SubMenu
     */
    this.showSubMenu = function(){
        //Show SubMenu        
        $('.nav>li>a.active').siblings().show();
    };
    /**
     * Activate
     *
     * Activate Sub 
     */
    this.acitvate = function(href){
    	elem = $('.nav a[href="'+ href +'"]');        
        $('.nav a').removeClass('selectedMenu');
		elem.addClass('selectedMenu')
    };
};
$(function(){  
	$(document).on('mouseenter', '#nav_menu>li', function() {
		$this = $(this).children('a');
        $('#nav_menu>li>ul').hide();
        $this.siblings().show();
	});
	$(document).on('mouseleave', '#nav_menu>li', function() {
		$this = $(this).children('a');
        if(!$this.hasClass('active')){
            $this.siblings().hide();
            Menu.showSubMenu();          
        }
	});
});
