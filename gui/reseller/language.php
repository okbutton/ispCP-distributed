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

$tpl -> define_dynamic('page', $cfg['RESELLER_TEMPLATE_PATH'].'/language.tpl');

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('def_language', 'page');

$tpl -> define_dynamic('logged_from', 'page');


/*
 *
 * page actions.
 *
 */

if (isset($_POST['uaction']) && $_POST['uaction'] === 'save_lang') {

    $user_id = $_SESSION['user_id'];

    $user_lang = $_POST['def_language'];

    $query = <<<SQL_QUERY
        update
            user_gui_props
        set
            lang = ?
        where
            user_id = ?
SQL_QUERY;

    $rs = exec_query($sql, $query, array($user_lang, $user_id));

	unset($_SESSION['user_def_lang']);
	$_SESSION['user_def_lang'] = $user_lang;
	set_page_message(tr('User language updated successfully!'));
}

$theme_color = $cfg['USER_INITIAL_THEME'];


// ko ima jump from other user interface neka esik i optica da ostanat tezi na
// ska4ashtijat user
if (!isset($_SESSION['logged_from']) && !isset($_SESSION['logged_from_id'])) {

		list($user_def_lang, $user_def_layout) = get_user_gui_props($sql, $_SESSION['user_id']);

} else {

		$user_def_layout = $_SESSION['user_theme'];

		$user_def_lang = $_SESSION['user_def_lang'];

}

gen_def_language($tpl, $sql, $user_def_lang);

$tpl -> assign(
                array(
                        'TR_CLIENT_LANGUAGE_TITLE' => tr('ispCP - Reseller/Change Language'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'),
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE'],
						'ISP_LOGO' => get_logo($_SESSION['user_id'])
                     )
              );



/*
 *
 * static page messages.
 *
 */

gen_reseller_mainmenu($tpl, $cfg['RESELLER_TEMPLATE_PATH'].'/main_menu_general_information.tpl');
gen_reseller_menu($tpl, $cfg['RESELLER_TEMPLATE_PATH'].'/menu_general_information.tpl');

gen_logged_from($tpl);

check_permissions($tpl);

$tpl -> assign(
                array(
                       'TR_LANGUAGE' => tr('Language'),
                        'TR_CHOOSE_DEFAULT_LANGUAGE' => tr('Choose default language'),
                        'TR_SAVE' => tr('Save'),
                     )
              );

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if ($cfg['DUMP_GUI_DEBUG']) dump_gui_debug();

unset_messages();

?>
