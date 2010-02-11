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

// Security
check_login(__FILE__);

if (isset($_GET['export_lang']) && $_GET['export_lang'] !== '') {
	$language_table = $_GET['export_lang'];
	$encoding = $sql->Execute("SELECT `msgstr` FROM `" . $language_table . "` WHERE `msgid` = 'encoding';");
	if ($encoding
		&& $encoding->RowCount() > 0
		&& $encoding->fields['msgstr'] != '') {
		$encoding = $encoding->fields['msgstr'];
	} else {
		$encoding = 'UTF-8';
	}
	$query = <<<SQL_QUERY
			SELECT
				`msgid`,
				`msgstr`
			FROM
				$language_table
SQL_QUERY;

	$rs = exec_query($sql, $query, array());

	if ($rs->RecordCount() == 0) {
		set_page_message(tr("Incorrect data input!"));
		user_goto('multilanguage.php');
	} else {
		$GLOBALS['class']['output']->showSize = false;
		header('Content-type: text/plain; charset=' . $encoding);
		while (!$rs->EOF) {
			$msgid = $rs->fields['msgid'];
			$msgstr = $rs->fields['msgstr'];
			if ($msgid !== '' && $msgstr !== '') {
				echo $msgid . " = " . $msgstr."\n";
			}
			$rs->MoveNext();
		}
	}
} else {
	set_page_message(tr("Incorrect data input!"));
	user_goto('multilanguage.php');
}
