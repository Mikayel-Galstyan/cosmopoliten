/**
* Map right click context menu class
*
* @author sourcio.com
* 
*/
ImageObject = {

    selectedObject:'',
    
    objectUniqId : '',
    
    currentId:0,
    
    zIndex : 1,
    
	mainImage: '',
	
    init: function(){
        //ImageObject.selectedObject = $('#mainImage');
		ImageObject.mainImage = $('#mainImage');
        $('#mainImage').css('position','absolute');
		$('.objectDiv img').click(function(){
            $(this).clone().attr('id', 'templateDress_'+ImageObject.currentId).appendTo($('#imgDiv'));
            $('#templateDress_'+ImageObject.currentId).css({'position':'absolute','z-index':ImageObject.zIndex}).attr('class',$(this).attr('data-class'));
            var height =  $('#templateDress_'+ImageObject.currentId).height();
            var width =  $('#templateDress_'+ImageObject.currentId).width();
            var top =  $('#templateDress_'+ImageObject.currentId).css('top');
            var src = $('#templateDress_'+ImageObject.currentId).attr('src');
            var zIndex =  $('#templateDress_'+ImageObject.currentId).css('z-index');
            var left =  $('#templateDress_'+ImageObject.currentId).css('left');
            var html = '<input type="hidden" value="" name="tops[]" id="putinTop_'+ImageObject.currentId+'" value="'+parseInt(top)+'">'+
            '<input type="hidden" name="lefts[]" id="putinLeft_'+ImageObject.currentId+'" value="'+parseInt(left)+'">'+
            '<input type="hidden" name="widths[]" id="putinWidth_'+ImageObject.currentId+'" value="'+width+'">'+
            '<input type="hidden" name="heights[]" id="putinHeight_'+ImageObject.currentId+'" value="'+height+'">'+
            '<input type="hidden" name="srcs[]" id="putinHeight_'+ImageObject.currentId+'" value="'+src+'">'+
            '<input type="hidden" name="rotates[]" id="putinRotate_'+ImageObject.currentId+'" value="'+0+'">'+
            '<input type="hidden" name="zIndexes[]" id="putinZIndex_'+ImageObject.currentId+'" value="'+ImageObject.zIndex+'">';
            $('#imgGenerate').append(html);
            ImageObject.selectedObject = $('#templateDress_'+ImageObject.currentId);
            ImageObject.selectedObject.css('position','absolute');
			ImageObject.addResizePoints(ImageObject.selectedObject);
            $(ImageObject.selectedObject ).draggable({ containment: ".loveListWorkDiv", scroll: false, 
				start: function() {
					ImageObject.resetResizePoints(ImageObject.selectedObject);
				},
				drag: function() {
					ImageObject.resetResizePoints(ImageObject.selectedObject);
				},
				stop: function() {
					ImageObject.resetResizePoints(ImageObject.selectedObject);
				}
			});
            ImageObject.currentId++;
            ImageObject.zIndex++;
            $('#imgDiv>img').click(function(){
				ImageObject.zIndex++;
				ImageObject.selectedObject = $(this);
				$(this).css('z-index',ImageObject.zIndex)
				ImageObject.objectUniqId = $(this).attr('id').replace('templateDress_','');
				ImageObject.setInputValues(ImageObject.selectedObject);
				ImageObject.addResizePoints(ImageObject.selectedObject);
            });
        });
		$('#imgDiv>img').click(function(){
			ImageObject.zIndex++;
			ImageObject.selectedObject = $(this);
			$(this).css('z-index',ImageObject.zIndex)
			ImageObject.objectUniqId = $(this).attr('id').replace('templateDress_','');
			ImageObject.setInputValues(ImageObject.selectedObject);
			ImageObject.addResizePoints(ImageObject.selectedObject);
		});
        window.onkeydown=function(e){
            if(e.keyCode == 109){//min
                ImageObject.move('out')
            }
            if(e.keyCode == 107){//plus
               ImageObject.move('in')
            }
			if(e.keyCode == 38){//down
               ImageObject.move('down')
            }
			if(e.keyCode == 40){//up
               ImageObject.move('up')
            }
			if(e.keyCode == 37){//down
               ImageObject.move('right')
            }
			if(e.keyCode == 39){//down
               ImageObject.move('left')
            }
        }
    },
    
	addResizePoints: function(obj){
		var x1 = parseInt($(obj).css("left"))-2.5;
		var y1  = parseInt($(obj).css("top"))+7.5;
		var x2 = parseInt($(obj).css("left"))+parseInt($(obj).width())-2.5;
		var y2  = parseInt($(obj).css("top"))+parseInt($(obj).height())+7.5;
		html = '<div class="resizeButton" id="leftTop" style="top:'+y1+'px;left:'+x1+'px;position:absolute;width:5px;height:5px;background:black;z-index:10000000;"></div>'+
		'<div class="resizeButton" id="rightTop" style="top:'+y1+'px;left:'+x2+'px;width:5px;position:absolute;height:5px;background:black;z-index:10000000;"></div>'+
		'<div class="resizeButton" id="leftBottom" style="top:'+y2+'px;left:'+x2+'px;width:5px;position:absolute;height:5px;background:black;z-index:10000000;"></div>'+
		'<div class="resizeButton" id="rightBottom" style="top:'+y2+'px;left:'+x1+'px;width:5px;position:absolute;height:5px;background:black;z-index:10000000;"></div>';
		$('.resizeButton').remove();
		$('#imgDiv').append(html);
		$('#leftTop').css({'top':y1+'px','left':x1+'px'});
		$('#rightTop').css({'top':y1+'px','left':x2+'px'});
		$('#leftBottom').css({'top':y2+'px','left':x2+'px'});
		$('#rightBottom').css({'top':y2+'px','left':x1+'px'});
		$('.resizeButton').draggable({containment: "#imgDiv", scroll: false, 
			drag: function() {
				console.log($(this).attr('id'));
			}
		});		
	},
	
	resetResizePoints: function(obj){
		var x1 = parseInt($(obj).css("left"))-2.5;
		var y1  = parseInt($(obj).css("top"))+2.5;
		var x2 = parseInt($(obj).css("left"))+parseInt($(obj).width())-2.5;
		var y2  = parseInt($(obj).css("top"))+parseInt($(obj).height())+2.5;
		$('#leftTop').css({'top':y1+'px','left':x1+'px'});
		$('#rightTop').css({'top':y1+'px','left':x2+'px'});
		$('#leftBottom').css({'top':y2+'px','left':x2+'px'});
		$('#rightBottom').css({'top':y2+'px','left':x1+'px'});
	},
	
	resizeLeftTop: function(obj){
		x = parseInt($(obj).css('top'))+2.5;
		y = parseInt($(obj).css('left'))-2.5;
	},
	
	resizeLeftTop: function(){
	
	},
	
	resizeLeftTop: function(){
	
	},
	
	resizeLeftTop: function(){
	
	},
	
    move : function(doing){
        switch (doing){
            case 'left': 
                ImageObject.left();
                break;
            case 'up': 
                ImageObject.top();
                break;   
            case 'right': 
                ImageObject.right();
                break;
            case 'down': 
                ImageObject.bottom();
                break;
            case 'in': 
                ImageObject.zoomIn();
                break;
            case 'out': 
                ImageObject.zoomOut();
                break;
            case 'rotateLeft': 
                ImageObject.rotateLeft();
                break;
            case 'rotateRight': 
                ImageObject.rotateRight();
                break;
            case 'widthIn': 
                ImageObject.widthIn();
                break;
            case 'widthOut': 
                ImageObject.widthOut();
                break;
            case 'heightIn': 
                ImageObject.heightIn();
                break;
            case 'heightOut': 
                ImageObject.heightOut();
                break;
            default: 
                break;
        }
        ImageObject.setInputValues(ImageObject.selectedObject);
    },
    
    left : function(){
        var left = parseInt($(ImageObject.selectedObject).css('left'))+1;
        $(ImageObject.selectedObject).css('left',(left)?left:1);
    },
    
    right : function(){
        var left = parseInt($(ImageObject.selectedObject).css('left'))-1;
        $(ImageObject.selectedObject).css('left',(left)?left:1);
    },
    
    top : function(){
        var top = parseInt($(ImageObject.selectedObject).css('top'))+1;
        $(ImageObject.selectedObject).css('top',(top)?top:1);
    },
    
    bottom : function(){
        var bottom = parseInt($(ImageObject.selectedObject).css('top'))-1;
        $(ImageObject.selectedObject).css('top',(bottom)?bottom:-1);
    },
    
    zoomIn : function(){
        var width = parseInt($(ImageObject.selectedObject).width())+1;
        $(ImageObject.selectedObject).css({'width':width,'height':'auto'});
    },
    
    zoomOut : function(){
        var width = parseInt($(ImageObject.selectedObject).width())-1;
        $(ImageObject.selectedObject).css({'width':width,'height':'auto'});
    },
    
    rotateLeft : function(){
        var rotate = ImageObject.getRotationDegrees($(ImageObject.selectedObject)).toString();console.log(rotate);
        var index = rotate.indexOf('(');
        rotate.replace(rotate.substring(0,index),'');
        rotate.replace('rotate(','');
        rotate.replace('deg)','');
        rotate = parseInt(rotate)+1;
        $(ImageObject.selectedObject).css({'transform':'rotate('+rotate+'deg)','-ms-transform':'rotate('+rotate+'deg)','-webkit-transform':'rotate('+rotate+'deg)'});
    },
    
    rotateRight : function(){
        var rotate = ImageObject.getRotationDegrees($(ImageObject.selectedObject)).toString();console.log(rotate);
        var index = rotate.indexOf('(');
        rotate.replace(rotate.substring(0,index),'');
        rotate.replace('rotate(','');
        rotate.replace('deg)','');
        rotate = parseInt(rotate)-1;
        $(ImageObject.selectedObject).css({'transform':'rotate('+rotate+'deg)','-ms-transform':'rotate('+rotate+'deg)','-webkit-transform':'rotate('+rotate+'deg)'});

    },
    
    widthIn : function(){
        var width = parseInt($(ImageObject.selectedObject).width())-1;
        $(ImageObject.selectedObject).css({'width':width,'height':$(ImageObject.selectedObject).height()});
    },
    
    widthOut : function(){
        var width = parseInt($(ImageObject.selectedObject).width())+1;
        $(ImageObject.selectedObject).css({'width':width,'height':$(ImageObject.selectedObject).height()});
    },
    
    heightIn : function(){
        var height = parseInt($(ImageObject.selectedObject).height())-1;
        $(ImageObject.selectedObject).css('height',height);
    },
    
    heightOut : function(){
        var height = parseInt($(ImageObject.selectedObject).height())+1;
        $(ImageObject.selectedObject).css('height',height);
    },
    getRotationDegrees: function(obj) {
        var matrix = obj.css("-webkit-transform") ||
        obj.css("-moz-transform")    ||
        obj.css("-ms-transform")     ||
        obj.css("-o-transform")      ||
        obj.css("transform");
        if(matrix !== 'none') {
            var values = matrix.split('(')[1].split(')')[0].split(',');
            var a = values[0];
            var b = values[1];
            var angle = Math.round(Math.atan2(b, a) * (180/Math.PI));
        } else { var angle = 0; }
        return (angle < 0) ? angle +=360 : angle;
    },
    
     setInputValues: function(obj){
        var height = $(obj).height();
        var width = $(obj).width();
        var top = parseInt($(obj).css('top'))-parseInt($(ImageObject.mainImage).css('top'));
        var left = parseInt($(obj).css('left'))-parseInt($(ImageObject.mainImage).css('left'));
        var rotate = parseInt(ImageObject.getRotationDegrees(obj));
        var zIndex = parseInt($(obj).css('z-index'));
        var id = $(obj).attr('id').replace('templateDress_','');
        $('#putinTop_'+id).attr('value',top);
        $('#putinLeft_'+id).attr('value',left);
        $('#putinWidth_'+id).attr('value',width);
        $('#putinHeight_'+id).attr('value',height);
        $('#putinRotate_'+id).attr('value',rotate);
        $('#putinZIndex_'+id).attr('value',zIndex);
    },
}