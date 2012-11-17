<?/*
node social program 20110503
Filename:		mod/render/haml.php
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

class Node_render_haml {

	protected $parent=false;
	

	public function __construct($parent){
		$this->parent=$parent;
		require_once $this->parent->fs_path.'lib/haml/HamlParser.php';
	}

	public function render($page='',$render_params=array(),$template='',$return=false){
		//some variables for the page to use
		$node = $this->parent;

		if($page=='') $page=$node->page['uri'];
		if($template==='') $template=$node->page['template'];
		$tplCacheDir=$node->ini['front']['cache_dir'].'tpl';
		//TODO:for some reason this doesn't work...I think it's a big in the parser
		if($node->ini['front']['debug_haml']) $hamlOpts=array('style'=>'nested', 'ugly'=>true);
		else $hamlOpts=array();
		$haml = new HamlParser($hamlOpts);
		
		$curPage=$node->root_http_path.$page;
		if(isset($node->query['page']))
			$toRoot=str_repeat('../',count(explode('/',$node->query['page']))-1);
		else $toRoot='';

		$headerHTML=implode($node->page['headerHTML']);
		
		//set $cancelPage to true in your tpl.php if you want to cancel loading the page
		$cancelPage=false;

		//load backend extra php if available for template then page
		if(file_exists($node->ini['front']['template_dir'].$template.'.php'))
			include $node->ini['front']['template_dir'].$template.'.php';
		if(!$cancelPage){
			if(file_exists($node->ini['front']['template_dir'].$page.'.php'))
				include $node->ini['front']['template_dir'].$page.'.php';
			if(!$cancelPage){
				//load page content
				$page_filename=$node->ini['front']['template_dir'].$page;
				ob_start();
				if(file_exists($page_filename.'.haml'))
					include $haml->parse($page_filename.'.haml', $tplCacheDir);
				elseif(file_exists($page_filename.'.phtml'))
					include $page_filename.'.phtml';
				$content=ob_get_clean();
			}else $content='';
		}else $content='';
		
		//load template or dump content
		$template_filename=$node->ini['front']['template_dir'].$template;
		if($return){
			return $content;
		}elseif($template && file_exists($template_filename.'.haml')){
			include $haml->parse($template_filename.'.haml', $tplCacheDir);
		}elseif($template && file_exists($template_filename.'.phtml')){
			include $template_filename.'.phtml';
		}else echo $content;

	}

}
