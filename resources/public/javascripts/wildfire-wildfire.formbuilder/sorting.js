jQuery(document).ready(function(){
  
  jQuery("ul.existing_field").sortable({
    update:function(e,ui){
      var obj = jQuery(this), 
          parent = obj.parent(), 
          items = parent.find("li"),
          lic=0
          ;
      items.each(function(){
        jQuery(this).find(".hidden_field").val(lic);
        lic++;
      });
      
    }
  }).disableSelection();
  
});