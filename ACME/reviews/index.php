<?php

/* REVIEWS CONTROLLER */

// Create or access a Session
session_start();

// required resourses
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/connections.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/acme-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/reviews-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/accounts-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/model/products-model.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/ACME/library/functions.php';

//action collection
$action = filter_input(INPUT_POST, 'action');
    if($action == NULL){
        $action = filter_input(INPUT_GET, 'action');
    }

//switch control
switch ($action){
    case 'add-review':
        //fiter and store data
        $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);
        $invId = filter_input(INPUT_POST, 'invId', FILTER_SANITIZE_NUMBER_INT);
        $clientId = filter_input(INPUT_POST, 'clientId', FILTER_SANITIZE_NUMBER_INT);

        // Check for missing data
        if(empty($reviewText) || empty($invId) || empty($clientId)) {
            $message = '<p class="notice"> Please provide information for all empty form fields.</p>';
            header ("Location: http://localhost/acme/products/?action=details&invId='$invId'");
            exit;
        } 
        
        // Send the data to the database
        $addReview = addReview($reviewText, $invId, $clientId);

        // Check and report the result
        if($addReview = 1){
            $message = "<p class='notice'>Your review was sucessfully added.</p>";
            $_SESSION['message'] = $message;
            header ("Location: http://localhost/acme/products/?action=details&invId='$invId'");
            exit;
        } else {
            $message = '<p class="notice">Failed to add review. Please try again.</p>';
            $_SESSION['message'] = $message;
            header ("Location: http://localhost/acme/products/?action=details&invId='$invId'");
            exit;
        }
    break;

    case 'edit-review':
        $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $reviewInfo = getReviewInfo($reviewId);
        $reviewDate = $reviewInfo['reviewDate'];
        $timestamp = strtotime($reviewDate);
        $displayDate = date("F j, Y", $timestamp);

        if (count($reviewInfo) < 1) {
            $message = 'Sorry, no product information could be found.';
        }
        include '../view/review-edit.php';
        exit;
    break;

    case 'update-review':
    // Filter and store the data
    $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_STRING);
    $reviewText = filter_input(INPUT_POST, 'reviewText', FILTER_SANITIZE_STRING);

    // Check for missing data
    if(empty($reviewId) || empty($reviewText)) {
        $message = '<p class="notice"> Please provide information for all empty form fields.</p>';
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/edit-review.php';
        exit;
    } 

    // Send the data to the database
    $updateReview = updateReview($reviewId, $reviewText);

    // Check and report the result
    if($updateReview = 1){
        $message = "<p class='notice'> Review was successfully updated.</p>";
        $_SESSION['message'] = $message;
        header('location: /acme/accounts/');
        exit;
    } else {
        $message = "<p class='notice'>Failed to update review. Please try again.</p>";
        $_SESSION['message'] = $message;
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/edit-reivew.php';
        exit;
    }
    break;

    case 'delete-review':
        $reviewId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $reviewInfo = getReviewInfo($reviewId);
        $reviewDate = $reviewInfo['reviewDate'];
        $timestamp = strtotime($reviewDate);
        $displayDate = date("F j, Y", $timestamp);

        if (count($reviewInfo) < 1) {
            $message = 'Sorry, no product information could be found.';
        }

        include '../view/review-delete.php';
        exit;
        break;
    break;

    case 'review-del':
        $reviewId = filter_input(INPUT_POST, 'reviewId', FILTER_SANITIZE_NUMBER_INT);
        $deleteResult = deleteReview($reviewId);
        if ($deleteResult) {
            $message = "<p class='notice'>Review was successfully deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/accounts/');
            exit;
        } else {
            $message = "<p class='notice'>Error: $invName review was not deleted.</p>";
            $_SESSION['message'] = $message;
            header('location: /acme/accounts/');
            exit;
        }
    break;

    default:
        include $_SERVER['DOCUMENT_ROOT'].'/ACME/view/admin.php';
}