<?php
if (isset($_POST['create_product'])) {
    $product_title = $_POST['title'];
    $product_category_id = $_POST['product_category'];

    $product_image = $_FILES['product_image']['name'];
    $product_image_temp = $_FILES['product_image']['tmp_name'];

    $product_description = $_POST['product_description'];
    $product_price = $_POST['product_price'];

    move_uploaded_file($product_image_temp, "../images/$product_image");

    // Add poduct
    $query = "INSERT INTO products (category_id, name, description, price, image) 
              VALUES (:product_category_id, :product_title, :product_description, :product_price, :product_image)";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':product_category_id', $product_category_id, PDO::PARAM_INT);
    $stmt->bindParam(':product_title', $product_title, PDO::PARAM_STR);
    $stmt->bindParam(':product_image', $product_image, PDO::PARAM_STR);
    $stmt->bindParam(':product_description', $product_description, PDO::PARAM_STR);
    $stmt->bindParam(':product_price', $product_price, PDO::PARAM_STR);

    $stmt->execute();

    // Get the ID of the last inserted record
    $last_product_id = $db->lastInsertId();

    // Display success message
    echo "<p class='alert alert-success'>Product added successfully. <a href='products.php?p_id=$last_product_id'>View Product</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Product Title</label>
        <input type="text" class="form-control" name="title">
    </div>

    <div class="form-group">
        <label for="product_category">Product Category</label>
        <select class="form-control" name="product_category" id="product_category">
            <?php
            $query = "SELECT * FROM categories";
            $stmt = $db->prepare($query);
            $stmt->execute();

            while ($Row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $cat_id = $Row["id"];
                $cat_title = $Row["name"];
                if (isset($cat_title)) {
                    ?>
                    <option value="<?php echo htmlspecialchars($cat_id); ?>"><?php echo htmlspecialchars($cat_title); ?></option>
                    <?php
                }
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="product_image">Product Image</label>
        <input type="file" name="product_image">
    </div>
    
    <div class="form-group">
        <label for="product_price">Product price</label>
        <input type="number" class="form-control" name="product_price">
    </div>

    <div class="form-group">
        <label id="my-ckeditor" for="product_description">Product Description</label>
        <textarea id="editor" name="product_description" class="form-control">
        
        </textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="create_product" value="Publish">
    </div>
</form>