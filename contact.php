<?php include 'includes/header.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">



    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>



<!-- ================= CONTACT HERO ================= -->

<section class="contact-hero">

    <div class="hero-circle hero-circle-one"></div>
    <div class="hero-circle hero-circle-two"></div>

    <div class="contact-hero-content">

        <span>CONTACT US</span>

        <h1>Get In Touch</h1>

        <div class="gold-line"></div>

        <p>
            We are always happy to hear from our guests.
            Contact us for reservations, inquiries and more.
        </p>

    </div>

</section>


<!-- ================= INTRO ================= -->

<section class="contact-intro">

    <div class="section-label">
        QUETTA SUPER SHANDAR HOTEL
    </div>

    <h2>We Would Love To Hear From You</h2>

    <div class="section-line"></div>

    <p>
        Whether you are planning your stay, making a reservation,
        or simply have a question, our team is here to help.
        Feel free to get in touch with us.
    </p>

</section>


<!-- ================= CONTACT AREA ================= -->

<section class="contact-area">

    <div class="contact-wrapper">


        <!-- CONTACT INFORMATION -->

        <div class="contact-details">

            <span class="contact-label">
                01 • CONTACT INFORMATION
            </span>

            <h2>
                Let's Start A<br>
                Conversation
            </h2>

            <div class="red-line"></div>

            <p class="contact-description">
                Reach out to Quetta Super Shandar Hotel.
                Our friendly team is ready to assist you
                with your questions and reservations.
            </p>


            <!-- LOCATION -->

            <div class="contact-detail-item">

                <div class="detail-icon">
                    📍
                </div>

                <div>

                    <h3>Our Location</h3>

                    <p>
                        Shamsabad, Rawalpindi,<br>
                        Pakistan
                    </p>

                </div>

            </div>


            <!-- PHONE -->

            <div class="contact-detail-item">

                <div class="detail-icon">
                    ☎
                </div>

                <div>

                    <h3>Phone Number</h3>

                    <p>
                        +92 XXX XXXXXXX
                    </p>

                </div>

            </div>


            <!-- EMAIL -->

            <div class="contact-detail-item">

                <div class="detail-icon">
                    ✉
                </div>

                <div>

                    <h3>Email Address</h3>

                    <p>
                        info@supershandarhotel.com
                    </p>

                </div>

            </div>


            <!-- HOURS -->

            <div class="contact-detail-item">

                <div class="detail-icon">
                    ◷
                </div>

                <div>

                    <h3>Opening Hours</h3>

                    <p>
                        Monday – Sunday<br>
                        24 Hours
                    </p>

                </div>

            </div>

        </div>


        <!-- CONTACT FORM -->

        <div class="contact-form-box">

            <div class="form-heading">

                <span>02 • SEND US A MESSAGE</span>

                <h2>How Can We Help?</h2>

                <div class="red-line"></div>

                <p>
                    Fill in the form below and we will
                    get back to you as soon as possible.
                </p>

            </div>


            <form action="#" method="POST">


                <div class="form-row">

                    <div class="form-group">

                        <label for="name">
                            Your Name
                        </label>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            placeholder="Enter your name"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label for="email">
                            Email Address
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="Enter your email"
                            required
                        >

                    </div>

                </div>


                <div class="form-row">

                    <div class="form-group">

                        <label for="phone">
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            placeholder="Enter phone number"
                        >

                    </div>


                    <div class="form-group">

                        <label for="subject">
                            Subject
                        </label>

                        <input
                            type="text"
                            id="subject"
                            name="subject"
                            placeholder="Enter subject"
                            required
                        >

                    </div>

                </div>


                <div class="form-group">

                    <label for="message">
                        Your Message
                    </label>

                    <textarea
                        id="message"
                        name="message"
                        placeholder="Write your message here..."
                        rows="6"
                        required
                    ></textarea>

                </div>


                <button type="submit" class="send-message-btn">

                    SEND MESSAGE

                    <span>→</span>

                </button>

            </form>

        </div>

    </div>

</section>


<!-- ================= MAP ================= -->

<section class="location-section">

    <div class="location-heading">

        <span>03 • FIND US</span>

        <h2>Our Location</h2>

        <div class="section-line"></div>

        <p>
            Come visit us and experience the warm hospitality
            of Quetta Super Shandar Hotel.
        </p>

    </div>


    <div class="map-box">

        <iframe
            src="https://www.google.com/maps?q=Shamsabad,Rawalpindi,Pakistan&output=embed"
            loading="lazy"
            allowfullscreen>
        </iframe>

    </div>

</section>




</body>
</html>
<?php include 'includes/footer.php'; ?>