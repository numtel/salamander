<?
$viewingPage='terminal';
$overwriteTitle='Salamander Terminal';
$params=$node->page['params'];
if(count($params) && $params[0]==='command'){
	//allow a request to suggest a template
	/*if($node->user_user->currentId===false){
		die('You are not logged in!');
	}else*/if(isset($_POST['modal']) && isset($_POST['template'])){
		$content=$node->render_haml->render($_POST['template'],$node->render_post->status,false,true);
		$params=array('content'=>$content,
						'id'=>$_POST['modalId'],
						'title'=>$_POST['modalTitle']);
		die($node->render_haml->render($appDir.'/blocks/modal',$params,false,true));
	}elseif(isset($_POST['template']))
		die($node->render_haml->render($_POST['template'],$node->render_post->status,false,true));
	//or send json data
	elseif(is_array($node->render_post->status))
		die(json_encode_ex($node->render_post->status));
	//or just send the string
	else die($node->render_post->status);
}
