<?php
include "includes/header.php";
include "includes/navigation.php";

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

?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-12">
                <?php
                if (isset($_GET['source'])) {
                    $source = $_GET['source'];
                } else {
                    $source = "";
                }
                switch ($source) {
                    case 'add_product':
                        include "./includes/add_product.php";
                        break;
                    case 'edit_product':
                        include "./includes/edit_product.php";
                        break;
                    default:
                        include "./includes/viewAllProducts.php";
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>