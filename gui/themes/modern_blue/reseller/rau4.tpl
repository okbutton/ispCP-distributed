<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_ADD_USER_PAGE_TITLE}</title>
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

    function makeUser(){
	    var dname  = document.forms[0].elements['ndomain_name'].value;
		dname = dname.toLowerCase();
	    dname = dname.replace(/�/gi, "ae");
	    dname = dname.replace(/�/gi, "ue");
	    dname = dname.replace(/�/gi, "oe");
	    dname = dname.replace(/�/gi, "ss");
		document.forms[0].elements['ndomain_mpoint'].value = "/" + dname.replace('.','_');
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
            <td height="62" align="left" background="{THEME_COLOR_PATH}/images/content/table_background.jpg" class="title"><img src="{THEME_COLOR_PATH}/images/content/table_icon_user.jpg" width="85" height="62" align="absmiddle">{TR_ADD_USER}</td>
            <td width="27" align="right" background="{THEME_COLOR_PATH}/images/content/table_background.jpg"><img src="{THEME_COLOR_PATH}/images/content/table_icon_close.jpg" width="27" height="62"></td>
          </tr>
          <tr>
            <td valign="top">
			
			<form name="add_alias_frm" method="post" action="rau4.php">
              <table width="100%" cellpadding="5" cellspacing="5">
                <!-- BDP: page_message -->
                <tr>
                  <td width="20">&nbsp;</td>
                  <td colspan="2" class="title"><font color="#FF0000">{MESSAGE}</font></td>
                </tr>
                <!-- EDP: page_message -->

				<!-- BDP: alias_list -->
				<tr>
                  <td>&nbsp;</td>
                  <td class="content3"><strong>{TR_DOMAIN_ALIS}</strong></td>
                  <td class="content3"><strong>{TR_STATUS}</strong></td>
                </tr>
				<!-- BDP: alias_entry -->
                <tr>
                  <td width="20">&nbsp;</td>
                  <td class="{CLASS}">{DOMAIN_ALIS}</td>
                  <td width="100" class="{CLASS}">{STATUS}</td>
                </tr>
				<!-- EDP: alias_entry -->
				
				<!-- EDP: alias_list -->
                <tr>
                  <td width="20">&nbsp;</td>
                  <td colspan="2">&nbsp;</td>
                </tr>
              </table>
              <table width="100%" cellpadding="5" cellspacing="5">
              <tr>
                <td width="20">&nbsp;</td> 
                <td colspan="2" class="content3"><b>{TR_ADD_ALIAS}</b></td>
                </tr>
              <tr>
                <td width="20">&nbsp;</td> 
                <td width="200" class="content2">{TR_DOMAIN_NAME}</td>
                <td class="content"><input name="ndomain_name" type="text" class="textinput" style="width:170px" value="{DOMAIN}" onBlur="makeUser();"></td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td>
                <td class="content2">{TR_MOUNT_POINT}</td>
                <td class="content"><input name="ndomain_mpoint" type="text" class="textinput" id="ndomain_mpoint" value='{MP}' style="width:170px"></td>
              </tr>
              <tr>
                <td width="20" nowrap>&nbsp;</td> 
                <td width="200" nowrap class="content2">{TR_FORWARD}</td>
                <td class="content"> 
                  <input name="forward" type="text" class="textinput" id="forward" style="width:170px" value="{FORWARD}">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> 
                <td colspan="2"> 
                  <input name="Submit" type="submit" class="button" value="  {TR_ADD}  ">&nbsp;&nbsp;&nbsp; <input name="Button" type="button" class="button" onClick="MM_goToURL('parent','users.php');return document.MM_returnValue" value="  {TR_GO_USERS}  ">
               </td>
                </tr>
            </table>
	    <input type="hidden" name="uaction" value="add_alias">
            </form>
			
			
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
