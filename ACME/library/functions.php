<?php
// Get the database connection file
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/connections.php';
// Get the acme model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/acme-model.php';
// Get the products model for use as needed
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/products-model.php';

// Get the array of categories
$categories = getCategories();

// Build a navigation bar using the $categories array
function buildNav($categories) {
    $navList = '<ul class="navigation">';
    $navList .= '<li><a href="#" title="Menu" onclick="toggleMenu()">&#9776; Menu</a></li>';
    $navList .= '<li><a href="/acme/" title="View our home page">Home</a></li>';
    foreach ($categories as $category) {
        $navList .= "<li><a href='/acme/products/?action=category&categoryName=".urlencode($category['categoryName'])."' title='View our $category[categoryName] product line'>$category[categoryName]</a></li>";
    }
    $navList .= '</ul>';
    return $navList;
}

// Check for valid email
function checkEmail($clientEmail){
    $valEmail = filter_var($clientEmail, FILTER_VALIDATE_EMAIL);
    return $valEmail;
}

//Check that password meets requirements
function checkPassword($clientPassword){
    //$pattern = '/^(?=.*[[:digit:]])(?=.*[[:punct:]])(?=.*[A-Z])(?=.*[a-z])([^/s]){8,}$/';
    $pattern = '/^(?=.*[\W])(?=[a-zA-Z0-9])[\w\W]{8,}$/i';
    return preg_match ($pattern, $clientPassword);
}

// Build the categories select list 
function buildCategoryList($categories){ 
    $catList = '<select name="categoryId" id="categoryList">'; 
    $catList .= "<option>Choose a Category</option>"; 
    foreach ($categories as $category) { 
        $catList .= "<option value='$category[categoryId]'>$category[categoryName]</option>"; 
    } 
    $catList .= '</select>'; 
    return $catList; 
}

// Build product details display for viewing
function buildProductInfoDisplay($details){
    $info = $details;
    $display = '<div id="product-info">';
    $display .= "<img id='product-img' src='$info[invImage]' alt='Image of our $info[invName] product'>";
    $display .= '<div id="product-desc">';
    $display .= "<h2>$info[invName]</h2>";
    $display .= "<p>$info[invDescription]<p>";
        $display .= '<ul id="product-details">';
        $display .= "<li>A $info[invVendor] product</li>";
        $display .= "<li>Primary material: $info[invStyle]</li>";
        $display .= "<li>Product Weight: $info[invWeight]</li>";
        $display .= "<li>Product Size: $info[invSize] inches (width x length x height)</li>";
        $display .= "<li>Ships from $info[invLocation]</li>";
        $display .= "<li>Number in stock: $info[invStock]</li>";
        $display .= "</ul>";
    $display .= "<h4>$$info[invPrice]</h4>";
    $display .= "</div>";
    $display .= "</div>";
    return $display;
}

// Build thumbnail display for details view
function buildTnDisplay($thumbnails){
    $tndisplay = '<div id="tn-display">';
    $tndisplay .= '<hr>';
    foreach ($thumbnails as $tn) {
        $tndisplay .= "<img src='$tn[imgPath]' alt='Image of our product'>";
    }
    $tndisplay .= '</div>';
    return $tndisplay;
}

/* FUNCTIONS FOR WORKING WITH IMAGES */

// Adds "-tn" designation to file name 
function makeThumbnailName($image) {
    $i = strrpos($image, '.');
    $image_name = substr($image, 0, $i);
    $ext = substr($image, $i);
    $image = $image_name . '-tn' . $ext;
    return $image;
}

// Build images display for image management view
function buildImageDisplay($imageArray) {
    $id = '<ul id="image-display">';
    foreach ($imageArray as $image) {
        $id .= '<li>';
        $id .= "<img src='$image[imgPath]' title='$image[invName] image on Acme.com' alt='$image[invName] image on Acme.com'>";
        $id .= "<p><a href='/acme/uploads?action=delete&imgId=$image[imgId]&filename=$image[imgName]' title='Delete the image'>Delete $image[imgName]</a></p>";
        $id .= '</li>';
    }
    $id .= '</ul>';
    return $id;
}

// Build the products select list
function buildProductsSelect($products) {
    $prodList = '<select name="invId" id="invId">';
    $prodList .= "<option>Choose a Product</option>";
    foreach ($products as $product) {
        $prodList .= "<option value='$product[invId]'>$product[invName]</option>";
    }
    $prodList .= '</select>';
    return $prodList;
}

// Handles the file upload process and returns the path
// The file path is stored into the database
function uploadFile($name) {
    // Gets the paths, full and local directory
    global $image_dir, $image_dir_path;
    if (isset($_FILES[$name])) {
        // Gets the actual file name
        $filename = $_FILES[$name]['name'];
        if (empty($filename)) {
            return;
        }
        // Get the file from the temp folder on the server
        $source = $_FILES[$name]['tmp_name'];
        // Sets the new path - images folder in this directory
        $target = $image_dir_path . '/' . $filename;
        // Moves the file to the target folder
        move_uploaded_file($source, $target);
        // Send file for further processing
        processImage($image_dir_path, $filename);
        // Sets the path for the image for Database storage
        $filepath = $image_dir . '/' . $filename;
        // Returns the path where the file is stored
        return $filepath;
    }
}

// Processes images by getting paths and 
// creating smaller versions of the image
function processImage($dir, $filename) {
    // Set up the variables
    $dir = $dir . '/';
    // Set up the image path
    $image_path = $dir . $filename;
    // Set up the thumbnail image path
    $image_path_tn = $dir.makeThumbnailName($filename);
    // Create a thumbnail image that's a maximum of 200 pixels square
    resizeImage($image_path, $image_path_tn, 200, 200);
    // Resize original to a maximum of 500 pixels square
    resizeImage($image_path, $image_path, 500, 500);
}

// Checks and Resizes image
function resizeImage($old_image_path, $new_image_path, $max_width, $max_height) {
     
    // Get image type
    $image_info = getimagesize($old_image_path);
    $image_type = $image_info[2];
   
    // Set up the function names
    switch ($image_type) {
        case IMAGETYPE_JPEG:
        $image_from_file = 'imagecreatefromjpeg';
        $image_to_file = 'imagejpeg';
        break;
        case IMAGETYPE_GIF:
        $image_from_file = 'imagecreatefromgif';
        $image_to_file = 'imagegif';
        break;
        case IMAGETYPE_PNG:
        $image_from_file = 'imagecreatefrompng';
        $image_to_file = 'imagepng';
        break;
        default:
        return;
    } // ends the switch statement
   
    // Get the old image and its height and width
    $old_image = $image_from_file($old_image_path);
    $old_width = imagesx($old_image);
    $old_height = imagesy($old_image);
   
    // Calculate height and width ratios
    $width_ratio = $old_width / $max_width;
    $height_ratio = $old_height / $max_height;
   
    // If image is larger than specified ratio, create the new image
    if ($width_ratio > 1 || $height_ratio > 1) {
   
        // Calculate height and width for the new image
        $ratio = max($width_ratio, $height_ratio);
        $new_height = round($old_height / $ratio);
        $new_width = round($old_width / $ratio);
    
        // Create the new image
        $new_image = imagecreatetruecolor($new_width, $new_height);
   
        // Set transparency according to image type
        if ($image_type == IMAGETYPE_GIF) {
            $alpha = imagecolorallocatealpha($new_image, 0, 0, 0, 127);
            imagecolortransparent($new_image, $alpha);
        }
   
        if ($image_type == IMAGETYPE_PNG || $image_type == IMAGETYPE_GIF) {
            imagealphablending($new_image, false);
            imagesavealpha($new_image, true);
        }
   
        // Copy old image to new image - this resizes the image
        $new_x = 0;
        $new_y = 0;
        $old_x = 0;
        $old_y = 0;
        imagecopyresampled($new_image, $old_image, $new_x, $new_y, $old_x, $old_y, $new_width, $new_height, $old_width, $old_height);
    
        // Write the new image to a new file
        $image_to_file($new_image, $new_image_path);
        // Free any memory associated with the new image
        imagedestroy($new_image);
    } else {
        // Write the old image to a new file
        $image_to_file($old_image, $new_image_path);
    } //ends the width-height ratio if-else statement
    
    // Free any memory associated with the old image
    imagedestroy($old_image);
} //ends the resize function

/* FUNCTIONS FOR DISPLAYING REVIEWS */

// build add a new review form
function buildReviewForm($invId, $clientId, $screenName){
    $addReviewForm = '<form action="/ACME/reviews/" method="post" enctype="multipart/form-data">';
    $addReviewForm .="<label>Screen Name:</label><br>";
    $addReviewForm .="<input readonly type='text' name='screenName' placeholder='$screenName'><br>";
    $addReviewForm .="<input type='hidden' name='invId' value='$invId'>";
    $addReviewForm .="<input type='hidden' name='clientId' value='$clientId'>";
    $addReviewForm .="<label>Review:</label><br>";
    $addReviewForm .='<input required type="text" name="reviewText" id="reviewText"/><br>';
    $addReviewForm .='<input type="submit" class="button" name="submit" value="Submit"/>';
    $addReviewForm .='<input type="hidden" name="action" value="add-review"/>';
    $addReviewForm .='</form>';
    return $addReviewForm;
}

// build reviews display for product
function productReviewsDisplay($productReviews){
    $prd = '<div id="prodreviews">';
    foreach ($productReviews as $review) {
        // build reviewers screen name
        $rFirstName = $review['clientFirstname'];
        $rLastName = $review['clientLastname'];
        $rScreenName = $rFirstName[0] . $rLastName;
        // build display date
        $reviewDate = $review['reviewDate'];
        $timestamp = strtotime($reviewDate);
        $displayDate = date("F j, Y", $timestamp);
        // continue building product reviews display
        $prd .= "<p class='rdata'><span class='bold'>$rScreenName</span>wrote on $displayDate: </p>";
        $prd .= "<p class ='reviewtext'>$review[reviewText]</p>";
        $prd .= '<hr>';
    }
    $prd .= '</div>';
    return $prd;
   } 

// build reviews display for client
function buildClientReviews($clientReviews){ 
    $crd = "<table id='clientreviews'>";
    foreach ($clientReviews as $review){
        $reviewDate = $review['reviewDate'];
        $timestamp = strtotime($reviewDate);
        $displayDate = date("F j, Y", $timestamp);
        $reviewId = $review['reviewId'];
        $crd .= "<tr>";
        $crd .= "<td>$review[invName]</td>";
        $crd .= "<td>written on $displayDate</td>";
        $crd .= "<td><a href='/acme/reviews?action=edit-review&id=$reviewId' title='Click to modify'>Modify</a></td>";
        $crd .= "<td><a href='/acme/reviews?action=delete-review&id=$reviewId' title='Click to Delete'>Delete</a></td>";
        $crd .= "</tr>";
    }
    $crd .= "</table>";
    return $crd;

}
