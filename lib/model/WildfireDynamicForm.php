<?
class WildfireDynamicForm extends WaxModel{
  
  public static $form;
  public static $custom_form_fields=array();
  
  public function setup(){
     parent::setup();
     $this->define("type", "CharField");
     $this->define("form_id", "CharField");
     $this->define("form", "IntegerField", array('widget'=>'HiddenInput'));
     WaxEvent::run(get_class($this).".setup", $this);
   }

  
}
?>