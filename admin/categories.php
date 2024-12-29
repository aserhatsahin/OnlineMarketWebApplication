<?php
include "includes/header.php";
include "includes/navigation.php";

$error_message = "";
// Add new Category.
if (isset($_POST["submit"])) {
    $cat_title = trim($_POST['cat_title']);
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
    $cat_title = trim($_POST["cat_title"]);
    if (!empty($cat_title)) {
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
    } else {
        $error_message = "Category field is required.";
    }
}

?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-xs-6">
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="cat_title">Add Category</label>
                        <input type="text" class="form-control" name="cat_title" id="">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" name="submit" value="Add Category">
                    </div>
                </form>
                <span><?php echo $error_message; ?></span>
                <form action="" method="POST">
                    <?php
                    if (isset($_GET['edit'])) {
                        $cat_id = $_GET['edit'];

                        $query = "SELECT * FROM categories WHERE id = ?";
                        $stmt = $db->prepare($query);
                        $stmt->execute([$cat_id]);

                        $Row = $stmt->fetch(PDO::FETCH_ASSOC);

                        if ($Row) {
                            $cat_title = $Row["name"];
                            ?>
                            <div class="form-group">
                                <label for="cat_title">Edit Category</label>
                                <input type="text" value="<?php echo $cat_title; ?>" class="form-control" name="cat_title" id="">
                            </div>
                            <div class="form-group">
                                <input class="btn btn-primary" type="submit" name="update_category" value="Edit Category">
                            </div>
                        <?php };
                    }
                    ?>
                </form>
            </div>
            <div class="col-xs-6">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $query = "SELECT * FROM categories";
                        $stmt = $db->prepare($query);
                        $stmt->execute();

                        while ($Row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $cat_id = htmlspecialchars($Row['id']);
                            $cat_title = htmlspecialchars($Row['name']);
                            echo "<tr>
                                    <td>{$cat_id}</td>
                                    <td>{$cat_title}</td>
                                    <td>
                                        <a href='categories.php?delete={$cat_id}' onclick=\"return confirm('Are you sure you want to delete this category?');\">Delete</a>
                                         | <a href='categories.php?edit={$cat_id}'>Edit</a>
                                    </td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- <?php include "includes/footer.php" ?> -->