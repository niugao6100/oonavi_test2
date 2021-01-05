$(function ()
{
  var page = 0; 
  var end_flag = 0; 
  $(window).bottom({proximity: 0.1}); 
  $(window).bind("bottom", function() {
 
    if(end_flag==0){ 
      var obj = $(this);
        if (!obj.data("loading")) {
  
          obj.data("loading", true);
  
          $('.loading').append('loading...'); 
  
          setTimeout(function() {
 
            $.ajax({
               type: 'POST',
               url: ajaxurl,
               data: {
                'action' : 'ajax_get_new_posts', 
                'page' : ++page, 
                },
               success: function(response) {
                  $(".loading").empty(); 
                  if(response!="end"){
                    $(".wp-block-table").append(response); 
                  }else{
                    end_flag=1;
                  }
               } 
            }); 
 
            obj.data("loading", false);
          }, 500);
        }
 
      } //end_flag
  });
 
});


