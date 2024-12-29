<?php
// Delete Product
if (isset($_GET["delete"])) {
    $product_id = $_GET['delete'];

    try {
        // Prepare the DELETE query
        $query = "DELETE FROM products WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$product_id]);

        header("Location: products.php");
        exit;
    } catch (PDOException $ex) {
        die("Query Failed: " . $ex->getMessage());
    }
}


if (isset($_POST["apply"])) {
    if (isset($_POST["checkBoxArray"])) {
        foreach ($_POST["checkBoxArray"] as $checkBoxValue) {
            $bulk_option = $_POST['bulk_option'];
            switch ($bulk_option) {
                case 'Delete':
                    $query = "DELETE FROM products WHERE id = ?";
                    $stmt = $db->prepare($query);        
                    $stmt->execute([$checkBoxValue]);

                    echo "<p class='alert alert-success'>Product deleted successfully.</p>";
                    break;
                default:
                    echo "<p class='alert alert-danger'>Please selectan option</p>";
                    break;
            }
        }
    } else {
        echo "<p class='alert alert-danger'>Please select a product</p>";
    }
}
?>
<form action="" method="POST">
    <table class="table table-bordered table-hover" id="viewposts">
        <div class="row">
            <div class="col-sm-4">
                <select class="form-control" name="bulk_option">
                    <option value="">Select Options</option>
                    <option value="Delete">Delete</option>
                </select>
            </div>
            <div class="form-group col-xs-4">
                <input type="submit" class="btn btn-success" name="apply" value="Apply">
                <a class="btn btn-primary" href="products.php?source=add_product">Add New</a>
            </div>
        </div>
        <thead>
            <tr>
                <th><input type='checkbox' id='selectAllBoxes' onclick="selectAll(this)"></th>
                <th>ID</th>
                <th>Title</th>
                <th>Category</th>
                <th>Image</th>
                <th>Price</th>
                <th>Description</th>
                <th>Date</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM products";
            $stmt = $db->prepare($query);
            $stmt->execute();
        
            while ($Row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $the_product_id = $Row['id'];
                echo "<tr>"; ?>
                <td><input type='checkbox' name='checkBoxArray[]' value='<?php echo htmlspecialchars($the_product_id); ?>'></td>
                <?php
                echo "<td>" . htmlspecialchars($Row['id']) . "</td>";
                echo "<td><a href='products.php?p_id=$the_product_id'>" . htmlspecialchars($Row['name']) . "</a></td>";
        
                // Fetch category name
                $cat_id = $Row['category_id'];
                $categoryQuery = "SELECT * FROM categories WHERE id = ?";
                $categoryStmt = $db->prepare($categoryQuery);
                $categoryStmt->execute([$cat_id]);
        
                $Cat = $categoryStmt->fetch(PDO::FETCH_ASSOC);
                if ($Cat) {
                    $cat_title = $Cat["name"];
                    echo "<td>" . htmlspecialchars($cat_title) . "</td>";
                } else {
                    echo "<td>No category</td>";
                }
        
                echo "
                    <td><img src='../images/" . htmlspecialchars($Row['image']) . "' alt='image' width='100px'></td>
                    <td>" . htmlspecialchars($Row['price']) . "</td>
                    <td>" . htmlspecialchars($Row['description']) . "</td>
                    <td>" . htmlspecialchars($Row['created_at']) . "</td>
                    <td>
                        <a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \" href='products.php?delete=$the_product_id'>Delete</a> 
                        | <a href='products.php?source=edit_product&p_id=$the_product_id'>Edit</a>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</form>