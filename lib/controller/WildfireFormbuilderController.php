<?
class WildfireFormbuilderController extends WaxController{
  
  public $custom_form = false;
  public $form_model_class = "DynamicForm";
  //from a single form id, generate the model by using the dynamic form model and then use form render
  public function __custom(){
    $f_class = $this->form_model_class;
    if($this->form_primval && ($custom_form = new CustomForm($this->form_primval))){
      $f_class::$form = $this->custom_form = $custom_form; //copy to this var so we can access the content / t&cs etc
 
      //clear and create the event to hook in to the model setup
      WaxEvent::clear($f_class.".setup");
      WaxEvent::add($f_class.".setup", function(){
        $obj = WaxEvent::data(); //the model
        $form = $obj::$form;
        //now we loop over the fields and add them to the model
        foreach($form->fields as $field){
          $choices = array();
          if($field->choices){
            $c = explode("\n", $field->choices);
            foreach($c as $v) $choices[$v] = $v;
          }
          $options = array('widget'=>$field->field_type, 'label'=>$field->title, 'required'=>$field->required, 'choices'=>$choices);
          
          $obj->define($field->column_name, "CharField", $options);
        }
      });
      
      $db = new $f_class;
      $this->custom_form = new WaxForm($db);
      if($saved = $this->custom_form->save()){
        $this->redirect_to($custom_form->saved_redirect."?s=".$saved->primval);
      }
    }

  }
  
}
?>