<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Verify Your Email</title>
</head>

<body style="margin:0; padding:0; background-color:#F7F7F7; font-family:Helvetica, Geneva, sans-serif; color:#6f6f6f;">
  <center style="width:100%; background-color:#F7F7F7;">

    <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="100%" bgcolor="#F7F7F7">
      <tr>
        <td style="padding:40px 10px;">

          <!-- Header -->
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="620" align="center" style="width:100%; max-width:620px;">
            <tr>
              <td align="center" style="padding-bottom:25px;">
                <a href="{{ config('app.url', 'Laravel') }}">
                  <img src="{{ config('app.url', 'Laravel') }}/assets/images/logo-dark.png" alt="TrendExpress" height="40" style="display:block; height:40px; border:0;">
                </a>
              </td>
            </tr>
          </table>

          <!-- Card -->
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="620" align="center" style="width:100%; max-width:620px; background-color:#ffffff;">
            <tr>
              <td style="padding:40px 30px;">

                <h2 style="margin:0 0 18px 0; font-weight:normal; color:#161616; font-size:18px;">
                  Welcome aboard, {{ $user->full_name }}!
                </h2>

                <p style="margin:0 0 18px 0; line-height:24px;">
                  We're excited to have you with us. To get started and ensure your account is secure, please verify your email address by clicking the button below:
                </p>

                <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-bottom:18px;">
                  <tr>
                    <td bgcolor="#FF4242">
                      <a href="{{ $url }}" target="_blank" style="display:inline-block; padding:12px 25px; font-size:16px; color:#ffffff; font-weight:medium; text-decoration:none;">
                        Verify Email Address
                      </a>
                    </td>
                  </tr>
                </table>

                <p style="font-size:14px; color:#666; line-height:20px;">
                  If the button above doesn't work, copy and paste the following link into your browser:<br>
                  <a href="{{ $url }}" style="color:#FF4242; word-break:break-all;">
                    {{ $url }}
                  </a>
                </p>

                <hr style="border:none; border-top:1px solid #eeeeee; margin:30px 0;">

                <p style="font-size:14px; color:#888; margin-bottom:20px;">
                  If you didn't create an account with us, you can safely ignore this email.
                </p>

                <p style="margin:0; line-height:24px; color:#161616;">
                  <span>Best Regards,</span> <br>
                  <span style="margin-top: 12px;">Trendexpress Team</span>
                </p>

              </td>
            </tr>
          </table>

          <!-- Footer -->
          <table role="presentation" cellpadding="0" cellspacing="0" border="0" width="620" align="center" style="width:100%; max-width:620px;">
            <tr>
              <td align="center" style="padding:25px 20px;">

                <p style="font-size:13px; margin:0;">
                  © {{ date('Y') }} TrendExpress. All rights reserved.
                </p>

                <table role="presentation" cellpadding="0" cellspacing="0" border="0" style="margin-top:15px;">
                  <tr>
                    @php
                      $whatsapp = $contacts->where('type', 'whatsapp')->first();
                      $instagram = $contacts->where('type', 'instagram')->first();
                      $phone = $contacts->where('type', 'phone')->first();
                      $email = $contacts->where('type', 'email')->first();
                    @endphp

                    @if ($phone)
                      <td style="padding:0 5px;">
                        <a href="tel:{{ $phone->value }}" target="_blank">
                          <img src="{{ config('app.url', 'Laravel') }}/assets/images/call.png" width="24" height="24" alt="CALL" style="display:block;">
                        </a>
                      </td>
                    @endif

                    @if ($email)
                      <td style="padding:0 5px;">
                        <a href="mailto:{{ $email->value }}" target="_blank">
                          <img src="{{ config('app.url', 'Laravel') }}/assets/images/email.png" width="24" height="24" alt="EMAIL" style="display:block;">
                        </a>
                      </td>
                    @endif

                    @if ($whatsapp)
                      <td style="padding:0 5px;">
                        <a href="{{ $whatsapp->value }}" target="_blank">
                          <img src="{{ config('app.url', 'Laravel') }}/assets/images/whatsapp.png" width="24" height="24" alt="WA" style="display:block;">
                        </a>
                      </td>
                    @endif

                    @if ($instagram)
                      <td style="padding:0 5px;">
                        <a href="{{ $instagram->value }}" target="_blank">
                          <img src="{{ config('app.url', 'Laravel') }}/assets/images/instagram.png" width="24" height="24" alt="IG" style="display:block;">
                        </a>
                      </td>
                    @endif

                  </tr>
                </table>

              </td>
            </tr>
          </table>

        </td>
      </tr>
    </table>

  </center>
</body>

</html>
