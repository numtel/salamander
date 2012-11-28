<?
function convert($size){
	$unit=array('b','kb','mb','gb','tb','pb');
	return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
}

//useful value: path to app
$p=$node->root_http_path.$node->ini['front']['appPath'];
$appDir=substr($node->page['template'],0,strrpos($node->page['template'],'/'));

//useful object: tree
$tree=$node->record_tree2;

$dataPath=$node->ini['front']['dataPath'];
$dataRoot=pull_item($tree->get($dataPath,2));
if(!$dataRoot) die('Data not found!');
