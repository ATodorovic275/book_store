<div class="wrapper">

    <div class="page-wrapper">
        <!-- Header -->
        <header class="main-header " id="header">
            <nav class="navbar navbar-static-top navbar-expand-lg">
                <!-- Sidebar toggle button -->
                <button id="sidebar-toggler" class="sidebar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                </button>
                <div class="navbar-right ">
                    <ul class="nav navbar-nav">
                        <!-- User Account -->
                        <li class="dropdown user-menu">
                            <button href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <span class="d-none d-lg-inline-block">User: <?= $_SESSION['user']->username ?></span>
                            </button>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>