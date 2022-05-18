<?php

/* ACCOUNTS MODEL */

// Insert site visitor data to database
function regClient($clientFirstname, $clientLastname, $clientEmail, $clientPassword){
    $db = acmeConnect();

    // The SQL statement to be used with the Database
    $sql = 'INSERT INTO clients (clientFirstname, clientLastname, clientEmail, clientPassword)
    VALUES (:firstname, :lastname, :email, :password)';   

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // The next four lines replace the placeholder in the SQL statement with the actual values
    // in the variables and tells the database the type of data it is
    $stmt->bindValue(':firstname', $clientFirstname, PDO:: PARAM_STR);
    $stmt->bindValue(':lastname', $clientLastname, PDO:: PARAM_STR);
    $stmt->bindValue(':email', $clientEmail, PDO:: PARAM_STR);
    $stmt->bindValue(':password', $clientPassword, PDO:: PARAM_STR); 

    // Use the prepared statement to insert the data
    $stmt->execute();

    // Now we find out if the insert worked by asking how many rows changed in the table
    $rowsChanged = $stmt->rowCount();

    //Close the databse interaction
    $stmt->closeCursor();

    // Return the indication of success
    return $rowsChanged;
}


// Check for an existing email address
function checkExistingEmail($clientEmail) {
    $db = acmeConnect();
    $sql = 'SELECT clientEmail FROM clients WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindVAlue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $matchEmail = $stmt->fetch(PDO::FETCH_NUM);
    $stmt->closeCursor();
    if (empty($matchEmail)) {
       return 0;
       //echo 'Nothing found';
       //exit;
    } else {
       return 1;
       //echo 'Match found';
       //exit;
    }
}

// Get client data based on an email address
function getClient($clientEmail){
    $db = acmeConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients
            WHERE clientEmail = :email';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':email', $clientEmail, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
   }

// Update client account information
function updateClient($clientFirstname, $clientLastname, $clientEmail, $clientId){
    $db = acmeConnect();

    // The SQL statement to be used with the Database
    $sql = 'UPDATE clients 
            SET
            clientFirstname = :clientFirstname,
            clientLastname = :clientLastname,
            clientEmail = :clientEmail
            WHERE clientId = :clientId';    

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // The next four lines replace the placeholder in the SQL statement with the actual values
    // in the variables and tells the database the type of data it is
    $stmt->bindValue(':clientFirstname', $clientFirstname, PDO:: PARAM_STR);
    $stmt->bindValue(':clientLastname', $clientLastname, PDO:: PARAM_STR);
    $stmt->bindValue(':clientEmail', $clientEmail, PDO:: PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO:: PARAM_STR); 

    // Use the prepared statement to insert the data
    $stmt->execute();

    // Now we find out if the insert worked by asking how many rows changed in the table
    $rowsChanged = $stmt->rowCount();

    //Close the databse interaction
    $stmt->closeCursor();

    // Return the indication of success
    return $rowsChanged;
}

function getClientById($clientId){
    $db = acmeConnect();
    $sql = 'SELECT clientId, clientFirstname, clientLastname, clientEmail, clientLevel, clientPassword 
            FROM clients
            WHERE clientId = :clientId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_STR);
    $stmt->execute();
    $clientData = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $clientData;
   }

function updatePassword($clientPassword, $clientId){
    $db = acmeConnect();

    // The SQL statement to be used with the Database
    $sql = 'UPDATE clients 
            SET
            clientPassword = :clientPassword
            WHERE clientId = :clientId';    

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // The next four lines replace the placeholder in the SQL statement with the actual values
    // in the variables and tells the database the type of data it is
    $stmt->bindValue(':clientPassword', $clientPassword, PDO:: PARAM_STR);
    $stmt->bindValue(':clientId', $clientId, PDO:: PARAM_STR); 

    // Use the prepared statement to insert the data
    $stmt->execute();

    // Now we find out if the insert worked by asking how many rows changed in the table
    $rowsChanged = $stmt->rowCount();

    //Close the databse interaction
    $stmt->closeCursor();

    // Return the indication of success
    return $rowsChanged;
}

