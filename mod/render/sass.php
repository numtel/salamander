<?/*
node social program 20110503
Filename:		mod/render/sass.php
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
Requires in ini: frontend/cache_dir
Ini arrays to read: frontend/css, frontend/sass

*/
class Node_render_sass {

	protected $node=false;
	
	public $css;

	public function __construct($node){
		$this->node=$node;

		require_once $node->fs_path.'lib/sass/SassParser.php';
		
		$sasscCacheDir=$node->ini['front']['cache_dir'].'sassc';
		$cssCacheDir=$node->ini['front']['cache_dir'].'css';

		$sass = new SassParser(array('cache_location'=>$sasscCacheDir,
									 'css_location'=>$cssCacheDir,
									 'style'=>'compact',
									 'vendor_properties'=>true));
		
		//load css fields
		$this->css=isset($node->ini['front']['css']) && 
				    is_array($node->ini['front']['css']) ? 
						$node->ini['front']['css'] : array();
		if(isset($node->ini['front']['sass'])){
			foreach($node->ini['front']['sass'] as $input){
				//adjust the input filename if its relative to current directory
				if(substr($input,0,2)==='./') $input=substr($input,2);
				//determine output filename
				$output=$cssCacheDir.'/'.preg_replace(array('/^.\//','/\//','/.scss/'),array('','-','.css'),$input);
				try {
					if (!file_exists($output) || (@filemtime($input) > filemtime($output))) {
						if (!is_dir($cssCacheDir)) @mkdir($cssCacheDir);
						$parsed=$sass->toCss($input);
						//adjust src values relative to the cache dir
						$relative=str_repeat('../',count(explode('/',$node->query['page']))).substr($input,0,strrpos($input,'/')+1);
						$parsed=explode('url(',$parsed);
						for($i=1;$i<count($parsed);$i++){
							//don't get rid of quote marks
							$fChar=substr($parsed[$i],0,1);
							if($fChar==='"' || $fChar==="'") $parsed[$i]=substr($parsed[$i],1);
							else $fChar='';
							$parsed[$i]=$fChar.$relative.$parsed[$i];
						}
						$parsed=implode('url(',$parsed);
						//save the file
						$return = (file_put_contents($output, $parsed)
								=== false ? false : $output);
					}
					$this->css[]=$output;
				}catch (exception $ex) {
					exit($ex->getMessage());
				}
			}
		}
		$html='';
		if(isset($node->query['page']))
			$toRoot=str_repeat('../',count(explode('/',$node->query['page']))-1);
		else $toRoot='';
		foreach($this->css as $file){
			$html.='<link href="'.(substr($file,0,2)!=='//' ? $toRoot : '').$file.'" rel="stylesheet" />'."\n";
		}
		$node->page['headerHTML'][]=$html;
		
	}
}
