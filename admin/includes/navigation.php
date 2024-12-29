<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <a class="navbar-brand" href="./dashboard.php">ADMIN</a>
    </div>

    <!-- Top Menu Items -->
    <ul class="nav navbar-right top-nav">
        <li><a href="../index.php">Home Page</a></li>
        
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['username'] ?> <b class="caret"></b></a>
            <ul class="dropdown-menu">
                <li>
                    <a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a>
                </li>
                <li>
                    <a href="#"><i class="fa fa-fw fa-gear"></i> Settings</a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="../logout.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                </li>
            </ul>
        </li>
    </ul>

    <!-- Sidebar Menu Items -->
    <div class="collapse navbar-collapse navbar-ex1-collapse">
        <ul class="nav navbar-nav side-nav">
            <li class="active">
                <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Dashboard</a>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#posts-dropdown">
                    <i class="fa fa-fw fa-arrows-v"></i> Products <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="posts-dropdown" class="collapse">
                    <li>
                        <a href="products.php?source=add_product">Add Product</a>
                    </li>
                    <li>
                        <a href="products.php">View Products</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="categories.php">
                    <i class="fa fa-fw fa-wrench"></i> Categories
                </a>
            </li>

            <li>
                <a href="javascript:;" data-toggle="collapse" data-target="#users-dropdown">
                    <i class="fa fa-fw fa-arrows-v"></i> Users <i class="fa fa-fw fa-caret-down"></i>
                </a>
                <ul id="users-dropdown" class="collapse">
                    <li>
                        <a href="users.php?source=add_user">Add User</a>
                    </li>
                    <li>
                        <a href="users.php">View Users</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- /.navbar-collapse -->
</nav>