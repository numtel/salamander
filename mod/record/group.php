<?/*
node social program 20110503
Filename:		mod/record/group.php
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


//NOTICE! group names cannot be just a number! 
//(this way you can interchange group names with ids on all functions)

//special groups:all users, users that match certain attributes
class Node_record_group {

	protected $parent=false;
	protected $db=false;
	public $table='groups';
	public $table_items='groups_assoc';

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		if($this->parent->ini['db']['install']){
		   	$this->db->init_table($this->table,array('table'=>'VARCHAR( 255 ) NOT NULL',
		   												 'name'=>'VARCHAR( 255 ) NOT NULL'));
		   	$this->db->init_table($this->table_items,array('table'=>'VARCHAR( 255 ) NOT NULL',
		   												 'group'=>'INT( 10 ) NOT NULL',
		   												 'item_id'=>'INT( 10 ) NOT NULL'));
		}
 	}	
 	
 	public function post($fields){
 		if(isset($fields['action'])){
 			switch($fields['action']){
 				case 'create': //fields: table,name
 					if($this->create($fields['table'],$fields['name']))
						return 'Group(s) Created Successfully.';
					else return 'Group Creation Failure.';
 				case 'rename': //fields: table,group,name
 					if($this->rename($fields['table'],$fields['group'],$fields['name']))
						return 'Group(s) Renamed Successfully.';
					else return 'Group Rename Failure.';
 				case 'delete': //fields: table,group
 					if($this->delete($fields['table'],$fields['group']) && 
 						$this->disassociate($fields['table'],$fields['group']))
							return 'Group(s) Deleted Successfully.';
					else return 'Group Deletion Failure.';
 				case 'associate': //fields: table,group,id
 					if($this->associate($fields['table'],$fields['group'],$fields['id']))
						return 'Item(s) Associated Successfully.';
					else return 'Item Association Failure.';
 				case 'disassociate': //fields: table,group,id
 					if($this->disassociate($fields['table'],$fields['group'],$fields['id']))
						return 'Item(s) Disassociated Successfully.';
					else return 'Item Disassociation Failure.';
 			}
 		}
 	}
 	    
    public function translate_to_id($table,$group){
    	if(is_array($group)){
    		$output=array();
    		foreach($group as $g){
    			if(!is_numeric($g)){
					$fields=array('table'=>$table,'name'=>$g);
					$group_row=$this->db->select($this->table,array(),$fields);
					if(count($group_row)==0) return false;
					$group_id=array_keys($group_row);
					$output[$g]=$group_id[0];
				}else{
					$output[$g]=$g;
				}
			}
			return $output;
		}else{
		   	if(!is_numeric($group)){
				$fields=array('table'=>$table,'name'=>$group);
				$group_row=$this->db->select($this->table,array(),$fields);
				if(count($group_row)==0) return false;
				$group_id=array_keys($group_row);
				return $group_id[0];
			}else{
				return $group;
			}
		}
    }
    
    //accepts an array of names
    public function create($table,$names=array()){
    	$all_good=true;
    	if(!is_array($names)) $names=array($names);
    	foreach($names as $name){
    		if(!is_numeric($name)){
				$fields=array('table'=>$table,'name'=>$name);
				$return=false;
				$current=$this->db->select($this->table,array(),$fields);
				if(!$current) $return=$this->db->insert($this->table,$fields,true);
				if($all_good) $all_good=$return;
			}else{ $all_good=false; }
    	}
    	return $all_good;
    }
    
    //omit the name to delete all groups for a table
    public function delete($table,$group=''){
    	$fields=array('table'=>$table);
    	if($group!=='') $fields['id']=$this->translate_to_id($table,$group);
    	return $this->db->delete($this->table,$fields) &&
    			$this->disassociate($table,$group);
    }
    
    public function rename($table,$group,$new_name){
    	if(is_numeric($new_name)) return false;
    	$fields=array('table'=>$table,'id'=>$this->translate_to_id($table,$group));
    	$update=array('name'=>$new_name);
    	return $this->db->update($this->table,$fields,$update);
    }
    
    //specify a name to check if a group exists
    public function list_groups($table,$group=''){
    	$fields=array('table'=>$table);
    	if($group!=='') $fields['id']=$this->translate_to_id($table,$group);
    	return $this->db->select($this->table,array('name'),$fields);
    }
    
    //specify an item_id to check for a certain association
    public function list_members($table,$group='',$item_id=''){
		$fields=array('table'=>$table);
		if($group!=='') $fields['group']=$this->translate_to_id($table,$group);
     	if($item_id!=='') $fields['item_id']=$item_id;
   		return $this->db->select($this->table_items,array('group','item_id'),$fields);
    }
    
    public function load_list($list,$fields='*'){
    	if(count($list)===0) return array();
    	$list=array_values($list);
    	$table=array_values($this->db->select($this->table_items,array('table'),array('id'=>$list[0]['group'])));
    	if(!$table) return false;
    	$table=$table[0]['table'];
    	$output=array();
    	foreach($list as $item){
    		$loaded=$this->db->select($table,$fields,array('id'=>$item['item_id']));
    		if($loaded){
    			$current_id=array_keys($loaded);
    			if(!isset($output[$item['group']])) $output[$item['group']]=array();
    			$output[$item['group']][$current_id[0]]=$loaded[$current_id[0]];
    		}
    	}
    	return $output;
    	
    }
    
    public function associate($table,$groups,$items){
    	$all_good=true;
    	if(!is_array($groups)) $groups=array($groups);
    	if(!is_array($items)) $items=array($items);
    	foreach($groups as $group){
			$group_id=$this->translate_to_id($table,$group);
			if(is_numeric($group_id)){
				foreach($items as $item){
					$fields=array('table'=>$table,'group'=>$group_id,'item_id'=>$item);
					$current=$this->db->select($this->table_items,array(),$fields);
					$return=false;
					if(!$current) $return=$this->db->insert($this->table_items,$fields);
					if($all_good) $all_good=$return;
				}
			}else{$all_good=false;}
    	}
    	return $all_good;
    }
    
    public function disassociate($table,$group='',$items=''){
		$fields=array('table'=>$table);
		if($group!=='') $fields['group']=$this->translate_to_id($table,$group);
		if($items!=='') $fields['item_id']=$items;
		return $this->db->delete($this->table_items,$fields,true);
    }
    
}
?>
