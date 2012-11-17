<?
$tr=$node->root_http_path.$node->ini['front']['appPath'];
$appDir=substr($node->page['template'],0,strrpos($node->page['template'],'/'));

//load user list
$userList=$node->db->select($node->user_user->table,array('name'));
foreach($userList as $id=>$user){
	$userList[$id]['id']=$id;
}
$userListJson=json_encode(array_values($userList));
//load attributes version as well
//$userList=$node->record_attribute->attach($node->user_user->table,$userList);

$rootRoles=$node->record_tree2->mode_to_roles($node->record_tree2->mode('/'));

$render_params['status']=array();
if($node->render_post->status) $render_params['status'][]=$node->render_post->status;

if(!$node->user_user->logged_in()){
	$isLoggedIn=false;
	$render_params['status'][]='Not Authorized for this Page!';
}else{ $isLoggedIn=true; }

if($node->render_post->did_post && !$node->render_post->status)
	$render_params['status'][]="Invalid form submission! Please go back and try again."

?>
