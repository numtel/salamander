<?/*
salamander framework 20121223
Filename:		mod/tree/relpaths.php
Description:	relative path filter for data tree
	
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

class Node_tree_relpaths {

	protected $parent=false;
	protected $db=false;

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$tree=$parent->record_tree2;
		//add filter hook for relative paths
		$tree->addressFilters[]=function($address,$node){
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
}


	
