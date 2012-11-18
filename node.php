<?/*
salamander framework 20110503
Filename:		index.php
Description:	module manager

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
require_once('lib/general.php');


class Node {
	private $config_name="config.ini";

	//program buffers
	public $query=array(),$mods=array();
	public $page,$db,$ini,$post_status;

	public function __construct(){
		//DETERMINE DIRECTORIES AND SUCH!
		//e.g. /benGallery/gallery/admin.php ( after the domain in the url)
		$this->uri=substr($_SERVER['REQUEST_URI'],0,(strpos($_SERVER['REQUEST_URI'],'?')?strpos($_SERVER['REQUEST_URI'],'?'):strlen($_SERVER['REQUEST_URI'])));
		
		$this->http_server='http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['HTTP_HOST'];
		
		if(isset($_SERVER['HTTP_REFERER'])){
			if(substr($_SERVER['HTTP_REFERER'],0,strlen($this->http_server))==$this->http_server){
				$this->referer=substr($_SERVER['HTTP_REFERER'],strlen($this->http_server));
			}else{
				$this->referer=$_SERVER['HTTP_REFERER'];
			}
		}
		
		//e.g. /var/www/benGallery/gallery/ ( absolute path to the gallery script)
		$this->fs_path=$_SERVER['DOCUMENT_ROOT'].substr($_SERVER["SCRIPT_NAME"],0,strrpos($_SERVER["SCRIPT_NAME"],'/')+1);
	
		//load params from url
		parse_str($_SERVER['QUERY_STRING'],$this->query);
		
		//subtract query string from uri to end up with the http path to the app on this server
		if(isset($this->query['page']) && !empty($this->query['page'])){
			$this->root_http_path=substr($this->uri,0,-strlen(str_replace(array(' '),
																		  array('%20'),
																		  $this->query['page'])));
		}else{
			$this->root_http_path=$this->uri;
		}
		
		//BEGIN SESSION!
		session_set_cookie_params(0,$this->root_http_path);
		$a = session_id();
		if ($a == '') session_start();
		if (!isset($_SESSION['safety'])) {
			session_regenerate_id(true);
			$_SESSION['safety'] = true;
		}
		$_SESSION['sessionid'] = session_id();

		//LOAD CONFIGURATION
		$this->ini=parse_ini_file($this->config_name,true);

		//determine which page to view
		$this->page=array('uri'=>$this->ini['front']['default'],'params'=>array(),'template'=>false);
		if(isset($this->query['page'])) 
			$this->page=$this->determine_uri_split($this->query['page']);
			
		$this->page['template']=$this->determine_tpl($this->page['uri']);
		
		//load cascading extra config
		$this->page['extra_config']=array_reverse($this->determine_cfg($this->page['uri']));
		foreach($this->page['extra_config'] as $extra_config){
			$this->load_cfg($extra_config);
		}
		
		//load package configs
		while(isset($this->ini['front']) && isset($this->ini['front']['config']) && 
				is_array($this->ini['front']['config']) && count($this->ini['front']['config'])){
				
			foreach($this->ini['front']['config'] as $pkgId=>$pkg){
				$this->load_cfg($this->ini['front']['template_dir'].$pkg.'/'.$this->config_name);
				unset($this->ini['front']['config'][$pkgId]);
			}
		}
		
		//load header html code from the config file!
		if(isset($this->ini['front']['headerHTML'])) $this->page['headerHTML']=$this->ini['front']['headerHTML'];
		else $this->page['headerHTML']=array();
		

		//load database driver module
		if(isset($this->ini['db']['driver'])) $this->db=$this->load($this->ini['db']['driver']);	
			
		//load initial modules in ascending order of keys
		ksort($this->ini['init']);
		foreach($this->ini['init'] as $mod_array){
			foreach($mod_array as $mod){
				$this->load($mod);
			}
		}
		
	}

	public function __destruct(){

	}
	
	public function load_cfg($extra_config){
		$dir_ini=parse_ini_file($extra_config,true);
		$iniVars=array('#thisdir#'=>substr($extra_config,0,-strlen($this->config_name)-1));
		$iniVars['#thistpl#']=substr($iniVars['#thisdir#'],strlen($this->ini['front']['template_dir']));
		$iniVars['#thisuri#']=$this->root_http_path.$iniVars['#thistpl#'];
		$iniVars['#rooturi#']=$this->root_http_path;
		$iniVarsKeys=array_keys($iniVars);
		$iniVarsVals=array_values($iniVars);
		//merge front sections
		if(isset($dir_ini['front'])){
			foreach($dir_ini['front'] as $key=>$val){
				//replace any values that need to contain the current config.ini directory
				if(is_array($val)){
					foreach($val as $key2=>$val2){
						$dir_ini['front'][$key][$key2]=str_replace($iniVarsKeys,$iniVarsVals,$val2);
					}
				}elseif(is_string($val)){
					$dir_ini['front'][$key]=str_replace($iniVarsKeys,$iniVarsVals,$val);
				}
				
				if(!is_array($val) && isset($this->ini['front'][$key])) unset($this->ini['front'][$key]);
			}
		
			if(!isset($this->ini['front'])) $this->ini['front']=array();
			if(isset($dir_ini['front']['replace_front']) && $dir_ini['front']['replace_front']) 
				$this->ini['front']=$dir_ini['front'];
			elseif(!isset($this->ini['front']['replace_front']) || !$this->ini['front']['replace_front'])
				//allow children to unset specific values
				if(isset($dir_ini['front']['unset'])){
					foreach($dir_ini['front']['unset'] as $unsetKey=>$unset){
						if(isset($this->ini['front'][$unset])){
							unset($this->ini['front'][$unset]);
							unset($dir_ini['front']['unset'][$unsetKey]);
						}
					}
				}
				$this->ini['front']=array_merge_recursive($this->ini['front'],$dir_ini['front']);
		}
		//merge path sections
		if(isset($dir_ini['path'])){
			if(!isset($this->ini['path'])) $this->ini['path']=array();
			$this->ini['path']=array_replace($this->ini['path'],$dir_ini['path']);
		}
		//merge init sections
		if(isset($dir_ini['init']))
			foreach($dir_ini['init'] as $id=>$mod_arr){
				if(!isset($this->ini['init'])) $this->ini['init']=array();
				$this->ini['init'][$id]=array_merge($this->ini['init'][$id],$dir_ini['init'][$id]);
			}
		//merge post sections
		if(isset($dir_ini['post'])){
			//update page paths
			foreach($dir_ini['post'] as $id=>$rule){
				$rule_id=substr($id,5);
				foreach($rule as $rId=>$str){
					if(substr(strtolower($id),0,5)==='allow'){
						$dir_path=substr($extra_config,0,-strlen($this->config_name));
						$dir_path=substr($dir_path,strlen($this->ini['front']['template_dir']));
						$str_spl=$this->parse_post_allow_str($str);
						if(count($str_spl)>1) $str_spl[1]=$dir_path.$str_spl[1];
						$dir_ini['post'][$id][$rId]=$this->rebuild_post_allow_str($str_spl);
					}
				}
			}
			if(!isset($this->ini['post'])) $this->ini['post']=array();
			$this->ini['post']=array_replace($this->ini['post'],$dir_ini['post']);
		}
	}
	
	public function parse_post_allow_str($instr){
		return preg_split("/[\@\{\}\,]/", $instr);
	}
	
	public function rebuild_post_allow_str($array){
		foreach($array as $i=>$val){
			$before='';
			if($i===1) $before='@';
			if($i===2) $before='{';
			if($i>2 && $i!==count($array)-1) $before=',';
			if($i===count($array)-1 && count($array)>2) $before='}';
			$array[$i]=$before.$val;
		}
		return implode($array);
	}

	private function determine_uri_split($uri,$params=array()){
		if(($this->ini['front']['missing_to_index'] && !$uri) ||
				file_exists($this->ini['front']['template_dir'].$uri.'.haml') || 
				file_exists($this->ini['front']['template_dir'].$uri.'.phtml')){
			return array('uri'=>(!$uri ? $this->ini['front']['default'] : $uri),'params'=>$params,'template'=>false);
		}elseif(file_exists($this->ini['front']['template_dir'].$uri) && !is_file($this->ini['front']['template_dir'].$uri)){
			if(substr($uri,-1)!=='/'){
				$uri.='/';
				if(count($params)===0) header('Location: '.$this->http_server.$this->uri.'/');
			}
			return array('uri'=>$uri.$this->ini['front']['default'],'params'=>$params,'template'=>false);			
		}else {
			$uri=explode('/',$uri);
			//at the end?
			if(!$this->ini['front']['missing_to_index'] && count($uri)===1) return array('uri'=>$this->ini['front']['error_404'],'params'=>$params,'template'=>false);
			//move one item from the uri to the params
			array_unshift($params,array_pop($uri));
			//take care of trailing slashes
			$last_param=array_pop($params);
			if($last_param!='') $params[]=$last_param;
			//and try again!
			return $this->determine_uri_split(implode('/',$uri),$params);
		}
	}
	
	private function determine_cfg($uri){
		$found=array();
		$tpl_candidate=explode('/',$uri);
		$tpl_last=array_pop($tpl_candidate);
		$tpl_uri=implode('/',$tpl_candidate);
		$dir_ini_file=$this->ini['front']['template_dir'].($tpl_uri!=='' ? $tpl_uri.'/' : '').$this->config_name;
		if(file_exists($dir_ini_file)) $found[]=$dir_ini_file;
		if($tpl_uri=='') return $found;
		$found=array_merge($found,$this->determine_cfg($tpl_uri));
		return $found;
	}
	
	private function determine_tpl($uri){
		$tpl_candidate=explode('/',$uri);
		$tpl_last=array_pop($tpl_candidate);
		$tpl_candidate[]=$this->ini['front']['page_template'];
		$tpl_uri=implode('/',$tpl_candidate);
		if(file_exists($this->ini['front']['template_dir'].$tpl_uri.'.haml') || 
				file_exists($this->ini['front']['template_dir'].$tpl_uri.'.phtml')) return $tpl_uri;
		else {
			if(count($tpl_candidate)===1) return false;
			$tpl_last=array_pop($tpl_candidate);
			return $this->determine_tpl(implode('/',$tpl_candidate));
		}
	}
	
	//load a module onto this node object
	public function load($mod){
		//remove the suffix in it's there
		if(strlen($this->ini['path']['module_suffix'])!==false &&
		   substr($mod,-strlen($this->ini['path']['module_suffix']))===$this->ini['path']['module_suffix'])
				$ccMod=substr($mod,0,-strlen($this->ini['path']['module_suffix']));
		else $ccMod=''.$mod;

		$ccMod=str_replace(array("/","."),array("_","-"),$ccMod);
		
		if(!in_array($ccMod,$this->mods) && !isset($this->$ccMod)){
			try{
				$this->mods[]=$ccMod;
				require_once($this->ini['path']['modules'].$mod);
				$cccMod='Node_'.$ccMod;
				$this->$ccMod=new $cccMod($this);
			}catch(exception $ex){
				return false;
			}
		}
		if(isset($this->$ccMod)) return $this->$ccMod;
		else return true;
	}


}

