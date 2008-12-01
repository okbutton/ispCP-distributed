<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_CLIENT_MANAGE_USERS_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
<script type="text/javascript">
<!--
function action_delete(url, mailacc) {
	if(url.indexOf("delete")==-1){
		location = url;
	} else {
		if (!confirm(sprintf("{TR_MESSAGE_DELETE}", mailacc)))
			return false;
		location = url;
	}
}
//-->
</script>
</head>

<body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/ftp_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/email_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<!-- BDP: logged_from --><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap="nowrap" class="backButton">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="16" height="16" border="0" align="absmiddle"></a> {YOU_ARE_LOGGED_AS}</td>
      </tr>
    </table>
	<!-- EDP: logged_from -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" style="border-collapse: collapse;padding:0;margin:0;">
<tr>
<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" border="0"></td>
<td style="height: 56px; width:100%; background-image: url({THEME_COLOR_PATH}/images/top/top_bg.jpg)"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" border="0"></td>
<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" border="0"></td>
</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
	    <td colspan="2" style="vertical-align: top;"><table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
          <tr height="95">
            <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
            <td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" border="0"></td>
          </tr>
          <tr>
            <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td align="left"><table width="100%" cellpadding="5" cellspacing="5">
                    <tr>
                      <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_email.png" width="25" height="25"></td>
                      <td colspan="2" class="title">{TR_CATCHALL_MAIL_USERS}</td>
                    </tr>
                </table></td>
                <td width="27" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="40">&nbsp;</td>
                      <td valign="top"><table width="100%" cellspacing="7">
                          <!-- BDP: page_message -->
                          <tr>
                            <td colspan="4" nowrap="nowrap" class="title"><span class="message">{MESSAGE}</span></td>
                          </tr>
                          <!-- EDP: page_message -->
                          <tr>
                            <td nowrap="nowrap" class="content3"><b>{TR_DOMAIN}</b></td>
                            <td nowrap="nowrap" class="content3"><b>{TR_CATCHALL}</b></td>
                            <td nowrap="nowrap" class="content3" align="center" width="100"><b>{TR_STATUS}</b></td>
                            <td nowrap="nowrap" class="content3" align="center" width="200"><b>{TR_ACTION}</b></td>
                          </tr>
                          <!-- BDP: catchall_message -->
                          <tr>
                            <td colspan="4" class="title"><span class="message">{CATCHALL_MSG}</span></td>
                          </tr>
                          <!-- EDP: catchall_message -->
                          <!-- BDP: catchall_item -->
                          <tr>
                            <td nowrap="nowrap" class="{ITEM_CLASS}">{CATCHALL_DOMAIN}</td>
                            <td nowrap="nowrap" class="{ITEM_CLASS}">{CATCHALL_ACC}</td>
                            <td nowrap="nowrap" class="{ITEM_CLASS}" align="center" width="100">{CATCHALL_STATUS}</td>
                            <td nowrap="nowrap" class="{ITEM_CLASS}" align="center" width="200">
                                <!-- BDP: del_icon -->
                                <img src="{THEME_COLOR_PATH}/images/icons/users.gif" width="16" height="16" border="0" align="absmiddle">
                                <!-- EDP: del_icon -->
                              <a href="#" class="link" onclick="action_delete('{CATCHALL_ACTION_SCRIPT}', '{CATCHALL_ACC}')">{CATCHALL_ACTION}</a>
                            </td>
                          </tr>
                          <!-- EDP: catchall_item -->
                      </table></td>
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
        </table></td>
	</tr>
</table>
</body>
</html>
