<?php
//   -------------------------------------------------------------------------------
//  |             VHCS(tm) - Virtual Hosting Control System                         |
//  |              Copyright (c) 2001-2005 by moleSoftware		            		|
//  |			http://vhcs.net | http://www.molesoftware.com		           		|
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the MPL General Public License                   |
//  | as published by the Free Software Foundation; either version 1.1              |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//  | You should have received a copy of the MPL Mozilla Public License             |
//  | along with this program; if not, write to the Open Source Initiative (OSI)    |
//  | http://opensource.org | osi@opensource.org								    |
//  |                                                                               |
//   -------------------------------------------------------------------------------



include '../include/vhcs-lib.php';

check_login();

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['ADMIN_TEMPLATE_PATH'].'/change_password.tpl');

$tpl -> define_dynamic('page_message', 'page');
$tpl -> define_dynamic('hosting_plans', 'page');

global $cfg;
$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> assign(
                array(
                        'TR_ADMIN_CHANGE_PASSWORD_PAGE_TITLE' => tr('VHCS - Admin/Change Password'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'),
						'ISP_LOGO' => get_logo($_SESSION['user_id']),
                        'VHCS_LICENSE' => $cfg['VHCS_LICENSE']
                     )
              );

function update_password()
{

    global $sql;

    if (isset($_POST['uaction']) && $_POST['uaction'] === 'updt_pass') {

        if ($_POST['pass'] === '' || $_POST['pass_rep'] === '' || $_POST['curr_pass'] === '') {

            set_page_message(tr('Please fill up all data fields!'));

        } else if (!vhcs_password_check($_POST['pass'], 20)) {

            set_page_message(tr('Incorrect password range or syntax!'));

        } else if ($_POST['pass'] !== $_POST['pass_rep']) {

            set_page_message(tr('Passwords does not match!'));

				} else if (check_udata($_SESSION['user_id'], $_POST['curr_pass']) === false) {

        	set_page_message(tr('The current password is wrong!'));

        } else {

            $upass = crypt_user_pass($_POST['pass']);

						$_SESSION['user_pass'] = $upass;
						
            $user_id = $_SESSION['user_id'];

            $query = <<<SQL_QUERY
                update
                    admin
                set
                    admin_pass = ?
                where
                    admin_id = ?
SQL_QUERY;
            $rs = exec_query($sql, $query, array($upass, $user_id));

            set_page_message(tr('User password updated successfully!'));


        }

    }
}

function check_udata($id, $pass) {
	global $sql;

	$query = <<<SQL_QUERY
        select
          	 admin_id, admin_pass
        from
            admin
        where
            admin_id = ?
        and
        	admin_pass = ?
SQL_QUERY;

	$query2 = <<<SQL_QUERY
        SELECT
                admin_name, admin_pass
        FROM
                admin
        WHERE
                admin_id = ?
SQL_QUERY;

  $rs = exec_query($sql, $query, array($id,md5($pass)));

  $rs2 = exec_query($sql, $query2, array($id));
  
  if ( ($rs -> RecordCount()) == 1  || crypt($pass, $udata['admin_pass']) == $udata['admin_pass'] )
        return true; else return false;
}

/*
 *
 * static page messages.
 *
 */

gen_admin_menu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/menu_general_information.tpl');

$tpl -> assign(
                array(
                       'TR_CHANGE_PASSWORD' => tr('Change password'),
                       'TR_PASSWORD_DATA' => tr('Password data'),
                       'TR_PASSWORD' => tr('Password'),
                       'TR_PASSWORD_REPEAT' => tr('Password repeat'),
                       'TR_UPDATE_PASSWORD' => tr('Update password'),
                       'TR_CURR_PASSWORD' => tr('Current password')
                     )
              );

update_password();

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if (isset($cfg['DUMP_GUI_DEBUG'])) dump_gui_debug();

unset_messages();
?>
