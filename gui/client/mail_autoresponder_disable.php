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

function check_email_user(&$sql) {
	$dmn_name = $_SESSION['user_logged'];
	$mail_id = $_GET['id'];

	$query = "
		SELECT
			t1.*,
			t2.domain_id,
			t2.domain_name
		FROM
			mail_users AS t1,
			domain AS t2
		WHERE
			t1.mail_id = ?
		AND
			t2.domain_id = t1.domain_id
		AND
			t2.domain_name = ?
";

	$rs = exec_query($sql, $query, array($mail_id, $dmn_name));
	$mail_acc = $rs->fields['mail_acc'];

	if ($rs->RecordCount() == 0) {
		set_page_message(tr('User does not exist or you do not have permission to access this interface!'));
		header('Location: mail_accounts.php');
		die();
	}
}

check_email_user($sql);

if (isset($_GET['id']) && $_GET['id'] !== '') {
	$mail_id = $_GET['id'];
	$item_change_status = Config::get('ITEM_CHANGE_STATUS');
	check_for_lock_file();

	$query = "
		UPDATE
			mail_users
		SET
			status = ?,
			mail_auto_respond = 0
		WHERE
			mail_id = ?
	";

	$rs = exec_query($sql, $query, array($item_change_status, $mail_id));

	send_request();
	$query = "
		SELECT
			`mail_type`,
			IF(`mail_type` like 'normal_%',t2.`domain_name`,
				IF(`mail_type` like 'alias_%',t3.`alias_name`,
					IF(`mail_type` like 'subdom_%', CONCAT(t4.`subdomain_name`,'.',t6.`domain_name`), CONCAT(t5.`subdomain_alias_name`,'.',t7.`alias_name`))
				)
			) AS mailbox
		FROM
			`mail_users` AS t1
		left join (domain AS t2) ON (t1.domain_id = t2.domain_id)
		left join (domain_aliasses AS t3) ON (sub_id = alias_id)
		left join (subdomain AS t4) ON (sub_id = subdomain_id)
		left join (subdomain_alias AS t5) ON (sub_id = subdomain_alias_id)
		left join (domain AS t6) ON (t4.domain_id = t6.domain_id)
		left join (domain_aliasses AS t7) ON (t5.alias_id = t7.alias_id)
		WHERE
			`mail_id` = ?
	";

	$rs = exec_query($sql, $query, array($mail_id));
	$mail_name = $rs->fields['mailbox'];
	write_log($_SESSION['user_logged'].": disabled mail autoresponder: ".$mail_name);
	set_page_message(tr('Mail account scheduled for modification!'));
	header('Location: mail_accounts.php');
	exit(0);
}
else {
	header('Location: mail_accounts.php');
	exit(0);
}

?>
