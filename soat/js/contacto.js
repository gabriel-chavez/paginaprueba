// $(document).ready(function(){
//   $("#btnSendMail").on('click', function(){
//     $("#sbmSendMail").click();
//     $( "#sbmSendMail" ).submit(function( event ) {
//         var domain = $("#domain").val();
//         $.post({
//             url: domain+'/exec/sendmailExec.php',
//             data: $(".formA").serialize(),
//             complete : function(data){
//                 if(data.responseText=='ok') {
//                   alert('enviado correctamente');
//                 } else {
//                 }
//             }
//         });
//       event.preventDefault();
//     });
//     // $("#sbmSendMail").on('click', function(){
//     //   $(this).submit();
//   });
// });

$(document).ready(function(){
  loadValidable({
      reqInput: 'req',
      reqSelect: 'req',
      reqTextarea: 'req',
      callback: 'verifyDate'
  });
  var domain = $("#domain").val();
  $("#formContact input").keypress(function(){
    domain = $('#domain').val();
    $("#formContact").attr('action',domain+'/exec/sendmailExec/');
  });
  $('#formContact input').bind('paste', null, function() {
    domain = $('#domain').val();
    $("#formContact").attr('action',domain+'/exec/sendmailExec/');
  });

// hide message
  if($('#messageBox').html()!='' )
    $('#messageBox').fadeIn(800, function() {
      setTimeout(function(){ $('#messageBox').fadeOut(800) },8000);
  });
  $("#sbmSendMail").on('click', function () {
    $("#formContact").submit();
  });

  if($('#messageBox').html()!='' )
    $('#messageBox').fadeIn(800, function() {
        setTimeout(function(){ $('#messageBox').fadeOut(800) },8000);
  });

});
