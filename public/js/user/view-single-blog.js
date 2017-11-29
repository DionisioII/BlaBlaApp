$(function(){
var idBlog = $('#blogIdP').val();
$('#blog_id_input').val(idBlog);
	
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
    
    
   /* $('.com fr').bind('click',function(){
        alert('ciao');
        $(this).parent().parent().find('.commentSection').toggle();
        
        
    });*/
    
	
		
	

});
    function showCommentSection(selector){
        $(selector).parent().parent().find('.commentSection').toggle();
    }
	
	
	
	function showPostForm()
	{
		/*if($('#postarea').val()!=''){
			
			$("#postFormPanel").toggle();
			$('#errorPostMessage').html('');
			$('#postFormPanel :input').val('');
			$('#submitPostButton').val('Salva Post');
			
		}else{
			alert('il post non può essere vuoto!');
		}
		
		return false;*/
		
		$("#postFormPanel").toggle();
			$('#errorPostMessage').html('');
			$('#postFormPanel :input').val('');
			$('#submitPostButton').val('Salva Post');
		return false;
		
	}
	
	
	
	function submitPostForm()
    {
        var data =$("#postForm").serialize() ;
		var url = 'http://localhost/BlablaApp/public/user/createpost';
        $.ajax({

            type : 'POST',
            url  : url,
            data : data,
            beforeSend: function()
            {
                $("#errorPostMessage").html('submit del post in corso...');
                
            },
            success :  function(data)
            {
                if(data=="error"){
						$("#errorPostMessage").html('Alcuni dati inseriti non vanno bene');
                    
                }
                else if(data=="OK")
                {

                    $("#errorPostMessage").html('post creato con successo');
                }
				else{
					$("#errorPostMessage").html(data);
				}
                
            }
        });
        return false;
    }
	
	function submitPost(){
		var formData = new FormData();

		formData.append("postTitle", $('#postTitle').val());
		formData.append("postarea", $('#postarea').val()); 
		formData.append("id_blog",4);
		
		var blob = new Blob([content], { type: "image/jpg"});

		// HTML file input, chosen by user
		formData.append("postImage", blob);
		var request = new XMLHttpRequest();
		var url = 'http://localhost/BlablaApp/public/user/createpost';
		request.open("POST", url);
		request.send(formData);
			}
    
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
    
    function deleteBlog(idBlog)
	{
        var sure = confirm("sicuro di volerlo cancellare?");
        
        if (sure)
        {
            var data ={'idBlog':idBlog};
            var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'deleteblog',), 'default') ?> ';
            $.ajax({

                type : 'POST',
                url  : url,
                data : data,
                success :  function(data)
                {
                    if(data=="0"){
                            console.log("error",'cancellazione non risucita')

                    }
                    else
                    {

                        window.location.href= data;
                    }

                }
            });
		
        }
        return false;
    }
	
