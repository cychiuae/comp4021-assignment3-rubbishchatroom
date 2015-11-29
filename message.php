<?php

// get the name from cookie
$name = "";
if (isset($_COOKIE["name"])) {
    $name = $_COOKIE["name"];
}

print "<?xml version=\"1.0\" encoding=\"utf-8\"?>";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Message Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript" src="jquery.js"></script>
        <script language="javascript" type="text/javascript">
        //<![CDATA[
        var loadTimer = null;
        var request;
        var datasize;
        var lastMsgID;

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

        function load() {
            //var cookie = getCookie('name');
            var username = getCookie('name');//document.getElementById("username");
            if (username == null) {
                $('#chatbox').css('visibility', 'hidden');
                loadTimer = setTimeout("load()", 100);
                return;
            }
            $('#chatbox').css('visibility', 'visible');
            loadTimer = null;
            datasize = 0;
            lastMsgID = 0;

            getUpdate();
        }

        function unload() {
            console.log('unload');
            var username = document.getElementById("username");
            if (username.value != "") {
                //request = new ActiveXObject("Microsoft.XMLHTTP");
                request =new XMLHttpRequest();
                request.open("POST", "logout.php", true);
                request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                request.send(null);
                username.value = "";
            }
            if (loadTimer != null) {
                loadTimer = null;
                clearTimeout("load()", 100);
            }
        }

        function getUpdate() {
            //request = new ActiveXObject("Microsoft.XMLHTTP");
            request =new XMLHttpRequest();
            request.onreadystatechange = stateChange;
            request.open("POST", "server.php", true);
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("datasize=" + datasize);
        }

        function stateChange() {
            if (request.readyState == 4 && request.status == 200 && request.responseText) {
                var xmlDoc;
                try {
                    xmlDoc =new XMLHttpRequest();
                    xmlDoc.loadXML(request.responseText);
                } catch (e) {
                    var parser = new DOMParser();
                    xmlDoc = parser.parseFromString(request.responseText, "text/xml");
                }
                datasize = request.responseText.length;
                updateChat(xmlDoc);
                getUpdate();
            }
        }

        function updateChat(xmlDoc) {

            //point to the message nodes
            var messages = xmlDoc.getElementsByTagName("message");
            
            // create a string for the messages
            /* Add your code here */
            for (var i = lastMsgID; i < messages.length; i++) {
                showMessage(messages[i].getAttribute('name'), messages[i].innerHTML, messages[i].getAttribute('color'));
            }

            lastMsgID = messages.length;
        }

        function showMessage(nameStr, contentStr, messageColor){

            var urlPattern = /https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/;
            // var urlPattern = /http:\/\/.*?\s?/ig;
            contentStr = contentStr.replace(urlPattern, function(match) {
                return '<a href="' + match + '" target="_blank">' + match + '</a> ';
            });

            var chat = $('#chattext');
            var row = '<tr>';
            row += '<td>' + nameStr + '</td>';
            row += '<td class="content" style="color:' + messageColor + '">' + contentStr + '</td>';
            row += '</tr>';
            chat.append(row);
        }
        
        //]]>
        </script>
        <style>
            #chatroom-header { 
                font-size: 30px;
                font-weight: bold;
                text-align: center;
                color: red;
            }

            #chatbox {
                min-height: 500px;
            }

            #chattext {
                padding-left: 100px;
                font-size: 20px;
                font-weight: bold;
            }

            .content {
                padding-left: 100px;
            }

            #chattext-wrap {
                padding-bottom: 20px;
                min-height: 500px;
            }
        </style>
    </head>

    <body style="text-align: left;" onload="load()" onunload="unload()" onbeforeunload="unload()">
        <div id="chatbox" style="width:100%;">
            <div id="chattext-wrap" style="100%; background:white; border:2px red solid;">
                <h3 id="chatroom-header">Chatroom</h3>
                <table id="chattext"></table>
            </div>
        </div>

        <form action="">
            <input type="hidden" value="<?php print $name; ?>" id="username" />
        </form>

    </body>
</html>
