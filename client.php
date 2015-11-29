<?php

session_start();

if (!isset($_COOKIE["name"])) {
    header("Location: error.html");
    return;
}

// get the name from cookie
$name = $_COOKIE["name"];

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript">
        //<![CDATA[
        function load() {
            var name = "<?php print $name; ?>";
            //window.parent.frames["message"].document.getElementById("username").setAttribute("value", name)
            setTimeout("document.getElementById('msg').focus()",100);
        }

        function popitup(url) {
            newwindow=window.open(url,'name','height=820,width=820');
            if (window.focus) {
                newwindow.focus()
            }
            return false;
        }

        function setSendColor(color) {
            document.getElementById('message-color').value = color;
            setCookie('msgColor', color);
        }

        function setCookie(name, value, expires, path, domain, secure) {
            var curCookie = name + "=" + escape(value) +
                ((expires) ? "; expires=" + expires.toGMTString() : "") +
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                ((secure) ? "; secure" : "");
            document.cookie = curCookie;
        }


        //
        // Get a cookie
        //
        function getCookie(name) {
            var dc = document.cookie;
            var prefix = name + "=";
            var begin = dc.indexOf("; " + prefix);
            if (begin == -1) {
                begin = dc.indexOf(prefix);
                if (begin != 0) return null;
            } else
                begin += 2;
            var end = document.cookie.indexOf(";", begin);
            if (end == -1)
                end = dc.length;
            return unescape(dc.substring(begin + prefix.length, end));
        }


        //
        // Delete a cookie
        //
        function deleteCookie(name, path, domain) {
            if (get_cookie(name)) {
                document.cookie = name + "=" + 
                ((path) ? "; path=" + path : "") +
                ((domain) ? "; domain=" + domain : "") +
                "; expires=Thu, 01-Jan-70 00:00:01 GMT";
            }
        }
        //]]>
        </script>
    </head>

    <body style="text-align: left" onload="load()">
        <form action="add_message.php" method="post">
            <table border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <td>What is your message?</td>
                </tr>
                <tr>
                    <td><input class="text" type="text" name="message" id="msg" style= "width: 780px" /></td>
                </tr>
                <tr>
                    <td>
                        <input class="button" type="submit" value="Send Your Message" style="width: 200px" />
                        <input id="message-color" type="hidden" name="messageColor" value="<?php echo isset($_COOKIE['msgColor']) ? $_COOKIE['msgColor'] : '#000' ?>"/>
                        <span>
                            <span>
                                Choose your color:
                            </span>
                            <span>
                                <button class="color-button" style="background: #000" onclick="setSendColor('#000');return false;"></button>
                                <button class="color-button" style="background: #1ff" onclick="setSendColor('#1ff');return false;"></button>
                                <button class="color-button" style="background: #f00" onclick="setSendColor('#f00');return false;"></button>
                                <button class="color-button" style="background: #00f" onclick="setSendColor('#00f');return false;"></button>
                                <button class="color-button" style="background: #0f0" onclick="setSendColor('#0f0');return false;"></button>
                                <button class="color-button" style="background: #50f" onclick="setSendColor('#50f');return false;"></button>
                            </span>
                        </span>
                    </td>
                </tr>
            </table>
        </form>
        <hr />
        <!--logout button-->
        <form action="logout.php" method="post">
            <button class="button" style="margin-left: 5px;width: 200px" onclick="popitup('onlineuser.html'); return false;">Show Online Users List</button>
            <button class="button" style="width: 200px">Logout</button>
        </form>
    </body>
</html>
