<?
if(count($node->page['params'])===0){
	$pageAddr=$dataPath;
	$pageData=$tree->get($pageAddr,1);
}else{
	$pageAddr=$dataPath.'/'.implode('/',$node->page['params']);
	$pageData=$tree->get($pageAddr);
}
$thisItem=pull_item($pageData);
if($thisItem!==false && isset($thisItem['pattern:match'])){
	//load this item from inside the pattern
	$patternAddr=$thisItem['pattern:match'];
	$patternData=$tree->get($patternAddr,true);
	$patternItem=pull_item($patternData);
	$patternFlat=flatten_tree($patternData);
}elseif($thisItem!==false && isset($thisItem['pattern:children'])){
	//a little bit different when loading from the pattern's root
	$patternData=$tree->get($thisItem['pattern:children'],true);
	if(substr($thisItem['pattern:children'],-1)==='/'){
		$patternAddr=substr($thisItem['pattern:children'],0,-1);
		$patternItem=pull_item($tree->get($patternAddr,true));
	}else{
		$patternAddr=$thisItem['pattern:children'];
		$patternItem=pull_item($patternData);
	}
	$patternFlat=flatten_tree($patternData);
}else{$thisItem=false;}

if(isset($patternItem) && is_array($patternItem) && isset($patternItem['page-read-depth'])){
	//reload this content at the desired depth!
	$pageData=$tree->get($pageAddr,$patternItem['page-read-depth']*1);
	$thisItem=pull_item($pageData);
}

if(isset($patternItem['node:children']['section'])){
	$thisChildren=organize_by_attrib('pattern:match',$thisItem['node:children']);
	if(isset($thisChildren[$patternAddr.'/section']))
		$thisSections=$thisChildren[$patternAddr.'/section'];
	else $thisSections=false;
}else{$thisSections=false;}

function extract_modifiers($match){
	$return=array();
	$modifiers=array('display-as-link', 'hide-on-page', 'no-wrapper-on-page');
	foreach($modifiers as $mod){
		if(isset($match[$mod])){
			$return[$mod]=explode(',',$match[$mod]);
		}else{
			$return[$mod]=array();
		}
	}
	return $return;
}
