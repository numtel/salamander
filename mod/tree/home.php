<?/*
node social program 20120428
Filename:		mod/user/home.php
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


class Node_tree_home {

	protected $parent=false;
	protected $db=false;
	protected $tree=false;
	public $address='/home';
	public $homeAddress=false;
	public $homeData=false;
	public $cUserName=false;
	protected $defaultData=array('admin:icon'=>'user');
	
	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$this->tree=$parent->record_tree2;


		if($this->parent->ini['db']['install']){
			//TODO:make some kind of install process for admin to create root item
		}
										
		$this->cUserName=$this->parent->user_user->find_name();	 

		//only owners can insert into the root home item with validation
		$this->tree->bind($this->address,'i','validate',function($address,$node,$curItem,$data){
			if(!$curItem['node:roles']['o']) return false;
			return true;
		});
		
		//only initialize if logged in
		if($this->cUserName!==false){
		
			$this->homeAddress=$this->address.'/'.$this->cUserName;
			$this->homeData=pull_item($this->tree->get($this->homeAddress,false,false,true));
		
			//create home item if doesnt exist
			if($this->homeData===false){
				$this->tree->insert($this->address.'/',array($this->cUserName=>$this->defaultData),true);
				$this->tree->chmod($this->homeAddress,0,array(0),true);
			}

			//add filter hook for tilde access to home item
			$this->tree->addressFilters[]=function($address,$node){
				if(substr($address,0,1)==='~') return $node->tree_home->homeAddress.substr($address,1);
				if(substr($address,0,2)==='/~') return $node->tree_home->homeAddress.substr($address,2);
				return $address;
			};
			
		
		}
 	}	
 	

}

