<?php
/**
 *  ispCP (OMEGA) - Virtual Hosting Control System | Omega Version
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
 
include '../include/ispcp-lib.php';

check_login();

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['ADMIN_TEMPLATE_PATH'].'/server_status.tpl');

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('service_status', 'page');

global $cfg;
$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> assign(
                array(
                        'TR_ADMIN_SERVER_STATUS_PAGE_TITLE' => tr('ISPCP Admin / System Tools / Server Status'),
                        'THEME_COLOR_PATH' => "../themes/$theme_color",
                        'THEME_CHARSET' => tr('encoding'),
						'ISP_LOGO' => get_logo($_SESSION['user_id']),
                        'ISPCP_LICENSE' => $cfg['ISPCP_LICENSE']
                     )
              );


/*
Site functions
*/

class status {

		var $all = array();
		var $log = FALSE;


		// AddService adds a service to a multi-dimensional array
		function AddService($ip, $port, $service, $type) {
			$small_array = array('ip' => $ip, 'port' => $port, 'service' => $service, 'type' => $type, 'status' => '');
			array_push($this->all, $small_array);
			return $this->all;
		}

		// GetCount returns the number of services added
		function GetCount()	{
			return count($this->all);
		}

		// CheckStatus checks the status
		function CheckStatus($timeout = 5) {
			$x = $this->GetCount();
			for($i = 0; $i <= $x - 1; $i++)	{
				$ip = $this->all[$i]['ip'];
				$port = $this->all[$i]['port'];
				$service = $this->all[$i]['service'];
				if($this->all[$i]['type'] == 'tcp')	{
					$fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
				}
				else {
					$fp = @fsockopen('udp://'.$ip, $port, $errno, $errstr, $timeout);
				}

				if($fp) {
					$this->all[$i]['status'] = TRUE;
					if($this->log) {
						$this->AddLog($this->all[$i]['ip'], $this->all[$i]['port'], $this->all[$i]['service'], $this->all[$i]['type'], 'TRUE');
						// $this->StatusUp(mysql_insert_id());
					}
				}
				else {
					$this->all[$i]['status'] = FALSE;
					if($this->log){
						$this->AddLog($this->all[$i]['ip'], $this->all[$i]['port'], $this->all[$i]['service'], $this->all[$i]['type'], 'FALSE');
						// $this->StatusDown(mysql_insert_id());
					}
				}
				if($fp) fclose($fp);
			}
		}

		# GetStatus a unecessary function to return the status
		function GetStatus() {
			return $this->all;
		}

		# GetSingleStatus will get the status of single address
		function GetSingleStatus($ip, $port, $type, $timeout = 5) {
			if($type == 'tcp'){
				$fp = @fsockopen($ip, $port, $errno, $errstr, $timeout);
			}
			else {
				$fp = @fsockopen('udp://'.$ip, $port, $errno, $errstr, $timeout);
			}
			if($fp)	{
				fclose($fp);
				return TRUE;
			}
			else {
				return FALSE;
			}
		}
}


function get_server_status(&$tpl, &$sql) {

	$query = <<<SQL_QUERY
		SELECT
			*
		FROM
			config
		WHERE
			name
		  LIKE
		  	'PORT_%'
		ORDER BY
			name ASC
SQL_QUERY;

	$rs = exec_query($sql, $query, array());

	$ispcp_status = new status;
	// Enable logging?
	$ispcp_status->log = FALSE; // Default is false
	$ispcp_status->AddService('localhost', 9876, 'ISPCP Daemon', 'tcp');
	// Dynamic added Ports
	while(!$rs->EOF) {

		list($port, $protocol, $name, $status, $custom) = explode(";", $rs->fields['value']);
		if ($status) {
			$ispcp_status->AddService('localhost', (int)$port, $name, $protocol);
		}

		$rs->MoveNext();
	} //while

	/*
	$ispcp_status->AddService('localhost', 21, 'FTP', 'tcp');
	$ispcp_status->AddService('localhost', 22, 'SSH', 'tcp');
	$ispcp_status->AddService('localhost', 23, 'Telnet', 'tcp');
	$ispcp_status->AddService('localhost', 25, 'SMTP', 'tcp');
	$ispcp_status->AddService('localhost', 53, 'DNS', 'tcp');
	$ispcp_status->AddService('localhost', 80, 'HTTP', 'tcp');
	$ispcp_status->AddService('localhost', 443, 'HTTP-SSL', 'tcp');
	$ispcp_status->AddService('localhost', 110, 'POP3', 'tcp');
	$ispcp_status->AddService('localhost', 995, 'POP3-SSL', 'tcp');
	$ispcp_status->AddService('localhost', 143, 'IMAP', 'tcp');
	$ispcp_status->AddService('localhost', 993, 'IMAP-SSL', 'tcp');
	*/
	$ispcp_status->CheckStatus(5);
	$data = $ispcp_status->GetStatus();


	for($i = 0; $i <= count($data) - 1; $i++) {
		if($data[$i]['status'])	{
			$img = $on = 'UP';
			$class = "content";
		}
		else {
			$img = $off ='<b><font color="#FF0000">DOWN</font></b>';
			$class = "content2";
		}

		$tpl -> assign(
						array(
							   'HOST' => $data[$i]['ip'],
							   'PORT' => $data[$i]['port'],
							   'SERVICE' => $data[$i]['service'],
							   'STATUS' => $img,
							   'CLASS' => $class,
							 )
					  );

					  $tpl -> parse('SERVICE_STATUS', '.service_status');
	}
}



/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/main_menu_general_information.tpl');
gen_admin_menu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/menu_general_information.tpl');

$tpl -> assign(
                array(
					   'TR_HOST' => tr('Host'),
					   'TR_SERVICE' => tr('Service'),
					   'TR_STATUS' => tr('Status'),
					   'TR_SERVER_STATUS' => tr('Server status'),
                     )
              );


get_server_status($tpl, $sql);

gen_page_message($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if (isset($cfg['DUMP_GUI_DEBUG']))
	dump_gui_debug();

unset_messages();
?>
