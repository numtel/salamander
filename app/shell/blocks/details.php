<?
$itemAddress=$_POST['fields']['address'];
if($itemAddress==='/'){
	$isRoot=true;
	$item=array('node:mode'=>$node->record_tree2->mode('/'),'node:address'=>'/');
	$item['node:modeString']=$node->record_tree2->mode_to_string($item['node:mode']);
	$item['node:roles']=$node->record_tree2->mode_to_roles($item['node:mode']);
}else{
	$isRoot=false;
	if(!is_array($render_params)) $error=$render_params;
	$item=pull_item($render_params);
	if(!$item) $error='Invalid item!';
}

if(!isset($error)){
	$permissions=$node->record_tree2->mode($itemAddress,0);
}
