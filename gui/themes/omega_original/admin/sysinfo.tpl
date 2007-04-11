<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_ADMIN_SYSTEM_INFO_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
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
		<td style="width: 195px; vertical-align: top;">{MENU}</td>
	    <td colspan=3 style="vertical-align: top;"><table style="width: 100%; border-collapse: collapse;padding:0;margin:0;">
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
		<td width="20"><img src="{THEME_COLOR_PATH}/images/content/table_icon_tools.png" width="25" height="25"></td>
		<td colspan="2" class="title">{TR_SYSTEM_INFO}</td>
	</tr>
</table>	
	</td>
    <td width="27" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><!-- BDP: props_list -->
        <table width="100%" cellpadding="5" cellspacing="5">
          <tr>
            <td width="25">&nbsp;</td>
            <td width="200" class="content2">{TR_KERNEL}</td>
            <td class="content2">{KERNEL}</td>
          </tr>
          <tr>
            <td width="25">&nbsp;</td>
            <td width="200" class="content">{TR_UPTIME}</td>
            <td class="content">{UPTIME}</td>
          </tr>
          <tr>
            <td width="25">&nbsp;</td>
            <td width="200" class="content2">{TR_LOAD}</td>
            <td class="content2">{LOAD}</td>
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
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
<table width="100%" cellpadding="5" cellspacing="5">
	<tr>
		<td width="20"><img src="{THEME_COLOR_PATH}/images/content/table_icon_tools.png" width="25" height="25"></td>
		<td colspan="2" class="title">{TR_CPU_SYSTEM_INFO}</td>
	</tr>
</table>	
	</td>
    <td width="27" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="5" cellspacing="5">
      <tr>
        <td width="25">&nbsp;</td>
        <td width="200" class="content2">{TR_CPU_MODEL}</td>
        <td class="content2">{CPU_MODEL}</td>
      </tr>
      <tr>
        <td width="25">&nbsp;</td>
        <td width="200" class="content">{TR_CPU_MHZ}</td>
        <td class="content">{CPU_MHZ}</td>
      </tr>
      <tr>
        <td width="25">&nbsp;</td>
        <td width="200" class="content2">{TR_CPU_CACHE}</td>
        <td class="content2">{CPU_CACHE}</td>
      </tr>
      <tr>
        <td width="25">&nbsp;</td>
        <td width="200" class="content">{TR_CPU_BOGOMIPS}</td>
        <td class="content">{CPU_BOGOMIPS}</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
<table width="100%" cellpadding="5" cellspacing="5">
	<tr>
		<td width="20"><img src="{THEME_COLOR_PATH}/images/content/table_icon_tools.png" width="25" height="25"></td>
		<td colspan="2" class="title">{TR_MEMRY_SYSTEM_INFO}</td>
	</tr>
</table>	
	</td>
    <td width="27" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="5" cellspacing="5">
      <tr>
        <td width="25">&nbsp;</td>
        <td class="content3"><b>{TR_RAM}</b></td>
        <td class="content3"><b>{TR_TOTAL}</b></td>
        <td class="content3"><b>{TR_USED}</b></td>
        <td class="content3"><b>{TR_FREE}</b></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="content">&nbsp;</td>
        <td class="content">{RAM_TOTAL}</td>
        <td class="content">{RAM_USED}</td>
        <td class="content">{RAM_FREE}</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="content3"><b>{TR_SWAP}</b></td>
        <td class="content3"><b>{TR_TOTAL}</b></td>
        <td class="content3"><b>{TR_USED}</b></td>
        <td class="content3"><b>{TR_FREE}</b></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td class="content">&nbsp;</td>
        <td class="content">{SWAP_TOTAL}</td>
        <td class="content">{SWAP_USED}</td>
        <td class="content">{SWAP_FREE}</td>
      </tr>
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left">
<table width="100%" cellpadding="5" cellspacing="5">
	<tr>
		<td width="20"><img src="{THEME_COLOR_PATH}/images/content/table_icon_tools.png" width="25" height="25"></td>
		<td colspan="2" class="title">{TR_FILE_SYSTEM_INFO}</td>
	</tr>
</table>	
	</td>
    <td width="27" align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" cellpadding="5" cellspacing="5">
      <!-- BDP: disk_list -->
      <tr>
        <td width="25" nowrap="nowrap" >&nbsp;</td>
        <td class="content3" nowrap="nowrap"><b>{TR_MOUNT}</b></td>
        <td class="content3" nowrap="nowrap"><b>{TR_TYPE}</b></td>
        <td class="content3" nowrap="nowrap"><b>{TR_PARTITION}</b></td>
        <td align="center" nowrap="nowrap" class="content3"><b>{TR_PERCENT}</b></td>
        <td align="right" nowrap="nowrap" class="content3"><b>{TR_FREE}</b></td>
        <td align="right" nowrap="nowrap" class="content3"><b>{TR_USED}</b></td>
        <td align="right" nowrap="nowrap" class="content3"><b>{TR_SIZE}</b></td>
      </tr>
      <!-- BDP: disk_list_item -->
      <tr>
        <td nowrap="nowrap">&nbsp;</td>
        <td class="{ITEM_CLASS}" nowrap="nowrap">{MOUNT}</td>
        <td class="{ITEM_CLASS}" nowrap="nowrap">{TYPE}</td>
        <td class="{ITEM_CLASS}" nowrap="nowrap">{PARTITION}</td>
        <td class="{ITEM_CLASS}" nowrap="nowrap" align="center"> {PERCENT} </td>
        <td class="{ITEM_CLASS}" nowrap="nowrap" align="right">{FREE}</td>
        <td class="{ITEM_CLASS}" nowrap="nowrap" align="right">{USED}</td>
        <td class="{ITEM_CLASS}" nowrap="nowrap" align="right">{SIZE}</td>
      </tr>
      <!-- EDP: disk_list_item -->
      <!-- EDP: disk_list -->
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
			</table>
		</td>
	</tr>
</table>
</body>
</html>
