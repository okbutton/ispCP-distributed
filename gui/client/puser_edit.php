<?php
/**
 *  ispCP (OMEGA) - Virtual Hosting Control System | Omega Version
 *
 *  @copyright 	2001-2006 by moleSoftware GmbH
 *  @copyright 	2006-2007 by ispCP | http://isp-control.net
 *  @link 		http://isp-control.net
 *  @author		ispCP Team (2007)
 *
 *  @license
 *  This program is free software; you can redistribute it and/or modify it under
 *  the terms of the MPL General Public License as published by the Free Software
 *  Foundation; either version 1.1 of the License, or (at your option) any later
 *  version.
 *  You should have received a copy of the MPL Mozilla Public License along with
 *  this program; if not, write to the Open Source Initiative (OSI)
 *  http://opensource.org | osi@opensource.org
 **/


include '../include/ispcp-lib.php';

check_login();

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['CLIENT_TEMPLATE_PATH'].'/puser_edit.tpl');

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('usr_msg', 'page');

$tpl -> define_dynamic('grp_msg', 'page');

$tpl -> define_dynamic('logged_from', 'page');

$tpl -> define_dynamic('pusres', 'page');

$tpl -> define_dynamic('pgroups', 'page');

$theme_color = $cfg['USER_INITIAL_THEME'];


$tpl -> assign(
                array(
                        'TR_CLIENT_WEBTOOLS_PAGE_TITLE' => tr('ISPCP - Client/Webtools'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'),
						'TID' => $_SESSION['layout_id'],
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE'],
						'ISP_LOGO' => get_logo($_SESSION['user_id'])
                     )
              );


function pedit_user(&$tpl, &$sql, &$dmn_id, &$uuser_id)
{

	if(isset($_POST['uaction']) && $_POST['uaction'] == 'modify_user'){
	// we have user to add
		if(isset($_POST['pass']) && isset($_POST['pass_rep']))
		{
			
		if (chk_password($_POST['pass']) > 0) {
			set_page_message(tr('Incorrect password range or syntax!'));
			return;
		}
		if ($_POST['pass'] !== $_POST['pass_rep']){
			set_page_message(tr('Passwords does not match!'));
			return;
		}

			if (CRYPT_BLOWFISH == 1) { 
				// suhosin enables blowfish, but apache cannot crypt this, so we don't need that
				if (CRYPT_MD5 == 1) { // use md5 if available: salt is $1$.microseconds.$
					$nadmin_password = crypt($_POST['pass'], '$1$'.microtime().'$');
				} else { // else only DES encryption is used
					$nadmin_password = crypt($_POST['pass'], microtime());
				}
			} else {
				$nadmin_password = crypt($_POST['pass']);
			}

			global $cfg;
			$change_status = $cfg['ITEM_CHANGE_STATUS'];

			$query = <<<SQL_QUERY
                    update
                        htaccess_users
                    set
                        upass = ?,
                        status = ?
                    where
                        dmn_id = ?
                    and
                    	id = ?

SQL_QUERY;
			$rs = exec_query($sql, $query, array($nadmin_password, $change_status, $dmn_id, $uuser_id, ));

			// lets update htaccess to rebuild the htaccess files#
			global $cfg;
			$change_status = $cfg['ITEM_CHANGE_STATUS'];

			$query = <<<SQL_QUERY
                    update
                        htaccess
                    set
                        status = ?
                    where
                         dmn_id = ?
SQL_QUERY;
			$rs = exec_query($sql, $query, array($change_status, $dmn_id));

			check_for_lock_file();
			send_request();

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
			$uname = $rs->fields['uname'];

			$admin_login = $_SESSION['user_logged'];
			write_log("$admin_login: modify user ID (protected areas): $uname");
			header( "Location: puser_manage.php" );
			die();
		}

	} else {
		return;
	}

}


function check_get(&$get_input)
{
	if (!is_numeric($get_input)) {
		return 0;

	} else {
		return 1;
	}

}


/*
 *
 * static page messages.
 *
 */

gen_client_mainmenu($tpl, $cfg['CLIENT_TEMPLATE_PATH'].'/main_menu_webtools.tpl');
gen_client_menu($tpl, $cfg['CLIENT_TEMPLATE_PATH'].'/menu_webtools.tpl');

gen_logged_from($tpl);

check_permissions($tpl);

$dmn_id = get_user_domain_id($sql, $_SESSION['user_id']);

if (isset($_GET['uname']) && $_GET['uname'] !== '' && is_numeric($_GET['uname'])) {


$uuser_id = $_GET['uname'];

$query = <<<SQL_QUERY

        select

            uname

        from

            htaccess_users

        where

             dmn_id = '$dmn_id'

        and
			id = '$uuser_id'

SQL_QUERY;

    $rs = execute_query($sql, $query);

	if ($rs -> RecordCount() == 0) {

		header('Location: puser_manage.php');
		die();

	} else {

		$tpl -> assign(
						array(
								'UNAME' => $rs -> fields['uname'],
								'UID' => $uuser_id,
								 )
						);
	}
} else if (isset($_POST['nadmin_name']) && !empty($_POST['nadmin_name']) && is_numeric($_POST['nadmin_name'])) {

$uuser_id = clean_input($_POST['nadmin_name']);

$query = <<<SQL_QUERY

        select

            uname

        from

            htaccess_users

        where

             dmn_id = '$dmn_id'

        and
			id = '$uuser_id'

SQL_QUERY;

	$rs = execute_query($sql, $query);

	if ($rs -> RecordCount() == 0) {

		header('Location: puser_manage.php');
		die();

	} else {


		$tpl -> assign(
					array(
							'UNAME' => $rs -> fields['uname'],
							'UID' => $uuser_id,
							 )
					);


		pedit_user($tpl, $sql, $dmn_id, $uuser_id);
	}

}else {
	header('Location: puser_manage.php');
	die();
}



$tpl -> assign(
                array(
						'TR_HTACCESS' => tr('Protected areas'),
						'TR_ACTION' => tr('Action'),
						'TR_UPDATE_USER' => tr('Update user'),
						'TR_USERS' => tr('User'),
						'TR_USERNAME' => tr('Username'),
						'TR_ADD_USER' => tr('Add user'),
						'TR_GROUPNAME' => tr('Group name'),
						'TR_GROUP_MEMBERS' => tr('Group members'),
						'TR_ADD_GROUP' => tr('Add group'),
						'TR_EDIT' => tr('Edit'),
						'TR_GROUP' => tr('Group'),
						'TR_DELETE' => tr('Delete'),
						'TR_UPDATE' => tr('Modify'),
						'TR_PASSWORD' => tr('Password'),
						'TR_PASSWORD_REPEAT' => tr('Password repeat'),
						'TR_CANCEL' => tr('Cancel'),

					  )
				);

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if (isset($cfg['DUMP_GUI_DEBUG'])) dump_gui_debug();

unset_messages();
?>