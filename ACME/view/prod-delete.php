<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';

    //check if user is admin level
    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header ("Location: http://localhost/acme");
    }
?>

<!-- PRODUCT DELETE VIEW -->
<!-- PAGE CONTENT -->
<section>

    <h2><?php if(isset($prodInfo['invName'])){ 
       echo "Delete $prodInfo[invName] ";} 
       elseif(isset($invName)) { echo $invName; }?></h2>

    <div class="message">
        <?php if (isset($message)) {echo $message;}?>
    </div>

    <p>Confirm Product Deletion. The delete is permanent.</p>

    <form action="http://localhost/ACME/products/index.php" method="post">
        <fieldset>
            <label>Product Name:</label>
            <input readonly type="text" name="invName" id="invName"
            <?php if(isset($prodInfo['invName'])) {echo "value='$prodInfo[invName]'"; }?>/><br>
            
            <label>Product Description:</label><br>
            <input readonly type="text" name="invDescription" id="invDescription"
            <?php if(isset($prodInfo['invDescription'])) {echo "value='$prodInfo[invDescription]'"; } ?>/><br>
        </fieldset>
        <input type="submit" class="button" name="submit" value="Delete Product"/>
        <!-- Action Key - Value Pair -->
        <input type="hidden" name="action" value="deleteProd">
        <input type="hidden" name="invId" 
            value="<?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];} ?>">
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>