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

check_login(__FILE__, Config::getInstance()->get('PREVENT_EXTERNAL_LOGIN_ADMIN'));

$theme_color = Config::getInstance()->get('USER_INITIAL_THEME');

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/index.tpl');
$tpl->define_dynamic('def_language', 'page');
$tpl->define_dynamic('def_layout', 'page');
$tpl->define_dynamic('no_messages', 'page');
$tpl->define_dynamic('msg_entry', 'page');
$tpl->define_dynamic('update_message', 'page');
$tpl->define_dynamic('database_update_message', 'page');
$tpl->define_dynamic('critical_update_message', 'page');
$tpl->define_dynamic('traff_warn', 'page');

function gen_system_message(&$tpl, &$sql) {
	$user_id = $_SESSION['user_id'];

	$query = "
		SELECT
			COUNT(`ticket_id`) AS cnum
		FROM
			`tickets`
		WHERE
			`ticket_to` = ?
		AND
			(`ticket_status` = '2' OR `ticket_status` = '5')
		AND
			`ticket_reply` = 0
	";

	$rs = exec_query($sql, $query, array($user_id));

	$num_question = $rs->fields('cnum');

	if ($num_question == 0) {
		$tpl->assign(array('MSG_ENTRY' => ''));
	} else {
		$tpl->assign(
			array(
				'TR_NEW_MSGS' => tr('You have <b>%d</b> new support questions', $num_question),
				'TR_VIEW' => tr('View')
			)
		);

		$tpl->parse('MSG_ENTRY', 'msg_entry');
	}
}

function get_update_infos(&$tpl) {

	$sql = Database::getInstance();

	if (criticalUpdate::getInstance()->checkUpdateExists()) {
		criticalUpdate::getInstance()->executeUpdates();
		if (criticalUpdate::getInstance()->getErrorMessage()!="")
			system_message(criticalUpdate::getInstance()->getErrorMessage());
		$tpl->assign(array('CRITICAL_MESSAGE' => 'Critical update has been performed'));
		$tpl->parse('CRITICAL_UPDATE_MESSAGE', 'critical_update_message');
	} else {
		$tpl->assign(array('CRITICAL_UPDATE_MESSAGE' => ''));
	}

	if (databaseUpdate::getInstance()->checkUpdateExists()) {
		$tpl->assign(array('DATABASE_UPDATE' => '<a href="database_update.php" class="link">' . tr('A database update is available') . '</a>'));
		$tpl->parse('DATABASE_UPDATE_MESSAGE', 'database_update_message');
	} else {
		$tpl->assign(array('DATABASE_UPDATE_MESSAGE' => ''));
	}

	if (!Config::getInstance()->get('CHECK_FOR_UPDATES')) {
		$tpl->assign(array('UPDATE' => tr('Update checking is disabled!')));
		$tpl->parse('UPDATE_MESSAGE', 'update_message');
		return false;
	}

	if (versionUpdate::getInstance()->checkUpdateExists()) {
		$tpl->assign(array('UPDATE' => '<a href="ispcp_updates.php" class="link">' . tr('New ispCP update is now available') . '</a>'));
		$tpl->parse('UPDATE_MESSAGE', 'update_message');
	} else {
		if (versionUpdate::getInstance()->getErrorMessage() != "") {
			$tpl->assign(array('UPDATE' => versionUpdate::getInstance()->getErrorMessage()));
			$tpl->parse('UPDATE_MESSAGE', 'update_message');
		} else {
			$tpl->assign(array('UPDATE_MESSAGE' => ''));
		}
	}
}

function gen_server_trafic(&$tpl, &$sql) {
	$query = "SELECT `straff_max`, `straff_warn` FROM `straff_settings`";

	$rs = exec_query($sql, $query, array());

	$straff_max = (($rs->fields['straff_max']) * 1024) * 1024;

	$fdofmnth = mktime(0, 0, 0, date("m"), 1, date("Y"));

	$ldofmnth = mktime(1, 0, 0, date("m") + 1, 0, date("Y"));

	$query = "
		SELECT
			IFNULL((SUM(`bytes_in`) + SUM(`bytes_out`)), 0) AS traffic
		FROM
			`server_traffic`
		WHERE
			`traff_time` > ?
		AND
			`traff_time` < ?
	";

	$rs1 = exec_query($sql, $query, array($fdofmnth, $ldofmnth));

	$traff = $rs1->fields['traffic'];

	$mtraff = sprintf("%.2f", $traff);

	if ($straff_max == 0) {
		$pr = 0;
	} else {
		$pr = ($traff / $straff_max) * 100;
	}

	if (($straff_max != 0 || $straff_max != '') && ($mtraff > $straff_max)) {
		$tpl->assign('TR_TRAFFIC_WARNING', tr('You are exceeding your traffic limit!')
			);
	} else {
		$tpl->assign('TRAFF_WARN', '');
	}

	$bar_value = calc_bar_value($traff, $straff_max , 400);

	$traff_msg = '';
    $percent = 0;
	if ($straff_max == 0) {
		$traff_msg = tr('%1$d%% [%2$s of unlimited]', $pr, sizeit($mtraff));
	} else {
		$traff_msg = tr('%1$d%% [%2$s of %3$s]', $pr, sizeit($mtraff), sizeit($straff_max));
		$percent = ($traff/$straff_max)*100;
	}

	$tpl->assign(
		array(
			'TRAFFIC_WARNING' => $traff_msg,
			'BAR_VALUE' => $bar_value,
			'TRAFFIC_PERCENT' => $percent,
		)
	);
}

/*
 *
 * static page messages.
 *
 */

$tpl->assign(
	array(
		'TR_ADMIN_MAIN_INDEX_PAGE_TITLE' => tr('ispCP - Admin/Main Index'),
		'THEME_COLOR_PATH' => "../themes/$theme_color",
		'ISP_LOGO' => get_logo($_SESSION['user_id']),
		'THEME_CHARSET' => tr('encoding')
	)
);

gen_admin_mainmenu($tpl, Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/main_menu_general_information.tpl');
gen_admin_menu($tpl, Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/menu_general_information.tpl');

get_admin_general_info($tpl, $sql);

get_update_infos($tpl);

gen_system_message($tpl, $sql);

gen_server_trafic($tpl, $sql);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::getInstance()->get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
