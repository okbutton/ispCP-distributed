<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_DETAILS_DOMAIN_PAGE_TITLE}</title>
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
	if (!confirm("{TR_MESSAGE_DELETE_ACCOUNT}"))
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
            <td height="62" align="left" background="{THEME_COLOR_PATH}/images/content/table_background.jpg" class="title"><img src="{THEME_COLOR_PATH}/images/content/table_icon_domains.jpg" width="85" height="62" align="absmiddle">{TR_DOMAIN_DETAILS}</td>
            <td width="27" align="right" background="{THEME_COLOR_PATH}/images/content/table_background.jpg"><img src="{THEME_COLOR_PATH}/images/content/table_icon_close.jpg" width="27" height="62"></td>
          </tr>
          <tr>
            <td>
			<table width="100%" cellpadding="5" cellspacing="5">
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="193">{TR_DOMAIN_NAME}</td>
                <td  class="content" colspan="2">{VL_DOMAIN_NAME}</td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_DOMAIN_IP}</i></td>
                <td  class="content" colspan="2">{VL_DOMAIN_IP}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_STATUS}</i></td>
                <td  class="content" colspan="2">{VL_STATUS}</td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_PHP_SUPP}</i></b> </td>
                <td  class="content" colspan="2">{VL_PHP_SUPP}</td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_CGI_SUPP}</td>
                <td  class="content" colspan="2">{VL_CGI_SUPP}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_MYSQL_SUPP}</td>
                <td  class="content" colspan="2">{VL_MYSQL_SUPP}</td>
              </tr>            
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_TRAFFIC}</td>
                <td  colspan="2" class="content">
				  <table width="252" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_left_small.gif" width="13" height="20"></td>
                      <td background="{THEME_COLOR_PATH}/images/stats_background.gif"> 
                        <table border="0" cellspacing="0" cellpadding="0" align="left">

                          <tr> 
                            <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_left.gif" width="7" height="13"></td>
                            <td background="{THEME_COLOR_PATH}/images/bars/stats_background.gif"><img src="{THEME_COLOR_PATH}/images/trans.gif" width="{VL_TRAFFIC_PERCENT}" height="1"></td>
                            <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_right.gif" width="7" height="13"></td>
                          </tr>
                        </table>
                      </td>
                      <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_right_small.gif" width="13" height="20"></td>
                    </tr>
                  </table>
				  <br>{VL_TRAFFIC_USED} / {VL_TRAFFIC_LIMIT}
				</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_DISK}</td>
                <td  colspan="2" class="content">
				  <table width="252" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_left_small.gif" width="13" height="20"></td>
                      <td background="{THEME_COLOR_PATH}/images/stats_background.gif"> 
                        <table border="0" cellspacing="0" cellpadding="0" align="left">

                          <tr> 
                            <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_left.gif" width="7" height="13"></td>
                            <td background="{THEME_COLOR_PATH}/images/bars/stats_background.gif"><img src="{THEME_COLOR_PATH}/images/trans.gif" width="{VL_DISK_PERCENT}" height="1"></td>
                            <td width="7"><img src="{THEME_COLOR_PATH}/images/bars/stats_right.gif" width="7" height="13"></td>
                          </tr>
                        </table>
                      </td>
                      <td width="13"><img src="{THEME_COLOR_PATH}/images/stats_right_small.gif" width="13" height="20"></td>
                    </tr>
                  </table>
				  <br>{VL_DISK_USED} / {VL_DISK_LIMIT}
				</td>
			  <tr>
   			    <td>&nbsp;</td>
   			    <td class="content3"><strong>{TR_FEATURE}</strong></td>
				<td width="200" class="content3"><strong>{TR_USED}</strong></td>
				<td class="content3"><strong>{TR_LIMIT}</strong></td>
			  </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_MAIL_ACCOUNTS}</td>
                <td  class="content">{VL_MAIL_ACCOUNTS_USED}</td>
				<td  class="content">{VL_MAIL_ACCOUNTS_LIIT}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_FTP_ACCOUNTS}</td>
                <td  class="content">{VL_FTP_ACCOUNTS_USED}</td>
				<td  class="content">{VL_FTP_ACCOUNTS_LIIT}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_SQL_DB_ACCOUNTS}</td>
                <td  class="content">{VL_SQL_DB_ACCOUNTS_USED}</td>
				<td  class="content">{VL_SQL_DB_ACCOUNTS_LIIT}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_SQL_USER_ACCOUNTS}</td>
                <td  class="content">{VL_SQL_USER_ACCOUNTS_USED}</td>
				<td  class="content">{VL_SQL_USER_ACCOUNTS_LIIT}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_SUBDOM_ACCOUNTS}</td>
                <td  class="content">{VL_SUBDOM_ACCOUNTS_USED}</td>
				<td  class="content">{VL_SUBDOM_ACCOUNTS_LIIT}</td>
              </tr>
			  <tr>
			    <td width="20">&nbsp;</td> 
                <td class="content2" width="193">{TR_DOMALIAS_ACCOUNTS}</td>
                <td  class="content">{VL_DOMALIAS_ACCOUNTS_USED}</td>
				<td  class="content">{VL_DOMALIAS_ACCOUNTS_LIIT}</td>
              </tr>
			  <tr>
			    <td>&nbsp;</td>
			    <td colspan="3">
				<form name="buttons" method="post" action="#">
				  <input name="Submit" type="submit" class="button" onClick="MM_goToURL('parent','users.php');return document.MM_returnValue" value="  {TR_BACK}  ">
				  &nbsp;&nbsp;&nbsp;
				  <!-- BDP: edit_option -->
	              <input name="Submit" type="submit" class="button" onClick="MM_goToURL('parent','edit_domain.php?edit_id={DOMAIN_ID}');return document.MM_returnValue" value="   {TR_EDIT}   ">
				  <!-- EDP: edit_option -->
                </form>
				</td>
			    </tr>
            </table>
			
			
			</td>
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
