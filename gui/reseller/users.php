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
$tpl->define_dynamic('page', Config::getInstance()->get('RESELLER_TEMPLATE_PATH') . '/users.tpl');
$tpl->define_dynamic('users_list', 'page');
$tpl->define_dynamic('user_entry', 'users_list');
$tpl->define_dynamic('user_details', 'users_list');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('scroll_prev_gray', 'page');
$tpl->define_dynamic('scroll_prev', 'page');
$tpl->define_dynamic('scroll_next_gray', 'page');
$tpl->define_dynamic('scroll_next', 'page');
$tpl->define_dynamic('edit_option', 'page');
$tpl->define_dynamic('alias_menu', 'page');

$theme_color = Config::getInstance()->get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_CLIENT_CHANGE_PERSONAL_DATA_PAGE_TITLE' => tr('ispCP - Users'),
		'THEME_COLOR_PATH' => "../themes/$theme_color",
		'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id']),
	)
);

// TODO: comment!
unset($_SESSION['dmn_name']);
unset($_SESSION['ch_hpprops']);
unset($_SESSION['local_data']);
unset($_SESSION['dmn_ip']);
unset($_SESSION['dmn_id']);
unset($GLOBALS['dmn_name']);
unset($GLOBALS['ch_hpprops']);
unset($GLOBALS['local_data']);
unset($GLOBALS['user_add3_added']);
unset($GLOBALS['user_add3_added']);
unset($GLOBALS['dmn_ip']);
unset($GLOBALS['dmn_id']);

/*
 *
 * static page messages.
 *
 */

gen_reseller_mainmenu($tpl, Config::getInstance()->get('RESELLER_TEMPLATE_PATH') . '/main_menu_users_manage.tpl');
gen_reseller_menu($tpl, Config::getInstance()->get('RESELLER_TEMPLATE_PATH') . '/menu_users_manage.tpl');

gen_logged_from($tpl);

$crnt_month = date("m");
$crnt_year = date("Y");

$tpl->assign(
	array(
		'TR_MANAGE_USERS' => tr('Manage users'),
		'TR_USERS' => tr('Users'),
		'TR_USER_STATUS' => tr('Status'),
		'TR_DETAILS' => tr('Details'),
		'TR_SEARCH' => tr('Search'),
		'TR_USERNAME' => tr('Username'),
		'TR_ACTION' => tr('Actions'),
		'TR_CREATION_DATE' => tr('Creation date'),
		'TR_EXPIRE_DATE' => tr('Expire date'),
		'TR_CHANGE_USER_INTERFACE' => tr('Switch to user interface'),
		'TR_BACK' => tr('Back'),
		'TR_TITLE_BACK' => tr('Return to previous menu'),
		'TR_TABLE_NAME' => tr('Users list'),
		'TR_MESSAGE_CHANGE_STATUS' => tr('Are you sure you want to change the status of %s?', true, '%s'),
		'TR_MESSAGE_DELETE_ACCOUNT' => tr('Are you sure you want to delete %s?', true, '%s'),
		'TR_STAT' => tr('Stats'),
		'VL_MONTH' => $crnt_month,
		'VL_YEAR' => $crnt_year,
		'TR_EDIT_DOMAIN' => tr('Edit Domain'),
		'TR_EDIT_USER' => tr('Edit User'),
		'TR_BW_USAGE' => tr('Bandwidth'),
		'TR_DISK_USAGE' => tr('Disk')
	)
);

if (Config::getInstance()->exists('HOSTING_PLANS_LEVEL') && Config::getInstance()->get('HOSTING_PLANS_LEVEL') === 'admin') {
	$tpl->assign('EDIT_OPTION', '');
}

generate_users_list($tpl, $_SESSION['user_id']);
check_externel_events($tpl);
gen_page_message($tpl);

if (!check_reseller_domainalias_permissions($_SESSION['user_id'])) {
	$tpl->assign('alias_menu', '');
}

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::getInstance()->get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();

// Begin function block

function generate_users_list(&$tpl, $admin_id) {
	$sql = Database::getInstance();
	global $externel_event;

	$start_index = 0;

	$rows_per_page = Config::getInstance()->get('DOMAIN_ROWS_PER_PAGE');

	if (isset($_POST['details']) && !empty($_POST['details'])) {
		$_SESSION['details'] = $_POST['details'];
	} else {
		if (!isset($_SESSION['details'])) {
			$_SESSION['details'] = "hide";
		}
	}

	if (isset($_GET['psi'])) $start_index = $_GET['psi'];

	// Search request generated ?!

	if (isset($_POST['uaction']) && !empty($_POST['uaction'])) {
		$_SESSION['search_for'] = trim(clean_input($_POST['search_for']));

		$_SESSION['search_common'] = $_POST['search_common'];

		$_SESSION['search_status'] = $_POST['search_status'];

		$start_index = 0;
	} else {
		if (isset($_SESSION['search_for']) && !isset($_GET['psi'])) {
			// He have not got scroll through patient records.
			unset($_SESSION['search_for']);
			unset($_SESSION['search_common']);
			unset($_SESSION['search_status']);
		}
	}

	$search_query = '';
	$count_query = '';

	if (isset($_SESSION['search_for'])) {
		gen_manage_domain_query($search_query,
			$count_query,
			$admin_id,
			$start_index,
			$rows_per_page,
			$_SESSION['search_for'],
			$_SESSION['search_common'],
			$_SESSION['search_status']
		);

		gen_manage_domain_search_options($tpl, $_SESSION['search_for'], $_SESSION['search_common'], $_SESSION['search_status']);
	} else {
		gen_manage_domain_query($search_query,
			$count_query,
			$admin_id,
			$start_index,
			$rows_per_page,
			'n/a',
			'n/a',
			'n/a'
		);

		gen_manage_domain_search_options($tpl, 'n/a', 'n/a', 'n/a');
	}

	$rs = execute_query($sql, $count_query);

	$records_count = $rs->fields['cnt'];

	$rs = execute_query($sql, $search_query);

	if ($records_count == 0) {
		if (isset($_SESSION['search_for'])) {
			$tpl->assign(
				array(
					'USERS_LIST' => '',
					'SCROLL_PREV' => '',
					'SCROLL_NEXT' => '',
					'TR_VIEW_DETAILS' => tr('View aliases'),
					'SHOW_DETAILS' => tr("Show")
				)
			);

			set_page_message(tr('Not found user records matching the search criteria!'));

			unset($_SESSION['search_for']);
			unset($_SESSION['search_common']);
			unset($_SESSION['search_status']);
		} else {
			$tpl->assign(
				array(
					'USERS_LIST' => '',
					'SCROLL_PREV' => '',
					'SCROLL_NEXT' => '',
					'TR_VIEW_DETAILS' => tr('View aliases'),
					'SHOW_DETAILS' => tr("Show")
				)
			);

			set_page_message(tr('You have no users.'));
		}
	} else {
		$prev_si = $start_index - $rows_per_page;

		if ($start_index == 0) {
			$tpl->assign('SCROLL_PREV', '');
		} else {
			$tpl->assign(
				array(
					'SCROLL_PREV_GRAY' => '',
					'PREV_PSI' => $prev_si
				)
			);
		}

		$next_si = $start_index + $rows_per_page;

		if ($next_si + 1 > $records_count) {
			$tpl->assign('SCROLL_NEXT', '');
		} else {
			$tpl->assign(
				array(
					'SCROLL_NEXT_GRAY' => '',
					'NEXT_PSI' => $next_si
				)
			);
		}
		$i = 1;

		while (!$rs->EOF) {
			if ($rs->fields['domain_status'] == Config::getInstance()->get('ITEM_OK_STATUS')) {
				$status_icon = "ok.png";
			} else if ($rs->fields['domain_status'] == Config::getInstance()->get('ITEM_DISABLED_STATUS')) {
				$status_icon = "disabled.png";
			} else if ($rs->fields['domain_status'] == Config::getInstance()->get('ITEM_ADD_STATUS')
				|| $rs->fields['domain_status'] == Config::getInstance()->get('ITEM_CHANGE_STATUS')
				|| $rs->fields['domain_status'] == Config::getInstance()->get('ITEM_TOENABLE_STATUS')
				|| $rs->fields['domain_status'] == Config::getInstance()->get('ITEM_RESTORE_STATUS')
				|| $rs->fields['domain_status'] == Config::getInstance()->get('ITEM_TODISABLED_STATUS')
				|| $rs->fields['domain_status'] == Config::getInstance()->get('ITEM_DELETE_STATUS')) {
				$status_icon = "reload.png";
			} else {
				$status_icon = "error.png";
			}
			$status_url = $rs->fields['domain_id'];

			$tpl->assign(
				array(
					'STATUS_ICON' => $status_icon,
					'URL_CHANGE_STATUS' => $status_url,
				)
			);

			$admin_name = decode_idna($rs->fields['domain_name']);

			$tpl->assign(
				array(
					'CLASS_TYPE_ROW' => ($i % 2 == 0) ? 'content' : 'content2',
				)
			);

			$dom_created = $rs->fields['domain_created'];

			$dom_expires = $rs->fields['domain_expires'];

			if ($dom_created == 0) {
				$dom_created = tr('N/A');
			} else {
				$date_formt = Config::getInstance()->get('DATE_FORMAT');
				$dom_created = date($date_formt, $dom_created);
			}

			if ($dom_expires == 0) {
				$dom_expires = tr('N/A');
			} else {
				$date_formt = Config::getInstance()->get('DATE_FORMAT');
				$dom_expires = date($date_formt, $dom_expires);
			}

			$tpl->assign(
				array(
					'CREATION_DATE' => $dom_created,
					'EXPIRE_DATE' => $dom_expires,
					'DOMAIN_ID' => $rs->fields['domain_id'],
					'NAME' => $admin_name,
					'ACTION' => tr('Delete'),
					'USER_ID' => $rs->fields['domain_admin_id'],
					'CHANGE_INTERFACE' => tr('Switch'),
					'DISK_USAGE' => ($rs->fields['domain_disk_limit'])
						? tr('%1$s of %2$s MB', round($rs->fields['domain_disk_usage'] / 1024 / 1024,1), $rs->fields['domain_disk_limit'])
						: tr('%1$s of <b>unlimited</b> MB', round($rs->fields['domain_disk_usage'] / 1024 / 1024,1))
				)
			);

			gen_domain_details($tpl, $sql, $rs->fields['domain_id']);
			$tpl->parse('USER_ENTRY', '.user_entry');
			$i++;
			$rs->MoveNext();
		}

		$tpl->parse('USER_LIST', 'users_list');
	}
}

function check_externel_events(&$tpl) {
	global $user_add3_added, $externel_event, $edit, $es_sbmt, $user_has_domain, $user_deleted;

	if (isset($_SESSION["user_add3_added"])) {
		if ($_SESSION["user_add3_added"] === '_yes_') {
			set_page_message(tr('User added!'));

			$externel_event = '_on_';
			unset($_SESSION["user_add3_added"]);
		}
	} else if (isset($_SESSION["edit"])) {
		if ('_yes_' === $_SESSION["edit"]) {
			set_page_message(tr('User data updated!'));
		} else {
			set_page_message(tr('User data not updated!'));
		}
		unset($_SESSION["edit"]);
	} else if (isset($_SESSION["user_has_domain"])) {
		if ($_SESSION["user_has_domain"] == '_yes_') {
			set_page_message(tr('This user has domain record !<br>First remove the domain from the system!'));
		}

		unset($_SESSION["user_has_domain"]);
	} else if (isset($_SESSION['user_deleted'])) {
		if ($_SESSION['user_deleted'] == '_yes_') {
			set_page_message(tr('User terminated!'));
		} else {
			set_page_message(tr('User not terminated!'));
		}

		unset($_SESSION['user_deleted']);
	}
}
