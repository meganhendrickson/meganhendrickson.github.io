<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php'?>
<!-- REGISTRATION VIEW -->       
<!-- PAGE CONTENT -->
    <section>
        <h2>ACME Registration</h2>
        <p> All fields are required.</p>
        
        <div class="message">
            <?php if (isset($message)) {echo $message;}?>
        </div>
        
        <form action="http://localhost/ACME/accounts/index.php" method="post">
            <label>First Name:</label><br>
                <input required type="text" name="clientFirstname" id="clientFirstname"/><br>
            
            <label>Last Name:</label><br>
                <input required type="text" name="clientLastname" id="clientLastname"/><br>
            
            <label>Email Address:</label><br>
                <input required type="text" name="clientEmail" id="clientEmail"/><br>
                       
            <label>Password:</label><br>
            <p id="instructions">Passwords must be at least 8 characters and contain at least 
                1 number, 1 capital letter, and 1 special character.</p>
                <input required type="password" name="clientPassword" id="clientPassword"/><br>
                <input type="submit" class="button" name="action" value="register"/>
        </form>
    </section>
<!-- FOOTER AREA -->
<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>
