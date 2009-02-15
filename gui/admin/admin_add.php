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
$tpl->define_dynamic('page', Config::get('ADMIN_TEMPLATE_PATH') . '/admin_add.tpl');
$tpl->define_dynamic('page_message', 'page');

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
		array(
			'TR_ADMIN_ADD_USER_PAGE_TITLE' => tr('ispCP - Admin/Manage users/Add User'),
			'THEME_COLOR_PATH' => "../themes/$theme_color",
			'THEME_CHARSET' => tr('encoding'),
			'ISP_LOGO' => get_logo($_SESSION['user_id'])
		)
	);

function add_user(&$tpl, &$sql) {
	if (isset($_POST['uaction']) && $_POST['uaction'] === 'add_user') {
		if (check_user_data()) {
			$upass = crypt_user_pass($_POST['pass']);

			$user_id = $_SESSION['user_id'];

			$username = clean_input($_POST['username']);
			$fname = clean_input($_POST['fname']);
			$lname = clean_input($_POST['lname']);
			$gender = clean_input($_POST['gender']);
			$firm = clean_input($_POST['firm']);
			$zip = clean_input($_POST['zip']);
			$city = clean_input($_POST['city']);
			$country = clean_input($_POST['country']);
			$email = clean_input($_POST['email']);
			$phone = clean_input($_POST['phone']);
			$fax = clean_input($_POST['fax']);
			$street1 = clean_input($_POST['street1']);
			$street2 = clean_input($_POST['street2']);

			if (get_gender_by_code($gender, true) === null) {
				$gender = '';
			}

			$query = <<<SQL_QUERY
                    insert into
                            admin
                            (
                                admin_name,
                                admin_pass,
                                admin_type,
                                domain_created,
                                created_by,
                                fname,
                                lname,
                                firm,
                                zip,
                                city,
                                country,
                                email,
                                phone,
                                fax,
                                street1,
                                street2,
                                gender
                            )
                            values
                            (
                                ?,
                                ?,
                                'admin',
                                unix_timestamp(),
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?,
                                ?
                            )
SQL_QUERY;

			$rs = exec_query($sql, $query, array($username,
					$upass,
					$user_id,
					$fname,
					$lname,
					$firm,
					$zip,
					$city,
					$country,
					$email,
					$phone,
					$fax,
					$street1,
					$street2,
					$gender));

			$new_admin_id = $sql->Insert_ID();

			$user_logged = $_SESSION['user_logged'];

			write_log("$user_logged: add admin: $username");

			$user_def_lang = $_SESSION['user_def_lang'];
			$user_theme_color = $_SESSION['user_theme'];
			$user_logo = 0;

			$query = <<<SQL_QUERY
                    insert into
                        user_gui_props
                            (
                                user_id,
                                lang,
                                layout,
                                logo
                            )
                        values
                            (
                              ?,?,?,?
                            )
SQL_QUERY;

			$rs = exec_query($sql, $query, array($new_admin_id,
					$user_def_lang,
					$user_theme_color,
					$user_logo));

			send_add_user_auto_msg ($user_id,
				clean_input($_POST['username']),
				clean_input($_POST['pass']),
				clean_input($_POST['email']),
				clean_input($_POST['fname']),
				clean_input($_POST['lname']),
				tr('Administrator'),
				$gender
				);

			$_SESSION['user_added'] = 1;

			header("Location: manage_users.php");
			die();
		} //check user data
		else {
			$tpl->assign(
					array(
						'EMAIL' => clean_input($_POST['email']),
						'USERNAME' => clean_input($_POST['username']),
						'FIRST_NAME' => clean_input($_POST['fname']),
						'LAST_NAME' => clean_input($_POST['lname']),
						'FIRM' => clean_input($_POST['firm']),
						'ZIP' => clean_input($_POST['zip']),
						'CITY' => clean_input($_POST['city']),
						'COUNTRY' => clean_input($_POST['country']),
						'STREET_1' => clean_input($_POST['street1']),
						'STREET_2' => clean_input($_POST['street2']),
						'PHONE' => clean_input($_POST['phone']),
						'FAX' => clean_input($_POST['fax']),
						'VL_MALE' => (($_POST['gender'] == 'M') ? 'selected="selected"' : ''),
						'VL_FEMALE' => (($_POST['gender'] == 'F') ? 'selected="selected"' : ''),
						'VL_UNKNOWN' => ((($_POST['gender'] == 'U') || (empty($_POST['gender']))) ? 'selected="selected"' : '')
					)
				);
		}
	} else {
		$tpl->assign(
				array(
					'EMAIL' => '',
					'USERNAME' => '',
					'FIRST_NAME' => '',
					'LAST_NAME' => '',
					'FIRM' => '',
					'ZIP' => '',
					'CITY' => '',
					'COUNTRY' => '',
					'STREET_1' => '',
					'STREET_2' => '',
					'PHONE' => '',
					'FAX' => '',
					'VL_MALE' => '',
					'VL_FEMALE' => '',
					'VL_UNKNOWN' => 'selected="selected"'
				)
			);
	} // else
}

function check_user_data() {
	$sql = Database::getInstance();

	if (!chk_username($_POST['username'])) {
		set_page_message(tr("Incorrect username length or syntax!"));

		return false;
	}
	if (!chk_password($_POST['pass'])) {
		if (Config::get('PASSWD_STRONG')) {
			set_page_message(sprintf(tr('The password must be at least %s long and contain letters and numbers to be valid.'), Config::get('PASSWD_CHARS')));
		} else {
			set_page_message(sprintf(tr('Password data is shorter than %s signs or includes not permitted signs!'), Config::get('PASSWD_CHARS')));
		}

		return false;
	}
	if ($_POST['pass'] != $_POST['pass_rep']) {
		set_page_message(tr("Entered passwords do not match!"));

		return false;
	}
	if (!chk_email($_POST['email'])) {
		set_page_message(tr("Incorrect email length or syntax!"));

		return false;
	}

	$query = <<<SQL_QUERY
        select
            admin_id
        from
            admin
        where
            admin_name = ?

SQL_QUERY;

	$username = clean_input($_POST['username']);

	$rs = exec_query($sql, $query, array($username));

	if ($rs->RecordCount() != 0) {
		set_page_message(tr('This user name already exist!'));

		return false;
	}

	return true;
}

/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, Config::get('ADMIN_TEMPLATE_PATH') . '/main_menu_users_manage.tpl');
gen_admin_menu($tpl, Config::get('ADMIN_TEMPLATE_PATH') . '/menu_users_manage.tpl');

add_user($tpl, $sql);

$tpl->assign(
		array(
			'TR_EMPTY_OR_WORNG_DATA' => tr('Empty data or wrong field!'),
			'TR_PASSWORD_NOT_MATCH' => tr("Passwords don't match!"),
			'TR_ADD_ADMIN' => tr('Add admin'),
			'TR_CORE_DATA' => tr('Core data'),
			'TR_USERNAME' => tr('Username'),
			'TR_PASSWORD' => tr('Password'),
			'TR_PASSWORD_REPEAT' => tr('Repeat password'),
			'TR_EMAIL' => tr('Email'),
			'TR_ADDITIONAL_DATA' => tr('Additional data'),
			'TR_FIRST_NAME' => tr('First name'),
			'TR_LAST_NAME' => tr('Last name'),
			'TR_GENDER' => tr('Gender'),
			'TR_MALE' => tr('Male'),
			'TR_FEMALE' => tr('Female'),
			'TR_UNKNOWN' => tr('Unknown'),
			'TR_COMPANY' => tr('Company'),
			'TR_ZIP_POSTAL_CODE' => tr('Zip/Postal code'),
			'TR_CITY' => tr('City'),
			'TR_COUNTRY' => tr('Country'),
			'TR_STREET_1' => tr('Street 1'),
			'TR_STREET_2' => tr('Street 2'),
			'TR_PHONE' => tr('Phone'),
			'TR_FAX' => tr('Fax'),
			'TR_PHONE' => tr('Phone'),
			'TR_ADD' => tr('Add'),
			'GENPAS' => passgen()
		)

	);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG'))
	dump_gui_debug();

unset_messages();

?>