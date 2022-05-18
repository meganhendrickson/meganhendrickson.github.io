<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';
 
    if(!$_SESSION['loggedin']){
        header ("Location: http://localhost/acme/accounts/?action=myAccount");
    }
?>

<!-- ADMIN VIEW -->
<!-- PAGE CONTENT -->
<section>
    <h1>Welcome,&nbsp; <?php echo ($_SESSION['clientData']['clientFirstname']);?>
    <?php echo ($_SESSION['clientData']['clientLastname']);?>!&nbsp; You are logged in.</h1>
        
    <?php 
        if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
        }
        if (isset($message)) { echo $message;}
    ?>

    <ul>
        <li>First Name: <?php echo $_SESSION['clientData']['clientFirstname'];?> </li>
        <li>Last Name: <?php echo $_SESSION['clientData']['clientLastname'];?> </li>
        <li>Email: <?php echo $_SESSION['clientData']['clientEmail'];?> </li>
    </ul>
    <p><a href="http://localhost/acme/accounts/?action=accountUpdate">Click here to update account information</a></p>

    <?php
        if ($_SESSION['clientData']['clientLevel'] > 1) {
            echo '<p> <a href="http://localhost/acme/products/">Click here to manage products</a>';
        }
    ?>

    <h2>Manage Your Product Reviews</h2>
    <?php if(isset($clientReviewsDisplay)){ echo $clientReviewsDisplay;} ?>

</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>