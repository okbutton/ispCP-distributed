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

$query = "
  SELECT
    `support_system`
  FROM
    `reseller_props`
  WHERE
    `reseller_id` = ?
";

$rs = exec_query($sql, $query, array($_SESSION['user_id']));

if (!Config::getInstance()->get('ISPCP_SUPPORT_SYSTEM') || $rs->fields['support_system'] == 'no') {
	user_goto('index.php');
}

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::getInstance()->get('RESELLER_TEMPLATE_PATH') . '/ticket_view.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('tickets_list', 'page');
$tpl->define_dynamic('tickets_item', 'tickets_list');

// page functions.

function gen_tickets_list(&$tpl, &$sql, &$ticket_id, &$screenwidth) {
	$user_id = $_SESSION['user_id'];
	$query = "
		SELECT
			`ticket_id`,
			`ticket_status`,
			`ticket_reply`,
			`ticket_urgency`,
			`ticket_date`,
			`ticket_subject`,
			`ticket_message`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
		AND
			(`ticket_from` = ? OR `ticket_to` = ?)
	";

	$rs = exec_query($sql, $query, array($ticket_id, $user_id, $user_id));

	if ($rs->RecordCount() == 0) {
		$tpl->assign('TICKETS_LIST', '');

		set_page_message(tr('Ticket not found!'));
	} else {
		$ticket_urgency = $rs->fields['ticket_urgency'];
		$ticket_status = $rs->fields['ticket_status'];

		if ($ticket_status == 0) {
			$tr_action = tr("Open ticket");
			$action = "open";
		} else {
			$tr_action = tr("Close ticket");
			$action = "close";
		}

		get_ticket_from($tpl, $sql, $ticket_id);
		$date_formt = Config::getInstance()->get('DATE_FORMAT');
		$ticket_content = wordwrap($rs->fields['ticket_message'], round(($screenwidth-200) / 7), "\n");

		$tpl->assign(
			array(
				'TR_ACTION' => $tr_action,
				'ACTION' => $action,
				'URGENCY' => get_ticket_urgency($ticket_urgency),
				'URGENCY_ID' => $ticket_urgency,
				'DATE' => date($date_formt, $rs->fields['ticket_date']),
				'SUBJECT' => htmlspecialchars($rs->fields['ticket_subject']),
				'TICKET_CONTENT' => nl2br(htmlspecialchars($ticket_content)),
				'ID' => $rs->fields['ticket_id']
			)
		);

		$tpl->parse('TICKETS_ITEM', '.tickets_item');
		get_tickets_replys($tpl, $sql, $ticket_id, $screenwidth);
	}
}

function get_tickets_replys(&$tpl, &$sql, &$ticket_id, &$screenwidth) {
	$query = "
		SELECT
			`ticket_id`,
			`ticket_status`,
			`ticket_reply`,
			`ticket_urgency`,
			`ticket_date`,
			`ticket_message`
		FROM
			`tickets`
		WHERE
			`ticket_reply` = ?
		ORDER BY
			`ticket_date` ASC
	";

	$rs = exec_query($sql, $query, array($ticket_id));

	if ($rs->RecordCount() == 0) {
		return;
	}

	while (!$rs->EOF) {
		$ticket_id = $rs->fields['ticket_id'];
		$ticket_date = $rs->fields['ticket_date'];
		$ticket_message = $rs->fields['ticket_message'];

		$date_formt = Config::getInstance()->get('DATE_FORMAT');
		$ticket_content = wordwrap($ticket_message, round(($screenwidth-200) / 7), "\n");

		$tpl->assign(
			array(
				'DATE' => date($date_formt, $ticket_date),
				'TICKET_CONTENT' => nl2br(htmlspecialchars($ticket_content))
			)
		);
		get_ticket_from($tpl, $sql, $ticket_id);
		$tpl->parse('TICKETS_ITEM', '.tickets_item');
		$rs->MoveNext();
	}
}

function get_ticket_from(&$tpl, &$sql, &$ticket_id) {
	$query = "
		SELECT
			`ticket_from`,
			`ticket_to`,
			`ticket_status`,
			`ticket_reply`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_id));
	$ticket_from = $rs->fields['ticket_from'];
	$ticket_to = $rs->fields['ticket_to'];
	$ticket_status = $rs->fields['ticket_status'];
	$ticket_reply = clean_html($rs->fields['ticket_reply']);

	$query = "
		SELECT
			`admin_name`,
			`admin_type`,
			`fname`,
			`lname`
		FROM
			`admin`
		WHERE
			`admin_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_from));
	$from_user_name = decode_idna($rs->fields['admin_name']);
	$admin_type = $rs->fields['admin_type'];
	$from_first_name = $rs->fields['fname'];
	$from_last_name = $rs->fields['lname'];

	$from_name = $from_first_name . " " . $from_last_name . " (" . $from_user_name . ")";

	$tpl->assign(
		array('FROM' => $from_name)
	);
}

// common page data.

$theme_color = Config::getInstance()->get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_CLIENT_VIEW_TICKET_PAGE_TITLE' => tr('ispCP - Reseller: Support System: View Ticket'),
		'THEME_COLOR_PATH' => "../themes/$theme_color",
		'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id'])
	)
);

function send_user_message(&$sql, $user_id, $reseller_id, $ticket_id, &$screenwidth) {
	if (!isset($_POST['uaction'])) {
		return;
	} elseif (empty($_POST['user_message'])) { // no message check->error
		if (($_POST['uaction'] != "open") && ($_POST['uaction'] != "close")) {
			set_page_message(tr('Please type your message!'));
			return;
		}
	}

	$ticket_date = time();
	$subject = clean_input($_POST['subject']);
	$user_message = clean_input($_POST["user_message"]);
	$ticket_status = 2;
	$ticket_reply = $_GET['ticket_id'];

	$query = "
		SELECT
			`ticket_level`,
			`ticket_from`,
			`ticket_to`,
			`ticket_status`,
			`ticket_reply`,
			`ticket_urgency`,
			`ticket_date`,
			`ticket_subject`,
			`ticket_message`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_reply));

	$ticket_level = $rs->fields['ticket_level'];

	if ($ticket_level != 1) {
		$ticket_to = $rs->fields['ticket_from'];
		$ticket_from = $rs->fields['ticket_to'];
	} else {
		$ticket_to = $rs->fields['ticket_to'];
		$ticket_from = $rs->fields['ticket_from'];
	}

	$urgency = $_POST['urgency'];

	$query = "
		INSERT INTO `tickets`
			(`ticket_from`,
			`ticket_to`,
			`ticket_status`,
			`ticket_reply`,
			`ticket_urgency`,
			`ticket_date`,
			`ticket_subject`,
			`ticket_message`)
		VALUES
			(?, ?, ?, ?, ?, ?, ?, ?)
	";

	$rs = exec_query($sql, $query, array($ticket_to, $ticket_from,
			$ticket_status, $ticket_reply, $urgency, $ticket_date,
			$subject, $user_message
			));

	// close ticket
	if ($_POST['uaction'] == "close") {
		close_ticket($sql, $ticket_id);
	} elseif ($_POST['uaction'] == "open") { // open ticket
		open_ticket($sql, $ticket_id);
	}

	set_page_message(tr('Message was sent.'));

	if ($_POST['uaction'] == "close") {
		if ($user_message != '') {
			$user_message .= "\n\n";
		}
		$user_message .= tr("Ticket was closed!");
	} elseif ($_POST['uaction'] == "open") {
		if ($user_message != '') {
			$user_message .= "\n\n";
		}
		$user_message .= tr("Ticket was reopened!");
	}

	send_tickets_msg($ticket_from, $ticket_to, $subject, $user_message, $ticket_reply, $urgency);
}

function get_send_to_who(&$sql, &$ticket_reply) {
	$query = "
		SELECT
			`ticket_from`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_reply));
	$ticket_from = $rs->fields['ticket_from'];

	$query = "
		SELECT
			`admin_type`
		FROM
			`admin`
		WHERE
			`admin_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_from));
	$admin_type = $rs->fields['admin_type'];
}

function close_ticket($sql, $ticket_id) {
	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = '0'
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_id));

	set_page_message(tr('Ticket was closed!'));
}

function open_ticket($sql, $ticket_id) {
	$query = "
		SELECT
			`ticket_level`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_id));

	global $ticket_level;

	$ticket_level = $rs->fields['ticket_level'];
	$ticket_status = 3;

	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = ?
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_status, $ticket_id));

	set_page_message(tr('Ticket was reopened!'));
}

function change_ticket_status_view($sql, $ticket_id) {
	$query = "
		SELECT
			`ticket_level`,
			`ticket_status`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_id));
	$ticket_level = $rs->fields['ticket_level'];
	$ticket_status = $rs->fields['ticket_status'];

	if ($ticket_status == 0) return;

	$ticket_status = 3;
	// Did the reseller write an answer?
	if (isset($_POST['uaction'])
		&& $_POST['uaction'] != "open"
		&& $_POST['uaction'] != "close") {
		if ($ticket_level != 2) {
			// if ticket to user
			$ticket_status = 2;
		} else {
			// if ticket to admin
			$ticket_status = 5;
		}
	} else {
		$ticket_status = 3;
	}

	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = ?
		WHERE
			`ticket_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_status, $ticket_id));
}

// dynamic page data.

$reseller_id = $_SESSION['user_created_by'];

if (isset($_GET['ticket_id'])) {
	if (isset($_GET['screenwidth'])) {
		$screenwidth = $_GET['screenwidth'];
	} else {
		$screenwidth = $_POST['screenwidth'];
	}

	if (!isset($screenwidth) || $screenwidth < 639) {
		$screenwidth = 1024;
	}
	$tpl->assign('SCREENWIDTH', $screenwidth);

	change_ticket_status_view($sql, $_GET['ticket_id']);

	send_user_message($sql, $_SESSION['user_id'], $reseller_id, $_GET['ticket_id'], $screenwidth);

	gen_tickets_list($tpl, $sql, $_GET['ticket_id'], $screenwidth);
} else {
	set_page_message(tr('Ticket not found!'));

	user_goto('ticket_system.php');
}

// static page messages.

gen_reseller_mainmenu($tpl, Config::getInstance()->get('RESELLER_TEMPLATE_PATH') . '/main_menu_ticket_system.tpl');
gen_reseller_menu($tpl, Config::getInstance()->get('RESELLER_TEMPLATE_PATH') . '/menu_ticket_system.tpl');

gen_logged_from($tpl);

$tpl->assign(
	array('TR_VIEW_SUPPORT_TICKET' => tr('View support ticket'),
		'TR_TICKET_URGENCY' => tr('Priority'),
		'TR_TICKET_SUBJECT' => tr('Subject'),
		'TR_TICKET_DATE' => tr('Date'),
		'TR_DELETE' => tr('Delete'),
		'TR_NEW_TICKET_REPLY' => tr('Send message reply'),
		'TR_REPLY' => tr('Send reply'),
		'TR_TICKET_FROM' => tr('From'),
		'TR_OPEN_TICKETS' => tr('Open tickets'),
		'TR_CLOSED_TICKETS' => tr('Closed tickets'),
	)
);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::getInstance()->get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
