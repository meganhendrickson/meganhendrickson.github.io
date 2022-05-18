<?php

/* ACCOUNTS CONTROLLER */

// Create or access a Session
session_start();

// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/connections.php';
// Get the acme model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/acme-model.php';
// Get the accounts model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/accounts-model.php';
// Get the accounts model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/reviews-model.php';
// Get the function library for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/functions.php';

$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

switch ($action){
    case 'myAccount':
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/login.php';
        exit;
    break;

    case 'admin':
        $clientId = $_SESSION['clientData']['clientId'];
        $clientReviews = getClientReviews($clientId);
        
        if(count($clientReviews)){
        $clientReviewsDisplay = buildClientReviews($clientReviews);
        }

        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/admin.php';
        exit;
    break;

    case 'login':
        // Filter and store the data & Check for valid email
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $checkEmail = checkEmail($clientEmail);

        // Filter and store the data & Check for valid password
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $checkPassword = checkPassword($clientPassword);
        
        // Check for missing data
        if (empty($checkEmail) || empty($checkPassword)) {
            $message = '<p class="notice">Please provide a valid email address and password.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/login.php';
        exit;
        } 

        // A valid password exists, proceed with the login process
        // Query the client data based on the email address
        $clientData = getClient($clientEmail);
        // Compare the password just submitted against the hashed password for the matching client
        $hashCheck = password_verify($clientPassword, $clientData['clientPassword']);
        // If the hashes don't match create an error and return to the login view
        if(!$hashCheck) {
            $message = '<p class="notice">Please check your password and try again.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/login.php';
            exit;
        } 
        // A valid user exists, log them in
        $_SESSION['loggedin'] = TRUE;
        // Remove the password from the array
        array_pop($clientData);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;

        //delete registration cookie - set expiration to one hour ago
        if($_SESSION['loggedin'] = TRUE){
            unset($_COOKIE['firstname']);
            setcookie('firstname','', strtotime('-1 year'), '/');
        }
        
        $clientId = $_SESSION['clientData']['clientId'];
        $clientReviews = getClientReviews($clientId);
        
        if(count($clientReviews)){
            $clientReviewsDisplay = buildClientReviews($clientReviews);
        }

        // Send them to the admin view
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/admin.php';
        
    break;

    case 'logout':
        $_SESSION = array();
        session_destroy();
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/index.php';
        exit;
    break;       
    
    case 'registration':
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/registration.php';
        exit;
    break;
   
    case 'register':
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        
        // Check for valid email
        $clientEmail = checkEmail($clientEmail);

        // Check that password meets requirements
        $checkPassword = checkPassword($clientPassword);

        // Check for existing email
        $existingEmail = checkExistingEmail($clientEmail);
        if ($existingEmail){
            $message = '<p class="notice">That email address already exists do you want to login instead?</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/login.php';
            exit;
        }

        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || 
        empty($checkPassword)) {
            $message = '<p class="notice">Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/registration.php';
            exit;
        }

        // Hash the checked password
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);

        // Send data to the model
        $regOutcome = regClient($clientFirstname, $clientLastname, $clientEmail, $hashedPassword);

        // Check, set cookie, and report the result
        if ($regOutcome === 1) {
            setcookie('firstname', $clientFirstname, strtotime('+1 year'), '/');
            $message = "<p class='notice'>Thanks for registering $clientFirstname. Please use your email and password to login.</p>";
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/login.php';
            exit;
        } else {
            $message = "<p class='notice'>Sorry, but the registration failed. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/registraton.php';
            exit;
        }
        exit;
    break;

    case 'accountUpdate':
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/client-update.php';
        exit;
    break;

    case 'clientUpdate':
        // Filter and store the data
        $clientFirstname = filter_input(INPUT_POST, 'clientFirstname', FILTER_SANITIZE_STRING);
        $clientLastname = filter_input(INPUT_POST, 'clientLastname', FILTER_SANITIZE_STRING);
        $clientEmail = filter_input(INPUT_POST, 'clientEmail', FILTER_SANITIZE_EMAIL);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);        
        
        // Check for valid email
        $clientEmail = checkEmail($clientEmail);

        // Check for existing email
        if (($_SESSION['clientData']['clientEmail']) != $clientEmail) {
            $existingEmail = checkExistingEmail($clientEmail);
            if ($existingEmail){
                $message = '<p class="notice">That email address already exists do you want to login instead?</p>';
                include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/login.php';
                exit;
            }
        }
        // Check for missing data
        if (empty($clientFirstname) || empty($clientLastname) || empty($clientEmail) || empty($clientId)) {
            $message = '<p class="notice">Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/client-update.php';
            exit;
        }
        
        // Send data to the model
        $updateOutcome = updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId);

        // Query the client data based on the email address
        $clientData = getClientById($clientId);
        // Store the array into the session
        $_SESSION['clientData'] = $clientData;
        
        // Check and report the result
        if ($updateOutcome === 1) {
            $message = "<p class='notice'> Your account has been successfully updated.</p>";
            $_SESSION['message'] = $message;
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/admin.php';
            exit;
        } else {
            $message = "<p class='notice'>Sorry, but the update failed. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/client-update.php';
            exit;
        }
        exit;
    break;

    case 'passwordUpdate':
        $clientPassword = filter_input(INPUT_POST, 'clientPassword', FILTER_SANITIZE_STRING);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        $checkPassword = checkPassword($clientPassword);
        
        if (empty($checkPassword) || empty($clientId)) {
            $message2 = '<p class="notice">Please provide a password that meets all requirements.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/client-update.php';
            exit;
        }
        
        $hashedPassword = password_hash($clientPassword, PASSWORD_DEFAULT);
        
        $updatePassword = updatePassword($hashedPassword, $clientId);
        
        if ($updatePassword === 1) {
            $message2 = "<p class='notice'> Your password has been successfully updated.</p>";
            $_SESSION['message'] = $message2;
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/admin.php';
            exit;
        } else {
            $message2 = "<p class='notice'>Sorry, but the update failed. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/client-update.php';
            exit;
        }
        exit;
    break;


    default:
        $clientId = $_SESSION['clientData']['clientId'];
        $clientReviews = getClientReviews($clientId);
        
        if(count($clientReviews)){
            $clientReviewsDisplay = buildClientReviews($clientReviews);
        }
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/admin.php';
}

