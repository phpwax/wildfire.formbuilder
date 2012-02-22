<?
CMSApplication::register_module("customformbuilder", array('include_in_cms'=>true, "display_name"=>"Form Builder", "link"=>"/admin/customformbuilder/", 'split'=>true));

if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}

WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $model = WaxEvent::data();
  if(!$model->columns['forms']) $model->define("forms", "ManyToManyField", array('target_model'=>'WildfireCustomForm', 'group'=>'relationships'));
});
?>