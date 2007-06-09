<?php
/**
 *  ispCP (OMEGA) a Virtual Hosting Control System
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

/* BEGIN common functions */
function get_update_infos(&$tpl) {
	global $cfg;

	$info_url = "http://www.isp-control.net/download.html";
	$last_update = "http://isp-control.net/latest.txt";

    // Fake the browser type
    ini_set('user_agent','Mozilla/5.0');

	$dh2 = @fopen($last_update,'r');

	if (!is_resource($dh2)) {
		$tpl -> assign(array('UPDATE_INFOS' =>  '',
		                     'TR_MESSAGE'   => tr("Couldn't check for updates!")));
		$tpl -> parse('UPDATE_MESSAGE', 'update_message');
		return ;
	}

	$last_update_result = (int)fread($dh2, 8);
	fclose($dh2);

	$current_version = (int)$cfg['BuildDate'];
	if ($current_version < $last_update_result) {

	   $tpl -> assign(
				array(
						'UPDATE_MESSAGE' =>  '',
						'UPDATE' =>  tr('New ISPCP update is now available'),
						'INFOS' => tr('Get it at')." <a href=\"".$info_url."\" class=\"link\" target=\"ispcp\">".$info_url."</a>"
					 )
			  );

		$tpl -> parse('UPDATE_INFOS', 'update_infos');
	} else {
		$tpl -> assign('UPDATE_INFOS', '');

	}
}
/* END system functions */

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['ADMIN_TEMPLATE_PATH'].'/ispcp_updates.tpl');

$tpl -> define_dynamic('page_message', 'page');
$tpl -> define_dynamic('hosting_plans', 'page');

$tpl -> define_dynamic('update_message', 'page');

$tpl -> define_dynamic('update_infos', 'page');

global $cfg;
$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> assign(
                array(
                        'TR_ADMIN_ISPCP_UPDATES_PAGE_TITLE' => tr('ISPCP - Virtual Hosting Control System'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'),
                        'ISP_LOGO' => get_logo($_SESSION['user_id']),
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE']
                     )
              );




/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/main_menu_system_tools.tpl');
gen_admin_menu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/menu_system_tools.tpl');

$tpl -> assign(
        array(
                'TR_UPDATES_TITLE' => tr('ISPCP updates'),
				'TR_AVAILABLE_UPDATES' => tr('Available ISPCP updates'),
				'TR_MESSAGE' => tr('No new ISPCP updates available'),
				'TR_UPDATE' => tr('Update'),
				'TR_INFOS' => tr('Update details'),

                )
        );

gen_page_message($tpl);

get_update_infos($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if ($cfg['DUMP_GUI_DEBUG']) dump_gui_debug();

unset_messages();

?>