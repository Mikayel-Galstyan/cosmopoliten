LoveListObject = {
    objectsCount : 0,
    my_evaluation : 0,
    evaluatedStars : [],
    //evaluatedStarsCount : 0,
    init    :   function(){
        var h = location.href;
        h=h.toString();
		//console.log(h.indexOf('lovelist'));
        /*if(h.indexOf('lovelist')<1){
            $('.objectDiv').hover(function(){
                var html = "<div  class='objectMask'><div>";
                $(this).append(html);
            }).mouseleave(function() {
                $('.objectMask').remove();
            });
        }*/
       
        LoveListObject.objectsCount = 0;
        $('.favourDiv>a').hover(function(){
            var img = 'images/objects/'+$(this).attr('data-img');
            $(this).closest('.favourDiv').css('background-image','url("'+img+'")');
            LoveListObject.my_evaluation = $(this).attr('data-evaluation');
        }).click(function(){
            var noChangeStars = LoveListObject.my_evaluation;
            var obj = $(this).closest('.objectContentDiv')[0];
            var id = $($(this).closest('.objectContentDiv')[0]).attr('data-id').replace('object_','');
            LoveListObject.evaluatedStars[id] = {
                objectId: id,
                evaluation:noChangeStars
            };
            console.log(LoveListObject.evaluatedStars);
            LoveListObject.evaluatedStarsCount++;
        });
        $('.favourDiv').mouseleave(function() {
            var id = $($(this).closest('.objectContentDiv')[0]).attr('data-id').replace('object_','');
            if(typeof LoveListObject.evaluatedStars[id] == 'object'){
                var obj = $(this).closest('.favourDiv').children('a')[LoveListObject.evaluatedStars[id].evaluation-1];
                $(this).closest('.favourDiv').css('background-image','url("images/objects/'+$(obj).attr('data-img')+'")');
            }else{
                $(this).closest('.favourDiv').css('background-image','url("images/objects/noStars.png")');
            }
        });
    },
    addLovleList : function(id){
        $('#'+id).attr('class','selectedLoveList');
        //$('#'+id).attr('onclick','LoveListObject.deleteFromSaveList("'+id+'")');
        id = id.replace('add_','');
        str = '<input type="hidden" id="template_'+id+'" name="objectsIds[]" value="'+id+'"/>';
        $('#addForm').append(str);
        LoveListObject.objectsCount++;
        if(LoveListObject.objectsCount == 1){
            $('#addToLoveList').show();
        }
    },
    
    deleteFromSaveList: function(id){
        $('#'+id).attr('class','unSelectedLoveList');
        id = id.replace('add_','');
        $('#template_'+id).remove();
        LoveListObject.objectsCount--;
        if(LoveListObject.objectsCount<1){
            $('#addToLoveList').hide();
        }
    },
    
    detectOption : function(id){
        if($('#'+id).attr('class')=='selectedLoveList'){
            LoveListObject.deleteFromSaveList(id);
        }else{
            LoveListObject.addLovleList(id);
        }
    }
};