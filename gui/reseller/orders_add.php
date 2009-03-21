<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright	2001-2006 by moleSoftware GmbH
 * @copyright	2006-2009 by ispCP | http://isp-control.net
 * @version		SVN: $Id$
 * @link		http://isp-control.net
 * @author		ispCP Team
 *
 * @license
 *   This program is free software; you can redistribute it and/or modify it under
 *   the terms of the MPL General Public License as published by the Free Software
 *   Foundation; either version 1.1 of the License, or (at your option) any later
 *   version.
 *   You should have received a copy of the MPL Mozilla Public License along with
 *   this program; if not, write to the Open Source Initiative (OSI)
 *   http://opensource.org | osi@opensource.org
 */

require '../include/ispcp-lib.php';

check_login(__FILE__);

$reseller_id = $_SESSION['user_id'];

if (isset($_GET['order_id']) && is_numeric($_GET['order_id'])) {
	$order_id = $_GET['order_id'];
} else {
	set_page_message(tr('Wrong order ID!'));
	header("Location: orders.php");
	die();
}

if (Config::exists('HOSTING_PLANS_LEVEL') && Config::get('HOSTING_PLANS_LEVEL') === 'admin') {
	$query = "
		SELECT
			*
		FROM
			`orders`
		WHERE
			`id` = ?
	";

	$rs = exec_query($sql, $query, array($order_id));
} else {
	$query = "
		SELECT
			*
		FROM
			`orders`
		WHERE
			`id` = ?
		AND
			`user_id` = ?
	";

	$rs = exec_query($sql, $query, array($order_id, $reseller_id));
}

if ($rs->RecordCount() == 0 || !isset($_SESSION['domain_ip'])) {
	set_page_message(tr('Permission deny!'));
	header('Location: orders.php');
	die();
}

$domain_ip		= $_SESSION['domain_ip'];
$dmn_user_name	= $rs->fields['domain_name'];
$dmn_user_name	= decode_idna($dmn_user_name);
$hpid			= $rs->fields['plan_id'];
$first_name		= $rs->fields['fname'];
$last_name		= $rs->fields['lname'];
$firm			= $rs->fields['firm'];
$zip			= $rs->fields['zip'];
$city			= $rs->fields['city'];
$state			= $rs->fields['state'];
$country		= $rs->fields['country'];
$phone			= $rs->fields['phone'];
$fax			= $rs->fields['fax'];
$street_one		= $rs->fields['street1'];
$street_two		= $rs->fields['street2'];
$customer_id	= $rs->fields['customer_id'];
$user_email		= $rs->fields['email'];
// lets check the reseller limits
$err_msg = "";

if (Config::exists('HOSTING_PLANS_LEVEL') && Config::get('HOSTING_PLANS_LEVEL') === 'admin') {
	$query = "SELECT `props` FROM `hosting_plans` WHERE `id` = ?";
	$res = exec_query($sql, $query, array($hpid));
} else {
	$query = "SELECT `props` FROM `hosting_plans` WHERE `reseller_id` = ? AND `id` = ?";
	$res = exec_query($sql, $query, array($reseller_id, $hpid));
}
$data = $res->FetchRow();
$props = $data['props'];

$_SESSION["ch_hpprops"] = $props;

if (!reseller_limits_check($sql, $err_msg, $reseller_id, $hpid)) {
	set_page_message(tr("Order Canceled: resellers maximum exceeded!"));
	header('Location: orders.php');
	die();
}

if (!empty($err_msg)) {
	set_page_message($err_msg);
	unset($_SESSION['domain_ip']);
	header('Location: orders.php');
	die();
}
unset($_SESSION["ch_hpprops"]);
list($php, $cgi, $sub,
	$als, $mail, $ftp,
	$sql_db, $sql_user,
	$traff, $disk) = explode(";", $props);

$php = preg_replace("/\_/", "", $php);
$cgi = preg_replace("/\_/", "", $cgi);

$timestamp = time();
$pure_user_pass = substr($timestamp, 0, 6);
$inpass = crypt_user_pass($pure_user_pass);

if (!chk_dname($dmn_user_name)) {
	set_page_message(tr('Wrong domain name syntax!'));
	unset($_SESSION['domain_ip']);
	header('Location: orders.php');
	die();
}
if (ispcp_domain_exists($dmn_user_name, $_SESSION['user_id'])) {
	set_page_message(tr('Domain with that name already exists on the system!'));
	unset($_SESSION['domain_ip']);
	header('Location: orders.php');
	die();
}

check_for_lock_file();

$query = "
	INSERT INTO `admin` (
		`admin_name`, `admin_pass`, `admin_type`, `domain_created`,
		`created_by`, `fname`, `lname`,
		`firm`, `zip`, `city`, `state`,
		`country`, `email`, `phone`,
		`fax`, `street1`, `street2`, `customer_id`
	) VALUES (
		?, ?, 'user', unix_timestamp(),
		?, ?, ?,
		?, ?, ?, ?,
		?, ?, ?,
		?, ?, ?, ?
	)
";

$res = exec_query($sql, $query, array($dmn_user_name, $inpass, $reseller_id, $first_name, $last_name,
		$firm, $zip, $city, $state, $country, $user_email, $phone, $fax, $street_one, $street_two, $customer_id));

print $sql->ErrorMsg();

$record_id = $sql->Insert_ID();

$query = "
	SELECT
		`reseller_ips`
	FROM
		`reseller_props`
	WHERE
		`reseller_id` = ?
";

$rs = exec_query($sql, $query, array($reseller_id));
$domain_ip = $rs->fields['reseller_ips'];
$status = Config::get('ITEM_ADD_STATUS');


$query = "
	INSERT INTO domain (
		`domain_name`, `domain_admin_id`,
		`domain_created_id`, `domain_created`,
		`domain_mailacc_limit`, `domain_ftpacc_limit`,
		`domain_traffic_limit`, `domain_sqld_limit`,
		`domain_sqlu_limit`, `domain_status`,
		`domain_subd_limit`, `domain_alias_limit`,
		`domain_ip_id`, `domain_disk_limit`,
		`domain_disk_usage`, `domain_php`, `domain_cgi`
	) VALUES (
		?, ?,
		?, unix_timestamp(),
		?, ?,
		?, ?,
		?, ?,
		?, ?,
		?, ?,
		'0', ?, ?
	)
";

$res = exec_query($sql, $query, array($dmn_user_name,
		$record_id,
		$reseller_id,
		$mail,
		$ftp,
		$traff,
		$sql_db,
		$sql_user,
		$status,
		$sub,
		$als,
		$domain_ip,
		$disk,
		$php,
		$cgi));
$dmn_id = $sql->Insert_ID();

//Add statistics group

$query = "
	INSERT INTO `htaccess_users`
		(`dmn_id`, `uname`, `upass`, `status`)
	VALUES
		(?, ?, ?, ?)
";
$rs = exec_query($sql, $query, array($dmn_id, $dmn_user_name, crypt_user_pass_with_salt($pure_user_pass), $status));

$user_id = $sql->Insert_ID();

$awstats_auth = Config::get('AWSTATS_GROUP_AUTH');

$query = "
	INSERT INTO `htaccess_groups`
		(`dmn_id`, `ugroup`, `members`, `status`)
	VALUES
		(?, ?, ?, ?)
";
$rs = exec_query($sql, $query, array($dmn_id, $awstats_auth, $user_id, $status));

// Create the 3 default addresses if wanted
if (Config::get('CREATE_DEFAULT_EMAIL_ADDRESSES')) client_mail_add_default_accounts($dmn_id, $user_email, $dmn_user_name); // 'domain', 0

// ispcp 2.5 feature
// add_domain_extras($dmn_id, $record_id, $sql);
// lets send mail to user
send_add_user_auto_msg ($reseller_id,
	$dmn_user_name,
	$pure_user_pass,
	$user_email,
	$first_name,
	$last_name,
	tr('Domain account')
	);

// add user into user_gui_props => domain looser needs language and skin too :-)
$user_def_lang = $_SESSION['user_def_lang'];
$user_theme_color = $_SESSION['user_theme'];

$query = "
	INSERT INTO `user_gui_props`
		(`user_id`, `lang`, `layout` )
	VALUES
		( ?, ?, ? )
";

$res = exec_query($sql, $query, array($record_id,
		$user_def_lang,
		$user_theme_color));

// send query to the ispcp daemon
send_request();

$admin_login = $_SESSION['user_logged'];
write_log("$admin_login: add user: $dmn_user_name (for domain $dmn_user_name)");
write_log("$admin_login: add domain: $dmn_user_name");

au_update_reseller_props($reseller_id, $props);
set_page_message(tr('User added!'));
$query = "
	UPDATE
		`orders`
	SET
		`status` = ?
	WHERE
		`id` = ?
";
exec_query($sql, $query, array('added', $order_id));

unset($_SESSION['domain_ip']);
header("Location: users.php");
die();

?>
