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
$tpl->define_dynamic('page', Config::get('ADMIN_TEMPLATE_PATH') . '/settings.tpl');
$tpl->define_dynamic('def_language', 'page');

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_ADMIN_SETTINGS_PAGE_TITLE' => tr('ispCP - Admin/Settings'),
		'THEME_COLOR_PATH' => "../themes/$theme_color",
		'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id'])
	)
);

if (isset($_POST['uaction']) && $_POST['uaction'] == 'apply') {
	$lostpassword					= $_POST['lostpassword'];
	$lostpassword_timeout			= clean_input($_POST['lostpassword_timeout']);
	$passwd_chars					= clean_input($_POST['passwd_chars']);
	$passwd_strong					= $_POST['passwd_strong'];
	$bruteforce						= $_POST['bruteforce'];
	$bruteforce_between				= $_POST['bruteforce_between'];
	$bruteforce_max_login			= clean_input($_POST['bruteforce_max_login']);
	$bruteforce_block_time			= clean_input($_POST['bruteforce_block_time']);
	$bruteforce_between_time		= clean_input($_POST['bruteforce_between_time']);
	$bruteforce_max_capcha			= clean_input($_POST['bruteforce_max_capcha']);
	$create_default_email_addresses	= $_POST['create_default_email_addresses'];
	$count_default_email_addresses	= $_POST['count_default_email_addresses'];
	$hard_mail_suspension			= $_POST['hard_mail_suspension'];
	$user_initial_lang				= $_POST['def_language'];
	$support_system					= $_POST['support_system'];
	$hosting_plan_level				= $_POST['hosting_plan_level'];
	$domain_rows_per_page			= clean_input($_POST['domain_rows_per_page']);
	$checkforupdate					= $_POST['checkforupdate'];
	$show_serverload				= $_POST['show_serverload'];
	$prevent_external_login_admin	= $_POST['prevent_external_login_admin'];
	$prevent_external_login_reseller= $_POST['prevent_external_login_reseller'];
	$prevent_external_login_client	= $_POST['prevent_external_login_client'];
	$custom_orderpanel_id			= clean_input($_POST['coid']);
	$tld_strict_validation			= $_POST['tld_strict_validation'];
	$sld_strict_validation			= $_POST['sld_strict_validation'];
	$max_dnames_labels				= clean_input($_POST['max_dnames_labels']);
	$max_subdnames_labels			= clean_input($_POST['max_subdnames_labels']);

	// change Loglevel to constant:
	switch ($_POST['log_level']) {
		case "E_USER_NOTICE":
			$log_level = E_USER_NOTICE;
			break;
		case "E_USER_WARNING":
			$log_level = E_USER_WARNING;
			break;
		case "E_USER_ERROR":
			$log_level = E_USER_ERROR;
			break;
		default:
			$log_level = E_USER_OFF;
	} // end switch

	if ((!is_number($lostpassword_timeout))
		|| (!is_number($passwd_chars))
		|| (!is_number($bruteforce_max_login))
		|| (!is_number($bruteforce_block_time))
		|| (!is_number($bruteforce_between_time))
		|| (!is_number($bruteforce_max_capcha))
		|| (!is_number($domain_rows_per_page))
		|| (!is_number($max_dnames_labels))
		|| (!is_number($max_subdnames_labels))) {
		set_page_message(tr('ERROR: Only positive numbers are allowed !'));
	} else if ($domain_rows_per_page < 1) {
		$domain_rows_per_page = 1;
	} else if ($max_dnames_labels < 1) {
		$max_dnames_labels = 1;
	} else if ($max_subdnames_labels < 1) {
		$max_subdnames_labels = 1;
	} else {
		setConfig_Value('LOSTPASSWORD', $lostpassword);
		setConfig_Value('LOSTPASSWORD_TIMEOUT', $lostpassword_timeout);
		setConfig_Value('PASSWD_CHARS', $passwd_chars);
		setConfig_Value('PASSWD_STRONG', $passwd_strong);
		setConfig_Value('BRUTEFORCE', $bruteforce);
		setConfig_Value('BRUTEFORCE_BETWEEN', $bruteforce_between);
		setConfig_Value('BRUTEFORCE_MAX_LOGIN', $bruteforce_max_login);
		setConfig_Value('BRUTEFORCE_BLOCK_TIME', $bruteforce_block_time);
		setConfig_Value('BRUTEFORCE_BETWEEN_TIME', $bruteforce_between_time);
		setConfig_Value('BRUTEFORCE_MAX_CAPTCHA', $bruteforce_max_capcha);
		setConfig_Value('CREATE_DEFAULT_EMAIL_ADDRESSES', $create_default_email_addresses);
		setConfig_Value('COUNT_DEFAULT_EMAIL_ADDRESSES', $count_default_email_addresses);
		setConfig_Value('HARD_MAIL_SUSPENSION', $hard_mail_suspension);
		setConfig_Value('USER_INITIAL_LANG', $user_initial_lang);
		setConfig_Value('ISPCP_SUPPORT_SYSTEM', $support_system);
		setConfig_Value('HOSTING_PLANS_LEVEL', $hosting_plan_level);
		setConfig_Value('DOMAIN_ROWS_PER_PAGE', $domain_rows_per_page);
		setConfig_Value('LOG_LEVEL', $log_level);
		setConfig_Value('CHECK_FOR_UPDATES', $checkforupdate);
		setConfig_Value('SHOW_SERVERLOAD', $show_serverload);
		setConfig_Value('PREVENT_EXTERNAL_LOGIN_ADMIN', $prevent_external_login_admin);
		setConfig_Value('PREVENT_EXTERNAL_LOGIN_RESELLER', $prevent_external_login_reseller);
		setConfig_Value('PREVENT_EXTERNAL_LOGIN_CLIENT', $prevent_external_login_client);
		setConfig_Value('CUSTOM_ORDERPANEL_ID', $custom_orderpanel_id);
		setConfig_Value('TLD_STRICT_VALIDATION', $tld_strict_validation);
		setConfig_Value('SLD_STRICT_VALIDATION', $sld_strict_validation);
		setConfig_Value('MAX_DNAMES_LABELS', $max_dnames_labels);
		setConfig_Value('MAX_SUBDNAMES_LABELS', $max_subdnames_labels);
		set_page_message(tr('Settings saved !'));
	}
}

$coid = Config::exists('CUSTOM_ORDERPANEL_ID') ? Config::get('CUSTOM_ORDERPANEL_ID'): '';

$tpl->assign(
	array(
		'LOSTPASSWORD_TIMEOUT_VALUE' => Config::get('LOSTPASSWORD_TIMEOUT'),
		'PASSWD_CHARS' => Config::get('PASSWD_CHARS'),
		'BRUTEFORCE_MAX_LOGIN_VALUE' => Config::get('BRUTEFORCE_MAX_LOGIN'),
		'BRUTEFORCE_BLOCK_TIME_VALUE' => Config::get('BRUTEFORCE_BLOCK_TIME'),
		'BRUTEFORCE_BETWEEN_TIME_VALUE' => Config::get('BRUTEFORCE_BETWEEN_TIME'),
		'BRUTEFORCE_MAX_CAPTCHA' => Config::get('BRUTEFORCE_MAX_CAPTCHA'),
		'DOMAIN_ROWS_PER_PAGE' => Config::get('DOMAIN_ROWS_PER_PAGE'),
		'CUSTOM_ORDERPANEL_ID' => $coid,
		'MAX_DNAMES_LABELS_VALUE' => Config::get('MAX_DNAMES_LABELS'),
		'MAX_SUBDNAMES_LABELS_VALUE' => Config::get('MAX_SUBDNAMES_LABELS')
	)
);

$language = Config::get('USER_INITIAL_LANG');
gen_def_language($tpl, $sql, $language);

if (Config::get('LOSTPASSWORD')) {
	$tpl->assign('LOSTPASSWORD_SELECTED_ON', 'selected="selected"');
	$tpl->assign('LOSTPASSWORD_SELECTED_OFF', '');
} else {
	$tpl->assign('LOSTPASSWORD_SELECTED_ON', '');
	$tpl->assign('LOSTPASSWORD_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('PASSWD_STRONG')) {
	$tpl->assign('PASSWD_STRONG_ON', 'selected="selected"');
	$tpl->assign('PASSWD_STRONG_OFF', '');
} else {
	$tpl->assign('PASSWD_STRONG_ON', '');
	$tpl->assign('PASSWD_STRONG_OFF', 'selected="selected"');
}

if (Config::get('BRUTEFORCE')) {
	$tpl->assign('BRUTEFORCE_SELECTED_ON', 'selected="selected"');
	$tpl->assign('BRUTEFORCE_SELECTED_OFF', '');
} else {
	$tpl->assign('BRUTEFORCE_SELECTED_ON', '');
	$tpl->assign('BRUTEFORCE_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('BRUTEFORCE_BETWEEN')) {
	$tpl->assign('BRUTEFORCE_BETWEEN_SELECTED_ON', 'selected="selected"');
	$tpl->assign('BRUTEFORCE_BETWEEN_SELECTED_OFF', '');
} else {
	$tpl->assign('BRUTEFORCE_BETWEEN_SELECTED_ON', '');
	$tpl->assign('BRUTEFORCE_BETWEEN_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('ISPCP_SUPPORT_SYSTEM')) {
	$tpl->assign('SUPPORT_SYSTEM_SELECTED_ON', 'selected="selected"');
	$tpl->assign('SUPPORT_SYSTEM_SELECTED_OFF', '');
} else {
	$tpl->assign('SUPPORT_SYSTEM_SELECTED_ON', '');
	$tpl->assign('SUPPORT_SYSTEM_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('TLD_STRICT_VALIDATION')) {
	$tpl->assign('TLD_STRICT_VALIDATION_ON', 'selected="selected"');
	$tpl->assign('TLD_STRICT_VALIDATION_OFF', '');
} else {
	$tpl->assign('TLD_STRICT_VALIDATION_ON', '');
	$tpl->assign('TLD_STRICT_VALIDATION_OFF', 'selected="selected"');
}

if (Config::get('SLD_STRICT_VALIDATION')) {
	$tpl->assign('SLD_STRICT_VALIDATION_ON', 'selected="selected"');
	$tpl->assign('SLD_STRICT_VALIDATION_OFF', '');
} else {
	$tpl->assign('SLD_STRICT_VALIDATION_ON', '');
	$tpl->assign('SLD_STRICT_VALIDATION_OFF', 'selected="selected"');
}

if (Config::get('CREATE_DEFAULT_EMAIL_ADDRESSES')) {
	$tpl->assign('CREATE_DEFAULT_EMAIL_ADDRESSES_ON', 'selected="selected"');
	$tpl->assign('CREATE_DEFAULT_EMAIL_ADDRESSES_OFF', '');
} else {
	$tpl->assign('CREATE_DEFAULT_EMAIL_ADDRESSES_ON', '');
	$tpl->assign('CREATE_DEFAULT_EMAIL_ADDRESSES_OFF', 'selected="selected"');
}

if (Config::get('COUNT_DEFAULT_EMAIL_ADDRESSES')) {
	$tpl->assign('COUNT_DEFAULT_EMAIL_ADDRESSES_ON', 'selected="selected"');
	$tpl->assign('COUNT_DEFAULT_EMAIL_ADDRESSES_OFF', '');
} else {
	$tpl->assign('COUNT_DEFAULT_EMAIL_ADDRESSES_ON', '');
	$tpl->assign('COUNT_DEFAULT_EMAIL_ADDRESSES_OFF', 'selected="selected"');
}

if (Config::get('HARD_MAIL_SUSPENSION')) {
	$tpl->assign('HARD_MAIL_SUSPENSION_ON', 'selected="selected"');
	$tpl->assign('HARD_MAIL_SUSPENSION_OFF', '');
} else {
	$tpl->assign('HARD_MAIL_SUSPENSION_ON', '');
	$tpl->assign('HARD_MAIL_SUSPENSION_OFF', 'selected="selected"');
}

if (Config::get('HOSTING_PLANS_LEVEL') == "admin") {
	$tpl->assign('HOSTING_PLANS_LEVEL_ADMIN', 'selected="selected"');
	$tpl->assign('HOSTING_PLANS_LEVEL_RESELLER', '');
} else {
	$tpl->assign('HOSTING_PLANS_LEVEL_ADMIN', '');
	$tpl->assign('HOSTING_PLANS_LEVEL_RESELLER', 'selected="selected"');
}

if (Config::get('CHECK_FOR_UPDATES')) {
	$tpl->assign('CHECK_FOR_UPDATES_SELECTED_ON', 'selected="selected"');
	$tpl->assign('CHECK_FOR_UPDATES_SELECTED_OFF', '');
} else {
	$tpl->assign('CHECK_FOR_UPDATES_SELECTED_ON', '');
	$tpl->assign('CHECK_FOR_UPDATES_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('SHOW_SERVERLOAD')) {
	$tpl->assign('SHOW_SERVERLOAD_SELECTED_ON', 'selected="selected"');
	$tpl->assign('SHOW_SERVERLOAD_SELECTED_OFF', '');
} else {
	$tpl->assign('SHOW_SERVERLOAD_SELECTED_ON', '');
	$tpl->assign('SHOW_SERVERLOAD_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('PREVENT_EXTERNAL_LOGIN_ADMIN')) {
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_ADMIN_SELECTED_ON', 'selected="selected"');
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_ADMIN_SELECTED_OFF', '');
} else {
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_ADMIN_SELECTED_ON', '');
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_ADMIN_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('PREVENT_EXTERNAL_LOGIN_RESELLER')) {
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_RESELLER_SELECTED_ON', 'selected="selected"');
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_RESELLER_SELECTED_OFF', '');
} else {
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_RESELLER_SELECTED_ON', '');
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_RESELLER_SELECTED_OFF', 'selected="selected"');
}

if (Config::get('PREVENT_EXTERNAL_LOGIN_CLIENT')) {
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_CLIENT_SELECTED_ON', 'selected="selected"');
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_CLIENT_SELECTED_OFF', '');
} else {
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_CLIENT_SELECTED_ON', '');
	$tpl->assign('PREVENT_EXTERNAL_LOGIN_CLIENT_SELECTED_OFF', 'selected="selected"');
}

switch (Config::get('LOG_LEVEL')) {
	case E_USER_OFF:
		$tpl->assign('LOG_LEVEL_SELECTED_OFF', 'selected="selected"');
		$tpl->assign('LOG_LEVEL_SELECTED_NOTICE', '');
		$tpl->assign('LOG_LEVEL_SELECTED_WARNING', '');
		$tpl->assign('LOG_LEVEL_SELECTED_ERROR', '');
		break;
	case E_USER_NOTICE:
		$tpl->assign('LOG_LEVEL_SELECTED_OFF', '');
		$tpl->assign('LOG_LEVEL_SELECTED_NOTICE', 'selected="selected"');
		$tpl->assign('LOG_LEVEL_SELECTED_WARNING', '');
		$tpl->assign('LOG_LEVEL_SELECTED_ERROR', '');
		break;
	case E_USER_WARNING:
		$tpl->assign('LOG_LEVEL_SELECTED_OFF', '');
		$tpl->assign('LOG_LEVEL_SELECTED_NOTICE', '');
		$tpl->assign('LOG_LEVEL_SELECTED_WARNING', 'selected="selected"');
		$tpl->assign('LOG_LEVEL_SELECTED_ERROR', '');
		break;
	default:
		$tpl->assign('LOG_LEVEL_SELECTED_OFF', '');
		$tpl->assign('LOG_LEVEL_SELECTED_NOTICE', '');
		$tpl->assign('LOG_LEVEL_SELECTED_WARNING', '');
		$tpl->assign('LOG_LEVEL_SELECTED_ERROR', 'selected="selected"');
} // end switch

/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, Config::get('ADMIN_TEMPLATE_PATH') . '/main_menu_settings.tpl');
gen_admin_menu($tpl, Config::get('ADMIN_TEMPLATE_PATH') . '/menu_settings.tpl');

$tpl->assign(
	array(
		'TR_GENERAL_SETTINGS'				=> tr('General settings'),
		'TR_SETTINGS'						=> tr('Settings'),
		'TR_MESSAGE'						=> tr('Message'),
		'TR_LOSTPASSWORD'					=> tr('Lost password'),
		'TR_LOSTPASSWORD_TIMEOUT'			=> tr('Activation link expire time (minutes)'),
		'TR_PASSWORD_SETTINGS'				=> tr('Password settings') ,
		'TR_PASSWD_STRONG'					=> tr('Use strong Passwords') ,
		'TR_PASSWD_CHARS'					=> tr('Password length'),
		'TR_BRUTEFORCE'						=> tr('Bruteforce detection'),
		'TR_BRUTEFORCE_BETWEEN'				=> tr('Block time between logins'),
		'TR_BRUTEFORCE_MAX_LOGIN'			=> tr('Max number of login attempts'),
		'TR_BRUTEFORCE_BLOCK_TIME'			=> tr('Blocktime (minutes)'),
		'TR_BRUTEFORCE_BETWEEN_TIME'		=> tr('Block time between logins (seconds)'),
		'TR_BRUTEFORCE_MAX_CAPTCHA'			=> tr('Max number of CAPTCHA validation attempts'),
		'TR_OTHER_SETTINGS'					=> tr('Other settings'),
		'TR_MAIL_SETTINGS'					=> tr('E-Mail settings'),
		'TR_CREATE_DEFAULT_EMAIL_ADDRESSES'	=> tr('Create default E-Mail addresses'),
		'TR_COUNT_DEFAULT_EMAIL_ADDRESSES'	=> tr('Count default E-Mail addresses'),
		'TR_HARD_MAIL_SUSPENSION'			=> tr('E-Mail accounts are hard suspended'),
		'TR_USER_INITIAL_LANG'				=> tr('Panel default language'),
		'TR_SUPPORT_SYSTEM'					=> tr('Support system'),
		'TR_ENABLED'						=> tr('Enabled'),
		'TR_DISABLED'						=> tr('Disabled'),
		'TR_APPLY_CHANGES'					=> tr('Apply changes'),
		'TR_SERVERPORTS'					=> tr('Server ports'),
		'TR_HOSTING_PLANS_LEVEL'			=> tr('Hosting plans available for'),
		'TR_ADMIN'							=> tr('Admin'),
		'TR_RESELLER'						=> tr('Reseller'),
		'TR_DOMAIN_ROWS_PER_PAGE'			=> tr('Domains per page'),
		'TR_LOG_LEVEL'						=> tr('Log Level'),
		'TR_E_USER_OFF' 					=> tr('Disabled'),
		'TR_E_USER_NOTICE' 					=> tr('Notices, Warnings and Errors'),
		'TR_E_USER_WARNING' 				=> tr('Warnings and Errors'),
		'TR_E_USER_ERROR' 					=> tr('Errors'),
		'TR_CHECK_FOR_UPDATES' 				=> tr('Check for update'),
		'TR_SHOW_SERVERLOAD' 				=> tr('Show server load'),
		'TR_PREVENT_EXTERNAL_LOGIN_ADMIN' 	=> tr('Prevent external login for admins'),
		'TR_PREVENT_EXTERNAL_LOGIN_RESELLER' => tr('Prevent external login for resellers'),
		'TR_PREVENT_EXTERNAL_LOGIN_CLIENT' 	=> tr('Prevent external login for clients'),
		'TR_CUSTOM_ORDERPANEL_ID' 			=> tr('Custom orderpanel ID'),
		'TR_DNAMES_VALIDATION_SETTINGS' 	=> tr('Domain names validation'),
		'TR_TLD_STRICT_VALIDATION' 			=> tr('Top Level Domain name strict validation'),
		'TR_TLD_STRICT_VALIDATION_HELP'		=> tr('Only Top Level Domains (TLD) listed in IANA root zone database can be used.'),
		'TR_SLD_STRICT_VALIDATION' 			=> tr('Second Level Domain name strict validation'),
		'TR_SLD_STRICT_VALIDATION_HELP'		=> tr('Single letter Second Level Domains (SLD) are not allowed under the most Top Level Domains (TLD). There is a small list of exceptions, e.g. the TLD .de.'),
		'TR_MAX_DNAMES_LABELS' 				=> tr('Maximal number of labels for domain names<br />(<i>Excluding SLD & TLD</i>)'),
		'TR_MAX_SUBDNAMES_LABELS' 			=> tr('Maximal number of labels for subdomains')
	)
);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
