<?
//variables for referencing this app's url 
$tr=$node->root_http_path.$node->ini['front']['appPath'];
$appDir=substr($node->page['template'],0,strrpos($node->page['template'],'/'));

//get variables from the config.ini file
$toExtract=array('siteTitle','dataPath','patternPath','pageSize');
foreach($toExtract as $iniVar){
	$$iniVar=$node->ini['front'][$iniVar];
}

//load the root data item
$dataConfig=pull_item($node->record_tree2->get($dataPath));


