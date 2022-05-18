<?php

/* IMAGE UPLOADS CONTROLLER */  

session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/connections.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/acme-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/products-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/uploads-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/functions.php';

$action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
if ($action == NULL) {
 $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
}

/* Variables for use with the Image Upload Functionality */

$image_dir = '/acme/images/products'; // directory name where uploaded images are stored

$image_dir_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir; // The path is the full path from the server root

/* Control Structure */

switch ($action) {
    case 'upload':
    
        $invId = filter_input(INPUT_POST, 'invId', FILTER_VALIDATE_INT); // Store the incoming product id

        $imgName = $_FILES['file1']['name'];  // Store the name of the uploaded image
      
        $imageCheck = checkExistingImage($imgName);
      
        if($imageCheck){
            $message = '<p class="notice">An image by that name already exists.</p>';
        } elseif (empty($invId) || empty($imgName)) {
            $message = '<p class="notice">You must select a product and image file for the product.</p>';
        } else {
            $imgPath = uploadFile('file1'); // Upload the image, store the returned path to the file
  
            $result = storeImages($imgPath, $invId, $imgName); // Insert the image information to the database, get the result
      
            if ($result) { // Set a message based on the insert result
                $message = '<p class="notice">The upload succeeded.</p>';
            } else {
                $message = '<p class="notice">Sorry, the upload failed.</p>';
            }
        }
      
        $_SESSION['message'] = $message;  // Store message to session
      
        header('location: .'); // Redirect to this controller for default action
    break;
    
    case 'delete':
        // Get the image name and id
        $filename = filter_input(INPUT_GET, 'filename', FILTER_SANITIZE_STRING);
        $imgId = filter_input(INPUT_GET, 'imgId', FILTER_VALIDATE_INT);
      
        $target = $image_dir_path . '/' . $filename; // Build the full path to the image to be deleted
      
        if (file_exists($target)) { // Check that the file exists in that location
            $result = unlink($target); // Deletes the file in the folder
        }
      
        if ($result) { // Remove from database only if physical file deleted
            $remove = deleteImage($imgId);
        }
      
        if ($remove) { // Set a message based on the delete result
            $message = "<p class='notice'>$filename was successfully deleted.</p>";
        } else {
            $message = "<p class='notice'>$filename was NOT deleted SILLY.</p>";
        }
      
        $_SESSION['message'] = $message; // Store message to session
      
        header('location: .'); // Redirect to this controller for default action
    break;
    
    default:
        $imageArray = getImages(); // Call function to return image info from database
      
        if (count($imageArray)) { // Build the image information into HTML for display
            $imageDisplay = buildImageDisplay($imageArray);
        } else {
            $imageDisplay = '<p class="notice">Sorry, no images could be found.</p>';
        }
      
        $products = getProductBasics(); // Get inventory information from database
        $prodSelect = buildProductsSelect($products); // Build a select list of product information for the view
      
        include '../view/image-admin.php';
        exit;
    break;
}