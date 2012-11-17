<?/*
node social program 20110503
Filename:		mod/user/user.php
Description:	the shiz

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//Unique name field prevents users from re-registering under the same name if [soft] deleted

class Node_user_user {

	protected $parent=false;
	protected $db=false;
	public $table='users';
	public $currentId=false;
	public $groups=false;
	public $cUserName=false;

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		
		require_once($this->parent->fs_path.'lib/phpass.php');
		
		if($this->parent->ini['db']['install']){
		   	$this->db->init_table($this->table,array('name'=>'VARCHAR( 255 ) NOT NULL',
		   												 'pw'=>'VARCHAR( 255 ) NOT NULL',
		   												 ''=>'UNIQUE(`name`)'));
		}
	   												 
	   	if(isset($_SESSION['user_id'])) $this->currentId=$_SESSION['user_id'];
	   	if($this->currentId!==false) $this->find_name();
	   
		$this->load_groups(true);
 	}	
 	
 	public function post($fields){
 		if(isset($fields['action'])){
 			switch($fields['action']){
 				case 'login':
 					if($this->login($fields['name'],$fields['pw']))
						return 'User "'.$fields['name'].'" Successfully Logged In.';
					else return 'User Login Failed.';
 				case 'signup':
 					if($this->signup($fields['name'],$fields['pw']))
						return 'User "'.$fields['name'].'" Successfully Created.';
					else return 'User Creation Failed.';
				case 'change_pw':
					if($this->change_pw($fields['id'],false,$fields['pw']))
						return 'Password Change Successful.';
					else return 'Password Change Failed.';
				case 'delete':
					if($this->db->delete($this->table,array('id'=>$fields['id'])) &&
						$this->parent->record_group->disassociate($this->table,'',$fields['id']) && 
						$this->load_groups(true))
							return 'User Deletion Success.';
					else return 'User Deletion Failed.';
				case 'rename':
					if(!is_array($fields['id']) && $this->db->update($this->table,array('id'=>$fields['id']),array('name'=>$fields['name'])) && $this->load_groups(true))
						return 'User Rename Success.';
					else return 'User Rename Failed.';
			}
 		}
 	}
 	
 	public function find_id($name){
 		$user=array_keys($this->db->select($this->table,array(),array('name'=>$name)));
 		if(count($user)===0) return false;
 		return $user[0];
 	}
 	
 	public function find_name($id=false){
 		if($id===false && $this->cUserName!==false) return $this->cUserName;
 		if($id===false) $id=$this->currentId;
 		if($id===false) return false;
 		$user=array_values($this->db->select($this->table,array('name'),array('id'=>$id)));
 		if(count($user)===0) return false;
 		if($id===$this->currentId) $this->cUserName=$user[0]['name'];
 		if(is_array($id)) return $user;
 		if(count($user)===1) return $user[0]['name'];
 		return $user;
 	}
    
    public function signup($name,$pw){
    	$name=trim($name);
		if($name=='' || $pw=='') return false;
		if($this->find_id($name)===false){
			$hasher = new PasswordHash(8, FALSE);
			$hash = $hasher->HashPassword($pw);
			unset($hasher);
			$newUserId=$this->db->insert($this->table,array('name'=>$name,'pw'=>$hash),true);
			//reload the user's groups
			if($newUserId!==false) $this->load_groups(true);
 			return $newUserId;
    	}
    	return false;
    }
    
    public function login($name,$pw){
		$user=$this->db->select($this->table,array('pw'),array('name'=>$name));
		$user_id=array_keys($user);
		
		if(count($user)!==0){
			$hasher = new PasswordHash(8, FALSE);
    		$check=$hasher->CheckPassword($pw, $user[$user_id[0]]['pw']);
			unset($hasher);
			if($check){
				$_SESSION['user_id']=$user_id[0];
				$this->currentId=$user_id[0];
				$this->load_groups(true);
				return $user_id[0];
			}
    	}
    	return false;
    }
    
    public function change_pw($id,$old_pw,$new_pw){
		$user=$this->db->select($this->table,array('pw'),array('id'=>$id));
		$user_id=array_keys($user);
		if(count($user)!==0){
			$hasher = new PasswordHash(8, FALSE);
    		$check=$hasher->CheckPassword($old_pw, $user[$user_id[0]]['pw']);
    		$new_hash=$hasher->HashPassword($new_pw);
			unset($hasher);
			if($old_pw===false || $check) return $this->db->update($this->table,array('id'=>$user_id[0]),array('pw'=>$new_hash));
    	}
    	return false;
    	
    }
    
    //used for form post validation
    public function logged_in(){
    	return $this->currentId!==false;
    }
    
    public function logout(){
    	unset($_SESSION['user_id']);
    	$this->currentId=false;
    	return true;
    }
    
    public function load_groups($attach=false){
    	//load the groups for each user
		$loaded_groups=$this->parent->record_group->list_members($this->table);
		$current_groups=array();//key=userId
		$current_users=array();//key=groupId
		foreach($loaded_groups as $assoc){
			if(!isset($current_groups[$assoc['item_id']]))
				$current_groups[$assoc['item_id']]=array();
			if(!isset($current_users[$assoc['group']]))
				$current_users[$assoc['group']]=array();
				
			$current_groups[$assoc['item_id']][]=$assoc['group'];
			$current_users[$assoc['group']][]=$assoc['item_id'];
		}
		$return=array('by_group_id'=>$current_users,
						'by_user_id'=>$current_groups,
						'names'=>$this->parent->record_group->list_groups($this->table));
		if($attach){
			$this->groups=$return;
			return true;
		}
		return $return;
    }
    
    public function find_group_id($groupName){
    	if($groupName==="World") return 0;
    	if($groupName==="All Logged In Users") return -1;
    	foreach($this->groups['names'] as $groupId=>$group){
    		if($group['name']===$groupName) return $groupId;
    	}
    	return false;
    }
    
    public function in_group($groupName,$userId=false){
    	if($groupName==="World" || $groupName===0) return true;
    	if($userId===false) $userId=$this->currentId;
    	if($userId===false) return false;
    	if($groupName==="All Logged In Users" || $groupName===-1) return true;
    	$groupId=$this->find_group_id($groupName);
    	if(isset($this->groups['by_group_id'][$groupId]) && 
    		in_array($userId,$this->groups['by_group_id'][$groupId])) return true;
    	return false;
    }

}
?>
