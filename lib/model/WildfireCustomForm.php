<?
class WildfireCustomForm extends WaxModel{

  public function setup(){
    $this->define("title", "CharField", array('required'=>true, 'scaffold'=>true, 'group'=>'content', 'primary_group'=>1));
    $this->define("content", "TextField", array('widget'=>"TinymceTextareaInput", 'group'=>'content', 'primary_group'=>1, 'label'=>false));
    $this->define("type", "CharField");
    $this->define("terms_and_conditions", "TextField", array('widget'=>"TinymceTextareaInput", 'group'=>'Terms'));
    $this->define("redirect_to_after_save", "CharField");
    $this->define("email_notification", "CharField", array('label'=>'Send email to'));
    $this->define("email_subject", "CharField");
    $this->define("submit_text","CharField");
    $this->define("prefix", "CharField", array('editable'=>false, 'unique'=>true));
    $this->define("table_name", "CharField", array('editable'=>false, 'unique'=>true));

    $this->define("date_created", "DateTimeField", array('editable'=>false, 'scaffold'=>true));
    $this->define("date_modified", "DateTimeField", array('editable'=>false));
    $this->define("pages", "ManyToManyField", array('target_model'=>CONTENT_MODEL, 'group'=>'relationships'));
    $this->define("fields", "ManyToManyField", array('scaffold'=>false, 'target_model'=>'WildfireCustomField', 'group'=>'Fields', 'editable'=>true, 'primary_group'=>1));
  }

  public function before_save(){
    if(!$this->title) $this->title = "FORM NAME";
    if(!$this->prefix) $this->prefix = $this->get_prefix();
    if(!$this->table_name) $this->table_name = "wdf_".$this->prefix;
    if(!$this->date_created) $this->date_created = date("Y-m-d H:i:s");
    $this->date_modified = date("Y-m-d H:i:s");
    if($this->columns['content']) $this->content =  CmsTextFilter::filter("before_save", $this->content);
    if($this->columns['terms_and_conditions']) $this->terms_and_conditions =  CmsTextFilter::filter("before_save", $this->terms_and_conditions);
  }

  public function get_prefix($test=false){
    if(!$test) $test = substr( Inflections::underscore(Inflections::to_url(str_replace("/", "_", $this->title))), 0, 12) ;
    $model = new WildfireCustomForm;
    if($model->filter("prefix", $test)->first()) return $this->get_prefix($test.rand(1000,9999));
    else return $test;
  }
}
?>