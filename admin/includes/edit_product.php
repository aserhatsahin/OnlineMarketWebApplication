<?php
if (isset($_POST['update_product'], $_GET['p_id'])) {
    $the_product_id = $_GET['p_id'];

    $product_title = $_POST['title'];
    $product_category_id = $_POST['product_category'];
    $product_price = $_POST['product_price'];

    $product_image = $_FILES['product_image']['name'];
    $product_image_temp = $_FILES['product_image']['tmp_name'];

    $product_description = $_POST['product_description'];


    move_uploaded_file($product_image_temp, "../images/$product_image");

    // Update a Product
    $query = "UPDATE products SET 
                category_id = :product_category_id, 
                name = :product_title, 
                description = :product_description, 
                price = :product_price"; 
                

    // Add the `product_image` only if it is not empty
    if (!empty($product_image)) {
        $query .= ", image = :product_image";
    }

    $query .= " WHERE id = :product_id";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':product_category_id', $product_category_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_title', $product_title, PDO::PARAM_STR);
    $stmt->bindParam(':product_description', $product_description, PDO::PARAM_STR);
    $stmt->bindParam(':product_price', $product_price, PDO::PARAM_STR);
    $stmt->bindParam(':product_id', $the_product_id, PDO::PARAM_INT);

    if (!empty($post_image)) {
        $stmt->bindParam(':product_image', $product_image, PDO::PARAM_STR);
    }

    $stmt->execute();

    echo "<p class='alert alert-success'>Product updated successfully. <a href='products.php?p_id=$the_product_id'>View Product</a></p>";
}
?>


<?php
if (isset($_GET['p_id'])) {
    $the_product_id = $_GET['p_id'];
    $query = "SELECT * FROM products WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$the_product_id]);
    
    $Row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($Row) {
        $product_id = $Row['id'];
        $product_title = $Row['name'];
        $product_category_id = $Row['category_id'];
        $product_price = $Row['price'];
        $product_image = $Row['image'];
        $product_description = $Row['description'];
    } else {
        echo "<p class='alert alert-danger'>Product not found.</p>";
        exit;
    }
    ?>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Product Title</label>
            <input type="text" class="form-control" value="<?php echo $product_title; ?>" name="title">
        </div>

        <div class="form-group">
            <label for="product_category">Product Category ID</label>
            <select class="form-control" name="product_category" id="product_category">
                <?php
                $query = "SELECT * FROM categories";
                $stmt = $db->prepare($query);
                $stmt->execute();
            
                while ($Row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $cat_id = $Row["id"];
                    $cat_title = $Row["name"];
                    $selected = ($cat_id == $product_category_id) ? 'selected' : '';
            
                    if (isset($cat_title)) {
                        echo "<option value='" . htmlspecialchars($cat_id) . "' " . $selected . ">" . htmlspecialchars($cat_title) . "</option>";
                    }
                }
                ?>
            </select>
        </div>

        <div class="form-group">
            <img src='../images/<?php echo $product_image ?>' alt='image' width='100px'>
            <input type="file" name="product_image">
        </div>

        <div class="form-group">
            <label for="product_price">Product Price</label>
            <input type="text" class="form-control" value='<?php echo $product_price; ?>' name="product_price">
        </div>

        <div class="form-group">
            <label for="product_description">Product description</label>
            <textarea id="editor" name="product_description" class="form-control">
                <?php echo $product_description; ?>
            </textarea>
        </div>

        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="update_product" value="Update">
        </div>
    </form>
<?php }
?>