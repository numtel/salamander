<?
//TODO: change to numeric on last param, enabling first params to be post/category address
if(count($node->page['params'])>0 && is_numeric($node->page['params'][0]) && is_int($node->page['params'][0]*1)){
	$pageNum=$node->page['params'][0]*1;
}else $pageNum=1;

//using $dataPath as the pagination key
$pageData=array_paginate_get($dataPath,$pageNum,$pageSize);
if($pageData===false){
	$blogPosts=$node->record_tree2->query($dataPath.'/',array('pattern:match'=>$patternPath.'/post'));
	$blogPosts=array_reverse(sort_by_attr('node:created',$blogPosts));
	array_paginate_init($blogPosts,$dataPath);
	$pageData=array_paginate_get($dataPath,$pageNum,$pageSize);

}
$postCount=array_paginate_get($dataPath,'count');
$lastPage=(int)ceil($postCount/$pageSize);

