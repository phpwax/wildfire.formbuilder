<?
CMSApplication::register_module("customformbuilder", array("display_name"=>"Form Builder", "link"=>"/admin/customformbuilder/"));
CMSApplication::register_asset("wildfire", "js", "wildfire.formbuilder");
CMSApplication::register_asset("wildfire", "css", "wildfire.formbuilder");

AutoLoader::register_view_path("plugin", __DIR__."/view/");
AutoLoader::register_controller_path("plugin", __DIR__."/lib/controller/");
AutoLoader::register_controller_path("plugin", __DIR__."/resources/app/controller/");
AutoLoader::$plugin_array[] = array("name"=>"wildfire.formbuilder","dir"=>__DIR__);





if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}

WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $model = WaxEvent::data();
  if(!$model->columns['forms']) $model->define("forms", "ManyToManyField", array('target_model'=>'WildfireCustomForm', 'group'=>'relationships'));
});

?>