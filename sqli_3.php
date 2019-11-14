<?php
echo "<script>alert('<flag>CoNgRaTuLaTiOnSCOMPLETED-LEVEL-1<flag>')</script>";
//session_start();
//print_r($_SESSION);
/*

bWAPP, or a buggy web application, is a free and open source deliberately insecure web application.
It helps security enthusiasts, developers and students to discover and to prevent web vulnerabilities.
bWAPP covers all major known web vulnerabilities, including all risks from the OWASP Top 10 project!
It is for security-testing and educational purposes only.

Enjoy!

Malik Mesellem
Twitter: @MME_IT

bWAPP is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License (http://creativecommons.org/licenses/by-nc-nd/4.0/). Copyright © 2014 MME BVBA. All rights reserved.

*/

include("security.php");
include("security_level_check.php");
include("selections.php");
include("functions_external.php");
include("connect.php");
//include("login.php");

$message = "";

function sqli($data)
{

    switch($_COOKIE["security_level"])
    {

        case "0" :

            $data = no_check($data);
            break;

        case "1" :

            $data = sqli_check_1($data);
            break;

        case "2" :

            $data = sqli_check_2($data);
            break;

        default :

            $data = no_check($data);
            break;

    }

    return $data;

}

?>
<!DOCTYPE html>
<html>

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<!--<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Architects+Daughter">-->
<link rel="stylesheet" type="text/css" href="stylesheets/stylesheet.css" media="screen" />
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />

<!--<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>-->
<script src="js/html5.js"></script>

<title>CTF - SQL Injection</title>

</head>

<body>

<header>

<h1>CTF</h1>

<h2>Bug Bounty!</h2>

</header>

<div id="menu">

    <table>

        <tr>

            <td><a href="password_change.php">Change Password</a></td>
            <td><font color="red">Welcome <?php if(isset($_SESSION["login"])){echo ucwords($_SESSION["login"]);}?></font></td>

        </tr>

    </table>

</div>

<div id="main">

    <h1>SQL Injection (GET-INSIDE) LEVEL 2</h1>

    <p>Enter as <b>'admin'</b>.</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST">

        <p><label for="login">Login:</label><br />
        <input type="text" id="login" name="login" size="20" autocomplete="off" /></p>

        <p><label for="password">Password:</label><br />
        <input type="password" id="password" name="password" size="20" autocomplete="off" /></p>

        <button type="submit" name="form" value="submit">Login</button>

    </form>

    <br />
<?php

    if(isset($_POST["form"]))
    {
       

        $login = $_POST["login"];
        $login = sqli($login);

        $password = $_POST["password"];
        $password = sqli($password);

        $sql = "SELECT * FROM heroes WHERE login = '" . $login . "' AND password = '" . $password . "'";

        // echo $sql;

        $recordset = mysqli_query($link,$sql);

        if(!$recordset)
        {

            die("Error: " . mysql_error());

        }

        else
        {

            $row = mysqli_fetch_array($recordset);

            if($row["login"])
            {
                
                // $message = "<font color=\"green\">Welcome " . ucwords($row["login"]) . "...</font>";
                $message =  "<p>Welcome <b>" . ucwords($row["login"]) . "</b>, how are you today?</p><p>Your secret: <b>" . ucwords($row["secret"]) . "</b></p>";
                // $message = $row["login"];
                $name=$_SESSION["login"];
                //print_r($name);
                //$name=$link->query("")s
                $link->query("INSERT INTO `test1` VALUES('$name','2',now());");
                //sleep(10);
                header("Location: xss_get.php");
            }

            else
            {

                $message = "<font color=\"red\">Invalid credentials!</font>";

            }

        }

        mysqli_close($link);

    }

    echo $message;

?>

</div>

<div id="disclaimer">

    <p>Created By NIHAL ABDULLA and MUHAMMED RAFI</p>

</div>

</body>

</html>