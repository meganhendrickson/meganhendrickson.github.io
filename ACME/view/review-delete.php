<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';

    //check if user is logged in
    if (!$_SESSION['loggedin']){
        header ("Location: http://localhost/acme");
    }
?>

<!-- REVIEW DELETE VIEW -->
<!-- PAGE CONTENT -->
<section>

    <h2><?php if(isset($reviewInfo['invName'])){ 
       echo "Delete $reviewInfo[invName] Review";} 
       else{ echo "Delete Review"; }?></h2>

    <div class="message">
        <?php if (isset($message)) {echo $message;}?>
    </div>

    <p>Update review below. All fields are required.</p>

    <form action="http://localhost/ACME/reviews/index.php" method="post">
        <fieldset>
            <label>Review of:</label><br>
            <input readonly type="text" name="invName" id="invName"
            <?php if(isset($reviewInfo['invName'])) {echo "value='$reviewInfo[invName]'"; }?>/><br>
            
            <label>written on:</label><br>
            <input readonly type="text" name="reviewDate" id="reviewDate"
            <?php if(isset($reviewInfo['reviewDate'])) {echo "value='$displayDate'"; }?>/><br>

            <label>Review Text:</label><br>
            <input readonly type="text" name="reviewText" id="reviewText"
            <?php if(isset($reviewInfo['reviewText'])) {echo "value='$reviewInfo[reviewText]'"; } ?>/><br>
        </fieldset>
        <input type="submit" class="button" name="submit" value="Delete Review"/>
        <!-- Action Key - Value Pair -->
        <input type="hidden" name="action" value="review-del">
        <input type="hidden" name="reviewId" 
            value="<?php if(isset($reviewInfo['reviewId'])){ echo $reviewInfo['reviewId'];} ?>">
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>