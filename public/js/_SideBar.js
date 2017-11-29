$(function(){
	
	$("#blogForm").submit(function(event){
		submitBlogForm();
		event.preventDefault();
		
	})
	
		
	

});
	
	function showBlogsPanel()
	{
		$("#divBlog").toggle();
		
		return false;
		
		
	}
	
	function showNuovoBlogPanel()
	{
		$("#nuovoBlogPanel").toggle();
		$('#erroremessage').html('');
		$(':input').val('');
		$('#submitButton').val('Crea Blog');
		
		return false;
		
	}
	
	
	function submitBlogForm()
    {
        var data = $("#blogForm").serialize();
        var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'createblog',), 'default') ?> ';
		
        $.ajax({

            type : 'POST',
            url  : url,
            data : data,
            beforeSend: function()
            {
                $("#erroremessage").html('creazione in corso...');
                
            },
            success :  function(data)
            {
                if(data=="error"){
						$("#erroremessage").html('Alcuni dati inseriti non vanno bene');
                    
                }
                else if(data=="OK")
                {
                    var url = '<?=$this->url(array('controller' => 'user','action'     => 'index'), 'default',true  ); ?>';

                    $("#erroremessage").html('Blog creato con successo');
                    window.setTimeout( window.location.href = url, 4000 );
                    
                    
                }
				else{
					$("#erroremessage").html(data);
				}
                
            }
        });
        return false;
    }
    
    