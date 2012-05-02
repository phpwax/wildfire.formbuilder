<?
class WildfireCustomField extends WaxModel{
  
  public $identifier = "title";
  
  public function setup(){
    $this->define("field_type", "CharField", array('required'=>true, 'widget'=>'SelectInput', 'choices'=>$this->field_types() ));
    $this->define("title", "CharField", array('required'=>true));
    
    $this->define("choices", "TextField"); //only for dropdowns & radio buttons
    $this->define("required", "BooleanField", array('choices'=>array('Optional', 'Required')));
    
    $this->define("subtext", "CharField");
    $this->define("field_group", "CharField");
    $this->define("crm_group_name", "CharField", array('editable'=>false));
    $this->define("extra_class", "CharField", array('widget'=>'SelectInput', 'choices'=>array(''=>'Normal', 'small'=>'small', 'large'=>'large')));
    
    $this->define("column_name", "CharField", array('editable'=>false));
    $this->define("form", "ForeignKey", array('target_model'=>'WildfireCustomForm', 'scaffold'=>true));
    $this->define("order", "IntegerField", array('widget'=>'HiddenInput'));
  }
  
  public function scope_live(){
    return $this->order("`order` ASC, `field_group` ASC");
  }
  
  public function before_save(){
    if(!$this->title) $this->title = "Field";
    if(!$this->column_name) $this->column_name = $this->get_column_name();
  }
  
  public function field_types(){
    return array(''=>'-- Select field type --', 'TitleInput'=>'Title field', 'TextInput'=>'Text field', 'EmailInput'=>'Email field', 'TextareaInput'=>'Message Field', 'CheckboxInput'=>'Check box', 'RadioInput'=>'Radio button', 'SelectInput'=>'Drop down list', 'FileInput'=>'File Upload', 'DateInput'=>'Date Picker', 'HiddenInput'=>'Hidden Field');
  }
  //
  public function get_column_name($test=false){
    if(!$test) $test = substr(Inflections::underscore(str_replace("/","_",$this->title)),0,8);
    return $test;
  }
  
}
?>