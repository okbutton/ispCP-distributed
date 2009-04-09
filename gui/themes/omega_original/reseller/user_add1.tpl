<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_CLIENT_CHANGE_PERSONAL_DATA_PAGE_TITLE}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
</head>

<body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<!-- BDP: logged_from --><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap="nowrap" class="backButton">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="16" height="16" border="0" style="vertical-align:middle" /></a> {YOU_ARE_LOGGED_AS}</td>
      </tr>
    </table>
	<!-- EDP: logged_from -->
<!-- ToolTip -->
<div id="dmn_help" style="background-color:#ffffe0;border: 1px #000000 solid;display:none;margin:5px;padding:5px;font-size:9pt;font-family:Verdana, sans-serif;color:#000000;width:200px;position:absolute;">{TR_DMN_HELP}</div>
<!-- ToolTip end -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" style="border-collapse: collapse;padding:0;margin:0;">
<tr>
<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" border="0" alt="ispCP Logogram" /></td>
<td style="height: 56px; width:100%; background-image: url({THEME_COLOR_PATH}/images/top/top_bg.jpg)"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" border="0" alt="" /></td>
<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" border="0" alt="" /></td>
</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
	    <td colspan="2" style="vertical-align: top;"><table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
          <tr height="95">
            <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
            <td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" border="0" alt="" /></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left"><table width="100%" cellpadding="5" cellspacing="5">
                    <tr>
                      <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_user.png" width="25" height="25" /></td>
                      <td colspan="2" class="title">{TR_ADD_USER}</td>
                    </tr>
                </table></td>
                <td width="27" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td><form name="reseller_add_users_first_frm" method="post" action="user_add1.php">
                    <table width="100%" cellpadding="5" cellspacing="5">
                      <!-- BDP: page_message -->
                      <tr>
                        <td width="25">&nbsp;</td>
                        <td colspan="2" class="title"><span class="message">{MESSAGE}</span></td>
                      </tr>
                      <!-- EDP: page_message -->
                      <!-- BDP: add_form -->
                      <tr>
                        <td width="25">&nbsp;</td>
                        <td colspan="2" class="content3">{TR_CORE_DATA}</td>
                      </tr>
                      <tr>
                        <td width="25">&nbsp;</td>
                        <td class="content2" width="200">
						 {TR_DOMAIN_NAME} <img src="{THEME_COLOR_PATH}/images/icons/help.png" width="16" height="16" onmouseover="showTip('dmn_help', event)" onmouseout="hideTip('dmn_help')" />
						</td>
                        <td class="content">
                          <input type="text" name="dmn_name" value="{DMN_NAME_VALUE}" style="width:210px" class="textinput" />
                        </td>
                      </tr>
                      <!-- BDP: add_user -->
                      <tr>
                        <td width="25">&nbsp;</td>
                        <td class="content2" width="200">{TR_CHOOSE_HOSTING_PLAN}</td>
                        <td class="content"><select name="dmn_tpl">
                            <!-- BDP: hp_entry -->
                            <option value="{CHN}" {CH{CHN}}>{HP_NAME}</option>
                            <!-- EDP: hp_entry -->
                          </select>
                        </td>
                      </tr>
                      <!-- BDP: personalize -->
                      <tr>
                        <td width="25">&nbsp;</td>
                        <td class="content2" width="200">{TR_PERSONALIZE_TEMPLATE}</td>
                        <td class="content">{TR_YES}
                          <input type="radio" name="chtpl" value="_yes_" {CHTPL1_VAL}>
                          {TR_NO}
                          <input type="radio" name="chtpl" value="_no_" {CHTPL2_VAL}>
                        </td>
                      </tr>
                      <!-- EDP: personalize -->
                      <!-- EDP: add_user -->
                      <tr>
                        <td>&nbsp;</td>
                        <td colspan="2"><input name="Submit" type="submit" class="button" value="{TR_NEXT_STEP}"></td>
                      </tr>
                      <!-- EDP: add_form -->
                    </table>
                  <input type="hidden" name="uaction" value="user_add_nxt">
                </form></td>
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
