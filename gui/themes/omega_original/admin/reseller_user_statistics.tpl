<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_ADMIN_USER_STATISTICS_PAGE_TITLE}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
</head>

<body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;padding:0;margin:0 auto;">
<tr>
<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" width="195" height="56" border="0" alt="ispCP Logogram" /></td>
<td style="height: 56px; width:100%; background-color: #0f0f0f"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" width="582" height="56" border="0" alt="" /></td>
<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" width="73" height="56" border="0" alt="" /></td>
</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
	    <td colspan="2" style="vertical-align: top;"><table style="width: 100%; padding:0;margin:0;" cellspacing="0">
				<tr style="height:95px;">
				  <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
					<td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" width="73" height="95" border="0" alt="" /></td>
				</tr>
				<tr>
				  <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left"><table width="100%" cellpadding="5" cellspacing="5">
                          <tr>
                            <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_stats.png" width="25" height="25" alt="" /></td>
                            <td colspan="2" class="title">{TR_RESELLER_USER_STATISTICS}</td>
                          </tr>
                      </table></td>
                      <td width="27" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td valign="top"><!-- BDP: page_message -->
                          <table width="100%" cellspacing="7">
                            <tr>
                              <td width="25" nowrap="nowrap">&nbsp;&nbsp;&nbsp;</td>
                              <td><!-- BDP: props_list -->
                                  <form action="user_statistics.php?psi={POST_PREV_PSI}" method="post" name="rs_frm" id="rs_frm">
                                    <table width="100%">
                                      <tr>
                                        <td width="80" class="content"><label for="month">{TR_MONTH}</label></td>
                                        <td width="80" class="content"><select name="month" id="month">
                                            <!-- BDP: month_list -->
                                            <option {OPTION_SELECTED}>{MONTH_VALUE}</option>
                                            <!-- EDP: month_list -->
                                          </select>
                                        </td>
                                        <td width="80" class="content"><label for="year">{TR_YEAR}</label></td>
                                        <td width="80" class="content"><select name="year" id="year">
                                            <!-- BDP: year_list -->
                                            <option {OPTION_SELECTED}>{YEAR_VALUE}</option>
                                            <!-- EDP: year_list -->
                                          </select>
                                        </td>
                                        <td class="content"><input name="Submit" type="submit" class="button" value=" {TR_SHOW} " />
                                        </td>
                                      </tr>
                                    </table>
                                    <input type="hidden" name="uaction" value="show" />
                                    <input type="hidden" name="name" value="{VALUE_NAME}" />
                                    <input type="hidden" name="rid" value="{VALUE_RID}" />
                                  </form>
                                <br />
                                  <table width="100%" cellspacing="3">
                                    <!-- BDP: no_domains -->
                                    <tr>
                                      <td class="title" colspan="13" width="550"><span style="color:red;"> {TR_NO_DOMAINS}</span></td>
                                    </tr>
                                    <!-- EDP: no_domains -->
                                    <!-- BDP: domain_list -->
                                    <tr>
                                      <td height="25" colspan="13" nowrap="nowrap" class="content">{RESELLER_NAME}</td>
                                    </tr>
                                    <tr align="center">
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_DOMAIN_NAME}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_TRAFF}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_DISK}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_WEB}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_FTP_TRAFF}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_SMTP}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_POP3}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_SUBDOMAIN}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_ALIAS}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_MAIL}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_FTP}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_SQL_DB}</b></td>
                                      <td class="content3" nowrap="nowrap" height="25"><b>{TR_SQL_USER}</b></td>
                                    </tr>
                                    <!-- BDP: domain_entry -->
                                    <tr>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center"><b><a href="domain_statistics.php?month={MONTH}&amp;year={YEAR}&amp;domain_id={DOMAIN_ID}" class="link">{DOMAIN_NAME}</a></b></td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_left_small.gif" width="13" height="20" alt="" /></td>
                                            <td class="stats"><table border="0" cellspacing="0" cellpadding="0" align="left">
                                                <tr>
                                                  <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_left.gif" width="7" height="13" alt="" /></td>
                                                  <td class="statsBar"><img src="{THEME_COLOR_PATH}/images/trans.gif" width="{TRAFF_PERCENT}" height="1" alt="" /></td>
                                                  <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_right.gif" width="7" height="13" alt="" /></td>
                                                </tr>
                                            </table></td>
                                            <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_right_small.gif" width="13" height="20" alt="" /></td>
                                          </tr>
                                        </table>
                                          <b>{TRAFF_SHOW_PERCENT}&nbsp;%</b><br />
                                        {TRAFF_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                          <tr>
                                            <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_left_small.gif" width="13" height="20" alt="" /></td>
                                            <td class="stats"><table border="0" cellspacing="0" cellpadding="0" align="left">
                                                <tr>
                                                  <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_left.gif" width="7" height="13" alt="" /></td>
                                                  <td class="statsBar"><img src="{THEME_COLOR_PATH}/images/trans.gif" width="{DISK_PERCENT}" height="1" alt="" /></td>
                                                  <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_right.gif" width="7" height="13" alt="" /></td>
                                                </tr>
                                            </table></td>
                                            <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_right_small.gif" width="13" height="20" alt="" /></td>
                                          </tr>
                                        </table>
                                          <b>{DISK_SHOW_PERCENT}&nbsp;%</b><br />
                                        {DISK_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{WEB}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{FTP}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{SMTP}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{POP3}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{SUB_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{ALS_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{MAIL_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{FTP_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{SQL_DB_MSG}</td>
                                      <td class="{ITEM_CLASS}" nowrap="nowrap" align="center">{SQL_USER_MSG}</td>
                                    </tr>
                                    <!-- EDP: domain_entry -->
                                    <!-- EDP: domain_list -->
                                  </table>
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td><div align="left"><br />
                                              <!-- BDP: scroll_prev_gray -->
                                              <img src="{THEME_COLOR_PATH}/images/icons/flip/prev_gray.gif" width="20" height="20" border="0" alt="" />
                                              <!-- EDP: scroll_prev_gray -->
                                              <!-- BDP: scroll_prev -->
                                              <a href="user_statistics.php?psi={PREV_PSI}&amp;rid={VALUE_RID}&amp;name={VALUE_NAME}&amp;month={MONTH}&amp;year={YEAR}"><img src="{THEME_COLOR_PATH}/images/icons/flip/prev.gif" width="20" height="20" border="0" alt="" /></a>
                                              <!-- EDP: scroll_prev -->
                                              <!-- BDP: scroll_next_gray -->
                                        &nbsp;<img src="{THEME_COLOR_PATH}/images/icons/flip/next_gray.gif" width="20" height="20" border="0" alt="" />
                                        <!-- EDP: scroll_next_gray -->
                                        <!-- BDP: scroll_next -->
                                        &nbsp;<a href="user_statistics.php?psi={NEXT_PSI}&amp;rid={VALUE_RID}&amp;name={VALUE_NAME}&amp;month={MONTH}&amp;year={YEAR}"><img src="{THEME_COLOR_PATH}/images/icons/flip/next.gif" width="20" height="20" border="0" alt="" /></a>
                                        <!-- EDP: scroll_next -->
                                      </div></td>
                                      <td><div align="right"><br />
                                              <!-- BDP: scroll_prev_gray -->
                                              <img src="{THEME_COLOR_PATH}/images/icons/flip/prev_gray.gif" width="20" height="20" border="0" alt="" />
                                              <!-- EDP: scroll_prev_gray -->
                                              <!-- BDP: scroll_prev -->
                                              <a href="user_statistics.php?psi={PREV_PSI}&amp;rid={VALUE_RID}&amp;name={VALUE_NAME}&amp;month={MONTH}&amp;year={YEAR}"><img src="{THEME_COLOR_PATH}/images/icons/flip/prev.gif" width="20" height="20" border="0" alt="" /></a>
                                              <!-- EDP: scroll_prev -->
                                              <!-- BDP: scroll_next_gray -->
                                        &nbsp;<img src="{THEME_COLOR_PATH}/images/icons/flip/next_gray.gif" width="20" height="20" border="0" alt="" />
                                        <!-- EDP: scroll_next_gray -->
                                        <!-- BDP: scroll_next -->
                                        &nbsp;<a href="user_statistics.php?psi={NEXT_PSI}&amp;rid={VALUE_RID}&amp;name={VALUE_NAME}&amp;month={MONTH}&amp;year={YEAR}"><img src="{THEME_COLOR_PATH}/images/icons/flip/next.gif" width="20" height="20" border="0" alt="" /></a>
                                        <!-- EDP: scroll_next -->
                                      </div></td>
                                    </tr>
                                </table></td>
                            </tr>
                          </table>
                        <br />
                          <!-- EDP: traffic_table -->
                      </td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
				</tr>
			</table></td>
	</tr>
</table>
</body>
</html>
