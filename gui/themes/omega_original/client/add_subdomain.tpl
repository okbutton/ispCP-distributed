<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}">
<title>{TR_CLIENT_ADD_SUBDOMAIN_PAGE_TITLE}</title>
  <meta name="robots" content="noindex">
  <meta name="robots" content="nofollow">
<link href="{THEME_COLOR_PATH}/css/ispcp.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="{THEME_COLOR_PATH}/css/ispcp.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
function makeUser(){
    var subname  = document.forms[0].elements['subdomain_name'].value;

	subname = subname.toLowerCase();
    subname = subname.replace(/�/gi, "ae");
    subname = subname.replace(/�/gi, "ue");
    subname = subname.replace(/�/gi, "oe");
    subname = subname.replace(/�/gi, "ss");

	document.forms[0].elements['subdomain_mnt_pt'].value = "/" + subname.replace(/\./g ,'_');
}

function MM_preloadImages() { //v3.0
	var d=document;
	if(d.images){
  	if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments;
		for(i=0; i<a.length; i++)
		    if (a[i].indexOf("#")!=0) {
				d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];
			}
	}
}

function MM_swapImgRestore() { //v3.0
	var i,x,a=document.MM_sr;
	for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++)
		x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  	var p,i,x;
  	if(!d) d=document;
  		if((p=n.indexOf("?"))>0&&parent.frames.length) {
    		d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);
		}
  	if(!(x=d[n])&&d.all)
  		x=d.all[n];
 	for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  	for(i=0;!x&&d.layers&&i<d.layers.length;i++)
		x=MM_findObj(n,d.layers[i].document);
  	if(!x && d.getElementById)
		x=d.getElementById(n);
	return x;
}

function MM_swapImage() { //v3.0
  	var i,j=0,x,a=MM_swapImage.arguments;
  	document.MM_sr=new Array;
	for(i=0;i<(a.length-2);i+=3)
   	if ((x=MM_findObj(a[i]))!=null) {
		document.MM_sr[j++]=x;
		if(!x.oSrc)
			x.oSrc=x.src;
		x.src=a[i+2];
	}
}
//-->
</script>
</head>

<body onLoad="MM_preloadImages('{THEME_COLOR_PATH}/images/icons/database_a.gif','{THEME_COLOR_PATH}/images/icons/domains_a.gif','{THEME_COLOR_PATH}/images/icons/ftp_a.gif','{THEME_COLOR_PATH}/images/icons/general_a.gif' ,'{THEME_COLOR_PATH}/images/icons/email_a.gif','{THEME_COLOR_PATH}/images/icons/webtools_a.gif','{THEME_COLOR_PATH}/images/icons/statistics_a.gif','{THEME_COLOR_PATH}/images/icons/support_a.gif','{THEME_COLOR_PATH}/images/icons/custom_link_a.gif')">
<!-- BDP: logged_from --><table width="100%"  border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="20" nowrap background="{THEME_COLOR_PATH}/images/button.gif">&nbsp;&nbsp;&nbsp;<a href="change_user_interface.php?action=go_back"><img src="{THEME_COLOR_PATH}/images/icons/close_interface.png" width="18" height="18" border="0" align="absmiddle"></a> <font color="red">{YOU_ARE_LOGGED_AS}</font> </td>
      </tr>
    </table>
	<!-- EDP: logged_from -->
<table width="100%" border="0" cellspacing="0" cellpadding="0" height="100%" style="border-collapse: collapse;padding:0;margin:0;">
	<tr>
		<td align="left" valign="top" style="vertical-align: top; width: 195px; height: 56px;"><img src="{THEME_COLOR_PATH}/images/top/top_left.jpg" border="0"></td>
		<td style="height: 56px; width: 617px;"><img src="{THEME_COLOR_PATH}/images/top/top_left_bg.jpg" border="0"></td>
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
                      <td colspan="2" class="title">{TR_ADD_SUBDOMAIN}</td>
                    </tr>
                </table></td>
                <td width="27" align="right">&nbsp;</td>
              </tr>
              <tr>
                <td valign="top"><table width="100%"  border="00" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="40">&nbsp;</td>
                      <td valign="top"><form name="client_add_subdomain_frm" method="post" action="add_subdomain.php">
                          <table width="100%" cellspacing="5">
                            <!-- BDP: page_message -->
                            <tr>
                              <td colspan="2" class="title"><font color="#FF0000">{MESSAGE}</font></td>
                            </tr>
                            <!-- EDP: page_message -->
                            <tr>
                              <td width="250" class="content2">{TR_SUBDOMAIN_NAME}</td>
                              <td class="content"><input type="text" name="subdomain_name" value="{SUBDOMAIN_NAME}" style="width:170px" class="textinput" onBlur="makeUser()";>
                                {DOMAIN_NAME}</td>
                            </tr>
                            <tr>
                              <td width="250" class="content2">{TR_DIR_TREE_SUBDOMAIN_MOUNT_POINT}</td>
                              <td class="content"><input type="text" name="subdomain_mnt_pt" value="{SUBDOMAIN_MOUNT_POINT}" style="width:170px" class="textinput">
                              </td>
                            </tr>
                            <tr>
                              <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                              <td colspan="2"><input name="Submit" type="submit" class="button" value="{TR_ADD}">
                                  <input type="hidden" name="uaction" value="add_subd"></td>
                            </tr>
                          </table>
                      </form></td>
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
        </table>
	  </td>
	</tr>
</table>
</body>
</html>
