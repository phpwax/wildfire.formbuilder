<?
class WildfireDynamicForm extends WaxModel{

  public static $form;
  public static $custom_form_fields=array();

  public function setup(){
     parent::setup();
     $this->define("form", "IntegerField", array('widget'=>'HiddenInput'));
     $this->define("submitted_on", "DateTimeField", array('widget'=>'HiddenInput', 'default'=>"now"));
     WaxEvent::run(get_class($this).".setup", $this);
   }


}
?>