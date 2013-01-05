<?
$tr=$node->root_http_path.$node->ini['front']['appPath'];
$appDir=substr($node->page['template'],0,strrpos($node->page['template'],'/'));

$toExtract=array('siteTitle','dataPath','patternPath','pageSize');
foreach($toExtract as $iniVar){
	$$iniVar=$node->ini['front'][$iniVar];
}

$dataConfig=pull_item($node->record_tree2->get($dataPath));


