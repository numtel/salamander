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
						if(!isset($patVal['enable-insert'])){
							$childTypes[$patKey]=$patVal;
						}else{
							$inserters=explode(',',$patVal['enable-insert']);
							//determine user's access ids
							$userId=$node->user_user->currentId;
							if($userId!==false){
								//determine this user's groups
								$groups=isset($node->user_user->groups['by_user_id'][$userId]) ? 
											$node->user_user->groups['by_user_id'][$userId] : array();
								//find all the items that this item matches
								$accessId=array_map(function($e){return ($e*-1)-($e!==0 ? 100 : 0);},$groups); //groups use negative ids
								$accessId[]=$userId; //load current user
								$accessId[]=-1; //all logged in users
							}
							$accessId[]=0; //use 0 for global permissions
				
							//cross check it!
							foreach($inserters as $cId){
								if(in_array(trim($cId)*1,$accessId)){
									$childTypes[$patKey]=$patVal;
								}
							}
						}
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
