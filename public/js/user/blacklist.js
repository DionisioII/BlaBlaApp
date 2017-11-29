$(function(){
    
    
    $('#BlacklistMenuLi').addClass('active');
    
    $("#Black_button").click(function(event){
    event.preventDefault();
    var selectValue = $('#blog_select').val();
    var searchIDs = $("#userListP input:checkbox:checked").map(function(){
      return $(this).attr('id');
    }).get(); // <----
        
    updateBlacklist(selectValue,searchIDs);
        
    
    });
    
    $('#blog_select').change(function(){
        var blog = $(this).val();
        var url = $('#url').attr('href');
        window.location.replace(url +'/blog_id/'+blog);
    });
    
    
    
    
    
});
    
    function updateBlacklist(blogId,usernameList)
    {
        if(usernameList.length == 0)
            usernameList = 'empty';
        
        var data ={'ListOfUsernames':usernameList,'blogId':blogId};
        
        var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'updateblacklist',), 'default') ?> ';
        $.ajax({

                type : 'POST',
                url  : url,
                data : data,
                success :  function(data)
                {
                    if(data==1){
                            $("#resultUpdateBlacklist").html('blacklist aggiornata');

                    }
                    else if(data!=1)
                    {

                        $("#resultUpdateBlacklist").html(data);
                    }
                    

                }
            });
    }
    

