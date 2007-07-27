<?php
/**
 *  ispCP ω (OMEGA) a Virtual Hosting Control System
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
 *
 **/

//
// THEME_COLOR managment stuff.
//

function get_user_gui_props(&$sql, $user_id) {

  global $cfg;

  $query = <<<SQL_QUERY
        select
            lang, layout
        from
            user_gui_props
        where
            user_id = ?
SQL_QUERY;

    $rs = exec_query($sql, $query, array($user_id));

    if($rs->RecordCount() == 0) {
        // values for user id, some default staff
        return array($cfg['USER_INITIAL_LANG'], $cfg['USER_INITIAL_THEME']);
    } else if ($rs->fields['lang'] === '' && $rs->fields['layout'] === '') {
        return array($cfg['USER_INITIAL_LANG'], $cfg['USER_INITIAL_THEME']);
    } else if ($rs->fields['lang'] === '') {
        return array($cfg['USER_INITIAL_LANG'],  $rs->fields['layout']);
    } else if ($rs->fields['layout'] === '') {
        return array($rs->fields['lang'], $cfg['USER_INITIAL_THEME']);
    }

    return array($rs->fields['lang'], $cfg['USER_INITIAL_THEME']);

}

if (isset($_SESSION['user_id'])) {

	if (!isset($_SESSION['logged_from']) && !isset($_SESSION['logged_from_id'])) {

		list($user_def_lang, $user_def_layout) = get_user_gui_props($sql, $_SESSION['user_id']);

		$_SESSION['user_theme'] = $user_def_layout;
		$_SESSION['user_def_lang'] = $user_def_lang;
	}
}

function gen_page_message(&$tpl) {

    if (!isset($_SESSION['user_page_message'])) {
        $tpl -> assign('PAGE_MESSAGE', '');
        $tpl -> assign('MESSAGE',      '');
    } else {
        $tpl -> assign('MESSAGE', $_SESSION['user_page_message']);
        unset($_SESSION['user_page_message']);
    }

}

function check_language_exist($lang_table) {
    global $sql;

    $tables = $sql->MetaTables();
    $nlang = count($tables);
    for ($i=0 ; $i < $nlang; $i++) {
        $data= $tables[$i];
        if ($data == $lang_table) {
            return true;
        }
    }
    return false;
}

function set_page_message($message) {

    if (isset($_SESSION['user_page_message']))
        $_SESSION['user_page_message'] .= "<br><br>$message<br><br>";
    else
        $_SESSION['user_page_message'] = $message;
}

function get_menu_vars($menu_link) {
	global $sql;

	$user_id = $_SESSION['user_id'];

	$query = <<<SQL_QUERY
        SELECT
            customer_id, fname, lname, firm, zip, city, country, email, phone, fax, street1, street2
        FROM
            admin
        WHERE
            admin_id = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($user_id));

	$search  = array();
	$replace = array();

	$search [] = '{uid}';
	$replace[] = $_SESSION['user_id'];
	$search [] = '{uname}';
	$replace[] = $_SESSION['user_logged'];
	$search [] = '{cid}';
	$replace[] = $rs -> fields['customer_id'];
	$search [] = '{fname}';
	$replace[] = $rs -> fields['fname'];
	$search [] = '{lname}';
	$replace[] = $rs -> fields['lname'];
	$search [] = '{company}';
	$replace[] = $rs -> fields['firm'];
	$search [] = '{zip}';
	$replace[] = $rs -> fields['zip'];
	$search [] = '{city}';
	$replace[] = $rs -> fields['city'];
	$search [] = '{country}';
	$replace[] = $rs -> fields['country'];
	$search [] = '{email}';
	$replace[] = $rs -> fields['email'];
	$search [] = '{phone}';
	$replace[] = $rs -> fields['phone'];
	$search [] = '{fax}';
	$replace[] = $rs -> fields['fax'];
	$search [] = '{street1}';
	$replace[] = $rs -> fields['street1'];
	$search [] = '{street2}';
	$replace[] = $rs -> fields['street2'];

	$query = <<<SQL_QUERY
        SELECT
            domain_name, domain_admin_id
        FROM
            domain
        WHERE
            domain_admin_id = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($user_id));

	$search [] = '{domain_name}';
	$replace[] = $rs -> fields['domain_name'];

	$menu_link = str_replace($search, $replace, $menu_link);
	return $menu_link;
}

// curently not being used because there's only one layout/theme
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

?>