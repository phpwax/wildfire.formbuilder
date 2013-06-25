function dropdown_check(){
  jQuery(".field_type select").unbind("change").bind("change", function(){
    var val = jQuery(this).val();
    if(val == "SelectInput" || val == "RadioInput") jQuery(this).parent().siblings(".choices").addClass("choices_forced").show();
    else jQuery(this).parent().siblings(".choices").removeClass("choices_forced").hide().find("textarea").val("");
  });
}

jQuery(document).ready(function(){
  jQuery(".newfield, .newfield span.choices").hide();
  var cloned = jQuery(".cloneme").html(),
      start = jQuery("#add_custom_form_field").siblings("ul.existing_field").find("li").length
      ;
  jQuery("#add_custom_form_field").attr("data-counter", start).bind("click", function(e){
    e.preventDefault();
    var c = cloned
        field_counter = parseInt(jQuery("#add_custom_form_field").attr("data-counter"));
        ;
    c = c.replace(/%s\[/gi, "new_field["+field_counter+"][").replace(/%s_/gi, "new_field_"+field_counter+"_");
    jQuery(".existing_field").append("<li class='clearfix join-option join-yes'>"+c+"</li>");
    jQuery("#add_custom_form_field").attr("data-counter", field_counter+1);
    jQuery(".existing_field").find(".unstyled_select").removeClass(".unstyled_select").select2({width:"resolve",allowClear:true});
    dropdown_check();
    return false;
  });

  dropdown_check();
});