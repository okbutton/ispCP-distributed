<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_CLIENT_ERROR_PAGE_TITLE}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
</head>

<body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/ftp_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/email_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<!-- BDP: logged_from --><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap="nowrap" class="backButton">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="16" height="16" border="0" style="vertical-align:middle" alt="" /></a> {YOU_ARE_LOGGED_AS}</td>
      </tr>
    </table>
	<!-- EDP: logged_from -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;padding:0;margin:0;">
<tr>
<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" width="195" height="53" border="0" alt="ispCP Logogram" /></td>
<td style="height: 56px; width:100%; background-color: #0f0f0f"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" width="582" height="53" border="0" alt="" /></td>
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
                      <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_errors.png" width="25" height="25" alt="" /></td>
                      <td colspan="2" class="title">{TR_ERROR_PAGES}</td>
                    </tr>
                </table></td>
                <td width="27" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td><table width="100%" cellspacing="7">
                <!-- BDP: page_message -->
                  <tr>
                    <td colspan="3" nowrap="nowrap" class="title"><span class="message">{MESSAGE}</span></td>
                  </tr>
                  <!-- EDP: page_message -->
                    <tr>
                      <td width="25">&nbsp;</td>
                      <td class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="55"><a href="error_edit.php?eid=401"><img src="{THEME_COLOR_PATH}/images/icons/error401.png" width="38" height="44" border="0" /></a></td>
                            <td width="300">{TR_ERROR_401}</td>
                            <td width="100"><img src="{THEME_COLOR_PATH}/images/icons/edit.png" width="16" height="16" align="left" /> <a href="error_edit.php?eid=401" class="link">{TR_EDIT}</a></td>
                            <td><a href="{DOMAIN}/errors/401.html" target="_blank" class="link">{TR_VIEW}</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="55"><a href="error_edit.php?eid=403"><img src="{THEME_COLOR_PATH}/images/icons/error403.png" width="38" height="44" border="0" /></a></td>
                            <td width="300">{TR_ERROR_403}</td>
                            <td width="100"><img src="{THEME_COLOR_PATH}/images/icons/edit.png" width="16" height="16" align="left" /> <a href="error_edit.php?eid=403" class="link">{TR_EDIT}</a></td>
                            <td><a href="{DOMAIN}/errors/403.html" target="_blank" class="link">{TR_VIEW}</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="55"><a href="error_edit.php?eid=404"><img src="{THEME_COLOR_PATH}/images/icons/error404.png" width="38" height="44" border="0" /></a></td>
                            <td width="300">{TR_ERROR_404}</td>
                            <td width="100"><img src="{THEME_COLOR_PATH}/images/icons/edit.png" width="16" height="16" align="left" /> <a href="error_edit.php?eid=404" class="link">{TR_EDIT}</a></td>
                            <td><a href="{DOMAIN}/errors/404.html" target="_blank" class="link">{TR_VIEW}</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="55"><a href="error_edit.php?eid=500"><img src="{THEME_COLOR_PATH}/images/icons/error500.png" width="38" height="44" border="0" /></a></td>
                            <td width="300">{TR_ERROR_500}</td>
                            <td width="100"><img src="{THEME_COLOR_PATH}/images/icons/edit.png" width="16" height="16" align="left" /> <a href="error_edit.php?eid=500" class="link">{TR_EDIT}</a></td>
                            <td><a href="{DOMAIN}/errors/500.html" target="_blank" class="link">{TR_VIEW}</a></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="content"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td width="55"><a href="error_edit.php?eid=503"><img src="{THEME_COLOR_PATH}/images/icons/error503.png" width="38" height="44" border="0" /></a></td>
                            <td width="300">{TR_ERROR_503}</td>
                            <td width="100"><img src="{THEME_COLOR_PATH}/images/icons/edit.png" width="16" height="16" align="left" /> <a href="error_edit.php?eid=503" class="link">{TR_EDIT}</a></td>
                            <td><a href="{DOMAIN}/errors/503.html" target="_blank" class="link">{TR_VIEW}</a></td>
                          </tr>
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
