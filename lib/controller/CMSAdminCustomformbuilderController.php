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
	    $saved->fields->unset($model->fields); //clear the joins every save	    
	    //handle new fields
	    foreach(Request::param('new_field') as $field){
	      $model = new WildfireCustomField;
        if($s = $model->update_attributes($field)) $saved->fields = $s;
	    }
	    //handle existing joins
	    foreach(Request::param('fields') as $field){
	      $model = new WildfireCustomField($field['primval']);
	      unset($field['primval']);
	      if($s = $model->update_attributes($field)) $saved->fields = $s;
	    }
    });
  }

}

?>