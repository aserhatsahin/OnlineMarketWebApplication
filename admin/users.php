<?php
include_once "includes/header.php";
include_once "includes/navigation.php";

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
                    case 'add_user':
                        include "includes/add_user.php";
                        break;
                    case 'edit_user':
                        include "includes/edit_user.php";
                        break;
                    default:
                        include "includes/viewAllUsers.php";
                        break;
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- <?php //include "includes/footer.php" ?> -->