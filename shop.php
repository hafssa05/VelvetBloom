<?php
session_start();
$conn = new mysqli("localhost", "root", "", "VelvetBloom_db");
$clientLoggedIn = isset($_SESSION['client']);

$products = $conn->query("SELECT * FROM materiel");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Shop - Velvet Bloom</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fff8f4;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ffffff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .logo {
      font-weight: bold;
      font-size: 24px;
      color: #a0522d;
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
      transition: 0.3s ease;
    }

    .nav-links a:hover {
      background-color: #fce9e0;
    }

    .shop-container {
      padding: 50px 20px;
      text-align: center;
    }

    .products {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      justify-content: center;
    }

    .product-card {
      background: #fff;
      border-radius: 15px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
      width: 260px;
    }

    .product-card img {
      width: 100%;
      height: 240px;
      object-fit: cover;
      border-radius: 10px;
    }

    .product-card h3 {
      color: #a0522d;
      margin: 10px 0 5px;
    }

    .product-card p {
      font-size: 14px;
      color: #3e2c28;
    }

    .product-card span {
      font-weight: bold;
      display: block;
      margin: 8px 0;
      color: #5a3e36;
    }

    .product-card form {
      margin-top: 10px;
    }

    .product-card button {
      background-color: #a0522d;
      border: none;
      color: white;
      padding: 10px 20px;
      border-radius: 25px;
      cursor: pointer;
    }

    .product-card button:hover {
      background-color: #7b3f1d;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar">
  <div class="logo"><a href="index.php">Velvet Bloom</a></div>
  <ul class="nav-links">
    <li><a href="shop.php">Shop</a></li>
    <?php if ($clientLoggedIn): ?>
      <li><a href="settings.php">Settings</a></li>
      <li><a href="cart.php">Cart</a></li>
      <li><a href="orders.php">Order History</a></li>
      <li><a href="logout.php">Logout</a></li>
    <?php else: ?>
      <li><a href="client_auth.php">Signup</a></li>
    <?php endif; ?>
  </ul>
</nav>

<!-- Shop -->
<div class="shop-container">
  <h2>Explore Our Full Collection</h2>
  <div class="products">
    <?php while ($row = $products->fetch_assoc()): ?>
      <div class="product-card">
        <img src="<?= $row['image'] ?>" alt="<?= $row['produit'] ?>">
        <h3><?= $row['produit'] ?></h3>
        <p><?= $row['caracteristique'] ?></p>
        <span><?= $row['prix'] ?> DH</span>
        <form method="POST" action="<?= $clientLoggedIn ? 'add_to_cart.php' : 'client_auth.php' ?>">
          <input type="hidden" name="id_materiel" value="<?= $row['id_materiel'] ?>">
          <button type="submit"><?= $clientLoggedIn ? 'Add to Cart' : 'Buy Now' ?></button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>

</body>
</html>
