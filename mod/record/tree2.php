<?/*
salamander framework 20120318
Filename:		mod/record/tree2.php
Description:	hierachical database module with events, permissions,
				customizable address filters
	
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
/*
-------------------------------------------------------------------
Address Strings
Root:			/
Single Item:	/itemname
Range of items: /itemname/
Deep child:		/itemname/child1/child2

---------------------------------------------------------------
'Tree' Object Arrays contain nested sets of key=>value arrays
Using 'node:children' as a special key to denote the array of child objects.
Object array keys correspond to the names of the items.


*/

class Node_record_tree2 {

	protected $parent=false;
	protected $db=false;
	public $table='tree2';
	public $tablePerms='tree2_perms';
	public $addressFilters=array();
	public $events=array();
	
	//[r]ead,[w]rite,[i]nsert into,[d]elete,[s]ort,[m]ove,set [o]wner,set [p]ermissions
	public $modes=array('r'=>1,'w'=>2,'i'=>4,'d'=>8,'s'=>16,'m'=>32,'o'=>64,'p'=>128);

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		
		
		if($this->parent->ini['db']['install']){
		   	$this->db->init_table($this->table,array('address'=>'VARCHAR( 1000 ) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL',
		   											'name'=>'VARCHAR( 100 ) CHARACTER SET latin1 COLLATE latin1_general_cs NOT NULL',
													'order'=>'INT( 10 ) NOT NULL',
													'depth'=>'INT( 3 ) NOT NULL',
													'owner'=>'INT( 10 ) NOT NULL',
													'key'=>'VARCHAR( 255 ) NOT NULL',
													'value'=>'varchar(255) DEFAULT NULL',
													'value_int'=>'int(10) DEFAULT NULL',
													'value_text'=>'text',
													'value_long'=>'mediumtext',
											 		''=>'INDEX (`address`,`depth`)'));
		   	$this->db->init_table($this->tablePerms,array('address'=>'VARCHAR( 1000 ) NOT NULL',
													'access_id'=>'INT( 10 ) NOT NULL',
													'mode'=>'INT( 10 ) NOT NULL',
													'owner'=>'INT( 10 ) NOT NULL',
													''=>'INDEX (`address`, `is_group`, `access_id`)'));

		}
		
		foreach($this->modes as $role=>$val){
			$this->events[$role]=array('validate'=>array(),'complete'=>array());
			if($role==='r') $this->events[$role]['item']=array();
		}
		
		//add filter hook for relative paths
		$this->addressFilters[]=function($address,$node){
			if(is_array($address)) var_export($address);
			if(strstr($address,'/../')!==false){
				while(strstr($address,'/../')!==false){
					$curBack=strpos($address,'/../');
					$lastSlash=strpos(strrev($address),'/',strlen($address)-$curBack);
					if($lastSlash===false) return '/'.substr($address,$curBack+4);
					$lastSlash=strlen($address)-$lastSlash;
					$address=substr($address,0,$lastSlash).substr($address,$curBack+4);
				}
			}
			if(substr($address,-3)==='/..'){
				$address=substr($address,0,-3);
				$lastSlash=strpos(strrev($address),'/');
				if($lastSlash===false) return '/';
				$lastSlash=strlen($address)-$lastSlash;
				$address=substr($address,0,$lastSlash-1);
				if($address==='') return '/';
			}
			return $address;
		};
	
		
 	}
 	
 	//FUNCTION $node->record_tree2->insert([String $address],['Tree' Array $data])
 	//$address=where to add this data
 	//$data=array containing items to be inserted
	public function insert($address='/',$data=array(),$suppressEvents=false){
		$address=$this->filter_address($address);
		//check address validity and correct any trailing slash action
		if($address!=='/'){
			$curItem=pull_item($this->get(substr($address,0,-1),false,false,true));
			if($curItem===false || $curItem['node:roles']['i']===false) return false;
			$addressSplit=explode('/',substr($address,0,-1));
			$parentName=array_pop($addressSplit);
		}else{ 
			//make sure user has permission on the root
			$rootMode=$this->mode('/');
			$curItem=array('node:mode'=>$rootMode,
							'node:roles'=>$this->mode_to_roles($rootMode),
							'node:modeString'=>$this->mode_to_string($rootMode),
							'node:address'=>'/');
			if(!$curItem['node:roles']['i']) return false; 
		}
 		
  		if($suppressEvents===false){
 			//perform insert validation event
  			$eventValidate=$this->event($curItem['node:address'],'i','validate',array($curItem,$data));
  			//if event returns array use as replaced data
  			if(is_array($eventValidate)) $data=$eventValidate;
  			//if event says get out, do it!
  			elseif($eventValidate===false) return false;
  			
  			//perform write validation events for each item
  			$data=$this->each_write_event($data,$address);
  			//if event says get out, do it!
  			if($data===false) return false;
  		}


		//find highest ordered item
		$maxOrder=array_values($this->db->select($this->table,array('order'),array('address'=>$address),'ORDER BY `order` DESC LIMIT 1'));
		if(count($maxOrder)) $maxOrder=$maxOrder[0]['order'];
		else $maxOrder=0;

		$dataMod=$this->adjust_addresses($data);
		$depth=substr_count($address,'/')-1;
		
		$insRows=$this->create_insert_items($dataMod,$address,$depth,false,$maxOrder);
		if($insRows===false) return false;
		$allGood=false;
		$nameIn=array();
		foreach($insRows as $item){
			//don't allow anything that contains directory separator
			if(strpos($item['name'],'/')!==false) return false;
			//skip over a name that matches a reserved value
			if(substr($item['name'],0,5)==='node:') continue;
			if(!in_array($item['address'].$item['name'],$nameIn)){
				//make sure not overwriting
				$curItem=$this->get($item['address'].$item['name']);
				if(count($curItem)){ $allGood=false; break; }
				$nameIn[]=$item['address'].$item['name'];
			}
			$allGood=$this->db->insert($this->table,$item);
			if($allGood===false) break;
		}
		
 		if($allGood===true && $suppressEvents===false){
 			$itemAddress=$address==='/' ? '/' : substr($address,0,-1);
 			$dataMod=$this->inserted_items($dataMod,$itemAddress);
 			$this->event($itemAddress,'i','complete',array($curItem,$dataMod));
 			$this->each_write_event($data,$address,true);
 		}
		return $allGood;
	}

 	
 	//FUNCTION $node->record_tree2->edit([String $address],[Array $data])
 	//$address=string address of item to edit
 	//$data=key/value array of attributes to set
 	public function edit($address,$data,$suppressEvents=false){
 		$address=$this->filter_address($address);
 		$where=array();
 		//make sure item exists and can write
 		$curItem=pull_item($this->get($address,false,false,true));
 		if($curItem===false || $curItem['node:roles']['w']===false) return false;
 		
 		//perform validation event
  		if($suppressEvents===false){
  			$eventValidate=$this->event($curItem['node:address'],'w','validate',array($curItem,$data));
  			//if event returns array use as replaced data
  			if(is_array($eventValidate)) $data=$eventValidate;
  			//if event says get out, do it!
  			elseif($eventValidate===false) return false;
  		}

 		//build key/value items
		$addressSplit=explode('/',$address);
		$where['name']=array_pop($addressSplit);
		$address=implode('/',$addressSplit).'/';
 		$where['address']=$address;
		$depth=substr_count($address,'/')-1;
 		$allGood=false;


		$maxOrder=array_values($this->db->select($this->table,array('order'),$where,'ORDER BY `order` DESC LIMIT 1'));
		if(count($maxOrder)) $maxOrder=$maxOrder[0]['order'];
		else $maxOrder=0;

 		foreach($data as $key=>$val){
 			//don't allow anything with a name that matches a reserved value
			if(substr($key,0,5)==='node:') return false;
 			if(isset($curItem[$key])){
 				$where['key']=$key;
 				$allGood=$this->db->update($this->table,$where,array('key'=>$key)
 																	+$this->adjust_value_to_db($val,false));
 			}else{
 				$allGood=$this->db->insert($this->table,array('name'=>$where['name'],
															'address'=>$address,
															'key'=>$key,
															'depth'=>$depth,
															'owner'=>$this->parent->user_user->currentId,
															'created'=>$curItem['node:created'],
															'order'=>$maxOrder)
															+$this->adjust_value_to_db($val));
 			}
 			if($allGood===false) break;
 		}
 		if($allGood===true && $suppressEvents===false) $this->event($curItem['node:address'],'w','complete',array($curItem,$data));
 		return $allGood;
 	}


 	//FUNCTION $node->record_tree2->chown([String $address],[Integer $userId],[Boolean $propagate=true])
 	//$address=string address of item to set owner of
 	//$userId=id of the user to set the owner to
 	//$propagate=perform this operation on the children (required for any action if address is a range)
 	public function chown($address,$userId,$propagate=true,$suppressEvents=false){
 		$address=$this->filter_address($address);
 		if(substr($address,-1)==='/'){
 			$rangeAddress=$address;
	 		$address=substr($address,0,-1);
	 		$isRange=true;
 		}else{
 			$rangeAddress=$address.'/';
 			$isRange=false;
 		}
 		
 		$where=array();
 		
 		//make sure item exists and user can set owner
 		$curItem=pull_item($this->get($address,false,false,true));
 		if($curItem===false || $curItem['node:roles']['o']===false) return false;
 		
 		//perform validation event
  		if($suppressEvents===false && !$this->event($curItem['node:address'],'o','validate',array($curItem,$userId))) return false;

 		//update this item
		if(!$isRange){
			$addressSplit=explode('/',$address);
			$where['name']=array_pop($addressSplit);
			$address=implode('/',$addressSplit).'/';
	 		$where['address']=$address;
	 		$updateThis=$this->db->update($this->table,$where,array('owner'=>$userId));
 			if(!$updateThis) return false;
		}
		if($propagate){
	 		//update any children as well
	 		$updateChildren=$this->db->update($this->table,array('@str'=>
	 							"`address` LIKE '".mysql_real_escape_string($rangeAddress,$this->db->link)."%'"),
	 							array('owner'=>$userId));
 		}else{ $updateChildren=true; }
 		if($updateChildren===true && $suppressEvents===false) $this->event($curItem['node:address'],'o','complete');
 		return $updateChildren;
 	}

 	
 	//FUNCTION: $node->record_tree2->delete([String $address])
 	//$address=address of item to delete or range to delete from
 	//$attribute=string name of attribute to delete if not whole item
 	public function delete($address,$attribute=false,$suppressEvents=false){
 		$address=$this->filter_address($address);
 		if(substr($address,-1)==='/'){
 			$rangeAddress=$address;
	 		$address=substr($address,0,-1);
	 		$isRange=true;
 		}else{
 			$rangeAddress=$address.'/';
 			$isRange=false;
 		}
 		
 		$where=array();
 		
 		//make sure item exists and user can delete it
 		$curItem=pull_item($this->get($address,false,false,true));
 		if($curItem===false || $curItem['node:roles']['d']===false) return false;
 		
 		//perform validation event
  		if($suppressEvents===false && !$this->event($curItem['node:address'],'d','validate',array($curItem,$address,$attribute))) return false;

 		//delete this item
		if(!$isRange){
			$addressSplit=explode('/',$address);
			$where['name']=array_pop($addressSplit);
			$address=implode('/',$addressSplit).'/';
	 		$where['address']=$address;
	 		if($attribute!==false) $where['key']=$attribute;
	 		$delThis=$this->db->delete($this->table,$where);
	 		//delete permissions for this item as well
	 		$delThis=$delThis && $this->db->delete($this->tablePerms,array('address'=>$curItem['node:address']));
 			if(!$delThis) return false;
		}
		if($attribute===false){
	 		//delete any children as well
	 		$delChildren=$this->db->delete($this->table,array('@str'=>
	 							"`address` LIKE '".mysql_real_escape_string($rangeAddress,$this->db->link)."%'"));
	 		//delete permission records from children
	 		$delChildren=$delChildren && $this->db->delete($this->tablePerms,array('@str'=>
	 							"`address` LIKE '".mysql_real_escape_string($rangeAddress,$this->db->link)."%'"));
 		}else{$delChildren=true;}
 		
 		if($delChildren===true && $suppressEvents===false) $this->event($curItem['node:address'],'d','complete',array($attribute));
		return $delChildren;
 	}
 	
 	//FUNCTION: $node->record_tree2->rename([String $itemAddress],[String $newName)
 	//$itemAddress=address of item to rename
 	//$newName=new name for this item
 	public function rename($itemAddress,$newName,$suppressEvents=false){
 		//names cannot contain directory separator or special code
 		if(strpos($newName,'/')!==false || substr($newName,0,5)==='node:') return false;
 		$itemAddress=$this->filter_address($itemAddress);
 		//make sure this address exists and user can edit it
 		$whereItem=array();
 		$curItem=pull_item($this->get($itemAddress,false,false,true));
 		if($curItem===false || $curItem['node:roles']['w']===false) return false;

  		//prepare the query
		$addressSplit=explode('/',$itemAddress);
		$whereItem['name']=array_pop($addressSplit);
		$whereItem['address']=implode('/',$addressSplit).'/';
 		//make sure this name doesnt exist at this address
 		$newItemAddress=$whereItem['address'].$newName;

		//perform validation event
  		if($suppressEvents===false){
  			$eventValidate=$this->event($newItemAddress,'m','validate',array($itemAddress,$newItemAddress));
  			//if event says get out, do it!
  			if($eventValidate===false) return false;
  		}
 		
 		$addrExists=$this->get($newItemAddress,false,false,true);
 		if(count($addrExists)) return false;
 		//update name field of this item and the addresses of children and the permissions
 		$oldChildAddress=mysql_real_escape_string($itemAddress.'/',$this->db->link);
 		$newChildAddress=mysql_real_escape_string($newItemAddress.'/',$this->db->link);
 		if($this->db->update($this->table,$whereItem,array('name'=>$newName)) &&
 			$this->db->update($this->table,array('@str'=>"(`address` LIKE '".$oldChildAddress."%')"),
 					array('@str'=>"`address`=replace(`address`,'".$oldChildAddress."','".$newChildAddress."')")) &&
 			$this->db->update($this->tablePerms,array('address'=>$itemAddress),array('address'=>$newItemAddress)) &&
 			$this->db->update($this->tablePerms,array('@str'=>"(`address` LIKE '".$oldChildAddress."%')"),
 					array('@str'=>"`address`=replace(`address`,'".$oldChildAddress."','".$newChildAddress."')"))){
 			if($suppressEvents===false) $this->event($newItemAddress,'m','complete',array($itemAddress));
 			return true;
 		}else return false;
 	}
 	

 	//FUNCTION: $node->record_tree2->move([String $itemAddress],[String $newAddress])
 	//$itemAddress=address of item to move
 	//$newAddress=new address range to place this item
 	public function move($itemAddress,$newAddress,$suppressEvents=false){
 		$itemAddress=$this->filter_address($itemAddress);
 		$newAddress=$this->filter_address($newAddress);
 		//don't move inside of itself
		if($newAddress!=='/' && substr($newAddress,0,strlen($itemAddress))===$itemAddress) return false;
 		//make sure this address exists and user can move it
 		$whereItem=array();
 		$curItem=pull_item($this->get($itemAddress,false,false,true));
 		if($curItem===false || $curItem['node:roles']['m']===false) return false;
 		//prepare the query
		$addressSplit=explode('/',$itemAddress);
		$whereItem['name']=array_pop($addressSplit);
		$whereItem['address']=implode('/',$addressSplit).'/';
		//don't move inside of itself
		if($newAddress!=='/'){
	 		//make sure new address exists and user can insert into it
	 		$newParent=pull_item($this->get(substr($newAddress,0,-1),false,false,true));
	 		if($newParent===false || $newParent['node:roles']['i']===false) return false;
 		}else{
 			//make sure user has permission on the root
			$rootRoles=$this->mode_to_roles($this->mode('/'));
			if(!$rootRoles['i']) return false; 
 		}
 		//make sure this name doesnt exist at this address
 		$newItemAddress=$newAddress.$whereItem['name'];
 		$addrExists=$this->get($newItemAddress);
 		if(count($addrExists)) return false;
 		
 		//perform validation event
  		if($suppressEvents===false && (!$this->event($curItem['node:address'],'m','validate',array($curItem,$newItemAddress)) ||
  				!$this->event($newParent['node:address'],'i','validate',array(array($curItem['node:name']=>$curItem),array($curItem['node:name']=>$curItem))))) return false;

 		//move this item and its children
 		$oldChildAddress=mysql_real_escape_string($itemAddress,$this->db->link);
 		$newChildAddress=mysql_real_escape_string($newItemAddress,$this->db->link);
 		
 		$newDepth=substr_count($newAddress,'/')-1;
 		$oldDepth=substr_count($itemAddress,'/')-1;
 		$depthDiff=$newDepth-$oldDepth;
 		//move item, its children, its permissions and its children's permissions
 		if($this->db->update($this->table,$whereItem,array('address'=>$newAddress,'depth'=>$newDepth)) &&
 			$this->db->update($this->table,array('@str'=>"(`address` LIKE '".$oldChildAddress."/%')"),
 					array('@str'=>"`address`=replace(`address`,'".$oldChildAddress."/','".$newChildAddress."/'), `depth`=`depth`+($depthDiff)")) &&
 			$this->db->update($this->tablePerms,array('address'=>$itemAddress),array('address'=>$newItemAddress)) &&
 			$this->db->update($this->tablePerms,array('@str'=>"(`address` LIKE '".$oldChildAddress."/%')"),
 					array('@str'=>"`address`=replace(`address`,'".$oldChildAddress."/','".$newChildAddress."/')"))){
 			 if($suppressEvents===false){
 			 	$this->event($newParent['node:address'],'i','complete',array(array($curItem['node:name']=>$curItem),array($curItem['node:name']=>$curItem)));
 			 	$this->event($newItemAddress,'m','complete',array($itemAddress));
 			 }
 			return true;
 		}else return false;
 		
 	}
 	
 	//FUNCTION: $node->record_tree2->sort([String $itemAddress],[String $newAddress])
 	//$parentAddress=address of parent item to check permissions
 	//$newAddress=new address range to place this item
 	public function sort($parentAddress,$ordered,$suppressEvents=false){
 		$parentAddress=$this->filter_address($parentAddress);
 		if($parentAddress!=='/'){
	 		//make sure this address exists and user can move it
	 		$parent=pull_item($this->get($parentAddress,false,false,true));
	 		if($parent===false || $parent['node:roles']['s']===false) return false;
 		}else{
			//make sure user has permission on the root
			$rootMode=$this->mode('/');
			$parent=array('node:mode'=>$rootMode,
							'node:roles'=>$this->mode_to_roles($rootMode),
							'node:modeString'=>$this->mode_to_string($rootMode),
							'node:address'=>'/');
			if(!$parent['node:roles']['i']) return false; 
 		}
 		
 		//perform validation event
  		if($suppressEvents===false && !$this->event($parent['node:address'],'s','validate',array($parent,$ordered))) return false;
 		
 		
 		foreach($ordered as $i=>$address){
 			$address=$this->filter_address($address);
	 		//prepare the query
	 		$whereItem=array();
			$addressSplit=explode('/',$address);
			$whereItem['name']=array_pop($addressSplit);
			$whereItem['address']=implode('/',$addressSplit).'/';
			//make sure children exist under parent item if not the root
			if($parentAddress!=='/' && substr($whereItem['address'],0,-1)!==$parentAddress) return false;
			//perform the update
 			$ordered[$i]=$this->db->update($this->table,$whereItem,array('order'=>$i));
 		}
 		//check them all
 		$all_success=array_values(array_unique($ordered));
 		$all_success=count($all_success)===1 && $all_success[0]*1===1;
 		if($all_success===true && $suppressEvents===false) $this->event($parent['node:address'],'s','complete');
		return $all_success;
 	}
 	
 	
 	//FUNCTION: $node->record_tree2->get([String $address],[Integer/False $depth])
 	//$address=root address to grab from
 	//$depth=how many levels: 0+ or false for unlimited on range address, 0+ true on item address for returning full depth
 	//$suppressPermissions=used privately to get items for checking permissions
 	public function get($address='/',$depth=false,$suppressPermissions=false,$suppressEvents=false){
 		$address=$this->filter_address($address);
 		/*
 		TODO: determine new method of blocking useres!!!
 		if($suppressPermissions===false){
 			 $rootRoles=$this->mode_to_roles($this->mode('/'));
 			 if(!$rootRoles['r']) return false;
 		}
 		*/
 		$where=array();
 		if(substr($address,-1)!=='/'){
	 		if(strlen($address)<=1) return false;
	 		$origAddress=$address;
	 		$addressSplit=explode('/',$address);
	 		$itemName=array_pop($addressSplit);
	 		$address=implode('/',$addressSplit).'/';
	 		if($depth!==false){
	 			//load children too
	 			$addrDepth=substr_count($origAddress,'/')-1;
	 			if($depth===true){ $depthStr=''; }
		 		else{
		 			$depthStr=" AND `depth`<'".($addrDepth+$depth+1)."'";
		 		}
		 		$where['@str']="((`address`='".mysql_real_escape_string($address,$this->db->link)."' AND `name`='".mysql_real_escape_string($itemName,$this->db->link)."') OR (`address` LIKE '".mysql_real_escape_string($origAddress,$this->db->link)."/%'".$depthStr."))";
	 		}else{
	 			$where['name']=$itemName;
	 			$where['address']=$address;
	 		}
	 	}elseif($depth===0){
	 		$where['address']=$address;
	 	}else{
	 		$addrDepth=substr_count($address,'/')-1;
	 		if($depth===true){ $depthStr=''; }
	 		else{
	 			if($depth===false) $depth=0;
	 			$depthStr=" AND `depth`<'".($addrDepth+$depth+1)."'";
	 		}
	 		$where['@str']="(`address` LIKE '".mysql_real_escape_string($address,$this->db->link)."%'".$depthStr.")";
	 	}
 		
  		//what address is this?
		if(isset($origAddress)) $eventAddress=$origAddress;
		elseif($address!=='/') $eventAddress=substr($address,0,-1);
		else $eventAddress='/';
		$isRange=!isset($origAddress);
		
 		//perform validation event
  		if($suppressEvents===false){
  			$eventValidate=$this->event($eventAddress,'r','validate',array($depth, $isRange));
  			//if event returns array return as replaced data
  			if(is_array($eventValidate)) return $eventValidate;
  			//if event says get out, do it!
  			elseif($eventValidate===false) return false;
  		}
	 	//print_r($where);
	 	$items=$this->db->select($this->table,'*',$where,'ORDER BY `order` ASC, `created` ASC');

		//depth for ranges includes the first level when loading the permissions!!!
	 	if($suppressPermissions===false) $itemPerms=$this->load_user_perms($eventAddress,false,true,
	 				$isRange ? $depth===false ? 1 : is_numeric($depth) ? $depth+1 : $depth : $depth );
	 	else $itemPerms=false;
	 	
	 	$tree=$this->organize_flat($items,$address,$suppressPermissions,$itemPerms,$suppressEvents);
	 	if($suppressPermissions===false) $tree=$this->unset_unreadable($tree);
	 	//perform complete event
	 	if($suppressEvents===false){
	 		/*TODO:virtual data
	 		if($isRange===true && $eventAddress!=='/'){
	 			$rangeParentItem=pull_item($this->get($eventAddress));
	 			if($rangeParentItem!==false && 
	 				isset($rangeParentItem['node:children']) && 
	 				count($rangeParentItem['node:children'])){
	 					$tree+=$rangeParentItem['node:children'];
	 			}
	 		}*/
	 		$eventComplete=$this->event($eventAddress,'r','complete',array($tree, $isRange));
  			//if event returns array return as replaced data
  			if(is_array($eventComplete)) return $eventComplete;
  			//if event says get out, do it!
  			elseif($eventComplete===false) return false;
	 	}
 		return $tree;
 	}
 	
 	
 	
 	//FUNCTION: $node->record_tree2->get([String $address],[Boolean $onlyAddresses])
 	//$address=address (including wildcards) to find items that match
 	//$onlyAddresses=pass true to return only an array of possible item addresses (all may not exist)
 	public function get_wild($address,$onlyAddresses=false,$suppressEvents=false){
 		$address=$this->filter_address($address);
 		//don't allow a wild call on just the root with any wildcards (would be killed later anyways)
 		if(strlen($address)<=1) return false;
 		//clip trailing slash
 		if(strlen($address)>1 && substr($address,-1)==='/') $address=substr($address,0,-1);
 		//echo '['.$address.','.memory_get_usage()."]\n";
 		//if there isn't anything wild then it's just an address
 		if(strpos($address,'/node:')===false){
 			if($onlyAddresses) return array($address);
 			$cItem=pull_item($this->get($address,false,false,$suppressEvents));
 			if($cItem===false) return false;
 			else return array($address=>$cItem);
 		}
 		$addressSplit=explode('/',$address);
		$getAddress=false;
		$foundAddresses=array();
		//go through each part of the address to determine wildcards
 		for($i=1;$i<count($addressSplit);++$i){
 			$getAddress=implode('/',array_slice($addressSplit,0,$i));
 			if(substr($addressSplit[$i],0,5)==='node:'){
 				$items=$this->get($getAddress.'/',0,false,$suppressEvents);
 				$checkAddress=$getAddress.'/'.implode('/',array_slice($addressSplit,$i));
 				$checkCurrent=$getAddress.'/'.implode('/',array_slice($addressSplit,$i,1));
 				//add this item if it works
 				//print_r(array('addr'=>$getAddress,'check'=>$checkCurrent,'count'=>count($items)));
 				if(strpos($addressSplit[$i],'-or-nothing')!==false && 
 					$this->address_matches($getAddress,$checkAddress)){
 						$foundAddresses[]=$getAddress;
 						//echo "sadfasf\n";
 				}
 				foreach($items as $itemName=>$item){
	 				if($this->address_matches($item['node:address'],$checkCurrent)){
	 					//add children
	 					//print_r(array('addr'=>$item['node:address'],'check'=>$checkAddress));
	 					if($this->address_matches($item['node:address'],$checkAddress,$item)){
	 						$foundAddresses[]=$item['node:address'];
	 						//echo "foozle\n";
	 					}
	 					//add deep children
						if(in_array($addressSplit[$i],array('node:wild-recursive-or-nothing','node:wild-recursive'))){
							//check if -or-nothing and this matches the next item
							$checkDeeper=$getAddress.'/'.implode('/',array_slice($addressSplit,$i+1,1));
							//echo '|'.$checkDeeper.','.$item['node:address']."|\n";
							if($addressSplit[$i]==='node:wild-recursive-or-nothing' && 
 								$this->address_matches($item['node:address'],$checkDeeper)){
 									$deepAddress=$item['node:address'].'/'.implode('/',array_slice($addressSplit,$i+2));
 									//echo "balls-$deepAddress\n";
 									$foundAddresses=array_merge($foundAddresses,$this->get_wild($deepAddress,true,$suppressEvents));
 							}
 							//check deeper items if searching recur
 							if($addressSplit[$i]==='node:wild-recursive'){
 								$deepAddress=$item['node:address'].'/node:wild-recursive-or-nothing/'.implode('/',array_slice($addressSplit,$i+1));
 								//echo "balls-$deepAddress\n";
 								$foundAddresses=array_merge($foundAddresses,$this->get_wild($deepAddress,true,$suppressEvents));
 							}
							//or go with the standard
							$findAddress=$item['node:address'].'/'.implode('/',array_slice($addressSplit,$i));
							//echo '['.$findAddress.']'."\n";
							$foundAddresses=array_merge($foundAddresses,$this->get_wild($findAddress,true,$suppressEvents));
						}
						if($i+1<count($addressSplit)){
							$findAddress=$item['node:address'].'/'.implode('/',array_slice($addressSplit,$i+1));
							//echo '{'.$findAddress.'}'."\n";
							$foundAddresses=array_merge($foundAddresses,$this->get_wild($findAddress,true,$suppressEvents));
						}
	 				}
 				}
 				
 			}
 		}
 		//echo '{'.count($foundAddresses)."}\n";
 		$foundAddresses=array_unique($foundAddresses);
 		if($onlyAddresses===true) return $foundAddresses;
 		//load each item
 		$results=array();
 		foreach($foundAddresses as $cAddress){
 			$cItem=pull_item($this->get($cAddress,false,false,$suppressEvents));
 			if($cItem!==false) $results[$cAddress]=$cItem;
 		}
 		
 		return $results;
 	}
 	
 	//FUNCTION: $node->record_tree2->query([String $rootAddress],[Array $args)
 	//$rootAddress=address range to begin the query from
 	//$args=array('somekey'=>array('value'=>'33','operator'=>'>'),'otherkey'=>'someval','query:mode'=>'and|or|not')
 	//		arguments can contain nested arrays without the key set to perform complex boolean operations
 	public function query($rootAddress='/',$args=array(),$depth=true,$suppressEvents=false,$onlySearch=false){
 		$validOperators=array('>','<','>=','<=','=','!=','like');
 		if(is_string($args)) $args=$this->parse_attribute_query_string($args);
 		//force trailing slash
 		$rootAddress=$this->filter_address($rootAddress);
 		if(substr($rootAddress,-1)!=='/') $rootAddress.='/';
 		foreach($args as $key=>$arg){
 			if(substr($key,0,6)==='query:') continue;
 			//numeric (assigned) keys as parenthetical separators
 			if(is_int($key)){
 				$args[$key]=$this->query($rootAddress,$arg,$depth,$suppressEvents,true);
 				continue;
 			}
 			//find addresses that contain this argument
 			$where=array();
 			
 			//determine depth for sql query
 			if($depth===true){ $depthStr=''; }
	 		else{
 				$addrDepth=substr_count($rootAddress,'/')-1;
	 			$depthStr=" AND (`depth`>='".mysql_real_escape_string($addrDepth,$this->db->link)."' AND `depth`<='".mysql_real_escape_string($addrDepth+$depth,$this->db->link)."')";
	 		}
			
			//determine if exact key is used
 			if(strpos($key,'%')===false){
 				$where['key']=mysql_real_escape_string($key,$this->db->link);
 			}else{
 				$depthStr.=" AND (`key` LIKE '".mysql_real_escape_string($key,$this->db->link)."')";
 			}

			//determine which operator and value to use
 			if(is_array($arg)) $argVal=$arg['value'];
 			else $argVal=$arg;
 			$argVal=mysql_real_escape_string($argVal,$this->db->link);
 			if(is_array($arg)){
 				if(!in_array($arg['operator'],$validOperators)) return false;
 				$argOperator=$arg['operator'];
 			}else{
 				$argOperator='=';
 				$args[$key]=array('value'=>$arg,'operator'=>'=');
 			}
 			
 			if(is_numeric($argVal) && is_int($argVal*1)){
 				//match only the integer field
				$where['@str']="(`value_int` ".$argOperator." '".$argVal."') AND (`address` LIKE '".mysql_real_escape_string($rootAddress,$this->db->link)."%')".$depthStr;
 			}else{
	 			if(is_numeric($argVal)){
	 				$argValInt=" OR `value_int` ".$argOperator." '".$argVal."'";
	 			}else{
	 				$argValInt="";
	 			}
	 			
	 			//match any of the attribute fields
				$where['@str']="(`value` ".$argOperator." '".$argVal."'".$argValInt." OR `value_text` ".$argOperator." '".$argVal."' OR `value_long` ".$argOperator." '".$argVal."') AND (`address` LIKE '".mysql_real_escape_string($rootAddress,$this->db->link)."%')".$depthStr;
			}
			
 			$args[$key]['where']=$where;
 			$argFound=$this->db->select($this->table,array('address','name'),$where);
 			$args[$key]['found']=array();
 			foreach($argFound as $foundItem){
 				$args[$key]['found'][]=$foundItem['address'].$foundItem['name'];
 			}
 		}
 		if($onlySearch===true) return $args;
 		//determine boolean seperations
 		$found=$this->query_boolean_sort($args);
 		//load items
 		$results=array();
 		foreach($found as $cAddress){
 			$cItem=pull_item($this->get($cAddress,false,false,$suppressEvents));
 			if($cItem!==false) $results[$cAddress]=$cItem;
 		}
 		
 		return $results;
 	}
 	 	
 	//FUNCTION: $node->record_tree2->chmod([String $address],[Integer $mode],[Array $users],[Array $groups])
 	//$address=address of item to set permission
 	//$mode=integer value of the mode for this permission setting
 	//$accessors=-100 to 0 reserved for special items, >0 is user ids, <-100 is for group ids (table id-100 for value)
 	//			0: world
 	//			-1: all logged in users
    public function chmod($address="/",$mode=0,$accessors=array(),$suppressEvents=false){
    	$address=$this->filter_address($address);
		//make sure item exists and user can set permissions on it
		$curRoles=$this->mode_to_roles($this->mode($address));
		if($curRoles['p']===false) return false;
		if($curRoles['o']===false){
			//make sure user not elevating privileges
			$newRoles=$this->mode_to_roles($mode);
			foreach($newRoles as $testRole=>$value){
				if($value && !$curRoles[$testRole]) return false;
			}
		}
 		
 		//perform validation event
  		if($suppressEvents===false && !$this->event($address,'p','validate',array($mode,$accessors))) return false;
		
    	$all_good=true;
    	$recip=array();
    	foreach($accessors as $id){
			$recip[]=array('access_id'=>$id,
							'mode'=>$mode,
							'owner'=>$this->parent->user_user->currentId,
							'address'=>$address);
    	}
    	if(count($recip)===0) return false;
    	foreach($recip as $accessor){
			$current=$this->db->select($this->tablePerms,array('mode','owner'),
											array('access_id'=>$accessor['access_id'],
													'address'=>$address));
			$current_id=array_keys($current);
			if(count($current)>0){
				if(!$curRoles['o']) return false;
				if($accessor['mode']==='delete'){
					$return=$this->db->delete($this->tablePerms,array('id'=>$current_id[0]));
				}else{
					$return=$this->db->update($this->tablePerms,array('id'=>$current_id[0]),$accessor);
				}
			}else{ $return=$this->db->insert($this->tablePerms,$accessor); }
			if($all_good) $all_good=$return;
    	}
    	if($all_good===true && $suppressEvents===false) $this->event($address,'p','complete');
    	return $all_good;
    }
    
 	//FUNCTION: $node->record_tree2->mode([String $address],[Integer $userId=false])
 	//$address=address to get permission mode of
 	//$userId=which user id, use default (false) for current user, 0 for all items
    public function mode($address="/",$userId=false,$knowExists=false,$providedPerms=false){
    	if($userId===false) $userId=$this->parent->user_user->currentId;
    	$address=$this->filter_address($address);
    	if($address!=='/' && $knowExists!==true){
			//make sure this is just a single item
			$curItem=pull_item($this->get($address,false,true,true));
			if($curItem===false) return false;
    	}
    	
		
    	if($providedPerms===false){
    		$current=$this->load_user_perms($address,$userId,true);
		}elseif(is_array($providedPerms)){
			$current=array();
			//provided Permissions will be for many items possibly, so sort it out!
			foreach($providedPerms as $cPerm){
				if(strlen($cPerm['address'])<strlen($address) && substr($address,0,strlen($cPerm['address']))===$cPerm['address']){
					$current[]=$cPerm;
				}
			}
		}
		if($userId===0) return $current;
		
		//determine the final mode
		$mode=0; $modeAddress=''; $modeAccessor=false;
		//sort by depth
		foreach($current as $i=>$perm){
			$current[$i]['depth']=$perm['address']==='/' ? -1 : substr_count($perm['address'],'/')-1;
		}
		usort($current, make_comparer('depth'));
		//loop through each permission, from the root to the item
		foreach($current as $perm){
			$permRoles=$this->mode_to_roles($perm['mode']);
			//ownership is everything
			if($permRoles['o']) return array_sum($this->modes);
			//determine if more specific permission
			if(strlen($modeAddress)<strlen($perm['address']) ||
				($modeAddress===$perm['address'] && (
					$modeAccessor===false || 
					$perm['access_id']>0 || 
					($modeAccessor<=0 && $perm['access_id']<$modeAccessor && $perm['mode']>$mode))
				)
			){
					$mode=$perm['mode'];
					$modeAccessor=$perm['access_id'];
					$modeAddress=$perm['address'];
			}
		}
		//echo $mode;
		return $mode;
    }
    
    
    //use in config.ini files for checking posts
    //example: check_root_owner[]="record_tree2/has_role/o/"
    //example: check_can_write[]="record_tree2/has_role/w/rootItemName/childItemName"
    public function has_role(){
    	$args=func_get_args();
    	$role=$args[0];
    	$address='/'.implode('/',array_slice($args,1));
    	$address=$this->filter_address($address);
    	$roles=$this->mode_to_roles($this->mode($address));
    	if($roles[$role]) return true;
    	return false;
    }
    
    //provide interface for form posts
 	public function post($fields){
 		if(isset($fields['action'])){
 			switch($fields['action']){
 				case 'rename': //fields: address, name
 					if($this->rename($fields['address'],$fields['name']))
						return 'Item Renamed Successfully.';
					else return 'Item Rename Failure.';
 				case 'delete': //fields: address
 					if($this->delete($fields['address'],isset($fields['key']) && $fields['key']!='false' ? $fields['key'] : false))
						return 'Item Deleted Successfully.';
					else return 'Item Delete Failure.';
 				case 'insert': //fields: address, data[][...]
					if($this->insert($fields['address'],$fields['data']))
						return 'Item Inserted Successfully.';
					else return 'Item Insert Failure.';
 				case 'edit': //fields: address, data[]
					if($this->edit($fields['address'],$fields['data']))
						return 'Item Edited Successfully.';
					else return 'Item Edit Failure.';
				case 'sort': //fields: address,data[]
					if($this->sort($fields['address'],$fields['data']))
						return 'Items Sorted Successfully.';
					else return 'Item Sort Failure.';
 				case 'move': //fields: address, newAddress
 					if($this->move($fields['address'],$fields['newAddress']))
						return 'Item Moved Successfully.';
					else return 'Item Move Failure.';
 				case 'copy': //fields: address, newAddress
 					if($this->copy($fields['address'],$fields['newAddress']))
						return 'Item Copied Successfully.';
					else return 'Item Copy Failure.';
 				case 'chmod': //fields: address, mode, accessors[],
 					if($this->chmod($fields['address'],$fields['mode'],$fields['accessors']))
						return 'Item Permissions Set Successfully.';
					else return 'Item Permissions Set Failure.';
 				case 'chown': //fields: address, user
 					if($this->chown($fields['address'],$fields['user']))
						return 'Item Owner Set Successfully.';
					else return 'Item Owner Set Failure.';
 				case 'get': //fields: address, depth
 					return $this->get($fields['address'],isset($fields['depth']) && $fields['depth']!='false' ? $fields['depth'] : false);
 				case 'get_mode': //fields: address
 					$mode=$this->mode($fields['address']);
 					return array('mode'=>$mode,
 								'string'=>$this->mode_to_string($mode),
 								'roles'=>$this->mode_to_roles($mode),
 								'address'=>$this->filter_address($fields['address']));
 			}
 		}
 	}
 	
 	//FUNCTION: $node->record_tree2->filter_address([String $address])
 	//$address=address to get run through configured filters
 	public function filter_address($address){
 		foreach($this->addressFilters as $filterFunc){
 			$address=call_user_func_array($filterFunc,array($address,$this->parent));
 		}
 		return $address;
 	}
 	
 	//FUNCTION: $node->record_tree2->event([String $address],[Char $role],[String $type],[Array $extraArgs])
 	//$address=address to call event for
 	//$role=character corresponding to which action was used (r,w,i,s,...)
 	//$type=which type of event to call ('validate','complete')
 	//$extraArgs=any extra parameters to add to the event function call after $address and $node
 	public function event($address,$role,$type,$extraArgs=array()){
 		//echo '['.$address.",$role,$type]\n";
 		$address=$this->filter_address($address);
 		if(!isset($this->events[$role])) return false;
 		$retVal=true;
 		foreach($this->events[$role][$type] as $event){
 			$eventAddress=$this->filter_address($event['address']);
 			//echo '{'.$eventAddress."}\n";
 			if($this->address_matches($address,$eventAddress)){
 				$eventVal=call_user_func_array($event['function'],array_merge(array($address,$this->parent),$extraArgs));
 				if($eventVal===false) return false;
 				elseif($eventVal!==true) $retVal=$eventVal;
 			}
 		}
 		return $retVal;
 	}
 	
 	//FUNCTION: $node->record_tree2->bind([String $address],[String $modeString],[String $type],[Callback $function])
 	//$address=address to get permission mode of
 	//$modeString=string containing which roles to bind to
 	//$type=which type of event to bind to ('validate','complete','item' [only for read])
 	//$function=function to call
 	public function bind($address,$modeString,$type,$function){
 		for($i=0;$i<strlen($modeString);++$i){
 			if(isset($this->events[$modeString[$i]]) && isset($this->events[$modeString[$i]][$type])){
				$this->events[$modeString[$i]][$type][]=array('address'=>$address, 'function'=>$function);
			}
		}
 	}
 	
 	
    //-------------------------------------------------------------------------------------
	//BEGIN derivative operation functions:
    //-------------------------------------------------------------------------------------
    public function copy($address, $newParent,$suppressEvents=false){
    	$data=$this->get($address,true,false,$suppressEvents);
    	if($data===false) return false;
    	//if copying a single item to same parent item, use random name!
    	if(count($data)===1 && substr($address,0,strrpos($address,'/')+1)===$newParent){
    		$data=array_values($data);
    		$data=array(random_string()=>$data[0]);
    	}
    	return $this->insert($newParent,$this->filter_for_insert($data),$suppressEvents);
    }
 	
    //-------------------------------------------------------------------------------------
	//BEGIN private helper functions:
    //-------------------------------------------------------------------------------------
    public function load_user_perms($address="/",$userId=false,$knowExists=false,$depth=false){
    	if($userId===false) $userId=$this->parent->user_user->currentId;
    	$address=$this->filter_address($address);
    	if($address!=='/' && $knowExists!==true){
			//make sure this is just a single item
			$curItem=pull_item($this->get($address,false,true,true));
			if($curItem===false) return false;
    	}
	
		//determine this item's ancestors
		if($address==='/'){
			$lineage=array('/');
			$addrDepth=0;
		}else{
			$itemAddress=explode('/',substr($address,1));
			$addrDepth=count($itemAddress);
			$lineage=array();
			while(count($itemAddress)>=1){
				$thisAddress=implode('/',$itemAddress);
				$lineage[]='/'.mysql_real_escape_string($thisAddress);
				array_pop($itemAddress);
			}
			$lineage[]='/';
		}
		if($depth===false) $depth=0;
		
		//determine query to find permission rules for this item, its specified depth of children, and its ancestors
		if($userId===0){
			$where=array('address'=>$address);
		}else{
			$lineageStr="((";
			if($depth>0) $lineageStr.="`address` like '".$lineage[0].($lineage[0]!=='/' ? '/' : '')."%' OR ";
			$lineageStr.="`address`='".implode("' OR `address`='",$lineage)."')";
			if($depth!==true && $depth>0) $lineageStr.=" and (length(`address`)-length(replace(`address`,'/',''))<".($addrDepth+$depth+1).")";
		
			$lineageStr.=")";
			//echo '['. $lineageStr."]\n";
		
			$where=array('@str'=>$lineageStr);
    	}
    	$accessId=array();
    	if($userId!==false){
			//determine this user's groups
			$groups=isset($this->parent->user_user->groups['by_user_id'][$userId]) ? 
						$this->parent->user_user->groups['by_user_id'][$userId] : array();
			//find all the items that this item matches
			$accessId=array_map(function($e){return ($e*-1)-($e!==0 ? 100 : 0);},$groups); //groups use negative ids
			$accessId[]=$userId; //load current user
			$accessId[]=-1; //all logged in users
    	}
    	if($userId!==0){
	    	$accessId[]=0; //use 0 for global permissions
	    	$where['access_id']=$accessId;
    	}
    	
		$current=$this->db->select($this->tablePerms,array('mode','address','access_id','owner'),$where);


		if($userId!==false && $userId!==0){
			//ancestors and children that are owned by this user have full access
			if($depth===0){
				$lineageStr="((";
			}else{
				$lineageStr="((`address` like '".mysql_real_escape_string($lineage[0]).($lineage[0]!=='/' ? '/' : '')."%'";
			}
			foreach($lineage as $ancestor){
				if($ancestor==='/') continue;
				$ancAddr=mysql_real_escape_string(substr($ancestor,0,strrpos($ancestor,'/')+1));
				$ancName=mysql_real_escape_string(substr($ancestor,strrpos($ancestor,'/')+1));
				if(strlen($lineageStr)>2) $lineageStr.=" OR ";
				$lineageStr.="(`address`='".$ancAddr."' AND `name`='".$ancName."')";
			}
		
			$lineageStr.=")";
			if($depth!==true && $depth!==0){
				$lineageStr.=" and (length(`address`)-length(replace(`address`,'/',''))<".($addrDepth+$depth+1).")";
			}
			$lineageStr.=")";
			$tableId=$this->db->adjust_table_name($this->table).'_id';

			if($lineageStr!=='(())'){
				$ownedAncestors=array_keys($this->db->select($this->table,"DISTINCT CONCAT(`address`, `name`) AS '".$tableId."', `owner`, `parent_id`",array('@str'=>$lineageStr,'owner'=>$userId)));


				foreach($ownedAncestors as $ownedAddr){
					$current[]=array('mode'=>array_sum($this->modes),
									'address'=>$ownedAddr,
									'access_id'=>$userId);
				}
			}
		}

		return $current;
	}

	private function create_insert_items($data,$address,$depth,$owner=false,$order=0){
		if($owner===false) $owner=$this->parent->user_user->currentId;
		$output=array();
		$loadedOrders=array();
		foreach($data as $name=>$attr){
			if(isset($attr['node:owner'])){
				if(!isset($attr['node:owner']['value_int'])) return false;
				$owner=$attr['node:owner']['value_int'];
				unset($attr['node:owner']);
			}
			if(isset($attr['node:children'])){
				$output=array_merge($output, $this->create_insert_items($attr['node:children'],$address.$name.'/',$depth+1,$owner,$order));
				unset($attr['node:children']);
			}
			foreach($attr as $key=>$val){
				if(!isset($loadedOrders[$address.$name])) $loadedOrders[$address.$name]=++$order;
				$output[]=array('name'=>$name,
								'address'=>$address,
								'key'=>$key,
								'depth'=>$depth,
								'owner'=>$owner,
								'order'=>$order)
								+$val;
				
			}
		}
		return $output;
	}
	
	private function adjust_addresses($data){
		$output=array();
		foreach($data as $key=>$val){
			//for items that don't have a specific item name
			if(strstr($key,'#RAND#')!==false) $key=str_replace('#RAND#',random_string(),$key);
			
			//deal with children
			if(isset($val['node:children'])){
				$thisChildren=array('node:children'=>$this->adjust_addresses($val['node:children']));
				unset($val['node:children']);
			}else{ $thisChildren=array(); }
			
			//add this
			$output[$key]=$this->adjust_array_to_db($val)+$thisChildren;
		}
		return $output;
	}
	
	private function inserted_items($data,$rootAddress){
		$output=array();
		foreach($data as $key=>$val){
			$item=pull_item($this->get($rootAddress.'/'.$key,true,false,true));
			if($item!==false) $output[$key]=$item;
		}
		return $output;
	}
	
 	
 	private function adjust_value_to_db($value,$isInsert=true){
 		$fields=array();
 		
 		//allow arrays to be put into attributes
 		if(is_array($value)){
 			$value='###ARRAY###'.serialize($value);
 		}
 		
		if(is_numeric($value) && strlen($value)<10 && is_int($value*1)){
			//set integer field
			$fields['value_int']=$value;
			//if updating, clear other fields
			if($isInsert===false){
				$fields['value_text']=null;
				$fields['value']=null;
				$fields['value_long']=null;
			}
		}elseif(strlen($value)<256){
			//set default value field
			$fields['value']=$value;
			//if updating, clear other fields
			if($isInsert===false){
				$fields['value_int']=null;
				$fields['value_text']=null;
				$fields['value_long']=null;
			}
		}elseif(strlen($value)<65536){
			//set default value field
			$fields['value_text']=$value;
			//if updating, clear other fields
			if($isInsert===false){
				$fields['value_int']=null;
				$fields['value_long']=null;
				$fields['value']=null;
			}
		}else{
			//set long text field
			$fields['value_long']=$value;
			//if updating, clear other fields
			if($isInsert===false){
				$fields['value_int']=null;
				$fields['value_text']=null;
				$fields['value']=null;
			}
		}
		return $fields;
 	}
 	
 	private function adjust_array_to_db($item,$isInsert=true){
		foreach($item as $key=>$value){
			$item[$key]=$this->adjust_value_to_db($value,$isInsert);
		}
		return $item;
 	} 
 
    public function find_which_value($row){
		if(isset($row['value_int']) && $row['value_int']!==null) $val=$row['value_int'];
		elseif(isset($row['value_text']) && $row['value_text']!='') $val=$row['value_text'];
		elseif(isset($row['value_long']) && $row['value_long']!='') $val=$row['value_long'];
    	else $val=$row['value'];
    	
    	if(substr($val,0,11)==='###ARRAY###') return unserialize(substr($val,11));
    	return $val;
    }
    
    //turn a flat set of db rows into a tree array
 	private function organize_flat($items,$address,$noPermissions=false,$itemPerms=false,$suppressEvents=false){
 		$output=array();
		foreach($items as $item){
 			if($item['address']===$address){
 				//create if needed
 				if(!isset($output[$item['name']])) $output[$item['name']]=array();
 				//set this attrib
 				$output[$item['name']][$item['key']]=$this->find_which_value($item);
 				
 				//set created and owner to earliest attribute creation
 				if(!isset($output[$item['name']]['node:created']) ||
 					$output[$item['name']]['node:created']>$item['created']){
 						$output[$item['name']]['node:name']=$item['name'];
	 					$output[$item['name']]['node:created']=$item['created'];
	 					$output[$item['name']]['node:owner']=$item['owner'];
	 					$output[$item['name']]['node:address']=$item['address'].$item['name'];
	 					if($noPermissions!==true && !isset($output[$item['name']]['node:mode'])){
	 						$output[$item['name']]['node:mode']=$this->mode($output[$item['name']]['node:address'],false,true,$itemPerms);
	 						$output[$item['name']]['node:modeString']=$this->mode_to_string($output[$item['name']]['node:mode']);
	 						$output[$item['name']]['node:roles']=$this->mode_to_roles($output[$item['name']]['node:mode']);
	 					}
	 			}
 					
 				//work the children
 				if(!isset($output[$item['name']]['node:children']))
 					$output[$item['name']]['node:children']=
 						$this->organize_flat($items,$address.$item['name'].'/',$noPermissions,$itemPerms);
 				
 			}
 		}
 		/*TODO:virtual data
		//perform item events
  		if($suppressEvents===false){
  			foreach($output as $name=>$item){
	  			$eventItem=$this->event($item['node:address'],'r','item',array($item));
	  			//if event returns array return as replaced data
	  			if(is_array($eventItem)) $output[$name]=$eventItem;
	  			//if event says get out, do it!
	  			elseif($eventItem===false) unset($output[$name]);
  			}
  		}
  		*/
 		return $output;
 	}
 	
	public function mode_to_roles($mode){
		if($mode===false) $mode=0;
    	$out=array();
    	foreach($this->modes as $id=>$bit){
    		if($bit & $mode) $out[$id]=true;
    		else $out[$id]=false;
    	}
    	return $out;
	}

    public function mode_to_string($mode){
    	$out='';
    	foreach($this->modes as $val=>$bit){
    		if($bit & $mode) $out.=$val;
    		else $out.='-';
    	}
    	return $out;
    }
    
    public function filter_for_insert($data,$noMeta=false){
    	foreach($data as $key=>$val){
    		if(substr($key,0,5)==="node:" && (!in_array(substr($key,5),array('owner','children')) || $noMeta)){
    			unset($data[$key]);
    			continue;
    		}
    		//go recursive if kids or the root of a get result
    		if($key==='node:children' || is_array($val)) $data[$key]=$this->filter_for_insert($val);
    	}
    	return $data;
    }
    
    //get display information for a permission access id
    public function access_id_load($accessId){
    	$accessId=(int)$accessId;
    	if($accessId===0){ return array('name'=>'World','group'=>true);
    	}elseif($accessId===-1){ return array('name'=>'All Logged In Users','group'=>true);
    	}elseif($accessId<-100){
    		$group=array_values($this->db->select($this->parent->record_group->table,
    											array('name'),
    											array('id'=>($accessId+100)*-1)));
    		if(count($group)!==1) return false;
    		return array('name'=>$group[0]['name'],'group'=>true);
    	}elseif($accessId>0){
    		$userName=$this->parent->user_user->find_name($accessId);
    		if($userName===false) return false;
    		return array('name'=>$userName,'group'=>false);
    	}
    	return false;
    }

 	
 	//TODO: return error when malformed
 	//determine if a real address matches an address with wildcards in it
 	public function address_matches($realAddress,$eventAddress,$item=false){
 		//no wildcards in real addresses
 		if(strstr($realAddress,'/node:')!==false) return false;
 		$realAddress=$this->filter_address($realAddress);
 		$eventAddress=$this->filter_address($eventAddress);
 		$special=array('node:wild',
 						'node:wild-recursive',
 						'node:wild-or-nothing',
 						'node:wild-recursive-or-nothing',
 						'node:starts-with(',
 						'node:ends-with(',
 						'node:attributes(');
 		$realSplit=explode('/',$realAddress);
 		$eventSplit=explode('/',$eventAddress);
 		foreach($realSplit as $i=>$name){
 			if(isset($eventSplit[$i]) && $name!==''){
 				//static cases
 				//print_r(array('eve'=>$eventSplit,'i'=>$i,'real'=>$realSplit));
 				switch($eventSplit[$i]){
 					case $special[0]: //wild
 						continue;
 					case $special[1]: //wild-recursive
 						if(isset($eventSplit[$i+1]) && count($realSplit)<$i+1){
 							$curAddress=implode('/',array_slice($realSplit,0,$i+1));
 							$curCheck=implode('/',array_merge(array_slice($realSplit,0,$i),array_slice($eventSplit,$i+1,1)));
 							if($this->address_matches($curAddress,$curCheck)){
								array_splice($eventSplit,$i,1);
							}
 						}elseif(count($realSplit)>$i+1){
 							array_splice($eventSplit,$i,1,array($realSplit[$i],$special[3]));
 						}
 						continue;
 					case $special[2]: //wild-or-nothing
 						if(isset($eventSplit[$i+1])){
 							$curAddress=implode('/',array_slice($realSplit,0,$i+1));
 							$curCheck=implode('/',array_merge(array_slice($eventSplit,0,$i),array_slice($eventSplit,$i+1,1)));
	 						if($this->address_matches($curAddress,$curCheck)){
	 							array_splice($eventSplit,$i,1);
	 						}
	 					}
 						break;
 					case $special[3]: //wild-recursive-or-nothing
 						if(isset($eventSplit[$i+1]) && count($realSplit)<=$i+2){
 							
 							//ie do the nothing check as well as the recursive check insteadnof just one
 							if(count($realSplit)<=$i+1){
	 							$curAddress=implode('/',array_slice($realSplit,0,$i+1));
	 							$curCheck=implode('/',array_merge(array_slice($realSplit,0,$i),array_slice($eventSplit,$i+1,1)));
 							}else{
 								$curAddress=$realAddress;
 								$curCheck=implode('/',array_merge(array_slice($realSplit,0,$i),array_slice($eventSplit,$i+1,count($eventSplit))));
 							}
 							//echo "here we are\n";
 							//print_r(array('curAddrA'=>$curAddress,'checkA'=>$curCheck));
 							if($this->address_matches($curAddress,$curCheck)){
 								//echo 'foozle';
								array_splice($eventSplit,$i,1);
							}
							//echo "back in da house\n";
 						}elseif(count($realSplit)>$i+1){
 							//echo 'fo-sho::'.implode('/',array_merge(array_slice($realSplit,0,$i+1),array_slice($eventSplit,$i+2,count($eventSplit))))."\n";
 							//TODO:DONEish need to check to see if this item matches the next item
 							//before moving on and accepting
 							//could go a diff path
 							//TODO: need to check up a level as well as the undermen!!!!
 							//echo 'shiilze::'.implode('/',array_slice($realSplit,0,$i+1));
 							//echo "\nfoozel::".implode('/',array_merge(array_slice($realSplit,0,$i),array_slice($eventSplit,$i+1,1)));
 							if($this->address_matches(implode('/',array_slice($realSplit,0,$i+1)),implode('/',array_merge(array_slice($realSplit,0,$i),array_slice($eventSplit,$i+1,1)))) && $this->address_matches($realAddress,implode('/',array_merge(array_slice($realSplit,0,$i+1),array_slice($eventSplit,$i+2,count($eventSplit)))))) return true;
 							array_splice($eventSplit,$i,0,array($realSplit[$i]));
 						}
 						break;
 				}
				//print_r(array('eve2'=>$eventSplit,'i2'=>$i,'real2'=>$realSplit));
 				//dynamic special cases
 				if(substr($eventSplit[$i],0,strlen($special[4]))===$special[4] &&
 					substr($eventSplit[$i],-1)===')'){ 
	 					//starts-with(term)
						$term=substr($eventSplit[$i],strlen($special[4]),-1);
						if(substr($name,0,strlen($term))!==$term) return false;
 				}elseif(substr($eventSplit[$i],0,strlen($special[5]))===$special[5] &&
 					substr($eventSplit[$i],-1)===')'){ 
	 					//ends-with(term)
						$term=substr($eventSplit[$i],strlen($special[5]),-1);
						if(substr($name,-strlen($term))!==$term) return false;
 				}elseif(substr($eventSplit[$i],0,strlen($special[6]))===$special[6] &&
 					substr($eventSplit[$i],-1)===')'){ 
 						//load item data if not supplied
 						if($item===false) $item=pull_item($this->get(implode('/',array_slice($realSplit,0,$i+1))));
 						if($item===false) return false;
	 					//attributes(term)
	 					$term=substr($eventSplit[$i],strlen($special[6]),-1);
						$booleanSorted=$this->parse_attribute_query_string($term,array($item));
						$curAddresses=$this->query_boolean_sort($booleanSorted);
						if(!count($curAddresses)) return false;
						
				}elseif(substr($eventSplit[$i],0,5)!=='node:' && 
						$eventSplit[$i]!==$name){
					return false;
				}
 			}elseif(!isset($eventSplit[$i]) || $eventSplit[$i]!==$name){
 				return false;
 			}
 		}
 		$lastEventName=$eventSplit[count($eventSplit)-1];
 		if(count($eventSplit)>count($realSplit) && 
 			in_array($lastEventName,$special) && 
 			strstr($lastEventName,'-or-nothing')!==false){
 				array_pop($eventSplit);
 		}
 	
 		return count($realSplit)===count($eventSplit);
 	}
	private function unset_unreadable($items){
		foreach($items as $id=>$item){
			if($items[$id]['node:roles']['r']===false) unset($items[$id]);
			elseif(count($items[$id]['node:children'])){
				$items[$id]['node:children']=$this->unset_unreadable($items[$id]['node:children']);
			}
		}
		return $items;
	}

 	private function each_write_event($data,$prefix='',$complete=false){
 		foreach($data as $key=>$val){
 			if(isset($val['node:children'])){
 				$children=$this->each_write_event($val['node:children'],$prefix.$key.'/',$complete);
 				if($children===false) return false;
 			}else{$children=false;}
 			if(isset($val['node:owner'])){
 				$owner=$val['node:owner'];
 				unset($val['node:owner']);
 			}else{$owner=false;}
 			if($complete){
 				$this->event($prefix.$key,'w','complete');
 			}else{
	 			$eventValidate=$this->event($prefix.$key,'w','validate',array(array(),$val));
	 			if($eventValidate===false) return false;
	  			//if event returns array use as replaced data
	  			$extraAttr=array();
	  			if($children!==false) $extraAttr['node:children']=$children;
	  			if($owner!==false) $extraAttr['node:owner']=$owner;
	  			if(is_array($eventValidate)) $data[$key]=$eventValidate+$extraAttr;
  			}
 		}
 		return $data;
 	}

 	private function query_boolean_sort($args){
 		$found=array();
 		$validModes=array('and','or','not');
 		if(!isset($args['query:mode'])) $args['query:mode']='and';
 		if(!in_array($args['query:mode'],$validModes)) return false;
 		$i=0;
		foreach($args as $key=>$arg){
 			if(substr($key,0,6)==='query:') continue;
 			//numeric (assigned) keys as parenthetical separators
 			if(is_int($key)){
 				$arg=array('found'=>$this->query_boolean_sort($arg));
 			}
 			foreach($arg['found'] as $foundItem){
	 			if($i===0){
	 				if($args['query:mode']==='and'){
	 					$allGood=true;
	 					foreach($args as $innerKey=>$innerArg){
	 						if(substr($innerKey,0,6)==='query:') continue;
	 						if(is_int($innerKey) && !isset($innerArg['found'])){
				 				$args[$innerKey]=$innerArg=array('found'=>$this->query_boolean_sort($innerArg));
				 			}
	 						if(!in_array($foundItem,$innerArg['found'])) $allGood=false;
	 						if($allGood===false) break;
	 					}
	 					if($allGood===true) $found[]=$foundItem;
	 				}else{
	 					$found[]=$foundItem;
	 				}
	 			}else{
	 				switch($args['query:mode']){
	 					case 'or':
	 						$found[]=$foundItem;
	 						break;
	 					case 'not':
	 						if(in_array($foundItem,$found)) $found=array_diff($found,array($foundItem));
	 						break;
	 				}
	 			}
 			}
 			++$i;
 		}
 		return $found;
 	}
 	
 	//Convert a string boolean query to an array for easy access
 	//$instr="(`foo`='bar' and `horse`>'4' or (`test`!='foozle' and `node:created`<'2011-06-05'))"
 	//$items=array of items to search through if you want to include the found results in the array (not sorted though)
 	public function parse_attribute_query_string($instr,$items=array()){
 		$data=array();
 		//step through and build tree
 		$strlen=strlen($instr);
 		$collecting=false;
 		$lastTerm=false;
 		$operator=false;
 		$snippet=false;
 		$needsBoolean=false;
 		//print_r($items);
 		for($i=0;$i<$strlen;$i++){
 			if($instr[$i]==='('){
 				$parenDepth=1;
 				$parenError=true;
 				for($j=$i+1;$j<$strlen;$j++){
 					if($instr[$j]==='(') $parenDepth++;
 					if($instr[$j]===')') $parenDepth--;
 					if($parenDepth===0){ 
 						$parenError=false;
 						break;
 					}
 				}
 				if($parenError) return false;
 				$data[]=$this->parse_attribute_query_string(substr($instr,$i+1,$j-$i-1));
 				$needsBoolean=true;
 				$i=$j;
 			}elseif($instr[$i]==='`' && 
 					$needsBoolean===false){
		 				if($collecting===false){
		 					$collecting=true;
		 					$snippet='';
		 				}else{
		 					$collecting=false;
		 					$lastTerm=$snippet;
		 				}
 			}elseif($instr[$i]==='=' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$operator='=';
 			}elseif(strtolower(substr($instr,$i,2))==='!=' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$i+=1;
 						$operator='!=';
 			}elseif(strtolower(substr($instr,$i,2))==='>=' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$operator='>=';
 						$i+=1;
 			}elseif($instr[$i]==='>' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$operator='>';
 			}elseif(strtolower(substr($instr,$i,2))==='<=' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$operator='<=';
 						$i+=1;
 			}elseif($instr[$i]==='<' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$operator='<';
 			}elseif(strtolower(substr($instr,$i,4))==='like' && 
 					$lastTerm!==false && 
 					$needsBoolean===false){
 						$operator='like';
 						$i+=3;
 			}elseif($instr[$i]==="'" && 
 					$i>0 && $instr[$i-1]!=='\\' && 
 					$lastTerm!==false && 
 					$operator!==false && 
 					$needsBoolean===false){
		  				if($collecting===false){
		 					$collecting=true;
		 					$snippet='';
		 				}else{
		 					$collecting=false;
		 					$curVal=$snippet;
		 					$found=array();
		 					foreach($items as $itemName=>$item){
		 						if($operator==='=' && 
		 							isset($item[$lastTerm]) &&
		 							$item[$lastTerm]==$curVal) 
		 									$found[]=$item['node:address'];
		 						elseif($operator==='>' && 
		 							isset($item[$lastTerm]) &&
		 							$item[$lastTerm]>$curVal) 
		 									$found[]=$item['node:address'];
		 						elseif($operator==='>=' && 
		 							isset($item[$lastTerm]) &&
		 							$item[$lastTerm]>=$curVal) 
		 									$found[]=$item['node:address'];
		 						elseif($operator==='<' && 
		 							isset($item[$lastTerm]) &&
		 							$item[$lastTerm]<$curVal) 
		 									$found[]=$item['node:address'];
		 						elseif($operator==='<=' && 
		 							isset($item[$lastTerm]) &&
		 							$item[$lastTerm]<=$curVal) 
		 									$found[]=$item['node:address'];
		 						elseif($operator==='!=' && 
		 							isset($item[$lastTerm]) &&
		 							$item[$lastTerm]!=$curVal) 
		 									$found[]=$item['node:address'];

		 					}
		 					$data[$lastTerm]=array('value'=>$curVal,'operator'=>$operator,'found'=>$found);
		 					$needsBoolean=true;
		 				}
 			}elseif($needsBoolean===true && 
 					strtolower(substr($instr,$i,3))==='and'){
 						if(!isset($data['query:mode'])) $data['query:mode']='and';
 						elseif($data['query:mode']!=='and') $data=array($data,'query:mode'=>'and');
 						$i+=2;
 						$needsBoolean=false;
 			}elseif($needsBoolean===true && 
 					strtolower(substr($instr,$i,2))==='or'){
 						if(!isset($data['query:mode'])) $data['query:mode']='or';
 						elseif($data['query:mode']!=='or') $data=array($data,'query:mode'=>'or');
 						$i+=1;
 						$needsBoolean=false;
 			}elseif($needsBoolean===true && 
 					strtolower(substr($instr,$i,3))==='not'){
 						if(!isset($data['query:mode'])) $data['query:mode']='not';
 						elseif($data['query:mode']!=='not') $data=array($data,'query:mode'=>'not');
 						$i+=2;
 						$needsBoolean=false;
 			}elseif(substr($instr,$i,2)==="\\'" && $collecting===true){
 				$snippet.="'";
 				$i+=1;
 			}elseif($collecting===true){
 				$snippet.=$instr[$i];
 			}elseif(in_array($instr[$i],array(' ',')'))){
 				continue;
 			}else{
 				return false;
 			}
 		}
 		return $data;
 	}

}

