<?php

/* REVIEWS MODEL */

//insert a new review
function addReview($reviewText, $invId, $clientId) {
    $db = acmeConnect();
   // The SQL statement to be used with the Database
   $sql = 'INSERT INTO reviews (reviewText, invId, clientId)
            VALUES (:reviewtext, :invid, :clientid)';   
   $stmt = $db->prepare($sql);
    //bind value statements
   $stmt->bindValue(':reviewtext', $reviewText, PDO:: PARAM_STR);
   $stmt->bindValue(':invid', $invId, PDO:: PARAM_INT);
   $stmt->bindValue(':clientid', $clientId, PDO:: PARAM_INT);

   // Use the prepared statement to insert the data
   $stmt->execute();
   $rowsChanged = $stmt->rowCount();
   $stmt->closeCursor();
   return $rowsChanged;
}

// get reviews for inventory item
function getProductReviews($invId) {
    $db = acmeConnect();
    $sql = 'SELECT reviewText, reviewDate, invId, reviews.clientId, 
                clients.clientFirstname, clients.clientLastname 
            FROM reviews 
            JOIN clients 
            ON reviews.clientId = clients.clientId 
            WHERE invId = :invId
            ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $productReviews = $stmt->fetchAll();
    $stmt->closeCursor();
    return $productReviews;
}

//get reviews for client
function getClientReviews($clientId) {
    $db = acmeConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, reviews.invId, inventory.invName 
            FROM reviews 
            JOIN inventory
            ON reviews.invId = inventory.invId
            WHERE clientId = :clientId
            ORDER BY reviewDate DESC';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':clientId', $clientId, PDO::PARAM_INT);
    $stmt->execute();
    $clientReviews = $stmt->fetchAll();
    $stmt->closeCursor();
    return $clientReviews;
}

//get single review info
function getReviewInfo($reviewId){
    $db = acmeConnect();
    $sql = 'SELECT reviewId, reviewText, reviewDate, reviews.invId, inventory.invName 
            FROM reviews 
            JOIN inventory
            ON reviews.invId = inventory.invId
            WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
   }

//update a review
function updateReview($reviewId, $reviewText){
    $db = acmeConnect();
    // The SQL statement to be used with the Database
    $sql = 'UPDATE reviews
            SET reviewText = :reviewText 
            WHERE reviewId = :reviewId'; 
    $stmt = $db->prepare($sql);
    // binding statements
    $stmt->bindValue(':reviewText', $reviewText, PDO:: PARAM_STR);
    $stmt->bindValue(':reviewId', $reviewId, PDO:: PARAM_INT); 
    // Use the prepared statement to update the data
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//delete a review
function deleteReview($reviewId) {
    $db = acmeConnect();
    $sql = 'DELETE FROM reviews WHERE reviewId = :reviewId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':reviewId', $reviewId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}