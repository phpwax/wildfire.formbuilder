<?
class WildfireDynamicForm extends WaxModel{
  
  public static $form;
  public static $custom_form_fields=array();
  
  public function setup(){
     parent::setup();
     WaxEvent::run(get_class($this).".setup", $this);
   }

  
}
?>