<?
AutoLoader::register_assets("javascripts/wildfire.formbuilder",__DIR__."/assets/javascripts/wildfire.formbuilder", "/*.js");
AutoLoader::register_assets("stylesheets/wildfire.formbuilder",__DIR__."/assets/stylesheets/wildfire.formbuilder", "/*.css");
AutoLoader::register_assets("images/wildfire.formbuilder",__DIR__."/assets/images/wildfire.formbuilder", "/*.png");
AutoLoader::add_plugin_setup_script(__DIR__."/setup.php");
?>