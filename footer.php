<head>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap");

        :root {
            --primary-color: #f13033;
            --primary-color-dark: #c3282b;
            --secondary-color: #f9f9f9;
            --text-dark: #0f172a;
            --text-light: #64748b;
            --white: #ffffff;
            --max-width: 1200px;
        }

        footer {
            background-color: #304352;
            width: 100%;
            margin-top: 0;
            position:relative;
            bottom:0;
            z-index: 1;
            display:flex;
            flex-direction:column;
            justify-content:center;
            align-items: center;
        }

        .footer__container {
            max-width: 1300px;
            width: 95%;
            height:260px;
            margin:auto;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content:center;
        }

        .footer__col {
            width: 250px;
            text-align: center;
            display:flex;
            flex-direction:column;
            height: 300px;
            margin: 20px;
        }

        .footer__col h5, .footer__col h5 {
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--text-dark);
        }

        .footer__col p, .footer__col a {
            color: var(--text-light);
            max-width: 300px;
            margin-bottom:10px;
            font-size: 1rem;
            font-weight: 500;
            transition: 0.3s;
        }

        .footer__col a:hover {
            color: var(--primary-color);
        }

        .footer__socials {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 10px;
            flex-wrap: wrap;
        }

        .footer__socials span a {
            padding: 5px 10px;
            margin: 0;
            font-size: 1.25rem;
            color: var(--white);
            background-color: var(--primary-color);
            border-radius: 100%;
        }

        .footer__socials span a:hover {
            color: var(--secondary-color);
            background-color: var(--primary-color-dark);
        }

        .footer__bar {
            padding: 1rem;
            font-size: 0.8rem;
            color: var(--white);
            text-align: center;
        }
        @media screen and (max-width:1250px){
            
        .footer__socials{
            display: none;
        }
        .footer__col h4{
            display: none;
        }
            
        }
    </style>
</head>
<body>
 
    <footer>
        <div class="footer__container">
            <div class="footer__col">
                <h5>Travel&Trails</h5>
                <p>Welcome to Travel&Trails, our tour and travel website is your gateway to a world of wanderlust-inducing experiences.</p>
            </div>
            <div class="footer__col">
                <h5>Quick Links</h5>
                <a href="main.php">Home</a>
                <a href="#destination">Destinations</a>
                <a href="#contactus">Contact Us</a>
                <a href="privacypolicy.php">Privacy Policy</a>
            </div>
            <div class="footer__col">
                <h5>Features</h5>
                <a href="packages.php">Vacation Package</a>
                <a href="gallery.php">Gallery</a>
                <a href="aboutus.php">Aboutus</a>
                <a href="booking.php">Hotels</a>
            </div>
            <div class="footer__col">
                <h4>Follow Us</h4>
                <div class="footer__socials">
                    <span>
                        <a href="https://www.facebook.com/profile.php?id=100025533319534"><i class="fa-brands fa-facebook"></i></a>
                    </span>
                    <span><a href="https://www.instagram.com/rohitshresthaaa/?hl=en"><i class="fa-brands fa-instagram"></i></a></span>
                    <span><a href="https://www.linkedin.com/in/rohit-shrestha-52061925b/"><i class="fa-brands fa-linkedin"></i></a></span>
                    <span><a href="https://twitter.com/RohitStha07"><i class="fa-brands fa-twitter"></i></a></span>
                </div>
            </div>
        </div>
        <div class="footer__bar">
            Copyright © 2023 Trails&Travels. All rights reserved.
        </div>
    </footer>

</body>
</html>
