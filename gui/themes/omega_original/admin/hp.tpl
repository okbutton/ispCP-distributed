<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_RESELLER_MAIN_INDEX_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/vhcs.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/vhcs.js"></script>
<script>
<!--

function delete_account(url) {
	if (!confirm("{TR_MESSAGE_DELETE}"))
		return false;

	location = url;
}
//-->
</script>

</head>
<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif','{THEME_COLOR_PATH}/images/icons/logout_a.gif','{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" style="border-collapse: collapse;padding:0;margin:0;">
	<tr>
		<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" border="0"></td>
		<td style="height: 56px; width: 785px;"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" border="0"></td>
		<td style="width:100%; background-image: url({THEME_COLOR_PATH}/images/top/top_bg.jpg)">&nbsp;</td>
		<td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" border="0"></td>
	</tr>
	<tr>
		<td style="width: 195px; vertical-align: top;">{SUB_MENU}</td>
	    <td colspan=3 style="vertical-align: top;"><table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
				<tr height="95";>
				  <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
					<td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" border="0"></td>
				</tr>
				<tr height="*">
				  <td colspan=3><table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="left" class="title"><table width="100%" cellpadding="5" cellspacing="5">
                          <tr>
                            <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_serverstatus.png" width="25" height="25"></td>
                            <td colspan="2" class="title">{TR_HOSTING_PLANS}</td>
                          </tr>
                      </table></td>
                      <td width="27" align="right">&nbsp;</td>
                    </tr>
                    <tr>
                      <td valign="top"><table width="100%" cellspacing="3">
                          <!-- BDP: page_message -->
                          <tr>
                            <td width="25">&nbsp;</td>
                            <td colspan="5" class="title"><font color="#FF0000">{MESSAGE}</font></b></td>
                          </tr>
                          <!-- EDP: page_message -->
                          <!-- BDP: hp_table -->
                          <tr>
                            <td width="25" align="center">&nbsp;</td>
                            <td class="content3" width="50" align="center"><span class="menu"><b>{TR_NOM}</b></span></td>
                            <td class="content3"><b>{TR_PLAN_NAME}</b></td>
                            <td width="100" align="center" class="content3"><strong>{TR_PURCHASING}</strong></td>
                            <td width="200" colspan="2" align="center" class="content3"><b>{TR_ACTION}</b></td>
                          </tr>
                          <!-- BDP: hp_entry -->
                          <tr>
                            <td width="25" align="center">&nbsp;</td>
                            <td class="{CLASS_TYPE_ROW}" width="50" align="center">{PLAN_NOM}</td>
                            <td class="{CLASS_TYPE_ROW}">{PLAN_NAME}</td>
                            <td align="center" class="{CLASS_TYPE_ROW}">{PURCHASING}</td>
                            <td class="{CLASS_TYPE_ROW}" align="center"><img src="{THEME_COLOR_PATH}/images/icons/edit.gif" width="16" height="16" border="0" align="absmiddle"> <a href="ehp.php?hpid={HP_ID}" class="link">{TR_EDIT}</a></td>
                            <td class="{CLASS_TYPE_ROW}" align="center"><img src="{THEME_COLOR_PATH}/images/icons/delete.gif" width="16" height="16" border="0" align="absmiddle"> <a href="#" onClick="delete_account('dhp.php?hpid={HP_ID}')" class="link">{PLAN_ACTION}</a></td>
                          </tr>
                          <!-- EDP: hp_entry -->
                          <!-- EDP: hp_table -->
                      </table></td>
                      <td>&nbsp;</td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  </table></td>
				</tr>
			</table>
			
	    <p>&nbsp;</p></td>
	</tr>
</table>
</body>
</html>