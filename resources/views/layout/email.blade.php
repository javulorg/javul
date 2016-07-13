<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <!-- If you delete this meta tag, Half Life 3 will never be released. -->
    <meta name="viewport" content="width=device-width" />

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Javul.org</title>

</head>

<body bgcolor="#FFFFFF" style="font-family: verdana;">

<!-- HEADER -->
<table width="100%" bgcolor="#E1672C">
    <tr>
        <td></td>
        <td style="margin:0 auto;max-width:600px;" >

            <div style="max-width:600px;margin:0 auto;padding:15px;">
                <table bgcolor="#E1672C">
                    <tr>
                        <td width="100%" style="width:100%;">
                            <a href="{!! url('') !!}">
                                <img src="{!! url('assets/images/logo.png') !!}" style="height: 60px;" height="60"/>
                            </a>
                        </td>
                        <td align="right"><h6 style="margin: 0;text-transform: uppercase;color:#fff">Javul.org</h6></td>
                    </tr>
                </table>
            </div>

        </td>
        <td></td>
    </tr>
</table><!-- /HEADER -->


<!-- BODY -->
<table width="100%">
    <tr>
        <td></td>
        <td bgcolor="#FFFFFF">

            <div style="display: block;margin: 0 auto;max-width: 600px;padding: 15px;">
                <table width="100%">
                    <tr>
                        <td>
                            @yield('content')
                            <!-- social & contact -->
                            <table width="100%" style="background-color:#ebebeb;margin-top: 20px;">
                                <tr>
                                    <td>

                                        <!-- column 1 -->
                                        <table align="left" style="width:280px;min-width:279px;float:left;">
                                            <tr>
                                                <td style="padding:15px;">
                                                    <h5 class="">Connect with Us:</h5>
                                                    <p class="">
                                                        <a href="#" style="color: #fff;font-size: 12px;font-weight: bold;padding: 3px 7px;
                                                        text-decoration: none;background-color:#3b5998;display:block;margin-bottom:10px;text-align:center
                                                        ">Facebook</a>
                                                        <a href="#" style="color: #fff;font-size: 12px;font-weight: bold;padding: 3px 7px;
                                                        text-decoration: none;background-color: #1daced;display:block;margin-bottom:10px;text-align:center
                                                        ">Twitter</a>
                                                        <a href="#" style="color: #fff;font-size: 12px;font-weight: bold;padding: 3px 7px;
                                                        text-decoration: none;background-color:#db4a39;display:block;text-align:center">Google+</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table><!-- /column 1 -->

                                        <!-- column 2 -->
                                        <table align="left" style="width:280px;min-width:279px;float:left;">
                                            <tr>
                                                <td style="padding:15px;">
                                                    <h5 class="">Contact Info:</h5>
                                                    <p>Phone: <strong>XXX-XXX-XXXX</strong><br/>
                                                        Email: <strong><a href="emailto:hseldon@trantor.com">info@javul.org</a></strong></p>
                                                </td>
                                            </tr>
                                        </table><!-- /column 2 -->

                                        <span class="clear"></span>

                                    </td>
                                </tr>
                            </table><!-- /social & contact -->

                        </td>
                    </tr>
                </table>
            </div><!-- /content -->

        </td>
        <td></td>
    </tr>
</table><!-- /BODY -->


</body>
</html>