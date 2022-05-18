<?php

/* PRODUCT IMAGE UPLOADS MODEL */

// Add image information to the database table
function storeImages($imgPath, $invId, $imgName) {
    $db = acmeConnect();
    $sql = 'INSERT INTO images (invId, imgPath, imgName) 
            VALUES (:invId, :imgPath, :imgName)';
    $stmt = $db->prepare($sql);
    // Store the full size image information
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->execute();

    // Make and store the thumbnail image information
    $imgPath = makeThumbnailName($imgPath); // Change name in path
    $imgName = makeThumbnailName($imgName); // Change name in file name
    // Store the thumbnail size image information
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->bindValue(':imgPath', $imgPath, PDO::PARAM_STR);
    $stmt->bindValue(':imgName', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

// Get Image Information from images table
function getImages() {
    $db = acmeConnect();
    $sql = 'SELECT imgId, imgPath, imgName, imgDate, inventory.invId, invName 
            FROM images 
            JOIN inventory 
            ON images.invId = inventory.invId';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $imageArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $imageArray;
}

// Delete image information from the images table
function deleteImage($id) {
    $db = acmeConnect();
    $sql = 'DELETE FROM images WHERE imgId = :imgId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':imgId', $id, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->rowCount();
    $stmt->closeCursor();
    return $result;
}

// Check for an existing image
function checkExistingImage($imgName){
    $db = acmeConnect();
    $sql = "SELECT imgName FROM images WHERE imgName = :name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', $imgName, PDO::PARAM_STR);
    $stmt->execute();
    $imageMatch = $stmt->fetch();
    $stmt->closeCursor();
    return $imageMatch;
   }

//Find all thumbnail images for a given product
function getThumbnails($invId){
    $db = acmeConnect();
    $sql = "SELECT imgPath
            FROM images 
            WHERE invId = :invId
            AND imgPath LIKE '%-tn%'";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $thumbnails = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $thumbnails;
}