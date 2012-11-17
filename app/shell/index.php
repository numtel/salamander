<?
$viewingPage='index';
$params=$node->page['params'];
if(count($params)){
	$curPageTree=$curPage.'/'.$params[0];
	$treeId=$node->record_tree->find_id($params[0]);
	if($treeId!==false){
		$loaded=$node->record_tree->get($treeId);
		//get the first level ready
		$curLevel=array(array('children'=>$loaded));
	}
	if(count($params)>1){
		$address=$node->record_tree->find_parent($params[1],'address');
		if($address!==false){
			$address=$address==='' ? array(0) : explode('/','0/'.$address);
			$address[]=$params[1]*1;
		}else{ $address=array(0); }
	}else{ $address=array(0); }
}
