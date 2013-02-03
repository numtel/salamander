<?/*
salamander framework 20120506
Filename:		mod/tree/pattern.php
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


class Node_tree_pattern {

	protected $parent;
	protected $db;
	protected $tree;
	
	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$this->tree=$parent->record_tree2;

		$this->tree->bind(
			"/node:wild-recursive-or-nothing/node:attributes(`pattern:children`!='')/node:wild-recursive", 
			'w', 'validate', function($address,$node,$curItem,$data){
				if(!isset($data['pattern:match']) && isset($curItem['pattern:match'])){
					$data['pattern:match']=$curItem['pattern:match'];
				}
				return $node->tree_pattern->validate($address,$data);
		});

		$this->tree->bind(
			"/node:wild-recursive-or-nothing/node:attributes(`pattern:children`!='')/node:wild-recursive-or-nothing", 
			'i', 'validate', function($address,$node,$curItem,$data){
				//load the pattern match specified
				foreach($data as $name=>$attr){
					if(!isset($attr['pattern:match'])){
						$node->tree_pattern->error_message('No "pattern:match" defined!'); 
						return false;
					}
					$pattern=pull_item($node->record_tree2->get($attr['pattern:match']));
					if($pattern===false){
						$node->tree_pattern->error_message('Pattern match not found!'); 
						return false;
					}
					
					//make sure that this pattern match fits hierarchically
					$parent=pull_item($node->record_tree2->get($address));
					if($parent===false) { 
						$node->tree_pattern->error_message('Parent not found!'); 
						return false;
					}
					if($node->tree_pattern->validate_structure($attr,$parent,$pattern)===false){
						$node->tree_pattern->error_message('Invalid structure!'); 
						return false;
					}
					
					if(!isset($pattern['enable-insert'])) continue;
					$inserters=explode(',',$pattern['enable-insert']);
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
					$foundMatch=false;
					foreach($inserters as $cId){
						if(in_array(trim($cId)*1,$accessId)) $foundMatch=true;
					}
					if($foundMatch===false){
						$node->tree_pattern->error_message('User not member of available inserters!'); 
						return false;
					}
				}
				return true;
		});

		$this->tree->bind(
			"/node:wild-recursive-or-nothing/node:attributes(`pattern:children`!='')/node:wild-recursive-or-nothing", 
			'i', 'complete', function($address,$node,$curItem,$data){
				//set permissions for this item if the pattern specifies it
				foreach($data as $name=>$attr){
					if(!isset($attr['pattern:match'])) return false;
					$pattern=pull_item($node->record_tree2->get($attr['pattern:match']));
					if($pattern===false) return false;
					if(!isset($pattern['set-permission'])) continue;
					$perms=explode(',',$pattern['set-permission']);
					foreach($perms as $perm){
						$perm=explode(':',$perm);
						if($node->record_tree2->chmod($address.'/'.$name,trim($perm[1])*1,array(trim($perm[0])*1))===false) return false;
					}
				}
				return true;
		});
		
 	}
 	
 	function error_message($string){
    	$this->tree->lastError=$string;
    
 		if(isset($this->parent->ini['front']['echo_tree_errors']) &&
 			$this->parent->ini['front']['echo_tree_errors']) echo $string." \t";
 	}
 	
 	function validate($address,$data){
		//if this is an insert of an item check the item inside
		$dataItems=array_values($data);
		if(count($data)===1 && is_array($dataItems[0])){
			$data=$dataItems[0];
			$address.='/';
		}
		//check which pattern item this matches
		if(!isset($data['pattern:match'])) { 
			$this->error_message('Pattern match not set!'); 
			return false;
		}
		$match=pull_item($this->tree->get($data['pattern:match']));
		//fail if no pattern match
		if($match===false) {
			$this->error_message('Pattern match not found!'); 
			return false;
		}

		//make sure that this pattern match fits hierarchically
		$parentAddress=substr($address,0,strrpos($address,'/'));
		$parent=pull_item($this->tree->get($parentAddress));
		if($parent===false) { 
			$this->error_message('Parent not found!'); 
			return false;
		}
		
		if($this->validate_structure($data,$parent,$match)===false){
			$this->error_message('Invalid structure!'); 
			return false;
		}
		
		
		//allow anything if specificity is vague
		if(isset($match['specificity']) && $match['specificity']==='vague') return true;
		//load up children of this pattern match
		$matchChildren=$this->tree->get($data['pattern:match'].'/');
		foreach($matchChildren as $key=>$details){
			if(isset($details['type']) && in_array($details['type'],array('recursive','array'))){
				unset($matchChildren[$key]);
			}
		}
		//validate new data
		foreach($data as $key=>$value){
			if(substr($key,0,5)==='node:' || substr($key,0,8)==='pattern:') continue;
			//make sure 
			if(!isset($matchChildren[$key])) { $this->error_message("Missing attribute '".$key."'."); return false; }

			//determine if can be blank
			if(isset($matchChildren[$key]['allow-blank']) && $matchChildren[$key]['allow-blank'] && $value==='') continue;
			
			//perform more specific validation for different field types
			
			//max-length
			if(isset($matchChildren[$key]['max-length']) && strlen($value)>$matchChildren[$key]['max-length']) {
				$this->error_message("Value too long on '".$key."'."); 
				return false;
			}
			//min-length
			if(isset($matchChildren[$key]['min-length']) && strlen($value)<$matchChildren[$key]['min-length']) {
				$this->error_message("Value too short on '".$key."'."); 
				return false;
			}
			//max-value
			if(isset($matchChildren[$key]['max-value']) && $value>$matchChildren[$key]['max-value']) {
				$this->error_message("Value too high on '".$key."'."); 
				return false;
			}
			//min-value
			if(isset($matchChildren[$key]['min-value']) && $value<$matchChildren[$key]['min-value']) {
				$this->error_message("Value too low on '".$key."'."); 
				return false;
			}
			//data-type
			if(isset($matchChildren[$key]['data-type'])){
				switch($matchChildren[$key]['data-type']){
					case 'integer':
						if(strval(intval($value)) !== strval($value)) {
							$this->error_message("Value not integer on '".$key."'."); 
							return false;
						}
						break;
					case 'numeric':
						if(!is_numeric($value)) {
							$this->error_message("Value not numeric on '".$key."'."); 
							return false;
						}
						break;
					case 'array':
						if(!is_array($value)) {
							$this->error_message("Value not array on '".$key."'."); 
							return false;
						}
						break;
					case 'enum':
						//load enum values from keys that start with 'enum:'
						$availableEnum=array();
						foreach($matchChildren[$key] as $enumKey=>$enumVal){
							if(substr($enumKey,0,5)==='enum:') $availableEnum[]=substr($enumKey,5);
						}
						if(!in_array($value,$availableEnum)) {
							$this->error_message("Invalid enumerated value on '".$key."'."); 
							return false;
						}
						break;
					case 'regex':
						if(!isset($matchChildren[$key]['preg-match'])){
							$this->error_message("Missing 'preg-match' attribute on pattern for '".$key."'.");
							return false;
						}
						if(!preg_match($matchChildren[$key]['preg-match'], $value)){
							$this->error_message("Invaid match on '".$key."'.");
							return false;
						}
						break;
					case 'datetime':
						$timeVal=strtotime($value);
						if($timeVal===false || $timeVal===-1){
							$this->error_message("Invaid date/time value on '".$key."'.");
							return false;
						}
						break;
					default:
						$this->error_message("Invalid data type on '".$key."'."); 
						return false;
				}
			}
		}
		//i guess it went alright
		return true;
 	}
 	
 	public function validate_structure($data,$parent,$match){
 	
		if(isset($parent['pattern:children'])){
			//if parent has 'pattern:children' set, this is a root item
			if(substr($parent['pattern:children'],-1)!=='/'){
				if($data['pattern:match']!==$parent['pattern:children']){ 
					$this->error_message('Incorrect root pattern.'); return false;
				}elseif(substr($data['pattern:match'],0,strlen($parent['pattern:children']))!==$parent['pattern:children']){
					$this->error_message('Incorrect root pattern range.'); return false;
				}
			}
		}elseif(isset($parent['pattern:match'])){
			if(isset($match['type'])){
				$matchParentAddr=substr($data['pattern:match'],0,strrpos($data['pattern:match'],'/'));
				$parentMatchParentAddr=substr($parent['pattern:match'],0,strrpos($parent['pattern:match'],'/'));
				//load the parent's pattern match for recursive-level checking
				$parentMatch=pull_item($this->tree->get($parent['pattern:match']));
				if($parentMatch===false){ $this->error_message('Parent pattern match not found!'); return false; }
				//make sure parent matches the parent type if array
				if($match['type']==='array' && $parent['pattern:match']!==$matchParentAddr &&
					!($parentMatch['type']==='recursive' && isset($parentMatch['recursive-level']) && $parentMatch['recursive-level'] && 
							$parentMatchParentAddr===$matchParentAddr))
					{ $this->error_message($parent['pattern:match'].': '.$matchParentAddr.', Array type incorrect.'); return false; }
				//if recursive, make sure same as parent or if the parent matches up
				if(($match['type']==='recursive' && 
					!($parent['pattern:match']===$data['pattern:match'] || 
						$parent['pattern:match']===$matchParentAddr)))
					{ $this->error_message('Recursive type incorrect.'); return false; }
			}
		}else{ $this->error_message('No pattern info!'); return false; }
	}

	public function rebuild_permissions($address='/',$depth=true){
		$cache=array();
		//find all items that have a pattern match!
		$patterned=$this->tree->query($address,"`pattern:match`!=''",$depth);
		foreach($patterned as $itemAddress=>$item){
			if(array_key_exists($item['pattern:match'],$cache)){
				$pattern=$cache[$item['pattern:match']];
			}else{
				$pattern=pull_item($this->tree->get($item['pattern:match']));
				$cache[$item['pattern:match']]=$pattern;
			}
			if($pattern===false) return false;
			if(!isset($pattern['set-permission'])) continue;
			$perms=explode(',',$pattern['set-permission']);
			foreach($perms as $perm){
				$perm=explode(':',$perm);
				if($this->tree->chmod($itemAddress,trim($perm[1])*1,array(trim($perm[0])*1))===false) return false;
			}
		}
		return true;

	}
}

