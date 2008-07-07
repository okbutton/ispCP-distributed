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

if (Config::exists('HOSTING_PLANS_LEVEL') && strtolower(Config::get('HOSTING_PLANS_LEVEL')) == 'admin') {
	Header("Location: hosting_plan.php");
	die();
}

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::get('RESELLER_TEMPLATE_PATH') . '/ahp.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
		array(
			'TR_RESELLER_MAIN_INDEX_PAGE_TITLE' => tr('ispCP - Reseller/Add hosting plan'),
			'THEME_COLOR_PATH' => "../themes/$theme_color",
			'THEME_CHARSET' => tr('encoding'),
			'ISP_LOGO' => get_logo($_SESSION['user_id'])
			)
		);

/*
 *
 * static page messages.
 *
 */

gen_reseller_mainmenu($tpl, Config::get('RESELLER_TEMPLATE_PATH') . '/main_menu_hp.tpl');
gen_reseller_menu($tpl, Config::get('RESELLER_TEMPLATE_PATH') . '/menu_hp.tpl');

gen_logged_from($tpl);

$tpl->assign(
		array(
			'TR_ADD_HOSTING_PLAN' => tr('Add hosting plan'),
			'TR_HOSTING PLAN PROPS' => tr('Hosting plan properties'),
			'TR_TEMPLATE_NAME' => tr('Template name'),
			'TR_MAX_SUBDOMAINS' => tr('Max subdomains<br><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_ALIASES' => tr('Max aliases<br><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_MAILACCOUNTS' => tr('Mail accounts limit<br><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_FTP' => tr('FTP accounts limit<br><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_SQL' => tr('SQL databases limit<br><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_SQL_USERS' => tr('SQL users limit<br><i>(-1 disabled, 0 unlimited)</i>'),
			'TR_MAX_TRAFFIC' => tr('Traffic limit [MB]<br><i>(0 unlimited)</i>'),
			'TR_DISK_LIMIT' => tr('Disk limit [MB]<br><i>(0 unlimited)</i>'),
			'TR_PHP' => tr('PHP'),
			'TR_CGI' => tr('CGI / Perl'),
			'TR_BACKUP_RESTORE' => tr('Backup and restore'),
			'TR_APACHE_LOGS' => tr('Apache logfiles'),
			'TR_AWSTATS' => tr('AwStats'),
			'TR_YES' => tr('yes'),
			'TR_NO' => tr('no'),
			'TR_BILLING_PROPS' => tr('Billing Settings'),
			'TR_PRICE' => tr('Price'),
			'TR_SETUP_FEE' => tr('Setup fee'),
			'TR_VALUE' => tr('Currency'),
			'TR_PAYMENT' => tr('Payment period'),
			'TR_STATUS' => tr('Available for purchasing'),
			'TR_TEMPLATE_DESCRIPTON' => tr('Description'),
			'TR_EXAMPLE' => tr('(e.g. EUR)'),
			'TR_ADD_PLAN' => tr('Add plan')
			)
		);

if (isset($_POST['uaction']) && ('add_plan' === $_POST['uaction'])) {
	// Process data
	if (check_data_correction($tpl))
		save_data_to_db($tpl, $_SESSION['user_id']);

	gen_data_ahp_page($tpl);
} else {
	gen_empty_ahp_page($tpl);
}

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG')) dump_gui_debug();

// Function definitions

// Generate empty form
function gen_empty_ahp_page(&$tpl) {
	$tpl->assign(
			array(
				'HP_NAME_VALUE' => '',
				'TR_MAX_SUB_LIMITS' => '',
				'TR_MAX_ALS_VALUES' => '',
				'HP_MAIL_VALUE' => '',
				'HP_FTP_VALUE' => '',
				'HP_SQL_DB_VALUE' => '',
				'HP_SQL_USER_VALUE' => '',
				'HP_TRAFF_VALUE' => '',
				'HP_PRICE' => '',
				'HP_SETUPFEE' => '',
				'HP_VELUE' => '',
				'HP_PAYMENT' => '',
				'HP_DESCRIPTION_VALUE' => '',
		'TR_STATUS_YES'			=> '',
		'TR_STATUS_NO'			=> 'checked',
		'TR_PHP_YES'			=> '',
		'TR_PHP_NO'				=> 'checked',
		'TR_CGI_YES'			=> '',
		'TR_CGI_NO'				=> 'checked',
		'HP_DISK_VALUE'			=> ''
	));
	$tpl->assign('MESSAGE', '');
} // End of gen_empty_hp_page()

// Show last entered data for new hp
function gen_data_ahp_page(&$tpl) {
	global $hp_name, $description, $hp_php, $hp_cgi;
	global $hp_sub, $hp_als, $hp_mail;
	global $hp_ftp, $hp_sql_db, $hp_sql_user;
	global $hp_traff, $hp_disk;
	global $price, $setup_fee, $value, $payment, $status;

	$tpl->assign(
			array(
				'HP_NAME_VALUE' => $hp_name,
				'TR_MAX_SUB_LIMITS' => $hp_sub,
				'TR_MAX_ALS_VALUES' => $hp_als,
				'HP_MAIL_VALUE' => $hp_mail,
				'HP_FTP_VALUE' => $hp_ftp,
				'HP_SQL_DB_VALUE' => $hp_sql_db,
				'HP_SQL_USER_VALUE' => $hp_sql_user,
				'HP_TRAFF_VALUE' => $hp_traff,
				'HP_DISK_VALUE' => $hp_disk,
				'HP_DESCRIPTION_VALUE' => $description,
				'HP_PRICE' => $price,
				'HP_SETUPFEE' => $setup_fee,
				'HP_VELUE' => $value,
				'HP_PAYMENT' => $payment
				)
			);

	if ('_yes_' === $hp_php) {
		$tpl->assign(array('TR_PHP_YES' => 'checked'));
	} else {
		$tpl->assign(array('TR_PHP_NO' => 'checked'));
	}
	if ('_yes_' === $hp_cgi) {
		$tpl->assign(
			array('TR_CGI_YES' => 'checked'));
	} else {
		$tpl->assign(array('TR_CGI_NO' => 'checked'));
	}
	if ($status == 1) {
		$tpl->assign(array('TR_STATUS_YES' => 'checked'));
	} else
		$tpl->assign(array('TR_STATUS_NO' => 'checked'));
} // End of gen_data_ahp_page()

// Check correction of input data
function check_data_correction(&$tpl) {
	global $hp_name, $description, $hp_php, $hp_cgi;
	global $hp_sub, $hp_als, $hp_mail;
	global $hp_ftp, $hp_sql_db, $hp_sql_user;
	global $hp_traff, $hp_disk;
	global $price, $setup_fee, $value, $payment, $status;

	$ahp_error = "_off_";

	$hp_name = clean_input($_POST['hp_name']);
	$hp_sub = clean_input($_POST['hp_sub']);
	$hp_als = clean_input($_POST['hp_als']);
	$hp_mail = clean_input($_POST['hp_mail']);
	$hp_ftp = clean_input($_POST['hp_ftp']);
	$hp_sql_db = clean_input($_POST['hp_sql_db']);
	$hp_sql_user = clean_input($_POST['hp_sql_user']);
	$hp_traff = clean_input($_POST['hp_traff']);
	$hp_disk = clean_input($_POST['hp_disk']);
	$description = clean_input($_POST['hp_description']);

	if (empty($_POST['hp_price'])) {
		$price = 0;
	} else {
		$price = clean_input($_POST['hp_price']);
	}
	if (empty($_POST['hp_setupfee'])) {
		$setup_fee = 0;
	} else {
		$setup_fee = clean_input($_POST['hp_setupfee']);
	}

	$value = clean_input($_POST['hp_value']);
	$payment = clean_input($_POST['hp_payment']);
	$status = $_POST['status'];

	if (isset($_POST['php']))
		$hp_php = $_POST['php'];

	if (isset($_POST['cgi']))
		$hp_cgi = $_POST['cgi'];;

	if ($hp_name == '') {
		$ahp_error = tr('Incorrect template name length!');
	}

	if ($description == '') {
		$ahp_error = tr('Incorrect template description length!');
	}
	if (!is_numeric($price)) {
		$ahp_error = tr('Price must be a number!');
	}

	if (!is_numeric($setup_fee)) {
		$ahp_error = tr('Setup fee must be a number!');
	}

	if (!ispcp_limit_check($hp_sub, -1)) {
		$ahp_error = tr('Incorrect subdomains limit!');
	} else if (!ispcp_limit_check($hp_als, -1)) {
		$ahp_error = tr('Incorrect aliases limit!');
	} else if (!ispcp_limit_check($hp_mail, -1)) {
		$ahp_error = tr('Incorrect mail accounts limit!');
	} else if (!ispcp_limit_check($hp_ftp, -1)) {
		$ahp_error = tr('Incorrect FTP accounts limit!');
	} else if (!ispcp_limit_check($hp_sql_user, -1)) {
		$ahp_error = tr('Incorrect SQL databases limit!');
	} else if (!ispcp_limit_check($hp_sql_db, -1)) {
		$ahp_error = tr('Incorrect SQL users limit!');
	} else if (!ispcp_limit_check($hp_traff, null)) {
		$ahp_error = tr('Incorrect traffic limit!');
	} else if (!ispcp_limit_check($hp_disk, null)) {
		$ahp_error = tr('Incorrect disk quota limit!');
	}

	if ($ahp_error == '_off_') {
		$tpl->assign('MESSAGE', '');
		return true;
	} else {
		set_page_message($ahp_error);
		// $tpl -> assign('MESSAGE', $ahp_error);
		return false;
	}
} // End of check_data_correction()

// Add new host plan to DB
function save_data_to_db(&$tpl, $admin_id){
	$sql = Database::getInstance();
	global $hp_name, $description, $hp_php, $hp_cgi;
	global $hp_sub, $hp_als, $hp_mail;
	global $hp_ftp, $hp_sql_db, $hp_sql_user;
	global $hp_traff, $hp_disk;
	global $price, $setup_fee, $value, $payment, $status;

	$err_msg = "";
	$query = "select id from hosting_plans where name = ? and reseller_id = ?";
	$res = exec_query($sql, $query, array($hp_name, $admin_id));

	if ($res->RowCount() == 1) {
		$tpl->assign('MESSAGE', tr('Hosting plan with entered name already exists!'));
		// $tpl -> parse('AHP_MESSAGE', 'ahp_message');
	} else {
		$hp_props = "$hp_php;$hp_cgi;$hp_sub;$hp_als;$hp_mail;$hp_ftp;$hp_sql_db;$hp_sql_user;$hp_traff;$hp_disk;";
		// this id is just for fake and is not used in reseller_limits_check.
		$hpid = 0;

		if (reseller_limits_check($sql, $err_msg, $admin_id, $hpid, $hp_props)) {
			if (!empty($err_msg)) {
				set_page_message($err_msg);
				return false;
			} else {
				$query = <<<SQL_QUERY
        insert into
            hosting_plans(reseller_id,
							name,
							description,
							props,
							price,
							setup_fee,
							value,
							payment,
							status)
        values (?, ?, ?, ?, ?, ?, ?, ?, ?)
SQL_QUERY;
				$res = exec_query($sql, $query, array($admin_id, $hp_name, $description, $hp_props, $price, $setup_fee, $value, $payment, $status));

				$_SESSION['hp_added'] = '_yes_';
				header("Location: hosting_plan.php");
				die();
			}
		}
		else {
			set_page_message(tr("Hosting plan values exceed reseller maximum values!"));
			return false;
		}
	}
} //End of save_data_to_db()

?>