<?php

/* Database Connections */

function acmeConnect(){
    $server = "localhost";
    $database = "acme";
    $user = "iClient";
    $password = "1ti9dkLq4pEoxkh2";
    $dsn = 'mysql:host=' . $server . ';dbname=' . $database;
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

    try{
        $acmeLink = new PDO($dsn, $user, $password, $options);
        //echo '$acmeLink worked successfully<br>';
        return $acmeLink;
    } catch (PDOException $exc) {
        //echo $exc ->getMessage();
        header('location: /acme/view/500.php');
        exit;   
    }
}

//acmeConnect();