  $(function(){
        $('.inputElement').on('keypress',function(e){
        
        if(e.which == 13 || e.keydown == 13){
                var array =$(this).attr('name').split('|');
                saveValue(this,array[1],array[0]);
        }
    });
        
        $(".AgeInput" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	 
	$(".AgeInput" ).datepicker( "option", "dateFormat","dd/mm/yy" )
    
    });

    function changeParameter(spanElement)
    {
        var inputElement = $(spanElement).parent().find('.inputElement');
        $(spanElement).attr('hidden','true');
        inputElement.removeAttr('hidden');
        inputElement.focus();
        
        
    }
    
    function lostFocus(inputElement)
    {
        if(!$(inputElement).hasClass('AgeInput')){
            $(inputElement).attr('hidden','true');
            $(inputElement).val( $(inputElement).parent().find('.spanElement').html() );
            $(inputElement).parent().find('.spanElement').removeAttr('hidden');
        }
        
    }
    
    function saveValue(inputElement,column,username)
    {
         
            
            var spanElement = $(inputElement).parent().find('.spanElement');
            var valueToSave = $(inputElement).val();
            var data = {'username':username,'column':column,'value':valueToSave};
            var url = ' <?= $this->url(array('controller' => 'admin', 'action' => 'modifyuser',), 'default') ?> ';
            $.ajax({

                type : 'POST',
                url  : url,
                data : data,
                success :  function(data)
                {
                    if(data == 1){
                            
                            $(spanElement).html(valueToSave);
                            $(inputElement).val(valueToSave);
                            $(inputElement).attr('hidden','true');
                            $(spanElement).removeAttr('hidden');
                            

                    }
                    else{

                    }

                }
            });        
    }
    
    function changeRole(selectElement,role,username)
    {
        var data = {'username':username,'column':'role','value':$(selectElement).val()};
        var url = ' <?= $this->url(array('controller' => 'admin', 'action' => 'modifyuser',), 'default') ?> ';
            $.ajax({

                type : 'POST',
                url  : url,
                data : data,
                success :  function(data)
                {
                    if(data == 1){
                            

                    }
                    else{

                    }

                }
            });        
    }
    
    function deleteUser(button,username)
    {
        var sure = confirm("sicuro di volerlo cancellare?");
        if(sure){
            var data = {'username':username};
            var url = ' <?= $this->url(array('controller' => 'admin', 'action' => 'deleteuser',), 'default') ?> ';
                $.ajax({

                    type : 'POST',
                    url  : url,
                    data : data,
                    success :  function(data)
                    {
                        if(data == 1){
                                $(button).parent().parent().remove();

                        }
                        else{

                        }

                    }
                }); 
        }       
    }
    
    
