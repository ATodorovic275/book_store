<body>
    <!--::header part start::-->
    <header class="main_menu home_menu">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-12">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="navbar-brand" href="index.php"> Bookstore</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="menu_icon"><i class="fas fa-bars"></i></span>
                        </button>

                        <div class="collapse navbar-collapse main-menu-item" id="navbarSupportedContent">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="index.php?page=products">Products</a>
                                </li>


                                <?php
                                if (!isset($_SESSION['user'])) :
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?page=login">Login</a>
                                    </li>
                                <?php else : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?page=logout">Logout</a>
                                    </li>
                                <?php endif; ?>
                                <?php
                                if (isset($_SESSION['user']) && $_SESSION['user']->id_role == 2) :
                                ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php?page=admin">Admin</a>
                                    </li>
                                <?php endif; ?>

                            </ul>
                        </div>
                        <?php if (isset($_SESSION['user'])) : ?>
                            <div class="hearer_icon d-flex">
                                <div class="dropdown cart">
                                    <a href="index.php?page=shoping_cart">
                                        <i class="fas fa-cart-plus"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>

    </header>
    <!-- Header part end-->