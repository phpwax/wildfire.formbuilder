<?
class WildfireCustomField extends WaxModel{
  
  public $identifier = "title";
  
  public function setup(){
    $this->define("field_type", "CharField", array('required'=>true, 'widget'=>'SelectInput', 'choices'=>$this->field_types() ));
    $this->define("title", "CharField", array('required'=>true));
    
    $this->define("choices", "TextField"); //only for dropdowns & radio buttons
    $this->define("required", "BooleanField", array('choices'=>array('Optional', 'Required')));
    
    $this->define("column_name", "CharField", array('editable'=>false, 'unique'=>true));
    $this->define("form", "ForeignKey", array('target_model'=>'WildfireCustomForm'));
  }
  
  public function before_save(){
    if(!$this->title) $this->title = "Field";
    if(!$this->column_name) $this->column_name = $this->get_column_name();
  }
  
  public function field_types(){
    return array(''=>'-- Select --', 'TextInput'=>'Text field', 'TextareaInput'=>'Message Field', 'CheckboxInput'=>'Check box', 'RadioInput'=>'Radio button', 'SelectInput'=>'Drop down list');
  }
  
  public function get_column_name($test=false){
    $model = new CustomField;
    if(!$test) $test = substr(Inflections::underscore($this->title),0,5);
    if($model->filter("column_name", $test)->first()) return $this->get_prefix($test.rand(1000,9999));
    else return $test;
  }
  
}
?>