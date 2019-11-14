<?php
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
include("functions_external.php");
include("selections.php");
include("connect.php");

function htmli($data)
{
         
    switch($_COOKIE["security_level"])
    {
        
        case "0" : 
            
            $data = no_check($data);            
            break;
        
        case "1" :
            
            $data = xss_check_1($data);
            break;
        
        case "2" :            
                       
            $data = xss_check_3($data);            
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

<title>CTF - HTML Injection</title>

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
    
    <h1>HTML Injection LEVEL 1</h1>

    <p>Enter your first and last name:</p>

    <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="GET">

        <p><label for="firstname">First name:</label><br />
        <input type="text" id="firstname" name="firstname"></p>

        <p><label for="lastname">Last name:</label><br />
        <input type="text" id="lastname" name="lastname"></p>

        <button type="submit" name="form" value="submit">Go</button>  

    </form>

    <br />
    <?php

    if(isset($_GET["firstname"]) && isset($_GET["lastname"]))
    {   

        $firstname = $_GET["firstname"];
        $lastname = $_GET["lastname"];    

        if($firstname == "" or $lastname == "")
        {

            echo "<font color=\"red\">Please enter both fields...</font>";       

        }

        else            
        {   
            if($firstname != strip_tags($firstname))
                {
                    echo '<script>alert("<flag>CoNgRaTuLaTiOn<flag>")</script>';
                    $name=$_SESSION["login"];
                    $link->query("INSERT INTO `test1` VALUES('$name','1',now());");
                }
            echo "Welcome " . htmli($firstname) . " " . htmli($lastname);
            header("Location: sqli_3.php");  

        }

    }

    ?>

</div>    

<div id="disclaimer">

    <p>Created By NIHAL ABDULLA and MUHAMMED RAFI</p>

</div>
    
</div>
      
</body>
    
</html>