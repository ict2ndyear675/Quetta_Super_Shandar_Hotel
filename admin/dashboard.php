<?php

session_start();

// Check if admin is logged in
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}

$admin_username = $_SESSION["admin_username"];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Quetta Super Shandar Hotel</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #f5f5f5;
        }

        /* =========================
           SIDEBAR
        ========================= */

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background: #b5121b;
            color: white;
            padding-top: 25px;
            z-index: 1000;
        }

        .hotel-logo {
            text-align: center;
            padding: 0 15px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .hotel-logo i {
            font-size: 38px;
            color: #f5c400;
        }

        .hotel-logo h2 {
            font-family: 'Playfair Display', serif;
            font-size: 20px;
            margin-top: 8px;
        }

        .hotel-logo p {
            font-size: 11px;
            margin: 0;
            opacity: 0.85;
        }

        .sidebar-menu {
            list-style: none;
            padding: 20px 12px;
        }

        .sidebar-menu li {
            margin-bottom: 7px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: 0.3s;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #f5c400;
            color: #222;
        }

        .sidebar-menu i {
            font-size: 18px;
        }

        /* =========================
           MAIN CONTENT
        ========================= */

        .main-content {
            margin-left: 250px;
            min-height: 100vh;
        }

        /* =========================
           TOP BAR
        ========================= */

        .topbar {
            height: 75px;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
            border-bottom: 1px solid #e5e5e5;
        }

        .topbar h1 {
            font-family: 'Playfair Display', serif;
            font-size: 25px;
            color: #222;
            margin: 0;
        }

        .admin-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-icon {
            width: 40px;
            height: 40px;
            background: #b5121b;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .admin-name {
            font-size: 13px;
            font-weight: 600;
        }

        .admin-role {
            font-size: 11px;
            color: #888;
        }

        /* =========================
           CONTENT
        ========================= */

        .content {
            padding: 30px;
        }

        .welcome-box {
            background: #b5121b;
            color: white;
            padding: 25px 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-left: 6px solid #f5c400;
        }

        .welcome-box h2 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 5px;
        }

        .welcome-box p {
            margin: 0;
            font-size: 13px;
            opacity: 0.9;
        }

        /* =========================
           STAT CARDS
        ========================= */

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 22px;
            border: 1px solid #eeeeee;
            height: 100%;
            transition: 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: #fff5c7;
            color: #b5121b;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            margin-bottom: 15px;
        }

        .stat-card h3 {
            font-size: 25px;
            margin-bottom: 3px;
        }

        .stat-card p {
            color: #777;
            font-size: 13px;
            margin: 0;
        }

        /* =========================
           QUICK ACTIONS
        ========================= */

        .section-title {
            font-family: 'Playfair Display', serif;
            margin: 35px 0 20px;
            font-size: 23px;
        }

        .action-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            border: 1px solid #eeeeee;
            text-decoration: none;
            color: #222;
            display: block;
            transition: 0.3s;
        }

        .action-card:hover {
            border-color: #b5121b;
            transform: translateY(-3px);
            color: #b5121b;
        }

        .action-card i {
            font-size: 30px;
            color: #b5121b;
            margin-bottom: 12px;
        }

        .action-card h5 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .action-card p {
            color: #777;
            font-size: 12px;
            margin: 0;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 768px) {

            .sidebar {
                width: 70px;
            }

            .hotel-logo h2,
            .hotel-logo p,
            .sidebar-menu span {
                display: none;
            }

            .hotel-logo i {
                font-size: 30px;
            }

            .sidebar-menu a {
                justify-content: center;
                padding: 13px;
            }

            .sidebar-menu i {
                margin: 0;
            }

            .main-content {
                margin-left: 70px;
            }

            .topbar {
                padding: 0 15px;
            }

            .content {
                padding: 20px 15px;
            }

            .admin-name,
            .admin-role {
                display: none;
            }

        }

    </style>

</head>

<body>

    <!-- =========================
         SIDEBAR
    ========================= -->

    <aside class="sidebar">

        <div class="hotel-logo">

            <i class="bi bi-building"></i>

            <h2>Quetta Super Shandar</h2>

            <p>Hotel Management System</p>

        </div>


        <ul class="sidebar-menu">

            <li>

                <a href="dashboard.php" class="active">

                    <i class="bi bi-speedometer2"></i>

                    <span>Dashboard</span>

                </a>

            </li>


            <li>

                <a href="menu/index.php">

                    <i class="bi bi-egg-fried"></i>

                    <span>Menu Items</span>

                </a>

            </li>


            <li>

                <a href="gallery/index.php">

                    <i class="bi bi-images"></i>

                    <span>Gallery</span>

                </a>

            </li>


            <li>

                <a href="../index.php" target="_blank">

                    <i class="bi bi-globe"></i>

                    <span>View Website</span>

                </a>

            </li>


            <li>

                <a href="logout.php">

                    <i class="bi bi-box-arrow-right"></i>

                    <span>Logout</span>

                </a>

            </li>

        </ul>

    </aside>


    <!-- =========================
         MAIN CONTENT
    ========================= -->

    <main class="main-content">


        <!-- TOPBAR -->

        <div class="topbar">

            <h1>Dashboard</h1>

            <div class="admin-info">

                <div>

                    <div class="admin-name">

                        <?php echo htmlspecialchars($admin_username); ?>

                    </div>

                    <div class="admin-role">
                        Administrator
                    </div>

                </div>

                <div class="admin-icon">

                    <i class="bi bi-person"></i>

                </div>

            </div>

        </div>


        <!-- CONTENT -->

        <div class="content">


            <!-- WELCOME -->

            <div class="welcome-box">

                <h2>
                    Welcome, <?php echo htmlspecialchars($admin_username); ?>!
                </h2>

                <p>
                    Manage your Quetta Super Shandar Hotel website from this dashboard.
                </p>

            </div>


            <!-- STAT CARDS -->

            <div class="row g-4">


                <div class="col-md-4">

                    <div class="stat-card">

                        <div class="stat-icon">

                            <i class="bi bi-egg-fried"></i>

                        </div>

                        <h3>0</h3>

                        <p>Menu Items</p>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="stat-card">

                        <div class="stat-icon">

                            <i class="bi bi-images"></i>

                        </div>

                        <h3>0</h3>

                        <p>Gallery Images</p>

                    </div>

                </div>


                <div class="col-md-4">

                    <div class="stat-card">

                        <div class="stat-icon">

                            <i class="bi bi-person-check"></i>

                        </div>

                        <h3>1</h3>

                        <p>Admin Account</p>

                    </div>

                </div>


            </div>


            <!-- QUICK ACTIONS -->

            <h3 class="section-title">
                Quick Actions
            </h3>


            <div class="row g-4">


                <div class="col-md-6">

                    <a href="menu/index.php" class="action-card">

                        <i class="bi bi-plus-circle"></i>

                        <h5>Manage Menu</h5>

                        <p>
                            Add, edit and delete hotel menu items.
                        </p>

                    </a>

                </div>


                <div class="col-md-6">

                    <a href="gallery/index.php" class="action-card">

                        <i class="bi bi-image"></i>

                        <h5>Manage Gallery</h5>

                        <p>
                            Add, edit and delete hotel gallery images.
                        </p>

                    </a>

                </div>


            </div>


        </div>

    </main>


</body>

</html>