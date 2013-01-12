<?

function json_encode_ex($value){
	if(!isset($GLOBALS['JSON_OBJECT'])){
		include_once('json.php');
		$GLOBALS['JSON_OBJECT'] = new Services_JSON(SERVICES_JSON_IN_ARR);
	}
	return $GLOBALS['JSON_OBJECT']->encode($value); 
}

function json_decode_ex($value){
	//for php>=5.2
	if(function_exists('json_decode'))
		return json_decode($value,true);
	//else (although this fails...);
	if(!isset($GLOBALS['JSON_OBJECT'])){
		include_once('json.php');
		$GLOBALS['JSON_OBJECT'] = new Services_JSON(SERVICES_JSON_IN_ARR);
	}
	return $GLOBALS['JSON_OBJECT']->decode($value); 
}

//convert a loaded tree into a flat array with the addresses as the keys instead of just names
function flatten_tree($data,$removeChildren=false){
	$output=array();
	foreach($data as $id=>$item){
		if(isset($item['node:children']) && count($item['node:children'])){
			$children=flatten_tree($item['node:children']);
			$output=$output+$children;
		}
		if($removeChildren===true) unset($item['node:children']);
		if(!isset($output[$item['node:address']])) $output[$item['node:address']]=$item;
	}
	return $output;
}

if (!function_exists('array_replace'))
{
  function array_replace( array &$array, array &$array1 )
  {
    $args = func_get_args();
    $count = func_num_args();

    for ($i = 0; $i < $count; ++$i) {
      if (is_array($args[$i])) {
        foreach ($args[$i] as $key => $val) {
          $array[$key] = $val;
        }
      }
      else {
        trigger_error(
          __FUNCTION__ . '(): Argument #' . ($i+1) . ' is not an array',
          E_USER_WARNING
        );
        return NULL;
      }
    }

    return $array;
  }
}

function random_string($length = 10) {
    $characters = 'abcdefghijklmnopqrstuvwxyz';
    $string = "";    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters)-1)];
    }
    return $string;
}

function var_not_null($var){return $var!==null;}

function pull_item($item=array()){
	if(!is_array($item) || count($item)!==1) return false;
	$item=array_values($item);
    return $item[0];
}

function make_comparer() {
    $criteriaNames = func_get_args();
    $comparer = function($first, $second) use ($criteriaNames) {
        // Do we have anything to compare?
        while(!empty($criteriaNames)) {
            // What will we compare now?
            $criterion = array_shift($criteriaNames);

            // Do the actual comparison
            if ($first[$criterion] < $second[$criterion]) {
                return -1;
            }
            else if ($first[$criterion] > $second[$criterion]) {
                return 1;
            }

        }

        // Nothing more to compare with, so $first == $second
        return 0;
    };

    return $comparer;
}

function organize_by_attrib($key,$data){
	$out=array();
	foreach($data as $name=>$val){
		if(isset($val[$key])){
			if(!isset($out[$val[$key]])) $out[$val[$key]]=array();
			$out[$val[$key]][$name]=$val;
		}
	}
	return $out;
}

//$fitler=array('key to look in'=>'required value')
//$data=array('itemname'=>array('attrib key'=>'attrib value'))
//$invert=default:false return items that match the filter, true to return items that dont
function filter_by_attrib($filter=array(),$data=array(),$invert=false){
	$out=array();
	foreach($data as $name=>$item){
		$go=true;
		foreach($filter as $key=>$val){
			if(!isset($item[$key]) || $item[$key]!==$val){
				$go=false;
				break;
			}
		}
		if($go!==$invert) $out[$name]=$item;
	}
	return $out;
}

/**
 * replcae quotes to HTML entities by names or numbers
 *
 * @param (string) escaped string value
 * @param (string) default ='number' will be return to number entities you can use ='name' to return name entities
 * Note : don't use ='name' coz (&apos;) (does not work in IE)
 */
function quote2entities($string,$entities_type='number')
{
    $search                     = array("\"","'");
    $replace_by_entities_name   = array("&quot;","&apos;");
    $replace_by_entities_number = array("&#34;","&#39;");
    $do = null;
    if ($entities_type == 'number')
    {
        $do = str_replace($search,$replace_by_entities_number,$string);
    }
    else if ($entities_type == 'name')
    {
        $do = str_replace($search,$replace_by_entities_name,$string);
    }
    else
    {
        $do = addslashes($string);
    }
    return $do;
}


