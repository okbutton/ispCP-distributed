<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
  <title>{TR_RESELLER_MAIN_INDEX_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
  <link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css">
  <script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
  <script language="JavaScript" type="text/JavaScript">
<!--

function delete_order(url) {
	if (!confirm("{TR_MESSAGE_DELETE_ACCOUNT}"))
		return false;

	location = url;
}
//-->
  </script>
 </head>

 <body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/hosting_plans_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/manage_users_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif')">
  <!-- BDP: logged_from -->
  <table width="100%"  border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td height="20" nowrap background="{THEME_COLOR_PATH}/images/button.gif">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="18" height="18" border="0" align="absmiddle"></a> <font color="red">{YOU_ARE_LOGGED_AS}</font></td>
   </tr>
  </table>
  <!-- EDP: logged_from -->
  <table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" style="border-collapse: collapse;padding:0;margin:0;">
   <tr>
    <td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="../themes/omega_original/images/top/top_left.jpg" border="0"></td>
    <td style="height: 56px; width:100%; background-image: url(../themes/omega_original/images/top/top_bg.jpg)"><img src="../themes/omega_original/images/top/top_left_bg.jpg" border="0"></td>
    <td style="width: 73px; height: 56px;"><img src="../themes/omega_original/images/top/top_right.jpg" border="0"></td>
   </tr>
   <tr>
    <td style="width: 195px; vertical-align: top;">{MENU}</td>
    <td colspan=2 style="vertical-align: top;">
     <table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
      <tr height="95";>
       <td style="padding-left:30px; width: 100%; background-image: url({THEME_COLOR_PATH}/images/top/middle_bg.jpg);">{MAIN_MENU}</td>
       <td style="padding:0;margin:0;text-align: right; width: 73px;vertical-align: top;"><img src="{THEME_COLOR_PATH}/images/top/middle_right.jpg" border="0"></td>
      </tr>
      <tr height="*">
       <td colspan=3>
	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
          <td align="left">
		   <table width="100%" cellpadding="5" cellspacing="5">
            <tr>
             <td width="25"><img src="{THEME_COLOR_PATH}/images/content/table_icon_billing.png" width="25" height="25"></td>
             <td colspan="2" class="title">{TR_MANAGE_ORDERS}</td>
            </tr>
           </table>
          </td>
          <td width="27" align="right">&nbsp;</td>
         </tr>
         <tr>
          <td>
		   <!-- BDP: props_list -->
           <table width="100%" cellspacing="3">
            <!-- BDP: page_message -->
            <tr>
             <td width="35">&nbsp;</td>
             <td colspan="7" class="title"><font color="#FF0000">{MESSAGE}<br /></font></td>
            </tr>
            <!-- EDP: page_message -->
            <!-- BDP: orders_table -->
            <tr>
             <td width="35" align="center">&nbsp;</td>
             <td class="content3" width="20" align="center"><span class="menu"><b>{TR_ID}</b></span></td>
             <td class="content3"><b>{TR_DOMAIN}</b></td>
             <td class="content3"><strong>{TR_HP}</strong></td>
             <td class="content3"><strong>{TR_USER}</strong></td>
             <td align="center" class="content3"><strong>{TR_STATUS}</strong></td>
             <td width="200" colspan="2" align="center" class="content3"><b>{TR_ACTION}</b></td>
            </tr>
            <!-- BDP: order -->
            <tr>
             <td width="35" align="center">&nbsp;</td>
             <td class="{ITEM_CLASS}" width="20" align="center">{ID}</td>
             <td class="{ITEM_CLASS}">{DOMAIN}</td>
             <td class="{ITEM_CLASS}">{HP}</td>
             <td class="{ITEM_CLASS}">{USER}</td>
             <td align="center" class="{ITEM_CLASS}">{STATUS}</td>
             <td class="{ITEM_CLASS}" align="center"><img src="{THEME_COLOR_PATH}/images/icons/details.png" width="18" height="18" border="0" align="absmiddle"> <a href="{LINK}" class="link">{TR_ADD}</a></td>
             <td class="{ITEM_CLASS}" align="center"><img src="{THEME_COLOR_PATH}/images/icons/delete.png" width="16" height="16" border="0" align="absmiddle"> <a href="#" onClick="delete_order('orders_delete.php?order_id={ID}')" class="link">{TR_DELETE}</a></td>
            </tr>
            <!-- EDP: order -->
            <!-- EDP: orders_table -->
           </table>
           <!-- EDP: props_list -->
           <div align="right"><br />
            <!-- BDP: scroll_prev_gray -->
            <img src="{THEME_COLOR_PATH}/images/icons/flip/prev_gray.gif" width="20" height="20" border="0">
            <!-- EDP: scroll_prev_gray -->
            <!-- BDP: scroll_prev -->
            <a href="orders.php?psi={PREV_PSI}"><img src="{THEME_COLOR_PATH}/images/icons/flip/prev.gif" width="20" height="20" border="0"></a>
            <!-- EDP: scroll_prev -->
            <!-- BDP: scroll_next_gray -->
            &nbsp;<img src="{THEME_COLOR_PATH}/images/icons/flip/next_gray.gif" width="20" height="20" border="0">
            <!-- EDP: scroll_next_gray -->
            <!-- BDP: scroll_next -->
            &nbsp;<a href="orders.php?psi={NEXT_PSI}"><img src="{THEME_COLOR_PATH}/images/icons/flip/next.gif" width="20" height="20" border="0"></a>
            <!-- EDP: scroll_next -->
           </div>
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
