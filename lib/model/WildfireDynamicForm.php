<?
class WildfireDynamicForm extends WaxModel{
  
  public static $form;
  public static $form_model;
  public static $custom_form_fields=array();
  
  public function setup(){
     parent::setup();
     $this->define("form", "IntegerField", array('widget'=>'HiddenInput'));
     $this->define("date_submitted", "DateTimeField", array('editable'=>false));
     WaxEvent::run(get_class($this).".setup", $this);
   }

  public function before_save(){
    parent::before_save();
    $this->date_submitted = date("Y-m-d H:i:s");
  }  
}
?>