        </main>
        <footer>
            <p>&copy; <?php echo date("Y");?> | ACME | All Rights Reserved</p>
            <p>All images used are believed to be in "Fair Use." Please notify author if any are not and they will be removed.
            <p><?php echo "Last modified" . date(" F d, Y.", getlastmod()); ?></p>
            <!-- scripts -->
            <script src="http://localhost/acme/js/main.js"></script>
            <?php unset($_SESSION['message']); ?>
        </footer>

    </body>
</html>
