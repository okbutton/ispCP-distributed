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

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::get('CLIENT_TEMPLATE_PATH') . '/ticket_view.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('tickets_list', 'page');
$tpl->define_dynamic('tickets_item', 'tickets_list');

// page functions.

function gen_tickets_list(&$tpl, &$sql, &$ticket_id, $screenwidth) {
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

		if ($ticket_urgency == 1) {
			$tpl->assign(array('URGENCY' => tr("Low"),
					'URGENCY_ID' => '1'));
		} elseif ($ticket_urgency == 2) {
			$tpl->assign(array('URGENCY' => tr("Medium"),
					'URGENCY_ID' => '2'));
		} elseif ($ticket_urgency == 3) {
			$tpl->assign(array('URGENCY' => tr("High"),
					'URGENCY_ID' => '3'));
		} elseif ($ticket_urgency == 4) {
			$tpl->assign(array('URGENCY' => tr("Very high"),
					'URGENCY_ID' => '4'));
		}

		get_ticket_from($tpl, $sql, $ticket_id);
		$date_formt = Config::get('DATE_FORMAT');
		$ticket_content = wordwrap(html_entity_decode($rs->fields['ticket_message']), round(($screenwidth-200) / 7), "\n");

		$tpl->assign(
			array(
				'TR_ACTION' => $tr_action,
				'ACTION' => $action,
				'DATE' => date($date_formt, $rs->fields['ticket_date']),
				'SUBJECT' => stripslashes($rs->fields['ticket_subject']),
				'TICKET_CONTENT' => nl2br($ticket_content),
				'ID' => $rs->fields['ticket_id']
			)
		);

		$tpl->parse('TICKETS_ITEM', '.tickets_item');
		get_tickets_replys($tpl, $sql, $ticket_id, $screenwidth);
	}
}

function get_tickets_replys(&$tpl, &$sql, &$ticket_id, $screenwidth) {
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
		$ticket_subject = $rs->fields['ticket_subject'];
		$ticket_date = $rs->fields['ticket_date'];
		$ticket_message = clean_input($rs->fields['ticket_message']);
		$ticket_content = wordwrap(html_entity_decode($rs->fields['ticket_message']), round(($screenwidth-200) / 7), "\n");

		$date_formt = Config::get('DATE_FORMAT');
		$tpl->assign(
			array(
				'DATE' => date($date_formt, $rs->fields['ticket_date']),
				'TICKET_CONTENT' => nl2br($ticket_content)
			)
		);
		get_ticket_from($tpl, $sql, $ticket_id);
		$tpl->parse('TICKETS_ITEM', '.tickets_item');
		$rs->MoveNext();
	}
}

function get_ticket_from(&$tpl, &$sql, $ticket_id) {
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
		AND
			(`ticket_from` = ? OR `ticket_to` = ?)
	";

	$rs = exec_query($sql, $query, array($ticket_id, $_SESSION['user_id'], $_SESSION['user_id']));
	$ticket_from = $rs->fields['ticket_from'];
	$ticket_to = $rs->fields['ticket_to'];
	$ticket_status = $rs->fields['ticket_status'];
	$ticket_reply = clean_html($rs->fields['ticket_reply']);

	$query = "
		SELECT
			`admin_name`,
			`fname`,
			`lname`
		FROM
			`admin`
		WHERE
			`admin_id` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_from));
	$from_user_name = decode_idna($rs->fields['admin_name']);
	$from_first_name = $rs->fields['fname'];
	$from_last_name = $rs->fields['lname'];

	$from_name = $from_first_name . " " . $from_last_name . " (" . $from_user_name . ")";
	$tpl->assign(array('FROM' => $from_name));
}

// common page data.

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_CLIENT_VIEW_TICKET_PAGE_TITLE' => tr('ispCP - Client: Support System: View Ticket'),
		'THEME_COLOR_PATH' => "../themes/$theme_color",
		'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id'])
	)
);

function send_user_message(&$sql, $user_id, $reseller_id, $ticket_id) {
	if (!isset($_POST['uaction'])) return;
	// close ticket
	elseif ($_POST['uaction'] == "close") {
		close_ticket($sql, $ticket_id);
		return;
	} elseif ($_POST['uaction'] == "open") {
		// open ticket
		open_ticket($sql, $ticket_id);
		return;
	} elseif (empty($_POST['user_message'])) {
		// no message check->error
		set_page_message(tr('Please type your message!'));
		return;
	}

	$ticket_date = time();
	$subject = clean_input($_POST['subject'], true);
	$user_message = clean_input($_POST["user_message"], true);
	$ticket_status = 4;
	$ticket_reply = $_GET['ticket_id'];
	$urgency = $_POST['urgency'];
	$ticket_from = $user_id;
	$ticket_to = $reseller_id;

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

	$rs = exec_query($sql, $query, array($ticket_from, $ticket_to, $ticket_status,
			$ticket_reply, $urgency, $ticket_date, $subject, $user_message));

	// Update all Replays -> Status 1
	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = '1'
		WHERE
			`ticket_id` = ?
		OR
			`ticket_reply` = ?
	";

	$rs = exec_query($sql, $query, array($ticket_reply, $ticket_reply));

	while (!$rs->EOF) {
		$rs->MoveNext();
	}

	set_page_message(tr('Message was sent.'));
	send_tickets_msg($ticket_to, $ticket_from, html_entity_decode($subject, ENT_QUOTES, 'UTF-8'), html_entity_decode($user_message, ENT_QUOTES, 'UTF-8'), $ticket_reply);
}

function change_ticket_status($sql, $ticket_id) {
	$query = "
		SELECT
			`ticket_status`
		FROM
			`tickets`
		WHERE
			`ticket_id` = ?
		AND
			(`ticket_from` = ? OR `ticket_to` = ?)
	";

	$rs = exec_query($sql, $query, array($ticket_id, $_SESSION['user_id'], $_SESSION['user_id']));
	$ch_ticket_status = $rs->fields['ticket_status'];

	if ($ch_ticket_status == 0) {
		$ticket_status = 0;
	} else if (!isset($_POST['uaction']) || $_POST['uaction'] == "open") {
		$ticket_status = 3;
	} else {
		$ticket_status = 4;
	}

	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = ?
		WHERE
			`ticket_id` = ?
		AND
			(`ticket_from` = ? OR `ticket_to` = ?)
	";

	$rs = exec_query($sql, $query, array($ticket_status, $ticket_id, $_SESSION['user_id'], $_SESSION['user_id']));
	// end of set status 3
}

function close_ticket($sql, $ticket_id) {
	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = '0'
		WHERE
			`ticket_id` = ?
		AND
			(`ticket_from` = ? OR `ticket_to` = ?)
	";
	$rs = exec_query($sql, $query, array($ticket_id, $_SESSION['user_id'], $_SESSION['user_id']));
	set_page_message(tr('Ticket was closed!'));
}

function open_ticket(&$sql, $ticket_id) {
	$ticket_status = 3;

	$query = "
		UPDATE
			`tickets`
		SET
			`ticket_status` = ?
		WHERE
			`ticket_id` = ?
		AND
			(`ticket_from` = ? OR `ticket_to` = ?)
	";

	$rs = exec_query($sql, $query, array($ticket_status, $ticket_id, $_SESSION['user_id'], $_SESSION['user_id']));
	set_page_message(tr('Ticket was reopened!'));
}

// dynamic page data.

if (!Config::get('ISPCP_SUPPORT_SYSTEM')) {
	header("Location: index.php");
	die();
}

$reseller_id = $_SESSION['user_created_by'];
if (isset($_GET['ticket_id'])) {
	$ticket_id = $_GET['ticket_id'];

	if (isset($_GET['screenwidth'])) {
		$screenwidth = $_GET['screenwidth'];
	} else {
		$screenwidth = $_POST['screenwidth'];
	}

	if (!isset($screenwidth) || $screenwidth < 639) {
		$screenwidth = 1024;
	}
	$tpl->assign('SCREENWIDTH', $screenwidth);

	send_user_message($sql, $_SESSION['user_id'], $reseller_id, $ticket_id);
	change_ticket_status($sql, $ticket_id);
	gen_tickets_list($tpl, $sql, $ticket_id, $screenwidth);
} else {
	set_page_message(tr('Ticket not found!'));
	header("Location: ticket_system.php");
	die();
}

// static page messages.

gen_client_mainmenu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/main_menu_ticket_system.tpl');
gen_client_menu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/menu_ticket_system.tpl');

gen_logged_from($tpl);

$tpl->assign(
	array(
		'TR_VIEW_SUPPORT_TICKET' => tr('View support ticket'),
		'TR_TICKET_URGENCY' => tr('Priority'),
		'TR_TICKET_SUBJECT' => tr('Subject'),
		'TR_TICKET_DATE' => tr('Date'),
		'TR_DELETE' => tr('Delete'),
		'TR_NEW_TICKET_REPLY' => tr('Send message reply'),
		'TR_REPLY' => tr('Send reply'),
		'TR_TICKET_FROM' => tr('From'),
		'TR_OPEN_TICKETS' => tr('Open tickets'),
		'TR_CLOSED_TICKETS' => tr('Closed tickets')
	)
);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG'))
	dump_gui_debug();

?>