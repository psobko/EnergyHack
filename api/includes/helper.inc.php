<?php
class helper
{
	/*----------------------------- CHECK PARAMS -----------------------------*/
	/**
	 * 
	 * @param String $format: eg. "Y-m-d H:i:s" default sql datetime format
	 * @param String $datetime: eg. "2012-02-28"
	 */
	public static function checkDateTimeFormat($datetime = "", $format = "Y-m-d H:i:s")
	{
		$res = false;
		if ( $strdt = strtotime(trim($datetime)) ) {
			$res = (date($format, $strdt) == $datetime) ? true : false;
		}
		return $res;
	}
	 
	public static function checkEmail($email) {
		
		return (false === filter_var($email, FILTER_VALIDATE_EMAIL)) ? false : true;
	}
	
	/*----------------------- ENCODING TRANSFORMATIONS -----------------------*/
	
	public static $default_charset = 'utf-8';
	private static $default_incoming_charset = 'iso-8859-1';
	private static $encoding_list = array('ucs-4', 'ucs-4be', 'ucs-4le', 'ucs-2', 'ucs-2be', 'ucs-2le', 'utf-32', 'utf-32be', 'utf-32le', 'utf-16', 'utf-16be', 'utf-16le', 'utf-7', 'utf7-imap', 'utf-8', 'ascii', 'euc-jp', 'sjis', 'eucjp-win', 'sjis-win', 'iso-2022-jp', 'iso-2022-jp-ms', 'cp932', 'cp51932', 'sjis-mac', 'sjis-mobile#docomo', 'sjis-mobile#kddi', 'sjis-mobile#softbank', 'utf-8-mobile#docomo', 'utf-8-mobile#kddi-a', 'utf-8-mobile#kddi-b', 'utf-8-mobile#softbank', 'iso-2022-jp-mobile#kddi', 'jis', 'jis-ms', 'cp50220', 'cp50220raw', 'cp50221', 'cp50222', 'iso-8859-1', 'iso-8859-2', 'iso-8859-3', 'iso-8859-4', 'iso-8859-5', 'iso-8859-6', 'iso-8859-7', 'iso-8859-8', 'iso-8859-9', 'iso-8859-10', 'iso-8859-13', 'iso-8859-14', 'iso-8859-15', 'byte2be', 'byte2le', 'byte4be', 'byte4le', 'base64', 'html-entities', '7bit', '8bit', 'euc-cn', 'cp936', 'gb18030', 'hz', 'euc-tw', 'cp950', 'big-5', 'euc-kr', 'uhc', 'cp949', 'iso-2022-kr', 'windows-1251', 'cp1251', 'windows-1252', 'cp1252', 'cp866', 'ibm866', 'koi8-r', 'macintosh', 'tis-620');
	private static $common_translation_list = array(
			'' => 'utf-8',
			'utf-8;' => 'utf-8',
			'big5' => 'big-5', // chinese
			'gb2312' => 'euc-cn', // chinese
			'shift_jis' => 'sjis', // japanese
			'shift-jis' => 'sjis', // japanese
			'x-sjis' => 'sjis', // japanese
			'windows-1250' => 'windows-1252', // eastern european
			'windows-1256' => 'utf-8', // arabic
			'windows-1254' => 'utf-8', // turkish
			'us-ascii' => 'ascii',
			'x-user-defined' => 'utf-8',
			'ms949' => 'euc-kr', // korean
			'gbk' => 'euc-cn', // chinese
			'utf8' => 'utf-8',
			'iso_8859-1' => 'iso-8859-1',
			'iso-8859-1;' => 'iso-8859-1',
			'iso-8859-1}' => 'iso-8859-1',
			'iso8859_1' => 'iso-8859-1',
			'iso8859-1' => 'iso-8859-1',
			'windows-1255' => 'iso-8859-8',
			'windows-31J' => 'utf-8',
			'windows-874' => 'tis-620',
			'windows-1253' => 'utf-8' //greek
	);

	public static function getEncoding($encoding){
		$encoding = strtolower(trim($encoding));
		if(!in_array($encoding, self::$encoding_list)) {
			if(array_key_exists($encoding, self::$common_translation_list)) {
				$encoding = self::$common_translation_list[$encoding];
			} else {
				$encoding = self::$default_incoming_charset;
			}
		}
		return $encoding;
	}
	public static function convertEncoding($string, $encoding) {
		$result = $string;
	
		if($encoding == 'macintosh') {
			$result = iconv($encoding, self::$default_charset, $string);
		}
		elseif($encoding == 'tis-620') {
			$result = iconv($encoding, self::$default_charset, $string);
// 			$result = self::tis620_to_utf8($string);
		}
		else {
			$result = mb_convert_encoding($string, self::$default_charset, $encoding);
		}
	
		return $result;
	}

	/**
	 * Replace any invalid character for utf-8 encoding from a utf-8 string by a question mark.
	 * This ensures your utf-8 string not to contain any invalid character.
	 * 
	 * @param String $body
	 * @return String Same string containing replaced characters.
	 */
	public static function clean_utf8_encoding($body){
		$body = preg_replace('/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
				'|(?<=^|[\x00-\x7F])[\x80-\xBF]+'.
				'|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
				'|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
				'|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/',
				'�', $body );
	
		$body = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
				'|\xED[\xA0-\xBF][\x80-\xBF]/S','?', $body );
	
		return $body;
	}

// 	private static function tis620_to_utf8($in) {
// 		$out = "";
// 		for ($i = 0; $i < strlen($in); $i++) {
// 			if (ord($in[$i]))
// 				$out .= $in[$i];
// 			else
// 				$out .= "&#" . (ord($in[$i]) - 161 + 3585) . ";";
// 		}
// 		return $out;
// 	}
	
	/*-------------------------- CHECK NUMBER RANGES -------------------------*/
	
	public static function checkTinyIntRange($number = 0, $unsigned = false) {
		if ($unsigned)
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>0, 'max_range'=>255)));
			return ($number >= 0 && $number <= 255) ? true : false;
		else
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>-128, 'max_range'=>127)));
			return ($number >= -128 && $number <= 127) ? true : false; 
	}
	
	public static function checkSmallIntRange($number = 0, $unsigned = false) {
		if ($unsigned)
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>0, 'max_range'=>65535)));
			return ($number >= 0 && $number <= 65535) ? true : false;
		else
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>-32768, 'max_range'=>32767)));
			return ($number >= -32768 && $number <= 32767) ? true : false;
	}
	
	public static function checkMediumIntRange($number = 0, $unsigned = false) {
		if ($unsigned)
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>0, 'max_range'=>16777215)));
			return ($number >= 0 && $number <= 16777215) ? true : false;
		else
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>-8388608, 'max_range'=>8388607)));
			return ($number >= -8388608 && $number <= 8388607) ? true : false;
	}
	
	public static function checkIntRange($number = 0, $unsigned = false){
		if ($unsigned)
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>0, 'max_range'=>4294967295)));
			return ($number >= 0 && $number <= 4294967295) ? true : false;
		else
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>-2147483648, 'max_range'=>2147483647)));
			return ($number >= -2147483648 && $number <= 2147483647) ? true : false;
	} 
	
	public static function checkBigIntRange($number = 0, $unsigned = false){
		if ($unsigned)
// 			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>0, 'max_range'=>18446744073709551615)));
			return ($number >= 0 && $number <= 18446744073709551615) ? true : false;
		else
			return filter_var($number, FILTER_VALIDATE_INT, array('options' => array('min_range'=>-9223372036854775808, 'max_range'=>9223372036854775807)));
// 			return ($number >= -9223372036854775808 && $number <= 9223372036854775807) ? true : false;
	}
	
	public static function validURL ($url)
	{
		return filter_var($url, FILTER_VALIDATE_URL);
// 		$urlregex = "^(https?|ftp)\:\/\/([a-z0-9+!*(),;?&=\$_.-]+(\:[a-z0-9+!*(),;?&=\$_.-]+)?@)?[a-z0-9+\$_-]+(\.[a-z0-9+\$_-]+)*(\:[0-9]{2,5})?(\/([a-z0-9+\$_-]\.?)+)*\/?(\?[a-z+&\$_.-][a-z0-9;:@/&%=+\$_.-]*)?(#[a-z_.-][a-z0-9+\$_.-]*)?\$";
// 		return (eregi($urlregex, $url)) ? true : false;
	}
	
	/*----------------------------- CODE SNIPPETS ----------------------------*/
	
	public static function createOptionList($arr = array(), $id = 0, $choose_message = true, $custom_message = '')
	{
		$list = '';
		if ($choose_message) {
			$list = "<option value='0'>";
			$list .= (!empty($custom_message)) ? $custom_message : "Please Choose";
			$list .= "</option>\r\n";
		}
		foreach ($arr as $key => $value)
		{
			$list .= "<option value=\"$key\"";
	
			if ($key == $id) {
				$list .= " selected='selected'";
			}
			$list .= ">$value</option>\r\n";
		}
		return $list;
	}
	
	/*--------------------------- OUTPUT FORMATING ---------------------------*/
	
	public static function formatCurrency($amount = 0) {
		return '$' . trim(sprintf("%01.2f", $amount)); 
	}
	
	public static function formatNumber($number = 0, $decimals = 2) {
		$locale = localeconv();
		return number_format($number,$decimals, $locale['decimal_point'], $locale['thousands_sep']);
	}
	
	public static function formatDateReport($datetime) {
		$date = new DateTime($datetime);
		return $date->format('M d, Y');
	}

	/**
	 * Send Mail through redeem account
	 * @param String $subject
	 * @param String $from
	 * @param String $to
	 * @param String $cc
	 * @param String $bcc
	 * @param Array $headers: Customized headers. When not informed standard headers will be sent.
	 * @return boolean|PEAR_Error: True on success. PEAR_Error on failure.
	 */
	public static function mail($subject, $from, $to, $body, $cc = '', $bcc = '', $headers = array() ){
		$result = false;
	
		require_once 'Mail.php';
		require_once 'Mail/mime.php';
	
		$host = "ssl://smtp.gmail.com";
		$port = "465";
		$username = $from;
		$password = "Rt7ext225";
	
		if (empty($headers)) {
			$headers = array ();
			$headers['From'] = $from;
			$headers['To'] = $to;
			if (!empty($cc))
				$headers['CC'] =  $cc;
			if (!empty($bcc))
				$headers['BCC'] =  $bcc;
			$headers['Subject'] = $subject;
		}
	
		$smtp = Mail::factory('smtp', array (
				'host' => $host,
				'port' => $port,
				'auth' => true,
				'username' => $username,
				'password' => $password)
		);
	
		$message = new Mail_mime();
		$message->setTXTBody(str_replace("<br>", "\r\n", $body));
		$message->setHTMLBody($body);
		$mbody = $message->get();
		$mheaders = $message->headers($headers, true);
		$result = $smtp->send($to, $mheaders, $mbody);
	
		return ($result === TRUE) ? true : false;
	}
	
	/*-------------------------- MANAGE DATABASE RESULTSETS -------------------------*/
	
	/**
	 * Retrieve all the values for a specific column into an array
	 * @param Array<Array> $resultset: A set of rows from the DB. Tipically, result of fetchAll PDO function. 
	 * @param String $column: Name of the column to retrieve
	 * @return Array<Multiple>: Array with the contents of the column for each row in the resultset.   
	 */
	public static function extractColumn($resultset = array(), $column = "", $indexedBy = "") {
		$result = array();
		
		if (empty($indexedBy)) {
			foreach ($resultset as $row) {
				$result[] = $row[$column];
			}
		} else {
			foreach ($resultset as $row) {
				$result[$row[$indexedBy]] = $row[$column];
			}
		}
		
		return $result;
	}
	public static function extractColumns($resultset = array(), $columns = array(), $indexedBy = "") {
		
		$result = array();
		foreach($columns as $column)
			$result[$column] = array();
		
		if(empty($indexedBy)) {
			foreach($resultset as $row) {
				foreach($columns as $column)
					$result[$column][] = $row[$column];
			}
		} else {
			foreach($resultset as $row) {
				foreach($columns as $column)
					$result[$column][$row[$indexedBy]] = $row[$column];
			}
		}
		return $result;
	}
	
	/**
	 * Retrieve all the values for a specific column into an array
	 * @param Array<Array> $resultset: A set of rows from the DB. Tipically, result of fetchAll PDO function. 
	 * @param String $index: Name of the column you want to use as index
	 * @param boolean $keep: Keep the index column when true. Leave it only as index when false.
	 * @return Array<Multiple>: Array with the contents of the column for each row in the resultset.   
	 */
	public static function indexedResultset($resultset = array(), $index = "", $keep = true){
		$result = array();
		
		if(!empty($resultset)) {
			foreach($resultset as $row) {
				if ( !$keep ) {
					foreach($row as $key => $field) {
						if (!$keep && $key == $index)
							continue;
						$result[$row[$index]][$key] = $field; 
					}
				} else {
					$result[$row[$index]] = $row;
				}
			}
		}
		return $result;
	}
	
	/*--------------------------------- FILE UPLOADS --------------------------------*/
	
	function storeImage_old($file, $existingFileName) {
	
		if (empty($existingFileName)) {
			$scriptname = 'uploadimage.php';
			$fileimage = uniqid() . '.png';
		} else {
			$scriptname = 'replaceimage.php';
			$fileimage = explode('/',$existingFileName);
			$fileimage = $fileimage[count($fileimage)-1];
			if (file_exists(FILEDIR . $fileimage))
				unlink(FILEDIR . $fileimage);
		}
	
		$img = $file;
		$img = str_replace('data:image/png;base64,', '', $img);
		$img = str_replace(' ', '+', $img);
		$data = base64_decode($img);
		// 		$fileimage = uniqid() . '.png';
		file_put_contents(FILEDIR . $fileimage, $data);
			
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://static.qriket.com/'. $scriptname);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "");
		curl_setopt($ch, CURLOPT_POST, true);
		$post = array(
				"fileimage" => base64_encode(file_get_contents(FILEDIR . $fileimage)),
				"fileimagename" => $fileimage
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		curl_exec($ch);
	
		return IMAGESDIR . $fileimage;
	}
	
	function storeImage($fileStream, $existingFilename = "") {
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://static.qriket.com/uploadimagejson.php');
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_VERBOSE, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, "");
		curl_setopt($ch, CURLOPT_POST, true);
		$post = array(
				"image" => $fileStream,
				"filename" => $existingFilename,
				"overwrite" => false
		);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		$answer = json_decode(curl_exec($ch), true);
		
		$fileurl = ($answer['error'] || empty($answer['filename'])) ? $existingFilename : IMAGESDIR . $answer['filename'];
		
		return $fileurl;
	}
	
// 	function uploadImage($file, $existingFileName) {
	
// 		if (empty($existingFileName)) {
// 			$scriptname = 'uploadimage.php';
// 			$fileimage = uniqid();
// 		} else {
	
// 			$scriptname = 'replaceimage.php';
// 			$fileimage = explode('/',$existingFileName);
// 			$fileimage = $fileimage[count($fileimage)-1];
// 			if (file_exists(FILEDIR . $fileimage))
// 				unlink(FILEDIR . $fileimage);
// 		}
	
// 		if (move_uploaded_file($file, FILEDIR . $fileimage)) {
	
// 			$ch = curl_init();
// // 			curl_setopt($ch, CURLOPT_URL, 'http://qriket.dev/' . $scriptname);
// 			curl_setopt($ch, CURLOPT_URL, 'http://static.qriket.com/' . $scriptname);
// // 			curl_setopt($ch, CURLOPT_URL, 'http://static.qriket.com/uploadimage.php');
// 			curl_setopt($ch, CURLOPT_HEADER, 0);
// 			curl_setopt($ch, CURLOPT_VERBOSE, 0);
// 			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 			curl_setopt($ch, CURLOPT_USERAGENT, "");
// 			curl_setopt($ch, CURLOPT_POST, true);
// 			$post = array(
// 					"fileimage" => base64_encode(file_get_contents(FILEDIR . $fileimage)),
// 					"fileimagename" => $fileimage
// 			);
// 			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
// 			curl_exec($ch);
	
// 			$fileimage = IMAGESDIR . $fileimage;
// 		} else {
// 			$fileimage = '';
// 		}
	
// 		return $fileimage;
// 	}
	
	/*------------------------ SORT BIDIMINSIONAL RESULTSETS ------------------------*/
	
	// TODO: We need to figure out how to call a static compare function with parameters.
	// Without params: uasort($array, array("helper", "compare_function"));
	// How to add parameters???
// 	public static function build_sorter($field) {
// 		return function ($a, $b) use ($field) {
// 			if ($a[$field] == $b[$field]) {
//         		return 0;
// 	    	}
// 	    	return ($a[$field] < $b[$field]) ? -1 : 1;
// 		};
// 	}
}
?>