<?
class DynamicForm extends WaxModel{
  
  public static $form;
  
  public function setup(){
     parent::setup();
     WaxEvent::run(get_class($this).".setup", $this);
   }

  
}
?>