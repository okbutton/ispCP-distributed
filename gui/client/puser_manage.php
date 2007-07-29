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


require '../include/ispcp-lib.php';

check_login(__FILE__);

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['CLIENT_TEMPLATE_PATH'].'/puser_manage.tpl');

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('usr_msg', 'page');

$tpl -> define_dynamic('grp_msg', 'page');

$tpl -> define_dynamic('logged_from', 'page');

$tpl -> define_dynamic('pusres', 'page');

$tpl -> define_dynamic('pgroups', 'page');

$tpl -> define_dynamic('group_members', 'page');


global $cfg;
$theme_color = $cfg['USER_INITIAL_THEME'];


$tpl -> assign(
                array(
                        'TR_CLIENT_WEBTOOLS_PAGE_TITLE' => tr('ISPCP - Client/Webtools'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'), 
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE'],
						'ISP_LOGO' => get_logo($_SESSION['user_id'])
                     )
              );


function gen_pusres(&$tpl, &$sql, &$dmn_id)
{

	 $query = <<<SQL_QUERY
        SELECT
            *
        FROM
            htaccess_users
        WHERE
             dmn_id = ?
        ORDER BY
            dmn_id DESC
SQL_QUERY;

    $rs = exec_query($sql, $query, array($dmn_id));

	if ($rs -> RecordCount() == 0) {

		$tpl -> assign('PUSRES', '');
		$tpl -> assign('USER_MESSAGE', tr('You have no users!'));
		$tpl -> parse('USR_MSG', 'usr_msg');

	} else {

		$tpl -> assign('USR_MSG', '');
		while (!$rs -> EOF) {

			$status = $rs -> fields['status'];
			$tpl -> assign(
						array(
								'UNAME' => $rs -> fields['uname'],
								'USTATUS' => translate_dmn_status($status),
								'USER_ID' =>  $rs -> fields['id'],
							  )
							);


			$tpl -> parse('PUSRES', '.pusres');
			$rs -> MoveNext(); //$counter ++;

        } // end of while

	} // end of else

} // function end

function gen_pgroups(&$tpl, &$sql, &$dmn_id)
{

	 $query = <<<SQL_QUERY
        SELECT
            *
        FROM
            htaccess_groups
        WHERE
		    dmn_id = ?
        ORDER BY
            dmn_id DESC
SQL_QUERY;

    $rs = exec_query($sql, $query, array($dmn_id));

	if ($rs -> RecordCount() == 0) {

		$tpl -> assign('GROUP_MESSAGE', tr('You have no groups!'));
		$tpl -> parse('GRP_MSG', 'grp_msg');
		$tpl -> assign('PGROUPS', '');

	} else {

		$tpl -> assign('GRP_MSG', '');
		while (!$rs -> EOF) {

			$members = $rs -> fields['members'];
			$status = $rs -> fields['status'];

			$tpl -> assign(
						array(
								'GNAME' => $rs -> fields['ugroup'],
								'GSTATUS' => translate_dmn_status($status),
								'GROUP_ID' =>  $rs -> fields['id'],
							  )
							);

			if ($members == '')
			{
				$tpl -> assign('GROUP_MEMBERS', '');
			} else {

				$members = split(',', $rs -> fields['members']);

				for ($i = 0; $i < count($members); $i++) {

				$query = <<<SQL_QUERY
					select
						uname
					from
						htaccess_users
					where
						 id = ?
SQL_QUERY;

   					$rs_members = exec_query($sql, $query, array($members[$i]));


					if (count($members) == 1 || count($members) == $i+1){
						$tpl -> assign('MEMBER', $rs_members -> fields['uname']);
					} else {
						$tpl -> assign('MEMBER', $rs_members -> fields['uname'].", ");
					}

					$tpl -> parse('GROUP_MEMBERS', '.group_members');



				}

			}




			$tpl -> parse('PGROUPS', '.pgroups');
			$tpl -> assign('GROUP_MEMBERS', '');
			$rs -> MoveNext();

        } // end of while

	} // end of else

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

gen_pusres($tpl, $sql, $dmn_id);

gen_pgroups($tpl, $sql, $dmn_id);

$tpl -> assign(
                array(
						'TR_HTACCESS' => tr('Protected areas'),
						'TR_ACTION' => tr('Action'),
						'TR_USER_MANAGE' => tr('Manage user'),
						'TR_USERS' => tr('User'),
						'TR_USERNAME' => tr('Username'),
						'TR_ADD_USER' => tr('Add user'),
						'TR_GROUPNAME' => tr('Group name'),
						'TR_GROUP_MEMBERS' => tr('Group members'),
						'TR_ADD_GROUP' => tr('Add group'),
						'TR_EDIT' => tr('Edit'),
						'TR_GROUP' => tr('Group'),
						'TR_DELETE' => tr('Delete'),
						'TR_GROUPS' => tr('Groups'),
						'TR_PASSWORD' => tr('Password'),
						'TR_STATUS' => tr('Status'),
						'TR_PASSWORD_REPEAT' => tr('Repeat password'),

					  )
				);

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if ($cfg['DUMP_GUI_DEBUG']) dump_gui_debug();

unset_messages();
?>