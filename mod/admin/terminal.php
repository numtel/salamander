<?/*
node social program 20110503
Filename:		mod/admin/terminal.php
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
config.ini
[front]
save_terminal_history=true (if ommitted, defaults to false)
	Save the user's terminal command history and variables to their home item.
save_terminal_commands=9 (if omitted, defaults to 100)
	Integer value of how many commands to save for each user.
	save_terminal_history must be true for this to take effect.
*/

class Node_admin_terminal {

	protected $parent=false;
	protected $db=false;
	protected $tree=false;
	protected $curVars=false;
	protected $saveHistory=false;
	protected $saveCmdCount=100;
	
	public $help="
This terminal prints the output of a line of PHP code. 
Only users with owner permission on the root of the data tree can access this terminal.

NOTICE: Be very careful using this terminal without backing up data!

Command 'clear' to clear the text area.

Common functions for returning data include: 'echo', 'print_r', 'var_export', and 'var_dump'.

Variables used will be stored throughout your session.
Your command history will be stored throughout your session as well.

Object Reference:
	\$node = Node Object
	\$this = \$node->admin_terminal
	\$this->tree = \$node->record_tree2
	\$this->home = \$node->tree_home
	
Example - Display items at root of data tree 0 levels deep.
	print_r(\$this->tree->get('/',0));
	
Example - Clear your saved terminal commands and variables.
	\$this->clearTerminalData();
";

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
		$this->tree=$parent->record_tree2;
		$this->home=$parent->tree_home;
		
		if(isset($parent->ini['front']['save_terminal_history']))
			$this->saveHistory=(bool)$parent->ini['front']['save_terminal_history'];
		if(isset($parent->ini['front']['save_terminal_commands']))
			$this->saveCmdCount=(int)$parent->ini['front']['save_terminal_commands'];
		
		if($this->saveHistory && isset($this->home->homeData['.terminal'])){
			$_SESSION['terminalHistory']=$this->home->homeData['.terminal']['cmd'];
			$_SESSION['terminalVars']=$this->home->homeData['.terminal']['data'];
		}
	}

 	public function post($fields){
 		if(isset($fields['action'])){
 			switch($fields['action']){
 				case 'getHistory':
 					if(isset($_SESSION['terminalHistory'])) return $_SESSION['terminalHistory'];
 				case 'command':
 					$rootRoles=$this->tree->mode_to_roles($this->tree->mode('/'));
 					if($rootRoles['o']){
 						$node=$this->parent;
 						$retval=false;
 						$this->curVars=array_keys(get_defined_vars());
 						if(isset($_SESSION['terminalVars'])) extract($_SESSION['terminalVars']);
 						if(!isset($_SESSION['terminal'])) $_SESSION['terminal']=array();
 						if(!isset($_SESSION['terminalHistory'])) $_SESSION['terminalHistory']=array();
 						if(trim($fields['command'])!=''){
 							if(count($_SESSION['terminalHistory'])){
	 							$lastCommand=$_SESSION['terminalHistory'][count($_SESSION['terminalHistory'])-1];
	 							if($fields['command']!==$lastCommand)
	 								$_SESSION['terminalHistory'][]=$fields['command'];
	 							unset($lastCommand);
 							}else{
 								$_SESSION['terminalHistory'][]=$fields['command'];
 							}
 						}
 						while(count($_SESSION['terminalHistory'])>$this->saveCmdCount) array_shift($_SESSION['terminalHistory']);
 						$retval=eval($fields['command']);
 						
 						if($_SESSION['terminalVars']==='clear'){
 							$_SESSION['terminalVars']=array();
 						}else{
	 						$afterVars=get_defined_vars();
	 						foreach($afterVars as $key=>$val){
	 							if(in_array($key,$this->curVars)) unset($afterVars[$key]);
	 						}
	 						$_SESSION['terminalVars']=$afterVars;
 						}
 						
 						if($this->saveHistory){
	 						$this->tree->edit('~',array('.terminal'=>
						 								array('cmd'=>$_SESSION['terminalHistory'],
						 									  'data'=>$_SESSION['terminalVars'])));
						}
 						return $retval;
 					}else{ return 'Access Denied! Must be have owner permissions on root.'; }
 			}
 		}
 	}
 	
 	public function clearTerminalData(){
 		$_SESSION['terminalHistory']=array();
 		$_SESSION['terminalVars']='clear';
 	}
   	
}
?>
