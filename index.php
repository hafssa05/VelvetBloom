<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <title>Velvet Bloom</title>
  <style>
    body, html {
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
  color: #7b3f1d; /* or any color you prefer on hover */
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

    .initial-image {
      background-image: url('img/pic1.jpeg');
      background-attachment: fixed;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
     
    .left-text {
      position: absolute;
      top: 50%;
      left: 50px;
      transform: translateY(-50%);
      color: #3e2c28;
      text-align: left;
      max-width: 300px;
       /* Animation for left-text */
      opacity: 0;                                      
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .left-text h1 {
      font-size: 48px;
      margin-bottom: 20px;
      white-space: nowrap; /* This prevents line breaks */
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .left-text p {
      font-size: 24px;
      margin-bottom: 30px;
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    

    .cta-button {
      background-color: #a0522d;
      color: white;
      border: none;
      padding: 15px 30px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
      border-radius: 30px;
      transition: opacity 0.8s ease, transform 0.8s ease;
    }

    .cta-button:hover {
      background-color: #7b3f1d;
    }

    /* Fancy Text Section */
    .fancy-section {
      padding: 100px 20px;
      text-align: center;
      background-color: #fff1ec;
      opacity: 0;
      transform: translateY(50px);
      transition: opacity 1.2s ease, transform 1.2s ease;
      filter: brightness(0.95) blur(1px);
      position: relative;
      overflow: hidden;
    }

    .fancy-section.show {
      opacity: 1;
      transform: translateY(0);
      filter: brightness(1);
      animation: bounceGlow 1.5s ease forwards;
    }

    .fancy-section h2 {
      font-size: 28px;
      color: #5a3e36;
      margin-bottom: 20px;
      text-shadow: 0 0 5px #ffd6d6, 0 0 10px #ffc4c4;
      position: relative;
      z-index: 1;
    }
    
    .fancy-section p {
      font-size: 18px;
      color: #7b3f1d;
      max-width: 700px;
      margin: auto;
      line-height: 1.6;
      text-shadow: 0 0 3px #ffd6d6;
      position: relative;
      z-index: 1;
    }

    @keyframes bounceGlow {
      0% { transform: translateY(50px); filter: brightness(0.95) blur(1px); }
      50% { transform: translateY(-10px); filter: brightness(1.05) blur(0); }
      70% { transform: translateY(5px); filter: brightness(1); }
      100% { transform: translateY(0); filter: brightness(1); }
    }

    
       @keyframes slideBounce {
     0% {
    opacity: 0;
    transform: translateX(-60px);
  }
  60% {
    opacity: 1;
    transform: translateX(10px);
  }
  80% {
    transform: translateX(-5px);
  }
  100% {
    transform: translateX(0);
  }
}

.left-text h1,
.left-text p,
.left-text .cta-button {
  opacity: 0;
}

.left-text.animate h1 {
  animation: slideBounce 0.6s ease-out forwards;
}

.left-text.animate p {
  animation: slideBounce 0.6s ease-out 0.2s forwards;
}

.left-text.animate .cta-button {
  animation: slideBounce 0.6s ease-out 0.4s forwards;
} 
.left-text.animate h1,
.left-text.animate p,
.left-text.animate .cta-button {
  opacity: 1;
}
.left-text.animate {
  opacity: 1;
}
 
.shop-section {
  background-color: #fff1ec;
  padding: 60px 20px;
  text-align: center;
}

@keyframes underlineGlow {
  0% {
    background-position: 0% 50%;
  }
  100% {
    background-position: 100% 50%;
  }
}

.shop-title {
  position: relative;
  font-size: 36px;
  color: #5a3e36;
  margin-bottom: 60px;
  font-family: 'Georgia', serif;
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 0.8s ease, transform 0.8s ease;
}

.shop-title.show {
  opacity: 1;
  transform: translateY(0);
}

.shop-title::after {
  content: "";
  display: block;
  width: 120px;
  height: 4px;
  margin: 10px auto 0;
  background: linear-gradient(270deg, #a0522d, #f7bda9, #a0522d);
  background-size: 600% 600%;
  border-radius: 2px;
  animation: underlineGlow 3s ease-in-out infinite;
}



.shop-scroll {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  gap: 20px;
  justify-content: center;
  scroll-behavior: smooth;
  padding-bottom: 20px;
}

.shop-card {
  background-color: white;
  border-radius: 15px;  /* Slightly rounded corners */
  box-shadow: 0 4px 20px rgba(0,0,0,0.1);
  padding: 20px;
  width: 260px;
  min-width: 260px;
  flex-shrink: 0;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.gps-card {
  border: 2px dashed #a0522d;
  border-radius: 25px;
  background-color: #fff7f2;
  position: relative;
  overflow: hidden;
}

.gps-card:hover {
  background-color: #fff0e8;
  transform: scale(1.03);
}

.gps-badge {
  position: absolute;
  top: 10px;
  left: -20px;
  background-color: #a0522d;
  color: white;
  padding: 5px 20px;
  transform: rotate(-20deg);
  font-size: 12px;
  font-weight: bold;
}


.shop-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 10px 30px rgba(0,0,0,0.15);
}

.shop-card img {
  width: 100%;
  height: 240px; /* let the height adjust automatically */
  object-fit: contain; /* show full image */
  border-radius: 10px; /* Match the card's border radius */
  margin-bottom: 15px;
}

.shop-card h3 {
  font-size: 18px;
  color: #a0522d;
  margin: 10px 0 5px;
}

.shop-card p {
  font-size: 14px;
  color: #3e2c28;
  margin-bottom: 8px;
}

.shop-card span {
  font-weight: bold;
  color: #5a3e36;
  font-size: 16px;
}

.shop-button {
  display: inline-block;
  margin-top: 40px;
  background-color: #a0522d;
  color: white;
  padding: 14px 30px;
  border-radius: 30px;
  text-decoration: none;
  font-size: 16px;
  transition: background-color 0.3s;
}

.shop-button:hover {
  background-color: #7b3f1d;
}

.about-section {
  background-color: #fff1ec; /* soft blush pink */
  padding: 80px 20px;
  display: flex;
  justify-content: center;
  align-items: center;
}

.about-container {
  max-width: 1200px;
  display: flex;
  flex-wrap: wrap;
  gap: 40px;
  align-items: center;
  opacity: 0;
  transform: translateY(50px);
  transition: opacity 1s ease, transform 1s ease;
}

.about-section.show .about-container {
  opacity: 1;
  transform: translateY(0);
}

.about-image {
  flex: 1;
  min-width: 280px;
  text-align: center;
}

.about-image img {
  width: 100%;
  max-width: 400px;
  border-radius: 10px;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
}

.about-text {
  flex: 1;
  min-width: 280px;
  color: #3e2c28;
  font-family: 'Georgia', serif;
}

.about-text h2 {
  font-size: 32px;
  margin-bottom: 20px;
  color: #a0522d;
}

.about-text p {
  font-size: 18px;
  line-height: 1.6;
  margin-bottom: 20px;
}

.about-button {
  background-color: #a0522d;
  color: white;
  border: none;
  padding: 12px 24px;
  font-size: 14px;
  border-radius: 30px;
  cursor: pointer;
  font-family: 'Poppins', sans-serif;
  transition: background-color 0.3s;
}

.about-button:hover {
  background-color: #7b3f1d;
}

/* Responsive */
@media (max-width: 768px) {
  .about-container {
    flex-direction: column;
    text-align: center;
  }

  .about-text {
    font-size: 16px;
  }
}


.contact-section {
  background-color: #fff8f4;
  padding: 100px 20px;
  text-align: center;
  /* i add it by myslef */
  opacity: 0;
  transform: translateY(40px);
  transition: opacity 1s ease, transform 1s ease;
}

.contact-section.show {
  opacity: 1;
  transform: translateY(0);
}




.contact-container {
  max-width: 600px;
  margin: auto;
}

.contact-section h2 {
  font-family: 'Playfair Display', serif;
  font-size: 32px;
  color: #5a3e36;
  margin-bottom: 10px;
}

.contact-section p {
  color: #7b3f1d;
  font-size: 16px;
  margin-bottom: 40px;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.contact-form input,
.contact-form textarea {
  background: none;
  border: none;
  border-bottom: 2px solid #a0522d;
  padding: 12px 10px;
  font-size: 16px;
  color: #3e2c28;
  font-family: 'Poppins', sans-serif;
  outline: none;
  transition: border-color 0.3s;
}

.contact-form input:focus,
.contact-form textarea:focus {
  border-bottom-color: #7b3f1d;
}

.contact-form textarea {
  resize: vertical;
  min-height: 120px;
}

.contact-form button {
  background-color: #a0522d;
  color: white;
  padding: 14px 30px;
  border: none;
  border-radius: 30px;
  font-size: 16px;
  font-family: 'Poppins', sans-serif;
  cursor: pointer;
  transition: background-color 0.3s;
}

.contact-form button:hover {
  background-color: #7b3f1d;
}


.admin-link {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #a0522d;
  color: white;
  padding: 12px 20px;
  border-radius: 30px;
  text-decoration: none;
  font-family: 'Poppins', sans-serif;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.15);
  transition: background-color 0.3s;
}
.admin-link:hover {
  background-color: #7b3f1d;
}


  </style>
</head>

<body>

 
  <!-- Navbar -->
<nav class="navbar">
  <a href="inddex.php" class="logo-button">Velvet Bloom</a>
  <ul class="nav-links">
    <li><a href="client_auth.php">Sign up</a></li>
    <li><a href="shop.php">Shop</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
</nav>


  <!-- Fixed Image Section -->
  <div id="home" class="initial-image">
    <div class="left-text">
      <h1>Stylish looks await</h1>
      <p>Discover your next outfit</p>
      <button class="cta-button">View products</button>
    </div>
  </div>

  

  <!-- SHOP SECTION -->
<div id="shop" class="shop-section">
  <h2 class="shop-title">Our Collection</h2>
  
  <?php
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$result = $conn->query("SELECT * FROM materiel ORDER BY id_materiel DESC LIMIT 4");
?>

<div class="shop-scroll">
  <?php while ($row = $result->fetch_assoc()): ?>
    <div class="shop-card">
      <img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['produit']) ?>">
      <h3><?= htmlspecialchars($row['produit']) ?></h3>
      <p><?= htmlspecialchars($row['caracteristique']) ?></p>
      <span><?= htmlspecialchars($row['prix']) ?> DH</span>
    </div>
  <?php endwhile; ?>
</div>

<?php $conn->close(); ?>

<a href="shop.php" class="shop-button">View Full Collection</a>

</div>

</div>


<!-- ABOUT US SECTION -->
<section id="about" class="about-section">
  <div class="about-container">
    <div class="about-image">
      <img src="img/this is the one.jpg" alt="Velvet Bloom">
    </div>
    <div class="about-text">
      <h2>Who We Are</h2>
      <p>We’re Hafsa & Aya — two girls who turned a dream into Velvet Bloom, a fashion space for every woman to feel seen, styled, and celebrated.

Tired of clothes that never fit right, we imagined something better: elegant pieces, made with love, and a special touch — tailored just for you.

Because at Velvet Bloom, we believe fashion isn’t one-size-fits-all. It’s one-size-fits-you.</p>
      <button class="about-button">✨ Read Our Story</button>
    </div>
  </div>
</section>

  <!-- CONTACT SECTION -->
<section id="contact" class="contact-section">
  <div class="contact-container">
    <h4 style="color:#f5deb3;"> Get in touch</h4>
    <h2>We'd love to hear from you!</h2>
    <p>Questions, compliments, or just a hello — we’d love to hear from you.</p>
    <form class="contact-form">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" placeholder="Your Message" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
  <!-- Google Maps Embed - Maarif -->
<div style="margin-top: 50px;">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3329.837056014897!2d-7.634304124559381!3d33.582368542285675!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda7cddf4b315845%3A0x6fa9fc6931124930!2sMa%C3%A2rif%2C%20Casablanca!5e0!3m2!1sen!2sma!4v1714665457347!5m2!1sen!2sma" 
    width="100%" 
    height="300" 
    style="border:0; border-radius: 15px;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>



<!-- Social Media Icons -->
<div style="margin-top: 30px; display: flex; justify-content: center; gap: 30px;">
<span style="color: #a0522d; font-size: 24px; cursor: pointer;">
  <i class="fa-brands fa-instagram"></i>
</span>

  <span style=" color: #25D366; font-size: 24px; cursor: pointer;">
    <i class="fa-brands fa-whatsapp"></i>
</span>
  <span style=" color: #a0522d; font-size: 24px; cursor: pointer;">
    <i class="fa-solid fa-envelope"></i>
</span>
</div>

</section>


  <script>
  window.addEventListener('scroll', function () {
  const home = document.getElementById('home');
  const leftText = document.querySelector('.left-text');
  const homeRect = home.getBoundingClientRect();
  const homeVisible = homeRect.top < window.innerHeight && homeRect.bottom > 0;

  if (homeVisible) {
    leftText.classList.add('animate');
  } else {
    leftText.classList.remove('animate');
  }

  const fancy = document.querySelector('.fancy-section');
  if (fancy) {
  const fancyTop = fancy.getBoundingClientRect().top;
  if (fancyTop < window.innerHeight - 100) {
    fancy.classList.add('show');
    }
             }
  

  const shopTitle = document.querySelector('.shop-title');
  const shopTop = shopTitle.getBoundingClientRect().top;
  if (shopTop < window.innerHeight - 100) {
    shopTitle.classList.add('show');
  }

  const about = document.querySelector('.about-section');
if (about) {
  const aboutTop = about.getBoundingClientRect().top;
  if (aboutTop < window.innerHeight - 100) {
    about.classList.add('show');
  }
}

const contact = document.querySelector('.contact-section');
if (contact) {
  const contactTop = contact.getBoundingClientRect().top;
  if (contactTop < window.innerHeight - 100) {
    contact.classList.add('show');
  }
}


});

</script>



</body>
</html> 