<?/*
node social program 20110503
Filename:		mod/render/post.php
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

class Node_render_post {

	protected $parent=false;
	
	public $status=false;	
	public $did_post=false;
	public $allowed_files=false;
	public $returns=array();
	public $posts=array();

	public function __construct($parent){
		$this->parent=$parent;
		if(!isset($_POST) || !isset($parent->ini['post'])) return false;
		$posts=$this->get_posts($_POST);
		$this->parent->posts=$posts;
		//print_r($posts);
		if(count($posts)) $this->did_post=true;
		foreach($posts as $postName=>$data){
			//array with each post action in it
			if(isset($data['action']) && isset($data['fields']) && strpos($data['action'],'/')!==false){
				$module=substr($data['action'],0,strpos($data['action'],'/'));
				$data['fields']['action']=substr($data['action'],strpos($data['action'],'/')+1);
				if(isset($parent->$module)){
					$allow=$this->transform($parent->ini['post']);
					foreach($allow as $rule){
						$check=true;
						//check to see if this post passes the checks
						foreach($rule['check'] as $cCheck){
							$cCheck=explode('/',$cCheck);
							if(count($cCheck)>2){
								if(isset($parent->$cCheck[0]) && 
									method_exists($parent->$cCheck[0],$cCheck[1]) && 
									call_user_func_array(array($parent->$cCheck[0],$cCheck[1]),array_slice($cCheck,2))) $check=true;
								else $check=false;
							}elseif(count($cCheck)===2){
								if(isset($parent->$cCheck[0]) && 
									method_exists($parent->$cCheck[0],$cCheck[1]) && 
									$parent->$cCheck[0]->$cCheck[1]()) $check=true;
								else $check=false;
							}else{ $check=false; }
							if(!$check) break;
						}
						if($check){
							//check to see if this post conforms to at least one allowed pattern
							$check=false;
							foreach($rule['allow'] as $cAllow){
								$cAllow=$parent->parse_post_allow_str($cAllow);
								if(count($cAllow)===1 && strpos($cAllow[0],'/')===false &&
									substr($data['action'],0,strpos($data['action'],'/'))===$cAllow[0]){
										$check=true;
								}elseif($data['action']===$cAllow[0] &&
									/* if the post allow string is more than just 1 parameter */
									(count($cAllow)>1 ? 
										/*and the page matches the spec'd page */
										(substr($parent->query['page'],0,strlen($cAllow[1]))==$cAllow[1]) 
										/* or the spec is for anything */
										|| ($cAllow[1]==='*')
										/* no spec? no problem */
										 : true) && 
										/* and the fields work out */
										$this->check_fields($cAllow,$data['fields'])){
											$check=true;
								}else{ $check=false; }
								if($check) break;
							}
						}
						if($check){
							//send files through in the files if allowed
							if(count($_FILES) && $this->allowed_files!==false){
								$postNameCut=substr($postName,6);
								//disallow files that don't match the extension
								foreach($_FILES as $id=>$info){
									$fileExt=strtolower(substr(basename( $info['name']),strrpos(basename( $info['name']),'.')+1));
									if($info['error']!==4){
										if($info['error']===1){
											$this->status="Uploaded file too large!";
											return;
										}elseif(!in_array($fileExt,$this->allowed_files)){
											//unset($data['fields']['_FILES'][$id]);
											//Fail the post instead:
											$this->status="Invalid file extension on upload!";
											return;
										}elseif($info['error']!==0){
											$this->status="File Upload Error #".$info['error'];
											return;
										}
									}
									//separate files for each different post section
									if(substr($id,4,strlen($postNameCut))==$postNameCut){
										$newId='file'.substr($id,4+strlen($postNameCut));
										$data['fields']['_FILES'][$newId]=$_FILES[$id];
									}

								}
							}
							//update fields if needed
							$data['fields']=$this->parse_stati($data['fields']);
							
							
							//set the status to the return of the module's post function
							$this->status=$parent->$module->post($data['fields']);
							if(isset($parent->$module->extra_status)){
								$this->returns[$postName]=$parent->$module->extra_status;
								unset($parent->$module->extra_status);
							}
							//only do this post once even if it matches multiple rules
							break;
						}
					}

				}
			}
		}
		//if($this->did_post && !$this->status) $this->status="Invalid form submission!";
	}
	
	//stati=plural of status
	private function parse_stati($fields){
		foreach($fields as $key=>$val){
			if(is_array($val)) $fields[$key]=$this->parse_stati($val);
			elseif(substr($val,0,3)==='###') $fields[$key]=$this->returns[substr($val,3)];
		}
		return $fields;
	}
	
	private function get_posts($data){
		$output=array();
		foreach($data as $key=>$val){
			if(substr(strtolower($key),0,6)==='action'){
				$actId=strtolower(substr($key,6));
				
				if(isset($data['fields'.$actId])) $output[$key]=array('action'=>$val,'fields'=>$data['fields'.$actId]);
			}
		}
		return $output;
	}
	
	private function transform($input){
		$output=array();
		foreach($input as $id=>$rules){
			$rule_id=substr($id,5);
			if(!isset($output[$rule_id])) $output[$rule_id]=array('check'=>array(),'allow'=>array());
			$output[$rule_id][substr($id,0,5)]=array_merge($output[$rule_id][substr($id,0,5)],$rules);
		}
		return $output;
	}
	
	private function check_fields($parsed,$fields){
		for($i=2;$i<count($parsed);$i++){
			if(count($parsed)>2 && $i===count($parsed)-1) break;
			$param=trim(substr($parsed[$i],0,strpos($parsed[$i],'=')));
			$value=trim(substr($parsed[$i],strpos($parsed[$i],'=')+1));
			$param_spl=preg_split("/[\[\]]/",$param);
			$is_array=false;
			
			if(strtolower($param)==='files' && strlen($value)){
				$this->allowed_files=explode(';',$value);
				continue;
			}
			if(count($param_spl)>1){
				$compare=$fields;
				foreach($param_spl as $j=>$part){
					//TODO: there is a bug in this! if you cant have attr[name]
					//right now it must be attr[name][]
					//if its a 2d array, it must end in an array
					//Seems to be fixed 110813
					if($part===''){
						$is_array=true;
					}else{
						if(!isset($compare[$part])) return false;
						$compare=$compare[$part];
					}
				}
				if(is_array($compare)) $arr_vals=array_values($compare);
			}else{
				if(!isset($fields[$param])) return false;
				$compare=$fields[$param];
			}
			
			//string value
			if(count(explode("'",$value))===3 &&
				$compare!==substr($value,1,-1)) return false;
				
			//node structure variable
			//starts at the base of $parent (e.g. $record_group->table)
			if(substr($value,0,1)==='$'){
				$var=explode('->',substr($value,1));
				$cur=$this->parent;
				while(count($var)){
					$next=explode('.',array_shift($var));
					$first=array_shift($next);
					$cur=$cur->$first;
					while(count($next)){
						$cur=$cur[array_pop($next)];
					}
				}
				if($compare!=$cur) return false;
			}
			
			//count of array items
			if(substr(strtolower($value),0,6)==='count:'){
				$countVal=substr($value,6);
				if(is_numeric($countVal) && count($arr_vals)!==$countVal*1) return false;
			}
			
			//not_empty value or array or single item array with one empty item
			if(strtolower($value)==='not_empty' &&
				(is_array($compare) ? 
					(count($compare)==0 || (count($compare)===1 && $arr_vals[0]=='')) : 
					($compare==''))) 
				return false;
				
			//false required
			if(strtolower($value)==='false' &&
				($compare!=false)) 
				return false;
		}
		if(count($_FILES) && $this->allowed_files===false) return false;
		return true;
	}
		
}
?>
