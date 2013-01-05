<?/*
salamander framework 20121223
Filename:		mod/tree/queryfilter.php
Description:	query path filter and cache for data tree
	
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

class Node_tree_queryfilter {

	protected $parent=false;
	protected $db=false;
	public $dataPath="~/queries";
	public $data=false;
	public $defaultData=array('admin:icon'=>'tag');

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$tree=$parent->record_tree2;
		$this->data=pull_item($tree->get($this->dataPath));
		
		//add filter hook for relative paths
		$tree->addressFilters[]=function($address,$node){
			//query:/:::`foo`!=''
			//optional paging: query:my_search_id:::/:::`foo`!='':::10,1
			if(substr($address,0,6)==='query:'){
				if($node->tree_queryfilter->data===false){
					$node->record_tree2->insert(substr($node->tree_queryfilter->dataPath,0,strrpos($node->tree_queryfilter->dataPath,'/')+1),array(substr($node->tree_queryfilter->dataPath,strrpos($node->tree_queryfilter->dataPath,'/')+1)=>$node->tree_queryfilter->defaultData));
					$node->tree_queryfilter->data=array('node:children'=>array());
				}


				$queryDetails=explode(':::',substr($address,6));
				$cacheItem=$node->tree_queryfilter->dataPath.'/'.$queryDetails[0];
				$curItem=pull_item($node->record_tree2->get($cacheItem));
				if($curItem===false){
					if(isset($queryDetails[3])){
						$paging=explode(',',$queryDetails[3]);
					}else{$paging=array(0,1);}
					$queryResults=$node->record_tree2->query($queryDetails[1],$queryDetails[2],true,false,$paging[0],$paging[1]);
					$cacheData=array('results'=>$queryResults,
									'memUsage'=>memory_get_peak_usage(true),
									'dbCount'=>$node->db->count);
					$node->record_tree2->insert($node->tree_queryfilter->dataPath.'/',array($queryDetails[0]=>$cacheData));
				}else{
					//$node->record_tree2->edit($cacheItem,$cacheData);
				}
				return $cacheItem;
			}
			return $address;
		};
	}
}


	
