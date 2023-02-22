<?php
// полинейный textoutput
$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json; charset=utf-8');

$file_name = "txt\\".date("Ymd_His").".txt";
$counter = 0; 
function textoutput($header,$key, $value) {
	global $counter;
	global $file_name;
//	if ($counter>100) return;
	if ( is_array($value) ) {
		/*
1``User`HQ/test
2``Scenario`Sc1:202104:202104
3``Version`Ver1
4``Result`Успешно
5``Data`202104`700810`Result`Успешно
		*/
		foreach ($value as $key2 => $value2) { 
			textoutput ($header.'`'.$key,$key2,$value2);
		}
	}
	else {		
		$counter+=1;
		$str = $counter.'. '.$header.'`'.$key.'`'.$value.PHP_EOL;
		echo $str;
		file_put_contents( $file_name ,	$str , FILE_APPEND );
	}
}

switch ($method) {
    case 'POST':
        $json = file_get_contents('php://input');
        $arr = json_decode($json, true);
		foreach ($arr as $key => $value) { 
			textoutput ("main",$key,$value);
		}
}