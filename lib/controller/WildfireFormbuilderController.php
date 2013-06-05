<?
class WildfireFormbuilderController extends WaxController{
  
  public $custom_form = false;
  public $custom_form_model = false;
  public $form_class = "WildfireCustomForm";
  public $form_model_class = "WildfireDynamicForm";
  public $custom_form_fields = array();

  public $email_notification_class = "Notification";
  public $email_notification_func = "submission";
  public $email_subject = false;
  public $dev_emails = array();
  public $from_address = false;
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
          $field->original_title = $field->title;
          if($field->required) $field->title .= " <sup>*</sup>";
          if($field->subtext) $field->title .= "<br><span class='subtext'>".$field->subtext."</span>";
          //set the group
          $group = $field->field_group;
          
          
          if($field->choices){
            $c = explode("\n", $field->choices);
            foreach($c as $v) $choices[trim($v)] = trim($v);
          }
          $previous_group = $group;
          $options = array('widget'=>$field->field_type, 'original_title'=>$field->original_title, 'label'=>$field->title, 'required'=>$field->required, 'choices'=>$choices, 'fg'=>$field->field_group, 'extra_class'=>$field->extra_class);          
          if($field->field_type == "TextareaInput") $obj->define($field->column_name, "TextField", $options);
          else $obj->define($field->column_name, "CharField", $options);
        }
      });
      
      $db = new $fm_class;
      $this->custom_form = new WaxForm($db);
      //bot check functionality
      if($this->bot_check()) $this->redirect_to($custom_form->redirect_to_after_save."?s=bot");
      $posted = $_REQUEST[$this->custom_form->handler->bound_to_model->table];
      
      
      if($posted['form'] == $this->form_primval && ($saved = $this->custom_form->save())){
        if(($to = $custom_form->email_notification) && ($this->email_notification_class)){
          $sender = new $this->email_notification_class;
          $func = "send_".$this->email_notification_func;
          if($session_data = unserialize( Session::get('campaign_data'))) $saved->row = array_merge($saved->row, array_filter($session_data));
          if($this->custom_form_model->email_subject) $sender->$func($saved, $to, $this->from_address, $this->custom_form_model->email_subject);
          elseif($this->email_subject && $this->dev_emails) $sender->$func($saved, $to, $this->from_address, $this->email_subject, $this->dev_emails);
          elseif($this->email_subject) $sender->$func($saved, $to, $this->from_address, $this->email_subject);
          else $sender->$func($saved, $to, $this->from_address);
        }
        $this->redirect_to($custom_form->redirect_to_after_save."?s=".$saved->primval);
      }
    }

  }

  protected function bot_check(){
    $posted = Request::param('check-in');
    if(($v = array_shift($posted)) && $v) return true;
    else return false;
  }
  
}
?>
