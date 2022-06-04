<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UpsellUpscale.com</title>
    <style>
      html,
      body,
      table,
      tbody,
      tr,
      td,
      div,
      p,
      ul,
      ol,
      li,
      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        margin: 0;
        padding: 0;
      }
      
      body {
        margin: 0;
        padding: 0;
        font-size: 0;
        line-height: 0;
        -ms-text-size-adjust: 100%;
        -webkit-text-size-adjust: 100%;
      }
      
      table {
        border-spacing: 0;
        mso-table-lspace: 0pt;
        mso-table-rspace: 0pt;
      }
      
      table td {
        border-collapse: collapse;
      }
      
      .ExternalClass {
        width: 100%;
      }
      
      .ExternalClass,
      .ExternalClass p,
      .ExternalClass span,
      .ExternalClass font,
      .ExternalClass td,
      .ExternalClass div {
        line-height: 100%;
      }
      /* Outermost container in Outlook.com */
      
      .ReadMsgBody {
        width: 100%;
      }
      
      img {
        -ms-interpolation-mode: bicubic;
      }
    </style>
    <style>
      .container600 {
        width: 600px;
        max-width: 100%;
      }
      
      @media all and (max-width: 600px) {
        .container600 {
          width: 100% !important;
        }
      }
      
      .col49 {
        width: 49%;
      }
      
      .col2 {
        width: 2%;
      }

      .col50 {
        width: 50%;
      }
      
      @media all and (max-width: 599px) {
        .fluid {
          width: 100% !important;
        }
        .reorder {
          width: 100% !important;
          margin: 0 auto 10px;
        }
        .ghost-column {
          display:none;
          height:0;
          width:0;
          overflow:hidden;
          max-height:0;
          max-width:0;
        }
      }
    </style>

    <!--[if gte mso 9]>
        <style>
            .ol {
              width: 100%;
            }
        </style>
    <![endif]-->
  </head>
  <body style="background-color: #f4f4f4;">
    <center>

      <!--[if gte mso 9]><table width="600" cellpadding="0" cellspacing="0"><tr><td>
                    <![endif]-->
      <table class="container600" cellpadding="0" cellspacing="0" border="0" width="100%" style="width:calc(100%);max-width:calc(600px);margin: 0 auto;">
        <tr>
          <td width="100%" style="text-align: left;">
            {{-- logo start --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
              <tr>
                <td width="100%" style="min-width:100%;background-color:#ffffff;padding:30px;">
                <img alt="EDMdesigner logo" src="{{ $objProfessionals->app_url.'/images/logo-nav.png' }}" width="210" style="display: block;" />
                </td>
              </tr>
            </table>
            {{-- logo end --}}

            {{-- short description start --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
              <tr>
                <td width="100%" style="background-color:#F8F7F0;color:#58585A;padding:30px;">
                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                      <td style="padding-top:10px;padding-bottom:24px;">
                        <h1 style="font-family:Arial;font-size:28px;line-height:32px;">Hi! {{ $objProfessionals->user && $objProfessionals->user->full_name ? $objProfessionals->user->full_name :''}}</h1>
                      </td>
                    </tr>
                  </table>
                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                      <td style="padding-top:15px;padding-bottom:15px;">
                        <p style="font-family:Georgia, Arial, sans-serif;font-size:16px;line-height:20px;">Here is list of Recommended sales Professionals from UpsellUpscale.com for your service {{ $objProfessionals->service && $objProfessionals->service->title ? $objProfessionals->service->title :'' }}</p>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            {{-- short description end --}}
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
              <tr>
                <td width="100%" style="min-width:100%;background-color:#ffffff;padding:20px;">
                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                      <td style="padding-top:10px;padding-bottom:20px;background-color:#FFFFFF;color:#58585A;">
                        <h2 style="font-family:Arial;font-size:24px;line-height:28px;">Sales Professionals</h2>
                      </td>
                    </tr>
                  </table>
                  <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                      <td style="padding-top:10px;padding-bottom:20px;background-color:#FFFFFF;color:#58585A;">
                        <h3 style="font-family:Arial;font-size:20px;line-height:24px;">Recommended by UpsellUpscale.com</h3>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
              <tr>
                <td style="background-color:#F8F7F0;padding:20px;">
                  {{-- 2 items in a row start --}}
                  @if ($objProfessionals->freelancers)
                  @foreach ($objProfessionals->freelancers as $item)
                      
                <a href="{{ $objProfessionals->app_url .'/user-profile/'. $item->freelancer->id }}">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td width="100%" valign="top" style="min-width: 100%;">

                        <!--[if gte mso 9]><table width="100%" cellpadding="0" cellspacing="0"><tr><![endif]-->
                          <!--[if gte mso 9]><td width="49%" valign="top">                                                <![endif]-->
                        <table class="ol col49 reorder" width="100%" align="left" style="width: 100%;" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="100%" valign="top" style="background-color:#ffffff;color:#000000;">
                              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:1px solid #afafaf;border-bottom:1px solid #afafaf;min-width:100%;">
                                <tr>
                                  <td width="100%" style="min-width:100%;padding:15px;">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tr>
                                        <td style="padding-top:10px;padding-bottom:20px;">
                                          <h3 style="font-family:Arial;font-size:20px;line-height:24px;">{{ $item->full_name  ? $item->full_name :'' }}</h3>
                                        </td>
                                      </tr>
                                    </table>
                                    <img alt="" src="{{ $item->avatar  ? url('/images/users/'.$item->avatar) :url('/images/users/avatar.png') }}" width="210" style="display: block;" />
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tr>
                                        <td style="padding-top:15px;padding-bottom:15px;">
                                          <p style="font-family:Georgia, Arial, sans-serif;font-size:16px;line-height:20px;">${{ $item->freelancer && $item->freelancer->price ? $item->freelancer->price :'' }}</p>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table>

                        <!--[if gte mso 9]></td><![endif]-->
                        <!--[if gte mso 9]><td width="2%" valign="top">                                                <![endif]-->

                        <table class="ol col2 ghost-column" width="100%" align="left" style="width: calc(2%);" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="100%" valign="top" style="line-height: 20px;">
                              &nbsp;
                            </td>
                          </tr>
                        </table>

                        <!--[if gte mso 9]></td><![endif]-->
                          <!--[if gte mso 9]><td width="49%" valign="top">                                                <![endif]-->
                        {{-- <table class="ol col49 reorder" width="100%" align="left" style="width: calc(49%);" cellpadding="0" cellspacing="0" border="0">
                          <tr>
                            <td width="100%" valign="top" style="background-color:#ffffff;color:#000000;">
                              <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-top:1px solid #afafaf;border-bottom:1px solid #afafaf;min-width:100%;">
                                <tr>
                                  <td width="100%" style="min-width:100%;padding:15px;">
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tr>
                                        <td style="padding-top:10px;padding-bottom:20px;">
                                          <h3 style="font-family:Arial;font-size:20px;line-height:24px;">APPLE iPhone 6S 128GB Pink</h3>
                                        </td>
                                      </tr>
                                    </table>
                                    <img alt="" src="https://edmdesigner.github.io/modern-html-email-tutorial/lesson11/img/unas_361921.jpg" width="210" style="display: block;" />
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                      <tr>
                                        <td style="padding-top:15px;padding-bottom:15px;">
                                          <p style="font-family:Georgia, Arial, sans-serif;font-size:16px;line-height:20px;">$349.0</p>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                        </table> --}}

                        <!--[if gte mso 9]></td><![endif]-->
                          <!--[if gte mso 9]></td></tr></table>                                                <![endif]-->
                      </td>
                    </tr>
                  </table>
                </a>
                  @endforeach
                  
                  @endif
                  {{-- 2 items in a row end --}} 
                 


                </td>
              </tr>
            </table>

            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="min-width:100%;">
              <tr>
                <td width="100%" style="min-width:100%;background-color:#ffffff;padding:20px;">
                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                      <td width="50%" valign="top" style="background-color:#ffffff;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                          <tr>
                            <td style="padding-top:15px;padding-bottom:15px;">
                              <p style="font-family:Georgia, Arial, sans-serif;font-size:16px;line-height:20px;">
                                <p style="font-family:Georgia, Arial, sans-serif;font-size:16px;line-height:20px;text-align: center;"> <p class="copyright-content-p">All rights reserved @ UpsellUpscale.com 2020</p>
                                <p>Powered by <a href="https://www.webonclicks.com.au/" class="link-color" target="#">WebOnClicks</a> </p></p>
                              </p>
                            </td>
                          </tr>
                        </table>
                      </td>
                      {{-- <td width="50%" valign="top" style="background-color:#ffffff;">
                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                          <tr>
                            <td style="padding-top:15px;padding-bottom:15px;">
                              <p style="font-family:Georgia, Arial, sans-serif;font-size:16px;line-height:20px;">$887.5</p>
                            </td>
                          </tr>
                        </table>
                      </td> --}}
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>

      <!--[if gte mso 9]></td></tr></table>
                    <![endif]-->
    </center>
  </body>
</html>
