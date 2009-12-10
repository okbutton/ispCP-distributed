<?php
/**
 * ispCP ω (OMEGA) a Virtual Hosting Control System
 *
 * @copyright 	2001-2006 by moleSoftware GmbH
 * @copyright 	2006-2008 by ispCP | http://isp-control.net
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
 * Portions created by the ispCP Team are Copyright (C) 2006-2009 by
 * isp Control Panel. All Rights Reserved.
 */

require '../include/ispcp-lib.php';

check_login(__FILE__);

$tpl = new pTemplate();
$tpl->define_dynamic('page', Config::get('CLIENT_TEMPLATE_PATH') . '/domains_manage.tpl');
$tpl->define_dynamic('page_message', 'page');
$tpl->define_dynamic('logged_from', 'page');
$tpl->define_dynamic('als_message', 'page');
$tpl->define_dynamic('als_list', 'page');
$tpl->define_dynamic('als_item', 'als_list');
$tpl->define_dynamic('sub_message', 'page');
$tpl->define_dynamic('sub_list', 'page');
$tpl->define_dynamic('sub_item', 'sub_list');
$tpl->define_dynamic('dns_message', 'page');
$tpl->define_dynamic('dns_list', 'page');
$tpl->define_dynamic('dns_item','dns_list');


// page functions.

function gen_user_dns_list(&$tpl, &$sql, $user_id) {
	$domain_id = get_user_domain_id($sql, $user_id);

	$query = "
		SELECT
			`domain_dns`.`domain_dns_id`,
			`domain_dns`.`domain_id`,
			`domain_dns`.`domain_dns`,
			`domain_dns`.`domain_class`,
			`domain_dns`.`domain_type`,
			`domain_dns`.`domain_text`,
			IFNULL(`domain_aliasses`.`alias_name`, `domain`.`domain_name`) AS domain_name,
			IFNULL(`domain_aliasses`.`alias_status`, `domain`.`domain_status`) AS domain_status
		FROM
			`domain_dns`
			LEFT JOIN `domain_aliasses` USING (`alias_id`, `domain_id`),
			`domain`
		WHERE
			`domain_dns`.`domain_id` = ?
		AND
			`domain`.`domain_id` = `domain_dns`.`domain_id`
		ORDER BY
				`domain_id`,
				`alias_id`,
				`domain_dns`,
				`domain_type`
	";

	$rs = exec_query($sql, $query, array($domain_id));
	if ($rs->RecordCount() == 0) {
		$tpl->assign(array('DNS_MSG' => tr("Manual zone's records list is empty!"), 'DNS_LIST' => ''));
		$tpl->parse('DNS_MESSAGE', 'dns_message');
	} else {
		$counter = 0;

		while (!$rs->EOF) {
			if ($counter % 2 == 0) {
				$tpl->assign('ITEM_CLASS', 'content');
			} else {
				$tpl->assign('ITEM_CLASS', 'content2');
			}

			list($dns_action_delete, $dns_action_script_delete) = gen_user_dns_action('Delete', $rs->fields['domain_dns_id'], $rs->fields['domain_status']);
			list($dns_action_edit, $dns_action_script_edit) = gen_user_dns_action('Edit', $rs->fields['domain_dns_id'], $rs->fields['domain_status']);

			$domain_name = decode_idna($rs->fields['domain_name']);
			$sbd_name = $rs->fields['domain_dns'];
			$sbd_data = $rs->fields['domain_text'];
			$tpl->assign(
				array(
					'DNS_DOMAIN'				=> $domain_name,
					'DNS_NAME'					=> $sbd_name,
					'DNS_CLASS'					=> $rs->fields['domain_class'],
					'DNS_TYPE'					=> $rs->fields['domain_type'],
					'DNS_DATA'					=> $sbd_data,
//					'DNS_ACTION_SCRIPT_EDIT'	=> $sub_action,
					'DNS_ACTION_SCRIPT_DELETE'	=> $dns_action_script_delete,
					'DNS_ACTION_DELETE'			=> $dns_action_delete,
					'DNS_ACTION_SCRIPT_EDIT'	=> $dns_action_script_edit,
					'DNS_ACTION_EDIT'			=> $dns_action_edit,
					'DNS_TYPE_RECORD'			=> tr("%s record", $rs->fields['domain_type'])
				)
			);
			$tpl->parse('DNS_ITEM', '.dns_item');
			$rs->MoveNext();
			$counter++;
		}

		$tpl->parse('DNS_LIST', 'dns_list');
		$tpl->assign('DNS_MESSAGE', '');
	}
}

function gen_user_dns_action($action, $dns_id, $status) {
	if ($status === Config::get('ITEM_OK_STATUS')) {
		return array(tr($action), 'dns_'.strtolower($action).'.php?edit_id='.$dns_id);
	} else {
		return array(tr('N/A'), '#');
	}
}

function gen_user_sub_action($sub_id, $sub_status) {
	if ($sub_status === Config::get('ITEM_OK_STATUS')) {
		return array(tr('Delete'), "subdomain_delete.php?id=$sub_id");
	} else {
		return array(tr('N/A'), '#');
	}
}

function gen_user_alssub_action($sub_id, $sub_status) {
	if ($sub_status === Config::get('ITEM_OK_STATUS')) {
		return array(tr('Delete'), "alssub_delete.php?id=$sub_id");
	} else {
		return array(tr('N/A'), '#');
	}
}

function gen_user_sub_list(&$tpl, &$sql, $user_id) {
	$domain_id = get_user_domain_id($sql, $user_id);

	$query = "
		SELECT
			`subdomain_id`,
			`subdomain_name`,
			`subdomain_mount`,
			`subdomain_status`,
			`domain_name`
		FROM
			`subdomain` JOIN `domain`
		ON
			`subdomain`.`domain_id` = `domain`.`domain_id`
		WHERE
			`subdomain`.`domain_id` = ?
		ORDER BY
			`subdomain_name`
";

	$query2 = "
		SELECT
			`subdomain_alias_id`,
			`subdomain_alias_name`,
			`subdomain_alias_mount`,
			`subdomain_alias_status`,
			`alias_name`
		FROM
			`subdomain_alias` JOIN `domain_aliasses`
		ON
			`subdomain_alias`.`alias_id` = `domain_aliasses`.`alias_id`
		WHERE
			`domain_id` = ?
		ORDER BY
			`subdomain_alias_name`
	";

	$rs = exec_query($sql, $query, array($domain_id));
	$rs2 = exec_query($sql, $query2, array($domain_id));

	if (($rs->RecordCount() + $rs2->RecordCount()) == 0) {
		$tpl->assign(array('SUB_MSG' => tr('Subdomain list is empty!'), 'SUB_LIST' => ''));
		$tpl->parse('SUB_MESSAGE', 'sub_message');
	} else {
		$counter = 0;
		while (!$rs->EOF) {
			$tpl->assign('ITEM_CLASS', ($counter % 2 == 0) ? 'content' : 'content2');

			list($sub_action, $sub_action_script) = gen_user_sub_action($rs->fields['subdomain_id'], $rs->fields['subdomain_status']);
			$sbd_name = decode_idna($rs->fields['subdomain_name']);
			$tpl->assign(
				array(
					'SUB_NAME'			=> $sbd_name,
					'SUB_ALIAS_NAME'	=> $rs->fields['domain_name'],
					'SUB_MOUNT'			=> $rs->fields['subdomain_mount'],
					'SUB_STATUS'		=> translate_dmn_status($rs->fields['subdomain_status']),
					'SUB_ACTION'		=> $sub_action,
					'SUB_ACTION_SCRIPT'	=> $sub_action_script
				)
			);
			$tpl->parse('SUB_ITEM', '.sub_item');
			$rs->MoveNext();
			$counter++;
		}
		while (!$rs2->EOF) {
			$tpl->assign('ITEM_CLASS', ($counter % 2 == 0) ? 'content' : 'content2');

			list($sub_action, $sub_action_script) = gen_user_alssub_action($rs2->fields['subdomain_alias_id'], $rs2->fields['subdomain_alias_status']);
			$sbd_name = decode_idna($rs2->fields['subdomain_alias_name']);
			$tpl->assign(
				array(
					'SUB_NAME'			=> $sbd_name,
					'SUB_ALIAS_NAME'	=> $rs2->fields['alias_name'],
					'SUB_MOUNT'			=> $rs2->fields['subdomain_alias_mount'],
					'SUB_STATUS'		=> translate_dmn_status($rs2->fields['subdomain_alias_status']),
					'SUB_ACTION'		=> $sub_action,
					'SUB_ACTION_SCRIPT'	=> $sub_action_script
				)
			);
			$tpl->parse('SUB_ITEM', '.sub_item');
			$rs2->MoveNext();
			$counter++;
		}

		$tpl->parse('SUB_LIST', 'sub_list');
		$tpl->assign('SUB_MESSAGE', '');
	}
}

function gen_user_als_action($als_id, $als_status) {
	if ($als_status === Config::get('ITEM_OK_STATUS')) {
		return array(tr('Delete'), 'alias_delete.php?id=' . $als_id);
	} else if ($als_status === Config::get('ITEM_ORDERED_STATUS')) {
		return array(tr('Delete order'), 'alias_order_delete.php?del_id=' . $als_id);
	} else {
		return array(tr('N/A'), '#');
	}
}

function gen_user_als_forward($als_id, $als_status, $url_forward) {
	if ($url_forward === 'no') {
		if ($als_status === 'ok') {
			return array("-", "alias_edit.php?edit_id=" . $als_id, tr("Edit"));
		} else if ($als_status === 'ordered') {
			return array("-", "#", tr("N/A"));
		} else {
			return array(tr("N/A"), "#", tr("N/A"));
		}
	} else {
		if ($als_status === 'ok') {
			return array($url_forward, "alias_edit.php?edit_id=" . $als_id, tr("Edit"));
		} else if ($als_status === 'ordered') {
			return array($url_forward, "#", tr("N/A"));
		} else {
			return array(tr("N/A"), "#", tr("N/A"));
		}
	}
}

function gen_user_als_list(&$tpl, &$sql, $user_id) {
	$domain_id = get_user_domain_id($sql, $user_id);

	$query = "
		SELECT
			`alias_id`,
			`alias_name`,
			`alias_status`,
			`alias_mount`,
			`alias_ip_id`,
			`url_forward`
		FROM
			`domain_aliasses`
		WHERE
			`domain_id` = ?
		ORDER BY
			`alias_mount`,
			`alias_name`
	";

	$rs = exec_query($sql, $query, array($domain_id));

	if ($rs->RecordCount() == 0) {
		$tpl->assign(array('ALS_MSG' => tr('Alias list is empty!'), 'ALS_LIST' => ''));
		$tpl->parse('ALS_MESSAGE', 'als_message');
	} else {
		$counter = 0;
		while (!$rs->EOF) {
			$tpl->assign('ITEM_CLASS', ($counter % 2 == 0) ? 'content' : 'content2');

			list($als_action, $als_action_script) = gen_user_als_action($rs->fields['alias_id'], $rs->fields['alias_status']);
			list($als_forward, $alias_edit_link, $als_edit) = gen_user_als_forward($rs->fields['alias_id'], $rs->fields['alias_status'], $rs->fields['url_forward']);

			$alias_name = decode_idna($rs->fields['alias_name']);
			$als_forward = decode_idna($als_forward);
			$tpl->assign(
				array(
					'ALS_NAME'			=> $alias_name,
					'ALS_MOUNT'			=> $rs->fields['alias_mount'],
					'ALS_STATUS'		=> translate_dmn_status($rs->fields['alias_status']),
					'ALS_FORWARD'		=> $als_forward,
					'ALS_EDIT_LINK'		=> $alias_edit_link,
					'ALS_EDIT'			=> $als_edit,
					'ALS_ACTION'		=> $als_action,
					'ALS_ACTION_SCRIPT'	=> $als_action_script
				)
			);
			$tpl->parse('ALS_ITEM', '.als_item');
			$rs->MoveNext();
			$counter++;
		}

		$tpl->parse('ALS_LIST', 'als_list');
		$tpl->assign('ALS_MESSAGE', '');
	}
}

// common page data.

$theme_color = Config::get('USER_INITIAL_THEME');

$tpl->assign(
	array(
		'TR_CLIENT_MANAGE_DOMAINS_PAGE_TITLE'	=> tr('ispCP - Client/Manage Domains'),
		'THEME_COLOR_PATH'						=> "../themes/$theme_color",
		'THEME_CHARSET'							=> tr('encoding'),
		'ISP_LOGO'								=> get_logo($_SESSION['user_id'])
	)
);

// dynamic page data.

gen_user_sub_list($tpl, $sql, $_SESSION['user_id']);
gen_user_als_list($tpl, $sql, $_SESSION['user_id']);
gen_user_dns_list($tpl, $sql, $_SESSION['user_id']);
// static page messages.

gen_client_mainmenu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/main_menu_manage_domains.tpl');
gen_client_menu($tpl, Config::get('CLIENT_TEMPLATE_PATH') . '/menu_manage_domains.tpl');

gen_logged_from($tpl);

check_permissions($tpl);

$tpl->assign(
	array(
		'TR_MANAGE_DOMAINS'	=> tr('Manage domains'),
		'TR_DOMAIN_ALIASES'	=> tr('Domain aliases'),
		'TR_ALS_NAME'		=> tr('Name'),
		'TR_ALS_MOUNT'		=> tr('Mount point'),
		'TR_ALS_FORWARD'	=> tr('Forward'),
		'TR_ALS_STATUS'		=> tr('Status'),
		'TR_ALS_ACTION'		=> tr('Action'),
		'TR_SUBDOMAINS'		=> tr('Subdomains'),
		'TR_SUB_NAME'		=> tr('Name'),
		'TR_SUB_MOUNT'		=> tr('Mount point'),
		'TR_SUB_STATUS'		=> tr('Status'),
		'TR_SUB_ACTION'		=> tr('Actions'),
		'TR_MESSAGE_DELETE'	=> tr('Are you sure you want to delete %s?', true, '%s'),
		'TR_DNS'			=> tr("DNS zone's records (EXPERIMENTAL)"),
		'TR_DNS_NAME'		=> tr('Name'),
		'TR_DNS_CLASS'		=> tr('Class'),
		'TR_DNS_TYPE'		=> tr('Type'),
		'TR_DNS_ACTION'		=> tr('Actions'),
		'TR_DNS_DATA'		=> tr('Record data'),
		'TR_DOMAIN_NAME'	=> tr('Domain')
	)
);

gen_page_message($tpl);
$tpl->parse('PAGE', 'page');
$tpl->prnt();

if (Config::get('DUMP_GUI_DEBUG')) {
	dump_gui_debug();
}
unset_messages();
