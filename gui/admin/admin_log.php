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

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/admin_log.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('log_row', 'page');
$tpl->define_dynamic('scroll_prev_gray', 'page');
$tpl->define_dynamic('scroll_prev', 'page');
$tpl->define_dynamic('scroll_next_gray', 'page');
$tpl->define_dynamic('scroll_next', 'page');
$tpl->define_dynamic('clear_log', 'page');

$theme_color = Config::getInstance()->get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_ADMIN_ADMIN_LOG_PAGE_TITLE'	=> tr('ispCP - Admin/Admin Log'),
		'THEME_COLOR_PATH'				=> "../themes/$theme_color",
		'THEME_CHARSET'					=> tr('encoding'),
		'ISP_LOGO'						=> get_logo($_SESSION['user_id'])
	)
);

function generate_page(&$tpl) {
	$sql = Database::getInstance();

	$start_index = 0;
	$rows_per_page = 15;

	if (isset($_GET['psi']) && is_numeric($_GET['psi']))
		$start_index = intval($_GET['psi']);

	$count_query = "
		SELECT
			COUNT(`log_id`) AS cnt
		FROM
			`log`
	";

	$query = "
		SELECT
			DATE_FORMAT(`log_time`, '%Y-%m-%d %H:%i') AS dat, `log_message`
		FROM
			`log`
		ORDER BY
			`log_time` DESC
		LIMIT
			$start_index, $rows_per_page
	";

	$rs = exec_query($sql, $count_query);

	$records_count = $rs->fields['cnt'];

	$rs = exec_query($sql, $query);

	if ($rs->RowCount() == 0) {
		// set_page_message(tr('Log is empty!'));
		$tpl->assign(
			array(
				'LOG_ROW'		=> '',
				'PAG_MESSAGE'	=> tr('Log is empty!'),
				'USERS_LIST'	=> '',
				'SCROLL_PREV'	=> '',
				'SCROLL_NEXT'	=> '',
				'CLEAR_LOG'		=> ''
			)
		);
	} else {
		$prev_si = $start_index - $rows_per_page;

		if ($start_index == 0) {
			$tpl->assign('SCROLL_PREV', '');
		} else {
			$tpl->assign(
				array(
					'SCROLL_PREV_GRAY'	=> '',
					'PREV_PSI'			=> $prev_si
				)
			);
		}

		$next_si = $start_index + $rows_per_page;

		if ($next_si + 1 > $records_count) {
			$tpl->assign('SCROLL_NEXT', '');
		} else {
			$tpl->assign(
				array(
					'SCROLL_NEXT_GRAY'	=> '',
					'NEXT_PSI'			=> $next_si
				)
			);
		}

		$tpl->assign(
			array(
				'PAGE_MESSAGE' => ''
			)
		);

		$row = 1;

		while (!$rs->EOF) {
			$tpl->assign(
				array(
					'ROW_CLASS' => ($row++ % 2 == 0) ? 'content' : 'content2',
				)
			);

			$log_message = htmlentities($rs->fields['log_message']);
			$replaces = array(
				'/[^a-zA-Z](delete[sd]?)[^a-zA-Z]/i'	=> ' <strong style="color:#FF0000">\\1</strong> ',
				'/[^a-zA-Z](remove[sd]?)[^a-zA-Z]/i'	=> ' <strong style="color:#FF0000">\\1</strong> ',
				'/[^a-zA-Z](add(s|ed)?)[^a-zA-Z]/i'		=> ' <strong style="color:#33CC66">\\1</strong> ',
				'/[^a-zA-Z](change[sd]?)[^a-zA-Z]/i'	=> ' <strong style="color:#3300FF">\\1</strong> ',
				'/[^a-zA-Z](update[sd]?)[^a-zA-Z]/i'	=> ' <strong style="color:#3300FF">\\1</strong> ',
				'/[^a-zA-Z](edit(s|ed)?)[^a-zA-Z]/i'	=> ' <strong style="color:#33CC66">\\1</strong> ',
				'/[^a-zA-Z](unknown)[^a-zA-Z]/i'		=> ' <strong style="color:#CC00FF">\\1</strong> ',
				'/[^a-zA-Z](logged)[^a-zA-Z]/i'			=> ' <strong style="color:#336600">\\1</strong> ',
				'/[^a-zA-Z]((session )?manipulation)[^a-zA-Z]/i'	=> ' <strong style="color:#FF0000">\\1</strong> ',
				'/[^a-zA-Z]*(Warning[\!]?)[^a-zA-Z]/i'	=> ' <strong style="color:#FF0000">\\1</strong> ',
				'/(bad password login data)/i'			=> ' <strong style="color:#FF0000">\\1</strong> '
			);

			foreach ($replaces as $pattern => $replacement) {
				$log_message = preg_replace($pattern, $replacement, $log_message);
			}

			$date_formt = Config::getInstance()->get('DATE_FORMAT') . ' H:i';
			$tpl->assign(
				array(
					'MESSAGE'	=> html_entity_decode($log_message),
					'DATE'		=> date($date_formt, strtotime($rs->fields['dat'])),
				)
			);

			$tpl->parse('LOG_ROW', '.log_row');

			$rs->MoveNext();
		} // end while
	}
}

function clear_log() {
	$sql = Database::getInstance();

	if (isset($_POST['uaction']) && $_POST['uaction'] === 'clear_log') {
		$query = null;
		$msg = '';

		switch ($_POST['uaction_clear']) {
			case 0:
				$query = "DELETE FROM `log`";
				$msg = tr('%s deleted the full admin log!', $_SESSION['user_logged']);
				break;

			case 2:
				// 2 Weeks
				$query = "
					DELETE FROM
						`log`
					WHERE
						DATE_SUB(CURDATE(), INTERVAL 14 DAY) >= `log_time`
				";
				$msg = tr('%s deleted the admin log older than two weeks!', $_SESSION['user_logged']);

				break;

			case 4:
				$query = "
					DELETE FROM
						`log`
					WHERE
						DATE_SUB(CURDATE(), INTERVAL 1 MONTH) >= `log_time`
				";
				$msg = tr('%s deleted the admin log older than one month!', $_SESSION['user_logged']);

				break;

			case 12:
				$query = "
					DELETE FROM
						`log`
					WHERE
						DATE_SUB(CURDATE(), INTERVAL 3 MONTH) >= `log_time`
				";
				$msg = tr('%s deleted the admin log older than three months!', $_SESSION['user_logged']);
				break;

			case 26:
				$query = "
					DELETE FROM
						`log`
					WHERE
						DATE_SUB(CURDATE(), INTERVAL 6 MONTH) >= `log_time`
				";
				$msg = tr('%s deleted the admin log older than six months!', $_SESSION['user_logged']);
				break;

			case 52;
				$query = "
					DELETE FROM
						`log`
					WHERE
						DATE_SUB(CURDATE(), INTERVAL 1 YEAR) >= `log_time`
				";
				$msg = tr('%s deleted the admin log older than one year!', $_SESSION['user_logged']);

				break;
			default:
				system_message(tr('Invalid time period!'));
				break;
		}

		$rs = execute_query($sql, $query);
		write_log($msg);
	}
}

/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/main_menu_general_information.tpl');
gen_admin_menu($tpl, Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/menu_general_information.tpl');

clear_log();

generate_page ($tpl);

$tpl->assign(
	array(
		'TR_ADMIN_LOG'				=> tr('Admin Log'),
		'TR_CLEAR_LOG'				=> tr('Clear log'),
		'TR_DATE'					=> tr('Date'),
		'TR_MESSAGE'				=> tr('Message'),
		'TR_CLEAR_LOG_MESSAGE'		=> tr('Delete from log:'),
		'TR_CLEAR_LOG_EVERYTHING'	=> tr('everything'),
		'TR_CLEAR_LOG_LAST2'		=> tr('older than 2 weeks'),
		'TR_CLEAR_LOG_LAST4'		=> tr('older than 1 month'),
		'TR_CLEAR_LOG_LAST12'		=> tr('older than 3 months'),
		'TR_CLEAR_LOG_LAST26'		=> tr('older than 6 months'),
		'TR_CLEAR_LOG_LAST52'		=> tr('older than 12 months'),
	)
);
// gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::getInstance()->get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
