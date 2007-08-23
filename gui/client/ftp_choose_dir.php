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

require '../include/vfs.php';
require '../include/ispcp-lib.php';

check_login(__FILE__);

$tpl = new pTemplate();

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('logged_from', 'page');

$tpl -> define_dynamic('dir_item', 'page');

$tpl -> define_dynamic('action_link', 'page');

$tpl -> define_dynamic('list_item', 'page');

$tpl -> define_dynamic('page', $cfg['CLIENT_TEMPLATE_PATH'].'/ftp_choose_dir.tpl');

$theme_color = $cfg['USER_INITIAL_THEME'];


function gen_directories( &$tpl ) {
	global $sql;

	// Initialize variables
	$path   = isset($_GET['cur_dir']) ? $_GET['cur_dir'] : '';
	$domain = $_SESSION['user_logged'];

	// Create the virtual file system and open it so it can be used
	$vfs =& new vfs($domain,$sql);

	// Get the directory listing
	$list = $vfs->ls($path);
	if (!$list) {
		set_page_message( tr('Can not open directory !<br>Please contact your administrator !'));
		return;
	}

	// Show parent directory link
	$parent = explode('/',$path);
	array_pop($parent);
	$parent = implode('/',$parent);
	$tpl -> assign('ACTION_LINK', '');
	$tpl -> assign( array(
				'ACTION' => '',
				'ICON' => "parent",
				'DIR_NAME' => tr('Parent Directory'),
				'LINK' => 'ftp_choose_dir.php?cur_dir=' . $parent,
			));
	$tpl -> parse('DIR_ITEM', '.dir_item');

	// Show directories only
	foreach ($list as $entry) {

		// Skip non-directory entries
		if ( $entry['type'] != VFS_TYPE_DIR )
			continue;
		// Skip '.' and '..'
		if ( $entry['file'] == '.' || $entry['file'] == '..')
			continue;

		// Check for .htaccess existance to display another icon
		$dr = $path.'/'.$entry['file'];
		$tfile = $dr . '/.htaccess';
		if ($vfs->exists($tfile)) {
			$image = "locked";
		} else {
			$image = "folder";
		}

		// Create the directory link
		$tpl->assign( array(
			'ACTION' => tr('Protect it'),
			'PROTECT_IT' => "protect_it.php?file=$dr",
			'ICON' => $image,
			'DIR_NAME' => $entry['file'],
			'CHOOSE_IT' => $dr,
			'LINK' => "ftp_choose_dir.php?cur_dir=$dr",
		));
		$tpl->parse('ACTION_LINK', 'action_link');
		$tpl->parse('DIR_ITEM'   , '.dir_item');
	}
}
// functions end


$tpl -> assign(
                array(
                        'TR_CLIENT_WEBTOOLS_PAGE_TITLE' => tr('ispCP - Client/Webtools'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'), 
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE'],
						'ISP_LOGO' => get_logo($_SESSION['user_id'])
                     )
              );


gen_directories($tpl);


$tpl -> assign(
                array(
						'TR_DIRECTORY_TREE' => tr('Directory tree'),
						'TR_DIRS' => tr('Directories'),
						'TR__ACTION' => tr('Action'),
						'CHOOSE' => tr('Choose')
					  )
				);

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if ($cfg['DUMP_GUI_DEBUG']) dump_gui_debug();

unset_messages();
?>