$(function(){
 $('#agree').on('change', function(){
 if($('#agree').prop('checked')){
 $('#submit').attr('disabled', false);
 }else{
 $('#submit').attr('disabled', true);
 }
 });
});