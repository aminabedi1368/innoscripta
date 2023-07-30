<?php
namespace Database\Seeders;

use App\Constants\SettingConstants;
use App\Models\SettingModel;
use Illuminate\Database\Seeder;

/**
 * Class SettingsSeeder
 * @package Database\Seeders
 */
class SettingsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        SettingModel::query()->create([
            'key' => SettingConstants::KAVEHNEGAR_API_KEY,
            'value' => 'lwefnkw45'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::KAVEHNEGAR_SENDER_NUMBER,
            'value' => '8935638'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::KAVEHNEGAR_VERIFICATION_TEMPLATE_NAME,
            'value' => 'Verify'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::KAVEHNEGAR_VERIFICATION_TEXT,
            'value' => 'saalam'
        ]);


        SettingModel::query()->create([
            'key' => SettingConstants::TWILIO_SID,
            'value' => 'TWILIO_SID'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::TWILIO_TOKEN,
            'value' => 'TWILIO_TOKEN'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::TWILIO_FROM,
            'value' => 'TWILIO_FROM'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_GOOGLE_REDIRECT_OUR_OAUTH_TO_APPLICATION,
            'value' => 'http://localhost:8000/hi'
        ]);

        ### generate command => openssl rsa -in private.key -pubout -out public.key
        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_PUBLIC_KEY,
            'value' => '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAxa4+fGrdhJ630gDnTWJk
ZWLt2NyPw1QL+0W+1sVbNMuTYvh2AkdiW2dZKCT07gk7jX/XxA+2hxbBex5vtxcO
tp7OrHN6yZj/Yh7VYDIGleklw4MAqXj3xmK1i00HNAbTpdgfGz42P/rOPI4QY0Y3
DlNF+IBsoqFulFJkKkahUMB3KxqS3kBmbRkhPxSBAs/JnuI4cLACqz33QBG6Ha6H
jPZ4X3w7cZcP0k+g5skJ6ofmBjz9vDk0Q61cZq98SlbBxdAgLkvjvFdtr+5EXBM1
fAknV5tTD822/a9Ox/T+0mp+3Kh+tlxlKcGyQttFea6NkuzWAPxrPMXUrxRmDCzZ
WQIDAQAB
-----END PUBLIC KEY-----'
        ]);

        ### generate command => php -r 'echo base64_encode(random_bytes(32)), PHP_EOL;'
        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_ENCRYPTION_KEY,
            'value' => 'IEK7vnHJzGLWusqgJkS5x5K4l3OIy4DzkxFTZPinzfY='
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_ACCESS_TOKEN_EXPIRES_DAYS,
            'value' => 7
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_REFRESH_TOKEN_EXPIRES_DAYS,
            'value' => 30
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::IS_IDENTIFIER_EMAIL_ENABLED,
            'value' => true
        ]);

        ###########################
        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_GOOGLE_CLIENT_ID,
            'value' => "95358021083-k8sg9ejlep2jj7k3nng5bm7c5lmscgm0.apps.googleusercontent.com"
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_GOOGLE_CLIENT_SECRET,
            'value' => "Btzt9tTVgg-dyUYHu3N11Xam"
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_GOOGLE_REDIRECT_TO_OUR_OAUTH,
            'value' => "http://localhost:8000/login/google/callback"
        ]);
        ##########################################

        SettingModel::query()->create([
            'key' => SettingConstants::IS_IDENTIFIER_MOBILE_ENABLED,
            'value' => true
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::IS_IDENTIFIER_USERNAME_ENABLED,
            'value' => false
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_SERVER_ADDRESS,
            'value' => 'mail.zoho.com'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_SERVER_PORT,
            'value' => '587'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_SERVER_TIMEOUT_SECONDS,
            'value' => 30
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_SERVER_USERNAME,
            'value' => 'support@zoho.com'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_SERVER_PASSWORD,
            'value' => '4Hydzcst'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_VERIFICATION_FROM_ADDRESS,
            'value' => 'support@zoho.com'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_VERIFICATION_FROM_NAME,
            'value' => 'Agatizer'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_VERIFICATION_SUBJECT,
            'value' => 'Verify Your Account'
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::CLIENT_TOKEN_EXPIRES_DAYS,
            'value' => 2000
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::OTP_EXPIRE_IN_MINUTES,
            'value' => 2
        ]);

        SettingModel::query()->create([
            'key' => SettingConstants::WEBSITE_URL,
            'value' => "https://agatizer.com"
        ]);


        ### generate command => openssl genrsa -out private.key 2048
        SettingModel::query()->create([
            'key' => SettingConstants::OAUTH_PRIVATE_KEY,
            'value' => '-----BEGIN RSA PRIVATE KEY-----
MIIEowIBAAKCAQEAxa4+fGrdhJ630gDnTWJkZWLt2NyPw1QL+0W+1sVbNMuTYvh2
AkdiW2dZKCT07gk7jX/XxA+2hxbBex5vtxcOtp7OrHN6yZj/Yh7VYDIGleklw4MA
qXj3xmK1i00HNAbTpdgfGz42P/rOPI4QY0Y3DlNF+IBsoqFulFJkKkahUMB3KxqS
3kBmbRkhPxSBAs/JnuI4cLACqz33QBG6Ha6HjPZ4X3w7cZcP0k+g5skJ6ofmBjz9
vDk0Q61cZq98SlbBxdAgLkvjvFdtr+5EXBM1fAknV5tTD822/a9Ox/T+0mp+3Kh+
tlxlKcGyQttFea6NkuzWAPxrPMXUrxRmDCzZWQIDAQABAoIBAGpwoASuJgi6zY+u
HN12FUjiM9+JI3+xSaJKs69BJRMQapPn5OLlPPiqdT9AZwGkxwQxyiQvscCbaCK7
CLw1Fh8O84m3xG24jApxP8NELHebylGzwC+AiymvDMGtACvrYRrzfAxXOy7IBTRl
6j0KGasE+7AKtnP7KGeE1ZpN3Z50j5pKA3LxLDJJBJZcsWTkWKQK4YAx9wl259dH
c57QvdJURtCMoGDcmEFPzgPXmzN4CxXJiu9blbbcdAz8rjvb7n7CBLZdiEf+aFRd
vBZ9rG9eq+u7i9xwbgfVlR3utagjREgaNqePYb9qtIvDn+PIjYNllYXmgpCdR8o2
s8dTtAECgYEA/oeHcxiSbsSu2xlTb8U8gp2g265VaCJ0wKMf0HNc5stbeY2hBAdQ
wR2rLjKReG09vaVnpoJiTyC73NJJ2EU7pLbGIQdlFYCnWEVRiAJFOR0zXjr6aqdm
/XBZN/a5fWyPM6BJT2U/5iLKF5rubuxahPes0AhG5wc62hsoa36v1rECgYEAxtKh
ecBOgNTkN6SOHOT4OJvlzFds1S9AECXb1ne8uuiXRdJaitUGsOtBJvCI06EESsBx
vpUzMdfi2htE4narBwsWvVXlIeHMZzpl1GfHWTFP0B3owqBCbxbMkG/RrbAx6SEb
AC2babyIJRWr3lVR0Z30kaQBE66qqffuFSXWpykCgYAS6/Bd1g3MvkJhd1iEjp0Y
+K7kpekjfKxBRd8vl+PoJGYAe07lBcYzFQmMvaWi1jwoxQsXjcnRKBXPLLLgqQTu
EchY3DvfhVjrbvvIqKKMxGb1Ml07YIZ/gMKhLm5LrK5YoCnTBSvi5+MuLg5boKZ6
DA+Ex5i9xAPUAwDWPOzFgQKBgDh1Q2lBVIl86rlqPvixhFL+4gheowb+feCX/48t
PSiON7aZ/yABUf8XLs8R6qi9xmw7rZEC6SC0PzTUHYF5VSOQ4IovQ/uVFOgTSys/
tPn86L8eXyQ1QegtvzUcq5v4tpOO1Q395W3nHXn6Z22hKLSvd+2LdsrSBKBzSOY0
cnnRAoGBAPzDXBktKSPaYbqBt9giABQ4orxTsnIIGBnOr3ZbIC3EFCh1Sgb+K0NG
xs5F6pwiE24QVJnAyd0v/qfnUakt8ll0za6tEP17uFuXnjvY1+ti0u5ZA33OoOEY
7UatPLdtk4azeTFgb0JbgY1cb4wJRRu3P4Jnj0+nUziNpJyfv3Hr
-----END RSA PRIVATE KEY-----'
        ]);


        $html = <<<EOD
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
              <meta name="viewport" content="width=device-width, initial-scale=1.0" />
              <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
              <title>Verify your email address</title>
              <style type="text/css" rel="stylesheet" media="all">
                /* Base ------------------------------ */
                *:not(br):not(tr):not(html) {
                  font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
                  -webkit-box-sizing: border-box;
                  box-sizing: border-box;
                  direction: rtl;
                }
                body {
                  width: 100% !important;
                  height: 100%;
                  margin: 0;
                  line-height: 1.4;
                  background-color: #F5F7F9;
                  color: #839197;
                  -webkit-text-size-adjust: none;
                  direction: rtl;
                }
                a {
                  color: #414EF9;
                }

                /* Layout ------------------------------ */
                .email-wrapper {
                  width: 100%;
                  margin: 0;
                  padding: 0;
                  background-color: #F5F7F9;
                }
                .email-content {
                  width: 100%;
                  margin: 0;
                  padding: 0;
                }

                /* Masthead ----------------------- */
                .email-masthead {
                  padding: 25px 0;
                  text-align: center;
                }
                .email-masthead_logo {
                  max-width: 400px;
                  border: 0;
                }
                .email-masthead_name {
                  font-size: 16px;
                  font-weight: bold;
                  color: #839197;
                  text-decoration: none;
                  text-shadow: 0 1px 0 white;
                }

                /* Body ------------------------------ */
                .email-body {
                  width: 100%;
                  margin: 0;
                  padding: 0;
                  border-top: 1px solid #E7EAEC;
                  border-bottom: 1px solid #E7EAEC;
                  background-color: #FFFFFF;
                }
                .email-body_inner {
                  width: 570px;
                  margin: 0 auto;
                  padding: 0;
                }
                .email-footer {
                  width: 570px;
                  margin: 0 auto;
                  padding: 0;
                  text-align: center;
                }
                .email-footer p {
                  color: #839197;
                }
                .body-action {
                  width: 100%;
                  margin: 30px auto;
                  padding: 0;
                  text-align: center;
                }
                .body-sub {
                  margin-top: 25px;
                  padding-top: 25px;
                  border-top: 1px solid #E7EAEC;
                }
                .content-cell {
                  padding: 35px;
                }
                .align-right {
                  text-align: right;
                }

                /* Type ------------------------------ */
                h1 {
                  margin-top: 0;
                  color: #292E31;
                  font-size: 19px;
                  font-weight: bold;
                  text-align: right;
                }
                h2 {
                  margin-top: 0;
                  color: #292E31;
                  font-size: 16px;
                  font-weight: bold;
                  text-align: right;
                }
                h3 {
                  margin-top: 0;
                  color: #292E31;
                  font-size: 14px;
                  font-weight: bold;
                  text-align: right;
                }
                p {
                  margin-top: 0;
                  color: #839197;
                  font-size: 16px;
                  line-height: 1.5em;
                  text-align: right;
                }
                p.sub {
                  font-size: 12px;
                }
                p.center {
                  text-align: center;
                }

                /* Buttons ------------------------------ */
                .button {
                  display: inline-block;
                  width: 200px;
                  background-color: #414EF9;
                  border-radius: 3px;
                  color: #ffffff;
                  font-size: 15px;
                  line-height: 45px;
                  text-align: center;
                  text-decoration: none;
                  -webkit-text-size-adjust: none;
                  mso-hide: all;
                }
                .button--green {
                  background-color: #28DB67;
                }
                .button--red {
                  background-color: #FF3665;
                }
                .button--blue {
                  background-color: #414EF9;
                }
                .logo {
            width: 100px;
            height: auto;
                }
                /*Media Queries ------------------------------ */
                @media only screen and (max-width: 600px) {
                  .email-body_inner,
                  .email-footer {
                    width: 100% !important;
                  }
                }
                @media only screen and (max-width: 500px) {
                  .button {
                    width: 100% !important;
                  }
                }
              </style>
            </head>
            <body>
              <table class="email-wrapper" width="100%" cellpadding="0" cellspacing="0">
                <tr>
                  <td align="center">
                    <table class="email-content" width="100%" cellpadding="0" cellspacing="0">
                      <!-- Logo -->
                      <tr>
                        <td class="email-masthead">

                          <a href={{website_url}} class="email-masthead_name"><img class="logo" src="https://cdn.agatizer.com/logo.png" alt=""></a>
                        </td>
                      </tr>
                      <!-- Email Body -->
                      <tr>
                        <td class="email-body" width="100%">
                          <table class="email-body_inner" align="center" width="570" cellpadding="0" cellspacing="0">
                            <!-- Body content -->
                            <tr>
                              <td class="content-cell">
                                <h1>فعال سازی حساب کاربری‎</h1>
                                <p>
                                  با سلام {{username}}
            <br>
            با تشکر از شما بابت عضویت در وبسایت محصولات میشا، کد زیر را در صفحه اعتبارسنجی وارد کنید یا بر روی لینک کلیک کنید.

                                </p>
                                <!-- Action -->
                                <table class="body-action" align="center" width="100%" cellpadding="0" cellspacing="0">
                                  <tr>
                                    <td align="center">
                                      <div>
                                        <!--[if mso]><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{action_url}}" style="height:45px;v-text-anchor:middle;width:200px;" arcsize="7%" stroke="f" fill="t">
                                        <v:fill type="tile" color="#414EF9" />
                                        <w:anchorlock/>
                                        <center style="color:#ffffff;font-family:sans-serif;font-size:15px;">Verify Email</center>
                                      </v:roundrect><![endif]-->
                                        <a href="#" class="button button--blue">{{code}}</a>
                                      </div>
                                    </td>
                                  </tr>
                                </table>
                                <p>با تشکر،<br>پلتفرم میشا</p>
                                <!-- Sub copy -->
                                <table class="body-sub">
                                  <tr>
                                    <td>
                                      <p class="sub">If you’re having trouble clicking the button, copy and paste the URL below into your web browser.
                                      </p>
                                      <p class="sub"><a href="#">{{code}}</a></p>
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <table class="email-footer" align="center" width="570" cellpadding="0" cellspacing="0">
                            <tr>
                              <td class="content-cell">
                                <p class="sub center">
                                  <p class="sub center" style="direction: ltr !important;">&copy; 2023 . All rights reserved.</p>
                                  <br>
                                <br>
                                02188693032 - 02188694191
                                </p>
                              </td>
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

        EOD;

        SettingModel::query()->create([
            'key' => SettingConstants::MAIL_VERIFICATION_TEMPLATE,
            'value' => $html
        ]);

    }

}
