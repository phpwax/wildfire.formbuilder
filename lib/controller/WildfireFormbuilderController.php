<?
class WildfireFormbuilderController extends WaxController{
  
  public $custom_form = false;
  public $custom_form_model = false;
  public $form_class = "WildfireCustomForm";
  public $form_model_class = "WildfireDynamicForm";
  public $custom_form_fields = array();
  //from a single form id, generate the model by using the dynamic form model and then use form render
  public function __custom(){
    $fm_class = $this->form_model_class;
    $f_class = $this->form_class;
    if($this->form_primval && ($custom_form = new $f_class($this->form_primval))){
      $fm_class::$form = $this->custom_form_model = $custom_form; //copy to this var so we can access the content / t&cs etc
      
 
      //clear and create the event to hook in to the model setup
      if(!$_POST) WaxEvent::clear($fm_class.".setup");
      WaxEvent::add($fm_class.".setup", function(){
        $obj = WaxEvent::data(); //the model
        $form = $obj::$form;
        $previous_group = $group = false;
        //now we loop over the fields and add them to the model
        foreach($form->fields->scope("live")->all() as $field){
          $obj->custom_form_fields[] = $field;
          $choices = array();
          if($field->subtext) $field->title .= "<br><span class='subtext'>".$field->subtext."</span>";
          //set the group
          $group = $field->field_group;
          //set title (& label) to false if the group is set and it matches the previous group (ie it should be treated like a set)
          if($group && $group == $previous_group) $field->title = false; 
          
          if($field->choices){
            $c = explode("\n", $field->choices);
            foreach($c as $v) $choices[trim($v)] = trim($v);
          }
          $previous_group = $group;
          $options = array('widget'=>$field->field_type, 'label'=>$field->title, 'required'=>$field->required, 'choices'=>$choices, 'fg'=>$field->field_group);          
          $obj->define($field->column_name, "CharField", $options);
        }
      });
      
      $db = new $fm_class;
      $this->custom_form = new WaxForm($db);
      if($saved = $this->custom_form->save()){
        $this->redirect_to($custom_form->redirect_to_after_save."?s=".$saved->primval);
      }
    }

  }
  
}
?>