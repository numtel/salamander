<?/*
node social program 20110730
Filename:		mod/db/mysql.php
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

class Node_db_mysql {

	protected $parent=false;
	
	public $link=false;
	
	public function __construct($parent){
		$this->parent=$parent;
		
		//connect to the computer datin-base
		if(!$this->link){
			$this->link = mysql_connect($this->parent->ini['db']['host'],$this->parent->ini['db']['user'],$this->parent->ini['db']['password']);

			if (!$this->link) {
				die('Could not connect: ' . mysql_error());
			}
		}
		mysql_select_db($this->parent->ini['db']['database'],$this->link);
		
		//don't show the password all the time
		unset($this->parent->ini['db']['password']);

	}
		
	public function __destruct(){
		mysql_close($this->link);
	}
	
	public function adjust_table_name($table_name){
		//allow forced no adjustment!
		if(substr($table_name,0,1)=='>') return mysql_real_escape_string(substr($table_name,1),$this->link);
		//otherwise add the table prefix
		return mysql_real_escape_string((substr($table_name,0,strlen($this->parent->ini['db']['table_prefix']))!==$this->parent->ini['db']['table_prefix'] ? $this->parent->ini['db']['table_prefix'] : '').$table_name,$this->link);
	}
	
	public function init_table($name,$fields){
		$name=$this->adjust_table_name($name);
		//create the table if not found!
		$table_query="CREATE TABLE IF NOT EXISTS `".$name."` (".
						"`".$name."_id` INT( 10 ) NOT NULL AUTO_INCREMENT, ".
						"`parent_id` INT( 10 ) NOT NULL DEFAULT '-1', ".
						"`active` INT( 1 ) NOT NULL DEFAULT '1', ".
						"`created` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, ".
						"PRIMARY KEY (  `".$name."_id` ));";
		
		$all_good=true;
		if(mysql_query($table_query,$this->link)){
			foreach($fields as $id=>$field){
				$id=mysql_real_escape_string($id,$this->link);
				$field=mysql_real_escape_string($field,$this->link);
				$field_query="ALTER TABLE  `".$name."` ADD  ".($id!='' ? "`".$id."`":'')." ".$field;
				$all_good=!$all_good ? false : mysql_query($field_query,$this->link);
			}
		}else{return false;}
		return $all_good;
	}
	
	public function insert($table_name,$fields,$return_index=false){
		if(!count($fields)) return false;
		$table_name=$this->adjust_table_name($table_name);
		$field_names='`'.implode(array_map("mysql_real_escape_string",array_keys($fields),array_fill(0,count($fields),$this->link)),'`, `').'`';
		$values="'".implode(array_map("mysql_real_escape_string",array_values($fields),array_fill(0,count($fields),$this->link)),"', '")."'";
		$insert_query="INSERT INTO `".$table_name."` (".$field_names.") VALUES (".$values.");";
		$return=mysql_query($insert_query,$this->link);
		if(!$return || $return_index===false) return $return;
		$return=mysql_insert_id($this->link);
		return $return;
	}
	
	public function count($table_name,$field='*',$where=array()){
		$table_name=$this->adjust_table_name($table_name);
		
		if(!isset($where['active'])) $where['active']='1';
		foreach($where as $id=>$val){
			if($id=='id'){
				$id=$table_name.'_id';
				$where[$id]=$val;
				unset($where['id']);
			}
			$where[$id]="`".mysql_real_escape_string($id)."`='".(is_array($val)?implode("' OR `".$id."`='",array_map("mysql_real_escape_string",$val,array_fill(0,count($val),$this->link))):mysql_real_escape_string($val))."'";
		}
		$where_val=implode(array_values($where), ' AND ');
		
		$query="SELECT COUNT(".mysql_real_escape_string($field).") FROM `".$table_name."` WHERE ".$where_val;
		$result = mysql_query($query,$this->link);
		
		if($result){
			$row = mysql_fetch_array($result);
			if($row) return $row[0]*1;
		}
		return false;	
	}
	
	// Load a query result into an array
	// use a where field array key of '@str' to directly add text to the where section
	// when using '@str', you MUST DO YOUR OWN VALIDATION!
	public function select($table_name,$fields='*',$where=array(),$limit=''){
		$table_name=$this->adjust_table_name($table_name);
		
		if(!isset($where['active'])) $where['active']='1';
		//allow not specified active column
		if($where['active']===-1) unset($where['active']);
		foreach($where as $id=>$val){
			if($id==='id'){
				$id=$table_name.'_id';
				$where[$id]=$val;
				unset($where['id']);
			}
			if($id!=='@str') $where[$id]="(`".mysql_real_escape_string($id,$this->link)."`='".(is_array($val)?implode("' OR `".$id."`='",(count($val) ? array_map("mysql_real_escape_string",$val,array_fill(0,count($val),$this->link)) : array())):mysql_real_escape_string($val,$this->link))."')";
		}
		$where_val=(count($where) ? ' WHERE ' : '' ).implode(array_values($where), ' AND ');
		
		if(!is_array($fields)) $field_names=$fields;
		else{
			//add in administrative columns
			if(!in_array($table_name.'_id',$fields)) $fields[]=$table_name.'_id';
			if(!in_array('parent_id',$fields)) $fields[]='parent_id';
			$field_names='`'.implode(array_map("mysql_real_escape_string",array_values($fields),array_fill(0,count($fields),$this->link)),'`, `').'`';
		}
		
		//apply limit (array) or suffix string
		if(is_array($limit)) $limit="LIMIT ".implode(',',$limit);
		$limit=mysql_real_escape_string($limit,$this->link);
		
		$query="SELECT ".$field_names." FROM `".$table_name."`".$where_val." ".$limit;
		//echo $query;
		$result = mysql_query($query,$this->link);
		
		$output=array();
		if($result){
			while ($row = mysql_fetch_array($result,MYSQL_ASSOC)) {
				$latest=false;
				
				if($row['parent_id']==='-2')
					$latest=array_values($this->select($table_name,$fields,array('parent_id'=>$row[$table_name.'_id'],'active'=>'2')," ORDER BY `created` DESC LIMIT 1"));
					
				if(isset($row[$table_name.'_id'])) $rowId=$table_name.'_id'; //default to tablename_id
				elseif(isset($row['id'])) $rowId='id'; //backup to just id
				
				$output[$row[$rowId]]=(is_array($latest) && isset($latest[0]) ? $latest[0] : $row);
				//hide administrative columns
				unset($output[$row[$rowId]][$table_name.'_id']);
				unset($output[$row[$rowId]]['parent_id']);
			}
			
			return $output;
		}
		return false;
	}
	
	//updating with version control requires the record's id to be specified
	public function update($table_name,$where,$fields,$versioning=false){
		$table_name=$this->adjust_table_name($table_name);

		if(!isset($where['active'])) $where['active']='1';
		foreach($where as $id=>$val){
			if($id=='id'){
				$id=$table_name.'_id';
				$item_id=$val;
				$where[$id]=$val;
				unset($where['id']);
			}
			if($id!=='@str' && !$versioning) $where[$id]="(`".mysql_real_escape_string($id,$this->link)."`='".(is_array($val)?implode("' OR `".mysql_real_escape_string($id,$this->link)."`='",array_map("mysql_real_escape_string",$val,array_fill(0,count($val),$this->link))):mysql_real_escape_string($val,$this->link))."')";
		}
		$where_val=implode(array_values($where), ' AND ');
		
		if($versioning){
			$parent_id=$item_id;
			$fields['parent_id']=$parent_id;
			$fields['active']='2';
			$parent_query="UPDATE `".$table_name."` SET `parent_id`='-2' WHERE `".$table_name."_id`='".$parent_id."'";
			$fields=array_filter($fields,'var_not_null');
			return $this->insert($table_name,$fields) && mysql_query($parent_query,$this->link);
		}else{
		
			foreach($fields as $id=>$val){
				if($id!=='@str') $fields[$id]="`".mysql_real_escape_string($id,$this->link)."`='".mysql_real_escape_string($val,$this->link)."'";
				if($val===null) $fields[$id]="`".mysql_real_escape_string($id,$this->link)."`=NULL";
			}
			$set_val=implode(array_values($fields), ', ');

			$query="UPDATE `".$table_name."` SET ".$set_val." WHERE ".$where_val;
			//echo $query;
			return mysql_query($query,$this->link);
		}
	}
	
	//"REALLY" deleting versions requires the record's id to be specified
	public function delete($table_name,$where,$reallyDelete=false,$reallyDeleteVersions=false,$limit=''){
		$table_name=$this->adjust_table_name($table_name);
		if(!isset($where['active'])) $where['active']='1';
		
		if(isset($where['@str'])){
			$extraWhere=$where['@str']; 
			unset($where['@str']);
		}
		
		foreach($where as $id=>$val){
			if($id==='id'){
				$parent_id=$val;
				$id=$table_name.'_id';
				unset($where['id']);
			}
			$where[$id]="(`".mysql_real_escape_string($id,$this->link)."`='".(is_array($val)?implode("' OR `".mysql_real_escape_string($id,$this->link)."`='",array_map("mysql_real_escape_string",$val,array_fill(0,count($val),$this->link))):mysql_real_escape_string($val,$this->link))."')";
		}
		$where_val=implode(array_values($where), ' AND ');
		if(isset($extraWhere)){
			$where_val.=(strlen($where_val) ? ' AND ' : '').'('.$extraWhere.')';
		}
		if($reallyDelete) $query="DELETE FROM ".$table_name." WHERE ".$where_val.$limit;
		else $query="UPDATE `".$table_name."` SET `active`='0' WHERE ".$where_val;
		
		if($reallyDeleteVersions) return mysql_query($query,$this->link) && $this->delete($table_name,array('parent_id'=>$parent_id,'active'=>'2'),true);
		//echo $query;
		return mysql_query($query,$this->link);
	}
	
}
?>
