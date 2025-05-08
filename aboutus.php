<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>About Us - Velvet Bloom</title>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            background-color: #fff8f4;
            scroll-behavior: smooth;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .logo {
            color: #a0522d;
            font-size: 24px;
            font-weight: bold;
        }

        .logo-button {
            color: #a0522d;
            font-size: 24px;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .logo-button:hover {
            color: #7b3f1d;
            background-color: #fff1ec;
            border-radius: 50px;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #3e2c28;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #fce9e0;
            color: #5a3e36;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* About Us Section */
        .about-section {
            background-color: #fff1ec;
            padding: 80px 20px;
            text-align: center;
        }

        .about-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            color: #3e2c28;
        }

        .about-text h2 {
            font-size: 32px;
            color: #a0522d;
            margin-bottom: 20px;
        }

        .about-text p {
            font-size: 18px;
            line-height: 1.8;
            margin-bottom: 20px;
            color: #7b3f1d;
        }

        .about-text ul {
            text-align: left;
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .about-text ul li {
            margin-bottom: 10px;
            font-size: 18px;
        }

        /* Footer Section */
        .footer {
            background-color: #a0522d;
            padding: 10px 20px;
            color: white;
            text-align: center;
        }

        .footer a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="index.php" class="logo-button">Velvet Bloom</a>
        <ul class="nav-links">
            <li><a href="client_auth.php">Sign up</a></li>
            <li><a href="shop.php">Shop</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <!-- About Us Section -->
    <section class="about-section" id="about">
        <div class="about-container">
            <h2>Who We Are</h2>
            <div class="about-text">
                <p>We’re Hafsa Abbassi and Aya Aoussar — two students, best friends, and now, creators of a bold idea: to make fashion for every woman feel like it was made just for her.</p>

                <p>Like many girls, we’ve struggled to find clothes that truly fit. Whether it's pants that don’t hug in the right places or tops that just don’t fall the way they should — we’ve felt that frustration. So we asked ourselves: what if fashion actually listened?</p>

                <p>That’s why we created Velvet Bloom — a place where every woman can find elegant, everyday pieces and feel heard. Yes, we sell dresses, jeans, tops, and bags — but what makes us different is this:</p>
                
                <ul>
                    <li>💬 When you contact us, we listen.</li>
                    <li>✂️ You tell us your size, your shape — and we tailor our pieces to you.</li>
                    <li>👖 You want a baggy jean that actually fits you perfectly? We’ll make it happen.</li>
                </ul>

                <p>Because we believe fashion shouldn’t be “one-size-fits-all.” It should be one-size-fits-YOU.</p>

                <p>We’re not a big company (yet 😉), but we care deeply. Every order you make supports our dream — and gives you something you won’t find in big brands: clothes made with real attention, for real women, by two girls who get it.</p>

                <p>Let’s change fashion — one beautiful fit at a time.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <div class="footer">
        <p>&copy; 2025 Velvet Bloom | <a href="index.php">Back to Home</a></p>
    </div>

</body>

</html>
