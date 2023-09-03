function mensaje(indi,msg)
    {
      var result;
    
        if(parseInt(indi)==1){
            result='<div class="alert alert-dismissible alert-danger">';
              result +='<button type="button" class="close" data-dismiss="alert">&times;</button>';
              result+=' <h4>ERROR!</h4>';
              result +='<p>'+msg+'</p>';
              result +='</div>';
              document.getElementById('_MSG_').innerHTML =result;
            
        }
        if(parseInt(indi)==2){
            result='<div class="alert alert-warning" role="alert">';
              result +='<button type="button" class="close" data-dismiss="alert">&times;</button>';
              result+=' <h4>ALERTA!</h4>';
              result +='<p>'+msg+'</p>';
              result +='</div>';
              document.getElementById('_MSG_').innerHTML =result;
            
        }
        
        if(parseInt(indi)==3){
            result='<div class="alert alert-dismissible alert-success">';
              result +='<button type="button" class="close" data-dismiss="alert">&times;</button>';
              result +='<p>'+msg+'</p>';
              result +='</div>';
              document.getElementById('_MSG_').innerHTML =result;
          }
        if(parseInt(indi)==4){
            result='';
            document.getElementById('_MSG_').innerHTML =result;
        }
    }