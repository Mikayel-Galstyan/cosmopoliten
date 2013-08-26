/**
* Map right click context menu class
*
* @author sourcio.com
* 
*/
Cosmo_object = {
    selected_element: null,
    currentId:0,
    zoomPixel: 2,
    init: function(){
        $('.objectDiv img').click(function(){
            $(this).clone().attr('id', 'templateDress_'+Cosmo_object.currentId).appendTo($('#ImageDiv span')); 
            $('#templateDress_'+Cosmo_object.currentId).mousedown(Cosmo_object.handle_mousedown);
            $('#templateDress_'+Cosmo_object.currentId).css('position','absolute').attr('class','');
            var height =  $('#templateDress_'+Cosmo_object.currentId).height();
            var width =  $('#templateDress_'+Cosmo_object.currentId).width();
            var top =  $('#templateDress_'+Cosmo_object.currentId).css('top');
            var src = $('#templateDress_'+Cosmo_object.currentId).attr('src');console.log(src);
            var left =  $('#templateDress_'+Cosmo_object.currentId).css('left');
            var html = '<input type="hidden" value="" name="tops[]" id="putinTop_'+Cosmo_object.currentId+'" value="'+parseInt(top)+'">'+
            '<input type="hidden" name="lefts[]" id="putinLeft_'+Cosmo_object.currentId+'" value="'+parseInt(left)+'">'+
            '<input type="hidden" name="widths[]" id="putinWidth_'+Cosmo_object.currentId+'" value="'+width+'">'+
            '<input type="hidden" name="heights[]" id="putinHeight_'+Cosmo_object.currentId+'" value="'+height+'">'+
            '<input type="hidden" name="srcs[]" id="putinHeight_'+Cosmo_object.currentId+'" value="'+src+'">';
            $('#imgGenerate').append(html);
            Cosmo_object.currentId++;
            
        });
        /*$('#heir img').click(function(){
            //$('#templateheir').remove();
            $(this).clone().attr('id', 'templateheir').appendTo($('#ImageDiv span'));
            $('#templateheir').css({'position':'absolute','top':'10px','left':'10px'});
            $('#templateheir').mousedown(Cosmo_object.handle_mousedown);
        });
        $('#gold img').click(function(){
            $('#goldTemplate').remove();
            $(this).clone().attr('id', 'goldTemplate').appendTo($('#ImageDiv span'));
            $('#goldTemplate').css({'position':'absolute','top':'10px','left':'10px'});
            $('#goldTemplate').mousedown(Cosmo_object.handle_mousedown);
        });
        $('#header img').click(function(){
            $('#headerTemplate').remove();
            $(this).clone().attr('id', 'headerTemplate').appendTo($('#ImageDiv span'));
            $('#headerTemplate').css({'position':'absolute','top':'10px','left':'10px'});
            $('#headerTemplate').mousedown(Cosmo_object.handle_mousedown);
        });*/
        window.onkeydown=function(e){
            if(e.keyCode == 109){//up
                Cosmo_object.zoomOut(Cosmo_object.selected_element,1.2);
            }
            if(e.keyCode == 107){//down
                Cosmo_object.zoomIn(Cosmo_object.selected_element,1.2);
            }  
        }
    },
    
    setInputValues: function(obj){
        var height = $(obj).height();
        var width = $(obj).width();
        var top = parseInt($(obj).css('top'));
        var left = parseInt($(obj).css('left'));
        var id = $(obj).attr('id').replace('templateDress_','');
        $('#putinTop_'+id).attr('value',top);
        $('#putinLeft_'+id).attr('value',left);
        $('#putinWidth_'+id).attr('value',width);
        $('#putinHeight_'+id).attr('value',height);
    },
    
    rotateY: function(elem,rad){
       
    },
    rotateZ: function(elem,rad){
       
    },
    rotateX: function(elem,rad){
        
    },
    zoomIn : function(elem,raized){
        $(elem).height((parseInt($(elem).height())*raized));
        //$(elem).width((parseInt($(elem).width())*raized));
        Cosmo_object.setInputValues(elem);
    },
    zoomOut : function(elem,raized){
        $(elem).height((parseInt($(elem).height())/raized));
        //$(elem).width((parseInt($(elem).width())/raized));console.log($(elem).width());
        Cosmo_object.setInputValues(elem);
    },
    handle_mousedown : function (e){
        window.my_dragging = {};
        my_dragging.pageX0 = e.pageX;
        my_dragging.pageY0 = e.pageY;
        my_dragging.elem = this;
        Cosmo_object.selected_element = this;
        my_dragging.offset0 = $(this).offset();
        function handle_dragging(e){
            var left = my_dragging.offset0.left + (e.pageX - my_dragging.pageX0);
            var top = my_dragging.offset0.top + (e.pageY - my_dragging.pageY0);
            if(left)
            $(my_dragging.elem)
            .offset({top: top, left: left});
            Cosmo_object.setInputValues(my_dragging.elem);
            
        }
        function handle_mouseup(e){
            $('body')
            .off('mousemove', handle_dragging)
            .off('mouseup', handle_mouseup);
        }
        $('body')
        .on('mouseup', handle_mouseup)
        .on('mousemove', handle_dragging);
    }
 }