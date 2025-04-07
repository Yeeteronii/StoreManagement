<?php

//define('DS',DIRECTORY_SEPARATOR);
const DS = DIRECTORY_SEPARATOR;


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
		
		//$bt_funcnames = c_extract($bt, "{n}.function");
		$bt_filenames = c_extract($bt, "{n}.file");
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
	if(is_array($a)||is_object($a)){@reset($a);}

	
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

//Internal function used by cdebug()
function _cdebug_buffer_dump($var, $split_scalar = false){
    ob_start();
    var_dump($var);
    $a=ob_get_contents();
    ob_end_clean();


    //if scalar value, split return value into array: $a[0] = type, $a[1] = value
    if($split_scalar){
        if(is_scalar($var)){
            if(is_string($var)){
                $cutoff = strpos($a,')') + 1;
                //$c = explode(')',$a);
                //$c[0] .= ')';
                //$c[1] = substr($c[1],0,-1);
                $c[0] = substr($a,0,$cutoff);
                $c[1] = substr($a,$cutoff);
            } else {
                $c = explode('(',$a);
                $c[1] = substr($c[1],0,-2);
            }
            $a = $c;
        } else if(is_null($var)){
            $c[1] = $a;
            return $c;
        }
    }

    return $a;
}




function c_extract($path, $data = null, $options = array()) {
    if (is_string($data)) {
        $tmp = $data;
        $data = $path;
        $path = $tmp;
    }
    if (strpos($path, '/') === false) {
        return c_classicExtract($data, $path);
    }
    if (empty($data)) {
        return array();
    }
    if ($path === '/') {
        return $data;
    }
    $contexts = $data;
    $options += array('flatten' => true);
    if (!isset($contexts[0])) {
        $current = current($data);
        if ((is_array($current) && count($data) < 1) || !is_array($current) || !Set::numeric(array_keys($data))) {
            $contexts = array($data);
        }
    }
    $tokens = array_slice(preg_split('/(?<!=|\\\\)\/(?![a-z-\s]*\])/', $path), 1);

    do {
        $token = array_shift($tokens);
        $conditions = false;
        if (preg_match_all('/\[([^=]+=\/[^\/]+\/|[^\]]+)\]/', $token, $m)) {
            $conditions = $m[1];
            $token = substr($token, 0, strpos($token, '['));
        }
        $matches = array();
        foreach ($contexts as $key => $context) {
            if (!isset($context['trace'])) {
                $context = array('trace' => array(null), 'item' => $context, 'key' => $key);
            }
            if ($token === '..') {
                if (count($context['trace']) === 1) {
                    $context['trace'][] = $context['key'];
                }
                $parent = implode('/', $context['trace']) . '/.';
                $context['item'] = c_extract($parent, $data);
                $context['key'] = array_pop($context['trace']);
                if (isset($context['trace'][1]) && $context['trace'][1] > 0) {
                    $context['item'] = $context['item'][0];
                } elseif (!empty($context['item'][$key])) {
                    $context['item'] = $context['item'][$key];
                } else {
                    $context['item'] = array_shift($context['item']);
                }
                $matches[] = $context;
                continue;
            }
            if ($token === '@*' && is_array($context['item'])) {
                $matches[] = array(
                    'trace' => array_merge($context['trace'], (array)$key),
                    'key' => $key,
                    'item' => array_keys($context['item']),
                );
            } elseif (is_array($context['item'])
                && array_key_exists($token, $context['item'])
                && !(strval($key) === strval($token) && count($tokens) === 1 && $tokens[0] === '.')) {
                $items = $context['item'][$token];
                if (!is_array($items)) {
                    $items = array($items);
                } elseif (!isset($items[0])) {
                    $current = current($items);
                    $currentKey = key($items);
                    if (!is_array($current) || (is_array($current) && count($items) <= 1 && !is_numeric($currentKey))) {
                        $items = array($items);
                    }
                }

                foreach ($items as $key => $item) {
                    $ctext = array($context['key']);
                    if (!is_numeric($key)) {
                        $ctext[] = $token;
                        $tok = array_shift($tokens);
                        if (isset($items[$tok])) {
                            $ctext[] = $tok;
                            $item = $items[$tok];
                            $matches[] = array(
                                'trace' => array_merge($context['trace'], $ctext),
                                'key' => $tok,
                                'item' => $item,
                            );
                            break;
                        } elseif ($tok !== null) {
                            array_unshift($tokens, $tok);
                        }
                    } else {
                        $key = $token;
                    }

                    $matches[] = array(
                        'trace' => array_merge($context['trace'], $ctext),
                        'key' => $key,
                        'item' => $item,
                    );
                }
            } elseif ($key === $token || (ctype_digit($token) && $key == $token) || $token === '.') {
                $context['trace'][] = $key;
                $matches[] = array(
                    'trace' => $context['trace'],
                    'key' => $key,
                    'item' => $context['item'],
                );
            }
        }
        if ($conditions) {
            foreach ($conditions as $condition) {
                $filtered = array();
                $length = count($matches);
                foreach ($matches as $i => $match) {
                    if (Set::matches(array($condition), $match['item'], $i + 1, $length)) {
                        $filtered[$i] = $match;
                    }
                }
                $matches = $filtered;
            }
        }
        $contexts = $matches;

        if (empty($tokens)) {
            break;
        }
    } while (1);

    $r = array();

    foreach ($matches as $match) {
        if ((!$options['flatten'] || is_array($match['item'])) && !is_int($match['key'])) {
            $r[] = array($match['key'] => $match['item']);
        } else {
            $r[] = $match['item'];
        }
    }
    return $r;
}

function c_classicExtract($data, $path = null) {
    if (empty($path)) {
        return $data;
    }
    if (is_object($data)) {
        if (!($data instanceof ArrayAccess || $data instanceof Traversable)) {
            $data = get_object_vars($data);
        }
    }
    if (empty($data)) {
        return null;
    }
    if (is_string($path) && strpos($path, '{') !== false) {
        $path = c_tokenize($path, '.', '{', '}');
    } elseif (is_string($path)) {
        $path = explode('.', $path);
    }
    $tmp = array();

    if (empty($path)) {
        return null;
    }

    foreach ($path as $i => $key) {
        if (is_numeric($key) && (int)$key > 0 || $key === '0') {
            if (isset($data[$key])) {
                $data = $data[$key];
            } else {
                return null;
            }
        } elseif ($key === '{n}') {
            foreach ($data as $j => $val) {
                if (is_int($j)) {
                    $tmpPath = array_slice($path, $i + 1);
                    if (empty($tmpPath)) {
                        $tmp[] = $val;
                    } else {
                        $tmp[] = c_classicExtract($val, $tmpPath);
                    }
                }
            }
            return $tmp;
        } elseif ($key === '{s}') {
            foreach ($data as $j => $val) {
                if (is_string($j)) {
                    $tmpPath = array_slice($path, $i + 1);
                    if (empty($tmpPath)) {
                        $tmp[] = $val;
                    } else {
                        $tmp[] = c_classicExtract($val, $tmpPath);
                    }
                }
            }
            return $tmp;
        } elseif (strpos($key, '{') !== false && strpos($key, '}') !== false) {
            $pattern = substr($key, 1, -1);

            foreach ($data as $j => $val) {
                if (preg_match('/^' . $pattern . '/s', $j) !== 0) {
                    $tmpPath = array_slice($path, $i + 1);
                    if (empty($tmpPath)) {
                        $tmp[$j] = $val;
                    } else {
                        $tmp[$j] = c_classicExtract($val, $tmpPath);
                    }
                }
            }
            return $tmp;
        } else {
            if (isset($data[$key])) {
                $data = $data[$key];
            } else {
                return null;
            }
        }
    }
    return $data;
}



function c_tokenize($data, $separator = ',', $leftBound = '(', $rightBound = ')') {
    if (empty($data)) {
        return array();
    }

    $depth = 0;
    $offset = 0;
    $buffer = '';
    $results = array();
    $length = mb_strlen($data);
    $open = false;

    while ($offset <= $length) {
        $tmpOffset = -1;
        $offsets = array(
            mb_strpos($data, $separator, $offset),
            mb_strpos($data, $leftBound, $offset),
            mb_strpos($data, $rightBound, $offset)
        );
        for ($i = 0; $i < 3; $i++) {
            if ($offsets[$i] !== false && ($offsets[$i] < $tmpOffset || $tmpOffset == -1)) {
                $tmpOffset = $offsets[$i];
            }
        }
        if ($tmpOffset !== -1) {
            $buffer .= mb_substr($data, $offset, ($tmpOffset - $offset));
            $char = mb_substr($data, $tmpOffset, 1);
            if (!$depth && $char === $separator) {
                $results[] = $buffer;
                $buffer = '';
            } else {
                $buffer .= $char;
            }
            if ($leftBound !== $rightBound) {
                if ($char === $leftBound) {
                    $depth++;
                }
                if ($char === $rightBound) {
                    $depth--;
                }
            } else {
                if ($char === $leftBound) {
                    if (!$open) {
                        $depth++;
                        $open = true;
                    } else {
                        $depth--;
                    }
                }
            }
            $offset = ++$tmpOffset;
        } else {
            $results[] = $buffer . mb_substr($data, $offset);
            $offset = $length + 1;
        }
    }
    if (empty($results) && !empty($buffer)) {
        $results[] = $buffer;
    }

    if (!empty($results)) {
        return array_map('trim', $results);
    }

    return array();
}
