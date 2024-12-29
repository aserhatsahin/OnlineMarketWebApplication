<?php
if (isset($_POST['add_user'])) {
    // $user_firstname = $_POST['firstname'];
    // $user_lastname = $_POST['lastname'];
    $user_role = $_POST['role'];
    $user_name = $_POST['username'];
    $user_password = $_POST['password'];
    $user_email = $_POST['email'];

    // Add new user.
    $query = "INSERT INTO users (role, username, password, email) 
              VALUES (:user_role, :user_name, :user_password, :user_email)";
              
    $stmt = $db->prepare($query);

    $stmt->bindParam(':user_role', $user_role, PDO::PARAM_STR);
    $stmt->bindParam(':user_name', $user_name, PDO::PARAM_STR);
    $stmt->bindParam(':user_password', $user_password, PDO::PARAM_STR);
    $stmt->bindParam(':user_email', $user_email, PDO::PARAM_STR);

    $stmt->execute();

    // Success message
    echo "User Created " . "<a href='users.php'>View Users</a>";
}
?>

<form action="" method="post">

    <!-- <div class="form-group">
        <label for="firstname">Firstname</label>
        <input type="text" class="form-control" name="firstname">
    </div>

    <div class="form-group">
        <label for="lastname">Lastname</label>
        <input type="text" class="form-control" name="lastname">
    </div> -->


    <div class="form-group">
        <label for="role">Role</label>
        <select class="form-control" name="role" id="product_category">
            <option value='user'>Select Options</option>
            <option value='admin'>Admin</option>
            <option value='user'>User</option>
        </select>
    </div>

    <div class="form-group">
        <label for="username">Username</label>
        <input type="text" class="form-control" name="username">
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password">
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email">
    </div>


    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="add_user" value="Add User">
    </div>
</form>