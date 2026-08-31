
<?php

require_once "config/db.php";

include 'includes/header.php';


/*
|--------------------------------------------------------------------------
| GET ACTIVE MENU ITEMS
|--------------------------------------------------------------------------
*/
$sql = "SELECT * FROM menu_items WHERE status = 1 ORDER BY category, id DESC";


$result = mysqli_query($conn, $sql);

$menu_items = [];

if ($result) {

    while ($row = mysqli_fetch_assoc($result)) {

        $menu_items[] = $row;

    }

}

?>
<!DOCTYPE html>
<html lang="en"> 
<head>

    <!-- =====================================================
         BASIC PAGE INFORMATION`
         
    ====================================================== -->

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Menu of Quetta Super Shandar Hotel - Traditional Quetta-style food, fresh parathas, chai and Pakistani dishes."
    >

    <meta
        name="keywords"
        content="Quetta Super Shandar Hotel, menu, chai, paratha, Pakistani food, Rawalpindi"
    >

    <meta
        name="author"
        content="Quetta Super Shandar Hotel"
    >

    <title>
        Menu | Quetta Super Shandar Hotel
    </title>


    <!-- =====================================================
         GOOGLE FONTS
    ====================================================== -->

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet"
    >


    <!-- =====================================================
         BOOTSTRAP
    ====================================================== -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <!-- =====================================================
         BOOTSTRAP ICONS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    <!-- =====================================================
         MAIN WEBSITE CSS
    ====================================================== -->

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>


<body>



<!-- =====================================================
     MENU HERO
====================================================== -->

<section class="menu-hero">

    <div class="menu-hero-overlay"></div>


    <div class="container">

        <div class="menu-hero-content text-center">


            <span class="menu-hero-label">
                OUR SPECIAL MENU
            </span>


            <h1>
                Taste of Quetta
            </h1>


            <div class="menu-hero-line"></div>


            <p>
                Traditional Pakistani food, fresh parathas,
                delicious chai and authentic hotel dishes.
            </p>


        </div>

    </div>

</section>



<!-- =====================================================
     MENU INTRODUCTION
====================================================== -->

<section class="menu-intro">

    <div class="container text-center">


        <span class="section-label">
            QUETTA SUPER SHANDAR HOTEL
        </span>


        <h2 class="section-title">
            Our Food Menu
        </h2>


        <div class="gold-line"></div>


        <p class="section-description mx-auto">

            Enjoy fresh, traditional and flavorful food prepared
            with care for our valued guests. From a hot cup of
            Quetta-style chai to delicious parathas and traditional
            Pakistani dishes, we serve food for every time of day.

        </p>

    </div>

</section>



<!-- =====================================================
     MENU CATEGORY NAVIGATION
====================================================== -->

<section class="menu-navigation">

    <div class="container">

        <div class="menu-tabs">


            <a
                href="#chai"
                class="menu-tab active"
            >

                <i class="bi bi-cup-hot-fill"></i>

                <span>
                    Chai & Coffee
                </span>

            </a>



            <a
                href="#paratha"
                class="menu-tab"
            >

                <i class="bi bi-circle-fill"></i>

                <span>
                    Paratha
                </span>

            </a>



            <a
                href="#anda"
                class="menu-tab"
            >

                <i class="bi bi-egg-fried"></i>

                <span>
                    Anda
                </span>

            </a>



            <a
                href="#salan"
                class="menu-tab"
            >

                <i class="bi bi-bowl-hot-fill"></i>

                <span>
                    Salan
                </span>

            </a>


        </div>

    </div>

</section>



<!-- =====================================================
     1. CHAI & COFFEE
====================================================== -->

<section
    class="food-section"
    id="chai"
>

    <div class="container">


        <!-- CATEGORY TITLE -->

        <div class="category-heading">

            <span>
                HOT & FRESH
            </span>

            <h2>
                Chai & Coffee
            </h2>

            <p>
                Traditional hot drinks prepared fresh for you.
            </p>

        </div>



        <div class="row g-4">

<?php foreach ($menu_items as $item): ?>

    <?php
    if (
        $item['category'] !== 'Chai & Kahwa' &&
        $item['category'] !== 'Chai & Coffee'
    ) {
        continue;
    }

    $image = !empty($item['image'])
    ? $item['image']
    : 'images/no-image.jpg';

$image = str_replace('../', '', $image);
    ?>

    <div class="col-lg-4 col-md-6">

        <div class="food-card">

            <div class="food-image">

                <img
                    src="<?php echo htmlspecialchars($image); ?>"
                    alt="<?php echo htmlspecialchars($item['name']); ?>"
                >

            </div>

            <div class="food-content">

                <div class="food-title-price">

                    <h3>
                        <?php echo htmlspecialchars($item['name']); ?>
                    </h3>

                    <span class="price">
                        Rs. <?php echo number_format($item['price'], 0); ?>
                    </span>

                </div>

                <p>
                    <?php echo htmlspecialchars($item['description']); ?>
                </p>

            </div>

        </div>

    </div>

<?php endforeach; ?>
</div>

    

<!-- =====================================================
     2. PARATHA
====================================================== -->

<section
    class="food-section food-section-light"
    id="paratha"
>

    <div class="container">


        <div class="category-heading">

            <span>
                FRESH FROM THE TAWA
            </span>

            <h2>
                Paratha
            </h2>

            <p>
                Freshly prepared traditional and stuffed parathas.
            </p>

        </div>



        <div class="row g-4">


            <!-- SADA PARATHA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/sada-parata.webp"
                            alt="Sada Paratha"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Sada Paratha
                            </h3>

                            <span class="price">
                                Rs. 120
                            </span>

                        </div>


                        <p>
                            Fresh, flaky and crispy traditional
                            paratha served hot from the tawa.
                        </p>

                    </div>

                </div>

            </div>



            <!-- KHUSHK PARATHA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/khushk-parata.webp"
                            alt="Khushk Paratha"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Khushk Paratha
                            </h3>

                            <span class="price">
                                Rs. 120
                            </span>

                        </div>


                        <p>
                            Light and crispy layered paratha
                            prepared fresh for breakfast.
                        </p>

                    </div>

                </div>

            </div>



            <!-- LACHHA PARATHA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/lacha-parata.webp"
                            alt="Lachha Paratha"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Lachha Paratha
                            </h3>

                            <span class="price">
                                Rs. 130
                            </span>

                        </div>


                        <p>
                            Crispy, layered and golden paratha
                            with a delicious flaky texture.
                        </p>

                    </div>

                </div>

            </div>



            <!-- ALOO PARATHA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/alo-parata.webp"
                            alt="Aloo Paratha"
                        >

                        <span class="popular-badge">
                            Popular
                        </span>

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Aloo Paratha
                            </h3>

                            <span class="price">
                                Rs. 210
                            </span>

                        </div>


                        <p>
                            Soft and crispy paratha filled with
                            flavorful spiced potatoes.
                        </p>

                    </div>

                </div>

            </div>



            <!-- ALOO CHEESE PARATHA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/aloo-cheeze-parata.webp"
                            alt="Aloo Cheese Paratha"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Aloo Cheese Paratha
                            </h3>

                            <span class="price">
                                Rs. 310
                            </span>

                        </div>


                        <p>
                            Stuffed potato and melted cheese
                            combined inside a freshly cooked paratha.
                        </p>

                    </div>

                </div>

            </div>



            <!-- PIZZA PARATHA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/pizza-prata.jpg"
                            alt="Pizza Paratha"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Pizza Paratha
                            </h3>

                            <span class="price">
                                Rs. 170
                            </span>

                        </div>


                        <p>
                            A tasty stuffed paratha combining
                            traditional flavors with a pizza-style filling.
                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     3. ANDA & BREAKFAST
====================================================== -->

<section
    class="food-section"
    id="anda"
>

    <div class="container">


        <div class="category-heading">

            <span>
                FRESH BREAKFAST
            </span>

            <h2>
                Anda & Breakfast
            </h2>

            <p>
                Simple, fresh and filling breakfast favorites.
            </p>

        </div>



        <div class="row g-4">


            <!-- ANDA OMELETTE -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/anda-omelette.webp"
                            alt="Anda Omelette"
                        >

                        <span class="popular-badge">
                            Popular
                        </span>

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Anda Omelette
                            </h3>

                            <span class="price">
                                Rs. 150
                            </span>

                        </div>


                        <p>
                            Fresh eggs cooked with spices and
                            vegetables for a tasty breakfast.
                        </p>

                    </div>

                </div>

            </div>



            <!-- FULL FRIED ANDA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/full-fried-anda.webp"
                            alt="Full Fried Anda"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Full Fried Anda
                            </h3>

                            <span class="price">
                                Rs. 140
                            </span>

                        </div>


                        <p>
                            Fresh fried eggs prepared hot and
                            served as a simple traditional breakfast.
                        </p>

                    </div>

                </div>

            </div>



            <!-- SALAD -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/salad.webp"
                            alt="Fresh Salad"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Fresh Salad
                            </h3>

                            <span class="price">
                                Rs. 160
                            </span>

                        </div>


                        <p>
                            Fresh seasonal vegetables prepared
                            as a light and refreshing side.
                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     4. SALAN & MAIN DISHES
====================================================== -->

<section
    class="food-section food-section-light"
    id="salan"
>

    <div class="container">


        <div class="category-heading">

            <span>
                TRADITIONAL PAKISTANI FOOD
            </span>

            <h2>
                Salan & Main Dishes
            </h2>

            <p>
                Traditional Pakistani dishes prepared with
                authentic spices and fresh ingredients.
            </p>

        </div>



        <div class="row g-4">


            <!-- CHANA PLATE -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/chana-plate.jpg"
                            alt="Chana Plate"
                        >

                        <span class="popular-badge">
                            Popular
                        </span>

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Chana Plate
                            </h3>

                            <span class="price">
                                Rs. 210
                            </span>

                        </div>


                        <p>
                            Flavorful chickpeas cooked with
                            traditional spices and fresh herbs.
                        </p>

                    </div>

                </div>

            </div>



            <!-- ALOO QEEMA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/alo-kima.jpg"
                            alt="Aloo Qeema"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Aloo Qeema
                            </h3>

                            <span class="price">
                                Rs. 520
                            </span>

                        </div>


                        <p>
                            Spiced minced meat cooked with potatoes
                            and aromatic traditional spices.
                        </p>

                    </div>

                </div>

            </div>



            <!-- CHICKEN QORMA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/chicken-qourma.jpg"
                            alt="Chicken Qorma"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Chicken Qorma
                            </h3>

                            <span class="price">
                                Rs. 560
                            </span>

                        </div>


                        <p>
                            Tender chicken cooked in a rich,
                            creamy and aromatic traditional gravy.
                        </p>

                    </div>

                </div>

            </div>



            <!-- DAAL MASH -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/dall-mash.jpg"
                            alt="Daal Mash"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Daal Mash
                            </h3>

                            <span class="price">
                                Rs. 450
                            </span>

                        </div>


                        <p>
                            Traditional black gram lentils cooked
                            with aromatic spices and herbs.
                        </p>

                    </div>

                </div>

            </div>



            <!-- LAL LOBIA -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/lal-lobia.jpg"
                            alt="Lal Lobia"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Lal Lobia
                            </h3>

                            <span class="price">
                                Rs. 400
                            </span>

                        </div>


                        <p>
                            Slow-cooked red beans prepared with
                            traditional spices and flavorful gravy.
                        </p>

                    </div>

                </div>

            </div>



            <!-- KARACHI BIRYANI -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/karachi-biryani.jpg"
                            alt="Karachi Biryani"
                        >

                        <span class="popular-badge">
                            Special
                        </span>

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Karachi Biryani
                            </h3>

                            <span class="price">
                                Rs. 520
                            </span>

                        </div>


                        <p>
                            Fragrant Pakistani rice cooked with
                            aromatic spices and traditional flavors.
                        </p>

                    </div>

                </div>

            </div>



            <!-- CHANAY -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/chanay.jpg"
                            alt="Chanay"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Chanay
                            </h3>

                            <span class="price">
                                Rs. 400
                            </span>

                        </div>


                        <p>
                            Spiced chickpeas prepared with onions,
                            herbs and traditional seasonings.
                        </p>

                    </div>

                </div>

            </div>



            <!-- SAJJI -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card featured-food">

                    <div class="food-image">

                        <img
                            src="images/sajji-platter.jpg"
                            alt="Quetta Sajji Platter"
                        >

                        <span class="popular-badge">
                            Hotel Special
                        </span>

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Quetta Sajji Platter
                            </h3>

                            <span class="price">
                                Rs. 1,250
                            </span>

                        </div>


                        <p>
                            A traditional Quetta-style sajji platter
                            prepared for guests who enjoy authentic
                            local flavors.
                        </p>

                    </div>

                </div>

            </div>



            <!-- PATEERI ROTI -->

            <div class="col-lg-4 col-md-6">

                <div class="food-card">

                    <div class="food-image">

                        <img
                            src="images/pateeri-rooti.webp"
                            alt="Pateeri Roti"
                        >

                    </div>


                    <div class="food-content">

                        <div class="food-title-price">

                            <h3>
                                Pateeri Roti
                            </h3>

                            <span class="price">
                                Rs. 30
                            </span>

                        </div>


                        <p>
                            Fresh traditional flatbread served
                            with curries and main dishes.
                        </p>

                    </div>

                </div>

            </div>


        </div>

    </div>

</section>



<!-- =====================================================
     SPECIAL MESSAGE
====================================================== -->

<section class="menu-special">

    <div class="container">

        <div class="special-box text-center">


            <div class="special-icon">

                <i class="bi bi-stars"></i>

            </div>


            <span class="section-label">
                OUR SPECIALITY
            </span>


            <h2>
                Taste the Traditional Quetta Flavor
            </h2>


            <p>
                Fresh food, traditional recipes and the warm
                hospitality of Quetta Super Shandar Hotel.
            </p>


            <a
                href="contact.php"
                class="btn btn-yellow"
            >

                <i class="bi bi-telephone-fill me-2"></i>

                Contact Us

            </a>


        </div>

    </div>

</section>



<!-- =====================================================
     FOOTER
====================================================== -->




<!-- =====================================================
     BOOTSTRAP JAVASCRIPT
====================================================== -->

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js">
</script>


<!-- =====================================================
     MENU TAB ACTIVE EFFECT
====================================================== -->

<script>

    const menuTabs = document.querySelectorAll(".menu-tab");

    menuTabs.forEach(function(tab) {

        tab.addEventListener("click", function() {

            menuTabs.forEach(function(item) {

                item.classList.remove("active");

            });

            this.classList.add("active");

        });

    });

</script>


</body>

</html>

<?php include 'includes/footer.php'; ?> 