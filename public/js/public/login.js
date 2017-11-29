$(function()
{
    $(":input").bind('blur',function(event)
    {
        var formElementId = $(this).attr('id');
        doValidation(formElementId);
		//$("#errormessage").html('inviando i dati...');
        //document.getElementById("username").parent().parent().find('.errors').html('gfyi ');
    });
	
	$("#registration").submit(function(event){
		submitForm();
		event.preventDefault();
		
	})
});

function doValidation(id)
{
	function showErrors(resp)    {
        $("#"+id).parent().parent().find('.errors').html(' ');
        $("#"+id).parent().parent().find('.errors').html(getErrorHtml(resp[id]));
    }

	
    var url = ' <?= $this->url(array('controller' => 'public', 'action' => 'validatelogin',), 'default') ?> ';
    $.ajax({
		type: 'POST',
		url: url,
		data: $("#<?php echo $this->loginForm->getName() ?>").serialize(),
		dataType: 'json',
		success: showErrors
    });
}



function showRegistrationPanel()
	{
		$("#registrationPanel").toggle();
		
		return false;
	}
	
  $( function() {
	  
    $( "#birthdate" ).datepicker({
      changeMonth: true,
      changeYear: true
    });
	 
	$( "#birthdate" ).datepicker( "option", "dateFormat","dd/mm/yy" )
	 
	
  } );
	
	
	////form registration submit////
	function submitForm()
    {
        var data = $("#registration").serialize();
		var url = ' <?= $this->url(array('controller' => 'public', 'action' => 'registra',), 'default') ?> ';
        $.ajax({

            type : 'POST',
            url  : url,
            data : data,
            beforeSend: function()
            {
                $("#errormessage").html('inviando i dati...');
                
            },
            success :  function(data)
            {
                if(data == 'non puoi nascere nel futuro'){
						$("#errormessage").html(data);
                    
                }
                else if(data == 'username già preso'){
                        $("#errormessage").html(data);
                }
                else if(data=="registered")
                {

                    $("#errormessage").html('registratzione riuscita');
                }
				else{
                    $("#errormessage").html('alcuni dati inseriti non vanno bene');
                    
					
                    $.each(data, function(i, item) {
                        console.log(i);
                        console.log(item);
                        $("#"+i).parent().parent().find('.errors').html(' ');
                        $("#"+i).parent().parent().find('.errors').html(getErrorHtml(item));
                    });				
                
                }
                
            }
        });
        return false;
    }
    
    function getErrorHtml(formErrors)
{
	if((typeof(formErrors) === 'undefined') || (formErrors.length < 1)) return;
	
	var out = '<ul>';
	for(errorKey in formErrors) {
        out += '<li>' + formErrors[errorKey] + '</li>';
    }
    out += '</ul>';
    return out;
}