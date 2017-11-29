function showupdateInfoPanel()
	{
		$("#updateInfoPanel").toggle();
		$('#infomessage').html('');
		
		
		return false;
		
	}
    
	$(function(e){
        
        $("#birthdate" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	 
	$("#birthdate" ).datepicker( "option", "dateFormat","dd/mm/yy" )
    
    });
        
        $('#invisibilityCheckbox').prop('checked',<?= $this->authInfo('hidden');?>)
		
		$("#invisibilityCheckbox").change(function(e) {
    // this will contain a reference to the checkbox 
		var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'togglevisibility',), 'default') ?> ';
			
    if (this.checked) {
		var obj = {'visibility':'true' };
      
    } else {
        var obj = {'visibility':'false' };
    }
			
	$.ajax({

            type : 'POST',
            url  : url,
            data : obj,
            beforeSend: function()
            {
				
                
                
            },
			 success :  function(data)
            {
                if(data=="error"){
						
						$(this).parent().prepend('Connessione assente?');
                    
                }
                else if(data=="OK")
                {
					
					
                }
				else{				
					
					
				}
                
            }
        });
			return false;
			
});
	});
	