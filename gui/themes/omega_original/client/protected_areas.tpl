<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_HTACCESS}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/vhcs.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/vhcs.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/ftp_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif','{THEME_COLOR_PATH}/images/icons/logout_a.gif','{THEME_COLOR_PATH}/images/icons/email_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<!-- BDP: logged_from --><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap background="{THEME_COLOR_PATH}/images/button.gif">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.gif" width="18" height="18" border="0" align="absmiddle"></a> <font color="red">{YOU_ARE_LOGGED_AS}</font> </td>
      </tr>
    </table>
	<!-- EDP: logged_from -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" style="border-collapse: collapse;padding:0;margin:0;">
	<tr>
		<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" border="0"></td>
		<td style="height: 56px; width: 785px;"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" border="0"></td>
		<td style="width:100%; background-image: url({THEME_COLOR_PATH}/images/top/top_bg.jpg)">&nbsp;</td>
		<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" border="0"></td>
	</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
	    <td colspan=3 style="vertical-align: top;"><table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
          <tr height="95";>
            <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
            <td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" border="0"></td>
          </tr>
          <tr height="*">
            <td colspan=3><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left"><table width="100%" cellpadding="5" cellspacing="5">
                    <tr>
                      <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_htaccess.png" width="25" height="25"></td>
                      <td colspan="2" class="title">{TR_HTACCESS}</td>
                    </tr>
                </table></td>
                <td width="27" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" align="left" cellpadding="5" cellspacing="5">
                    <tr>
                      <!-- BDP: page_message -->
                    <tr>
                      <td width="25" nowrap >&nbsp;</td>
                      <td colspan="4" nowrap class="title"><font color="#FF0000">{MESSAGE}</font></td>
                    </tr>
                    <!-- EDP: page_message -->
                    <!-- BDP: protected_areas -->
                    <tr>
                      <td width="25" align="center" nowrap>&nbsp;</td>
                      <td class="content3" nowrap><b>{TR_HTACCESS}</b></td>
                      <td width="80" align="center" nowrap class="content3"><strong>{TR_STATUS}</strong></td>
                      <td width="" colspan="2" align="center" nowrap class="content3"><b>{TR__ACTION}</b></td>
                    </tr>
                    <!-- BDP: dir_item -->
                    <tr>
                      <td width="25" align="center" nowrap>&nbsp;</td>
                      <td class="{CLASS}" nowrap>{AREA_NAME}<br>
                          <u>{AREA_PATH}</u></td>
                      <td width="80" class="{CLASS}" nowrap align="center">{STATUS}</td>
                      <td width="60" class="{CLASS}" nowrap align="center"><img src="{THEME_COLOR_PATH}/images/icons/edit.gif" width="18" height="18" border="0" align="absmiddle"> <a href="protect_it.php?id={PID}" class="link">{TR_EDIT}</a> </td>
                      <td width="60" class="{CLASS}" nowrap align="center"><img src="{THEME_COLOR_PATH}/images/icons/delete.gif" width="16" height="16" border="0" align="absmiddle"> <a href="protect_delete.php?id={PID}" class="link">{TR_DELETE}</a></td>
                    </tr>
                    <!-- EDP: dir_item -->
                    <!-- EDP: protected_areas -->
                    <tr>
                      <td width="25" align="center" nowrap>&nbsp;</td>
                      <td colspan="4" nowrap><input name="Button" type="button" class="button" onClick="MM_goToURL('parent','protect_it.php');return document.MM_returnValue" value="{TR_ADD_AREA}">
                        &nbsp;&nbsp;&nbsp;
                        <input name="Button2" type="button" class="button" onClick="MM_goToURL('parent','puser_manage.php');return document.MM_returnValue" value="{TR_MANAGE_USRES}"></td>
                    </tr>
                </table></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table></td>
          </tr>
        </table>	    <p>&nbsp;</p></td>
	</tr>
</table>
</body>
</html>