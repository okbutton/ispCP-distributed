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

$tpl -> define_dynamic('page', $cfg['CLIENT_TEMPLATE_PATH'].'/cronjobs_overview.tpl');

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('logged_from', 'page');

$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> define_dynamic('cronjobs', 'page');

$tpl -> assign(
                array(
                        'TR_CLIENT_CRONJOBS_TITLE' => tr('ISPCP - Client/Cronjob Manager'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'), 
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE'],
						'ISP_LOGO' => get_logo($_SESSION['user_id'])
                     )
              );

/*
Functions start
*/
function gen_cron_jobs(&$tpl, &$sql, $user_id)
{

} // End of gen_cron_job();

/*
Functions end
*/


/*
 *
 * static page messages.
 *
 */

gen_client_mainmenu($tpl, $cfg['CLIENT_TEMPLATE_PATH'].'/main_menu_webtools.tpl');
gen_client_menu($tpl, $cfg['CLIENT_TEMPLATE_PATH'].'/menu_webtools.tpl');

gen_logged_from($tpl);

check_permissions($tpl);

gen_cron_jobs($tpl, $sql, $_SESSION['user_id']);

$tpl -> assign(
                array('TR_CRON_MANAGER' => tr('Cronjob Manager'),
						'TR_MESSAGE_DELETE' => tr('Are you sure you want to delete'),
						'TR_CRONJOBS' => tr('Cronjobs'),
						'TR_ACTIVE' => tr('Active'),
						'TR_ACTION' => tr('Active'),
						'TR_EDIT' => tr('Edit'),
						'TR_DELETE' => tr('Delete'),
						'TR_ADD' => tr('Add Cronjob'),

                     )
              );

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if ($cfg['DUMP_GUI_DEBUG']) dump_gui_debug();

unset_messages();
?>