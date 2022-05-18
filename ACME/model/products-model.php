<?php

/* PRODUCTS MODEL */

// Insert new category into database
function addCategory($categoryName){
    $db = acmeConnect();

    // The SQL statement to be used with the Database
    $sql = 'INSERT INTO categories (categoryName)
    VALUE (:categoryname)';   

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // binding statement
    $stmt->bindValue(':categoryname', $categoryName, PDO:: PARAM_STR);

    // Use the prepared statement to insert the data
    $stmt->execute();
    
    // Now we find out if the insert worked by asking how many rows changed in the table
    $rowsChanged = $stmt->rowCount();
    //error_log("$rowsChanged");
    //Close the databse interaction
    $stmt->closeCursor();

    // Return the indication of success
    return $rowsChanged;
}


// Insert new product data into database
function addInventory($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, 
        $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle){
        $db = acmeConnect();

    // The SQL statement to be used with the Database
    $sql = 'INSERT INTO inventory (invName, invDescription, invImage, invThumbnail, invPrice, invStock, 
        invSize, invWeight, invLocation, categoryId, invVendor, invStyle)
    VALUES (:invname, :invdescription, :invimage, :invthumbnail, :invprice, :invstock, 
        :invsize, :invweight, :invlocation, :categoryid, :invvendor, :invstyle)';

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // binding statements
    $stmt->bindValue(':invname', $invName, PDO:: PARAM_STR);
    $stmt->bindValue(':invdescription', $invDescription, PDO:: PARAM_STR);
    $stmt->bindValue(':invimage', $invImage, PDO:: PARAM_STR);
    $stmt->bindValue(':invthumbnail', $invThumbnail, PDO:: PARAM_STR);
    $stmt->bindValue(':invprice', $invPrice, PDO:: PARAM_STR); 
    $stmt->bindValue(':invstock', $invStock, PDO:: PARAM_STR);
    $stmt->bindValue(':invsize', $invSize, PDO:: PARAM_STR);
    $stmt->bindValue(':invweight', $invWeight, PDO:: PARAM_STR);
    $stmt->bindValue(':invlocation', $invLocation, PDO:: PARAM_STR);
    $stmt->bindValue(':categoryid', $categoryId, PDO:: PARAM_STR);
    $stmt->bindValue(':invvendor', $invVendor, PDO:: PARAM_STR);
    $stmt->bindValue(':invstyle', $invStyle, PDO:: PARAM_STR);

    // Use the prepared statement to insert the data
    $stmt->execute();

    // Now we find out if the insert worked by asking how many rows changed in the table
    $rowsChanged = $stmt->rowCount();

    //Close the databse interaction
    $stmt->closeCursor();

    // Return the indication of success
    return $rowsChanged;
}

// Get products by categoryId 
function getProductsByCategory($categoryId){ 
    $db = acmeConnect(); 
    $sql = ' SELECT * FROM inventory WHERE categoryId = :categoryId'; 
    $stmt = $db->prepare($sql); 
    $stmt->bindValue(':categoryId', $categoryId, PDO::PARAM_INT); 
    $stmt->execute(); 
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    $stmt->closeCursor(); 
    return $products; 
}

// Get single product information by invId
function getProductInfo($invId){
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $prodInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $prodInfo;
   }

   // update a product function
   function updateProduct($invName, $invDescription, $invImage, $invThumbnail, $invPrice, $invStock, 
        $invSize, $invWeight, $invLocation, $categoryId, $invVendor, $invStyle, $invId){
        $db = acmeConnect();

    // The SQL statement to be used with the Database
    $sql = 'UPDATE inventory 
            SET
            invName = :invName, 
            invDescription = :invDescription, 
            invImage = :invImage, 
            invThumbnail = :invThumbnail, 
            invPrice = :invPrice, 
            invStock = :invStock, 
            invSize = :invSize, 
            invWeight = :invWeight, 
            invLocation = :invLocation, 
            categoryId = :categoryId, 
            invVendor = :invVendor, 
            invStyle = :invStyle
            WHERE invId = :invId'; 

    // The next line creates the prepared statement using the acme connection
    $stmt = $db->prepare($sql);

    // binding statements
    $stmt->bindValue(':invName', $invName, PDO:: PARAM_STR);
    $stmt->bindValue(':invDescription', $invDescription, PDO:: PARAM_STR);
    $stmt->bindValue(':invImage', $invImage, PDO:: PARAM_STR);
    $stmt->bindValue(':invThumbnail', $invThumbnail, PDO:: PARAM_STR);
    $stmt->bindValue(':invPrice', $invPrice, PDO:: PARAM_STR); 
    $stmt->bindValue(':invStock', $invStock, PDO:: PARAM_STR);
    $stmt->bindValue(':invSize', $invSize, PDO:: PARAM_STR);
    $stmt->bindValue(':invWeight', $invWeight, PDO:: PARAM_STR);
    $stmt->bindValue(':invLocation', $invLocation, PDO:: PARAM_STR);
    $stmt->bindValue(':categoryId', $categoryId, PDO:: PARAM_STR);
    $stmt->bindValue(':invVendor', $invVendor, PDO:: PARAM_STR);
    $stmt->bindValue(':invStyle', $invStyle, PDO:: PARAM_STR);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT); 

    // Use the prepared statement to update the data
    $stmt->execute();

    // Now we find out if the update worked by asking how many rows changed in the table
    $rowsChanged = $stmt->rowCount();

    //Close the databse interaction
    $stmt->closeCursor();

    // Return the indication of success
    return $rowsChanged;
}

// delete a product function
function deleteProduct($invId) {
    $db = acmeConnect();
    $sql = 'DELETE FROM inventory WHERE invId = :invId';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':invId', $invId, PDO::PARAM_INT);
    $stmt->execute();
    $rowsChanged = $stmt->rowCount();
    $stmt->closeCursor();
    return $rowsChanged;
}

//create a list of products based on category
function getProductsByCategoryName($categoryName){
    $db = acmeConnect();
    $sql = 'SELECT * FROM inventory WHERE categoryId IN (SELECT categoryId FROM categories WHERE categoryName = :categoryName)';
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':categoryName', $categoryName, PDO::PARAM_STR);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

//build a display of products
function buildProductsDisplay($products){
    $pd = '<ul id="prod-display">';
    foreach ($products as $product) {
        $pd .= "<li><a href='/acme/products/?action=details&invId=".urlencode($product['invId'])."' title='View $product[invName] details'>";
        $pd .= "<img class='prodthumb' src='$product[invThumbnail]' alt='Image of $product[invName] on Acme.com'></a>";
        $pd .= '<hr>';
        $pd .= "<h4><a href='/acme/products/?action=details&invId=".urlencode($product['invId'])."' title='View $product[invName] details'>$product[invName]</a></h4>";
        $pd .= "<span>&#36;$product[invPrice]</span>";
        $pd .= '</li>';
    }
    $pd .= '</ul>';
    return $pd;
   }

// Get the list of products
function getProductBasics() {
    $db = acmeConnect();
    $sql = 'SELECT invName, invId FROM inventory ORDER BY invName ASC';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $stmt->closeCursor();
    return $products;
}

