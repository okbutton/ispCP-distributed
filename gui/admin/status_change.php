<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2010 by ispCP | http://isp-control.net
 * @version 	SVN: $Id$
 * @link 		http://isp-control.net
 * @author 		ispCP Team
 *
 * @license
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 *
 * The Original Code is "VHCS - Virtual Hosting Control System".
 *
 * The Initial Developer of the Original Code is moleSoftware GmbH.
 * Portions created by Initial Developer are Copyright (C) 2001-2006
 * by moleSoftware GmbH. All Rights Reserved.
 * Portions created by the ispCP Team are Copyright (C) 2006-2010 by
 * isp Control Panel. All Rights Reserved.
 */

require '../include/ispcp-lib.php';

check_login(__FILE__);


if (!isset($_GET['domain_id'])) {
	user_goto('manage_users.php');
}

if (!is_numeric($_GET['domain_id'])) {
	user_goto('manage_users.php');
}

// so we have domain id and let's disable or enable it
$domain_id = $_GET['domain_id'];

// check status to know if have to disable or enable it
$query = <<<SQL_QUERY
	SELECT
		`domain_name`,
		`domain_status`
	FROM
		`domain`
	WHERE
		`domain_id` = ?
SQL_QUERY;

$rs = exec_query($sql, $query, array($domain_id));

$location = 'admin';

if ($rs->fields['domain_status'] == Config::get('ITEM_OK_STATUS')) {

		//disable_domain($sql, $domain_id, $rs->fields['domain_name']);
		$action = 'disable';
		change_domain_status(&$sql, $domain_id, $rs->fields['domain_name'], $action, $location);

} else if ($rs->fields['domain_status'] == Config::get('ITEM_DISABLED_STATUS')) {

	//enable_domain($sql, $domain_id, $rs->fields['domain_name']);
	$action = 'enable';
	change_domain_status(&$sql, $domain_id, $rs->fields['domain_name'], $action, $location);

} else {
	user_goto('manage_users.php');
}
