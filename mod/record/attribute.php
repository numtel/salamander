<?/*
node social program 20110503
Filename:		mod/record/attribute.php
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

class Node_record_attribute {

	protected $parent=false;
	protected $db=false;
	public $table='attributes';

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		if($this->parent->ini['db']['install']){
		   	$this->db->init_table($this->table,array('table'=>'VARCHAR( 255 ) NOT NULL',
		   												 'item_id'=>'INT( 10 ) NOT NULL',
		   												 'key'=>'VARCHAR( 255 ) NOT NULL',
		   												 'value'=>'varchar(255) DEFAULT NULL',
		   												 'value_int'=>'int(10) DEFAULT NULL',
		   												 'value_text'=>'text',
		   												 'value_long'=>'mediumtext',
		   												 ''=>'INDEX (`table`, `item_id`)'));
		}
 	}	
 	
 	public function post($fields){
 		if(isset($fields['action'])){
 			switch($fields['action']){
 				case 'set':
 					//handle file uploads into attributes
					if(isset($fields['_FILES'])){
						foreach($fields['_FILES'] as $name=>$info){
							//skip over empty file uploaders
							if($info['error']===4) continue;
							//determine the name of the new file in the cache dir
							$i=0;
							$fileExt=strtolower(substr(basename( $info['name']),strrpos(basename( $info['name']),'.')+1));
							while($i===0 || file_exists($target_path)){
								$random_str = random_string();
								$target_path = $this->parent->fs_path.$this->parent->ini['front']['upload_dir'] . $random_str.'.'.$fileExt; 
								$fileName=$this->parent->root_http_path.$this->parent->ini['front']['upload_dir'].$random_str.'.'.$fileExt;
								$i++; 
							}
							//move that file if it matches one of this form's fields
							if(in_array(substr($name,5),$fields['attr']['key'])){
								if(move_uploaded_file($info['tmp_name'], $target_path)){
									//set attribute to link to the file
									$index=false;
									foreach($fields['attr']['key'] as $i=>$key){
										if(strtolower($key)===strtolower(substr($name,5))) $index=$i;
									}
									if($index!==false) $fields['attr']['value'][$index]=$fileName;
								}else{
									return "There was an error uploading the file, please try again!";
								}
							}
			
						}
					}
					//set the attribs
 					if($this->set($fields['table'],$fields['id'],array_combine($fields['attr']['key'],$fields['attr']['value']),
 							(isset($fields['versioning']) && $fields['versioning']==='true' ? true : false )))
						return 'Attribute(s) Set Successfully.';
					else return 'Attribute Set Failure.';
 				case 'delete':
 					if($this->delete($fields['table'],$fields['id'],$fields['attr']))
						return 'Attribute(s) Deleted Successfully.';
					else return 'Attribute Deletion Failure.';
 			}
 		}
 	}
    
    //load attributes for an array with keys of ids in a specified table
    //(i.e. a return from a selection of rows)
    public function attach($table,$input_array){
		foreach($this->get($table,array_keys($input_array)) as $cAttr){
			if(isset($input_array[$cAttr['item_id']][$cAttr['key']]))
				$input_array[$cAttr['item_id']][$cAttr['key'].'_attr']=$cAttr['value'];
			else $input_array[$cAttr['item_id']][$cAttr['key']]=$cAttr['value'];
		}
    	return $input_array;
    }
    
    public function get($table,$id,$key=''){
    	$fields=array('table'=>$table,'item_id'=>$id);
    	if($key!=='') $fields['key']=$key;
    	return $this->find_which_value($this->db->select($this->table,
    				array('item_id','key','value','value_int','value_text','value_long'),$fields));
    }
    
    private function find_which_value($result){
    	if(!is_array($result)) return false;
    	foreach($result as $i=>$row){
    		if(isset($row['value_int']) && $row['value_int']!==null) $result[$i]['value']=$row['value_int'];
    		elseif(isset($row['value_text']) && $row['value_text']!='') $result[$i]['value']=$row['value_text'];
    		elseif(isset($row['value_long']) && $row['value_long']!='') $result[$i]['value']=$row['value_long'];
    	}
    	return $result;
   }
    
    public function set($table,$id,$attributes,$versioning=false){
    	$all_good=true;
    	foreach($attributes as $key=>$value){
			$fields=array('table'=>$table,'item_id'=>$id,'key'=>$key);
			$current=$this->db->select($this->table,array(),$fields);
			$current_id=array_keys($current);
			if(is_numeric($value) && strlen($value)<10 && is_int($value*1)){
				//set integer field
				$fields['value_int']=$value;
				//if updating, clear other fields
				if(count($current)>0){
					$fields['value_text']=null;
					$fields['value']=null;
					$fields['value_long']=null;
				}
			}elseif(strlen($value)<256){
				//set default value field
				$fields['value']=$value;
				//if updating, clear other fields
				if(count($current)>0){
					$fields['value_int']=null;
					$fields['value_text']=null;
					$fields['value_long']=null;
				}
			}elseif(strlen($value)<65536){
				//set default value field
				$fields['value_text']=$value;
				//if updating, clear other fields
				if(count($current)>0){
					$fields['value_int']=null;
					$fields['value_long']=null;
					$fields['value']=null;
				}
			}else{
				//set long text field
				$fields['value_long']=$value;
				//if updating, clear other fields
				if(count($current)>0){
					$fields['value_int']=null;
					$fields['value_text']=null;
					$fields['value']=null;
				}
			}
			if(count($current)>0) {
				$return=$this->db->update($this->table,array('id'=>$current_id[0]),$fields,$versioning);}
			else $return=$this->db->insert($this->table,$fields);
			if($all_good) $all_good=$return;
    	}
    	return $all_good;
    }
    
    public function delete($table,$id,$key=''){
    	$fields=array('table'=>$table,'item_id'=>$id);
    	if($key!=='') $fields['key']=$key;
    	return $this->db->delete($this->table,$fields);
    }
}
?>
