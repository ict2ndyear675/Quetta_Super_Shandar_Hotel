<?php

/*
=====================================================
QUETTA SUPER SHANDAR HOTEL
COMMON WEBSITE HEADER
=====================================================
*/

// Detect current page
$currentPage = basename($_SERVER['PHP_SELF']);

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <!-- =========================================
         BASIC PAGE INFORMATION
    ========================================== -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Quetta Super Shandar Hotel - Traditional taste, quality food and warm hospitality in Rawalpindi."
    >

    <meta
        name="keywords"
        content="Quetta Super Shandar Hotel, Rawalpindi, restaurant, Quetta food, Pakistani food"
    >

    <meta
        name="author"
        content="Quetta Super Shandar Hotel"
    >


    <!-- =========================================
         PAGE TITLE
    ========================================== -->

    <title>
        Quetta Super Shandar Hotel | Rawalpindi
    </title>


    <!-- =========================================
         GOOGLE FONTS
    ========================================== -->

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- =========================================
         BOOTSTRAP CSS
    ========================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =========================================
         BOOTSTRAP ICONS
    ========================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- =========================================
         OUR EXTERNAL CSS
    ========================================== -->

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>


<!-- =====================================================
     TOP INFORMATION BAR
====================================================== -->

<div class="top-bar">

    <div class="container">

        <div class="top-bar-content">


            <!-- Welcome -->

            <div class="top-item">

                <i class="bi bi-star-fill"></i>

                <span>
                    Welcome to Quetta Super Shandar Hotel
                </span>

            </div>


            <!-- Location -->

            <div class="top-item">

                <i class="bi bi-geo-alt-fill"></i>

                <span>
                    Shamsabad, Rawalpindi, Pakistan
                </span>

            </div>


            <!-- Opening Hours -->

            <div class="top-item">

                <i class="bi bi-clock-fill"></i>

                <span>
                    Opening Hours: Please confirm with hotel
                </span>

            </div>


            <!-- Contact -->

            <div class="top-item">

                <i class="bi bi-telephone-fill"></i>

                <span>
                    Contact Us
                </span>

            </div>

        </div>

    </div>

</div>


<!-- =====================================================
     MAIN NAVIGATION
====================================================== -->

<nav class="navbar navbar-expand-lg main-navbar">

    <div class="container">


        <!-- =========================================
             HOTEL LOGO
        ========================================== -->

        <a
            class="navbar-brand hotel-logo"
            href="index.php"
        >

            <div class="logo-icon">

                <i class="bi bi-shop"></i>

            </div>


            <div class="logo-text">

                <span class="logo-main">
                    QUETTA
                </span>

                <span class="logo-sub">
                    SUPER SHANDAR HOTEL
                </span>

                <small>
                    Tradition of Taste & Hospitality
                </small>

            </div>

        </a>


        <!-- =========================================
             MOBILE MENU BUTTON
        ========================================== -->

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNavigation"
            aria-controls="mainNavigation"
            aria-expanded="false"
            aria-label="Toggle navigation"
        >

            <span class="navbar-toggler-icon"></span>

        </button>


        <!-- =========================================
             NAVIGATION LINKS
        ========================================== -->

        <div
            class="collapse navbar-collapse"
            id="mainNavigation"
        >

            <ul class="navbar-nav ms-auto align-items-lg-center">


                <!-- HOME -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php echo ($currentPage == 'index.php') ? 'active' : ''; ?>"
                        href="index.php"
                    >
                        Home
                    </a>

                </li>


                <!-- ABOUT -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php echo ($currentPage == 'about.php') ? 'active' : ''; ?>"
                        href="about.php"
                    >
                        About Us
                    </a>

                </li>


                <!-- MENU -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php echo ($currentPage == 'services.php') ? 'active' : ''; ?>"
                        href="services.php"
                    >
                        Menu
                    </a>

                </li>


                <!-- GALLERY -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php echo ($currentPage == 'gallery.php') ? 'active' : ''; ?>"
                        href="gallery.php"
                    >
                        Gallery
                    </a>

                </li>


                <!-- CONTACT -->

                <li class="nav-item">

                    <a
                        class="nav-link <?php echo ($currentPage == 'contact.php') ? 'active' : ''; ?>"
                        href="contact.php"
                    >
                        Contact Us
                    </a>

                </li>


                <!-- RESERVATION -->

                <li class="nav-item ms-lg-3 mt-3 mt-lg-0">

                    <a
                        href="contact.php"
                        class="btn btn-yellow reservation-btn"
                    >

                        <i class="bi bi-calendar-check me-2"></i>

                        Reservation

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>