<?
class CMSAdminCustomformbuilderController extends AdminComponent {

  public $module_name = "customformbuilder";
  public $model_class = 'WildfireCustomForm';
  public $display_name = "Form Builder";
  public $dashboard = false;

  protected function events(){
    parent::events();
    WaxEvent::add("cms.joins.handle", function(){
      $obj = WaxEvent::data();
	    $saved = $obj->model;
	    //handle new fields
	    foreach(Request::param('new_field') as $field){
	      $model = new WildfireCustomField;
        if($s = $model->update_attributes($field)) $saved->fields = $s;
	    }
	    $joins = Request::param('joins');
	    $fjoins = $joins['fields'];
	    //handle existing joins
	    foreach(Request::param('fields') as $field){
	      $model = new WildfireCustomField($field['primval']);
	      unset($field['primval']);
	      if($fjoins[$model->primval][$model->primary_key] && ($s = $model->update_attributes($field))) $saved->fields = $s;
	      else $model->update_attributes(array($saved->table."_".$saved->primary_key=>0));
	    }
    });
  }

}

?>