<?php
include "includes/header.php";
include "includes/navigation.php";

if (isset($_POST['update_profile'], $_SESSION['username'])) {
    $the_user_name = $_SESSION['username'];

    // $user_firstname = $_POST['firstname'];
    // $user_lastname = $_POST['lastname'];
    $user_role = $_POST['role'];
    $user_username = $_POST['username'];
    $user_password = $_POST['password'];
    $user_email = $_POST['email'];

    $query = "UPDATE users SET  
                password = :user_password, 
                email = :user_email,
                role = :user_role 
              WHERE username = :the_user_name";

    $stmt = $db->prepare($query);

    // Bind parameters
    $stmt->bindParam(':user_role', $user_role, PDO::PARAM_STR);
    $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    $stmt->bindParam(':the_user_name', $the_user_name, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Check if any row was updated
    if ($stmt->rowCount() > 0) {
        echo "<p class='alert alert-success'>User updated successfully.</p>";
    } else {
        echo "No changes were made.";
    }
}

?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Hello
                    <?php echo $_SESSION['username'] ?>
                </h1>
            </div>
            <div class="col-xs-12">
                <?php
                if (isset($_SESSION['username'])) {
                    $the_user_name = $_SESSION['username'];

                    try {
                        // Fetch user data using PDO
                        $query = "SELECT * FROM users WHERE username = :username";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(':username', $the_user_name, PDO::PARAM_STR);
                        $stmt->execute();

                        if ($Row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            $user_id = $Row['id'];
                            $username = $Row['username'];
                            $password = $Row['password'];
                            $email = $Row['email'];
                            $role = $Row['role'];
                            ?>

                <form action="" method="post">
                    <!-- <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" class="form-control" name="firstname" value="<?php echo htmlspecialchars($firstname); ?>">
                            </div>

                            <div class="form-group">
                                <label for="lastname">Lastname</label>
                                <input type="text" class="form-control" name="lastname" value="<?php echo htmlspecialchars($lastname); ?>">
                            </div> -->

                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-control" name="role" id="user_role">
                            <option value="<?php echo htmlspecialchars($role); ?>">
                                <?php echo htmlspecialchars($role); ?></option>
                            <?php
                                        if ($role == 'admin') {
                                            echo "<option value='user'>User</option>";
                                        } else {
                                            echo "<option value='admin'>Admin</option>";
                                        }
                                        ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" value="<?php echo htmlspecialchars($username); ?>"
                            disabled>
                        <input type="hidden" name="username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password"
                            value="<?php echo htmlspecialchars($password); ?>">
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email"
                            value="<?php echo htmlspecialchars($email); ?>">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="update_profile" value="Update Profile">
                    </div>
                </form>

                <?php
                        } else {
                            echo "<p>User not found.</p>";
                        }
                    } catch (PDOException $ex) {
                        echo "<p>Error: " . $ex->getMessage() . "</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>