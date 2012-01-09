var field_counter=0;
jQuery(document).ready(function(){
  jQuery(".newfield, .newfield span.choices").hide();
  
  jQuery("#add_custom_form_field").bind("click", function(e){    
    e.preventDefault();
    
    var cloned = jQuery(".cloneme").html().replace("new_field[", "new_field["+field_counter+"][").replace("new_field_", "new_field_"+field_counter+"_");
    jQuery(".existing_field").prepend("<li class='clearfix join-option join-yes'>"+cloned+"</li>");
    field_counter ++;
    return false;
  });
  
});