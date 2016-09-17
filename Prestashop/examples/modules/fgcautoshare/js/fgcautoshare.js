/* 
    @author Le Xuan Chien <chien.lexuan@gmail.com>
 */


var specialKeys = new Array();
specialKeys.push(8); //Backspace
jQuery(function($){    


    //load for edit
    var pathname = window.location.href;
    var str=pathname.split('&');
    for (var i = 0; i < str.length; i++) {
        if (($.trim(str[i])=="action=edit_channel")||($.trim(str[i])=="action=add_channel")){
            //load ajax auto
            var data_ajax=$('.form-channel .autoshare_channeltype_id option:selected').attr('data_ajax');
   
            $.ajax({
                url:data_ajax,
                type:'html',
                success:function(rs){
             
                    $('.param_chanel').html(rs);
                
                }
            })
        }
    }
   
   
 
    $('.form-channel .autoshare_channeltype_id').change(function(){
        $('.loading').show();
        // $('.form-channel .autoshare_channeltype_id option').each(function(){
        var data_ajax=$('.form-channel .autoshare_channeltype_id option:selected').attr('data_ajax');
        $.ajax({
            url:data_ajax,
            type:'html',
            success:function(rs){
             
                $('.param_chanel').html(rs);
                $('.loading').hide();
            }
        })
    })
    // change rules
    $('.form-channel  .autoshare_ruletype_id').change(function(){
        var option_selected =$('.form-channel .autoshare_ruletype_id option:selected').val();
      // $(".condition").val('');
        $(".condition").focus();
        if((option_selected =='4')||(option_selected =='5')){
            $('#cat').show();//show commam
            $('#cat1').hide();
               $('#cat2').hide()
             $(".condition").attr('onkeyup','res(this, numb2);');
        }
        else{
            //validate number
            
            if(option_selected =='3'){
               $('#cat').hide();
               $('#cat1').hide();
               $('#cat2').show();
                       $(".condition").attr('onkeyup','res(this, numb2);');
            }
            else{
                  $('#cat').hide();
                   $('#cat1').show();
               $('#cat2').hide()
               $(".condition").attr('onkeyup','res(this, numb);');
            }
            
           
              
             
        }
    })
    
    $('#submit_rules').click(function(){
         var option_selected =$('.form-channel .autoshare_ruletype_id option:selected').val();
         var cur_coddition= $(".condition").val();
         var str=cur_coddition.split('');
         console.log(str);

          if(option_selected <= 2){
        for (var i = 0; i < str.length; i++) {
             if ($.trim(str[i])==",")
             {
                 alert('Price separated by dots(e.g: 540.62)');
                 $(".condition").attr('style',' border: 1px solid red');
                 $(".condition").focus();
                 return false;
                 
             }
            
         }

  
          }
          else{
                   
                   
              
               for (var i = 0; i < str.length; i++) {
       
              if ($.trim(str[i])==".")
            {
                  if(option_selected == 3){
                    alert('Price separated by commas (e.g: 12,16)');
                  }
                  else{
                        alert('Category separated by commas (e.g: 540,62)'); 
                  }
               
                  $(".condition").attr('style',' border: 1px solid red');
                   $(".condition").focus();
                  return false;
             }
         }

          }
         
       
    })
        
})

 var numb = "0123456789.";
 var numb2="0123456789,";
    function res(t, v) {
        var w = "";
        for (i = 0; i < t.value.length; i++) {
            x = t.value.charAt(i);
            if (v.indexOf(x, 0) != -1)
                w += x;
        }
        $(".error_digital").html("Digits Only!!!").show().fadeOut("slow")
        t.value = w;
    }