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

function save_layout(&$sql) {

    if (isset($_POST['uaction']) && $_POST['uaction'] === 'save_layout') {

        $user_id = $_SESSION['user_id'];

        $user_layout = $_POST['def_layout'];

        $query = <<<SQL_QUERY
            update
                user_gui_props
            set
                layout = ?
            where
                user_id = ?
SQL_QUERY;
        $rs = exec_query($sql, $query, array($user_layout, $user_id));
    	$_SESSION['user_theme_color'] = $user_layout;
        $theme_color = $user_layout;
		$user_def_layout = $user_layout;

    }
}

function update_logo() {
    global $cfg;

    if (isset($_POST['uaction']) && $_POST['uaction'] === 'upload_logo') {

            $user_id = $_SESSION['user_id'];

            if ($_POST['Submit'] == tr('Remove')) {

                    update_user_gui_props('', $user_id);

                    return;
            }

            if (empty($_FILES['logo_file']['name'])) {

                    set_page_message(tr('Upload file error!'));

                    return;
            }

            $file_type = $_FILES['logo_file']['type'];

            switch ($file_type) {
                case 'image/gif':
                    $fext = 'gif';
                    break;
                case 'image/jpeg':
                case 'image/pjpeg':
                    $file_type = 'image/jpeg';
                    $fext = 'jpg';
                    break;
                case 'image/png':
                    $fext = 'png';
                    break;
                default:
                    set_page_message(tr('You can only upload images!'));
                    return ;
                    break;
            }

            $fname = $_FILES['logo_file']['tmp_name'];

            // Make sure it is really an image
            if (image_type_to_mime_type(exif_imagetype($fname)) != $file_type) {
                set_page_message(tr('You can only upload images!'));
                return ;
            }

			// $fsize = $_FILES['logo_file']['size'];

            $newFName = get_user_name($user_id) . '.' . $fext;

            $path1 = substr($_SERVER['SCRIPT_FILENAME'],0, strpos($_SERVER['SCRIPT_FILENAME'], '/admin/layout.php')+1);

			// $path2 = substr($cfg['ROOT_TEMPLATE_PATH'],0, strpos($cfg['ROOT_TEMPLATE_PATH'], '/tpl')+1);

            $logoFile = $path1 . '/themes/user_logos/' . $newFName;
            move_uploaded_file($fname, $logoFile);
            chmod ($logoFile, 0644);

            update_user_gui_props($newFName, $user_id);

            set_page_message(tr('Your logo was successful uploaded!'));

    }
}

function update_user_gui_props($file_name, $user_id) {
    global $sql;

    $query = <<<SQL_QUERY
        update
            user_gui_props
        set
            logo = ?
        where
            user_id = ?
SQL_QUERY;

    $rs = exec_query($sql, $query, array($file_name, $user_id));

}


function gen_def_layout(&$tpl, $user_def_layout) {
    $layouts = array('blue', 'green', 'red', 'yellow');

    foreach ($layouts as $layout) {

        if ($layout === $user_def_layout) {

            $selected = 'selected';

        } else {

            $selected = '';

        }

        $tpl -> assign(
                        array(
                                'LAYOUT_VALUE' => $layout,
                                'LAYOUT_SELECTED' => $selected,
                                'LAYOUT_NAME' => $layout
                             )
                      );

        $tpl -> parse('DEF_LAYOUT', '.def_layout');
    }

}

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['ADMIN_TEMPLATE_PATH'].'/layout.tpl');

$tpl -> define_dynamic('page_message', 'page');
$tpl -> define_dynamic('hosting_plans', 'page');

$tpl -> define_dynamic('def_layout', 'page');


save_layout($sql);

update_logo();

$theme_color = $cfg['USER_INITIAL_THEME'];

gen_def_layout($tpl, $_SESSION['user_theme']);

$tpl -> assign(
                array(
                        'TR_ADMIN_CHANGE_LAYOUT_PAGE_TITLE' => tr('ISPCP - Virtual Hosting Control System'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'ISP_LOGO' => get_logo($_SESSION['user_id']),
                        'THEME_CHARSET' => tr('encoding'),
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE']
                     )
              );

/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/main_menu_settings.tpl');
gen_admin_menu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/menu_settings.tpl');

$tpl -> assign(
                array(
                        'TR_LAYOUT_SETTINGS' => tr('Layout settings'),
						'TR_INSTALLED_LAYOUTS' => tr('Installed layouts'),
						'TR_LAYOUT_NAME' => tr('Layout name'),
						'TR_DEFAULT' => tr('default'),
						'TR_YES' => tr('yes'),
						'TR_SAVE' => tr('Save'),
						'TR_UPLOAD_LOGO' => tr('Upload logo'),
						'TR_LOGO_FILE' => tr('Logo file'),
						'TR_UPLOAD' => tr('Upload'),
						'TR_REMOVE' => tr('Remove'),
						'TR_CHOOSE_DEFAULT_LAYOUT' => tr('Choose default layout'),
						'TR_LAYOUT' => tr('Layout'),
                     )
              );

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if ($cfg['DUMP_GUI_DEBUG']) dump_gui_debug();

unset_messages();
?>