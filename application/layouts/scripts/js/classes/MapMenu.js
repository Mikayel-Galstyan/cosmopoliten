/**
* Map right click context menu class
*
* @author MIQO
* 
*/
ImageObject = {

    selectedObject:'',
    
    objectUniqId : '',
    
    currentId:0,
    
    zIndex : 1,
    
    deltaChange : 1,
    
	mainImage: '',
    
    pointWidth: 5,
	
	shotchik : 0,
	
    init: function(){
        //ImageObject.selectedObject = $('#mainImage');
		ImageObject.mainImage = $('#mainImage');
        ImageObject.zIndex = 0;
        ImageObject.shotchik = 0;
        ImageObject.currentId = 0;
		$('.objectDiv img').click(function(){
            $(this).clone().attr('id', 'templateDress_'+ImageObject.currentId).appendTo($('#imgDiv'));
            $('#templateDress_'+ImageObject.currentId).css({'position':'absolute','z-index':ImageObject.zIndex}).attr('class',$(this).attr('data-class'));
            var height =  $('#templateDress_'+ImageObject.currentId).height();
            var width =  $('#templateDress_'+ImageObject.currentId).width();
            var top =  (parseInt($('#templateDress_'+ImageObject.currentId).css('top')))?parseInt($('#templateDress_'+ImageObject.currentId).css('top')):0;
            var src = $('#templateDress_'+ImageObject.currentId).attr('src');
            var zIndex =  $('#templateDress_'+ImageObject.currentId).css('z-index');
            var left =  (parseInt($('#templateDress_'+ImageObject.currentId).css('left')))?parseInt($('#templateDress_'+ImageObject.currentId).css('left')):0;
            var html = '<input type="hidden" value="" name="tops[]" id="putinTop_'+ImageObject.currentId+'" value="0">'+
            '<input type="hidden" name="lefts[]" id="putinLeft_'+ImageObject.currentId+'" value="0">'+
            '<input type="hidden" name="widths[]" id="putinWidth_'+ImageObject.currentId+'" value="'+width+'">'+
            '<input type="hidden" name="heights[]" id="putinHeight_'+ImageObject.currentId+'" value="'+height+'">'+
            '<input type="hidden" name="srcs[]" id="putinSrcs_'+ImageObject.currentId+'" value="'+src+'">'+
            '<input type="hidden" name="rotates[]" id="putinRotate_'+ImageObject.currentId+'" value="'+0+'">'+
            '<input type="hidden" name="zIndexes[]" id="putinZIndex_'+ImageObject.currentId+'" value="'+ImageObject.zIndex+'">';
            $('#imgGenerate').append(html);
            ImageObject.selectedObject = $('#templateDress_'+ImageObject.currentId);
            ImageObject.selectedObject.css('position','absolute');
			ImageObject.addResizePoints(ImageObject.selectedObject);
            $(ImageObject.selectedObject ).draggable({ containment: "#imgDiv", scroll: false, 
				start: function() {
					ImageObject.resetResizePoints(ImageObject.selectedObject);
				},
				drag: function() {
					ImageObject.resetResizePoints(ImageObject.selectedObject);
				},
				stop: function() {
					ImageObject.resetResizePoints(ImageObject.selectedObject);
                    ImageObject.setInputValues(ImageObject.selectedObject);
				}
			});

            $('#imgDiv>img').mousedown(function(){
				ImageObject.zIndex++;
				ImageObject.selectedObject = $(this);
				$(this).css('z-index',ImageObject.zIndex)
				ImageObject.objectUniqId = $(this).attr('id').replace('templateDress_','');
				ImageObject.setInputValues(ImageObject.selectedObject);
				ImageObject.addResizePoints(ImageObject.selectedObject);
            });
            var html = "<div id='infoDress_"+ImageObject.currentId+
            "' ><a onclick='ImageObject.changeSelectedObject(\"select_"+ImageObject.currentId+"\")'>"+$(this).attr('name')+"</a>"+
            "<a onclick='ImageObject.removeObjectFromList(\"remove_"+ImageObject.currentId+"\")'>X</a></div>";
            $('#putInList').append(html);
            var html = "<div style='width:100%;height:100%;opacity:0.6;background:black;position:absolute;top:0px;left:0px;' id='disable_"+ImageObject.currentId+"'></div>";
            $(this).closest('.objectContentDiv').append(html);
            ImageObject.currentId++;
            ImageObject.zIndex++;
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
    
    changeSelectedObject:function(id){
        id = id.replace('select_','');
        $('#templateDress_'+id).css('z-index',ImageObject.zIndex);
        ImageObject.objectUniqId = id;
        ImageObject.selectedObject = $('#templateDress_'+id);
        ImageObject.setInputValues(ImageObject.selectedObject);
        ImageObject.addResizePoints(ImageObject.selectedObject);
        ImageObject.zIndex++;
    },
    
    removeObjectFromList : function(id){
        id = id.replace('remove_','');
        $('#infoDress_'+id).remove();
        $('#templateDress_'+id).remove();
        $('#putinSrcs_'+id).remove();
		$('#putinTop_'+id).remove();
        $('#putinLeft_'+id).remove();
        $('#putinWidth_'+id).remove();
        $('#putinHeight_'+id).remove();
        $('#putinRotate_'+id).remove();
        $('#putinZIndex_'+id).remove();
        $('#disable_'+id).remove();
        $('#leftTop').remove();
		$('#rightTop').remove();
		$('#rightBottom').remove();
		$('#leftBottom').remove(); 
    },
    
	addResizePoints: function(obj){
		var x1 = parseInt($(obj).css("left"))-ImageObject.pointWidth/2;
		var y1  = parseInt($(obj).css("top"))-ImageObject.pointWidth/2;
		var x2 = parseInt($(obj).css("left"))+parseInt($(obj).width())-ImageObject.pointWidth/2;
		var y2  = parseInt($(obj).css("top"))+parseInt($(obj).height())-ImageObject.pointWidth/2;
		html = '<div class="resizeButton" id="leftTop" style="top:'+y1+'px;left:'+x1+'px;position:absolute;width:'+ImageObject.pointWidth+';height:'+ImageObject.pointWidth+';background:black;z-index:10000000;"></div>'+
		'<div class="resizeButton" id="rightTop" style="top:'+y1+'px;left:'+x2+'px;width:'+ImageObject.pointWidth+';position:absolute;height:'+ImageObject.pointWidth+';background:black;z-index:10000000;"></div>'+
		'<div class="resizeButton" id="leftBottom" style="top:'+y2+'px;left:'+x2+'px;width:'+ImageObject.pointWidth+';position:absolute;height:'+ImageObject.pointWidth+';background:black;z-index:10000000;"></div>'+
		'<div class="resizeButton" id="rightBottom" style="top:'+y2+'px;left:'+x1+'px;width:'+ImageObject.pointWidth+';position:absolute;height:'+ImageObject.pointWidth+';background:black;z-index:10000000;"></div>';
		$('.resizeButton').remove();
		$('#imgDiv').append(html);
		$('#leftTop').css({'top':y1+'px','left':x1+'px'});
		$('#rightTop').css({'top':y1+'px','left':x2+'px'});
		$('#rightBottom').css({'top':y2+'px','left':x2+'px'});
		$('#leftBottom').css({'top':y2+'px','left':x1+'px'});
		$('.resizeButton').draggable({containment: "#imgDiv", scroll: false, 
			start: function(){
				ImageObject.shotchik = 0;
			},
			drag: function() {
				ImageObject.shotchik++;
				if(ImageObject.shotchik%15==0){
					ImageObject.resizeImageByPoints($(this).attr('id'));
				}
			},
            stop : function(){
            	ImageObject.resizeImageByPoints($(this).attr('id'));
            }
		});		
	},
	
	resetResizePoints: function(obj){
		var x1 = parseInt($(obj).css("left"))-ImageObject.pointWidth/2;
		var y1  = parseInt($(obj).css("top"))-ImageObject.pointWidth/2;
		var x2 = parseInt($(obj).css("left"))+parseInt($(obj).width())-ImageObject.pointWidth/2;
		var y2  = parseInt($(obj).css("top"))+parseInt($(obj).height())-ImageObject.pointWidth/2;
		$('#leftTop').css({'top':y1+'px','left':x1+'px'});
		$('#rightTop').css({'top':y1+'px','left':x2+'px'});
		$('#rightBottom').css({'top':y2+'px','left':x2+'px'});
		$('#leftBottom').css({'top':y2+'px','left':x1+'px'});
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
        ImageObject.resetResizePoints(ImageObject.selectedObject);
    },
    
    left : function(){
        var left = parseInt($(ImageObject.selectedObject).css('left'))+ImageObject.deltaChange;
        $(ImageObject.selectedObject).css('left',(left)?left:ImageObject.deltaChange);
    },
    
    right : function(){
        var left = parseInt($(ImageObject.selectedObject).css('left'))-ImageObject.deltaChange;
        $(ImageObject.selectedObject).css('left',(left)?left:ImageObject.deltaChange);
    },
    
    top : function(){
        var top = parseInt($(ImageObject.selectedObject).css('top'))+ImageObject.deltaChange;
        $(ImageObject.selectedObject).css('top',(top)?top:ImageObject.deltaChange);
    },
    
    bottom : function(){
        var bottom = parseInt($(ImageObject.selectedObject).css('top'))-ImageObject.deltaChange;
        $(ImageObject.selectedObject).css('top',(bottom)?bottom:-ImageObject.deltaChange);
    },
    
    zoomIn : function(){
        var width = parseInt($(ImageObject.selectedObject).width())+ImageObject.deltaChange;
        $(ImageObject.selectedObject).css({'width':width,'height':'auto'});
    },
    
    zoomOut : function(){
        var width = parseInt($(ImageObject.selectedObject).width())-ImageObject.deltaChange;
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
    
    resizeImageByPoints: function(id){
        var right = id.indexOf('right');
        var bottom = id.indexOf('Bottom');
        var resized = false;
        if((right<0 && bottom<0) || (right>=0 && bottom>=0)){
            var y1 = parseInt($('#leftTop').css('top'))+ImageObject.pointWidth/2;
            var x1 = parseInt($('#leftTop').css('left'))+ImageObject.pointWidth/2;
            var x2 = parseInt($('#rightBottom').css('left'))+ImageObject.pointWidth/2;
            var y2 = parseInt($('#rightBottom').css('top'))+ImageObject.pointWidth/2;
            var left = x1;
            var top = y1;
            if(x2>x1+10){
                var newWidth = x2-x1;
                resized = true;
            }
            if(y2>y1+10){
                var newHeight = y2-y1;
                resized = true;
            }
        }else{
            var y1 = parseInt($('#rightTop').css('top'))+ImageObject.pointWidth/2;
            var x1 = parseInt($('#rightTop').css('left'))+ImageObject.pointWidth/2;
            var x2 = parseInt($('#leftBottom').css('left'))+ImageObject.pointWidth/2;
            var y2 = parseInt($('#leftBottom').css('top'))+ImageObject.pointWidth/2;
            var left = parseInt($('#leftBottom').css('left'));
            var top = parseInt($('#rightTop').css('top')); 
            if(x1>x2+10){
                var newWidth = x1-x2;
                resized = true;
            }
            if(y2>y1+10){
                var newHeight = y2-y1;
                resized = true;
            }
        }
       
		
        if(resized){
            $(ImageObject.selectedObject).css({'width':newWidth,'height':newHeight,'top':(top),'left':(left)});
            console.log(newWidth);
            console.log(x2);
            ImageObject.resetResizePoints(ImageObject.selectedObject);
            ImageObject.setInputValues(ImageObject.selectedObject);
        }
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
        console.log(parseInt($(ImageObject.mainImage).css('left')));
        console.log(parseInt($(obj).css('left')));
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