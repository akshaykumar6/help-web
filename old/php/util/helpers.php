<?php
/**
 * Created on Jul 16, 2009
 *
 * @description Helpers php library helps you stay dry! This is the "no mod_rewrite" version.
 * @author Shrikant Sharat KANDULA
 * @file helpers.php
**/

/*
 * Sample DB file as Helpers expects it to be:
 * <?php
 * define('HOST_NAME', 'localhost');
 * define('USER_NAME', 'sharat');
 * define('PASSWORD', 'amul');
 * define('DB_NAME', 'finance_learning');
 * mysql_connect(HOST_NAME, USER_NAME, PASSWORD);
 * mysql_select_db(DB_NAME);
 * ?>
 */
require_once('db_config.php');

class Helpers {
	
	static $default_mode = 'xml';
	
	/**
	 * @param String query This is a string containing the SQL query.
	 * @return array with cleaned/escaped request parameters
	 */
	static function checkParams($params, $REQ) {
		$request = array();
		foreach($params as $p) {
			if(!isset($REQ[$p]))
				Helpers::errKill(1, "$p is not set", false);
			$request[$p] = mysql_real_escape_string($REQ[$p]);
		}
		return $request;
	}
	
	/**
	 * @param String query This is a string containing the SQL query.
	 * @return String xml in a string containing the result from the query
	 */
	static function get_xml($query, $escape_chars=true) {
	
		$result = mysql_query($query) or Helpers::errKill(2, "Error executing query");
		mysql_num_rows($result) or Helpers::errKill(3, "Zero row response");
		
		$cols = array();
		while ($col = mysql_fetch_field($result)) {
			$cols[] = $col->name;
		}
		
		$column_count = sizeof($cols);

		$response = '<response success="1">';
		while ($row = mysql_fetch_array($result)) {
			if (in_array('id', $cols)) {
				$response .= '<item id="' . $row['id'] . '">';
			} else {
				$response .= "<item>";
			}
			
			for ($i = 0; $i < $column_count; $i++) {
				$colName = $cols[$i];
				if($colName != 'id') {
					$response .= "<$colName>" . ($escape_chars ? htmlentities($row[$i]) : $row[$i]) . "</$colName>";
				}
			}
			$response .= "</item>";
		}
		$response .= "</response>";
		return $response;
	}
	
	/**
	 * Convenient function to show the xml output of the query and exit
	 * @param String query This is a string containing the SQL query.
	 */
	static function show_xml($query, $escape_chars=true) {
		$response = Helpers::get_xml($query, $escape_chars);
		header("Content-type: text/xml");
		echo $response;
	}
	
	/**
	 * @param String query This is a string containing the SQL query.
	 * @return json encoded text of the result from the query
	 */
	static function get_json($query) {
		$result = mysql_query($query) or Helpers::errKill(2, "Error executing query");
		mysql_num_rows($result) or Helpers::errKill(3, "Zero row response");
		
		$response = array(); 
		
		$response['success'] = true;
		$response['data'] = array();
		while($row = mysql_fetch_assoc($result)) {
			$response['data'][] = $row;
		}
		return json_encode($response);
	}
	
	/**
	 * Convenient function to print json encoded text of the result from the query
	 * @param String query This is a string containing the SQL query.
	 */
	static function show_json($query) {
		$response = Helpers::get_json($query);
		header("Content-type: application/json");
		echo $response;
	}
	
	static function errKill($errcode, $detail, $mysql=true, $mode=null) {
		if($mode == null) {
			$mode = self::$default_mode;
		}
		switch($mode) {
			case 'xml':
				header("Content-type: text/xml");
				die("<response success=\"0\"><error code=\"$errcode\">"
					. "<detail>$detail</detail>"
					. ($mysql ? "<mysql>" . mysql_error() . "</mysql>" : "")
					. "</error></response>");
			case 'json':
				header("Content-type: application/json");
				$resp = array(
					'success' => false,
					'error' => array(
						'code' => $errcode,
						'detail' => $detail
					)
				);
				if($mysql) {
					$resp['mysql'] = mysql_error();
				}
				die(json_encode($resp));
			default:
				die("Failure: code $errcode<br/>$detail" . ($mysql ? "<br/>MySQL message: " . mysql_error() : ""));
		}
	}
	
	static function emptyResponse($success=1, $mode=null) {
		if($mode == null) {
			$mode = self::$default_mode;
		}
		$response = '';
		switch($mode) {
			case 'xml':
				$response = '<response success="' . $success . '"></response>';
				break;
			case 'json':
				$response = json_encode(array('success' => ($success == 1 ? true : "$success")));
				break;
		}
		return $response;
	}
	
}

?>
