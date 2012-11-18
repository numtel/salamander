<?/*
salamander framework 20110905
Filename:		mod/img/resize.php
Description:	uses ImageMagick!

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


class Node_img_resize {

	protected $parent=false;
	protected $db=false;

	public function __construct($parent){
		$this->parent=$parent;
		$this->db=$parent->db;
 	}	
 	
 	public function load($file,$width,$height,$center=false){
 		$prefix=substr($this->parent->fs_path,0,-strlen($this->parent->root_http_path));
 		$original=$file;
 		//if no resizing, return original
 		if($width===false && $height===false) return $file;
 		//generate filename for resized image
 		$file=substr($file,0,strrpos($file,'.')).'-'.$width.'x'.$height.($center ? '-c' :'').substr($file,strrpos($file,'.'));
 		if(!file_exists($prefix.$original)) return false;
 		//check for cached image
 		if(!file_exists($prefix.$file)){
 			//create new image
 			$this->resize($prefix.$original,$prefix.$file,$width,$height,$center);
 		}
 		return $file;
 	}
 	
 	private function resize($name,$filename,$new_w,$new_h,$center=false){
		if(substr($name,0,6)=='/cache') $name=substr($name,1);
		$current_size = getimagesize($name);

		$old_x=$current_size[0];
		$old_y=$current_size[1];
		if ($old_x > $old_y){
			$thumb_w=$new_w;
			$thumb_h=$old_y*($new_h/$old_x);
		}
		if ($old_x < $old_y){
			$thumb_w=$old_x*($new_w/$old_y);
			$thumb_h=$new_h;
		}
		if ($old_x == $old_y){
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		if(!$center){
			$make_magick = exec("convert -geometry $thumb_w x $thumb_h $name $filename", $retval);
		}else{
			$make_magick = exec("convert $name  -thumbnail ".$new_w."x".$new_h."^ -gravity center -extent ".$new_w."x".$new_h."  $filename", $retval);
		}

		return $retval;	 
	}
}


