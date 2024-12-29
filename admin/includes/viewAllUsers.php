<?php
include '../includes/db.php' ;

// Delete User
if (isset($_GET["delete"])) {
    if (isset($_SESSION['role']) && $_SESSION['role'] === "admin") {
        try {
            $user_id = (int)$_GET['delete']; 
            $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->execute([$user_id]);
            
            header("Location: users.php");
        } catch (PDOException $ex) {
            die("Query Failed: " . $ex->getMessage());
        }
    }
}

// Change user to Admin.
if (isset($_GET["change_to_admin"])) {
    $user_id = $_GET["change_to_admin"];
    $user_role = 'admin';
    try {
        $query = "UPDATE users SET role = :user_role WHERE id = :user_id";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':user_role', $user_role, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
  
        $stmt->execute();
        header("Location: users.php");
        exit;
    } catch (PDOException $ex) {
        die("Query Failed: " . $ex->getMessage());
    }
}

// Change user to User.
if (isset($_GET["change_to_user"])) {
    $user_id = $_GET["change_to_user"];
    try {
        $query = "UPDATE users SET role = :user_role WHERE id = :user_id";
        $stmt = $db->prepare($query);

        $user_role = 'user';
        $stmt->bindParam(':user_role', $user_role, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);

        $stmt->execute();

        header("Location: users.php");
        exit;
    } catch (PDOException $ex) {
        die("Query Failed: " . $ex->getMessage());
    }
}

?>

<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM users";
        $stmt = $db->prepare($query);
        $stmt->execute();

        while ($Row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $user_id = htmlspecialchars($Row['id']);
            $user_name = htmlspecialchars($Row['username']);
            $user_email = htmlspecialchars($Row['email']);
            $user_role = htmlspecialchars($Row['role']);
            $user_date = htmlspecialchars($Row['created_at']);

            echo "<tr>
                    <td>$user_id</td>
                    <td>$user_name</td>
                    <td>$user_email</td>
                    <td>$user_role</td>
                    <td>$user_date</td>
                    <td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>
                    <td><a href='users.php?change_to_user=$user_id'>User</a></td>
                    <td><a href='users.php?source=edit_user&user_id=$user_id'>Edit</a></td>
                    <td><a onClick=\"javascript: return confirm('Are you sure you want to delete?');\" href='users.php?delete=$user_id'>Delete</a></td>
                </tr>";
            }
        ?>
    </tbody>
</table>