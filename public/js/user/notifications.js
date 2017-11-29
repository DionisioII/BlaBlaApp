 $(function() {
  
     updateNotificationsDB();
     
}); 

function acceptFriendship(button,adder,receiver,idNotification)
    {
         
        var data = {'adder':adder,'receiver':receiver,'idNotification':idNotification};
        var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'acceptfriendship',), 'default') ?> ';
		
        $.ajax({

            type : 'POST',
            url  : url,
            data : data,
            beforeSend: function()
            {
                $(button).attr("disabled","true");
                
            },
            success :  function(data)
            {
                if(data=="error"){
						//$("#erroremessage").html('Alcuni dati inseriti non vanno bene');
                    
                }
                else if(data=="OK")
                {

                    $(button).parent().find('.disableButton').attr('disabled','true');
                    $(button).html("richiesta accettata");
                }
				else{
					//$("#erroremessage").html(data);
				}
                
            }
        });
        return false;
    }
    
    function denyFriendship(button,adder,receiver,idNotification)
    {
       var data = {'adder':adder,'receiver':receiver,'idNotification':idNotification};
        var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'denyfriendship',), 'default') ?> ';
		
        $.ajax({

            type : 'POST',
            url  : url,
            data : data,
            beforeSend: function()
            {
                $(button).attr("disabled","true");
                
            },
            success :  function(data)
            {
                if(data=="error"){
						//$("#erroremessage").html('Alcuni dati inseriti non vanno bene');
                    
                }
                else if(data=="OK")
                {
                    $(button).attr('disabled','true');
                    $(button).parent().find('.acceptBut').attr('disabled','true');
                    $(button).html("richiesta rifiutata")
                }
				else{
					//$("#erroremessage").html(data);
				}
                
            }
        });
        return false; 
    }
    
    function updateNotificationsDB()
    {
        var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'updatenotification',), 'default') ?> ';
          $.ajax({

            type : 'POST',
            url  : url,
            success :  function(data)
            {
                if(data=="error"){
						//$("#erroremessage").html('Alcuni dati inseriti non vanno bene');
                    
                }
                else if(data==1)
                {
                    $('#NotificheMenuLi').find('a').html('Notifiche');
                    $('#NotificheMenuLi').addClass('active');
                    
                }
                
            }
        });
    }
