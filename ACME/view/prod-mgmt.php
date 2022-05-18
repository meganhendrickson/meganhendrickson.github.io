<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';
    
    //check if user is logged in
    if (!$_SESSION['loggedin']){
        header ("Location: http://localhost/acme");
    }
    
    //check if user is admin level
    if ($_SESSION['clientData']['clientLevel'] < 2) {
        header ("Location: http://localhost/acme");
        exit;
    }

    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
       }
?>

<!-- PRODUCT MANAGEMENT VIEW -->  
<!-- PAGE CONTENT -->
<section>
<h2>Product Management</h2>
    <?php if (isset($message)) { echo $message;}?>
    <a href="http://localhost/ACME/products/index.php?action=new-cat">Add a New Category</a><br>
    <a href="http://localhost/ACME/products/index.php?action=new-prod">Add a New Product</a>

    <?php
        if (isset($categoryList)) { 
            echo '<h2>Products By Category</h2>'; 
            echo '<p>Choose a category to see those products</p>'; 
            echo $categoryList; 
        }
    ?>

    <noscript>
        <p><strong>JavaScript Must Be Enabled to Use this Page.</strong></p>
    </noscript>

    <table id="productsDisplay">
    <!-- Product table built here using JS DOM -->
    </table>

</section>

<script src="../js/products.js"></script>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>