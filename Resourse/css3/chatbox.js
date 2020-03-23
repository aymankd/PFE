chat = document.getElementById('Chat'); 


$(window).load(function() {
$messages.mCustomScrollbar();
});


var $messages = $('.messages-content'),
    d, h, m,
    i = 0;
var msgcontainer = $('.mCSB_container');

function updateScrollbar() {
  $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom');
}


function insertMessage() {
  msg = $('.message-input').val();
  i++;
  //$('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
  


  
  htmlmsg = '<div class="message message-personal">' + msg + '</div>' ;
  msgcontainer.insertAdjacentHTML("beforeend",htmlmsg);

  $('.message-input').val(null);
  updateScrollbar();
}

$('.message-submit').click(function() {
  insertMessage();
});

$('#ChatPro').click(function(){
  chat.style="display:block";
  updateScrollbar();
});
$('#CloseChat').click(function(){
  chat.style="display:none";
});


