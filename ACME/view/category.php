<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php'?>

<!-- CATEGORY VIEW -->  
<!-- PAGE CONTENT -->
<section>
    <h2><?php echo $categoryName;?>  Products</h2>

    <?php if(isset($_SESSION['message'])) {
        echo $_SESSION['message']; 
        unset($_SESSION['message']);
        } ?>

    <?php if(isset($prodDisplay)){ echo $prodDisplay;} ?>

</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>