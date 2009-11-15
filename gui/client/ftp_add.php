<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2008 by ispCP | http://isp-control.net
 * @version 	SVN: $ID$
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
 * Portions created by the ispCP Team are Copyright (C) 2006-2009 by
 * isp Control Panel. All Rights Reserved.
 */

require '../include/ispcp-lib.php';

check_login(__FILE__);

$tpl = new pTemplate();

$tpl->define_dynamic('page', Config::get('CLIENT_TEMPLATE_PATH') . '/ftp_add.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('als_list', 'page');
$tpl->define_dynamic('sub_list', 'page');
$tpl->define_dynamic('to_subdomain', 'page');
$tpl->define_dynamic('to_alias_domain', 'page');
// JavaScript
$tpl->define_dynamic('js_to_subdomain', 'page');
$tpl->define_dynamic('js_to_alias_domain', 'page');
$tpl->define_dynamic('js_to_all_domain', 'page');
$tpl->define_dynamic('js_not_domain', 'page');

// page functions.

function get_alias_mount_point(&$sql, $alias_name) {
	$query = <<<SQL_QUERY
		SELECT
			`alias_mount`
		FROM
			`domain_aliasses`
		WHERE
			`alias_name` = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($alias_name));
	return $rs->fields['alias_mount'];
}

function gen_page_form_data(&$tpl, $dmn_name, $post_check) {
	$dmn_name = decode_idna($dmn_name);
	if ($post_check === 'no') {
		$tpl->assign(
			array(
				'USERNAME' => '',
				'DOMAIN_NAME' => $dmn_name,
				'DMN_TYPE_CHECKED' => 'checked="checked"',
				'ALS_TYPE_CHECKED' => '',
				'SUB_TYPE_CHECKED' => '',
				'OTHER_DIR' => '',
				'USE_OTHER_DIR_CHECKED' => ''
			)
		);
	} else {
		$tpl->assign(
			array(
				'USERNAME' => clean_input($_POST['username'], true),
				'DOMAIN_NAME' => $dmn_name,
				'DMN_TYPE_CHECKED' => ($_POST['dmn_type'] === 'dmn') ? 'checked="checked"' : '',
				'ALS_TYPE_CHECKED' => ($_POST['dmn_type'] === 'als') ? 'checked="checked"' : '',
				'SUB_TYPE_CHECKED' => ($_POST['dmn_type'] === 'sub') ? 'checked="checked"' : '',
				'OTHER_DIR' => clean_input($_POST['other_dir'], true),
				'USE_OTHER_DIR_CHECKED' => (isset($_POST['use_other_dir']) && $_POST['use_other_dir'] === 'on') ? 'checked="checked"' : ''
			)
		);
	}
}

function gen_dmn_als_list(&$tpl, &$sql, $dmn_id, $post_check) {
	$ok_status = Config::get('ITEM_OK_STATUS');

	$query = <<<SQL_QUERY
		SELECT
			`alias_id`, `alias_name`
		FROM
			`domain_aliasses`
		WHERE
			`domain_id` = ?
		AND
			`alias_status` = ?
		ORDER BY
			`alias_name`
SQL_QUERY;

	$rs = exec_query($sql, $query, array($dmn_id, $ok_status));
	if ($rs->RecordCount() == 0) {
		$tpl->assign(
			array(
				'ALS_ID' => 'n/a',
				'ALS_SELECTED' => 'selected="selected"',
				'ALS_NAME' => tr('Empty List')
			)
		);
		$tpl->parse('ALS_LIST', 'als_list');
		$tpl->assign('TO_ALIAS_DOMAIN', '');
		$_SESSION['alias_count'] = "no";
	} else {
		$first_passed = false;
		while (!$rs->EOF) {
			if ($post_check === 'yes') {
				$als_id = (!isset($_POST['als_id'])) ? '' : $_POST['als_id'];
				$als_selected = ($als_id == $rs->fields['alias_name'])
					? 'selected="selected"'
					: '';
			} else {
				$als_selected = (!$first_passed) ? 'selected="selected"' : '';
			}

			$als_menu_name = decode_idna($rs->fields['alias_name']);

			$tpl->assign(
				array(
					'ALS_ID' => $rs->fields['alias_name'],
					'ALS_SELECTED' => $als_selected,
					'ALS_NAME' => $als_menu_name
				)
			);

			$tpl->parse('ALS_LIST', '.als_list');
			$rs->MoveNext();

			if (!$first_passed) $first_passed = true;
		}
	}
}

function gen_dmn_sub_list(&$tpl, &$sql, $dmn_id, $dmn_name, $post_check) {
	$ok_status = Config::get('ITEM_OK_STATUS');
	$query = <<<SQL_QUERY
		SELECT
			`subdomain_id` AS sub_id, `subdomain_name` AS sub_name
		FROM
			`subdomain`
		WHERE
			`domain_id` = ?
		AND
			`subdomain_status` = ?
		ORDER BY
			`subdomain_name`
SQL_QUERY;

	$rs = exec_query($sql, $query, array($dmn_id, $ok_status));

	if ($rs->RecordCount() == 0) {
		$tpl->assign(
			array(
				'SUB_ID' => 'n/a',
				'SUB_SELECTED' => 'selected="selected"',
				'SUB_NAME' => tr('Empty list')
			)
		);

		$tpl->parse('SUB_LIST', 'sub_list');
		$tpl->assign('TO_SUBDOMAIN', '');
		$_SESSION['subdomain_count'] = "no";
	} else {
		$first_passed = false;
		while (!$rs->EOF) {
			if ($post_check === 'yes') {
				$sub_id = (!isset($_POST['sub_id'])) ? '' : $_POST['sub_id'];
				$sub_selected = ($sub_id == $rs->fields['sub_name'])
					? 'selected="selected"'
					: '';
			} else {
				$sub_selected = (!$first_passed) ? 'selected="selected"' : '';
			}

			$sub_menu_name = decode_idna($rs->fields['sub_name']);
			$dmn_menu_name = decode_idna($dmn_name);
			$tpl->assign(
				array(
					'SUB_ID' => $rs->fields['sub_name'],
					'SUB_SELECTED' => $sub_selected,
					'SUB_NAME' => $sub_menu_name . '.' . $dmn_menu_name
				)
			);
			$tpl->parse('SUB_LIST', '.sub_list');
			$rs->MoveNext();
			if (!$first_passed) $first_passed = true;
		}
	}
}

function get_ftp_user_gid(&$sql, $dmn_name, $ftp_user) {
	global $last_gid;
	global $max_gid;

	$query = "SELECT `gid`, `members` FROM `ftp_group` WHERE `groupname` = ?";

	$rs = exec_query($sql, $query, array($dmn_name));

	if ($rs->RecordCount() == 0) { // there is no such group. we'll need a new one.
		list($temp_dmn_id,
			$temp_dmn_name,
			$temp_dmn_gid,
			$temp_dmn_uid,
			$temp_dmn_created_id,
			$temp_dmn_created,
			$temp_dmn_last_modified,
			$temp_dmn_mailacc_limit,
			$temp_dmn_ftpacc_limit,
			$temp_dmn_traff_limit,
			$temp_dmn_sqld_limit,
			$temp_dmn_sqlu_limit,
			$temp_dmn_status,
			$temp_dmn_als_limit,
			$temp_dmn_subd_limit,
			$temp_dmn_ip_id,
			$temp_dmn_disk_limit,
			$temp_dmn_disk_usage,
			$temp_dmn_php,
			$temp_dmn_cgi) = get_domain_default_props($sql, $_SESSION['user_id']);

		$query = <<<SQL_QUERY
			INSERT INTO ftp_group
				(`groupname`, `gid`, `members`)
			VALUES
				(?, ?, ?)
SQL_QUERY;

		$rs = exec_query($sql, $query, array($dmn_name, $temp_dmn_gid, $ftp_user));
		// add entries in the quota tables
		// first check if we have it by one or other reason
		$query = "SELECT COUNT(`name`) as cnt FROM `quotalimits` WHERE `name` = ?";
		$rs = exec_query($sql, $query, array($temp_dmn_name));
		if ($rs->fields['cnt'] == 0) {
			// ok insert it
			if ($temp_dmn_disk_limit == 0) {
				$dlim = 0;
			} else {
				$dlim = $temp_dmn_disk_limit * 1024 * 1024;
			}

			$query = <<<SQL_QUERY
				INSERT INTO `quotalimits`
					(`name`, `quota_type`, `per_session`, `limit_type`,
					`bytes_in_avail`, `bytes_out_avail`, `bytes_xfer_avail`,
					`files_in_avail`, `files_out_avail`, `files_xfer_avail`)
				VALUES
					(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
SQL_QUERY;

			$rs = exec_query($sql, $query, array($temp_dmn_name, 'group', 'false', 'hard', $dlim, 0, 0, 0, 0, 0));
		}

		return $temp_dmn_gid;
	} else {
		$ftp_gid = $rs->fields['gid'];
		$members = $rs->fields['members'];

		if (preg_match("/" . $ftp_user . "/", $members) == 0) {
			$members .= ",$ftp_user";
		}

		$query = <<<SQL_QUERY
			UPDATE
				`ftp_group`
			SET
				`members` = ?
			WHERE
				`gid` = ?
			AND
				`groupname` = ?
SQL_QUERY;

		$rs = exec_query($sql, $query, array($members, $ftp_gid, $dmn_name));
		return $ftp_gid;
	}
}

function get_ftp_user_uid(&$sql, $dmn_name, $ftp_user, $ftp_user_gid) {
	global $max_uid;

	$query = <<<SQL_QUERY
		SELECT
			`uid`
		FROM
			`ftp_users`
		WHERE
			`userid` = ?
		AND
			`gid` = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($ftp_user, $ftp_user_gid));
	if ($rs->RecordCount() > 0) {
		set_page_message(tr('FTP account already exists!'));
		return -1;
	}

	list($temp_dmn_id,
		$temp_dmn_name,
		$temp_dmn_gid,
		$temp_dmn_uid,
		$temp_dmn_created_id,
		$temp_dmn_created,
		$temp_dmn_last_modified,
		$temp_dmn_mailacc_limit,
		$temp_dmn_ftpacc_limit,
		$temp_dmn_traff_limit,
		$temp_dmn_sqld_limit,
		$temp_dmn_sqlu_limit,
		$temp_dmn_status,
		$temp_dmn_als_limit,
		$temp_dmn_subd_limit,
		$temp_dmn_ip_id,
		$temp_dmn_disk_limit,
		$temp_dmn_disk_usage,
		$temp_dmn_php,
		$temp_dmn_cgi) = get_domain_default_props($sql, $_SESSION['user_id']);

	return $temp_dmn_uid;
}

function add_ftp_user(&$sql, $dmn_name) {
	$username = strtolower(clean_input($_POST['username']));
	$res_uname = preg_match("/\./", $username, $match);
	if ($res_uname == 1) {
		set_page_message(tr("Incorrect username length or syntax!"));
		return;
	}

	if (!chk_username($username)) {
		set_page_message(tr("Incorrect username length or syntax!"));
		return;
	}
	// Set default values ($ftp_home may be overwritten if user
	// has specified a mount point)
	switch ($_POST['dmn_type']) {
		// Default moint point for a domain
		case 'dmn':
			$ftp_user = $username . Config::get('FTP_USERNAME_SEPARATOR') . $dmn_name;
			$ftp_home = Config::get('FTP_HOMEDIR') . "/$dmn_name";
			break;
		// Default mount point for an alias domain
		case 'als':
			$ftp_user = $username . Config::get('FTP_USERNAME_SEPARATOR') . $_POST['als_id'];
			$alias_mount_point = get_alias_mount_point($sql, $_POST['als_id']);
			$ftp_home = Config::get('FTP_HOMEDIR') . "/$dmn_name" . $alias_mount_point;
			break;
		// Default mount point for a subdomain
		case 'sub':
			$ftp_user = $username . Config::get('FTP_USERNAME_SEPARATOR') . $_POST['sub_id'] . '.' . $dmn_name;
			$ftp_home = Config::get('FTP_HOMEDIR') . "/$dmn_name/" . clean_input($_POST['sub_id']);
			break;
		// Unknown domain type (?)
		default:
			set_page_message(tr('Unknown domain type'));
			return;
			break;
	}
	// User-specified mount point
	if (isset($_POST['use_other_dir']) && $_POST['use_other_dir'] === 'on') {
		$ftp_vhome = clean_input($_POST['other_dir'], false);
		// Strip possible double-slashes
		$ftp_vhome = str_replace('//', '/', $ftp_vhome);
		// Check for updirs ".."
		$res = preg_match("/\.\./", $ftp_vhome);
		if ($res !== 0) {
			set_page_message(tr('Incorrect mount point length or syntax'));
			return;
		}
		$ftp_home = Config::get('FTP_HOMEDIR') . "/$dmn_name/" . $ftp_vhome;
		// Strip possible double-slashes
		$ftp_home = str_replace('//', '/', $ftp_home);
		// Check for $ftp_vhome existence
		// Create a virtual filesystem (it's important to use =&!)
		$vfs = new vfs($dmn_name, $sql);
		// Check for directory existence
		$res = $vfs->exists($ftp_vhome);

		if (!$res) {
			set_page_message(tr('%s does not exist', $ftp_vhome));
			return;
		}
	} // End of user-specified mount-point
	$ftp_gid = get_ftp_user_gid($sql, $dmn_name, $ftp_user);
	$ftp_uid = get_ftp_user_uid($sql, $dmn_name, $ftp_user, $ftp_gid);

	if ($ftp_uid == -1) return;

	$ftp_shell = Config::get('CMD_SHELL');
	$ftp_passwd = crypt_user_pass_with_salt($_POST['pass']);

	$query = <<<SQL_QUERY
		INSERT INTO ftp_users
			(`userid`, `passwd`, `uid`, `gid`, `shell`, `homedir`)
		VALUES
			(?, ?, ?, ?, ?, ?)
SQL_QUERY;

	$rs = exec_query($sql, $query, array($ftp_user, $ftp_passwd, $ftp_uid, $ftp_gid, $ftp_shell, $ftp_home));

	$domain_props = get_domain_default_props($sql, $_SESSION['user_id']);
	update_reseller_c_props($domain_props[4]);

	write_log($_SESSION['user_logged'] . ": add new FTP account: $ftp_user");
	set_page_message(tr('FTP account added!'));
	user_goto('ftp_accounts.php');
}

function check_ftp_acc_data(&$tpl, &$sql, $dmn_id, $dmn_name) {
	if (!isset($_POST['username']) || $_POST['username'] === '') {
		set_page_message(tr('Please enter FTP account username!'));
		return;
	}

	if (!isset($_POST['pass']) || empty($_POST['pass'])
		|| !isset($_POST['pass_rep'])
		|| $_POST['pass_rep'] === '') {
		set_page_message(tr('Password data is missing!'));
		return;
	}

	if ($_POST['pass'] !== $_POST['pass_rep']) {
		set_page_message(tr('Entered passwords differ from the another!'));
		return;
	}

	if (!chk_password($_POST['pass'])) {
		if (Config::get('PASSWD_STRONG')) {
			set_page_message(sprintf(tr('The password must be at least %s long and contain letters and numbers to be valid.'), Config::get('PASSWD_CHARS')));
		} else {
			set_page_message(sprintf(tr('Password data is shorter than %s signs or includes not permitted signs!'), Config::get('PASSWD_CHARS')));
		}
		return;
	}

	if ($_POST['dmn_type'] === 'sub' && $_POST['sub_id'] === 'n/a') {
		set_page_message(tr('Subdomain list is empty! You cannot add FTP accounts there!'));
		return;
	}

	if ($_POST['dmn_type'] === 'als' && $_POST['als_id'] === 'n/a') {
		set_page_message(tr('Alias list is empty! You cannot add FTP accounts there!'));
		return;
	}

	if (isset($_POST['use_other_dir']) && $_POST['use_other_dir'] === 'on' && empty($_POST['other_dir'])) {
		set_page_message(tr('Please specify other FTP account dir!'));
		return;
	}

	add_ftp_user($sql, $dmn_name);
}

function gen_page_ftp_acc_props(&$tpl, &$sql, $user_id) {
	list($dmn_id,
		$dmn_name,
		$dmn_gid,
		$dmn_uid,
		$dmn_created_id,
		$dmn_created,
		$dmn_last_modified,
		$dmn_mailacc_limit,
		$dmn_ftpacc_limit,
		$dmn_traff_limit,
		$dmn_sqld_limit,
		$dmn_sqlu_limit,
		$dmn_status,
		$dmn_als_limit,
		$dmn_subd_limit,
		$dmn_ip_id,
		$dmn_disk_limit,
		$dmn_disk_usage,
		$dmn_php,
		$dmn_cgi) = get_domain_default_props($sql, $user_id);

	list($ftp_acc_cnt, $dmn_ftp_acc_cnt, $sub_ftp_acc_cnt, $als_ftp_acc_cnt) = get_domain_running_ftp_acc_cnt($sql, $dmn_id);

	if ($dmn_ftpacc_limit != 0 && $ftp_acc_cnt >= $dmn_ftpacc_limit) {
		set_page_message(tr('FTP accounts limit reached!'));
		user_goto('ftp_accounts.php');
	} else {
		if (!isset($_POST['uaction'])) {
			gen_page_form_data($tpl, $dmn_name, 'no');
			gen_dmn_als_list($tpl, $sql, $dmn_id, 'no');
			gen_dmn_sub_list($tpl, $sql, $dmn_id, $dmn_name, 'no');
			gen_page_js($tpl);
		} else if (isset($_POST['uaction']) && $_POST['uaction'] === 'add_user') {
			gen_page_form_data($tpl, $dmn_name, 'yes');
			gen_dmn_als_list($tpl, $sql, $dmn_id, 'yes');
			gen_dmn_sub_list($tpl, $sql, $dmn_id, $dmn_name, 'yes');
			check_ftp_acc_data($tpl, $sql, $dmn_id, $dmn_name);
		}
	}
}

function gen_page_js(&$tpl) {
	if (isset($_SESSION['subdomain_count'])
		&& isset($_SESSION['alias_count'])) { // no subdomains and no alias
		$tpl->parse('JS_NOT_DOMAIN', 'js_not_domain');
		$tpl->assign('JS_TO_SUBDOMAIN', '');
		$tpl->assign('JS_TO_ALIAS_DOMAIN', '');
		$tpl->assign('JS_TO_ALL_DOMAIN', '');
	} else if (isset($_SESSION['subdomain_count'])
		&& !isset($_SESSION['alias_count'])) { // no subdomains - alaias available
		$tpl->assign('JS_NOT_DOMAIN', '');
		$tpl->assign('JS_TO_SUBDOMAIN', '');
		$tpl->parse('JS_TO_ALIAS_DOMAIN', 'js_to_alias_domain');
		$tpl->assign('JS_TO_ALL_DOMAIN', '');
	} else if (!isset($_SESSION['subdomain_count'])
		&& isset($_SESSION['alias_count'])) { // no alias - subdomain available
		$tpl->assign('JS_NOT_DOMAIN', '');
		$tpl->parse('JS_TO_SUBDOMAIN', 'js_to_subdomain');
		$tpl->assign('JS_TO_ALIAS_DOMAIN', '');
		$tpl->assign('JS_TO_ALL_DOMAIN', '');
	} else { // there are subdomains and aliases
		$tpl->assign('JS_NOT_DOMAIN', '');
		$tpl->assign('JS_TO_SUBDOMAIN', '');
		$tpl->assign('JS_TO_ALIAS_DOMAIN', '');
		$tpl->parse('JS_TO_ALL_DOMAIN', 'js_to_all_domain');
	}

	unset($GLOBALS['subdomain_count']);
	unset($GLOBALS['alias_count']);
	unset($_SESSION['subdomain_count']);
	unset($_SESSION['alias_count']);
}

// common page data.

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_CLIENT_ADD_FTP_ACC_PAGE_TITLE' => tr('ispCP - Client/Add FTP User'),
		'THEME_COLOR_PATH' => "../themes/$theme_color",
		'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id'])
	)
);

// dynamic page data.

gen_page_ftp_acc_props($tpl, $sql, $_SESSION['user_id']);

// static page messages.

gen_client_mainmenu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/main_menu_ftp_accounts.tpl');
gen_client_menu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/menu_ftp_accounts.tpl');

gen_logged_from($tpl);

check_permissions($tpl);

$tpl->assign(
	array(
		'TR_ADD_FTP_USER' => tr('Add FTP user'),
		'TR_USERNAME' => tr('Username'),
		'TR_TO_MAIN_DOMAIN' => tr('To main domain'),
		'TR_TO_DOMAIN_ALIAS' => tr('To domain alias'),
		'TR_TO_SUBDOMAIN' => tr('To subdomain'),
		'TR_PASSWORD' => tr('Password'),
		'TR_PASSWORD_REPEAT' => tr('Repeat password'),
		'TR_USE_OTHER_DIR' => tr('Use other dir'),
		'TR_ADD' => tr('Add'),
		'CHOOSE_DIR' => tr('Choose dir'),
		'FTP_SEPARATOR' => Config::get('FTP_USERNAME_SEPARATOR')
	)
);

gen_page_message($tpl);
$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
