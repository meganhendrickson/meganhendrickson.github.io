<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
       }
?>

<!-- IMAGE ADMIN VIEW -->  

<!-- PAGE CONTENT -->
<section>
    <h2>Image Management</h2>
    <p>Welcome to the Image Management page! Please, choose one of the options below.</p>

    <h4>Add New Product Image</h4>
    <?php
       if (isset($message)) {
            echo $message;} 
    ?>

    <form action="/acme/uploads/" method="post" enctype="multipart/form-data">
        <label for="invItem">Product</label><br>
        <?php echo $prodSelect; ?><br><br>
        <label>Upload Image:</label><br>
        <input type="file" name="file1"><br>
        <input type="submit" class="regbtn" value="Upload">
        <input type="hidden" name="action" value="upload">
    </form>
    <hr>
    <h4>Existing Images</h4>
    <p class="notice">If deleting an image, delete the thumbnail too and vice versa.</p>
    <?php
        if (isset($imageDisplay)) {
            echo $imageDisplay;} 
    ?>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>
<?php unset($_SESSION['message']); ?>