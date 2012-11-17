<?
$viewingPage='users';
$overwriteTitle='Salamander User Manager';
$params=$node->page['params'];

$users=$node->db->select($node->user_user->table,array('name'));
foreach($this->parent->user_user->groups['by_user_id'] as $userId=>$userGroups){
	$users[$userId]['admin:groups']=$userGroups;
}

if(count($params)){
	if($params[0]==='ajax-reload') $template=false;
	if(count($params)>1){
	}else{ }
}
