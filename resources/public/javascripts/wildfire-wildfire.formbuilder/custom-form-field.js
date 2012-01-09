function dropdown_check(){
  jQuery(".field_type select").unbind("change").bind("change", function(){
    var val = jQuery(this).val();
    if(val == "SelectInput" || val == "RadioInput") jQuery(this).parent().siblings(".choices").addClass("choices_forced").show();
    else jQuery(this).parent().siblings(".choices").removeClass("choices_forced").hide().find("textarea").val("");
  });
}

jQuery(document).ready(function(){
  jQuery(".newfield, .newfield span.choices").hide();
  var cloned = jQuery(".cloneme").html();
  jQuery("#add_custom_form_field").data("counter", 0).bind("click", function(e){    
    e.preventDefault();    
    var field_counter = jQuery(this).data("counter"),
        c = cloned
        ;
    c = c.replace(/%s\[/gi, "new_field["+field_counter+"][").replace(/%s_/gi, "new_field_"+field_counter+"_");
    jQuery(".existing_field").append("<li class='clearfix join-option join-yes'>"+c+"</li>");
    jQuery(this).data("counter", field_counter+1);

    dropdown_check();
    return false;
  });
  
  dropdown_check();
  
  
});