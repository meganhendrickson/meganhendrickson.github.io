<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php'?>

<!-- PRODUCT DETAILS VIEW -->  
<!-- PAGE CONTENT -->
<section>
    <?php
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];}
    if (isset($message)) { echo $message;}
    ?>
    <p>Product <a href="#reviews">reviews</a> appear at the bottom of the page.</p>
    <?php if(isset($detailDisplay)){ echo $detailDisplay;} ?>
    <?php if(isset($tnDisplay)){ echo $tnDisplay;} ?>

    <hr>
    
    <div id='reviews'>
        <h2>Customer Reviews</h2>
        <?php  
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
            if(isset($addReviewForm)){echo $addReviewForm;}
        }else{
            echo 
            '<p> <a href="http://localhost/acme/accounts/">Login to write a review.</a>';
        }

        if(isset($reviewsDisplay)){ echo $reviewsDisplay;} 
        ?>
    </div>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>