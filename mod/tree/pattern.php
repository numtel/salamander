<?/*
node social program 20120506
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
			"/node:wild-recursive-or-nothing/node:attributes(`pattern:children`!='')/node:wild-recursive-or-nothing", 
			'i', 'complete', function($address,$node){
				//TODO:set permissions for this item if the pattern specifies it
				
		});
		$this->tree->bind(
			"/node:wild-recursive-or-nothing/node:attributes(`pattern:children`!='')/node:wild-recursive", 
			'w', 'validate', function($address,$node,$curItem,$data){
				return $node->tree_pattern->validate($address,$data);
		});
		
 	}
 	
 	function error_message($string){
 		if(!isset($this->parent->ini['front']['echo_pattern_errors']) ||
 			!$this->parent->ini['front']['echo_pattern_errors']) return false;
 		//do what you want, do all you can, break all the fucking rules and go to hell with superman
 		echo $string." \t";
 		//and die like a champion yeah hey!
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
			$this->error_message('Pattern match not found!'); 
			return false;
		}
		$match=pull_item($this->tree->get($data['pattern:match']));
		//fail if no pattern match
		if($match===false) {
			$this->error_message('Item not found!'); 
			return false;
		}

		//make sure that this pattern match fits hierarchically
		$parentAddress=substr($address,0,strrpos($address,'/'));
		$parent=pull_item($this->tree->get($parentAddress));
		if($parent===false) { 
			$this->error_message('Parent not found!'); 
			return false;
		}
		
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
				//make sure parent matches the parent type if array
				if($match['type']==='array' && $parent['pattern:match']!==substr($data['pattern:match'],0,strrpos($data['pattern:match'],'/'))){ $this->error_message('Array type incorrect.'); return false;}
				//if recursive, make sure same as parent or if the parent matches up
				if($match['type']==='recursive' && 
						!($parent['pattern:match']===$data['pattern:match'] || 
							$parent['pattern:match']===substr($data['pattern:match'],0,strrpos($data['pattern:match'],'/'))))
					{ $this->error_message('Recursive type incorrect.'); return false; }
			}
		}else{ $this->error_message('No pattern info!'); return false; }
		
		//allow anything if specificity is vague
		if(isset($match['pattern:specificity']) && $match['pattern:specificity']==='vague') return true;
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

}

