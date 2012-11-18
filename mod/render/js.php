<?/*
salamander framework 20110503
Filename:		mod/render/js.php
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

class Node_render_js {

	protected $node=false;
	
	public $js=array();
	

	public function __construct($node){
		$this->node=$node;
		
		if(!is_dir($node->ini['front']['cache_dir'])&& !mkdir($node->ini['front']['cache_dir'])) die('<h1>No cache directory available!</h1> <p>Please create '.$node->ini['front']['cache_dir'].' with mode 0777.</p>');
		$min_file=$node->ini['front']['cache_dir'].$node->ini['front']['js_min'];
		$re_minify=false;
		if(file_exists($min_file) && isset($node->ini['front']['js']) && is_array($node->ini['front']['js'])){
			foreach($node->ini['front']['js'] as $file){
				if(substr($file,0,2)!=='//' && !$node->ini['front']['debug_js']){
					if(file_exists($file) && filemtime($file) > filemtime($min_file)) 
						$re_minify=true;
				}else $this->js[]=$file;
					
			}
		}else{ $re_minify=true; }
		//Reminify css if its been updated
		if($re_minify){ 
			# Include minify library
			require $node->fs_path.'lib/jsmin.php';
			$script = "";
			if(isset($node->ini['front']['js']) && is_array($node->ini['front']['js'])){
				foreach($node->ini['front']['js'] as $file){
					if(substr($file,0,2)!=='//') $script .= file_get_contents($file);
				}
			}
		
			$packer = new JavaScriptPacker($script, 'Normal', true, false);
			$packed = $packer->pack();
			//Save/Update minified version
			if(file_exists($min_file)) unlink($min_file);
			file_put_contents($min_file, $packed);
		}
		if(!$node->ini['front']['debug_js']) $this->js[]=$min_file;
		
		$html='';
		if(isset($node->query['page']))
			$toRoot=str_repeat('../',count(explode('/',$node->query['page']))-1);
		else $toRoot='';
		foreach($this->js as $file){
			$html.='<script src="'.(substr($file,0,2)!=='//' ? $toRoot : '').$file.'"></script>'."\n";
		}
		$node->page['headerHTML'][]=$html;
	}
		
}

