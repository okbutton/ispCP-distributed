<?php
//   -------------------------------------------------------------------------------
//  |             VHCS(tm) - Virtual Hosting Control System                         |
//  |              Copyright (c) 2001-2005 by moleSoftware		            		|
//  |			http://vhcs.net | http://www.molesoftware.com		           		|
//  |                                                                               |
//  | This program is free software; you can redistribute it and/or                 |
//  | modify it under the terms of the MPL General Public License                   |
//  | as published by the Free Software Foundation; either version 1.1              |
//  | of the License, or (at your option) any later version.                        |
//  |                                                                               |
//  | You should have received a copy of the MPL Mozilla Public License             |
//  | along with this program; if not, write to the Open Source Initiative (OSI)    |
//  | http://opensource.org | osi@opensource.org								    |
//  |                                                                               |
//   -------------------------------------------------------------------------------



include '../include/vhcs-lib.php';

check_login();

$reseller_id = $_SESSION['user_id'];


if(isset($_GET['order_id']) && is_numeric($_GET['order_id'])){
	$order_id = $_GET['order_id'];
}else{
	set_page_message(tr('Wrong order ID!'));
	Header("Location: orders.php");
	die();
}



$query = <<<SQL_QUERY
	select
		id
	from
		orders
	where
			id = ?
		and
			user_id = ?
SQL_QUERY;

	$rs = exec_query($sql, $query, array($order_id, $reseller_id));

		if ($rs -> RecordCount() == 0) {

			set_page_message(tr('Permission deny!'));
			header('Location: orders.php');
			die();
		}

//delete all FTP Accounts
  $query = <<<SQL_QUERY
          delete from
              orders
          where
              id = ?
SQL_QUERY;
  $rs = exec_query($sql, $query, array($order_id));

set_page_message(tr('Customer order was removed successful!'));

write_log($_SESSION['user_logged'].": delete customer order.");
header( "Location: orders.php");
die();
?>
