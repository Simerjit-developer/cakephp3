<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Supperout</title>
    </head>

    <body style="background:url(<?php echo "http://" . $_SERVER['SERVER_NAME'].$this->request->getAttribute('webroot'); ?>files/emails/back.jpg) repeat #dddddd;background-size:160px">
        <div style="width: 560px;padding:15px 0;background:url(<?php echo "http://" . $_SERVER['SERVER_NAME'].$this->request->getAttribute('webroot'); ?>files/emails/back.jpg) repeat #dddddd;margin:0px auto;font-weight:400;background-size:160px">
            <table width="560" border="0" cellpadding="10" cellspacing="0" style="margin:0px auto;background:#fffefb;text-align:center;border-radius: 5px;overflow: hidden;box-shadow: 0 0 10px #bfbfbf;">
                <tbody>
                    <tr style="background:#fff">
                        <td style="text-align:center;padding-top:20px;padding-bottom:20px;border-bottom:2px solid #FF6D59;background-image: url(bg-splash.png);background-size: cover;background-repeat: no-repeat;background-position: center;">
                            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'].$this->request->getAttribute('webroot'); ?>files/emails/logo.png" alt="img" class="CToWUd"/>
                        </td>
                    </tr>
                    <tr>
                        <td align="center">
                            <!--<h2 style="text-align:center;font-weight:500;margin-bottom:1px;font-size:18px">By: <?php //echo " ".$subject ?>,</h2>-->
                            <p style="color:#000;font-weight:500">Restaurant Name:<?php echo " ".$restaurant_name; ?></p>
                            <p style="color:#000;font-weight:500">Location:<?php echo " ".$email; ?></p>
                            <p style="color:#000;font-weight:500">Content:<?php echo " ".$message; ?></p>
                            
                        </td>
                    </tr>
                    <tr>
                        <td align="center"  style="border-top: 1px solid #ececec;">
                            <p style="color:#000;font-weight:500">Thank You,<br><b>Supper Out</b> </p>
                            <span class="HOEnZb"><font color="#888888"> </font></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>

