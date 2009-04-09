<?xml version="1.0" encoding="{THEME_CHARSET}" ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>{TR_PAY_PAGE_TITLE}</title>
		<meta name="robots" content="nofollow, noindex" />
		<meta http-equiv="Content-Type" content="text/html; charset={THEME_CHARSET}" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<meta http-equiv="Content-Script-Type" content="text/javascript" />
		<link href="../themes/omega_original/css/ispcp.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="../themes/omega_original/css/ispcp.js"></script>
	</head>

	<body onload="MM_preloadImages('../themes/omega_original/images/icons/database_a.gif','../themes/omega_original/images/icons/hosting_plans_a.gif','../themes/omega_original/images/icons/domains_a.gif','../themes/omega_original/images/icons/general_a.gif','../themes/omega_original/images/icons/manage_users_a.gif','../themes/omega_original/images/icons/webtools_a.gif','../themes/omega_original/images/icons/statistics_a.gif','../themes/omega_original/images/icons/support_a.gif'); {TR_BODY_JOB}">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" style="height:100%">
			<tr>
				<td height="80" align="left" valign="top">&nbsp;</td>
			</tr>
			<tr>
				<td valign="top">
					<table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100%">
						<tr>
							<td valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="62" align="left" class="title">{TR_PURCHASE_FROM} {TR_PURCHASE_RESELLER_NAME}</td>
										<td width="27" align="right">&nbsp;</td>
									</tr>
									<tr>
										<td valign="top">
											<!-- BDP: pay_page -->
											<form name="paypal_form" action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post">
												<input type="hidden" name="cmd" value="_xclick" />
												<input type="hidden" name="business" value="{TR_RESELLER_MAIL}" />
												<input type="hidden" name="item_name" value="{TR_PACKAGE_NAME}" />
												<input type="hidden" name="item_number" value="{TR_PACKAGE_ID}" />
												<input type="hidden" name="custom" value="{TR_RESELLER_ID}" />
												<input type="hidden" name="return" value="{TR_RETURN_ADDRESS}" />
												<input type="hidden" name="amount" value="{TR_PACKAGE_PRICE}" />
												<input type="hidden" name="no_note" value="1" />
												<input type="hidden" name="currency_code" value="{TR_CURRENCY}" />
											</form>
											<br /><br /><br /><br /><br /><br /><br />
											<p align="center"><strong>{TR_PLEASE_WAIT}</strong></p>
											<!-- EDP: pay_page -->
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td height="71">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
