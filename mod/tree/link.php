<?/*
salamander framework 20120428
Filename:		mod/tree/link.php
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

/*
on insert/write: link:address attribute, add to table(linkitem,address)
if address matches, provide alternate content
*/
class Node_tree_link {

	protected $parent=false;
	protected $db=false;
	protected $tree=false;
	public $table='tree_links';
	
	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$this->tree=$parent->record_tree2;
		
		$linkPattern="/node:wild-recursive-or-nothing/node:attributes(`link:type`!='')/node:wild-recursive";

		if($this->parent->ini['db']['install']){
		   	$this->db->init_table($this->table,array('address'=>'VARCHAR( 1000 ) NOT NULL',
													'reference'=>'VARCHAR( 1500 ) NOT NULL',
													''=>'INDEX (`address`)'));
		}
		
		/* 
		$this->tree->bind('/node:wild-recursive','r','validate',function($address,$node,$depth,$isRange){
			$addrSplit=explode('/',$address);
			
		});
										
		$this->tree->bind('/node:wild-recursive', 'w', 'complete', function($address,$node){
			$data=pull_item($node->record_tree2->get($address));
			if($data===false) return false;
			//node insert/edit
			if(isset($data['link:address'])){
				//check if row exists for this item address
				$cLink=$node->db->select($node->tree_link->table,'*',array('@str'=>"locate(`address`,'".mysql_real_escape_string($address)."')=1"));
				if(is_array($cLink)){
					//update the link to the new reference address
					$cLinkId=array_keys($cLink);
					$linkSuccess=$node->db->update($node->tree_link->table,array('id'=>$cLinkId[0]),
									array('reference'=>$data['link:address']));
				}else{
					//insert new link
					$linkSuccess=$node->db->insert($node->tree_link->table,array(
										'address'=>$address,
										'reference'=>$data['link:address']));
				}
			}
			return true;
		});
		$this->tree->bind('/node:wild-recursive', 'd', 'complete', function($address, $node){
		});
		$this->tree->bind('/node:wild-recursive', 'm', 'complete', function($address, $node){
		});
		

		$this->tree->bind('/node:wild-recursive','r','validate',function($address,$node,$depth,$isRange){
			$cLink=$node->db->select($node->tree_link->table,'*',array('@str'=>"locate(`address`,'".mysql_real_escape_string($address)."')=1"));
			if($cLink!==false && count($cLink)){
				$cLink=array_values($cLink);
				$linkAddress=$cLink[0]['reference'].substr($address,strlen($cLink[0]['address'])).($isRange ? '/' : '');
				//echo $linkAddress.','.$depth;
				$fakeData=$node->record_tree2->get($linkAddress,$depth);
				return $node->tree_link->adjust_addresses($fakeData,$cLink[0]['reference'],$cLink[0]['address']);
			}else{
				return true;
			}
		});
		$this->tree->bind($linkPattern,'r','complete',function($address,$node,$data){
			//$cLink=$node->db->select($node->record_tree2->table,'*',array('@str'=>" `key` like 'link:%' and locate(`address`,'".mysql_real_escape_string($address)."')=1"));
			if($cLink!==false && count($cLink)){
				$linkAddress=false;
				foreach($cLink as $row){
					$linkName=substr($row['key'],5);
					$linkItemAddress=$row['address'].'/'.$linkName;
					$addrPrefix=substr($address,0,strlen($linkItemAddress)+1);
					if($addrPrefix===$linkItemAddress.(strlen($addrPrefix)===strlen($linkItemAddress) ? '' : '/')){
						$linkAddress=$node->record_tree2->find_which_value($row);
						break;
					}
				}
				if($linkAddress!==false){
					$linkedItem=$linkAddress.substr($address,strlen($linkItemAddress)).($isRange ? '/' : '');
					$fakeData=$node->record_tree2->get($linkedItem,$depth);
					return $node->tree_link->adjust_addresses($fakeData,$linkAddress,$linkItemAddress);
				}
			}
			return true;
		});*/
		
 	}	
 	
 	public function adjust_addresses($data,$ref,$addr){
 		foreach($data as $key=>$val){
 			$data[$key]['node:address']=$addr.substr($val['node:address'],strlen($ref));
 			if(count($val['node:children'])) $data[$key]['node:children']=$this->adjust_addresses($val['node:children'],$ref,$addr);
 		}
 		return $data;
 	}
 	
 	//for data imports and suches
	public function repairLinks($rootAddress='/'){
	}
}

