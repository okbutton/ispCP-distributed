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
 *
 **/


//-- check if they are trying to hack
$CHECK_VARS = array();
$CHECK_VARS[] = "/wget /i";
$CHECK_VARS[] = "/chmod /i";
$CHECK_VARS[] = "/chown /i";
$CHECK_VARS[] = "/lnyx /i";
$CHECK_VARS[] = "/curl /i";
$CHECK_VARS[] = "/fopen /i";
$CHECK_VARS[] = "/mkdir /i";
$CHECK_VARS[] = "/passwd /i";
$CHECK_VARS[] = "/http:/i";
$CHECK_VARS[] = "/ftp:/i";

$CHECK_VARS[] = "/content-type:/i";
$CHECK_VARS[] = "/content-transfer-encoding:/i";
$CHECK_VARS[] = "/mime-version:/i";
$CHECK_VARS[] = "/subject:/i";
$CHECK_VARS[] = "/to:/i";
$CHECK_VARS[] = "/cc:/i";
$CHECK_VARS[] = "/bcc:/i";
$CHECK_VARS[] = "/\r/";
$CHECK_VARS[] = "/\n/";
$CHECK_VARS[] = "/%0a/";
$CHECK_VARS[] = "/%0d/";

function check_input($value = '') {

    global $CHECK_VARS;

    if (!empty($value)) {

        $value = strtolower($value);

        foreach($CHECK_VARS as $VAR) {

            if (preg_match($VAR, $value) > 0) {
                $message = "Possible hacking attempt. Script terminated.";
                write_log($message);
                system_message(tr($message));
                die();
            }

        }

    }

}

function clean_html($input = '') {

    $suche = array ('@<script[^>]*?>.*?</script>@si',  // JavaScript entfernen
    '@<[\/\!]*?[^<>]*?>@si',          // HTML-Tags entfernen
    '@([\r\n])[\s]+@',                // Leerr�ume entfernen
    '@&(quot|#34);@i',                // HTML-Entit�ten ersetzen
    '@&(amp|#38);@i',
    '@&(lt|#60);@i',
    '@&(gt|#62);@i',
    '@&(nbsp|#160);@i',
    '@&(iexcl|#161);@i',
    '@&(cent|#162);@i',
    '@&(pound|#163);@i',
    '@&(copy|#169);@i',
    '@&#(\d+);@e');                    // als PHP auswerten

    $ersetze = array ('',
    '',
    '\1',
    '"',
    '&',
    '<',
    '>',
    ' ',
    chr(161),
    chr(162),
    chr(163),
    chr(169),
    'chr(\1)');

    $text = preg_replace($suche, $ersetze, $input);
    //and second one...
    $text = strip_tags($text);

    return $text;

}

function clean_input($input) {

    if ((strpos($input, "{") == 0) && (strpos($input, "}") == strlen($input)-1)) {

        $input = trim($input, "{..}");

    }

    return htmlentities(stripslashes($input), ENT_QUOTES, "UTF-8");

}

/**
 *  @function		chk_password
 *  @description
 *
 * 	@param		String		$data		username to be checked
 * 	@param		int			$num		number of max. chars
 *  @return		boolean					valid username or not
 */
function chk_password($password, $num = 50) {
    global $cfg;

    $len = strlen($password);
    if ($len < $cfg['PASSWD_CHARS'] || $len > $num )
		return FALSE;

    if ($cfg['PASSWD_STRONG'])
        return (bool)(preg_match("/[0-9]/", $password) AND preg_match("/[a-zA-Z]/", $password));
    else
        return TRUE;
}

/**
 *  @function		chk_username
 *  @description
 *
 * 	@param		String		$data		username to be checked
 * 	@param		int			$num		number of max. chars
 *  @return		boolean					valid username or not
 */
function chk_username($username, $num = 50) {

	// Username contains only allowed chars
    if (!preg_match("/^[A-Za-z0-9][A-Za-z0-9\.\-_]*[A-Za-z0-9]$/D", $username))
    	return FALSE;

    // Username has not two times .,- or _
	if(preg_match("/(\.\.)|(\-\-)|(\_\_)/", $username))
		return FALSE;

	// Username has no not allowed concardination in it
	if (preg_match("/(\.\-)|(\-\.)|(\.\_)|(\_\.)|(\-\_)|(\_\-)/", $username))
		return FALSE;

	// String is not to long
	if (strlen($username) > $num)
		return FALSE;

    return TRUE;
}


function chk_email($email, $num = 50) {
    // RegEx begin

    $nonascii      = "\x80-\xff"; # Non-ASCII-Chars are not allowed

    $nqtext        = "[^\\\\$nonascii\015\012\"]";
    $qchar         = "\\\\[^$nonascii]";

    $normuser      = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
    $quotedstring  = "\"(?:$nqtext|$qchar)+\"";
    $user_part     = "(?:$normuser|$quotedstring)";

    $dom_mainpart  = '[a-zA-Z0-9][a-zA-Z0-9.-]*[a-zA-Z0-9]\\.';
    $dom_subpart   = '(?:[a-zA-Z0-9][a-zA-Z0-9.-]*\\.)*';
    $dom_tldpart   = '[a-zA-Z]{2,5}';
    $domain_part   = "$dom_subpart$dom_mainpart$dom_tldpart";

    $regex         = "$user_part\@$domain_part";
    // RegEx end

    if (!preg_match("/^$regex$/",$email))
		return FALSE;

    if (strlen($email) > $num)
		return FALSE;

    return TRUE;

}

function ispcp_check_local_part($email, $num = 50) {
    // RegEx begin

    $nonascii      = "\x80-\xff"; # Non-ASCII-Chars are not allowed

    $nqtext        = "[^\\\\$nonascii\015\012\"]";
    $qchar         = "\\\\[^$nonascii]";

    $normuser      = '[a-zA-Z0-9][a-zA-Z0-9_.-]*';
    $quotedstring  = "\"(?:$nqtext|$qchar)+\"";
    $user_part     = "(?:$normuser|$quotedstring)";

    $regex         = $user_part;
    // RegEx end

    if (!preg_match("/^$regex$/D",$email))
		return FALSE;

    if (strlen($email) > $num)
		return FALSE;

    return TRUE;

}


function full_domain_check($data) {

    $data .= ".";
    $match = array();

    $res = preg_match_all("/([^\.]*\.)/", $data, $match, PREG_PATTERN_ORDER);

    if (!$res) {
        return FALSE;
    }

    $last = $res - 1;

    for ($i = 0; $i < $last ; $i++) {

        $token = chop($match[0][$i], ".");

        $res = check_dn_token($token);

        if (!$res)
            return FALSE;
    }


    $res = preg_match("/^[A-Za-z0-9][A-Za-z0-9]*[A-Za-z0-9]\.$/", $match[0][$last]);

    if (!$res)
        return FALSE;

    return TRUE;
}


function check_dn_token($data) {

    $match = array();

    if (!preg_match("/^([A-Za-z0-9])([A-Za-z0-9\-]*)([A-Za-z0-9])$/D", $data, $match))
        return FALSE;

    // Username has not two times .,- or _
	if(preg_match("/(\.\.)|(\-\-)|(\_\_)/", $data))
		return FALSE;

	// Username has no not allowed concardination in it
	if (preg_match("/(\.\-)|(\-\.)|(\.\_)|(\_\.)|(\-\_)|(\_\-)/", $data))
		return FALSE;

    return TRUE;
}

/**
 *  @function		ispcp_limit_check
 *  @description	Function for checking ispcp limits. The correct values for
 * 					this limits are in ranges -1, 0, [1, $num]
 *
 * 	@param		String		$data		ispcp 'limit' field data
 * 	@param		int			$num		number of max. chars
 *  @return		boolean					false	incorrect syntax (ranges)
 * 										true	correct syntax (ranges)
 */
function ispcp_limit_check($data, $num) {

    $res = preg_match("/^(-1|0|[1-9][0-9]*)$/D", $data);

    if (!$res)
    	return FALSE;

    if ($data > $num)
    	return FALSE;

    return TRUE;
}

/**
 *  @function		check_dn_rsl_token
 *  @description	Function for checking domain name tokens; Internel function,
 * 					for usage in ispcp_* functions
 *
 * 	@param		String		$data		token data. Without '\n' at the end
 * 	@param		int			$num		number of max. chars
 *  @return		boolean					false	incorrect syntax
 * 										true	correct syntax
 */
function check_dn_rsl_token($data) {

	$match = array();
    if (!preg_match("/^([[^a-z0-9^A-Z^������\-]*)([A-Za-z0-9])$/D", $data, $match))
		return FALSE;

    if (preg_match("/\-\-/", $match[2]))
		return FALSE;

    return TRUE;
}

/**
 *  @function		chk_dname
 *  @description	Function for checking ISPCP domains syntax. Here domains are
 * 					limited to {dname}.{ext} parts
 *
 * 	@param		String		$dname		ispcp domain data
 * 	@param		int			$num		number of max. chars
 *  @return		boolean					false	incorrect syntax
 * 										true	correct syntax
 */
function chk_dname($dname) {

    if (!rsl_full_domain_check($dname))
		return FALSE;

    $match = array();

    if (preg_match_all("/\./", $dname, $match, PREG_PATTERN_ORDER) <= 0)
    	return FALSE;

    return TRUE;

}

/**
 *  @function		chk_url
 *  @description	Function for checking URL syntax
 *
 * 	@param		String		$url		URL data
 *  @return		boolean					false	incorrect syntax
 * 										true	correct syntax
 */
function chk_url($url) {

    $dom_mainpart  = '[a-zA-Z0-9][a-zA-Z0-9-]*[a-zA-Z0-9]\.';
    $dom_subpart   = '(?:[a-zA-Z0-9][a-zA-Z0-9.-]*\.)*';
    $dom_tldpart   = '[a-zA-Z]{2,5}';
    $domain   	   = $dom_subpart.$dom_mainpart.$dom_tldpart;

    if (!preg_match("/^(http|https|ftp)\:\/\/".$domain."$/", $url))
		return FALSE;

    return TRUE;
}

/**
 *  @function		chk_mountp
 *  @description	Function checking for valid mount point
 *
 * 	@param		String		$data		mountpoint data
 * 	@param		int			$num		number of max. chars
 *  @return		boolean					false	incorrect syntax
 * 										true	correct syntax
 */
function chk_mountp($data, $num = 50) {

    if (!preg_match("/^\/(.*)$/D", $data))
		return FALSE;

    if (preg_match("/^\/htdocs$/D", $data))
		return FALSE;

    if (preg_match("/^\/backups$/D", $data))
    	return FALSE;

    if (preg_match("/^\/cgi-bin$/D", $data))
		return FALSE;

    if (preg_match("/^\/errors$/D", $data))
    	return FALSE;

    if (preg_match("/^\/logs$/D", $data))
    	return FALSE;

    $res = explode("/", trim($data));
    $cnt_res = count($res);
    if ($cnt_res > 2)
    	return FALSE;

    $match = array();
    $count = preg_match_all("(\/[^\/]*)", $data, $match, PREG_PATTERN_ORDER);

    if (!$count)
        return FALSE;

    for ($i = 0; $i < $count; $i++) {
        $token = substr($match[0][$i], 1);

        if (!chk_username($token, $num))
           	return FALSE;
    }

    return TRUE;
}

/* return mail for a a id */
function trans_mailid_to_mail(&$sql, $mailid) {

    $query = <<<SQL_QUERY

	select *
		from
			mail_users
		where
			mail_id = ?
		limit 1
SQL_QUERY;

    $res = exec_query($sql, $query, array($mailid));

    if ($res -> RowCount() == 1) {

        $data = $res -> FetchRow();
        $mail_type = $data['mail_type'];

        if ($mail_type === 'normal_mail') {

            $local_part = $data['mail_acc'];
            $domain_query = "select domain_name from domain as t1, mail_users as t2  where t2.domain_id=t1.domain_id and t2.mail_id = ?";
            $res = exec_query($sql, $domain_query, array($mailid));
            $domain_name = $res->fields['domain_name'];

            return $local_part."@".$domain_name;

        }
		else if ($mail_type === 'normal_forward') {

            $local_part = $data['mail_acc'];
            $domain_query = "select domain_name from domain as t1, mail_users as t2  where t2.domain_id=t1.domain_id and t2.mail_id = ?";
            $res = exec_query($sql, $domain_query, array($mailid));
            $domain_name = $res->fields['domain_name'];

            return $local_part."@".$domain_name;

        }
		else if ($mail_type === 'alias_mail') {

            $local_part = $data['mail_acc'];
            $domain_query = "select alias_name from domain as t1, mail_users as t2, domain_aliasses as t3  where t2.domain_id=t1.domain_id and t3.alias_id = t2.sub_id and t2.mail_id = ?";
            $res = exec_query($sql, $domain_query, array($mailid));
            $domain_name = $res->fields['alias_name'];

            return $local_part."@".$domain_name;

        }
		else if ($mail_type === 'alias_forward') {

            $local_part = $data['mail_acc'];
            $domain_query = "select alias_name from domain as t1, mail_users as t2, domain_aliases as t3  where t2.domain_id=t1.domain_id and t3.alias_id = t2.sub_id and t2.mail_id = ?";
            $res = exec_query($sql, $domain_query, array($mailid));
            $domain_name = $res->fields['alias'];

            return $local_part."@".$domain_name;


        }
		else if ($mail_type === 'subdom_mail') {

            $local_part = $data['mail_acc'];
            $domain_query = "select subdomain_name from domain as t1, mail_users as t2, subdomain as t3  where t2.domain_id=t1.domain_id and t3.subdomain_id = t2.sub_id and t2.mail_id = ?";

        }
		else if ($mail_type === 'subdom_forward') {

            $local_part = $data['mail_acc'];
            $domain_query = "select subdomain_name from domain as t1, mail_users as t2, subdomain as t3  where t2.domain_id=t1.domain_id and t3.subdomain_id = t2.sub_id and t2.mail_id = ?";
            $res = exec_query($sql, $domain_query, array($mailid));
            $domain_name = $res->fields['subdomain_name'];

            return $local_part."@".$domain_name;

        }
		else if ($mail_type === 'normal_catchall') {
            return tr('Catchall account');
        }
		else if ($mail_type === 'alias_catchall') {
            return tr('Catchall account');
        }
		else {
            return tr('Unknown type');
        }

    }

}

function get_post($value) {

    if(isset($_POST[$value]))
        return $_POST[$value];
    else
        return null;
}

function get_session($value) {

    if(isset($_SESSION[$value]))
        return $_SESSION[$value];
    else
        return null;
}

function is_subdir_of($base_domain, $subdomain, $realPath = true) {
    if ($realPath) {
        $base_domain = realpath($base_domain);
        $subdomain   = realpath($subdomain);
    }

    $t = explode($base_domain, $subdomain);

    return (count($t) > 1 && $t[0] === '');
}

/**
* Description:
*
* Function for checking ISPCP subdomain syntax. Here subdomains are
* limited to {subname}.{dname}.{ext} parts. Data passed to this
* function must be in the upper form, not only subdomain part for
* example.
*
* Input:
*
* $data - ispcp subdomain data;
*
* Output:
*
* false - incorrect syntax;
*
* true - correct syntax;
*/
function chk_subdname($subdname) {

    if (!full_domain_check($subdname)) {
        return false;
    }

    $match = array();

    $res = preg_match_all("/\./", $subdname, $match, PREG_PATTERN_ORDER);

    if ($res <= 1) {
        return false;
    }

    $res = preg_match("/^(www|ftp|mail|ns)\./", $subdname);

    return !($res == 1);
}

/**
 * All in one function to check who owns what =)
 *
 * @param misc $id FTP/mail/domain/alias/subdomain/etc id to check
 * @param string $type What kind of id $id is
 * @return numeric The id of the admin who owns the id $id of $type type
 */
function who_owns_this($id, $type = 'dmn')
{
    global $sql;

    $who = null;

    // Fix $type according to type or by alias
    switch ($type) {
        case 'dmn_id':
            $type = 'domain_id';
            break;
        case 'sub_id':
            $type = 'subdomain_id';
            break;
        case 'als_id':
            $type = 'alias_id';
            break;
        case 'user':
            $type = 'client';
            break;
        case 'domain_uid':
            $type = 'uid';
            break;
        case 'ticket':
            $type = 'ticket_id';
            break;
        case 'domain_gid':
            $type = 'gid';
            break;
        case 'sqlu_id':
        case 'sqluser_id':
            $type = 'sql_user_id';
            break;
        case 'sqld_id':
        case 'sqldatabase_id':
            $type = 'sql_database_id';
            break;
        case 'ftpuser':
        case 'ftpuserid':
        case 'ftp_userid':
            $type = 'ftp_user';
            break;
        case 'sqluser':
        case 'sqlu':
        case 'sqlu_name':
            // Can't guess by type
            $type = 'sql_user';
            break;
        case 'sqldatabase':
        case 'sqld':
        case 'sqld_name':
            // Can't guess by type
            $type = 'sql_database';
            break;
        case 'dmn':
        case 'domain':
            if (!is_numeric($id)) {
                $type = 'domain';
            } else {
                $type = 'domain_id';
            }
            break;
        case 'als':
        case 'alias':
        case 'domain_alias':
            if (!is_numeric($id)) {
                $type = 'alias';
            } else {
                $type = 'alias_id';
            }
            break;
        case 'sub':
        case 'subdomain':
            if (!is_numeric($id)) {
                $type = 'subdomain';
            } else {
                $type = 'subdomain_id';
            }
            break;
    }

    $resolvers = array();
    /**
     * $resolvers is a multi-dimensional array.
     * It's elements keys are the value that will be matched by $type.
     * Each element is an array, containing at least two elements:
     *  'query' and 'is_final'
     * The former is the SQL query that should only SELECT one item; or false in case a query isn't used.
     * The latter is a boolean which specifies whether the result of that 'resolver' is an admin id or not
     *
     * Other elements might be:
     *  'next', 'separator', 'pos'
     *
     * 'next' is the $type value for the next call to who_owns_this (only used when 'is_final' is false)
     * 'separator' is the separator to be used when exploding the $id (only used when 'query' is false)
     * 'post' is the position in the array/result of exploding $id (only used when 'query' is false)
     *
     * NOTE: 'query' MUST be formated like: 'SELECT something FROM...' in order to correctly detect the field being selected
     *
     */
    $resolvers['domain_id'] = array();
    $resolvers['domain_id']['query'] = 'SELECT domain_admin_id FROM domain WHERE domain_id = ? LIMIT 1;';
    $resolvers['domain_id']['is_final'] = true;

    $resolvers['alias_id'] = array();
    $resolvers['alias_id']['query'] = 'SELECT domain_id FROM domain_aliasses WHERE alias_id = ? LIMIT 1;';
    $resolvers['alias_id']['is_final'] = false;
    $resolvers['alias_id']['next'] = 'dmn';

    $resolvers['alias'] = array();
    $resolvers['alias']['query'] = 'SELECT domain_id FROM domain_aliasses WHERE alias_name = ? LIMIT 1;';
    $resolvers['alias']['is_final'] = false;
    $resolvers['alias']['next'] = 'dmn';

    $resolvers['subdomain_id'] = array();
    $resolvers['subdomain_id']['query'] = 'SELECT domain_id FROM subdomain WHERE subdomain_id = ? LIMIT 1;';
    $resolvers['subdomain_id']['is_final'] = false;
    $resolvers['subdomain_id']['next'] = 'dmn';

    $resolvers['subdomain'] = array();
    $resolvers['subdomain']['query'] = false;
    $resolvers['subdomain']['separator'] = '.';
    $resolvers['subdomain']['pos'] = 1;
    $resolvers['subdomain']['is_final'] = false;
    $resolvers['subdomain']['next'] = 'dmn';

    $resolvers['client'] = array();
    $resolvers['client']['query'] = 'SELECT created_by FROM admin WHERE admin_id = ? LIMIT 1;';
    $resolvers['client']['is_final'] = true;

    $resolvers['reseller'] = $resolvers['admin'] = $resolvers['client'];

    $resolvers['domain'] = array();
    $resolvers['domain']['query'] = 'SELECT domain_admin_id FROM domain WHERE domain = ? LIMIT 1;';
    $resolvers['domain']['is_final'] = true;

    $resolvers['ticket_id'] = array();
    $resolvers['ticket_id']['query'] = 'SELECT ticket_from FROM ticket WHERE ticket_id = ? LIMIT 1;';
    $resolvers['ticket_id']['is_final'] = true;

    $resolvers['uid'] = array();
    $resolvers['uid']['query'] = 'SELECT domain_admin_id FROM domain WHERE domain_uid = ? LIMIT 1;';
    $resolvers['uid']['is_final'] = true;

    $resolvers['gid'] = array();
    $resolvers['gid']['query'] = 'SELECT domain_admin_id FROM domain WHERE domain_gid = ? LIMIT 1;';
    $resolvers['gid']['is_final'] = true;

    $resolvers['gid'] = array();
    $resolvers['gid']['query'] = 'SELECT domain_admin_id FROM domain WHERE domain_gid = ? LIMIT 1;';
    $resolvers['gid']['is_final'] = true;

    $resolvers['ftp_user'] = array();
    $resolvers['ftp_user']['query'] = 'SELECT uid FROM ftp_users WHERE userid = ? LIMIT 1;';
    $resolvers['ftp_user']['is_final'] = false;
    $resolvers['ftp_user']['next'] = 'dmn';

    $resolvers['sql_user_id'] = array();
    $resolvers['sql_user_id']['query'] = 'SELECT sqld_id FROM sql_user WHERE sqlu_id = ? LIMIT 1;';
    $resolvers['sql_user_id']['is_final'] = false;
    $resolvers['sql_user_id']['next'] = 'sqld_id';

    $resolvers['sql_database_id'] = array();
    $resolvers['sql_database_id']['query'] = 'SELECT domain_id FROM sql_database WHERE sqld_id = ? LIMIT 1;';
    $resolvers['sql_database_id']['is_final'] = false;
    $resolvers['sql_database_id']['next'] = 'dmn';

    $resolvers['sql_user'] = array();
    $resolvers['sql_user']['query'] = 'SELECT sqld_id FROM sql_user WHERE sqlu_name = ? LIMIT 1;';
    $resolvers['sql_user']['is_final'] = false;
    $resolvers['sql_user']['next'] = 'sqld_id';

    $resolvers['sql_database'] = array();
    $resolvers['sql_database']['query'] = 'SELECT domain_id FROM sql_database WHERE sqld_name = ? LIMIT 1;';
    $resolvers['sql_database']['is_final'] = false;
    $resolvers['sql_database']['next'] = 'dmn';

    $resolvers['mail_id'] = array();
    $resolvers['mail_id']['query'] = 'SELECT domain_id FROM mail_users WHERE mail_id = ? LIMIT 1;';
    $resolvers['mail_id']['is_final'] = false;
    $resolvers['mail_id']['next'] = 'dmn';

    $resolvers['mail'] = array();
    $resolvers['mail']['query'] = false;
    $resolvers['mail']['separator'] = '@';
    $resolvers['mail']['post'] = 1;
    $resolvers['mail']['is_final'] = false;
    $resolvers['mail']['next'] = 'dmn';

    $resolvers['htaccess_id'] = array();
    $resolvers['htaccess_id']['query'] = 'SELECT dmn_id FROM htaccess WHERE id = ? LIMIT 1;';
    $resolvers['htaccess_id']['is_final'] = false;
    $resolvers['htaccess_id']['next'] = 'dmn';

    $resolvers['htaccess_group_id'] = array();
    $resolvers['htaccess_group_id']['query'] = 'SELECT dmn_id FROM htaccess_groups WHERE id = ? LIMIT 1;';
    $resolvers['htaccess_group_id']['is_final'] = false;
    $resolvers['htaccess_group_id']['next'] = 'dmn';

    $resolvers['htaccess_user_id'] = array();
    $resolvers['htaccess_user_id']['query'] = 'SELECT dmn_id FROM htaccess_users WHERE id = ? LIMIT 1;';
    $resolvers['htaccess_user_id']['is_final'] = false;
    $resolvers['htaccess_user_id']['next'] = 'dmn';

    $resolvers['hosting_plan_id'] = array();
    $resolvers['hosting_plan_id']['query'] = 'SELECT reseller_id FROM hosting_plans WHERE id = ? LIMIT 1;';
    $resolvers['hosting_plan_id']['is_final'] = true;

    if (isset($resolvers[$type])) {
        $r = $resolvers[$type];
        if ($r['query']) {
            $matches = array();
            if (!preg_match('/SELECT[ \t]+([a-z0-9\_]+)[ \t]+FROM/i', $r['query'], $matches)) {
                system_message(tr('Unknown Error'));
            }
            $select = $matches[1];
            $rs = exec_query($sql, $r['query'], $id);
            if ($rs->RecordCount() != 0) {
                if ($r['is_final']) {
                    $who = $rs->fields[$select];
                } else {
                    $who = who_owns_this($rs->fields[$select], $r['next']);
                }
            }
        } else {
            $ex = explode($r['separator'], $id);
            if (!$r['is_final']) {
                $who = who_owns_this($r['pos'], $r['next']);
            } else {
                $who = $ex[$r['pos']];
            }
        }
    }

    if ($type != 'admin' && (empty($who) || $who <= 0)) {
        $who = null;
    }

    return $who;

}

?>