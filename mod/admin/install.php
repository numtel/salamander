<?/*
salamander framework 20121023
Filename:		mod/admin/install.php
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

class Node_admin_install {

	protected $parent=false;
	protected $db=false;
	protected $tree=false;
	

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$this->tree=$parent->record_tree2;
	}

 	public function post($fields){
 		if(isset($fields['action'])){
 			switch($fields['action']){
 				case 'install':
 					return $this->install($fields['group'],
 										$fields['user'],
 										$fields['pw'],
 										isset($fields['scripts']) ? $fields['scripts'] : array());
 			}
 		}
 	}
 	
 	public function installable(){
 		return $this->db->count($this->parent->user_user->table)===0;
 	}
 	
 	public function install($group,$user,$pw,$scripts){
 		if(!$this->installable())
 			return 'Install Failure: Already installed!';
 			
 		$userId=$this->parent->user_user->signup($user,$pw);
 		if($userId===false) 
 			return 'Install Failure: Could not create user.';
 		$groupId=$this->parent->record_group->create($this->parent->user_user->table,$group);
 		if($groupId===false) 
 			return 'Install Failure: Count not create group.';
 		if(!$this->parent->record_group->associate($this->parent->user_user->table,$group,$userId))
 			return 'Install Failure: Count not associate user to group.';
 		$userId=$this->parent->user_user->login($user,$pw);
 		if($userId===false)
 			return 'Install Failure: Could not log in.';
 		if(!$this->db->insert($this->tree->tablePerms,array('owner'=>$userId,'address'=>'/','mode'=>'1','access_id'=>'0')) ||
			!$this->db->insert($this->tree->tablePerms,array('owner'=>$userId,'address'=>'/','mode'=>array_sum($this->tree->modes),'access_id'=>-100-$groupId)) ||
			!$this->db->insert($this->tree->tablePerms,array('owner'=>$userId,'address'=>'/','mode'=>array_sum($this->tree->modes),'access_id'=>$userId)))
			return 'Install Failure: Could not set root data permssions.';
 		if(!$this->tree->insert('/',array(substr($this->parent->tree_home->address,1)=>array('admin:icon'=>'user'))))
 			return 'Install Failure: Could not create root home item.';
 		if(!$this->tree->chmod($this->parent->tree_home->address,5,array(-1)))
 			return 'Install Failure: Could not set permissions on root home item.';
 		$loadedScripts=$this->get_scripts();
 		foreach($scripts as $key=>$checked){
 			if(isset($loadedScripts[$key])){
	 			$retval=call_user_func_array($loadedScripts[$key],array($this->parent));
 				if($retval!==true) return $retval;
 			}
 		}
 		return 'Installation successful!';
 	}
 	
 	public function get_scripts(){
 		$scripts=glob($this->parent->ini['path']['modules'].'admin/install-scripts/*.php');
 		$install=array();
 		foreach($scripts as $script){
 			include_once($script);
 		}
 		return $install;
 	}
 	
 	public function generate_docsdata($outfile=false){
 		$out="<? 
\$install['Documentaion Data']=function(\$node){

\$docsPattern=array('patterns'=>array('admin:icon'=>'th','node:children'=>".var_export($this->tree->filter_for_insert($this->tree->get('/patterns/documentation',true)),true)."));\n\n\$docsData=".var_export($this->tree->filter_for_insert($this->tree->get('/docs',true)),true).";

if(!\$node->record_tree2->insert('/',\$docsPattern,true) ||
	!\$node->record_tree2->insert('/',\$docsData,true))
	return 'Install Failure: Could not import documentation data.';
if(!\$node->tree_pattern->rebuild_permissions())
	return 'Install Failure: Could not set permissions on import data.';

return true;

};
";
 		if($outfile===false) return $out;
 		return file_put_contents($outfile,$out)!==false;
 	}
   	
}

