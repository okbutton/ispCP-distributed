<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_ALIAS_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/vhcs.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/vhcs.js"></script>
<script>
<!--

function change_status(dom_id) {
	if (!confirm("{TR_MESSAGE_CHANGE_STATUS}"))
		return false;

	location = ('change_status.php?domain_id=' + dom_id);
}

function delete_account(url) {
	if (!confirm("{TR_MESSAGE_DELETE}"))
		return false;

	location = url;
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>

</head>
<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif','{THEME_COLOR_PATH}/images/icons/logout_a.gif','{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
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
                      <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_domains.png" width="25" height="25"></td>
                      <td colspan="2" class="title">{TR_MANAGE_ALIAS}</td>
                    </tr>
                </table></td>
                <td width="27" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top"><table width="100%" cellpadding="5" cellspacing="5">
                    <tr>
                      <td height="25" colspan="6" nowrap><!-- serach gose here-->
                          <form name="search_alias_frm" method="post" action="domain_alias.php?psi={PSI}">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td width="40" nowrap>&nbsp;</td>
                                <td width="300" nowrap  class="content"><input name="search_for" type="text" class="textinput" value="{SEARCH_FOR}" style="width:140px">
                                    <select name="search_common" class="textinput">
                                      <option value="alias_name" {M_DOMAIN_NAME_SELECTED}>{M_ALIAS_NAME}</option>
                                      <option value="account_name" {M_ACCOUN_NAME_SELECTED}>{M_ACCOUNT_NAME}</option>
                                    </select>
                                </td>
                                <td nowrap class="content"><input name="Submit" type="submit" class="button" value="  {TR_SEARCH}  ">
                                </td>
                              </tr>
                            </table>
                            <input type="hidden" name="uaction" value="go_search">
                          </form>
                        <!-- serach end here -->
                      </td>
                    </tr>
                    <tr>
                      <td width="25" align="center" nowrap>&nbsp;</td>
                      <td height="25" nowrap class="content3"><b>{TR_NAME}</b></td>
                      <td height="25" nowrap class="content3"><strong>{TR_REAL_DOMAIN}</strong></td>
                      <td width="80" height="25" align="center" nowrap class="content3"><b>{TR_FORWARD}</b></td>
                      <td width="80" height="25" align="center" nowrap class="content3"><b>{TR_STATUS}</b></td>
                      <td width="80" height="25" align="center" nowrap class="content3"><b>{TR_ACTION}</b></td>
                    </tr>
                    <!-- BDP: page_message -->
                    <tr>
                      <td width="25">&nbsp;</td>
                      <td colspan="5" class="title"><font color="#FF0000">{MESSAGE}</font></td>
                    </tr>
                    <!-- EDP: page_message -->
                    <!-- BDP: table_list -->
                    <!-- BDP: table_item -->
                    <tr>
                      <td width="25" align="center">&nbsp;</td>
                      <td class="{CONTENT}" nowrap><img src="{THEME_COLOR_PATH}/images/icons/domain_icon.gif" width="15" height="14" align="left"> {NAME}<br>
                        {ALIAS_IP}</td>
                      <td class="{CONTENT}" nowrap>{REAL_DOMAIN}<br>
                        {REAL_DOMAIN_MOUNT}</td>
                      <td align="center" nowrap class="{CONTENT}"><a href="{EDIT_LINK}" class="link">{FORWARD} </a></td>
                      <td class="{CONTENT}" nowrap align="center">{STATUS}</td>
                      <td class="{CONTENT}" nowrap align="center"><img src="{THEME_COLOR_PATH}/images/icons/delete.gif" width="16" height="16" border="0" align="absmiddle"> <a href="#" onClick="delete_account('{DELETE_LINK}')" class="link">{DELETE}</a></td>
                    </tr>
                    <!-- EDP: table_item -->
                    <!-- EDP: table_list -->
                  </table>
                    <table width="100%"  border="0" cellspacing="3" cellpadding="0">
                      <tr>
                        <td width="30">&nbsp;</td>
                        <td><input name="Submit" type="submit" class="button" onClick="MM_goToURL('parent','add_alias.php');return document.MM_returnValue" value="   {TR_ADD_ALIAS}   ">
                        </td>
                        <td><div align="right">
                            <!-- BDP: scroll_prev_gray -->
                            <img src="{THEME_COLOR_PATH}/images/icons/flip/prev_gray.gif" width="20" height="20" border="0">
                            <!-- EDP: scroll_prev_gray -->
                            <!-- BDP: scroll_prev -->
                            <a href="domain_alias.php?psi={PREV_PSI}"><img src="{THEME_COLOR_PATH}/images/icons/flip/prev.gif" width="20" height="20" border="0"></a>
                            <!-- EDP: scroll_prev -->
                            <!-- BDP: scroll_next_gray -->
                          &nbsp;<img src="{THEME_COLOR_PATH}/images/icons/flip/next_gray.gif" width="20" height="20" border="0">
                          <!-- EDP: scroll_next_gray -->
                          <!-- BDP: scroll_next -->
                          &nbsp;<a href="domain_alias.php?psi={NEXT_PSI}"><img src="{THEME_COLOR_PATH}/images/icons/flip/next.gif" width="20" height="20" border="0"></a>
                          <!-- EDP: scroll_next -->
                        </div></td>
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
