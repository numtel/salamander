<?
$tree=$node->record_tree2;
$template=false;
$tool=isset($_GET['tool']) ? $_GET['tool'] : false;

$ajax=$_POST && isset($_POST['ajax']) && $_POST['ajax'];
if($ajax){
	if(is_array($node->render_post->status))
		die(json_encode_ex($node->render_post->status));
	//or just send the string
	else die($node->render_post->status);
}

switch($tool){
	case 'edit':
		if(isset($_GET['address'])){
			$itemData=$tree->get($_GET['address']);
			$thisItem=pull_item($itemData);
			$patternFlat=array();
			if($thisItem!==false){
				$patternData=$tree->get($thisItem['pattern:match'],1);
				$patternItem=pull_item($patternData);
				$patternFlat=flatten_tree($patternData);
			}
		}else{$thisItem=false;}
		break;
	case 'insert':
		if(isset($_GET['address'])){
			$itemData=$tree->get($_GET['address']);
			$thisItem=pull_item($itemData);
			$patternFlat=array();
			$childTypes=array();
			if($thisItem!==false){
				$patternData=$tree->get($thisItem['pattern:match'],2);
				$patternItem=pull_item($patternData);
				$patternFlat=flatten_tree($patternData);
				if(isset($patternItem['type']) && $patternItem['type']==='recursive') $childTypes[$patternItem['node:name']]=$patternItem;
				foreach($patternItem['node:children'] as $patKey=>$patVal){
					if(isset($patVal['type']) && in_array($patVal['type'],array('array','recursive'))){
						$childTypes[$patKey]=$patVal;
					}
				}
			}
		}else{$thisItem=false;}
		break;
	case 'delete':
	case 'move':
	case 'owner':
	case 'rename':
		if(isset($_GET['address'])){
			$itemData=$tree->get($_GET['address']);
			$thisItem=pull_item($itemData);
		}
		break;
	case 'permission':
		if(isset($_GET['address'])){
			$itemData=$tree->get($_GET['address']);
			$thisItem=pull_item($itemData);
			$permissions=$node->record_tree2->mode($thisItem['node:address'],0);
		}
		break;
	default:
		$tool=false;
}
