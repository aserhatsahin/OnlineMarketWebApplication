<?php
include "includes/header.php";
include "includes/navigation.php";

$error_message = "";
// Add new Category.
if (isset($_POST["submit"])) {
    $cat_title = $_POST['cat_title'];
    if (!empty($cat_title)) {
        $query = "INSERT INTO categories (name) VALUES (?)";
        $stmt = $db->prepare($query);
        $stmt->execute([$cat_title]);
    } else {
        $error_message = "Category field is required.";
    }
}

// Delete Category.
if (isset($_GET["delete"])) {
    $cat_id = $_GET['delete'];
    try {
        $query = "DELETE FROM categories WHERE id = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$cat_id]);
        header("Location: categories.php");
        exit;
    } catch (PDOException $ex) {
        die("Query Failed: " . $ex->getMessage());
    }
}

// Update Category.
if (isset($_GET["edit"]) && isset($_POST["update_category"])) {
    $cat_id = $_GET['edit'];
    $cat_title = $_POST["cat_title"];
    try {
        $query = "UPDATE categories SET name = :cat_title WHERE id = :cat_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':cat_title', $cat_title, PDO::PARAM_STR);
        $stmt->bindParam(':cat_id', $cat_id, PDO::PARAM_INT);
        $stmt->execute();
        header("Location: categories.php");
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