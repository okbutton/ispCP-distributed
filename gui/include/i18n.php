<?php
/**
 *  ispCP (OMEGA) a Virtual Hosting Control Panel
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

/**
 * 	Function:		tr
 * 	Description:	translates a given string into the selected language, if exists
 *
 * 	@access			public
 * 	@version		2.1
 *  @author			ISPCP Team, Benedikt Heintel (2007)
 *
 * 	@param		$msgid		string to translate
 * 	@param		$js			whether the input string is in javascript or not
 * 	@return					translated or original string
 **/
function tr($msgid, $as_is = false) {
    global $sql, $default_lang, $cfg;
    static $cache;

    $lang = (isset($_SESSION['user_def_lang'])) ? $_SESSION['user_def_lang'] : $cfg['USER_INITIAL_LANG'];
    $encoding = 'UTF-8';

    if (isset($cache[$lang][$msgid])) {
        $msgstr = $cache[$lang][$msgid];
    } else {
        $msgstr = $msgid;

        if ($sql) {
            if (!$as_is) {
                $encoding = tr('encoding');
            }
            $msg_res = $sql->Execute("SELECT `msgstr` FROM `$lang` WHERE `msgid` = '$msgid';");

            if ($msg_res && $msg_res->RowCount() > 0) {
                $msg_d = $msg_res->FetchRow();
                if ($msg_d['msgstr'] != '') {
                    $msgstr = $msg_d['msgstr'];
                }
            }
        }
    }

    if ($msgid == 'encoding' && $msgstr == $msgid) {
        $msgstr = $encoding;
    }

    $cache[$lang][$msgid] = $msgstr;

    // Replace values
    if (func_num_args() > 2) {
        $argv = func_get_args();
        unset($argv[0]); //msgid
        unset($argv[1]); //as_is
        $msgstr = vsprintf($msgstr, $argv);
    }

    if (!$as_is) {
        $msgstr = replace_html(htmlentities($msgstr, ENT_COMPAT, $encoding));
    }

    return $msgstr;
}

/**
 * 	Function:		replace_html
 * 	Description:	replaces special encoded strings back to their original signs
 *
 * 	@access			public
 * 	@version		1.0
 *  @author			ISPCP Team, Benedikt Heintel (2007)
 *
 * 	@param		$string		string to replace chars
 * 	@return					string with replaced chars
 **/
function replace_html($string) {

    $pattern = array (
                        '=&lt;b&gt;=is',
                        '=&lt;/b&gt;=is',
                        '=&lt;i&gt;=is',
                        '=&lt;/i&gt;=is',
                        '=&lt;br&gt;=is'
                     );

    $replacement = array (
                            '<b>',
                            '</b>',
                            '<i>',
                            '</i>',
                            '<br />'
                         );

	$string = preg_replace($pattern, $replacement, $string);

	return $string;
}

?>