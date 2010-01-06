<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2010 by ispCP | http://isp-control.net
 * @version 	SVN: $ID$
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

// Begin page line
require '../include/ispcp-lib.php';

check_login(__FILE__);

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::get('RESELLER_TEMPLATE_PATH') . '/orders.tpl');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('page_message', 'page');
// Table with orders
$tpl->define_dynamic('orders_table', 'page');
$tpl->define_dynamic('order', 'orders_table');
// scrolling
$tpl->define_dynamic('scroll_prev_gray', 'page');
$tpl->define_dynamic('scroll_prev', 'page');
$tpl->define_dynamic('scroll_next_gray', 'page');
$tpl->define_dynamic('scroll_next', 'page');

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_RESELLER_MAIN_INDEX_PAGE_TITLE'	=> tr('ispCP - Reseller/Order management'),
		'THEME_COLOR_PATH'					=> "../themes/$theme_color",
		'THEME_CHARSET'						=> tr('encoding'),
		'ISP_LOGO'							=> get_logo($_SESSION['user_id'])
	)
);

/*
 * Functions
 */

function gen_order_page(&$tpl, &$sql, $user_id) {
	$start_index = 0;
	$current_psi = 0;

	if (isset($_GET['psi']) && is_numeric($_GET['psi'])) {
		$start_index = $_GET['psi'];
		$current_psi = $_GET['psi'];
	}

	$rows_per_page = Config::get('DOMAIN_ROWS_PER_PAGE');
	// count query
	$count_query = "
		SELECT
			COUNT(`id`) AS cnt
		FROM
			`orders`
		WHERE
			`user_id` = ?
		AND
			`status` != ?
	";
	// let's count
	$rs = exec_query($sql, $count_query, array($user_id, 'added'));
	$records_count = $rs->fields['cnt'];

	$query = "
		SELECT
			*
		FROM
			`orders`
		WHERE
			`user_id` = ?
		AND
			`status` != ?
		ORDER BY
			`date` DESC
		LIMIT
			$start_index, $rows_per_page
	";
	$rs = exec_query($sql, $query, array($user_id, 'added'));

	$prev_si = $start_index - $rows_per_page;

	if ($start_index == 0) {
		$tpl->assign('SCROLL_PREV', '');
	} else {
		$tpl->assign(
			array(
				'SCROLL_PREV_GRAY' => '',
				'PREV_PSI' => $prev_si
			)
		);
	}

	$next_si = $start_index + $rows_per_page;

	if ($next_si + 1 > $records_count) {
		$tpl->assign('SCROLL_NEXT', '');
	} else {
		$tpl->assign(
			array(
				'SCROLL_NEXT_GRAY' => '',
				'NEXT_PSI' => $next_si
			)
		);
	}

	if ($rs->RecordCount() == 0) {
		set_page_message(tr('You do not have new orders!'));
		$tpl->assign('ORDERS_TABLE', '');
		$tpl->assign('SCROLL_NEXT_GRAY', '');
		$tpl->assign('SCROLL_PREV_GRAY', '');
	} else {
		$counter = 0;
		while (!$rs->EOF) {
			$plan_id = $rs->fields['plan_id'];
			$order_status = tr('New order');
			// let's get hosting plan name
			$planname_query = "
				SELECT
					`name`
				FROM
					`hosting_plans`
				WHERE
					`id` = ?
			";
			$rs_planname = exec_query($sql, $planname_query, array($plan_id));
			$plan_name = $rs_planname->fields['name'];

			$tpl->assign('ITEM_CLASS', ($counter % 2 == 0) ? 'content' : 'content2');

			$status = $rs->fields['status'];
			if ($status === 'update') {
				$customer_id = $rs->fields['customer_id'];
				$cusrtomer_query = "
					SELECT
						*
					FROM
						`admin`
					WHERE
						`admin_id` = ?
				";
				$rs_customer = exec_query($sql, $cusrtomer_query, array($customer_id));
				$user_details = $rs_customer->fields['fname'] . "&nbsp;" . $rs_customer->fields['lname'] . "<br /><a href=\"mailto:" . $rs_customer->fields['email'] . "\" class=\"link\">" . $rs_customer->fields['email'] . "</a><br />" . $rs_customer->fields['zip'] . "&nbsp;" . $rs_customer->fields['city'] . "&nbsp;" . $rs_customer->fields['state'] . "&nbsp;" . $rs_customer->fields['country'];
				$order_status = tr('Update order');
				$tpl->assign('LINK', 'orders_update.php?order_id=' . $rs->fields['id']);
			} else {
				$user_details = $rs->fields['fname'] . "&nbsp;" . $rs->fields['lname'] . "<br /><a href=\"mailto:" . $rs->fields['email'] . "\" class=\"link\">" . $rs->fields['email'] . "</a><br />" . $rs->fields['zip'] . "&nbsp;" . $rs->fields['city'] . "&nbsp;" . $rs->fields['state'] . "&nbsp;" . $rs->fields['country'];
				$tpl->assign('LINK', 'orders_detailst.php?order_id=' . $rs->fields['id']);
			}
			$tpl->assign(
				array(
					'ID'		=> $rs->fields['id'],
					'HP'		=> $plan_name,
					'DOMAIN'	=> $rs->fields['domain_name'],
					'USER'		=> $user_details,
					'STATUS'	=> $order_status,
				)
			);

			$tpl->parse('ORDER', '.order');
			$rs->MoveNext();
			$counter++;
		}
	}
}

// end of functions

/*
 *
 * static page messages.
 *
 */

gen_order_page($tpl, $sql, $_SESSION['user_id']);

gen_reseller_mainmenu($tpl, Config::get('RESELLER_TEMPLATE_PATH') . '/main_menu_orders.tpl');
gen_reseller_menu($tpl, Config::get('RESELLER_TEMPLATE_PATH') . '/menu_orders.tpl');

gen_logged_from($tpl);

$tpl->assign(
	array(
		'TR_MANAGE_ORDERS'			=> tr('Manage Orders'),
		'TR_ID'						=> tr('ID'),
		'TR_DOMAIN'					=> tr('Domain'),
		'TR_USER'					=> tr('Customer data'),
		'TR_ACTION'					=> tr('Action'),
		'TR_STATUS'					=> tr('Order'),
		'TR_EDIT'					=> tr('Edit'),
		'TR_DELETE'					=> tr('Delete'),
		'TR_DETAILS'				=> tr('Details'),
		'TR_HP'						=> tr('Hosting plan'),
		'TR_MESSAGE_DELETE_ACCOUNT'	=> tr('Are you sure you want to delete this order?', true),
		'TR_ADD'					=> tr('Add/Details')
	)
);

gen_page_message($tpl);

$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
