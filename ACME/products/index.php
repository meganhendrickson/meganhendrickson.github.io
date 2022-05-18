<?php

/* PRODUCTS CONTROLLER */

// Create or access a Session
session_start();

require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/connections.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/acme-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/products-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/uploads-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/reviews-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/functions.php';

//Drop down select list using $categories array
$catList = '<select name="category">';
foreach ($categories as $category){
    $catList .= '<option value="'.$category["categoryId"].'">'.$category["categoryName"].'</option>';
}
$catList .= '</select>';

//Action cases
$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

switch ($action){
    case 'products': //go to product management view
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/prod-mgmt.php';
        exit;
    break;
    
    case 'new-cat': //go to new category view
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/new-cat.php';
        exit;
    break;   

    case 'add-cat': //add a new category
        // Filter and store the data
        $categoryName = filter_input(INPUT_POST, 'categoryName');
        
        // Check for missing data
        if (empty($categoryName)){
            $message = '<p class="notice"> Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/new-cat.php';
            exit;
        }
        
        //send the data to the model
        $catOutcome = addCategory($categoryName);
       
        //check and report the outcome
        if($catOutcome === 1){
            $message = '<p class="notice">The category has been sucessfully added.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/prod-mgmt.php';
            exit;
        } else {
            $message = '<p class="notice">Failed to add category. Please try again.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/prod-mgmt.php';
            exit;
        }
        
    break;

    case 'new-prod': //go to new category view
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/new-prod.php';   
        exit;
    break;

    case 'add-prod':
        // Filter and store the data
        $categoryId = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        
        // Check for missing data
        if(empty($categoryId) || empty($invName) || empty($invDescription) || empty($invImage) 
            || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) 
            || empty($invWeight) || empty($invLocation) || empty($invVendor) || empty($invStyle)) {
            $message = '<p class="notice"> Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/new-prod.php';
            exit;
        } 
        
        // Send the data to the database
        $invOutcome = addInventory($invName, $invDescription, $invImage, $invThumbnail, $invPrice, 
            $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle);

        // Check and report the result
        if($invOutcome === 1){
            $message = "<p class='notice'>$invName was sucessfully added.</p>";
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/new-prod.php';
            exit;
        } else {
            $message = '<p class="notice">Failed to add product. Please try again.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/new-prod.php';
            exit;
        }

    break;
    
    /* Get Inventory Items by categoryId - Used for starting Update & delete process */ 
    case 'getInventoryItems': 
        // Get the categoryId 
        $categoryId = filter_input(INPUT_GET, 'categoryId', FILTER_SANITIZE_NUMBER_INT); 
        // Fetch the products by categoryId from the DB 
        $productsArray = getProductsByCategory($categoryId); 
        // Convert the array to a JSON object and send it back 
        echo json_encode($productsArray); 
    break;

    case 'mod':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);
        if(count($prodInfo)<1){
         $message = 'Sorry, no product information could be found.';
        }
        include '../view/prod-update.php';
        exit;
    break;

    case 'updateProd':
        // Filter and store the data
        $categoryId = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invDescription = filter_input(INPUT_POST, 'invDescription', FILTER_SANITIZE_STRING);
        $invImage = filter_input(INPUT_POST, 'invImage', FILTER_SANITIZE_STRING);
        $invThumbnail = filter_input(INPUT_POST, 'invThumbnail', FILTER_SANITIZE_STRING);
        $invPrice = filter_input(INPUT_POST, 'invPrice', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invStock = filter_input(INPUT_POST, 'invStock', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invSize = filter_input(INPUT_POST, 'invSize', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invWeight = filter_input(INPUT_POST, 'invWeight', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $invLocation = filter_input(INPUT_POST, 'invLocation', FILTER_SANITIZE_STRING);
        $invVendor = filter_input(INPUT_POST, 'invVendor', FILTER_SANITIZE_STRING);
        $invStyle = filter_input(INPUT_POST, 'invStyle', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        
        // Check for missing data
        if(empty($categoryId) || empty($invName) || empty($invDescription) || empty($invImage) 
            || empty($invThumbnail) || empty($invPrice) || empty($invStock) || empty($invSize) 
            || empty($invWeight) || empty($invLocation) || empty($invVendor) || empty($invStyle)) {
            $message = '<p class="notice"> Please provide information for all empty form fields.</p>';
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/prod-update.php';
            exit;
        } 
        
        // Send the data to the database
        $updateResult = updateProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, 
            $invStock, $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle, $invId);

        // Check and report the result
        if($updateResult){
            $message = "<p class='notice'> $invName was successfully updated.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/products/');
            exit;
        } else {
            $message = "<p class='notice'>Failed to update $invName. Please try again.</p>";
            include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/prod-update.php';
            exit;
        }

    break;
    
    case 'del':
        $invId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $prodInfo = getProductInfo($invId);

        if (count($prodInfo) < 1) {
            $message = 'Sorry, no product information could be found.';
        }

        include '../view/prod-delete.php';
        exit;
        break;

    case 'deleteProd':
        $invName = filter_input(INPUT_POST, 'invName', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $deleteResult = deleteProduct($invId);
        if ($deleteResult) {
            $message = "<p class='notice'>Congratulations, $invName was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/products/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invName was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/products/');
            exit;
        }
    break;

    case 'category':
        $categoryName = filter_input(INPUT_GET, 'categoryName', FILTER_SANITIZE_STRING);
        $products = getProductsByCategoryName($categoryName);
        if(!count($products)){
            $_SESSION['message'] = "<p class='notice'>Sorry, no $categoryName products could be found.</p>";
        } else {
            $prodDisplay = buildProductsDisplay($products);
        }
        include '../view/category.php';
    break;

    case 'details':
        //store all the necessary data
        $invId = filter_input(INPUT_GET, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $details = getProductInfo($invId);
        $thumbnails = getThumbnails($invId);       
        $productReviews = getProductReviews($invId);
                
        //if there are details, build display (or error message)
        if(empty($details)){
            $_SESSION['message'] = "<p class='notice'>Sorry, no product information could be found.</p>";
        } else {
            $detailDisplay = buildProductInfoDisplay($details);
        }

        //if there are thumbnails, build display
        if(count($thumbnails)){
            $tnDisplay = buildTnDisplay($thumbnails);
        }

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            $clientId = $_SESSION['clientData']['clientId'];
            $firstName = $_SESSION['clientData']['clientFirstname'];
            $lastName = $_SESSION['clientData']['clientLastname'];
            $screenName = $firstName[0] . $lastName;        
            $addReviewForm = buildReviewForm($invId, $clientId, $screenName);
        }

        //if there are reviews, build display
        if(count($productReviews)){
            $reviewsDisplay = productReviewsDisplay($productReviews);
        }

        include '../view/prod-detail.php';
    break;

    default:
        $categoryList = buildCategoryList($categories);
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/prod-mgmt.php';

}