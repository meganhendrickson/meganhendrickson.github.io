<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/header.php'?>

<!-- ACME HOME PAGE -->   
<!-- PAGE CONTENT -->
<section class="rocketfeature">
    <img id="rocketfeature" alt="acme rocket" src="http://localhost/acme/images/site/rocketfeature.jpg"/>
    <ul>
        <li><h2>Acme Rocket</h2></li>
        <li>Quick lighting fuse</li>
        <li>NHTSA approved seat belts</li>
        <li>Mobile launch stand included</li>
        <li><a href="#" title="add to cart button"><img id="actionbtn" alt="Add to cart button" src="http://localhost/acme/images/site/iwantit.gif"></a></li>
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
                    <td class="img"><img class="recipeimg" alt="pulled roadrunner bbq" src="http://localhost/acme/images/recipes/bbqsand.jpg"/></td>
                    <td class="img"><img class="recipeimg" alt="roadrunner pot pie" src="http://localhost/acme/images/recipes/potpie.jpg"/></td>
                </tr>
                <tr>
                    <td><a href="#" title="pulled roadrunner bbq recipe">Pulled Roadrunner BBQ</a></td> 
                    <td><a href="#" title="roadrunner pie recipe">Roadrunner Pot Pie</a></td>
                </tr>
                <tr>       
                    <td class="img"><a href="#" title="roadrunner soup recipe"><img class="recipeimg" alt="roadrunner soup" src="http://localhost/acme/images/recipes/soup.jpg"/></a></td>
                    <td class="img"><a href="#" title="roadrunner tacos recipe"><img class="recipeimg" alt="roadrunner tacos" src="http://localhost/acme/images/recipes/taco.jpg"/></a></td>
                </tr>
                <tr>
                    <td><a href="#" title="roadrunner soup recipe">Roadrunner Soup</a></td> 
                    <td><a href="#" title="roadrunner tacos recipe">Roadrunner Tacos</a></td>
                </tr>
            </table>
    </section>
</div>  

<?php include $_SERVER['DOCUMENT_ROOT'].'/ACME/common/footer.php';?>