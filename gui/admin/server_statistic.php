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
$tpl -> define_dynamic('page', $cfg['ADMIN_TEMPLATE_PATH'].'/server_statistic.tpl');
$tpl -> define_dynamic('page_message', 'page');
$tpl -> define_dynamic('hosting_plans', 'page');
$tpl -> define_dynamic('month_list', 'page');
$tpl -> define_dynamic('year_list', 'page');
$tpl -> define_dynamic('day_list', 'page');

global $cfg;
$theme_color = $cfg['USER_INITIAL_THEME'];

$tpl -> assign(array('TR_ADMIN_SERVER_STATICSTICS_PAGE_TITLE' => tr('VHCS - Admin/Server statistics'),
                     'THEME_COLOR_PATH' => "../themes/$theme_color",
                     'THEME_CHARSET' => tr('encoding'),
                     'ISP_LOGO' => get_logo($_SESSION['user_id']),
                     'VHCS_LICENSE' => $cfg['VHCS_LICENSE']));

global $month, $year;

if (isset($_GET['month']) && isset($_GET['year'])) {
  $year  = intval($_GET['year']);
  $month = intval($_GET['month']);
} else if (isset($_POST['month']) && isset($_POST['year'])) {
  $year  = intval($_POST['year']);
  $month = intval($_POST['month']);
} else {
  $month = date("m");
  $year  = date("Y");
}

function get_server_trafic($from, $to)
{
  global $sql;

  $query = <<<SQL_QUERY
        select
            IFNULL(sum(bytes_in), 0) as sbin,
            IFNULL(sum(bytes_out), 0) as sbout,
            IFNULL(sum(bytes_mail_in), 0) as smbin,
            IFNULL(sum(bytes_mail_out), 0) as smbout,
            IFNULL(sum(bytes_pop_in), 0) as spbin,
            IFNULL(sum(bytes_pop_out), 0) as spbout,
            IFNULL(sum(bytes_web_in), 0) as swbin,
            IFNULL(sum(bytes_web_out), 0) as swbout
        from
            server_traffic
        where
            traff_time > ? and traff_time < ?
SQL_QUERY;

  $rs = exec_query($sql, $query, array($from, $to));

  if($rs -> RecordCount() == 0) {
    return array(0,0,0,0,0, 0,0,0,0,0);
  } else {
    return array($rs->fields['swbin'], $rs->fields['swbout'],
                 $rs->fields['smbin'], $rs->fields['smbout'],
                 $rs->fields['spbin'], $rs->fields['spbout'],
                 $rs->fields['sbin'] - ($rs->fields['swbin'] + $rs->fields['smbin'] + $rs->fields['spbin']),
                 $rs->fields['sbout'] - ($rs->fields['swbout'] + $rs->fields['smbout'] + $rs->fields['spbout']),
                 $rs->fields['sbin'], $rs->fields['sbout']);
  }
}

function generate_page (&$tpl)
{
  global $sql, $month,$year;

  if ($month == date('m') && $year == date('Y')) {
    $curday = date('j');
  } else {
    $tmp = mktime(1,0,0,$month+1,0,$year);
    $curday = date('j',$tmp);
  }

  $curtimestamp = time();
  $firsttimestamp = mktime(0,0,0,$month,1,$year);

  $all[0] = 0;
  $all[1] = 0;
  $all[2] = 0;
  $all[3] = 0;
  $all[4] = 0;
  $all[5] = 0;
  $all[6] = 0;
  $all[7] = 0;

  for($i = 1; $i <= $curday; $i++) {
    $ftm = mktime(0,0,0,$month,$i,$year);
    $ltm = mktime(23,59,59,$month,$i,$year);

    $query = <<<SQL_QUERY
          select
              count(bytes_in) as cnt
          from
              server_traffic
          where
              traff_time > ? and traff_time < ?
SQL_QUERY;

    $rs = exec_query($sql, $query, array($ftm, $ltm));
    $has_data = false;

    // if ($rs -> fields['cnt'] > 0) {
    if ($rs->RecordCount() > 0) {
      list($web_in,
           $web_out,
           $mail_in,
           $mail_out,
           $pop_in,
           $pop_out,
           $other_in,
           $other_out,
           $all_in,
           $all_out) = get_server_trafic($ftm, $ltm);

      $has_data = true;

      if ($i % 2 == 0) {
        $tpl -> assign('ITEM_CLASS', 'content');
      } else {
        $tpl -> assign('ITEM_CLASS', 'content2');
      }

      $tpl -> assign(array('DAY' => $i,
                           'YEAR' =>  $year,
                           'MONTH' => $month,
                           'WEB_IN' => make_hr($web_in),
                           'WEB_OUT' => make_hr($web_out),
                           'MAIL_IN' => make_hr($mail_in),
                           'MAIL_OUT' => make_hr($mail_out),
                           'POP_IN' => make_hr($pop_in),
                           'POP_OUT' => make_hr($pop_out),
                           'OTHER_IN' => make_hr($other_in),
                           'OTHER_OUT' => make_hr($other_out),
                           'ALL_IN' => make_hr($all_in),
                           'ALL_OUT' => make_hr($all_out),
                           'ALL' => make_hr($all_in + $all_out)));
      $all[0] = $all[0] + $web_in;
      $all[1] = $all[1] + $web_out;
      $all[2] = $all[2] + $mail_in;
      $all[3] = $all[3] + $mail_out;
      $all[4] = $all[4] + $pop_in;
      $all[5] = $all[5] + $pop_out;
      $all[6] = $all[6] + $all_in;
      $all[7] = $all[7] + $all_out;

      $tpl->parse('DAY_LIST','.day_list');

    }// if count

  }//for

  if (!$has_data) {
    $tpl->assign('DAY_LIST','');
  };

  $all_other_in  = $all[6] - ($all[0] + $all[2] + $all[4]);
  $all_other_out = $all[7] - ($all[1] + $all[3] + $all[5]);

  $tpl -> assign(array('WEB_IN_ALL' => make_hr($all[0]),
                       'WEB_OUT_ALL' => make_hr($all[1]),
                       'MAIL_IN_ALL' => make_hr($all[2]),
                       'MAIL_OUT_ALL' => make_hr($all[3]),
                       'POP_IN_ALL' => make_hr($all[4]),
                       'POP_OUT_ALL' => make_hr($all[5]),
                       'OTHER_IN_ALL' => make_hr($all_other_in),
                       'OTHER_OUT_ALL' => make_hr($all_other_out),
                       'ALL_IN_ALL' => make_hr($all[6]),
                       'ALL_OUT_ALL' => make_hr($all[7]),
                       'ALL_ALL' => make_hr($all[6] + $all[7])));
}


/*
 *
 * static page messages.
 *
 */
gen_admin_mainmenu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/main_menu_statistics.tpl');
gen_admin_menu($tpl, $cfg['ADMIN_TEMPLATE_PATH'].'/menu_statistics.tpl');

gen_select_lists($tpl, $month, $year);

generate_page ($tpl);

$tpl->assign(array('TR_SERVER_STATISTICS' => tr('Server statistics'),
                   'TR_MONTH' => tr('Month'),
                   'TR_YEAR' => tr('Year'),
                   'TR_SHOW' => tr('Show'),
                   'TR_DAY' => tr('Day'),
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
                   'TR_ALL' => tr('All')));

gen_page_message($tpl);
$tpl -> parse('PAGE', 'page');
$tpl -> prnt();

if (isset($cfg['DUMP_GUI_DEBUG'])) dump_gui_debug();

unset_messages();

?>