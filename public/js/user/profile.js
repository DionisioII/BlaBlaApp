	function goToBlog()
	{
		$(this).parent().attr('id');
	}
    
    function followBlog(button,blogId){
            
        if($(button).hasClass('followButton'))
            var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'followBlog',), 'default') ?>';
        else
            var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'unfollowBlog',), 'default') ?>';
            var obj = {'BlogId':blogId};
            
            
            
            $.ajax({
            type : 'POST',
            url  : url,
            data : obj,
			dataType: 'json',
            beforeSend: function()
                {
                    $(button).html('richiesta in corso');
                        $(button).attr("disabled","true");
                    
                },success:function(reply){
                    if(reply)
                        
                        if($(button).hasClass('followButton')){
                            $(button).html('following');
                            $(button).attr("disabled","true");
                        }
                        else{
                              $(button).html('unsubscribed');
                            $(button).attr("disabled","true");  
                        }
                }
            });
        }
    