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
                            <h3>Hi Admin,</h3>
                            <p>Visited URL: <a href="{{$url}}">{{$url}}</a></p>
                            <p>Message:{{$messages}}</p>
                            <p>Submitted by: {{$name}}</p>
                            <p><i>Submitted through "Report a concern" webform.</i></p>
                            <p>Regards,</p>
                            <p>info@javul.org</p>
                            <!-- social & contact -->
                            <table width="100%" style="background-color:#ebebeb;margin-top: 20px;">
                                <tr>
                                    <td>
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