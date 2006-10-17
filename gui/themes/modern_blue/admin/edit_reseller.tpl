<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_ADMIN_EDIT_RESELLER_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/vhcs.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/vhcs.js"></script>
</head>

<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif','{THEME_COLOR_PATH}/images/icons/logout_a.gif','{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%">
  <tr>
    <td height="80" align="left" valign="top">
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
            <td height="62" align="left" background="{THEME_COLOR_PATH}/images/content/table_background.jpg" class="title"><img src="{THEME_COLOR_PATH}/images/content/table_icon_doc.jpg" width="85" height="62" align="absmiddle">{TR_EDIT_RESELLER}</td>
            <td width="27" align="right" background="{THEME_COLOR_PATH}/images/content/table_background.jpg"><img src="{THEME_COLOR_PATH}/images/content/table_icon_close.jpg" width="27" height="62"></td>
          </tr>
          <tr>
            <td valign="top">
			<form name="admin_edit_reseller" method="post" action="edit_reseller.php">
            <table width="100%" cellpadding="5" cellspacing="5">
              <tr>
                <td width="20">&nbsp;</td> 
                <td colspan="2" class="content3"><b>{TR_CORE_DATA}</b></td>
                </tr>
              <!-- BDP: page_message -->
              <tr>
                <td width="20">&nbsp;</td> 
                <td colspan="2" class="title"><font color="#FF0000">{MESSAGE}</font></td>
                </tr>
              <!-- EDP: page_message -->
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_USERNAME}</td>
                <td class="content"> {USERNAME}</td>
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_PASSWORD}</td>
                <td class="content"> <input type="password" name="pass" value="{VAL_PASSWORD}" style="width:210px" class="textinput">&nbsp;&nbsp;&nbsp;<input name="genpass" type="submit" class="button" value=" {TR_PASSWORD_GENERATE} ">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_PASSWORD_REPEAT}</td>
                <td class="content"> <input type="password" name="pass_rep" value="{VAL_PASSWORD}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_EMAIL}</td>
                <td class="content"> <input type="text" name="email" value="{EMAIL}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_DOMAIN_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_domain_cnt value="{MAX_DOMAIN_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_SUBDOMAIN_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_subdomain_cnt value="{MAX_SUBDOMAIN_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_ALIASES_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_alias_cnt value="{MAX_ALIASES_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_MAIL_USERS_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_mail_cnt value="{MAX_MAIL_USERS_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_FTP_USERS_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_ftp_cnt value="{MAX_FTP_USERS_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_SQLDB_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_sql_db_cnt value="{MAX_SQLDB_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_SQL_USERS_COUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_sql_user_cnt value="{MAX_SQL_USERS_COUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_TRAFFIC_AMOUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_traffic value="{MAX_TRAFFIC_AMOUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td class="content2" width="200">{TR_MAX_DISK_AMOUNT}<br>
                  <b><i>(0 {TR_UNLIMITED})</i></b></td>
                <td class="content"> 
                  <input type="text" name=nreseller_max_disk value="{MAX_DISK_AMOUNT}" style="width:140px" class="textinput">
                </td>
              </tr>
              <!--
              <tr> 
                <td class="content2" width="175">{TR_PHP}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="php" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="php" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_PERL_CGI}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="cgi" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="cgi" value="no">
                  {TR_NO}</td>
              </tr>
              <tr>
                <td class="content2" width="175" height="23">{TR_JSP}</td>
                <td width="254" class="content3" height="23">
                  <input type="radio" name="jsp" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="jsp" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175" height="23">{TR_SSI}</td>
                <td width="254" class="content3" height="23"> 
                  <input type="radio" name="ssi" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="ssi" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_FRONTPAGE_EXT}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="fp" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="fp" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_BACKUP_RESTORE}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="backup_restore" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="backup_restore" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_CUSTOM_ERROR_PAGES}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="error_pages" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="error_pages" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_PROTECTED_AREAS}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="protected_areas" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="protected_areas" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_WEBMAIL}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="webmail" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="webmail" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_DIR_LIST}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="directorylisting" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="directorylisting" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_APACHE_LOGFILES}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="apachelogfiles" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="apachelogfiles" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_AWSTATS}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="awstats" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="awstats" value="no">
                  {TR_NO}</td>
              </tr>
              <tr> 
                <td class="content2" width="175">{TR_LOGO_UPLOAD}</td>
                <td width="254" class="content3"> 
                  <input type="radio" name="logo_upload" value="yes" checked>
                  {TR_YES} 
                  <input type="radio" name="logo_upload" value="no">
                  {TR_NO}</td>
              </tr>
				-->
              <tr>
                <td width="20">&nbsp;</td> 
                <td colspan="2"><table cellpadding="3" cellspacing="1" border="0" width="100%">
                  <tr>
                    <td class="content3" colspan="4">{TR_RESELLER_IPS}</td>
                  </tr>
                  <!-- BDP: rsl_ip_message -->
                  <tr>
                    <td colspan="4" class="title" nowrap><b>{MESSAGES_LABEL}</b></td>
                  </tr>
                  <!-- EDP: rsl_ip_message -->
                  <!-- BDP: rsl_ip_list -->
                  <tr>
                    <td width="10%" align="center" class="content3">{TR_RSL_IP_NUMBER}</td>
                    <td width="20%" align="center" class="content3">{TR_RSL_IP_ASSIGN}</td>
                    <td width="35%" class="content3">{TR_RSL_IP_LABEL}</td>
                    <td width="35%" class="content3">{TR_RSL_IP_IP}</td>
                  </tr>
                  <!-- BDP: rsl_ip_item -->
                  <tr>
                    <td width="10%" align="center" class="{RSL_IP_CLASS}">{RSL_IP_NUMBER}</td>
                    <td width="20%" align="center" class="{RSL_IP_CLASS}"><input type="checkbox" name="{RSL_IP_CKB_NAME}" value="{RSL_IP_CKB_VALUE}" {RSL_IP_ITEM_ASSIGNED}>
                    </td>
                    <td width="35%" class="{RSL_IP_CLASS}">{RSL_IP_LABEL}</td>
                    <td width="35%" class="{RSL_IP_CLASS}">{RSL_IP_IP}</td>
                  </tr>
                  <!-- EDP: rsl_ip_item -->
                  <!-- EDP: rsl_ip_list -->
                </table> 
                  </td>
                </tr>
              <tr>
                <td width="20">&nbsp;</td> 
                <td colspan="2" class="content3"><b>{TR_ADDITIONAL_DATA}</b></td>
                </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_CUSTOMER_ID}</td>
                <td class="content"> <input type="text" name="customer_id" value="{CUSTOMER_ID}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_FIRST_NAME}</td>
                <td class="content"> <input type="text" name="fname" value="{FIRST_NAME}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_LAST_NAME}</td>
                <td class="content"> <input type="text" name="lname" value="{LAST_NAME}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_COMPANY}</td>
                <td class="content"> <input type="text" name="firm" value="{FIRM}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_ZIP_POSTAL_CODE}</td>
                <td class="content"> <input type="text" name="zip" value="{ZIP}" style="width:80px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_CITY}</td>
                <td class="content"> <input type="text" name="city" value="{CITY}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_COUNTRY}</td>
                <td class="content"> <input type="text" name="country" value="{COUNTRY}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_STREET_1}</td>
                <td class="content"> <input type="text" name="street1" value="{STREET_1}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_STREET_2}</td>
                <td class="content"> <input type="text" name="street2" value="{STREET_2}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_PHONE}</td>
                <td class="content"> <input type="text" name="phone" value="{PHONE}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr>
                <td width="20">&nbsp;</td> <td width="200" class="content2">{TR_FAX}</td>
                <td class="content"> <input type="text" name="fax" value="{FAX}" style="width:210px" class="textinput">
                </td>
              </tr>
              <tr> 
                <td>&nbsp;</td>
                <td colspan="2"><input name="Submit" type="submit" class="button" value="  {TR_UPDATE}  ">&nbsp;&nbsp;&nbsp;<input type="checkbox" name="send_data" checked>{TR_SEND_DATA}</td>
                </tr>
            </table>
            <input type="hidden" name="uaction" value="update_reseller">
            <input type="hidden" name="edit_id" value="{EDIT_ID}">
            <input type="hidden" name="edit_username" value="{USERNAME}">
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
