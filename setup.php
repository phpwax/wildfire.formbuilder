<?

AutoLoader::register_view_path("plugin", __DIR__."/view/");
AutoLoader::register_controller_path("plugin", __DIR__."/lib/controller/");
AutoLoader::register_controller_path("plugin", __DIR__."/resources/app/controller/");
AutoLoader::$plugin_array[] = array("name"=>"wildfire.formbuilder","dir"=>__DIR__);


CMSApplication::register_module("customformbuilder", array('plugin_name'=>'wildfire.formbuilder', 'assets_for_cms'=>true, "display_name"=>"Form Builder", "link"=>"/admin/customformbuilder/"));

if(!defined("CONTENT_MODEL")){
  $con = new ApplicationController(false, false);
  define("CONTENT_MODEL", $con->cms_content_class);
}

WaxEvent::add(CONTENT_MODEL.".setup", function(){
  $model = WaxEvent::data();
  if(!$model->columns['forms']) $model->define("forms", "ManyToManyField", array('target_model'=>'WildfireCustomForm', 'group'=>'relationships'));
});

?>