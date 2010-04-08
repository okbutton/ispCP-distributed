<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2010 by ispCP | http://isp-control.net
 * @version 	SVN: $Id$
 * @link 		http://isp-control.net
 * @author 		ispCP Team
 *
 * @license
 * The contents of this file are subject to the Mozilla Public License
 * Version 1.1 (the "License"); you may not use this file except in
 * compliance with the License. You may obtain a copy of the License at
 * http://www.mozilla.org/MPL/
 *
 * Software distributed under the License is distributed on an "AS IS"
 * basis, WITHOUT WARRANTY OF ANY KIND, either express or implied. See the
 * License for the specific language governing rights and limitations
 * under the License.
 *
 * The Original Code is "VHCS - Virtual Hosting Control System".
 *
 * The Initial Developer of the Original Code is moleSoftware GmbH.
 * Portions created by Initial Developer are Copyright (C) 2001-2006
 * by moleSoftware GmbH. All Rights Reserved.
 * Portions created by the ispCP Team are Copyright (C) 2006-2010 by
 * isp Control Panel. All Rights Reserved.
 */

require '../include/ispcp-lib.php';

check_login(__FILE__);

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/multilanguage.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('lang_row', 'page');
$tpl->define_dynamic('lang_delete_link', 'lang_row');
$tpl->define_dynamic('lang_delete_show', 'lang_row');
$tpl->define_dynamic('lang_radio', 'lang_row');
$tpl->define_dynamic('lang_def', 'lang_row');

$theme = Config::getInstance()->get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_ADMIN_I18N_PAGE_TITLE'	=> tr('ispCP - Admin/Internationalisation'),
		'THEME_COLOR_PATH'			=> "../themes/$theme",
		'THEME_CHARSET'				=> tr('encoding'),
		'ISP_LOGO'					=> get_logo($_SESSION['user_id'])
	)
);

function install_lang() {
	$sql = Database::getInstance();

	if (isset($_POST['uaction']) && $_POST['uaction'] === 'upload_language') {
		// add lang pack now !
		$file_type = $_FILES['lang_file']['type'];
		$file = $_FILES['lang_file']['tmp_name'];

		if (empty($_FILES['lang_file']['name'])
			|| !file_exists($file)
			|| !is_readable($file)) {
			set_page_message(tr('Upload file error!'));
			return;
		}

		if ($file_type !== "text/plain"
			&& $file_type !== "application/octet-stream") {
			set_page_message(tr('You can upload only text files!'));
			return;
		} else {
			$fp = fopen($file, 'r');

			if (!$fp) {
				set_page_message(tr('Could not read language file!'));
				return;
			}

			$t = '';
			$ab = array(
				'ispcp_languageRevision' => '',
				'ispcp_languageSetlocaleValue' => '',
				'ispcp_table' => '',
				'ispcp_language' => ''
			);
			$errors = 0;

			while (!feof($fp) && $errors <= 3) {
				$t = fgets($fp);

				$msgid = '';
				$msgstr = '';

				@list($msgid, $msgstr) = $t = explode(' = ', $t);

				if (count($t) != 1) {
					$ab[$msgid] = rtrim($msgstr);
				} else {
					$errors++;
				}
			}

			fclose($fp);

			if ($errors > 3) {
				set_page_message(tr('Uploaded file is not a valid language file!'));
				return;
			}

			if (empty($ab['ispcp_languageSetlocaleValue'])
				|| empty($ab['ispcp_table'])
				|| empty($ab['ispcp_language'])
				|| !preg_match('/^[a-z]{2}(_[A-Z]{2}){0,1}$/Di', $ab['ispcp_languageSetlocaleValue'])
				|| !preg_match('/^[a-z0-9]+$/Di', $ab['ispcp_table'])) {
				set_page_message(tr('Uploaded file does not contain the language information!'));
				return;
			}

			$lang_table = 'lang_' . $ab['ispcp_table'];

			$lang_update = false;

			for ($i = 0, $tables = $sql->MetaTables(), $nlang = count($tables); $i < $nlang; $i++) {
				if ($lang_table == $tables[$i]) {
					$lang_update = true;
					break;
				}
			}

			if ($lang_update) {
				$sql->Execute("DROP TABLE IF EXISTS `$lang_table`;");
			}

			$sql->Execute("CREATE TABLE `$lang_table` (
							`msgid` text collate utf8_unicode_ci,
							`msgstr` text collate utf8_unicode_ci,
							KEY `msgid` (msgid(25))
							) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
			);

			foreach ($ab as $msgid => $msgstr) {
				$query = "INSERT INTO `$lang_table` (`msgid`, `msgstr`) VALUES (?, ?)";
				exec_query($sql, $query, str_replace("\\n", "\n", array($msgid, $msgstr)));
			}

			if (!$lang_update) {
				write_log(sprintf("%s added new language: %s", $_SESSION['user_logged'], $ab['ispcp_language']));
				set_page_message(tr('New language installed!'));
			} else {
				write_log(sprintf("%s updated language: %s", $_SESSION['user_logged'], $ab['ispcp_language']));
				set_page_message(tr('Language was updated!'));
			}
		}
	}
}

function show_lang(&$tpl, &$sql) {
	$tables = $sql->MetaTables();

	$nlang = count($tables);

	$row = 1;

	list($user_def_lang, $user_def_layout) = get_user_gui_props($sql, $_SESSION['user_id']);

	$usr_def_lng = explode('_', $user_def_lang);

	for ($i = 0; $i < $nlang; $i++) {
		$data = $tables[$i];
		$pos = strpos($data, "lang_");
		if ($pos === false) {
			/* not found... ... next :) */
			continue;
		}
		$dat = explode('_', $data);

		$query = "SELECT COUNT(`msgid`) AS cnt FROM " . $tables[$i];
		$rs = exec_query($sql, $query, array());

		$query = "SELECT `msgstr` FROM " . $tables[$i] . " WHERE `msgid` = 'ispcp_language'";
		$res2 = exec_query($sql, $query, array());

		$query = "SELECT `msgstr` FROM " . $tables[$i] . " WHERE `msgid` = 'ispcp_languageSetlocaleValue'";
		$res3 = exec_query($sql, $query, array());

		$query = "SELECT `msgstr` FROM " . $tables[$i] . " WHERE `msgid` = 'ispcp_languageRevision'";
		$res4 = exec_query($sql, $query, array());

		if ($res2->RecordCount() == 0 || $res3->RecordCount() == 0) {
			$language_name = tr('Unknown');
		} else {
			$tr_langcode = tr($res3->fields['msgstr']);
			if ($res3->fields['msgstr'] == $tr_langcode) { // no translation found
				$language_name = $res2->fields['msgstr'];
			} else { // found translation
				$language_name = $tr_langcode;
			}
		}

		if ($res4->RecordCount() !== 0 && $res4->fields['msgstr'] != '' && class_exists('DateTime')) {
			$tmp_lang = new DateTime($res4->fields['msgstr']);
			$language_revision = $tmp_lang->format('Y-m-d H:i');
			unset($tmp_lang);
		} else {
			$language_revision = tr('Unknown');
		}

		$tpl->assign('LANG_CLASS', ($row++ % 2 == 0) ? 'content2' : 'content');

		if (Config::getInstance()->get('USER_INITIAL_LANG') == 'lang_' . $dat[1]
			|| $usr_def_lng[1] == $dat[1]) {
			$tpl->assign(
				array(
					'TR_UNINSTALL'		=> tr('uninstall'),
					'LANG_DELETE_LINK'	=> '',
					'LANGUAGE'			=> $language_name,
					'LANGUAGE_REVISION'	=> $language_revision,
				)
			);
			$tpl->parse('LANG_DELETE_SHOW', 'lang_delete_show');
		} else {
			$tpl->assign(
				array(
					'TR_UNINSTALL'		=> tr('uninstall'),
					'URL_DELETE'		=> 'language_delete.php?delete_lang=lang_' . $dat[1],
					'LANG_DELETE_SHOW'	=> '',
					'LANGUAGE'			=> $language_name,
					'LANGUAGE_REVISION'	=> $language_revision,
				)
			);
			$tpl->parse('LANG_DELETE_LINK', 'lang_delete_link');
		}
		// 'LANGUAGE' => $dat[1],
		// $res
		$tpl->assign(
			array(
				'MESSAGES'		=> tr('%d messages translated', $rs->fields['cnt']-5), // -5, because of meta strings
				'URL_EXPORT'	=> 'multilanguage_export.php?export_lang=lang_' . $dat[1],
			)
		);

		$tpl->parse('LANG_ROW', '.lang_row');
	}
}

/*
 *
 * static page messages.
 *
 */

gen_admin_mainmenu($tpl, Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/main_menu_settings.tpl');
gen_admin_menu($tpl, Config::getInstance()->get('ADMIN_TEMPLATE_PATH') . '/menu_settings.tpl');

install_lang();

show_lang($tpl, $sql);

$tpl->assign(
	array(
		'TR_MULTILANGUAGE'			=> tr('Internationalisation'),
		'TR_INSTALLED_LANGUAGES'	=> tr('Installed languages'),
		'TR_LANGUAGE'				=> tr('Language'),
		'TR_MESSAGES'				=> tr('Messages'),
		'TR_LANG_REV'				=> tr('Date'),
		'TR_DEFAULT'				=> tr('Panel Default'),
		'TR_ACTION'					=> tr('Action'),
		'TR_SAVE'					=> tr('Save'),
		'TR_INSTALL_NEW_LANGUAGE'	=> tr('Install new language'),
		'TR_LANGUAGE_FILE'			=> tr('Language file'),
		'ISP_LOGO'					=> get_logo($_SESSION['user_id']),
		'TR_INSTALL'				=> tr('Install'),
		'TR_EXPORT'					=> tr('Export'),
		'TR_MESSAGE_DELETE'			=> tr('Are you sure you want to delete %s?', true, '%s'),
	)
);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::getInstance()->get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
