<?php
if(PHP_OS=='Linux'){
	define ( "OBABLE_PATH", "/usr/bin/obabel" );
	define ( 'OPENBABLE_PATH',"/usr/bin/" );
}elseif(PHP_OS=='WINNT'){
	define ( "OBABLE_PATH", "C:\OpenBabel-2.4.1\obabel" );
	define ( 'OPENBABLE_PATH',"C:\OpenBabel-2.4.1" );
}else{
	
}
// /usr/local/bin/obabel
//C:\OpenBabel-2.4.1\obabel
function p($data, $flag = false) {
	echo "<pre>";
	var_export ( $data );
	echo "</pre>";
	if (! $flag) {
		exit ();
	}
}


/**
 * @desc  im:十进制数转换成三十六机制数
 * @param (int)$num 十进制数
 * return 返回：三十六进制数
 */
function _10to36($num) {
	$num = intval($num);
	if ($num <= 0)
		return false;
		$charArr = array("0","1","2","3","4","5","6","7","8","9",'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
		$char = '';
		do {
			$key = $num % 36;
			$char= $charArr[$key] . $char;
			$num = floor(($num - $key) / 36);
		} while ($num > 0);
		return $char;
}

/**
 * @desc  im:三十六进制数转换成十机制数
 * @param (string)$char 三十六进制数
 * return 返回：十进制数
 */
function _36to10($char){
	$array=array("0","1","2","3","4","5","6","7","8","9","A", "B", "C", "D","E", "F", "G", "H", "I", "J", "K", "L","M", "N", "O","P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y","Z");
	$len=strlen($char);
	$sum = 0;
	for($i=0;$i<$len;$i++){
		$index=array_search($char[$i],$array);
		$sum+=($index)*pow(36,$len-1-$i);
	}
	return $sum;
} 

function _10toLetter($number){
	$charArr = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	if($number<=26){
		return $charArr[$number-1];
	}
	
	if ($number % 26 === 0){
		
		$first = floor($number / 26) - 1;
		
		$second = 26;
	}
	else{
		
		$first = floor($number / 26);
		
		$second = $number % 26;
	}
	
	return $charArr[$first-1].$charArr[$second-1];
}


function convert($size) {
	$unit = array (
			'b',
			'kb',
			'mb',
			'gb',
			'tb',
			'pb' 
	);
	return @round ( $size / pow ( 1024, ($i = floor ( log ( $size, 1024 ) )) ), 2 ) . ' ' . $unit [$i];
}
function getNIHGOVUrl($keyword, $type = "smiles") {
	$types = [ 
			"stdinchikey",
			"stdinchi",
			"smiles",
			"ficts",
			"ficus",
			"uuuuu",
			"hashisy",
			"sdf",
			"names",
			"iupac_name",
			"cas",
			"chemspider_id",
			"image",
			"twirl",
			"mw",
			"formula",
			"h_bond_donor_count",
			"h_bond_acceptor_count",
			"h_bond_center_count",
			"rule_of_5_violation_count",
			"rotor_count",
			"effective_rotor_count",
			"ring_count",
			"ringsys_count" 
	];
	if (! in_array ( $type, $types )) {
		return "";
	}
	if (! $keyword) {
		return "";
	}
	$url = "https://cactus.nci.nih.gov/chemical/structure/{$keyword}/{$type}";
	return $url;
}
// iupac_name
function getIUPACNAMEByNIH($keyword, $ip = "127.0.0.1", $port = 80) {
	$requestUrl = getNIHGOVUrl ( $keyword, 'iupac_name' );
	return getCurlContent ( $requestUrl, $ip, $port );
}
function getSMILESByNIH($keyword, $ip = "127.0.0.1", $port = 80) {
	$requestUrl = getNIHGOVUrl ( $keyword );
	return getCurlContent ( $requestUrl, $ip, $port );
}
function getCurlContent($requestUrl, $ip = "127.0.0.1", $port = 80, $timeout = 50, $cookie = "") {
	$valid = preg_match ( '/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\z/', $ip );
	if (! $valid) {
		return false;
	}
	if (! is_integer ( $port )) {
		return false;
	}
	$ch = curl_init ();
	$header = [ ];
	$ip_long = array (
			array (
					'607649792',
					'608174079' 
			), // 36.56.0.0-36.63.255.255
			array (
					'1038614528',
					'1039007743' 
			), // 61.232.0.0-61.237.255.255
			array (
					'1783627776',
					'1784676351' 
			), // 106.80.0.0-106.95.255.255
			array (
					'2035023872',
					'2035154943' 
			), // 121.76.0.0-121.77.255.255
			array (
					'2078801920',
					'2079064063' 
			), // 123.232.0.0-123.235.255.255
			array (
					'-1950089216',
					'-1948778497' 
			), // 139.196.0.0-139.215.255.255
			array (
					'-1425539072',
					'-1425014785' 
			), // 171.8.0.0-171.15.255.255
			array (
					'-1236271104',
					'-1235419137' 
			), // 182.80.0.0-182.92.255.255
			array (
					'-770113536',
					'-768606209' 
			), // 210.25.0.0-210.47.255.255
			array (
					'-569376768',
					'-564133889' 
			) 
	) // 222.16.0.0-222.95.255.255
;
	// $rand_key = mt_rand(0, 9);
	// $tmpIp= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
	// $header = array("CLIENT-IP:{$ip1}','X-FORWARDED-FOR:{$tmpIp}",);
	
	curl_setopt ( $ch, CURLOPT_URL, $requestUrl );
	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $ch, CURLOPT_HEADER, false );
	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
	curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
	
	if (substr ( $requestUrl, 0, 5 ) == 'https') {
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false ); // 信任任何证书
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, false ); // 不检测域名
	}
	
	if ($ip != "127.0.0.1") {
		curl_setopt ( $ch, CURLOPT_PROXY, $ip ); // 代理服务器地址
		                                      // curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
		curl_setopt ( $ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5 );
		curl_setopt ( $ch, CURLOPT_PROXYPORT, $port ); // 代理服务器端口
		curl_setopt ( $ch, CURLOPT_PROXYUSERPWD, "hfagent1:As54HWWddfty" ); // http代理认证帐号，username:password的格式
	}
	
	if ($cookie) {
		curl_setopt ( $ch, CURLOPT_COOKIE, $cookie );
	}
	curl_setopt ( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36" );
	
	$content = curl_exec ( $ch );
	// file_put_contents('1111.txt', var_export($content,1));
	curl_close ( $ch );
	return $content;
}
function filterZhStr($str) {
	preg_match ( '/[\x{4e00}-\x{9fa5}]/u', $str, $matches );
	// preg_match('/[\x80-\xff]{2,32}/', $str, $matches);
	return isset ( $matches [0] ) ? true : false;
}
function filterPercent($cas) {
	$reg = "/\d+\.?\d+(-|\+)?%(-|\+)?/";
	preg_match ( $reg, $cas, $match );
	if (isset ( $match [0] ) && $match [0]) {
		return $match [0];
	}
	return '';
}

function filterMDL($mdl){
	$reg = "/MFCD\d*(.*)/";
	preg_match ( $reg, $mdl, $match );
	if((isset($match[0])&&$match[1])||!isset($match[0])){
		return '';
	}
	return $match[0];
}
function filterCAS($cas) {
$reg = "/^[1-9]\d*-\d\d-\d$/";
	preg_match ( $reg, $cas, $match );
	if (isset ( $match [0] ) && $match [0]) {
		$casArray = explode ( "-", $match [0] );
		
// 		if (count ( $casArray ) != 3) {
// 			return '';
// 		}
		
// 		if (! is_numeric ( $casArray [0] ) || ! is_numeric ( $casArray [1] )) {
// 			return '';
// 		}
		
		$str = $casArray [0] . $casArray [1];
		
		$total = 0;
		$j = 1;
		for($i = strlen ( $str ) - 1; $i >= 0; $i --) {
			$total += $str [$i] * $j;
			$j ++;
		}
		
		if ($total % 10 === intval ( $casArray [2] )) {
			return $match [0];
		}
	}
	return '';
}
function microtime_float() {
	list ( $usec, $sec ) = explode ( " ", microtime () );
	return (( float ) $usec + ( float ) $sec); // 微秒加秒
}
function trimnbsp($string) // 删除空格
{
	$string = trim ( trim ( $string, "&nbsp;" ), ' ' );
	return $string;
}

/**
 * 数组数据合并
 *
 * @param array $a        	
 * @param array $b        	
 */
function merge($a, $b) {
	$args = func_get_args ();
	$res = array_shift ( $args );
	while ( ! empty ( $args ) ) {
		$next = array_shift ( $args );
		foreach ( $next as $k => $v ) {
			if (is_int ( $k )) {
				if (isset ( $res [$k] )) {
					$res [] = $v;
				} else {
					$res [$k] = $v;
				}
			} elseif (is_array ( $v ) && isset ( $res [$k] ) && is_array ( $res [$k] )) {
				$res [$k] = merge ( $res [$k], $v );
			} else {
				$res [$k] = $v;
			}
		}
	}
	return $res;
}
function getSMILESByName($name, $ip = "127.0.0.1", $port = 5678) {
	$socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
	$connect = socket_connect ( $socket, $ip, $port );
	if (! $socket || ! $connect) {
		return "";
	}
	// 向服务端发送数据
	socket_write ( $socket, $name . "\n" );
	// 接受服务端返回数据
	$string = socket_read ( $socket, 1024, PHP_NORMAL_READ );
	
	socket_close ( $socket );
	
	if (trim ( $string ) === "null") {
		$string = "";
	}
	return $string;
}
function getSMILESByNames($names, $ip = "127.0.0.1", $port = 5678) {
	$socket = socket_create ( AF_INET, SOCK_STREAM, SOL_TCP );
	$connect = socket_connect ( $socket, $ip, $port );
	if (! $socket || ! $connect) {
		return false;
	}
	$results = [ ];
	foreach ( $names as $name ) {
		// 向服务端发送数据
		socket_write ( $socket, $name . "\n" );
		// 接受服务端返回数据
		$string = socket_read ( $socket, 1024, PHP_NORMAL_READ );
		if (trim ( $string ) === "null") {
			$string = "";
		}
		$results [$name] = $string;
	}
	socket_close ( $socket );
	return $results;
}
function getMoleculeInfoBySMILES($smiles) {
	// /usr/local/bin/obabel -:'S([O-])(O)(=O)=O.C[N+](C)(C)C' -oreport
	$report = [ ];
	$result = [ 
			'formula' => '',
			'mass' => '',
			'exactMass' => '' 
	];
	exec ( OBABLE_PATH . " -:'$smiles' -oreport", $report );
	if (isset ( $report [0] ) && $report [0] === 'FILENAME:') {
		$tmp = explode ( ":", $report [1] );
		$result ['formula'] = trim ( $tmp [1], ' ' );
		$tmp = explode ( ":", $report [2] );
		$result ['mass'] = trim ( $tmp [1], ' ' );
		$tmp = explode ( ":", $report [3] );
		$result ['exactMass'] = trim ( $tmp [1], ' ' );
	}
	return $result;
}

/**
 * 将非GBK字符集的编码转为GBK
 *
 * @param mixed $mixed
 *        	源数据
 *        	
 * @return mixed GBK格式数据
 */
function charsetToGBK($mixed) {
	if (is_array ( $mixed )) {
		foreach ( $mixed as $k => $v ) {
			if (is_array ( $v )) {
				$mixed [$k] = charsetToGBK ( $v );
			} else {
				$encode = mb_detect_encoding ( $v, array (
						'ASCII',
						'UTF-8',
						'GB2312',
						'GBK',
						'BIG5' 
				) );
				if ($encode == 'UTF-8') {
					$mixed [$k] = iconv ( 'UTF-8', 'GBK', $v );
				}
			}
		}
	} else {
		$encode = mb_detect_encoding ( $mixed, array (
				'ASCII',
				'UTF-8',
				'GB2312',
				'GBK',
				'BIG5' 
		) );
		// var_dump($encode);
		if ($encode == 'UTF-8') {
			$mixed = iconv ( 'UTF-8', 'GBK', $mixed );
		}
	}
	return $mixed;
}

/**
 * 将非UTF-8字符集的编码转为UTF-8
 *
 * @param mixed $mixed
 *        	源数据
 *        	
 * @return mixed utf-8格式数据
 */
function charsetToUTF8($mixed) {
	if (is_array ( $mixed )) {
		foreach ( $mixed as $k => $v ) {
			if (is_array ( $v )) {
				$mixed [$k] = charsetToUTF8 ( $v );
			} else {
				$encode = mb_detect_encoding ( $v, array (
						'ASCII',
						'UTF-8',
						'GB2312',
						'GBK',
						'BIG5' 
				) );
				if ($encode == 'EUC-CN') {
					$mixed [$k] = iconv ( 'GBK', 'UTF-8', $v );
				}
			}
		}
	} else {
		$encode = mb_detect_encoding ( $mixed, array (
				'ASCII',
				'UTF-8',
				'GB2312',
				'GBK',
				'BIG5' 
		) );
		if ($encode == 'EUC-CN') {
			$mixed = iconv ( 'GBK', 'UTF-8', $mixed );
		}
	}
	return $mixed;
}
function readExcel($file, $rowStart = 1, $position = 'Z') {
	$reader = PHPExcel_IOFactory::createReader ( 'Excel2007' ); // 读取 excel 文件方式 此方法是读取excel2007之前的版本 excel2007 为读取2007以后的版本 也可以查Classes\PHPExcel\Reader 文件夹中的类（为所有读取类，需要哪个填上哪个就行）
	$resource = $file;
	if (! file_exists ( $resource )) {
		exit ( "$resource is not exists.\n" );
	}
	$PHPExcel = $reader->load ( $file ); // 文件名称
	$sheet = $PHPExcel->getSheet ( 0 ); // 读取第一个工作表从0读起
	$highestRow = $sheet->getHighestRow (); // 取得总行数
	$highestColumn = $sheet->getHighestColumn (); // 取得总列数t8.php
	                                             // 根据自己的数据表的大小修改
	                                             
	// echo $highestRow;exit;
	$arr = array (
			0 => 'a',
			1 => 'A',
			2 => 'B',
			3 => 'C',
			4 => 'D',
			5 => 'E',
			6 => 'F',
			7 => 'G',
			8 => 'H',
			9 => 'I',
			10 => 'J',
			11 => 'K',
			12 => 'L',
			13 => 'M',
			14 => 'N',
			15 => 'O',
			16 => 'P',
			17 => 'Q',
			18 => 'R',
			19 => 'S',
			20 => 'T',
			21 => 'U',
			22 => 'V',
			23 => 'W',
			24 => 'X',
			25 => 'Y',
			26 => 'Z',
			27 => 'AA',
			28 => 'AB',
			29 => 'AC',
			30 => 'AD',
			31 => 'AE',
			32 => 'AF',
			33 => 'AG',
			34 => 'AH',
			35 => 'AI',
			36 => 'AJ',
			37 => 'AK',
			38 => 'AL',
			39 => 'AM' 
	);
	// 每次读取一行，再在行中循环每列的数值
	for($row = $rowStart; $row <= $highestRow; $row ++) {
		for($column = 0; $arr [$column] != strtoupper ( $position ); $column ++) {
			$val = $sheet->getCellByColumnAndRow ( $column, $row )->getValue (); // getFormattedValue();//getValue();
			if ((is_numeric ( $val )) && (strpos ( $val, '.' ))) {
				$val = rtrim ( rtrim ( number_format ( $val, 12, '.', '' ), '0' ), '.' ); // number_format($val,12,',','');//rtrim(rtrim(number_format($val,12,',',''),'0'),',');
			}
			$list [$row] [] = ( string ) $val; // @iconv('gbk', 'utf-8', $val);
		}
	}
	return $list;
}
function getSDFSMILES($filename) {
	$commond = OBABLE_PATH . " -isdf \"{$filename}\" -osmi  -t";
	exec ( $commond, $report );
	//p($report);
	return $report;
}
function getSDFBaseinfo($filename) {
	$datas = [ ];
	$property = [ ];
	$handle = fopen ( $filename, 'r' );
	while ( ! feof ( $handle ) ) {
		$tmp = trim ( fgets ( $handle, 1024 ) );
		if (strstr ( $tmp, "<" ) && strstr ( $tmp, ">" )) {
			$key = trim ( substr ( $tmp, strpos ( $tmp, "<" ) + 1, strripos ( $tmp, ">" ) - strlen ( $tmp ) ) );
			
			$str = trim ( fgets ( $handle, 1024 ) );
			$encode = mb_detect_encoding ( $str, array (
					'ASCII',
					'UTF-8',
					'GB2312',
					'GBK',
					'BIG5',
					'LATIN1',
					'ISO-8859-1' 
			) );
			
			if ($encode != 'UTF-8') {
				$string = mb_convert_encoding ( $str, 'UTF-8', $encode );
			}
			$property [$key] = $str;
		}
		if (strstr ( $tmp, "$$$$" )) {
			$datas [] = $property;
			$property = [ ];
		}
	}
	fclose ( $handle );
	return $datas;
}
function getSDFInfo($filename) {
	if (! file_exists ( $filename )) {
		return false;
	}
	$filename = realpath ( $filename );
	$datas = getSDFBaseinfo ( $filename );
	$SMILESs = getSDFSMILES ( $filename );
	foreach ( $datas as $k => &$data ) {
		 $data ['SMILES'] = $SMILESs [$k];
		// $datas[$k]['SMILES'] = $SMILESs[$k];
	}
	return $datas;
}


function tanimoto($D_SMILES,$SMILES){
	//obabel -:"Oc1ccccc1C(=O)O " -:"Oc1ccccc1C(=O)O" -ofpt
	$commond = OBABLE_PATH . " -:\"{$SMILES}\" -:\"$D_SMILES\" -ofpt";
	echo $commond;
	exec ( $commond, $report );
	if(!$report){
		return false;
	}
	if(isset($report[1])&&$report[1]){
		$data = explode("=", $report[1]);
		if(isset($data[1])){
			return floatval($data[1]);
		}
	}
	return false;
}

/*
 *生成图片
 */
function smilesToIMG($SMILES,$filename,$type='.png'){
    $commond = OBABLE_PATH . " -:\"{$SMILES}\" -O ".$filename.$type;
    // echo $commond;die();
    exec ( $commond, $report );
    $commond = OBABLE_PATH . " -:\"{$SMILES}\" -O ".$filename.".svg";
    // echo $commond;die();
    exec ( $commond, $report );
    return  true;
}


function SMILEStoCan($smiles){
    $commond = OBABLE_PATH . " -:\"$smiles\" -ocan";
    //echo $commond;
    exec($commond, $report);
    return isset($report[0])&&$report[0]?$report[0]:"";
}