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
		user_goto('mail_accounts.php');
	}
}

check_email_user($sql);

if (isset($_GET['id']) && $_GET['id'] !== '') {
	$mail_id = $_GET['id'];
	$item_change_status = Config::get('ITEM_CHANGE_STATUS');

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
	user_goto('mail_accounts.php');

} else {
	user_goto('mail_accounts.php');
}
