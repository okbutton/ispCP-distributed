<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2008 by ispCP | http://isp-control.net
 * @version 	SVN: $Id$
 * @link 		http://isp-control.net
 * @author 		ispCP Team
 *
 * @license
 *   This program is free software; you can redistribute it and/or modify it under
 *   the terms of the MPL General Public License as published by the Free Software
 *   Foundation; either version 1.1 of the License, or (at your option) any later
 *   version.
 *   You should have received a copy of the MPL Mozilla Public License along with
 *   this program; if not, write to the Open Source Initiative (OSI)
 *   http://opensource.org | osi@opensource.org
 */

require '../include/ispcp-lib.php';

check_login(__FILE__);

// page functions.
function get_db_user_passwd(&$sql, $db_user_id) {
	$query = "
		SELECT
			`sqlu_name`, `sqlu_pass`
		FROM
			`sql_user`
		WHERE
			`sqlu_id` = ?
	";

	$rs = exec_query($sql, $query, $db_user_id);

	$user_mysql = $rs -> fields['sqlu_name'];
	$pass_mysql = decrypt_db_password($rs -> fields['sqlu_pass']);

	$data="pma_username=".urlencode($user_mysql)."&pma_password=".urlencode($pass_mysql)."\r\n\r\n";

	$out  = "POST /pma/ HTTP/1.1\r\n";
	$out .= "Host: ".Config::get('BASE_SERVER_VHOST')."\r\n";
	$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$out .= "Content-length: ".strlen($data)."\r\n";
	$out .= "Connection: Close\r\n\r\n";

	$rs='';

	$fp = fsockopen(Config::get('BASE_SERVER_VHOST'), 80, $errno, $errstr, 5);
	if (!$fp) {
		error();
	} else {
		fwrite($fp, $out);
		fwrite($fp, $data);
		$header=null;
		while (!feof($fp)) {
			$line = fgets($fp, 2048);
			$rs.=$line;
			if(preg_match("/^Location.+/",$line,$results)) $header=$line;
		}
		fclose($fp);
		preg_match_all("/(?:Set-Cookie: )(?:(?U)(.+)=(.+)(?:;))(?:(?U)( expires=)(.+)(?:;))?(?:( path=)(.+))?/",$rs,$results,PREG_SET_ORDER);
		foreach($results as $result){
			setcookie(urldecode($result[1]),urldecode($result[2]),strtotime(urldecode($result[4])),urldecode($result[6]));
		}
		if($header){
			header($header);
			die();
		} else {
			error();
		}
	}
}

function error(){
	set_page_message("Error while authenticating!!!");
	header("Location: sql_manage.php");
	die();
}

// check User sql permision
if (isset($_SESSION['sql_support']) && $_SESSION['sql_support'] == "no") {
	header("Location: index.php");
	exit;
}

if (isset($_GET['id'])) {
	$db_user_id = $_GET['id'];
} else {
	user_goto('sql_manage.php');
}

check_usr_sql_perms($sql, $db_user_id);
get_db_user_passwd($sql, $db_user_id);

?>
