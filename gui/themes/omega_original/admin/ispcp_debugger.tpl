<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{TR_ADMIN_ISPCP_DEBUGGER_PAGE_TITLE}</title>
<meta name="robots" content="nofollow, noindex" />
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
  <link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css" />
  <script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
 </head>

 <body onload="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%;padding:0;margin:0;">
   <tr>
    <td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" border="0" alt="ispCP Logogram" /></td>
    <td style="height: 56px; width:100%; background-image: url({THEME_COLOR_PATH}/images/top/top_bg.jpg)"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" border="0" alt="" /></td>
    <td style="width: 73px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_right.jpg" border="0" alt="" /></td>
   </tr>
   <tr>
    <td style="width: 195px; vertical-align: top;">{MENU}</td>
    <td colspan="2" style="vertical-align: top;">
     <table style="width: 100%; padding:0;margin:0;" cellspacing="0">
      <tr style="height:95px;">
       <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
       <td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" border="0" alt="" /></td>
      </tr>
      <tr>
       <td colspan="3">
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
          <td align="left">
           <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="20"><img src="{THEME_COLOR_PATH}/images/content/table_icon_debugger.png" width="25" height="25" /></td>
             <td colspan="2" class="title">{TR_DEBUGGER_TITLE}</td>
            </tr>
           </table>
          </td>
          <td width="27" align="right">&nbsp;</td>
         </tr>
         <tr>
          <td>
		   <!-- BDP: props_list -->
           <table width="100%" cellpadding="5" cellspacing="5">
            <!-- BDP: page_message -->
            <tr>
             <td width="25">&nbsp;</td>
             <td colspan="2" class="title"><span class="message">{MESSAGE}</span></td>
            </tr>
            <!-- EDP: page_message -->
            <tr>
             <td width="25">&nbsp;</td>
             <td class="content3"><b>{TR_DOMAIN_ERRORS}</b></td>
            </tr>
            <!-- BDP: domain_message -->
            <tr>
             <td>&nbsp;</td>
             <td>{TR_DOMAIN_MESSAGE}</td>
            </tr>
            <!-- EDP: domain_message -->
            <!-- BDP: domain_list -->
            <tr>
             <td>&nbsp;</td>
             <td class="{CONTENT}">
			  {TR_DOMAIN_NAME} - <a href="ispcp_debugger.php?action=change_status&amp;id={CHANGE_ID}&amp;type={CHANGE_TYPE}" class="link">{TR_CHANGE_STATUS}</a><br />
              <span style="color:red;">{TR_DOMAIN_ERROR}</span>
			 </td>
            </tr>
            <!-- EDP: domain_list -->
           </table>
           <br />
           <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="25">&nbsp;</td>
             <td class="content3"><b>{TR_ALIAS_ERRORS}</b></td>
            </tr>
            <!-- BDP: alias_message -->
            <tr>
             <td>&nbsp;</td>
             <td>{TR_ALIAS_MESSAGE}</td>
            </tr>
            <!-- EDP: alias_message -->
            <!-- BDP: alias_list -->
            <tr>
             <td>&nbsp;</td>
             <td class="{CONTENT}">
			  {TR_ALIAS_NAME} - <a href="ispcp_debugger.php?action=change_status&amp;id={CHANGE_ID}&amp;type={CHANGE_TYPE}" class="link">{TR_CHANGE_STATUS}</a><br />
              <span style="color:red;">{TR_ALIAS_ERROR}</span>
			 </td>
            </tr>
            <!-- EDP: alias_list -->
           </table>
           <br />
           <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="25">&nbsp;</td>
             <td class="content3"><b>{TR_SUBDOMAIN_ERRORS}</b></td>
            </tr>
            <!-- BDP: subdomain_message -->
            <tr>
             <td>&nbsp;</td>
             <td>{TR_SUBDOMAIN_MESSAGE}</td>
            </tr>
             <!-- EDP: subdomain_message -->
             <!-- BDP: subdomain_list -->
            <tr>
             <td>&nbsp;</td>
             <td class="{CONTENT}">
			  {TR_SUBDOMAIN_NAME} - <a href="ispcp_debugger.php?action=change_status&amp;id={CHANGE_ID}&amp;type={CHANGE_TYPE}" class="link">{TR_CHANGE_STATUS}</a><br />
              <span style="color:red;">{TR_SUBDOMAIN_ERROR}</span>
			 </td>
            </tr>
            <!-- EDP: subdomain_list -->
           </table>
           <br />
           <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="25">&nbsp;</td>
             <td class="content3"><b>{TR_SUBDOMAIN_ALIAS_ERRORS}</b></td>
            </tr>
            <!-- BDP: subdomain_alias_message -->
            <tr>
             <td>&nbsp;</td>
             <td>{TR_SUBDOMAIN_ALIAS_MESSAGE}</td>
            </tr>
             <!-- EDP: subdomain_alias_message -->
             <!-- BDP: subdomain_alias_list -->
            <tr>
             <td>&nbsp;</td>
             <td class="{CONTENT}">
			  {TR_SUBDOMAIN_ALIAS_NAME} - <a href="ispcp_debugger.php?action=change_status&amp;id={CHANGE_ID}&amp;type={CHANGE_TYPE}" class="link">{TR_CHANGE_STATUS}</a><br />
              <span style="color:red;">{TR_SUBDOMAIN_ALIAS_ERROR}</span>
			 </td>
            </tr>
            <!-- EDP: subdomain_alias_list -->
           </table>
           <br />
           <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="25">&nbsp;</td>
             <td class="content3"><b>{TR_MAIL_ERRORS}</b></td>
            </tr>
            <!-- BDP: mail_message -->
            <tr>
             <td>&nbsp;</td>
             <td>{TR_MAIL_MESSAGE}</td>
            </tr>
            <!-- EDP: mail_message -->
            <!-- BDP: mail_list -->
            <tr>
             <td>&nbsp;</td>
             <td class="{CONTENT}">
			  {TR_MAIL_NAME} - <a href="ispcp_debugger.php?action=change_status&amp;id={CHANGE_ID}&amp;type={CHANGE_TYPE}" class="link">{TR_CHANGE_STATUS}</a><br />
              <span style="color:red;">{TR_MAIL_ERROR}</span></td>
            </tr>
            <!-- EDP: mail_list -->
           </table>
           <br />
           <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="25">&nbsp;</td>
             <td class="content3"><b>{TR_DAEMON_TOOLS}</b></td>
            </tr>
            <tr>
             <td>&nbsp;</td>
             <td><a href="ispcp_debugger.php?action=run_engine" class="link">{EXEC_COUNT} {TR_EXEC_REQUESTS}</a></td>
            </tr>
           </table>
           <!-- EDP: props_list -->
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
     </table>
    </td>
   </tr>
  </table>
 </body>
</html>
