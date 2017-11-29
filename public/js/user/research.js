    $(function()
{
	
        $('#RicercaMenuLi').addClass('active');

        
        
        $("#researchForm").submit(function(event){
            var name = $('#nameResearchInput').val();
            var surname = $('#surnameResearchInput').val();
            
            
            searchFun(name,surname);
            event.preventDefault();

        })
});
    
    
    function searchFun( name, surname )
		{
            
			var obj = {'name':name,'surname':surname };
			
			var url = ' <?= $this->url(array('controller' => 'user', 'action' => 'search',), 'default') ?> ';
			
			$.ajax({

            type : 'POST',
            url  : url,
            data : obj,
			dataType: 'json',
            beforeSend: function()
            {
                
            },
			 success :  function(data)
            {
                if(data=="error"){
						$('#ResearchResult').val('');
                    alert(data);
                    
                }
                else 
                {
					
					$('#ResearchResult').html('');
						for(var i in data){
                            if (data[i][3] == 1 ){   // friends already
                                $('#ResearchResult').append(
                                        '<div max_widht =110px"><img class="comment_pic" align ="top" width="30" height="30" alt="" src="'+data[i][4]+'" ><span >'+data[i][0]+' '+ data[i][1]+' '+data[i][6]+'</span></br> <button onclick = "return visitaprofilo(\''+ data[i][5]+'\' )">profilo</button></div><br>'	
                                    
							
					);}
                        
                        else if(data[i][3] == -1 && data[i][2] == "0" ){ //not friends but request already sent && public profile
                            
                                $('#ResearchResult').append(
                                        '<div max_widht =110px"><img class="comment_pic" align ="top" width="30" height="30" alt="" src="'+data[i][4]+'" ><span >'+data[i][0]+' '+ data[i][1]+' '+data[i][6]+'</span></br><button disabled = "true">richiesta inviata</button> <button onclick = "return visitaprofilo(\''+ data[i][5]+'\' )">profilo</button></div><br>'	
                                    
							
					           );
                        }
                        
                        else if (data[i][3] == -1 && data[i][2] == "1"){ // not friends but request already sent && not public profile
                            $('#ResearchResult').append(
                                        '<div max_widht =110px"><img class="comment_pic" align ="top" width="30" height="30" alt="" src="'+data[i][4]+'" ><span >'+data[i][0]+' '+ data[i][1]+'</span></br> <button disabled="true">richiesta inviata</button></div><br>'	
							
							
					);}
                        
                        else if (data[i][2] == "1"){ // not friends && not public profile
                            $('#ResearchResult').append(
                                        '<div max_widht =110px"><img class="comment_pic" align ="top" width="30" height="30" alt="" src="'+data[i][4]+'" ><span >'+data[i][0]+' '+ data[i][1]+'</span></br> <button onclick ="return friendRequest(this,\''+data[i][5]+'\')">aggiungi</button></div><br>'	
							
							
					);}
                        
                        else{
                            $('#ResearchResult').append( //not friends and public profile
                                        '<div max_widht =110px"><img class="comment_pic" align ="top" width="30" height="30" alt="" src="'+data[i][4]+'" ><span >'+data[i][0]+' '+ data[i][1]+' '+data[i][6]+'</span></br> <button onclick ="return friendRequest(this,\''+data[i][5]+'\')">aggiungi</button><button onclick = "return visitaprofilo(\''+ data[i][5]+'\' )">profilo</button></div><br>');
                            
                            }
                        }
									
									
                }
                
            }
        });
		}