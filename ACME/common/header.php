<!DOCTYPE html>
<html lang="en">

    <head>
        <title>ACME, Inc.</title>  
        <!-- META INFO -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="Commission Information and Pricing">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS LINK --> 
        <link rel="stylesheet" href="/acme/css/main.css">
    </head>

    <body>
        <header>
        <div class="accountmenu">
        <?php 
                // Check if the firstname cookie exists, get its value
                if(isset($_COOKIE['firstname'])){
                    $cookieFirstname = filter_input(INPUT_COOKIE, 'firstname', FILTER_SANITIZE_STRING);
                }
                //if cookie exists display welcome message -- cookie is created only at new registtration
                //elseif loggedin display hello message -- only shown if logged in and no cookie exists
                if(isset($cookieFirstname) && !empty($_SESSION['loggedin'])){
                    echo "<span><a href='http://localhost/acme/accounts/?action=admin'>Welcome $cookieFirstname!</a></span>";
                }elseif(!empty($_SESSION['loggedin'])) {
                    echo "<span><a href='http://localhost/acme/accounts/?action=admin'>Hello ", $_SESSION['clientData']['clientFirstname'], "!</a></span>";
                }
                //if session is not logged in show myAccount link
                //if session is logged in show logout link
                if(empty($_SESSION['loggedin'])) {
                    echo '<a href="http://localhost/acme/accounts/index.php"><img src="http://localhost/acme/images/site/account.gif" alt="account icon" id="accounticon"/> My Account</a>';
                } elseif($_SESSION['loggedin'] == TRUE) {
                    echo '<a href="http://localhost/acme/accounts/?action=logout">Log Out</a>';
                } 
            ?>
        </div>

        <div class ="logo">
            <a href="http://localhost/acme"><img src="http://localhost/acme/images/site/logo.gif" alt="acme logo" id="logo"/></a>
        </div>
        </header>
        <!-- NAVIGATION -->
        <nav>
        <?php
        // Get the common functions
        require_once $_SERVER['DOCUMENT_ROOT'].'/acme/library/functions.php';

        $navList = buildNav($categories);
        echo $navList;
        ?>
        </nav>
        <main>
