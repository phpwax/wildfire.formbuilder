<?
class WildfireDynamicForm extends WaxModel{
  
  public static $form;
  public static $custom_form_fields=array();
  
  public function setup(){
     parent::setup();
     $this->define("form", "IntegerField", array('widget'=>'HiddenInput'));
     $this->define("date_submitted", "DateTimeField");
     WaxEvent::run(get_class($this).".setup", $this);
   }

  
}
?>