<?php
// if name is not in the post data, exit
session_start();

if (isset($_SESSION['name']) && !empty($_SESSION['name'])) {
	header("Location: client.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!isset($_POST["name"])) {
	    header("Location: error.html");
	    exit;
	}

	$username = $_POST['name'];
	
	if (isset($_FILES['profile_picture'])) {
		$allowed_types = array(
            'gif',
            'png',
            'jpeg',
            'jpg'
        );
        $extension = end(explode('.', $_FILES['profile_picture']['name']));
        if ((($_FILES['profile_picture']['type'] == "image/gif") || ($_FILES['profile_picture']['type'] == "image/jpeg") || ($_FILES['profile_picture']['type'] == "image/png"))) {

        	$image_location = 'image/' . $username . '.' .$extension;
        	
        	if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $image_location)) {
        		header("Location: error.html");
        		echo '1';
        	}

        } else {
        	header("Location: error.html");
			exit;
        }
	} else {
		header("Location: error.html");
		exit;
	}



	require_once('xmlHandler.php');

	// create the chatroom xml file handler
	$xmlh = new xmlHandler("chatroom.xml");
	if (!$xmlh->fileExist()) {
	    header("Location: error.html");
	    exit;
	}

	// open the existing XML file
	$xmlh->openFile();

	// get the 'users' element
	$users_element = $xmlh->getElement("users");

	// create a 'user' element
	$user_element = $xmlh->addElement($users_element, "user");

	// add the user name
	$xmlh->setAttribute($user_element, "name", $_POST["name"]);

    $xmlh->setAttribute($user_element, "picture", $image_location);    

	// save the XML file
	$xmlh->saveFile();

	// set the name to the cookie
	setcookie("name", $_POST["name"]);
	$_SESSION['name'] = $_POST["name"];
    setcookie("msgColor", null, time() - 3600);
	// Cookie done, redirect to client.php (to avoid reloading of page from the client)
	header("Location: client.php");
}

?>

<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="style.css" />
        <script type="text/javascript">
        //<![CDATA[
        function clearMessage() {
            try {
                var name = window.parent.frames["message"].document.getElementById("username");
                if (name != "") {
                    window.parent.frames["message"].location.reload();
                }
            } catch (e) { }
        }
        
        //username input checking
       function checkInput() {
            //username cannot be empty
            var name = document.getElementById('name').value;
            if (name == '') {
                alert('Please enter a name!');
                return false;
            }


            //username cannot contain illeagl character
           if (name.match(/[\<\>!@#\$%^&\*,\"\'\[\]\{\}\-\+\=\b:;\/\.]+/i)) {
                alert('Invalid user name!\nPlease don\'t use space and the following character. \"\':;<>()[]{}!@#$%^&*-+=');
                return false;
           }
        }
        
        </script>
    </head>

    <body onload="clearMessage()">
        <form method="post" action="login.php" onsubmit="javascript:return checkInput()" enctype="multipart/form-data">
            <table border="0" cellpadding="5" cellspacing="0">
                <tr>
                    <td>Please enter your user name:</td>
                    <td><input class="text" name="name" id="name" type="text" size="20" maxlength="10" /></td>
                </tr>
                <tr>
                    <td>Please upload a picture:</td>
                    <td>
                        <input type="file" name="profile_picture" accept="image/*" />
                    </td>
                </tr>
                <tr align="center">
                    <td colspan="2"><input class="button" type="submit" value="Go!" style="width: 150px" /></td>
                </tr>
            </table>
        </form>
    </body>
</html>
