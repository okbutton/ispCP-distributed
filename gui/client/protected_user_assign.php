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

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::get('CLIENT_TEMPLATE_PATH') . '/puser_assign.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('already_in', 'page');
$tpl->define_dynamic('grp_avlb', 'page');
$tpl->define_dynamic('add_button', 'page');
$tpl->define_dynamic('remove_button', 'page');

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
		array(
			'THEME_COLOR_PATH' => "../themes/$theme_color",
			'THEME_CHARSET' => tr('encoding'),
			'ISP_LOGO' => get_logo($_SESSION['user_id'])
		)
	);
// ** Functions
function get_htuser_name(&$sql, &$uuser_id, &$dmn_id) {
	$query = <<<SQL_QUERY
        select
            uname
        from
            htaccess_users
        where
             dmn_id = ?
        and
			id = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($dmn_id, $uuser_id));

	if ($rs->RecordCount() == 0) {
		header('Location: protected_user_manage.php');
		die();
	} else {
		return $rs->fields['uname'];
	}
}

function gen_user_assign(&$tpl, &$sql, &$dmn_id) {
	if (isset($_GET['uname']) && $_GET['uname'] !== '' && is_numeric($_GET['uname'])) {
		$uuser_id = $_GET['uname'];

		$tpl->assign('UNAME', get_htuser_name($sql, $uuser_id, $dmn_id));
		$tpl->assign('UID', $uuser_id);
	} else if (isset($_POST['nadmin_name']) && !empty($_POST['nadmin_name']) && is_numeric($_POST['nadmin_name'])) {
		$uuser_id = $_POST['nadmin_name'];

		$tpl->assign('UNAME', get_htuser_name($sql, $uuser_id, $dmn_id));
		$tpl->assign('UID', $uuser_id);
	} else {
		header('Location: protected_user_manage.php');
		die();
	}
	// get groups
	$query = <<<SQL_QUERY
        select
            *
        from
            htaccess_groups
        where
             dmn_id = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($dmn_id));

	if ($rs->RecordCount() == 0) {
		set_page_message(tr('You have no groups!'));
		header('Location: protected_user_manage.php');
		die();
	} else {
		$added_in = 0;
		$not_added_in = 0;

		while (!$rs->EOF) {
			$group_id = $rs->fields['id'];
			$group_name = $rs->fields['ugroup'];
			$members = $rs->fields['members'];

			$members = explode(",", $members);
			$grp_in = 0;
			// lets generete all groups wher the user is  assignet
			for($i = 0; $i < count($members);$i++) {
				if ($uuser_id == $members[$i]) {
					$tpl->assign(
						array('GRP_IN' => $group_name,
							'GRP_IN_ID' => $group_id,
							)
						);

					$tpl->parse('ALREADY_IN', '.already_in');
					$grp_in = $group_id;
					$added_in ++;
				}
			}
			if ($grp_in !== $group_id) {
				$tpl->assign(
					array('GRP_NAME' => $group_name,
						'GRP_ID' => $group_id,
						)
					);
				$tpl->parse('GRP_AVLB', '.grp_avlb');
				$not_added_in ++;
			}

			$rs->MoveNext();
		}
		// generate add/remove buttons
		if ($added_in < 1) {
			$tpl->assign('ALREADY_IN', '');
			$tpl->assign('REMOVE_BUTTON', '');
		}
		if ($not_added_in < 1) {
			$tpl->assign('GRP_AVLB', '');
			$tpl->assign('ADD_BUTTON', '');
		}
	}
}

function add_user_to_group(&$tpl, &$sql, &$dmn_id) {
	if (isset($_POST['uaction']) && $_POST['uaction'] == 'add' && isset($_POST['groups']) && !empty($_POST['groups']) && isset($_POST['nadmin_name']) && is_numeric($_POST['groups']) && is_numeric($_POST['nadmin_name'])) {
		$uuser_id = clean_input($_POST['nadmin_name']);
		$group_id = $_POST['groups'];

		$query = <<<SQL_QUERY
        select
			id,
			ugroup,
			members
		from
        	htaccess_groups
        where
			dmn_id = ?
			and
			id = ?
SQL_QUERY;
		$rs = exec_query($sql, $query, array($dmn_id, $group_id));

		$members = $rs->fields['members'];
		if ($members == '') {
			$members = $uuser_id;
		} else {
			$members = $members . "," . $uuser_id;
		}

		$change_status = Config::get('ITEM_CHANGE_STATUS');

		$update_query = <<<SQL_QUERY
				update
					htaccess_groups
				set
					members = ?,
					status = ?
				where
					id = ?
					and
					dmn_id = ?
SQL_QUERY;

		$rs_update = exec_query($sql, $update_query, array($members, $change_status, $group_id, $dmn_id));

		$change_status = Config::get('ITEM_CHANGE_STATUS');

		$query = <<<SQL_QUERY
				update
					htaccess
				set
					status = ?
				where
					dmn_id = ?
SQL_QUERY;

		$rs_update_htaccess = exec_query($sql, $query, array($change_status, $dmn_id));

		check_for_lock_file();
		send_request();
		set_page_message(tr('User was assigned to the %s group', $rs->fields['ugroup']));
	} else {
		return;
	}
}

function delete_user_from_group(&$tpl, &$sql, &$dmn_id) {
	if (isset($_POST['uaction']) && $_POST['uaction'] == 'remove' && isset($_POST['groups_in']) && !empty($_POST['groups_in']) && isset($_POST['nadmin_name']) && is_numeric($_POST['groups_in']) && is_numeric($_POST['nadmin_name'])) {
		$group_id = $_POST['groups_in'];
		$uuser_id = clean_input($_POST['nadmin_name']);

		$query = <<<SQL_QUERY
        select
			id,
			ugroup,
			members
		from
        	htaccess_groups
        where
			dmn_id = ?
			and
			id = ?
SQL_QUERY;
		$rs = exec_query($sql, $query, array($dmn_id, $group_id));

		$members = $rs->fields['members'];
		$members = preg_replace("/$uuser_id/", "", "$members");

		$members = preg_replace("/,,/", ",", "$members");
		$members = preg_replace("/^,/", "", "$members");
		$members = preg_replace("/,$/", "", "$members");

		$update_query = <<<SQL_QUERY
				update
					htaccess_groups
				set
					members = ?
				where
					id = ?
				and
					dmn_id = ?
SQL_QUERY;

		$rs_update = exec_query($sql, $update_query, array($members, $group_id, $dmn_id));

		$change_status = Config::get('ITEM_CHANGE_STATUS');
		$query = <<<SQL_QUERY
				update
					htaccess
				set
					status = ?
				where
					dmn_id = ?
SQL_QUERY;
		$rs_update_htaccess = exec_query($sql, $query, array($change_status, $dmn_id));

		check_for_lock_file();
		send_request();

		set_page_message(tr('User was deleted from the %s group ', $rs->fields['ugroup']));
	} else {
		return;
	}
}

function gen_page_awstats(&$tpl) {
	$awstats_act = Config::get('AWSTATS_ACTIVE');
	if ($awstats_act != 'yes') {
		$tpl->assign('ACTIVE_AWSTATS', '');
	} else {
		$tpl->assign(
			array(
				'AWSTATS_PATH' => 'http://' . $_SESSION['user_logged'] . '/stats/',
				'AWSTATS_TARGET' => '_blank'
				)
			);
	}
}
// ** end of funcfions

gen_client_mainmenu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/main_menu_webtools.tpl');
gen_client_menu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/menu_webtools.tpl');

gen_logged_from($tpl);

gen_page_awstats($tpl);

check_permissions($tpl);

$dmn_id = get_user_domain_id($sql, $_SESSION['user_id']);

add_user_to_group($tpl, $sql, $dmn_id);

delete_user_from_group($tpl, $sql, $dmn_id);

gen_user_assign($tpl, $sql, $dmn_id);

$tpl->assign(
		array(
			'TR_HTACCESS' => tr('Protected areas'),
			'TR_DELETE' => tr('Delete'),
			'TR_USER_ASSIGN' => tr('User assign'),
			'TR_ALLREADY' => tr('Already in:'),
			'TR_MEMBER_OF_GROUP' => tr('Member of group:'),
			'TR_BACK' => tr('Back'),
			'TR_REMOVE' => tr('Remove'),
			'TR_ADD' => tr('Add'),
			'TR_SELECT_GROUP' => tr('Select group:')
		)
	);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG'))
	dump_gui_debug();

unset_messages();

?>