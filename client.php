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
                        <input id="message-color" type="hidden" name="messageColor" value="#000"/>
                        <span>
                            <span>
                                Choose your color:
                            </span>
                            <span>
                                <button class="color-button" style="background: #000" onclick="document.getElementById('message-color').value='#000'; return false;"></button>
                                <button class="color-button" style="background: #1ff" onclick="document.getElementById('message-color').value='#1ff'; return false;"></button>
                                <button class="color-button" style="background: #f00" onclick="document.getElementById('message-color').value='#f00'; return false;"></button>
                                <button class="color-button" style="background: #00f" onclick="document.getElementById('message-color').value='#00f'; return false;"></button>
                                <button class="color-button" style="background: #0f0" onclick="document.getElementById('message-color').value='#0f0'; return false;"></button>
                                <button class="color-button" style="background: #50f" onclick="document.getElementById('message-color').value='#50f'; return false;"></button>
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
