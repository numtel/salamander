<?
if(count($node->page['params'])>0 && is_numeric($node->page['params'][0]) && is_int($node->page['params'][0]*1)){
	$pageNum=$node->page['params'][0]*1;
}else $pageNum=1;

$blogPosts=$node->record_tree2->query($dataPath.'/',array('pattern:match'=>$patternPath.'/post'),true,false,$pageSize,$pageNum);
$postCount=$node->record_tree2->lastQueryFoundCount;
$lastPage=ceil($postCount/$pageSize);


