<!DOCTYPE html>
<html lang="en"> <!-- ACME HOME PAGE -->
    <head>
        <title>ACME</title>  
        <!-- META INFO -->
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="description" content="Commission Information and Pricing">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSS LINKS -->
        <link rel="stylesheet" href="css/main.css">
        <!-- MODERNIZR SCRIPT -->
        <script src="js/modernizr-2.8.3.min.js"></script>
    </head>
    <body>
        <!-- HEADER -->
        <header>
            <?php include 'common/header.php'?>
        </header>
        <!-- PAGE CONTENT -->
        <section class="rocketfeature">
            <img id="rocketfeature" alt="acme rocket" src="images/site/rocketfeature.jpg"/>
            <ul>
                <li><h2>Acme Rocket</h2></li>
                <li>Quick lighting fuse</li>
                <li>NHTSA approved seat belts</li>
                <li>Mobile launch stand included</li>
                <li><a href="#"><img id="actionbtn" alt="Add to cart button" src="images/site/iwantit.gif"></a></li>
            </ul>
        </section>
        <div class="flexcontainer">
        <section class="productreview" style="order: 2">
            <h2>ACME Rocket Reviews</h2>
            <ul>
                <li>"I don't know how I ever caught roadrunners before this." (4/5)</li>
                <li>"That thing was fast!" (4/5)</li>
                <li>"Talk about fast delivery." (5/5)</li>
                <li>"I didn't even have to pull the meat apart." (4.5/5)</li>
                <li>"I'm on my thirtieth one. I love these things!" (5/5)</li>
            </ul>
        </section>  
        <section id="featured-recipes" style="order: 1">
            <h2>Featured Recipes</h2>
                <table>
                    <tr>
                        <td class="img"><img class="recipeimg" alt="pulled roadrunner bbq" src="images/recipes/bbqsand.jpg"/></td>
                        <td class="img"><img class="recipeimg" alt="roadrunner pot pie" src="images/recipes/potpie.jpg"/></td>
                    </tr>
                    <tr>
                        <td><a href="#">Pulled Roadrunner BBQ</a></td> 
                        <td><a href="#">Roadrunner Pot Pie</a></td>
                    </tr>
                    <tr>       
                        <td class="img"><a href="#"><img class="recipeimg" alt="roadrunner soup" src="images/recipes/soup.jpg"/></a></td>
                        <td class="img"><a href="#"><img class="recipeimg" alt="roadrunner tacos" src="images/recipes/taco.jpg"/></a></td>
                    </tr>
                    <tr>
                        <td><a href="#">Roadrunner Soup</a></td> 
                        <td><a href="#">Roadrunner Tacos</a></td>
                    </tr>
                </table>
        </section>
</div>  
        <!-- FOOTER AREA -->
        <footer>
            <?php include 'common/footer.php'?>
        </footer>
        <!-- scripts -->
        <script src="js/main.js"></script>
    </body>
</html>