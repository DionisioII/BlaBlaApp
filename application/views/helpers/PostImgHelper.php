<?php
class Zend_View_Helper_PostImgHelper extends Zend_View_Helper_HtmlElement
{
	
	
	public function PostImgHelper($imgFile,$username= null)
	{
        
        if ($username == null)
        {
        
                if (is_null($imgFile)) {
                    $imgFile = 'default.jpg';
                }

                $path = $this->view->baseUrl('images/postphotos/' . $imgFile);




                $tag = '<img class = "myImg"  src="' . $path .' "  height="'.'"  />';
                return $tag;
            }
        else{
            if(!is_null($imgFile)){
                
                $path = $this->view->baseUrl('images/profiphotos/'. $username.'/'.$imgFile);
                
                return $path;
                
            }else{
                $path = $this->view->baseUrl('images/profiphotos/userpic.gif');
                
                return $path;
            }
            
            
        }
    
    
    }
}