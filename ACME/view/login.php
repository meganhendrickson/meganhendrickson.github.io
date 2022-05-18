<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php'?>
<!-- LOGIN VIEW -->        
<!-- PAGE CONTENT -->
    <section>
        <h2>ACME Login</h2>

            <div class="message">
                <?php if (isset($message)) {echo $message;}?>
            </div>

            <form action="/ACME/accounts/" method="post">
                <label>Email Address:</label><br>
                <input required type="text" name="clientEmail" id="clientEmail"/><br>
                <label>Password:</label><br>
                <input required type="password" name="clientPassword" id="clientPassword"/><br>
                <input type="submit" class="button" name="login" value="Login"/>
                <input type="hidden" name="action" value="login"/>
            </form>
            
            <p> Not a member?</p>
                <form action="/ACME/accounts/" method="post">
                    <input type="submit" class="button" name="registration" value="Create an Account">
                    <input type="hidden" name="action" value="registration"/>
                </form> 
        </section>
        
    <!-- FOOTER AREA -->
<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php'?>
