<?php
echo '<script>alert("<flag>CoNgRaTuLaTiOnS-COMPLETED-LEVEL-3<flag>")</script>';
//session_start();
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
include("admin/settings.php");
include("connect.php");

$bugs = file("bugs.txt");

if(isset($_POST["form_bug"]) && isset($_POST["bug"]))
{
        
            $key = $_POST["bug"]; 
            $bug = explode(",", trim($bugs[$key]));
            
            // Debugging
            // print_r($bug);
            
            header("Location: " . $bug[1]);
            
            exit;

}
 
if(isset($_POST["form_security_level"]) && isset($_POST["security_level"]))    
{
    
    $security_level_cookie = $_POST["security_level"];
    
    switch($security_level_cookie)
    {

        case "0" :

            $security_level_cookie = "0";
            break;

        case "1" :

            $security_level_cookie = "1";
            break;

        case "2" :

            $security_level_cookie = "2";
            break;

        default : 

            $security_level_cookie = "0";
            break;

    }

    if($evil_bee == 1)
    {

        setcookie("security_level", "666", time()+60*60*24*365, "/", "", false, false);

    }
    
    else        
    {
      
        setcookie("security_level", $security_level_cookie, time()+60*60*24*365, "/", "", false, false);
        
    }

    header("Location: directory_traversal_2.php?directory=documents");
    
    exit;

}

if(isset($_COOKIE["security_level"]))
{

    switch($_COOKIE["security_level"])
    {
        
        case "0" :
            
            $security_level = "low";
            break;
        
        case "1" :
            
            $security_level = "medium";
            break;
        
        case "2" :
            
            $security_level = "high";
            break;
        
        case "666" :

            $security_level = "666";
            break;
        
        default : 
            
            $security_level = "low";
            break;

    }
    
}

else
{
     
    $security_level = "not set";
    
}

$directory = "";
$directory_traversal_error = "";  

function show_directory($directory,$link)
{
    $check='____GET-INSIDE____';
    // Checks whether a file or directory exists    
    if(file_exists($directory))
    {
    
        $dp = opendir($directory);
       
        while($line = readdir($dp))
        {
        
            if($line != "." && $line != ".." && $line != ".htaccess")
            {
            
                echo "<a href=\"" . $directory . "/" . $line . "\" target=\"_blank\">" . $line . "</a><br />";
                //print_r($directory);
            
            }
        
        }
        
        if (strpos($directory,$check) !== false)
            { 
                $name=$_SESSION["login"];
                $link->query("INSERT INTO `test1` VALUES('$name','4',now());");
                header("Location: directory_traversal_1.php?page=message.txt");
            }
    }
    
    else
    {
        
        echo "This directory doesn't exist!";
       
    }
     
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

<title>CTF</title>

</head>

<body>
    
<header>

<h1>CTF</h1>

<h2>an extremely buggy web app !</h2>

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
    
    <h1>Directory Traversal - Directories LEVEL 4</h1>

    <?php

    if(isset($_GET["directory"]))
    {

        $directory = $_GET["directory"];

        switch($_COOKIE["security_level"])
            {

            case "0" :            

                show_directory($directory,$link);

                // echo "<br />" . $_GET['page'];

                break;

            case "1" :         

                $directory_traversal_error = directory_traversal_check_2($directory);

                if(!$directory_traversal_error)
                {

                    show_directory($directory,$link);

                }

                else
                {

                    echo $directory_traversal_error;

                }           

                break;

            case "2" :

                $directory_traversal_error = directory_traversal_check_3($directory, $base_path = "./documents");           

                if(!$directory_traversal_error)
                {

                    show_directory($directory,$link);

                }

                else
                {

                    echo $directory_traversal_error;

                }           

                break;

            default :           

                show_directory($directory,$link);

                break;

        }

    }

    ?>


</div>     
    
<div id="disclaimer">
          
    <p>Created By NIHAL ABDULLA and MUHAMMED RAFI</p>
   
</div>
      
</body>
    
</html>