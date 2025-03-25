<?php

//----------------------------------------------------------------------------
// cDEBUG() - display var contents
//----------------------------------------------------------------------------
// to show all vars in current scope : cdebug(get_defined_vars())
function cdebug($a, $title='', $colorchange=1, $renderhtml = false, $show_bool = true, $max_depth = false) {
	//_respondas_html();	//break out of xml/json mode
	
	global $cdebug_called;
	$cdebug_called = true;
	
	static $max_depth2;
	if(!$max_depth && !$max_depth2){
		$max_depth2 = 10;
	} else if($max_depth > 0){
		$max_depth2 = $max_depth;
	}
	
	static $depth;
	$depth++;
	if($depth > $max_depth2){echo '<font size="-2"><b><i>[TOODEEP]</i></b></font>'; $depth--; return;}
	
	
	//set bg color
	static $color=-1;
	if($colorchange){
		++$color;
	}
	$color = ($color > 8 ? 0 : $color);
	$c = array('66CCFF','CCDDFF','FFFFAA','00FF44','FFC0C0','EEFF00','DDAAEE','87D008', 'E58D8D');
	
	$light_color = $c[$color];
	
	$isObject = (is_object($a) ? '<i>[OBJECT]</i>' : '');
	$bt_out = '';
	
		
	if(!empty($title)){
		
		$title = "<b>$title</b> $isObject<br style='clear:both;'/>";
		
		//find calling file and line number	
		$bt = debug_backtrace(false);		//****** after upgrading to PHP 5.36+, add options to debug_backtrace() to limit output
		//echo Debugger::trace(array('format' => 'js', 'args'=>false, 'start'=>1) );
		
		//$bt_funcnames = Set::extract($bt, "{n}.function");
		$bt_filenames = Set::extract($bt, "{n}.file");
		//skip internal cdebug functions
		foreach($bt_filenames as $i  => $filename){
			//if(substr($funcname, 0, 6) == 'cdebug' || $funcname == 'call_user_func_array'){
			if(substr($filename, -10) == 'cdebug.php' || $filename ==''){
				continue;
			}
			break;
		}
		//print_r($bt_filenames);
		//print_r($bt_funcnames);
		//print_r($i);
		//print_r($funcname);
		//
		
		$bt_filename = $bt[$i]['file'];
		$_bt_arr = explode('\\', $bt_filename);
		$bt_filename_short = array_pop($_bt_arr);
		$bt_filename_short = "<div style='font-size:11px'><b>$bt_filename_short</b></div>";
		//split path into 4 lines
		$fn_chunks = explode(DS,$bt_filename);
//		var_dump($fn_chunks); exit;
		$fn_0 =  implode(DS,array_slice($fn_chunks, 0, -1)).DS;
		$fn_1 =  implode(DS,array_slice($fn_chunks, -1 ));
//		$fn_1 =  implode(DS,array_slice($fn_chunks, 5,-1)).DS;
		
		//$bt_filename = substr($bt_filename,0,$fn_len_half).'<br>'.substr($bt_filename,$fn_len_half);
		
		
		$bt_out = "<div style='font-family:Tahoma;font-size:11px;float:right;text-align:right;background-color:#$light_color;padding:5px;border-radius: 5px;'>$fn_0 <b>$fn_1</b>  {$bt[$i]['line']}</div>";
	}

	//prevent array pointer weirdness
	if(is_array($a)||is_object($a)){reset($a);}	

	
	$common_div_style = "padding:10px;margin-bottom:10px; background:#$c[$color]; color:black;font-family:Verdana;font-size:14px; overflow:auto;border-radius: 10px;";
	
	
	//show string,numeric,bool,null ------------------
	if(!is_array($a) && !is_object($a)) {
		//if(is_bool($a) || is_null($a)){
			//$b = '<i>'.var_export($a,true).'</i>';
		//} else {
			$a1 = _cdebug_buffer_dump($a,true);
			
			if(!$renderhtml){
				$a1[1] = htmlspecialchars($a1[1],ENT_QUOTES);
			}
			//var_dump($a1[1]);exit;
			
			//wordwrap?
			if(!$renderhtml){
				$a3 = wordwrap($a1[1],200,"<br>",true);
			} else {
				$a3 = $a1[1];
			}
			$a4 = (isset($a1[0]) ? $a1[0] : '');
												
			$b = "<i><b>$a4</b></i><br>".$a3;
			
			
		//}
		echo"<div style='$common_div_style'>$bt_out $title<br> $b</div>";
		$depth--;
		return;
	}


	//show ARRAY or OBJECT ------------------
	echo "<div style='$common_div_style'>$bt_out $title";
	echo "<ul>\n";	
	
		if(empty($a) && $depth==1){print_r($a);} //show 'empty' instead of nothing
		foreach($a as $key => $val){
//		while(list($key, $val) = @each($a)) {
			$italic_val = false;
			if(is_array($val) || is_object($val)) {
				$o = (is_object($val) ? '<b><i>[OBJECT]</i></b>' : '');
				echo "<LI>$key $o</LI>\n";
				cdebug($val,'',0, $renderhtml, $show_bool);
				//$depth--;
			} else {
				if($show_bool){
					if(is_string($val)){
						$val = print_r($val,true);	//print_r to avoid escaping apostrophes
					} else {
						$italic_val = (is_bool($val) || is_null($val) ? true : false );
						$val = var_export($val,true);	//var_export to show bool/null
					}
				} else {
					$val = print_r($val,true); //show bool/null as blank (easier to read)
				}
				
				
				if(!$renderhtml){
					//NO HTML RENDERING -- prevent values containing '<' from being rendered by browser
					$val = htmlspecialchars($val,ENT_QUOTES);
				}
/*					
					if(is_string($val)){
						echo '<LI>'.$key.' = ['.print_r($val,true).']</LI>'."\n";
					} else {
						echo '<LI>'.$key.' = ['.var_export($val,true).']</LI>'."\n";
					}
				} else {
					//NO HTML RENDERING -- prevent values containing '<' being rendered by browser
					echo '<LI>'.$key.' = ['.htmlspecialchars(var_export($val,true),ENT_QUOTES).']</LI>'."\n";
				}
*/

				$val = ( $italic_val ? '<i>'.$val.'</i>' : $val);
				echo '<LI>'.$key.' = ['.$val.']</LI>'."\n";
				
			}
			
		}

	echo "</ul>\n";

	echo "</div>";
	$depth--;
	//ob_end_flush(); 
} 
