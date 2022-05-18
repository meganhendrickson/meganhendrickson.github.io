<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';

    //check if user is logged in
    if (!$_SESSION['loggedin']){
        header ("Location: http://localhost/acme");
    }
    //check if user is admin level
    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header ("Location: http://localhost/acme");
    }
?>

<!-- PRODUCT UPDATE VIEW -->
<!-- PAGE CONTENT -->
<section>

    <h2><?php if(isset($prodInfo['invName'])){ 
       echo "Modify $prodInfo[invName] ";} 
       elseif(isset($invName)) { echo $invName; }?></h2>

    <div class="message">
        <?php if (isset($message)) {echo $message;}?>
    </div>

    <p>Update product below. All fields are required!</p>

    <form action="http://localhost/ACME/products/index.php" method="post">
        <fieldset>
            <label>Select category:</label><br>
            <?php  //Drop down select list using $categories array
                    $catList = '<select name="categoryId" id="categoryId">';
                    foreach ($categories as $category){
                        $catList .= "<option value='$category[categoryId]'";
                        if(isset($categoryId)){
                            if($category['categoryId'] === $categoryId){
                            $catList .= ' selected ';
                            }
                        } elseif(isset($prodInfo['categoryId'])){
                            if($category['categoryId'] === $prodInfo['categoryId']){
                                $catList .= ' selected ';
                            }
                          }
                        $catList .= ">$category[categoryName].</option>";
                    }
                    $catList .= '</select>';
                    echo $catList;  
                ?>
            <br>

            <label>Product Name:</label><br>
            <input required type="text" name="invName" id="invName"
                <?php if(isset($invName)){ echo "value='$invName'"; } 
                    elseif(isset($prodInfo['invName'])) {
                        echo "value='$prodInfo[invName]'"; }?>/><br>
            
            <label>Product Description:</label><br>
            <input required type="text" name="invDescription" id="invDescription"
                <?php if(isset($invDescription)){ echo "value='$invDescription'"; } 
                    elseif(isset($prodInfo['invDescription'])) {
                        echo "value='$prodInfo[invDescription]'"; }?>/><br>
            
            <label>Product Image (use image admin to upload new image):</label><br>
            <input readonly type="text" name="invImage" id="invImage" 
                <?php if(isset($invStock)){ echo "value='$invStock'"; } 
                    elseif(isset($prodInfo['invImage'])) {
                        echo "value='$prodInfo[invImage]'"; }?>/><br>
            
            <label>Product Thumbnail(use image admin to upload new image):</label><br>
            <input readonly type="text" name="invThumbnail" id="invThumbnail" 
                <?php if(isset($invThumbnail)){ echo "value='$invStock'"; } 
                    elseif(isset($prodInfo['invThumbnail'])) {
                        echo "value='$prodInfo[invThumbnail]'"; }?>/><br>
            
            <label>Product Price:</label><br>
            <input required type="number" name="invPrice" id="invPrice"
                <?php if(isset($invPrice)){ echo "value='$invPrice'"; } 
                    elseif(isset($prodInfo['invPrice'])) {
                        echo "value='$prodInfo[invPrice]'"; }?>/><br>
            
            <label>Number in Stock:</label><br>
            <input required type="number" name="invStock" id="invStock"
                <?php if(isset($invStock)){ echo "value='$invStock'"; } 
                    elseif(isset($prodInfo['invStock'])) {
                        echo "value='$prodInfo[invStock]'"; }?>/><br>
            
            <label>Shipping Size (W x H x L in inches):</label><br>
            <input required type="number" name="invSize" id="invSize"
                <?php if(isset($invSize)){ echo "value='$invSize'"; } 
                    elseif(isset($prodInfo['invSize'])) {
                        echo "value='$prodInfo[invSize]'"; }?>/><br>
            
            <label>Product Weight (lbs):</label><br>
            <input required type="number" name="invWeight" id="invWeight"
                <?php if(isset($invWeight)){ echo "value='$invWeight'"; } 
                    elseif(isset($prodInfo['invWeight'])) {
                        echo "value='$prodInfo[invWeight]'"; }?>/><br>
            
            <label>Product Location (city name):</label><br>
            <input required type="text" name="invLocation" id="invLocation"
                <?php if(isset($invLocation)){ echo "value='$invLocation'"; } 
                    elseif(isset($prodInfo['invLocation'])) {
                        echo "value='$prodInfo[invLocation]'"; }?>/><br>
            
            <label>Vendor Name:</label><br>
            <input required type="text" name="invVendor" id="invVendor"
                <?php if(isset($invVendor)){ echo "value='$invVendor'"; } 
                    elseif(isset($prodInfo['invVendor'])) {
                        echo "value='$prodInfo[invVendor]'"; }?>/><br>
            
            <label>Primary Material:</label><br>
            <input required type="text" name="invStyle" id="invStyle"
                <?php if(isset($invStyle)){ echo "value='$invStyle'"; } 
                    elseif(isset($prodInfo['invStyle'])) {
                        echo "value='$prodInfo[invStyle]'"; }?>/><br>
        </fieldset>
        <input type="submit" class="button" name="submit" value="Update Product"/>
        <!-- Action Key - Value Pair -->
        <input type="hidden" name="action" value="updateProd">
        <input type="hidden" name="invId" 
            value="<?php if(isset($prodInfo['invId'])){ echo $prodInfo['invId'];} 
                    elseif(isset($invId)){ echo $invId; } ?>">
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>