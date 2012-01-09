<?
class WildfireCustomForm extends WaxModel{

  public function setup(){
    $this->define("title", "CharField", array('required'=>true, 'scaffold'=>true));
    $this->define("content", "TextField", array('widget'=>"TinymceTextareaInput"));
    $this->define("terms_and_conditions", "TextField", array('widget'=>"TinymceTextareaInput"));
    $this->define("redirect_to_after_save", "CharField");

    $this->define("prefix", "CharField", array('editable'=>false, 'unique'=>true));

    $this->define("date_created", "DateTimeField", array('editable'=>false, 'scaffold'=>true));
    $this->define("date_modified", "DateTimeField", array('editable'=>false));
    
    $this->define("fields", "HasManyField", array('target_model'=>'WildfireCustomField', 'group'=>'Fields', 'editable'=>true));
  }
  
  public function before_save(){
    if(!$this->title) $this->title = "FORM NAME";
    if(!$this->prefix) $this->prefix = $this->get_prefix();
  }
  
  public function get_prefix($test=false){
    if(!$test) $test = substr(Inflections::to_url($this->title),0,5);
    $model = new WildfireCustomForm;
    if($model->filter("prefix", $test)->first()) return $this->get_prefix($test.rand(1000,9999));
    else return $test;
  }
}
?>