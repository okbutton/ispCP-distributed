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

$theme_color = Config::get('USER_INITIAL_THEME');

if (isset($_GET['hpid']) && is_numeric($_GET['hpid']))
	$hpid = $_GET['hpid'];
else {
	$_SESSION['hp_deleted'] = '_no_';
	user_goto('hosting_plan.php');
}

// Check if there is no order for this plan
$res = exec_query($sql, "SELECT COUNT(`id`) FROM `orders` WHERE `plan_id` = ?", array($hpid));
$data = $res->FetchRow();
if ($data['0'] > 0) {
	$_SESSION['hp_deleted_ordererror'] = '_yes_';
	user_goto('hosting_plan.php');
}

// Try to delete hosting plan from db
$query = "DELETE FROM `hosting_plans` WHERE `id` = ? AND `reseller_id` = ?";
$res = exec_query($sql, $query, array($hpid, $_SESSION['user_id']));

$_SESSION['hp_deleted'] = '_yes_';

user_goto('hosting_plan.php');
