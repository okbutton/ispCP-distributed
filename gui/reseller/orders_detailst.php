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



// Begin page line
include '../include/vhcs-lib.php';

check_login();

$tpl = new pTemplate();
$tpl -> define_dynamic('page', $cfg['RESELLER_TEMPLATE_PATH'].'/orders_detailst.tpl');
$tpl -> define_dynamic('logged_from', 'page');
$tpl -> define_dynamic('ip_entry', 'page');
$tpl -> define_dynamic('page_message', 'page');

$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> assign(array('TR_RESELLER_MAIN_INDEX_PAGE_TITLE' => tr('VHCS - Reseller/Order details'),
                     'THEME_COLOR_PATH' => "../themes/$theme_color",
                     'THEME_CHARSET' => tr('encoding'),
                     'VHCS_LICENSE' => $cfg['VHCS_LICENSE'],
                     'ISP_LOGO' => get_logo($_SESSION['user_id'])));

// Functions
//*
//*
function gen_order_details (&$tpl, &$sql, $user_id, $order_id)
{

	$query = <<<SQL_QUERY
        select
            *
        from
            orders
        where
           id = ?
		and
			user_id = ?
			
SQL_QUERY;
 	$rs = exec_query($sql, $query, array($order_id, $user_id));
	if ($rs -> RecordCount() == 0) {
		set_page_message(tr('Permission deny!'));
		Header("Location: orders.php");
		die();
	}
	$plan_id = $rs -> fields['plan_id'];

	global $cfg;
	$date_formt = $cfg['DATE_FORMAT'];
	$date = date($date_formt, $rs -> fields['date']);

	if (isset($_POST['uaction'])) {
		$domain_name = $_POST['domain'];
		$customer_id = $_POST['customer_id'];
		$fname = $_POST['fname'];
		$lname = $_POST['lname'];
		$firm = $_POST['firm'];
		$zip = $_POST['zip'];
		$city = $_POST['city'];
		$country = $_POST['country'];
		$street1 = $_POST['street1'];
		$street2 = $_POST['street2'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$fax = $_POST['fax'];
	} else {
		
		$domain_name = $rs -> fields['domain_name'];
		$customer_id = $rs -> fields['customer_id'];
		$fname = $rs -> fields['fname'];
		$lname = $rs -> fields['lname'];
		$firm = $rs -> fields['firm'];
		$zip = $rs -> fields['zip'];
		$city = $rs -> fields['city'];
		$country = $rs -> fields['country'];
		$email = $rs -> fields['email'];
		$phone = $rs -> fields['phone'];
		$fax = $rs -> fields['fax'];
		$street1 = $rs -> fields['street1'];
		$street2 = $rs -> fields['street2'];
	}	
		$query = <<<SQL_QUERY
        select
            name, description
        from
            hosting_plans
        where
           id = ?
			
SQL_QUERY;
 	$rs = exec_query($sql, $query, array($plan_id));
	$plan_name = $rs -> fields['name']."<br>".$rs -> fields['description'];
	
	generate_ip_list($tpl, $_SESSION['user_id']);
	
	if ($customer_id === NULL) $customer_id = '';
	
	$tpl -> assign(array('ID' => $order_id,
                     'DATE' => $date,
					 'HP' => $plan_name,
					 'DOMAINNAME' => $domain_name,
					 'CUSTOMER_ID' => $customer_id,
					 'FNAME' => $fname,
                     'LNAME' => $lname,
                     'FIRM' => $firm,
					 'ZIP' => $zip,
					 'CITY' => $city,
					 'COUNTRY' => $country,
					 'EMAIL' => $email,
					 'PHONE' => $phone,
					 'FAX' => $fax,
					 'STREET1' => $street1,
					 'STREET2' => $street2));
	

}

function update_order_details(&$tpl, &$sql, $user_id, $order_id)
{

$domain = strtolower($_POST['domain']);
$domain = get_punny($domain);
$customer_id = strip_html($_POST['customer_id']);
$fname = strip_html($_POST['fname']);
$lname = strip_html($_POST['lname']);
$firm = strip_html($_POST['firm']);
$zip = strip_html($_POST['zip']);
$city = strip_html($_POST['city']);
$country = strip_html($_POST['country']);
$street1 = strip_html($_POST['street1']);
$street2 = strip_html($_POST['street2']);
$email = strip_html($_POST['email']);
$phone = strip_html($_POST['phone']);
$fax = strip_html($_POST['fax']);

   $query = <<<SQL_QUERY
            update
                orders
            set
                domain_name=?,
				customer_id=?,
                fname=?,
                lname=?,
                firm=?,
                zip=?,
                city=?,
                country=?,
                email=?,
                phone=?,
                fax=?,
                street1=?,
                street2=?
            where
                id=?
			and
				user_id=?
SQL_QUERY;
    exec_query($sql, $query, array($domain, $customer_id, $fname, $lname, $firm, $zip, $city, $country, $email, $phone, $fax, $street1, $street2, $order_id, $user_id));
	

}

//
// end of functions
//


/*
 *
 * static page messages.
 *
 */
 
if(isset($_GET['order_id']) && is_numeric($_GET['order_id'])){
	$order_id = $_GET['order_id'];
}else{
	set_page_message(tr('Wrong order ID!'));
	Header("Location: orders.php");
	die();
}
 
if (isset($_POST['uaction'])){
	update_order_details($tpl, $sql, $_SESSION['user_id'], $order_id);
	
	if ($_POST['uaction'] === 'update_data') {
		set_page_message(tr('Order data updated successfully!'));
	} else if ($_POST['uaction'] === 'add_user') {
		$_SESSION['domain_ip'] = @$_POST['domain_ip'];
		Header("Location: orders_add.php?order_id=".$order_id);
		die();
	}
} 
 
gen_order_details($tpl, $sql, $_SESSION['user_id'], $order_id);

gen_reseller_menu($tpl, $cfg['RESELLER_TEMPLATE_PATH'].'/menu_orders.tpl');

gen_logged_from($tpl);


$tpl -> assign(array('TR_MANAGE_ORDERS' => tr('Manage Orders'),
                     'TR_DATE' => tr('Order date'),
					 'TR_HP' => tr('Hosting plan'),
					 'TR_HOSTING_INFO' => tr('Hosting details'),
					 'TR_DOMAIN' => tr('Domain'),
                     'TR_FIRST_NAME' => tr('First name'),
                     'TR_LAST_NAME' => tr('Last name'),
                     'TR_COMPANY' => tr('Company'),
                     'TR_ZIP_POSTAL_CODE' => tr('Zip/Postal code'),
                     'TR_CITY' => tr('City'),
                     'TR_COUNTRY' => tr('Country'),
                     'TR_STREET_1' => tr('Street 1'),
                     'TR_STREET_2' => tr('Street 2'),
                     'TR_EMAIL' => tr('Email'),
                     'TR_PHONE' => tr('Phone'),
                     'TR_FAX' => tr('Fax'),
                     'TR_UPDATE_DATA' => tr('Update data'),
					 'TR_ORDER_DETAILS' => tr('Order details'),
					 'TR_CUSTOMER_DATA' => tr('Customer data'),
					 'TR_DELETE_ORDER' => tr('Delete order'),
					 'TR_DMN_IP' => tr('Domain IP'),
					 'TR_CUSTOMER_ID' => tr('Customer ID'),
					 'TR_MESSAGE_DELETE_ACCOUNT' => tr('Are you sure you want to delete this order?'),
					 'TR_ADD' => tr('Add to the system')));
gen_page_message($tpl);
$tpl -> parse('PAGE', 'page');
$tpl -> prnt();

if (isset($cfg['DUMP_GUI_DEBUG'])) dump_gui_debug();

unset_messages();

?>
