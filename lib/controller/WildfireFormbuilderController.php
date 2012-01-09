<?
class WildfireFormbuilderController extends WaxController{
  
  public $custom_form = false;
  
  //from a single form id, generate the model by using the dynamic form model and then use form render
  public function __custom(){
    if($this->form_primval && ($custom_form = new CustomForm($this->form_primval))){
      DynamicForm::$form = $this->custom_form = $custom_form; //copy to this var so we can access the content / t&cs etc
 
      //clear and create the event to hook in to the model setup
      WaxEvent::clear("DynamicForm.setup");
      WaxEvent::add("DynamicForm.setup", function(){
        $obj = WaxEvent::data(); //the model
        $form = $obj::$form;
        //now we loop over the fields and add them to the model
        
      });
      
      $db = new DynamicForm;
      $db->table = $form->prefix;
      
      
    }

    exit;
  }
  
}
?>