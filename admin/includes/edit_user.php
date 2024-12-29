<?php

if (isset($_POST['update_user'], $_GET['user_id'])) {
    $the_user_id = $_GET['user_id'];

    $user_role = $_POST['role'];
    $user_username = $_POST['username'];
    $user_password = $_POST['password'];
    $user_email = $_POST['email'];

    try {
        $query = "UPDATE users SET 
                    role = :user_role,
                    username = :user_username,
                    password = :user_password,
                    email = :user_email
                  WHERE id = :user_id";

        $stmt = $db->prepare($query);

        $stmt->bindParam(':user_role', $user_role, PDO::PARAM_STR);
        $stmt->bindParam(':user_username', $user_username, PDO::PARAM_STR);
        $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);
        $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $the_user_id, PDO::PARAM_INT);

        $stmt->execute();

        echo "<p class='alert alert-success'>User updated successfully.</p>";
    } catch (PDOException $ex) {
        die("Query Failed: " . $ex->getMessage());
    }
}
?>


<?php
if (isset($_GET['user_id'])) {
    $the_user_id = $_GET['user_id'];

    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$the_user_id]);

    $Row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($Row) {
        $user_id = $Row['id'];
        $username = $Row['username'];
        $password = $Row['password'];
        $email = $Row['email'];
        $role = $Row['role'];
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" name="role" id="user_role">
                    <option value='<?php echo $role ?>'><?php echo $role ?></option>
                    <?php
                            if ($role == 'admin') {
                                echo "<option value='Admin'>Admin</option>";
                            } else {
                                echo "<option value='User'>User</option>";
                            }

                            ?>
                </select>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" value='<?php echo $username; ?>'>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" value='<?php echo $password; ?>'>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" value='<?php echo $email; ?>'>
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="update_user" value="Update User">
            </div>
        </form>
<?php }
}
?>