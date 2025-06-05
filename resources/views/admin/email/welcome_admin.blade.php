<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
<title>{{ config('app.name', 'Boy Projects') }} - Welcome Admin</title>

<style type="text/css">

	    body{width: 100%; background-color: #383434; margin:0; padding:0; -webkit-font-smoothing: antialiased;mso-margin-top-alt:0px; mso-margin-bottom-alt:0px; mso-padding-alt: 0px 0px 0px 0px;}
        
        p,h1,h2,h3,h4{margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;}
        
        span.preheader{display: none; font-size: 1px;}
        
        html{width: 100%;}
        
        table{font-size: 12px;border: 0;}
		
		.menu-space{padding-right:25px;}
		
		a,a:hover { text-decoration:none; color:#FFF;}

        .credentials-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        .credentials-table td {
            padding: 8px 12px;
            border: 1px solid #e2e3e3;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
        }
        
        .credential-label {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #4c4c4c;
            width: 30%;
        }
        
        .credential-value {
            background-color: #ffffff;
            color: #333;
            font-family: 'Courier New', monospace;
        }


@media only screen and (max-width:640px)

{
	body {width:auto!important;}
	table [class=main] {width:440px !important;}
	table [class=two-left] {width:420px !important; margin:0px auto;}
	table [class=full] {width:100% !important; margin:0px auto;}
	table [class=two-left-inner] {width:400px !important; margin:0px auto;}
	table [class=menu-icon] { display:none;}

	}

@media only screen and (max-width:479px)
{
	body {width:auto!important;}
	table [class=main]  {width:310px !important;}
	table [class=two-left] {width:300px !important; margin:0px auto;}
	table [class=full] {width:100% !important; margin:0px auto;}
	table [class=two-left-inner] {width:280px !important; margin:0px auto;}
	table [class=menu-icon] { display:none;}

	
}



</style>

</head>

<body yahoo="fix" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<!--Main Table Start-->

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434">
  <tr>
    <td align="center" valign="middle">
    
    
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434" data-bgcolor="BodyBg" data-module="23-1-top-space" data-thumb="http://www.freetemplates.bz/design/thumbnails/bignote/23-1.png">
  <tr>
    <td align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td height="90" align="center" valign="top" style="font-size:90px; line-height:90px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434" data-bgcolor="BodyBg" data-module="23-2-logo-part" data-thumb="http://www.freetemplates.bz/design/thumbnails/bignote/23-2.png">
  <tr>
    <td align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF" style="-moz-border-radius: 25px 25px 0px 0px; border-radius: 25px 25px 0px 0px; border-bottom:#e2e3e3 solid 1px;"><table width="380" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left-inner">
          <tr>
            <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top"><table border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" valign="middle">
                    <h2 style="color: #875ab9; font-family: Arial, Helvetica, sans-serif; margin: 0; padding: 10px;">
                        {{ config('app.name', 'Boy Projects') }}
                    </h2>
                </td>
              </tr>
            </table></td>
          </tr>
          <tr>
             <td height="20" align="center" valign="top" style="font-size:20px; line-height:20px;">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434" data-bgcolor="BodyBg" data-module="23-3-text-part" data-thumb="http://www.freetemplates.bz/design/thumbnails/bignote/23-3.png">
  <tr>
    <td align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF"><table width="380" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left-inner">
          <tr>
            <td height="60" align="center" valign="top" style="font-size:60px; line-height:60px;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              
              <tr>
                <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#4c4c4c; font-weight:normal; line-height:36px;" mc:edit="bm23-03"><multiline>Hello {{ $admin->name ?? 'Admin' }}!</multiline></td>
              </tr>
              
              <tr>
                <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:30px; color:#4c4c4c; font-weight:normal;" mc:edit="bm23-04"><multiline>Welcome to Our Team</multiline></td>
              </tr>
              
               <tr>
                <td height="10" align="center" valign="top" style="font-size:10px; line-height:10px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#4c4c4c; font-weight:normal; line-height:24px; padding:0px 20px;" mc:edit="bm23-05"><multiline>Your administrator account has been successfully created. You now have access to manage and support our platform.</multiline></td>
              </tr>
              
              <tr>
                <td height="20" align="center" valign="top" style="font-size:20px; line-height:20px;">&nbsp;</td>
              </tr>

              <!-- Login Credentials Section -->
              <tr>
                <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#4c4c4c; font-weight:bold; padding:0px 20px;"><multiline>Account Information</multiline></td>
              </tr>
              
              <tr>
                <td height="15" align="center" valign="top" style="font-size:15px; line-height:15px;">&nbsp;</td>
              </tr>

              <tr>
                <td align="center" valign="top" style="padding:0px 20px;">
                  <table class="credentials-table">
                    <tr>
                      <td class="credential-label">Email:</td>
                      <td class="credential-value">{{ $admin->email }}</td>
                    </tr>
                    <tr>
                      <td class="credential-label">Status:</td>
                      <td class="credential-value">
                        @if($admin->is_active)
                          <span style="color: #28a745;">Active</span>
                        @else
                          <span style="color: #dc3545;">Inactive</span>
                        @endif
                        | 
                        @if($admin->verified)
                          <span style="color: #28a745;">Verified</span>
                        @else
                          <span style="color: #ffc107;">Pending Verification</span>
                        @endif
                      </td>
                    </tr>
                    @if(isset($admin->role))
                    <tr>
                      <td class="credential-label">Role:</td>
                      <td class="credential-value">{{ ucfirst($admin->role) }}</td>
                    </tr>
                    @endif
                    <tr>
                      <td class="credential-label">Account Created:</td>
                      <td class="credential-value">{{ $admin->created_at->format('M d, Y') }}</td>
                    </tr>
                  </table>
                </td>
              </tr>
              
              <tr>
                <td height="20" align="center" valign="top" style="font-size:20px; line-height:20px;">&nbsp;</td>
              </tr>

              @if(isset($password))
              <tr>
                <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#4c4c4c; font-weight:normal; line-height:20px; padding:0px 20px;" mc:edit="bm23-05">
                  <multiline>
                    <strong>Temporary Password:</strong> {{ $password }}<br/>
                    <strong>Important:</strong> Please verify your account first, then change this password immediately after your first login for security reasons.
                  </multiline>
                </td>
              </tr>
              @else
              <tr>
                <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#4c4c4c; font-weight:normal; line-height:20px; padding:0px 20px;" mc:edit="bm23-05">
                  <multiline>
                    <strong>Important:</strong> Please verify your account first. Your login credentials have been provided separately for security reasons.
                  </multiline>
                </td>
              </tr>
              @endif
              
              <tr>
                <td align="center" valign="top">&nbsp;</td>
              </tr>
              
              <tr>
                <td align="center" valign="top"><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
                  <tr>
                    @if(!$admin->verified && isset($verificationUrl))
                    <td height="50" align="center" valign="middle" bgcolor="#28a745" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#FFF; font-weight:normal; text-transform:uppercase; -moz-border-radius: 30px; border-radius: 30px;" data-bgcolor="theme-bg" mc:edit="bm23-06">
                        <a href="{{ $verificationUrl }}" style="text-decoration:none; color:#FFF; display: block; padding: 15px; width: 100%; box-sizing: border-box;">Verify Account</a>
                    </td>
                    @else
                    <td height="50" align="center" valign="middle" bgcolor="#875ab9" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#FFF; font-weight:normal; text-transform:uppercase; -moz-border-radius: 30px; border-radius: 30px;" data-bgcolor="theme-bg" mc:edit="bm23-06">
                        <a href="{{ $loginUrl ?? route('admin.login') }}" style="text-decoration:none; color:#FFF; display: block; padding: 15px; width: 100%; box-sizing: border-box;">Admin Login</a>
                    </td>
                    @endif
                  </tr>
                </table></td>
              </tr>

              <tr>
                <td height="25" align="center" valign="top" style="font-size:25px; line-height:25px;">&nbsp;</td>
              </tr>

              <!-- Features Section -->
              <tr>
                <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:14px; color:#4c4c4c; font-weight:normal; line-height:22px; padding:0px 20px;" mc:edit="bm23-07">
                  <multiline>
                    <strong>Admin Access Includes:</strong><br/>
                    • Dashboard and Analytics<br/>
                    • User Management<br/>
                    • Content Management<br/>
                    • Communication Tools<br/>
                    • System Configuration<br/>
                    @if($admin->verified && $admin->is_active)
                    • Full Administrative Access
                    @else
                    • Limited Access (until verification is complete)
                    @endif
                  </multiline>
                </td>
              </tr>

              @if(!$admin->verified || !$admin->is_active)
              <tr>
                <td height="20" align="center" valign="top" style="font-size:20px; line-height:20px;">&nbsp;</td>
              </tr>
              <tr>
                <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:12px; color:#dc3545; font-weight:normal; line-height:18px; padding:15px 20px; background-color:#fff3cd; border: 1px solid #ffeaa7; border-radius: 5px;">
                  <multiline>
                    <strong>Note:</strong> 
                    @if(!$admin->verified)
                    Your account requires verification before full access is granted.
                    @endif
                    @if(!$admin->is_active)
                    Your account is currently inactive. Please contact the system administrator.
                    @endif
                  </multiline>
                </td>
              </tr>
              @endif

            </table></td>
          </tr>
          <tr>
             <td height="50" align="center" valign="top" style="font-size:50px; line-height:50px;">&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434" data-bgcolor="BodyBg" data-module="23-4-bottom-bg-part" data-thumb="http://www.freetemplates.bz/design/thumbnails/bignote/23-4.png">
  <tr>
    <td align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td align="center" valign="top" bgcolor="#FFFFFF" style="-moz-border-radius:0px 0px 25px 25px; border-radius:0px 0px 25px 25px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434" data-bgcolor="BodyBg" data-module="23-5-copyright-part" data-thumb="http://www.freetemplates.bz/design/thumbnails/bignote/23-5.png">
  <tr>
    <td align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td align="center" valign="top"><table width="380" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left-inner">
          <tr>
            <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
          </tr>
          <tr>
            <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; color:#FFF; font-weight:bold; line-height:28px;" mc:edit="bm14-04"><multiline>Copyright &copy; {{ date('Y') }} {{ config('app.name', 'Boy Projects') }} </multiline></td>
          </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#383434" data-bgcolor="BodyBg" data-module="23-6-bottom-space-part" data-thumb="http://www.freetemplates.bz/design/thumbnails/bignote/23-6.png">
  <tr>
    <td align="center" valign="middle"><table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
      <tr>
        <td height="90" align="center" valign="top" style="font-size:90px; line-height:90px;">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>
    
    
    </td>
  </tr>
</table>

<!--Main Table End-->

</body>
</html> 