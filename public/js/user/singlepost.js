   
    $(function(){

    $('.commentTextArea').bind('keyup',function (e){
	
	if(e.keyCode==13)
		{
			var element = $(this);
			var comment =$(this).val();
            var srcPic = element.parent().find('.comment_pic').attr('src');
            var nameCommentor = element.parent().find('.comment_pic').attr('alt');
			//alert($(this).attr('id'));
			var obj = {'comment':$(this).val(),'id_post':$(this).attr('id') };
            
			var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'comment',), 'default') ?> ';
			
			
		$.ajax({

            type : 'POST',
            url  : url,
            data : obj,
            beforeSend: function()
            {
                $('.commentTextArea').attr("disabled","true");
                
            },
			 success :  function(data)
            {
                if(data=="error"){
						$(this).parent().parent().prepend('Connessione assente?');
                    
                }
                else if(data=="OK")
                {
					$('.commentTextArea').val('');
					$('.commentTextArea').prop('disabled', false);

                    element.parent().find('.comments').prepend('<div max_widht ="90px"><img class="comment_pic" align ="middle"width="30" height="30" alt="" src="'+srcPic+'" ><a href="/BlablaApp/public/index.php/user/index"><span class="nameComment">'+nameCommentor+' </span></a><span >'+comment+'</span></div><br>');
					
                }
				else{
					
					
					alert(data);
				}
                
            }
        });
			return false;
		}
});
    
    
    });

        
    
    function deletePost(idPost)
	{
        var sure = confirm("sicuro di volerlo cancellare?");
        if (sure)
        {
            var data ={'idPost':idPost};
            var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'deletepost',), 'default') ?> ';
            $.ajax({

                type : 'POST',
                url  : url,
                data : data,
                success :  function(data)
                {
                    if(data=="0"){
                            $("#"+idPost).html('cancellazione non riuscita');

                    }
                    else if(data=="1")
                    {

                        $("#"+idPost).html('post andato in paradiso');
                    }
                    else{
                        $("#"+idPost).html(data);
                    }

                }
            });
        }
        return false;
    }