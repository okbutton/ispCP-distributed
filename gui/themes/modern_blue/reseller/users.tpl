<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_CLIENT_CHANGE_PERSONAL_DATA_PAGE_TITLE}</title>
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
function sbmt(form, uaction) {

    form.details.value = uaction;
    form.submit();

    return false;

}
//-->
</script>

</head>
<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif','{THEME_COLOR_PATH}/images/icons/logout_a.gif','{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td height="80" align="left" valign="top">
	<!-- BDP: logged_from --><table width="100%"  border="00" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap background="{THEME_COLOR_PATH}/images/button.gif">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.gif" width="18" height="18" border="0" align="absmiddle"></a> <font color="red">{YOU_ARE_LOGGED_AS}</font> </td>
      </tr>
    </table>
	<!-- EDP: logged_from -->
    <table width="100%"  border="0" cellspacing="0" cellpadding="0">
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
            <td height="62" align="left" background="{THEME_COLOR_PATH}/images/content/table_background.jpg" class="title"><img src="{THEME_COLOR_PATH}/images/content/table_icon_users.jpg" width="85" height="62" align="absmiddle">{TR_MANAGE_USERS}</td>
            <td width="27" align="right" background="{THEME_COLOR_PATH}/images/content/table_background.jpg"><img src="{THEME_COLOR_PATH}/images/content/table_icon_close.jpg" width="27" height="62"></td>
          </tr>
          <tr>
            <td>
			<form name="search_user" method="post" action="users.php">
            <table width="100%" cellspacing="3">


              <tr>
                <td colspan="9" nowrap>&nbsp;</td>
              </tr>
			  <!-- BDP: page_message -->
              <tr>
                <td>&nbsp;</td>
                <td colspan="8" class="title"><font color="#FF0000">{MESSAGE}</font></td>
                </tr>
              <tr>
			  <!-- EDP: page_message -->
                <td>&nbsp;</td>
                <td colspan="5"><table border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td nowrap><input name="search_for" type="text" class="textinput" value="{SEARCH_FOR}" style="width:140px">
                        <select name="search_common" class="textinput">
                          <option value="domain_name" {M_DOMAIN_NAME_SELECTED}>{M_DOMAIN_NAME}</option>
                          <option value="customer_id" {M_CUSTOMER_ID_SELECTED}>{M_CUSTOMER_ID}</option>
                          <option value="lname" {M_LAST_NAME_SELECTED}>{M_LAST_NAME}</option>
                          <option value="firm" {M_COMPANY_SELECTED}>{M_COMPANY}</option>
                          <option value="city" {M_CITY_SELECTED}>{M_CITY}</option>
                          <option value="country" {M_COUNTRY_SELECTED}>{M_COUNTRY}</option>
                        </select>
                        <select name="search_status" class="textinput">
                          <option value="all" {M_ALL_SELECTED}>{M_ALL}</option>
                          <option value="ok" {M_OK_SELECTED}>{M_OK}</option>
                          <option value="disabled" {M_SUSPENDED_SELECTED}>{M_SUSPENDED}</option>
                      </select></td>
                    <td nowrap><input name="Submit" type="submit" class="button" value=" {TR_SEARCH} ">
                    </td>
                  </tr>
                </table></td>
                <td colspan="3" align="right">
				<input type="hidden" name="details" value="">
				<img src="{THEME_COLOR_PATH}/images/icons/show_alias.jpg" width="15" height="16" align="absmiddle"> <a href="#" class="link" onClick="return sbmt(document.forms[0],'{SHOW_DETAILS}');">{TR_VIEW_DETAILS}</a></td>
                </tr>
              <tr>
                <td width="20">&nbsp;</td>
                <td class="content3" width="20" align="center"><b>{TR_NO}</b></td>
                <td class="content3"><b>{TR_USERNAME}</b></td>
                <td class="content3" width="90" align="center"><b>{TR_CREATION_DATE}</b></td>
                <td colspan="5" align="center" class="content3"><b>{TR_ACTION}</b></td>
				</tr>
			  <!-- BDP: users_list -->
			  <!-- BDP: user_entry -->
              <tr>
                <td align="center">&nbsp;</td>
                <td class="{CLASS_TYPE_ROW}" align="center"><a href="#" onClick="change_status('{URL_CHANGE_STATUS}')"><img src="{THEME_COLOR_PATH}/images/icons/{STATUS_ICON}" width="18" height="18" border="0"></a></td>
                <td class="{CLASS_TYPE_ROW}"><a href="edit_user.php?edit_id={USER_ID}" class="link">{NAME}</a></td>
                <td class="{CLASS_TYPE_ROW}" width="90" align="center">{CREATION_DATE}</td>
                <td nowrap width="80" align="center" class="{CLASS_TYPE_ROW}"><img src="{THEME_COLOR_PATH}/images/icons/bullet.gif" width="18" height="18" border="0" align="absmiddle"> <a href="domain_details.php?domain_id={DOMAIN_ID}" class="link">{TR_DETAILS}</a></td>
				<!-- BDP: edit_option -->
				<td nowrap width="120" align="center" class="{CLASS_TYPE_ROW}" ><img src="{THEME_COLOR_PATH}/images/icons/edit.gif" width="18" height="18" border="0" align="absmiddle"> <a href="edit_domain.php?edit_id={DOMAIN_ID}" class="link">{TR_EDIT}</a></td>
				<!-- EDP: edit_option -->
				<td nowrap width="80" align="center" class="{CLASS_TYPE_ROW}" ><img src="{THEME_COLOR_PATH}/images/icons/stats.gif" width="18" height="18" border="0" align="absmiddle"> <a href="domain_statistics.php?month={VL_MONTH}&year={VL_YEAR}&domain_id={DOMAIN_ID}" class="link">{TR_STAT}</a></td>
				<td nowrap width="80" align="center" class="{CLASS_TYPE_ROW}" ><img src="{THEME_COLOR_PATH}/images/icons/details.gif" width="18" height="18" border="0" align="absmiddle"> <a href="change_user_interface.php?to_id={USER_ID}" class="link">{CHANGE_INTERFACE}</a></td>
				<td nowrap width="80" align="center" class="{CLASS_TYPE_ROW}" ><img src="{THEME_COLOR_PATH}/images/icons/delete.gif" width="16" height="16" border="0" align="absmiddle"> <a href="#" onClick="delete_account('druser.php?id={USER_ID}')" class="link">{ACTION}</a></td>
              </tr>
			  <!-- BDP: user_details -->
              <tr>
                <td align="center">&nbsp;</td>
                <td class="content4" align="center">&nbsp;</td>
                <td colspan="7" class="content4">&nbsp;&nbsp;<img src="{THEME_COLOR_PATH}/images/icons/show_alias.jpg" width="15" height="16" align="absmiddle">&nbsp;{ALIAS_DOMAIN}</td>
                </tr>
			  <!-- EDP: user_details -->

			  <!-- EDP: user_entry -->

			  <!-- EDP: users_list -->


            </table>
			<input type="hidden" name="uaction" value="go_search">
		  </form>
			<div align="right"><br>
                <!-- BDP: scroll_prev_gray --><img src="{THEME_COLOR_PATH}/images/icons/flip/prev_gray.gif" width="20" height="20" border="0"><!-- EDP: scroll_prev_gray --><!-- BDP: scroll_prev --><a href="users.php?psi={PREV_PSI}"><img src="{THEME_COLOR_PATH}/images/icons/flip/prev.gif" width="20" height="20" border="0"></a><!-- EDP: scroll_prev --><!-- BDP: scroll_next_gray -->&nbsp;<img src="{THEME_COLOR_PATH}/images/icons/flip/next_gray.gif" width="20" height="20" border="0"><!-- EDP: scroll_next_gray --><!-- BDP: scroll_next -->&nbsp;<a href="users.php?psi={NEXT_PSI}"><img src="{THEME_COLOR_PATH}/images/icons/flip/next.gif" width="20" height="20" border="0"></a><!-- EDP: scroll_next -->
            </div></td>
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
