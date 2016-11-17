$(document).ready(function() {
  var conn=new WebSocket('ws://localhost:8080');
  conn.onopen=function(e){
      console.log('Connection established!');
  };

  $('#create').click(function(){
    var baseUrl=document.location.origin;
    var title=$('#postform-title').val();
    var content=$('#postform-content').val();
    var published=$('#postform-published').val();
    $.ajax({
      url: baseUrl+'/rgkProject/web/admin/post/create-ajax',
      data: {
        'title':title,
        'content': content,
        'published': published
      },
      method: 'POST',
      success: function(data){
        if(data.success){
          console.log(data.success);
          var data='Новая запись';
          conn.send(data);
          console.log('Отправлено: '+data);
        }
        else if(data.error){
          console.log(data.error);
        }
      }
    });
    return false;
      
  });
      
});