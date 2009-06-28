<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright	2001-2006 by moleSoftware GmbH
 * @copyright	2006-2009 by ispCP | http://isp-control.net
 * @version		SVN: $Id: checkout.php 1744 2009-05-07 03:21:47Z haeber $
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

/**
 * Validate activation parameters
 * @param integer $order_id ID in table orders
 * @param string $key hash value to compare with
 * @return boolean true - validation correct
 */
function validate_order_key($order_id, $key) {
	$result = false;
	$sql = Database::getInstance();
	$query = <<<SQL_QUERY
		SELECT
			*
		FROM
			`orders`
		WHERE
			`id` = ?
		AND
			`status` = ?
SQL_QUERY;
	$rs = exec_query($sql, $query, array($order_id, 'unconfirmed'));
	if ($rs->RecordCount() == 1) {
		$domain_name 	= $rs->fields['domain_name'];
		$admin_id 		= $rs->fields['user_id'];
		$coid = Config::exists('CUSTOM_ORDERPANEL_ID') ? Config::get('CUSTOM_ORDERPANEL_ID'): '';
		$ckey = sha1($order_id.'-'.$domain_name.'-'.$admin_id.'-'.$coid);
		if ($ckey == $key) $result = true;
	}	
	return $result;
}

/**
 * Set order to confirmed so that reseller can activate this
 * @param integer $order_id
 */
function confirm_order($order_id) {

	$sql = Database::getInstance();
	$query = <<<SQL_QUERY
		SELECT
			*
		FROM
			`orders`
		WHERE
			`id` = ?
SQL_QUERY;
	$rs = exec_query($sql, $query, array($order_id));
	if ($rs->RecordCount() == 1) {

		$query = <<<SQL_QUERY
		UPDATE `orders` SET `status`=? WHERE `id`=?
SQL_QUERY;
		exec_query($sql, $query, array('new', $order_id));

		$admin_id 		= $rs->fields['user_id'];
		$domain_name 	= $rs->fields['domain_name'];
		$ufname			= $rs->fields['fname'];
		$ulname			= $rs->fields['lname'];
		$uemail			= $rs->fields['email'];
		$name = trim($ufname.' '.$ulname);

		$data = get_order_email($admin_id);

		$from_name = $data['sender_name'];
		$from_email = $data['sender_email'];

		$search [] = '{DOMAIN}';
		$replace[] = $domain_name;
		$search [] = '{MAIL}';
		$replace[] = $uemail;
		$search [] = '{NAME}';
		$replace[] = $name;

		if ($from_name) {
			$from = '"' . encode($from_name) . "\" <" . $from_email . ">";
		} else {
			$from = $from_email;
		}

		// moved from reseller-functions.php:
		// let's send mail to the reseller => new order
		$subject = encode(tr("You have a new order"));

		$message = tr('

Dear {RESELLER},
you have a new order from {NAME} <{MAIL}> for domain {DOMAIN}

Please login into your ispCP control panel for more details.

	');
		$search [] = '{RESELLER}';
		$replace[] = $from_name;
		$message = str_replace($search, $replace, $message);
		$message = html_entity_decode($message, ENT_QUOTES, 'UTF-8');

		$headers = "From: ". $from . "\n";
		$headers .= "MIME-Version: 1.0\n" . "Content-Type: text/plain; charset=utf-8\n" . "Content-Transfer-Encoding: 8bit\n" . "X-Mailer: ispCP " . Config::get('Version') . " Service Mailer";

		mail($from, $subject, $message, $headers);
	}	
}

if (!isset($_GET['id']) || !is_numeric($_GET['id']) || !isset($_GET['k'])) {
	system_message(tr('You do not have permission to access this interface!'));
}


$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::get('PURCHASE_TEMPLATE_PATH') . '/activate.tpl');
$tpl->define_dynamic('page_message', 'page');

$theme_color = isset($_SESSION['user_theme'])
	? $_SESSION['user_theme']
	: Config::get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'THEME_COLOR_PATH' => '../themes/' . $theme_color,
		'THEME_CHARSET' => tr('encoding')
	)
);


if (validate_order_key($_GET['id'], $_GET['k'])) {
	confirm_order($_GET['id']);
	$msg = tr('Your order has been successfully created.');
} else {
	$msg = tr('Error creating order! Perhaps already activated?');
}

$tpl->assign('ORDER_STATUS_MESSAGE', $msg);
$tpl->assign('PAGE_TITLE', tr('Order confirmation'));

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}