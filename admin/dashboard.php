<?php
include "includes/header.php";
include "includes/navigation.php";
?>

<div id="page-wrapper">
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Welcome to Dashboard
                    <?php echo $_SESSION['username'] ?>
                </h1>
            </div>

        </div>


        <div class="row">
            <!-- Chart -->
            <div class="col-lg-5 col-md-6">
                <div id="myChart" style="max-width:700px; height:400px"></div>
            </div>
            <!-- Widgets Cards -->
            <div class="col-lg-7 col-md-6">
                <div class="col-lg-12" style="padding-top: 50px;">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-file-text fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query = "SELECT * FROM products";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();

                                        $product_count = $stmt->rowCount();
                                        ?>
                                        <div class='huge'><?php echo $product_count; ?></div>
                                        <div>Products</div>
                                    </div>
                                </div>
                            </div>
                            <a href="products.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-user fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query = "SELECT * FROM users";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();

                                        $user_count = $stmt->rowCount();
                                        ?>
                                        <div class='huge'><?php echo $user_count; ?></div>
                                        <div>Users</div>
                                    </div>
                                </div>
                            </div>
                            <a href="users.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php
                                        $query = "SELECT * FROM categories";
                                        $stmt = $db->prepare($query);
                                        $stmt->execute();

                                        $categories_count = $stmt->rowCount();
                                        ?>
                                        <div class='huge'><?php echo $categories_count; ?></div>
                                        <div>Categories</div>
                                    </div>
                                </div>
                            </div>
                            <a href="categories.php">
                                <div class="panel-footer">
                                    <span class="pull-left">View Details</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        // Count user with role=user
        $query = "SELECT COUNT(*) FROM users WHERE role = ?";
        $stmt = $db->prepare($query);
        $stmt->execute(['user']);
        $users_count = $stmt->fetchColumn();

        // Count admins
        $stmt->execute(['admin']);
        $admins_count = $stmt->fetchColumn();
        ?>
        <script>
            google.charts.load('current', {
                'packages': ['corechart']
            });
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['Contry', 'Mhl'],
                    ['Products', <?php echo $product_count ?>],
                    ['Users', <?php echo $user_count ?>],
                    ['Users_admins', <?php echo $admins_count ?>],
                    ['Users_users', <?php echo $users_count ?>],
                    ['Categories', <?php echo $categories_count ?>],
                ]);

                var options = {
                    title: 'Summary'
                };

                var chart = new google.visualization.PieChart(document.getElementById('myChart'));
                chart.draw(data, options);
            }
        </script>

    </div>
</div>

<?php include "includes/footer.php" ?> 