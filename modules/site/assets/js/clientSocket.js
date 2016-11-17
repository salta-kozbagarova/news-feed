$(document).ready(function() {
  var conn=new WebSocket('ws://localhost:8080');
  conn.onopen=function(e){
      console.log('Connection established!');
  };
  conn.onmessage=function(e){
      console.log('Полученные данные: '+e.data);
      RefreshListView();
  };
  function send(){
      var data='Данные для отправки: '+Math.random();
      conn.send(data);
      console.log('Отправлено: '+data);
  };
  function RefreshListView(){
    $('#refreshPosts').trigger("click");
  };
});