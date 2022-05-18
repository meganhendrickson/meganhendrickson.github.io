<?php 
    include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php';
    
    if(!$_SESSION['loggedin']){
        header ("Location: http://localhost/acme/accounts/?action=myAccount");
    }
?>

<!-- CLIENT UPDATE VIEW -->
<!-- PAGE CONTENT -->
<section>
    <h2>Update Account</h2>
    <?php if (isset($message)) {echo $message;}?>
    <p>Use this form to update your name or email.</p>

    <form action="http://localhost/ACME/accounts/index.php" method="post">
        <fieldset>
            <label>First Name:</label><br>
            <input required type="text" name="clientFirstname" id="clientFirstname" 
                value="<?php echo $_SESSION['clientData']['clientFirstname']?>"/><br>

            <label>Last Name:</label><br>
            <input required type="text" name="clientLastname" id="clientLastname" 
                value="<?php echo $_SESSION['clientData']['clientLastname']?>"/><br>

            <label>Email Address:</label><br>
            <input required type="text" name="clientEmail" id="clientEmail" 
            value="<?php echo $_SESSION['clientData']['clientEmail']?>"/><br>

            <input type="submit" class="button" name="submit" value="Update Account" />
            <!-- Action Key - Value Pair -->
            <input type="hidden" name="action" value="clientUpdate">
            <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']?>">
        </fieldset>
    </form>

    <h2>Update Password</h2>
    <?php if (isset($message2)) {echo $message2;}?>                        
    <p>Use this form to change your password.</p>

    <form action="http://localhost/ACME/accounts/index.php" method="post">
        <fieldset>
            <p id="instructions">Passwords must be at least 8 characters and contain at least
                1 number, 1 capital letter, and 1 special character.</p>
            <label>New Password:</label><br>
            <input required type="password" name="clientPassword" id="clientPassword" /><br>
            <input type="submit" class="button" name="submit" value="Change Password" />

            <!-- Action Key - Value Pair -->
            <input type="hidden" name="action" value="passwordUpdate">
            <input type="hidden" name="clientId" value="<?php echo $_SESSION['clientData']['clientId']?>">
        </fieldset>
    </form>
</section>

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>