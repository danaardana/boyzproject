<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;" />
<title>{{ config('app.name', 'Boy Projects') }}</title>

<style type="text/css">
    body{width: 100%; background-color: #383434; margin:0; padding:0; -webkit-font-smoothing: antialiased;mso-margin-top-alt:0px; mso-margin-bottom-alt:0px; mso-padding-alt: 0px 0px 0px 0px;}
    
    p,h1,h2,h3,h4{margin-top:0;margin-bottom:0;padding-top:0;padding-bottom:0;}
    
    span.preheader{display: none; font-size: 1px;}
    
    html{width: 100%;}
    
    table{font-size: 12px;border: 0;}
    
    .menu-space{padding-right:25px;}
    
    a,a:hover { text-decoration:none; color:#FFF;}

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
    
    <!-- Header Spacer -->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td height="70" align="center" valign="top" style="font-size:70px; line-height:70px;">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Logo Section -->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF" style="-moz-border-radius: 25px 25px 0px 0px; border-radius: 25px 25px 0px 0px;">
                <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="center" valign="top">
                      <table border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td align="center" valign="middle">
                            <a href="{{ url('/') }}">
                              <img src="{{ asset('admin/images/logo.png') }}" width="105" height="40" alt="{{ config('app.name') }}" />
                            </a>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                     <td height="20" align="center" valign="top" style="font-size:20px; line-height:20px;">&nbsp;</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Main Content Section -->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF">
                <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                  
                  <tr>
                    <td height="60" align="center" valign="top" style="font-size:60px; line-height:60px;">&nbsp;</td>
                  </tr>

                  <!-- Greeting -->
                  <tr>
                    <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#4c4c4c; font-weight:bold; line-height:24px;">
                      Hello {{ $customer->name }},
                    </td>
                  </tr>
                  <tr>
                    <td height="10" align="center" valign="top" style="font-size:10px; line-height:10px;">&nbsp;</td>
                  </tr>
                  
                  <!-- Main Content -->
                  <tr>
                    <td align="center" valign="top">
                      <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        
                        <!-- Title -->
                        <tr>
                          <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:20px; color:#4c4c4c; font-weight:bold; text-transform:uppercase;">
                            Response to Your Message
                          </td>
                        </tr>

                        <tr>
                          <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#4c4c4c; font-weight:normal; line-height:24px; padding:0px 35px;">&nbsp;</td>
                        </tr>
                        
                        <!-- Admin Response Box -->
                        <tr>
                          <td align="center" valign="top">
                            <table width="330" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                              <tr>
                                <td align="center" valign="middle" bgcolor="#f5f5f5" style="-moz-border-radius: 8px; border-radius: 8px;">
                                  <table width="290" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                      <td height="25" align="center" valign="top">&nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td align="left" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:15px; color:#4c4c4c; font-weight:normal; line-height:26px; padding: 0 20px;">
                                        {{ $adminResponse }}
                                      </td>
                                    </tr>
                                    <tr>
                                      <td height="25" align="center" valign="top">&nbsp;</td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>

                        <tr>
                          <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#e0365a; font-weight:normal; line-height:30px;">&nbsp;</td>
                        </tr>

                        <!-- Additional Info -->
                        <tr>
                          <td align="center" valign="top" style="font-family:'Open Sans', sans-serif, Verdana; font-size:13px; color:#666; font-weight:normal; line-height:20px; padding: 0 30px;">
                            <strong>Original Message:</strong> {{ $originalMessage->content_key ?? 'Your inquiry' }}<br>
                            <strong>Status:</strong> {{ ucfirst(str_replace('_', ' ', $messageStatus ?? 'resolved')) }}<br>
                            <strong>Responded by:</strong> {{ $adminName ?? 'Support Team' }}<br>
                            <strong>Date:</strong> {{ now()->format('M d, Y H:i') }}
                          </td>
                        </tr>

                        <tr>
                          <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:18px; color:#e0365a; font-weight:normal; line-height:30px;">&nbsp;</td>
                        </tr>

                        <!-- Contact Button -->
                        <tr>
                          <td align="center" valign="top">
                            <table width="180" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr>
                                <td height="50" align="center" valign="middle" bgcolor="#ef4447" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; color:#FFF; font-weight:bold; -moz-border-radius: 30px; border-radius: 30px;">
                                  <a href="{{ url('/') }}#contact" style="text-decoration:none; color:#FFF;">Contact Us Again</a>
                                </td>
                              </tr>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </td>
                  </tr>
                  <tr>
                     <td height="60" align="center" valign="top" style="font-size:60px; line-height:60px;">&nbsp;</td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Footer Spacer -->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF" style="-moz-border-radius:0px 0px 25px 25px; border-radius:0px 0px 25px 25px;">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Footer -->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td align="center" valign="top">
                <table width="350" border="0" align="center" cellpadding="0" cellspacing="0" class="two-left">
                  <tr>
                    <td height="35" align="center" valign="top" style="font-size:35px; line-height:35px;">&nbsp;</td>
                  </tr>
                  
                  <tr>
                    <td height="10" align="center" valign="top" style="font-size:10px; line-height:10px;">&nbsp;</td>
                  </tr>

                  <tr>
                    <td align="center" valign="top" style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#FFF; font-weight:normal; line-height:24px;">
                      <p>Thank you for choosing {{ config('app.name', 'Boy Projects') }}!</p>
                      <p>Your trusted partner for motorcycle spare parts and accessories.</p>
                      <br>
                      <p>Copyright &copy; {{ date('Y') }} {{ config('app.name', 'Boy Projects') }}. All rights reserved.</p>
                    </td>
                  </tr>

                </table>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- Bottom Spacer -->
    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="middle">
          <table width="450" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
            <tr>
              <td height="60" align="center" valign="top" style="font-size:60px; line-height:60px;">&nbsp;</td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    
    </td>
  </tr>
</table>

<!--Main Table End-->

</body>
</html> 