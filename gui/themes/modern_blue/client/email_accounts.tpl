<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_CLIENT_MANAGE_USERS_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/vhcs.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/vhcs.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function action_delete(url) {
	if (!confirm("{TR_MESSAGE_DELETE}"))
		return false;

	location = url;
}
//-->
</script>
<style type="text/css">
<!--
.style1 {font-size: 9px}
-->
</style>
</head>

<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/ftp_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif','{THEME_COLOR_PATH}/images/icons/logout_a.gif','{THEME_COLOR_PATH}/images/icons/email_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td height="80" align="left" valign="top">
	<!-- BDP: logged_from --><table width="100%"  border="00" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap background="{THEME_COLOR_PATH}/images/button.gif">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.gif" width="18" height="18" border="0" align="absmiddle"></a> <font color="red">{YOU_ARE_LOGGED_AS}</font> </td>
      </tr>
    </table>
	<!-- EDP: logged_from --><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="17"><img src="{THEME_COLOR_PATH}/images/top/left.jpg" width="17" height="80"></td>
          <td width="198" align="center" background="{THEME_COLOR_PATH}/images/top/logo_background.jpg"><img src="{ISP_LOGO}"></td>
          <td background="{THEME_COLOR_PATH}/images/top/left_fill.jpg"><img src="{THEME_COLOR_PATH}/images/top/left_fill.jpg" width="2" height="80"></td>
          <td width="766"><img src="{THEME_COLOR_PATH}/images/top/middle_background.jpg" width="766" height="80"></td>
          <td background="{THEME_COLOR_PATH}/images/top/right_fill.jpg"><img src="{THEME_COLOR_PATH}/images/top/right_fill.jpg" width="3" height="80"></td>
          <td width="9"><img src="{THEME_COLOR_PATH}/images/top/right.jpg" width="9" height="80"></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table height="100%" width="100%"  border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="215" valign="top" bgcolor="#F5F5F5"><!-- Menu begin -->
  {MENU}
    <!-- Menu end -->
        </td>
        <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td height="62" align="left" background="{THEME_COLOR_PATH}/images/content/table_background.jpg" class="title"><img src="{THEME_COLOR_PATH}/images/content/table_icon_email.jpg" width="85" height="62" align="absmiddle">{TR_MAIL_USERS}</td>
            <td width="27" align="right" background="{THEME_COLOR_PATH}/images/content/table_background.jpg"><img src="{THEME_COLOR_PATH}/images/content/table_icon_close.jpg" width="27" height="62"></td>
          </tr>
          <tr>
            <td><table width="100%"  border="00" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="20">&nbsp;</td>
                  <td valign="top"><table width="100%" cellspacing="7">
                    <!-- BDP: page_message -->
					<tr>
                      <td colspan="4" nowrap class="title"><font color="#FF0000">{MESSAGE}</font></td>
                      </tr>
                    <tr>
					<!-- EDP: page_message -->
                      <td nowrap class="content3"><b>{TR_MAIL}</b></td>
                      <td nowrap class="content3" width="150"><b>{TR_TYPE}</b></td>
                      <td nowrap class="content3" align="center" width="180"><b>{TR_STATUS}</b></td>
                      <td nowrap class="content3" align="center" width="100"><b>{TR_ACTION}</b></td>
                    </tr>
                    <!-- BDP: mail_message -->
                    <tr>
                      <td colspan="4" class="title"><font color="#FF0000">{MAIL_MSG}</font></td>
                    </tr>
                    <!-- EDP: mail_message -->
                    <!-- BDP: mail_item -->
                    <tr>
                      <td nowrap class="{ITEM_CLASS}"><img src="{THEME_COLOR_PATH}/images/icons/mail_icon.gif" width="16" height="14" align="absmiddle"> <a href="{MAIL_EDIT_SCRIPT}" class="link">{MAIL_ACC}</a>
                          <!-- BDP: auto_respond -->
						  <br><span class="style1">
						  {TR_AUTORESPOND}: [&nbsp;&nbsp;
                          <a href="{AUTO_RESPOND_DISABLE_SCRIPT}" class="link">{AUTO_RESPOND_DISABLE}</a>&nbsp;&nbsp;
						  <a href="{AUTO_RESPOND_EDIT_SCRIPT}" class="link">{AUTO_RESPOND_EDIT}</a>
						  ]
						  <!-- EDP: auto_respond -->
						  </span>
                      </td>
                      <td nowrap class="{ITEM_CLASS}" width="150">{MAIL_TYPE}</td>
                      <td nowrap class="{ITEM_CLASS}" align="center" width="180">{MAIL_STATUS}</td>
                      <td nowrap class="{ITEM_CLASS}" align="center" width="100"><img src="{THEME_COLOR_PATH}/images/icons/delete.gif" width="16" height="16" border="0" align="absmiddle"> <a href="#" class="link" onClick="action_delete('{MAIL_ACTION_SCRIPT}')">{MAIL_ACTION}</a></td>
					</td>
                    </tr>
                    <!-- EDP: mail_item -->
                    <!-- BDP: mails_total -->
                    <tr>
                      <td colspan="4" align="right" nowrap class="content3">{TR_TOTAL_MAIL_ACCOUNTS}:&nbsp;<b>{TOTAL_MAIL_ACCOUNTS}</b></td>
                    </tr>
                    <!-- EDP: mails_total -->
                  </table>
                    </td>
                </tr>
            </table></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="71"><table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr><td width="17"><img src="{THEME_COLOR_PATH}/images/top/down_left.jpg" width="17" height="71"></td><td width="198" valign="top" background="{THEME_COLOR_PATH}/images/top/downlogo_background.jpg"><table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td width="55"><a href="http://www.vhcs.net" target="_blank"><img src="{THEME_COLOR_PATH}/images/vhcs.gif" alt="" width="51" height="71" border="0"></a></td>
            <td class="bottom">{VHCS_LICENSE}</td>
          </tr>
        </table>          </td>
          <td background="{THEME_COLOR_PATH}/images/top/down_left_fill.jpg"><img src="{THEME_COLOR_PATH}/images/top/down_left_fill.jpg" width="2" height="71"></td><td width="766" background="{THEME_COLOR_PATH}/images/top/middle_background.jpg"><img src="{THEME_COLOR_PATH}/images/top/down_middle_background.jpg" width="766" height="71"></td>
          <td background="{THEME_COLOR_PATH}/images/top/down_right_fill.jpg"><img src="{THEME_COLOR_PATH}/images/top/down_right_fill.jpg" width="3" height="71"></td>
          <td width="9"><img src="{THEME_COLOR_PATH}/images/top/down_right.jpg" width="9" height="71"></td></tr>
    </table></td>
  </tr>
</table>
</body>
</html>
