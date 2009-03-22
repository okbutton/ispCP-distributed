<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright	2001-2006 by moleSoftware GmbH
 * @copyright	2006-2009 by ispCP | http://isp-control.net
 * @version		SVN: $Id$
 * @link		http://isp-control.net
 * @author		ispCP Team
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

$theme_color = Config::get('USER_INITIAL_THEME');

if (isset($_GET['id'])) {
	$usid = $_GET['id'];
} else {
	$_SESSION['user_deleted'] = '_no_';
	header("Location: users.php");
	die();
}

$reseller_id = $_SESSION['user_id'];

$query = <<<SQL_QUERY
	SELECT
		domain_id
	FROM
		domain
	WHERE
		domain_admin_id = ?
	AND
		domain_created_id = ?
SQL_QUERY;
$res = exec_query($sql, $query, array($usid, $reseller_id));

if ($res->RowCount() !== 1) {
	header("Location: users.php");
	die();
} else {
	// delete the user
	rm_rf_user_account ($usid);
	check_for_lock_file();
	send_request();
	set_page_message(tr('User terminated!'));
	header("Location: users.php");
	die();
}

?>