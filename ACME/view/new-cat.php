<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';
    //check if user is logged in
    if(!$_SESSION['loggedin']){
        header ("Location: http://localhost/acme");
    }
    //check if user is admin level
    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header ("Location: http://localhost/acme");
    }
?>

<!-- NEW CAT VIEW -->
<!-- PAGE CONTENT -->
<section>

    <h2>Add Category</h2>
    <div class="message">
        <?php if (isset($message)) {echo $message;}?>
    </div>
    <p>Add a new category of products below.</p>
    <form action="http://localhost/ACME/products/index.php" method="post">
        <label>New Category Name</label><br>
        <input type="text" name="categoryName" id="categoryName" required /><br>
        <input type="submit" class="button" name="submit" value="Add Category" />
        <!-- Action Key - Value Pair -->
        <input type="hidden" name="action" value="add-cat">
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php';?>