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

$tpl = new pTemplate();

$tpl -> define_dynamic('page', $cfg['ADMIN_TEMPLATE_PATH'].'/server_day_stats.tpl');

$tpl -> define_dynamic('page_message', 'page');

$tpl -> define_dynamic('hour_list', 'page');

global $cfg;
$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> assign(
    array(
        'TR_ADMIN_SERVER_DAY_STATS_PAGE_TITLE' => tr('VHCS - Admin/Server day stats'),
        'THEME_COLOR_PATH' => "../themes/$theme_color",
        'THEME_CHARSET' => tr('encoding'),
		'ISP_LOGO' => get_logo($_SESSION['user_id']),
        'VHCS_LICENSE' => $cfg['VHCS_LICENSE']
        )
    );

global $month, $year, $day;

if (isset($_GET['month']) && isset($_GET['year']) && isset($_GET['day']) &&
	is_numeric($_GET['month']) && is_numeric($_GET['year']) && is_numeric($_GET['day'])){

    $year= $_GET['year'];

    $month = $_GET['month'];

    $day = $_GET['day'];
} else {
	header("Location: server_statistic.php");
	die();
}

function generate_page (&$tpl) {

    global $sql, $month, $year, $day;

    $all[0] = 0;
    $all[1] = 0;
    $all[2] = 0;
    $all[3] = 0;
    $all[4] = 0;
    $all[5] = 0;
    $all[6] = 0;
    $all[7] = 0;

    $all_other_in = 0;
    $all_other_out = 0;

    $row = 1;

    $ftm = mktime(0,0,0,$month,$day,$year);
    $ltm = mktime(23,59,59,$month,$day,$year);

    $query = <<<SQL_QUERY
        select
            count(bytes_in) as cnt
        from
            server_traffic
        where
            traff_time > ? and traff_time < ?
SQL_QUERY;

    $rs =  exec_query($sql, $query, array($ftm, $ltm));

    $dnum = $rs -> fields['cnt'];

    $query = <<<SQL_QUERY
        select
            traff_time as ttime,
            bytes_in as sbin,
            bytes_out as sbout,
            bytes_mail_in as smbin,
            bytes_mail_out as smbout,
            bytes_pop_in as spbin,
            bytes_pop_out as spbout,
            bytes_web_in as swbin,
            bytes_web_out as swbout
        from
            server_traffic
        where
            traff_time > ? and traff_time < ?

SQL_QUERY;

    $rs1 =  exec_query($sql, $query, array($ftm, $ltm));

    $row = 1;

    if($dnum != 0 ){

        for($i=0;$i<$dnum;$i++){

            /* make it in kb mb or bytes :) */
            $ttime = date('H:i',$rs1->fields['ttime']);

            /* make other traffic */
            $other_in  = $rs1->fields['sbin'] - ($rs1->fields['swbin']+$rs1->fields['smbin']+$rs1->fields['spbin']);
            $other_out = $rs1->fields['sbout'] - ($rs1->fields['swbout']+$rs1->fields['smbout']+$rs1->fields['spbout']);

            if ($row++ % 2 == 0) {
                $tpl -> assign(
                        array(
                            'ITEM_CLASS' => 'content',
                            )
                        );
            }
            else{
                $tpl -> assign(
                        array(
                            'ITEM_CLASS' => 'content2',
                            )
                        );
            }

            $tpl -> assign(
                array(
                    'HOUR' => $ttime,
                    'WEB_IN' => make_hr($rs1->fields['swbin']),
                    'WEB_OUT' => make_hr($rs1->fields['swbout']),
                    'MAIL_IN' => make_hr($rs1->fields['smbin']),
                    'MAIL_OUT' => make_hr($rs1->fields['smbout']),
                    'POP_IN' => make_hr($rs1->fields['spbin']),
                    'POP_OUT' => make_hr($rs1->fields['spbout']),
                    'OTHER_IN' => make_hr($other_in),
                    'OTHER_OUT' => make_hr($other_out),
                    'ALL_IN' => make_hr($rs1->fields['sbin']),
                    'ALL_OUT' => make_hr($rs1->fields['sbout']),
                    'ALL' => make_hr($rs1->fields['sbin']+$rs1->fields['sbout']),
                )
            );

            $all[0] = $all[0] +$rs1->fields['swbin'];
            $all[1] = $all[1] +$rs1->fields['swbout'];
            $all[2] = $all[2] +$rs1->fields['smbin'];
            $all[3] = $all[3] +$rs1->fields['smbout'];
            $all[4] = $all[4] +$rs1->fields['spbin'];
            $all[5] = $all[5] +$rs1->fields['spbout'];
            $all[6] = $all[6] +$rs1->fields['sbin'];
            $all[7] = $all[7] +$rs1->fields['sbout'];

            $tpl->parse('HOUR_LIST','.hour_list');

            $rs1->MoveNext();

        }//for

        $all_other_in  = $all[6] - ($all[0]+$all[2]+$all[4]);
        $all_other_out = $all[7] - ($all[1]+$all[3]+$all[5]);

    }// if dnum
    else{
        $tpl->assign('HOUR_LIST','');
    }
    $tpl -> assign(
        array(

            'WEB_IN_ALL' => make_hr($all[0]),
            'WEB_OUT_ALL' => make_hr($all[1]),
            'MAIL_IN_ALL' => make_hr($all[2]),
            'MAIL_OUT_ALL' => make_hr($all[3]),
            'POP_IN_ALL' => make_hr($all[4]),
            'POP_OUT_ALL' => make_hr($all[5]),
            'OTHER_IN_ALL' => make_hr($all_other_in),
            'OTHER_OUT_ALL' => make_hr($all_other_out),
            'ALL_IN_ALL' => make_hr($all[6]),
            'ALL_OUT_ALL' => make_hr($all[7]),
            'ALL_ALL' => make_hr($all[6]+$all[7]),
        )
    );

}


/*
 *
 * static page messages.
 *
 */

gen_admin_menu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/menu_statistics.tpl');

$tpl -> assign(
    array(
        'TR_SERVER_DAY_STATISTICS' => tr('Server day statistics'),
        'TR_MONTH' => tr('Month:'),
        'TR_YEAR' => tr('Year:'),
        'TR_DAY' => tr('Day:'),
        'TR_HOUR' => tr('Hour'),
        'TR_WEB_IN' => tr('Web in'),
        'TR_WEB_OUT' => tr('Web out'),
        'TR_MAIL_IN' => tr('Mail in'),
        'TR_MAIL_OUT' => tr('Mail out'),
        'TR_POP_IN' => tr('Pop/IMAP in'),
        'TR_POP_OUT' => tr('Pop/IMAP out'),
        'TR_OTHER_IN' => tr('Other in'),
        'TR_OTHER_OUT' => tr('Other out'),
        'TR_ALL_IN' => tr('All in'),
        'TR_ALL_OUT' => tr('All out'),
        'TR_ALL' => tr('All'),
        'TR_BACK' => tr('Back'),

        'MONTH' => $month,
        'YEAR' => $year,
        'DAY' => $day,
        )
    );

gen_page_message($tpl);

generate_page ($tpl);

$tpl -> parse('PAGE', 'page');

$tpl -> prnt();

if (isset($cfg['DUMP_GUI_DEBUG'])) dump_gui_debug();

unset_messages();
?>